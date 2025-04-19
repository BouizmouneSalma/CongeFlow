<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // admin
        User::create([
            'nom' => 'Admin',
            'prenom' => 'Système',
            'email' => 'salmabouizmoune@gmail.com',
            'password' => Hash::make('admin123'), 
            'role' => 'admin',
            'status' => 'actif',
            'dateInscription' => Carbon::now(),
        ]);

        //  RH
        User::create([
            'nom' => 'rh',
            'prenom' => 'Rh',
            'email' => 'salmabouizmoun@gmail.com',
            'password' => Hash::make('rh123456'), 
            'role' => 'rh',
            'status' => 'actif',
            'dateInscription' => Carbon::now(),
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
        ]);
    }
}
