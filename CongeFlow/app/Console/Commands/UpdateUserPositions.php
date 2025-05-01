<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserPositions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update-positions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mise à jour des postes pour les utilisateurs existants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $postes = [
            'Développeur DevOps',
            'Développeur Frontend',
            'Développeur Backend',
            'Designer UX/UI',
            'Chef de Projet',
            'Ingénieur QA',
            'Administrateur Système',
            'Analyste Fonctionnel'
        ];

        $this->info('Mise à jour des postes pour les salariés...');
        
        $users = User::where('role', 'salarie')->get();
        $count = 0;
        
        foreach ($users as $user) {
            if (empty($user->poste)) {
                $poste = $postes[array_rand($postes)];
                $user->poste = $poste;
                $user->save();
                $count++;
                $this->info("Utilisateur {$user->prenom} {$user->nom} est maintenant {$poste}");
            }
        }
        
        $this->info("{$count} utilisateurs mis à jour avec succès.");
    }
} 