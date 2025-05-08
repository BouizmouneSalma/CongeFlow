<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\DemandeConge;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SoldeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer les demandes de congés de l'année en cours
        $demandesAnnee = DemandeConge::where('user_id', $user->id)
            ->whereYear('dateDebut', Carbon::now()->year)
            ->get();

        // Calculer les congés pris
        $congesPris = $demandesAnnee
            ->where('statut', 'approuvee')
            ->sum('duree');

        // Calculer les congés en attente
        $congesEnAttente = $demandesAnnee
            ->where('statut', 'en_attente')
            ->sum('duree');

        // Récupérer tous les types de congés avec leurs soldes
        $typesConges = Type::all()->map(function ($type) use ($demandesAnnee) {
            $pris = $demandesAnnee
                ->where('type_id', $type->id)
                ->where('statut', 'approuvee')
                ->sum('duree');

            $enAttente = $demandesAnnee
                ->where('type_id', $type->id)
                ->where('statut', 'en_attente')
                ->sum('duree');

            return [
                'id' => $type->id,
                'nom' => $type->libelle,
                'droits' => $type->droits_annuels ?? 0,
                'pris' => $pris,
                'enAttente' => $enAttente,
                'restants' => ($type->droits_annuels ?? 0) - $pris
            ];
        });

        return view('employee.solde_conges', compact('congesPris', 'congesEnAttente', 'typesConges'));
    }
} 