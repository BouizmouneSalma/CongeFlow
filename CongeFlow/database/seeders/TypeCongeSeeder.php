<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeConge;

class TypeCongeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'nom' => 'Congés annuels',
                'description' => 'Congés payés annuels',
                'droits_annuels' => 25,
                'couleur' => '#3B82F6', // Bleu
                'actif' => true
            ],
            [
                'nom' => 'RTT',
                'description' => 'Réduction du temps de travail',
                'droits_annuels' => 11,
                'couleur' => '#10B981', // Vert
                'actif' => true
            ],
            [
                'nom' => 'Congé sans solde',
                'description' => 'Congé non rémunéré',
                'droits_annuels' => 0,
                'couleur' => '#F59E0B', // Orange
                'actif' => true
            ],
            [
                'nom' => 'Congé maladie',
                'description' => 'Arrêt maladie',
                'droits_annuels' => 0,
                'couleur' => '#8B5CF6', // Violet
                'actif' => true
            ],
            [
                'nom' => 'Congé exceptionnel',
                'description' => 'Événements familiaux, etc.',
                'droits_annuels' => 0,
                'couleur' => '#EC4899', // Rose
                'actif' => true
            ]
        ];

        foreach ($types as $type) {
            TypeConge::create($type);
        }
    }
} 