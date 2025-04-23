<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
            Service::create($serviceData);
        }
        
        // Récupérer les IDs des services
        $serviceInfo = Service::where('nom', 'Informatique')->first()->id;
        $serviceRH = Service::where('nom', 'Ressources Humaines')->first()->id;
        $serviceDirection = Service::where('nom', 'Direction')->first()->id;

        // admin
        User::create([
            'nom' => 'Admin',
            'prenom' => 'Système',
            'email' => 'salmabouizmoune@gmail.com',
            'password' => Hash::make('admin123'), 
            'role' => 'admin',
            'status' => 'actif',
            'dateInscription' => Carbon::now(),
            'service_id' => $serviceDirection,
        ]);

        //  RH
        User::create([
            'nom' => 'rh',
            'prenom' => 'Rh',
            'email' => 'salmabouizmoun@gmail.com',
            'password' => Hash::make('f'), 
            'role' => 'rh',
            'status' => 'actif',
            'dateInscription' => Carbon::now(),
            'service_id' => $serviceRH,
        ]);

        // salarie
        User::create([
            'nom' => 'salma',
            'prenom' => 'salma',
            'email' => 'perso1salmabouizmoune@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'salarie',
            'status' => 'actif',
            'dateInscription' => Carbon::now(),
            'service_id' => $serviceInfo,
        ]);
        
        // Appel du seeder pour les types de congés
        $this->call(TypeSeeder::class);
    }
}
