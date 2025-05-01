<?php

namespace App\Http\Controllers;

use App\Models\DemandeConge;
use App\Models\Type;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CongeStatusChanged;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CongeController extends Controller
{

    use AuthorizesRequests;
    /**
     * Affiche la page principale de gestion des congés
     */
    public function index()
    {
        $user = Auth::user();
        $types = Type::all();
        
        // Si c'est un RH, montrer toutes les demandes
        // Si c'est un admin, montrer les demandes uniquement pour la récupération des stats
        // Si c'est un salarié, montrer uniquement ses demandes
        if ($user->role === 'rh') {
            $demandes = DemandeConge::with(['user', 'type'])->latest()->get();
        } else if ($user->role === 'admin') {
            // Pour les admins, accès limité aux demandes (seulement pour stats)
            $demandes = DemandeConge::with(['user', 'type'])
                ->select(['id', 'user_id', 'type_id', 'dateDebut', 'dateFin', 'statut', 'created_at'])
                ->latest()
                ->get();
        } else {
            $demandes = DemandeConge::with(['type'])->where('user_id', $user->id)->latest()->get();
        }
        
        return view('conges.index', compact('demandes', 'types', 'user'));
    }
    
    /**
     * Récupère les demandes au format JSON (pour Ajax)
     */
    public function getDemandes()
    {
        $user = Auth::user();
        
        if ($user->role === 'rh') {
            $demandes = DemandeConge::with(['user', 'type'])->latest()->get();
        } else if ($user->role === 'admin') {
            // Pour les admins, accès limité aux demandes (seulement pour stats)
            $demandes = DemandeConge::with(['user', 'type'])
                ->select(['id', 'user_id', 'type_id', 'dateDebut', 'dateFin', 'statut', 'created_at'])
                ->latest()
                ->get();
        } else {
            $demandes = DemandeConge::with(['type'])->where('user_id', $user->id)->latest()->get();
        }
        
        return response()->json(['demandes' => $demandes]);
    }
    
    /**
     * Enregistre une nouvelle demande de congé
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|exists:types,id',
            'dateDebut' => 'required|date|after_or_equal:today',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
            'motif' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        // Créer la demande
        $demande = new DemandeConge();
        $demande->user_id = Auth::id();
        $demande->type_id = $request->type_id;
        $demande->dateDebut = $request->dateDebut;
        $demande->dateFin = $request->dateFin;
        $demande->motif = $request->motif;
        $demande->statut = 'en_attente';
        $demande->save();
        
        // Si la requête est en AJAX, retourner la demande créée
        if ($request->ajax()) {
            $demande->load(['user', 'type']);
            return response()->json(['demande' => $demande, 'message' => 'Demande de congé créée avec succès'], 201);
        }
        
        return redirect()->route('conges.index')->with('success', 'Demande de congé créée avec succès');
    }
    
    /**
     * Affiche les détails d'une demande de congé
     */
    public function show(DemandeConge $demande)
    {
        // Vérifier si l'utilisateur a le droit de voir cette demande
        $this->authorize('view', $demande);
        
        if (request()->ajax()) {
            $demande->load(['user', 'type']);
            return response()->json(['demande' => $demande]);
        }
        
        return view('conges.show', compact('demande'));
    }
    
    /**
     * Met à jour une demande de congé
     */
    public function update(Request $request, DemandeConge $demande)
    {
        // Vérifier si l'utilisateur a le droit de modifier cette demande
        $this->authorize('update', $demande);
        
        $validator = Validator::make($request->all(), [
            'type_id' => 'sometimes|required|exists:types,id',
            'dateDebut' => 'sometimes|required|date',
            'dateFin' => 'sometimes|required|date|after_or_equal:dateDebut',
            'motif' => 'nullable|string|max:255',
            'statut' => 'sometimes|required|in:en_attente,approuvee,refusee,annulee',
            'commentaire' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        // Si c'est un RH qui change le statut
        if (Auth::user()->role === 'rh' && $request->has('statut')) {
            $demande->statut = $request->statut;
            $demande->commentaire = $request->commentaire;
            $demande->dateDebut = $request->dateDebut;
            $demande->dateFin = $request->dateFin;

        } 

        // Si c'est le propriétaire qui modifie la demande
        else if (Auth::id() === $demande->user_id && $demande->statut === 'en_attente') {
            if ($request->has('type_id')) $demande->type_id = $request->type_id;
            if ($request->has('dateDebut')) $demande->dateDebut = $request->dateDebut;
            if ($request->has('dateFin')) $demande->dateFin = $request->dateFin;
        }
        
        $demande->save();
        
        if ($request->ajax()) {
            $demande->load(['user', 'type']);
            return response()->json(['demande' => $demande, 'message' => 'Demande mise à jour avec succès']);
        }
        
        return redirect()->route('conges.index')->with('success', 'Demande mise à jour avec succès');
    }
    
    /**
     * Affiche la page de gestion des congés pour les RH
     */
    public function gestionConges()
    {
        // Vérifier que l'utilisateur est RH uniquement
        $user = Auth::user();
        if ($user->role !== 'rh') {
            abort(403, 'Accès non autorisé');
        }
        
        // Récupérer les types de congés
        $types = Type::all();
        
        // Récupérer les services (départements) uniques
        $services = Service::orderBy('nom')->get();
        
        // Récupérer les demandes en attente
        $demandesEnAttente = DemandeConge::with(['user', 'type'])
            ->where('statut', 'en_attente')
            ->latest()
            ->get();
            
        // Récupérer les demandes traitées récemment
        $demandesTraitees = DemandeConge::with(['user', 'type'])
            ->whereIn('statut', ['approuvee', 'refusee'])
            ->latest()
            ->take(10)
            ->get();
            
        // Récupérer tous les statuts possibles pour le filtre
        $statuts = [
            'en_attente' => 'En attente',
            'approuvee' => 'Approuvée',
            'refusee' => 'Refusée',
            'annulee' => 'Annulée'
        ];
            
        return view('hr.gestion_conges', compact('demandesEnAttente', 'demandesTraitees', 'types', 'services', 'statuts'));
    }
    
    /**
     * Annule une demande de congé (pour l'employé)
     */
    public function cancel(Request $request, DemandeConge $demande)
    {
        // Vérifier si l'utilisateur est bien le propriétaire de la demande
        if (Auth::id() !== $demande->user_id) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }
        
        // Vérifier si la demande peut être annulée
        if ($demande->statut !== 'en_attente') {
            return response()->json(['error' => 'Seules les demandes en attente peuvent être annulées'], 400);
        }
        
        $demande->statut = 'annulee';
        $demande->save();
        
        if ($request->ajax()) {
            return response()->json(['message' => 'Demande annulée avec succès']);
        }
        
        return redirect()->route('conges.index')->with('success', 'Demande annulée avec succès');
    }
    
  
    public function destroy(Request $request, DemandeConge $demande)
    {
        $this->authorize('delete', $demande);
        
        $demande->delete();
        
        if ($request->ajax()) {
            return response()->json(['message' => 'Demande supprimée avec succès']);
        }
        
        return redirect()->route('conges.index')->with('success', 'Demande supprimée avec succès');
    }

    public function filter(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'type_id' => 'nullable|exists:type_conges,id',
            'statut' => 'nullable|in:en_attente,approuvee,refusee,annulee',
            'search' => 'nullable|string|max:255',
        ]);

        $userId = auth()->id();
        $user = auth()->user();
        $isRH = $user->hasRole('rh');
        $query = DemandeConge::with(['user.service', 'type'])
            ->when($isRH, function ($query) {
                // RH sees all requests
                return $query;
            })
            ->when(!$isRH, function ($query) use ($userId) {

                return $query->where('user_id', $userId);
            });

            $query->when($request->filled('service_id'), function ($query) use ($request) {
            return $query->whereHas('user.service', function ($q) use ($request) {
                $q->where('id', $request->service_id);
            });
        })
        ->when($request->filled('type_id'), function ($query) use ($request) {
            return $query->where('type_id', $request->type_id);
        })
        ->when($request->filled('statut'), function ($query) use ($request) {
            return $query->where('statut', $request->statut);
        })
        ->when($request->filled('search'), function ($query) use ($request) {
            $search = $request->search;
            return $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        });

        $demandes = $query->latest()->get();

        return response()->json([
            'success' => true,
            'demandes' => $demandes
        ]);
    }

    public function updateStatutDemande(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:approuvee,refusee',
            'commentaire' => 'required_if:statut,refusee',
        ]);
        $demande = DemandeConge::findOrFail($id);
        
        if (!auth()->user()->hasRole('rh')) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à effectuer cette action.');
        }
        
        if ($demande->statut !== 'en_attente') {
            return back()->with('error', 'Cette demande ne peut plus être modifiée.');
        }
        $demande->statut = $request->statut;
        
        if ($request->statut === 'refusee') {
            $demande->commentaire_rejet = $request->commentaire;
            $message = 'La demande de congé a été refusée.';
        } else {
            $message = 'La demande de congé a été approuvée.';
        }
        
        $demande->date_traitement = now();
        $demande->traite_par = auth()->id();
        $demande->save();
        
        return redirect()->route('conges.index')->with('success', $message);
    }
} 