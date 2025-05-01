<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Mettre à jour le profil de l'utilisateur
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photoProfile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
        ];

        // Gérer l'upload de photo de profil
        if ($request->hasFile('photoProfile') && $request->file('photoProfile')->isValid()) {
            try {
                // Supprimer l'ancienne photo si elle existe
                if ($user->photoProfile) {
                    Storage::disk('public')->delete($user->photoProfile);
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
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['photoProfile' => 'Erreur lors de la mise à jour de la photo: ' . $e->getMessage()]);
            }
        }
        
        // Supprimer la photo si demandé
        if ($request->has('remove_photo') && $request->remove_photo && $user->photoProfile) {
            try {
                Storage::disk('public')->delete($user->photoProfile);
                $data['photoProfile'] = null;
            } catch (\Exception $e) {
                // On continue même en cas d'erreur
            }
        }

        // Mettre à jour le mot de passe uniquement s'il est fourni
        if ($request->filled('current_password') && $request->filled('password')) {
            $request->validate([
                'current_password' => 'required|string|current_password',
                'password' => 'required|string|min:8|confirmed',
            ]);
            
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('profile.edit')
            ->with('success', 'Profil mis à jour avec succès');
    }
} 