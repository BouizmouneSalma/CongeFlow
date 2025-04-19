<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RHController extends Controller
{
    // Afficher le formulaire d'ajout d'un RH
    public function create()
    {
        return view('admin.rh.create');
    }

    // Afficher la liste des RH
    public function index()
    {
        $rhUsers = User::where('role', 'rh')->get();
        return view('admin.rh.index', compact('rhUsers'));
    }

    // Enregistrer un nouvel utilisateur RH
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'rh',
            'status' => 'actif',
            'dateInscription' => Carbon::now(),
        ]);

        return redirect()->route('admin.rh.index')
            ->with('success', 'Utilisateur RH ajouté avec succès.');
    }

    // Modifier un utilisateur RH
    public function edit(User $rh)
    {
        return view('admin.rh.edit', compact('rh'));
    }

    // Mettre à jour un utilisateur RH
    public function update(Request $request, User $rh)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $rh->id,
            'status' => 'required|in:actif,inactif',
        ]);

        $data = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'status' => $request->status,
        ];

        // Mettre à jour le mot de passe uniquement s'il est fourni
        if ($request->filled('password') && $request->filled('password_confirmation')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $rh->update($data);

        return redirect()->route('admin.rh.index')
            ->with('success', 'Utilisateur RH mis à jour avec succès.');
    }

    // Supprimer un utilisateur RH
    public function destroy(User $rh)
    {
        if ($rh->role !== 'rh') {
            return redirect()->route('admin.rh.index')
                ->with('error', 'Vous ne pouvez supprimer que des utilisateurs RH.');
        }

        $rh->delete();

        return redirect()->route('admin.rh.index')
            ->with('success', 'Utilisateur RH supprimé avec succès.');
    }
} 