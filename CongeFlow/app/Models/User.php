<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id'; 

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'photoProfile',
        'role',
        'status',
        'dateInscription',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'dateInscription' => 'datetime',
    ];

    // Méthodes de la classe Utilisateur
    public function login($email, $password)
    {
        // Logique de connexion
        return true;
    }

    public function logout()
    {
        // Logique de déconnexion
    }

    // Les relations
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function demandeConges()
    {
        return $this->hasMany(DemandeConge::class);
    }
}