<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les services
        $services = [
            ['nom' => 'Informatique', 'description' => 'Service informatique et développement'],
            ['nom' => 'Ressources Humaines', 'description' => 'Service RH et administration du personnel'],
            ['nom' => 'Comptabilité', 'description' => 'Service comptabilité et finances'],
            ['nom' => 'Marketing', 'description' => 'Service marketing et communication'],
            ['nom' => 'Commercial', 'description' => 'Service commercial et ventes'],
            ['nom' => 'Direction', 'description' => 'Direction générale'],
        ];
        
        foreach ($services as $serviceData) {
            // Vérifier si le service existe déjà
            $exists = Service::where('nom', $serviceData['nom'])->first();
            
            if (!$exists) {
                Service::create($serviceData);
            }
        }
    }
} 