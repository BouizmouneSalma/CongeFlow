<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Http\Requests\SalarieRequest;
use App\Notifications\WelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Mail\SendCredentials;
use Illuminate\Support\Facades\Mail;

class SalarieController extends Controller
{
    /**
     * Afficher la page de gestion des salariés
     */
    public function index()
    {
        $salaries = User::where('role', 'salarie')->paginate(10);
        $services = Service::all();
        
        return view('hr.gestion_salaries', compact('salaries', 'services'));
    }

    /**
     * Afficher le formulaire de création d'un salarié
     */
    public function create()
    {
        $services = Service::all();
        return view('hr.salaries.create', compact('services'));
    }

    /**
     * Enregistrer un nouveau salarié
     */
    public function store(SalarieRequest $request)
    {
        // Préparer les données
        $data = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'salarie',
            'status' => 'actif',
            'service_id' => $request->service_id,
            'dateInscription' => Carbon::now(),
            'poste' => $request->poste,
            'date_embauche' => $request->date_embauche,
        ];
        
        // Gérer l'upload de photo de profil
        if ($request->hasFile('photoProfile') && $request->file('photoProfile')->isValid()) {
            try {
                // Valider le fichier
                $request->validate([
                    'photoProfile' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);
                
                $file = $request->file('photoProfile');
                $fileName = time() . '_' . $file->getClientOriginalName();
                
                // S'assurer que le répertoire existe
                $path = 'profile-photos';
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }
                
                // Stocker le fichier
                $filePath = $file->storeAs($path, $fileName, 'public');
                $data['photoProfile'] = $filePath;
                
                // Pour le débogage
                \Log::info('Photo uploaded: ' . $filePath);
            } catch (\Exception $e) {
                \Log::error('Error uploading photo: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['photoProfile' => 'Erreur lors du téléchargement de la photo: ' . $e->getMessage()]);
            }
        }

        $salarie = User::create($data);

        Mail::to($salarie->email)->send(new SendCredentials($salarie->nom, $salarie->email, $request -> password));

        return redirect()->route('hr.salaries.index')
            ->with('success', 'Salarié ajouté avec succès et email envoyé.');
    }

    public function edit(User $salarie)
    {
        $services = Service::all();
        return view('hr.salaries.edit', compact('salarie', 'services'));
    }

    public function update(Request $request, User $salarie)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $salarie->id,
            'service_id' => 'required|exists:services,id',
            'status' => 'required|in:actif,en congé,inactif',
            'poste' => 'required|string|max:255',
            'date_embauche' => 'nullable|date',
            'photoProfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'service_id' => $request->service_id,
            'status' => $request->status,
            'poste' => $request->poste,
            'date_embauche' => $request->date_embauche,
        ];

        // Upload de pic
        if ($request->hasFile('photoProfile') && $request->file('photoProfile')->isValid()) {
            try {
                // Supprimer l'ancienne photo si elle existe
                if ($salarie->photoProfile) {
                    Storage::disk('public')->delete($salarie->photoProfile);
                }
                
                $file = $request->file('photoProfile');
                $fileName = time() . '_' . $file->getClientOriginalName();
                
                // S'assurer que le répertoire existe
                $path = 'profile-photos';
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }
                
                // Stocker la nouvelle photo
                $filePath = $file->storeAs($path, $fileName, 'public');
                $data['photoProfile'] = $filePath;
                
                // Pour le débogage
                \Log::info('Photo updated: ' . $filePath);
            } catch (\Exception $e) {
                \Log::error('Error updating photo: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['photoProfile' => 'Erreur lors de la mise à jour de la photo: ' . $e->getMessage()]);
            }
        }
        
        // Supprimer la photo si demandé
        if ($request->has('remove_photo') && $request->remove_photo && $salarie->photoProfile) {
            try {
                Storage::disk('public')->delete($salarie->photoProfile);
                $data['photoProfile'] = null;
            } catch (\Exception $e) {
                \Log::error('Error removing photo: ' . $e->getMessage());
            }
        }

        // Mettre à jour le mot de passe uniquement s'il est fourni
        if ($request->filled('password') && $request->filled('password_confirmation')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $salarie->update($data);

        return redirect()->route('hr.salaries.index')
            ->with('success', 'Salarié mis à jour avec succès.');
    }

    /**
     * Supprimer un salarié
     */
    public function destroy(User $salarie)
    {
        if ($salarie->role !== 'salarie') {
            return redirect()->route('hr.salaries.index')
                ->with('error', 'Vous ne pouvez supprimer que des utilisateurs salariés.');
        }

        // Supprimer la photo de profil si elle existe
        if ($salarie->photoProfile) {
            Storage::disk('public')->delete($salarie->photoProfile);
        }

        $salarie->delete();

        return redirect()->route('hr.salaries.index')
            ->with('success', 'Salarié supprimé avec succès.');
    }
} 