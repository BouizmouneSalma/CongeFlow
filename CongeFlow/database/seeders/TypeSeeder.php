<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

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
                'description' => 'Congés payés annuels légaux',
                'duree' => '1,5 jour/mois',
                'duree_max' => 18, // 18 jours par an
                'paiement' => 100, // 100% du salaire
                'couleur' => '#3B82F6', // Bleu
                'actif' => true
            ],
            [
                'libelle' => 'Congé de maternité',
                'description' => 'Congé accordé aux femmes enceintes',
                'duree' => '14 semaines (7 avant + 7 après)',
                'duree_max' => 98, // 14 semaines * 7 jours
                'paiement' => 100, // 100% via CNSS
                'couleur' => '#EC4899', // Rose
                'actif' => true
            ],
            [
                'libelle' => 'Congé de paternité',
                'description' => 'Congé accordé aux nouveaux pères',
                'duree' => '3 jours',
                'duree_max' => 3,
                'paiement' => 100, // 100% remboursé par CNSS
                'couleur' => '#8B5CF6', // Violet
                'actif' => true
            ],
            [
                'libelle' => 'Congés exceptionnels',
                'description' => 'Congés pour événements familiaux ou personnels (mariage, décès, circoncision, opération)',
                'duree' => '2 à 4 jours',
                'duree_max' => 4,
                'paiement' => 100, // Rémunéré par l'employeur
                'couleur' => '#F59E0B', // Orange
                'actif' => true
            ],
            [
                'libelle' => 'Congé maladie',
                'description' => 'Congé pour raison médicale',
                'duree' => 'Variable selon certificat médical',
                'duree_max' => null, // Variable selon le certificat
                'paiement' => 0, // Non rémunéré sauf dispositions spécifiques
                'couleur' => '#EF4444', // Rouge
                'actif' => true
            ],
            [
                'libelle' => 'Accident du travail',
                'description' => 'Congé suite à un accident de travail',
                'duree' => 'Jusqu\'à guérison',
                'duree_max' => null, // Variable selon la guérison
                'paiement' => 100, // Indemnité CNSS
                'couleur' => '#DC2626', // Rouge foncé
                'actif' => true
            ]
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
} 