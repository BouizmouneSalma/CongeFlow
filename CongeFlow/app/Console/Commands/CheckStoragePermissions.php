<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class CheckStoragePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie et répare les permissions de stockage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des permissions de stockage...');
        
        // Vérifier si le lien symbolique existe
        if (!file_exists(public_path('storage'))) {
            $this->info('Création du lien symbolique pour le stockage public...');
            $this->call('storage:link');
        } else {
            $this->info('Le lien symbolique vers le stockage public existe déjà.');
        }
        
        // Vérifier si le dossier profile-photos existe
        $profilePhotosPath = storage_path('app/public/profile-photos');
        if (!file_exists($profilePhotosPath)) {
            $this->info('Création du dossier profile-photos...');
            Storage::disk('public')->makeDirectory('profile-photos');
        } else {
            $this->info('Le dossier profile-photos existe déjà.');
        }
        
        // Vérifier les permissions du dossier storage
        $this->info('Vérification des permissions du dossier storage...');
        
        try {
            if (PHP_OS_FAMILY === 'Windows') {
                $this->info('Système Windows détecté, pas besoin de changer les permissions.');
            } else {
                // Sur Linux/Unix, définir les permissions
                $storagePath = storage_path();
                $publicPath = public_path();
                
                $this->runProcess(['chmod', '-R', '775', $storagePath]);
                $this->runProcess(['chmod', '-R', '775', $publicPath . '/storage']);
                
                // Définir le propriétaire sur le user et le groupe www-data (pour Apache/Nginx)
                $user = exec('whoami');
                $this->runProcess(['chown', '-R', $user . ':www-data', $storagePath]);
                $this->runProcess(['chown', '-R', $user . ':www-data', $publicPath . '/storage']);
                
                $this->info('Permissions storage mises à jour avec succès.');
            }
        } catch (\Exception $e) {
            $this->error('Erreur lors de la mise à jour des permissions : ' . $e->getMessage());
        }
        
        // Vérifier si la colonne photoProfile existe dans la table users
        $this->info('Vérification de la structure de la base de données...');
        $this->call('migrate');
        
        $this->info('Vérification des permissions de stockage terminée !');
    }
    
    /**
     * Exécute une commande de processus
     */
    private function runProcess(array $command)
    {
        $process = new Process($command);
        $process->run();
        
        if (!$process->isSuccessful()) {
            throw new \Exception($process->getErrorOutput());
        }
        
        return $process->getOutput();
    }
} 