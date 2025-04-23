<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'libelle' => 'Congé annuel payé',
                'duree_max' => 18,
                'couleur' => '#3b82f6', // blue
                'description' => '1,5 jour/mois (18 jours/an) - Salaire normal, indemnité compensatrice en cas de rupture',
            ],
            [
                'libelle' => 'Congé de maternité',
                'duree_max' => 98, // 14 semaines
                'couleur' => '#ec4899', // pink
                'description' => '14 semaines (7 avant + 7 après) - Indemnité CNSS (100% du salaire moyen)',
            ],
            [
                'libelle' => 'Congé de paternité',
                'duree_max' => 3,
                'couleur' => '#8b5cf6', // purple
                'description' => '3 jours - Salaire normal, remboursé par la CNSS',
            ],
            [
                'libelle' => 'Congés exceptionnels',
                'duree_max' => 4,
                'couleur' => '#f59e0b', // amber
                'description' => '2 à 4 jours (mariage, décès, circoncision, opération) - Rémunéré par l\'employeur',
            ],
            [
                'libelle' => 'Congé maladie',
                'duree_max' => null,
                'couleur' => '#ef4444', // red
                'description' => 'Variable selon certificat médical - Non rémunéré sauf dispositions spécifiques',
            ],
            [
                'libelle' => 'Accident du travail',
                'duree_max' => null,
                'couleur' => '#10b981', // emerald
                'description' => 'Jusqu\'à guérison - Indemnité CNSS et maintien du congé annuel',
            ],
        ];

        foreach ($types as $typeData) {
            Type::updateOrCreate(
                ['libelle' => $typeData['libelle']],
                $typeData
            );
        }
    }
} 