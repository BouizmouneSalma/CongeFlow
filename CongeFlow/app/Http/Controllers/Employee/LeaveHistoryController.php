<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DemandeConge;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;

class LeaveHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = DemandeConge::with(['conge.type'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Filtrage par type
        if ($request->filled('type')) {
            $query->whereHas('conge', function($q) use ($request) {
                $q->where('type_id', $request->type);
            });
        }

        // Filtrage par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtrage par année
        if ($request->filled('annee')) {
            $query->whereYear('created_at', $request->annee);
        }

        $demandes = $query->paginate(10);
        $types = Type::all();

        return view('employee.historique', compact('demandes', 'types'));
    }
} 