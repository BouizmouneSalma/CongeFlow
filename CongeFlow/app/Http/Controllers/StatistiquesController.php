<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DemandeConge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistiquesController extends Controller
{
    public function index()
    {
        // Nombre total de salariés (role salarie)
        $totalSalaries = User::where('role', 'salarie')->count();
        
        // Nombre de responsables RH
        $totalRH = User::where('role', 'rh')->count();
        
        // Nombre total d'utilisateurs
        $totalUsers = User::count();
        
        // Nombre d'administrateurs
        $totalAdmins = User::where('role', 'admin')->count();
        
        // Nombre de demandes de congé
        $totalDemandes = DemandeConge::count();
        
        // Formater les données pour le graphique par mois
        $moisLabels = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
            7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];
        
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $demandesParMois[$i] ?? 0;
        }
        
        return view('admin.statistiques', compact(
            'totalSalaries', 
            'totalRH', 
            'totalUsers', 
            'totalAdmins', 
            'totalDemandes', 
            'moisLabels',
            'chartData'
        ));
    }
} 