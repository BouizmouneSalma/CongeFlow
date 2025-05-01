<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    /**
     * Afficher le formulaire de test d'upload
     */
    public function showForm()
    {
        return view('test.upload');
    }

    /**
     * Traiter l'upload de fichier de test
     */
    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $file = $request->file('photo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                
                // S'assurer que le répertoire existe
                $path = 'test-uploads';
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }
                
                // Stocker le fichier
                $filePath = $file->storeAs($path, $fileName, 'public');
                
                // Ajouter des informations de débogage
                Log::info('Photo téléchargée avec succès', [
                    'path' => $filePath,
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'storage_path' => storage_path('app/public/' . $filePath),
                    'public_url' => asset('storage/' . $filePath)
                ]);
                
                return back()
                    ->with('success', 'Photo téléchargée avec succès.')
                    ->with('photo', $filePath);
            }
            
            return back()->with('error', 'Échec du téléchargement de la photo.');
        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement: ' . $e->getMessage());
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }
} 