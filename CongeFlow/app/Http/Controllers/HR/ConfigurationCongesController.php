<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfigurationCongesController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return view('hr.configuration_conges', compact('types'));
    }

    public function show(Type $type)
    {
        return response()->json(['type' => $type]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255|unique:types',
            'description' => 'required|string',
            'duree' => 'required|string',
            'paiement' => 'required|numeric|min:0|max:100',
            'couleur' => 'required|string|max:7'
        ]);

        $type = Type::create([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'duree' => $request->duree,
            'paiement' => $request->paiement,
            'couleur' => $request->couleur,
            'actif' => true
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Type de congé créé avec succès',
                'type' => $type
            ]);
        }

        return redirect()->route('hr.configuration_conges')
            ->with('success', 'Type de congé créé avec succès');
    }

    public function update(Request $request, Type $type)
    {
        $request->validate([
            'libelle' => 'required|string|max:255|unique:types,libelle,' . $type->id,
            'description' => 'required|string',
            'duree' => 'required|string',
            'paiement' => 'required|numeric|min:0|max:100',
            'couleur' => 'required|string|max:7'
        ]);

        $type->update([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'duree' => $request->duree,
            'paiement' => $request->paiement,
            'couleur' => $request->couleur
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Type de congé modifié avec succès',
                'type' => $type
            ]);
        }

        return redirect()->route('hr.configuration_conges')
            ->with('success', 'Type de congé modifié avec succès');
    }

    public function destroy(Type $type)
    {
        try {
            DB::beginTransaction();
            
            // Vérifier si l'utilisateur est RH
            if (!auth()->user()->role === 'rh') {
                throw new \Exception('Vous n\'êtes pas autorisé à effectuer cette action.');
            }

            // Vérifier si le type a des congés associés avec des demandes
            if ($type->conges()->whereHas('demandes')->exists()) {
                throw new \Exception('Ce type de congé ne peut pas être supprimé car il est utilisé dans des demandes');
            }

            // Supprimer d'abord les congés associés qui n'ont pas de demandes
            $type->conges()->whereDoesntHave('demandes')->delete();
            
            // Puis supprimer le type
            $type->delete();
            
            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Type de congé supprimé avec succès'
                ]);
            }

            return redirect()->route('hr.configuration_conges')
                ->with('success', 'Type de congé supprimé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression du type de congé: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->with('error', $e->getMessage());
        }
    }
} 