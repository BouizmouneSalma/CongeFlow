<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'photoProfile',
        'role',
        'status',
        'dateInscription',
        'service_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'dateInscription' => 'datetime',
    ];

    /**
     * Les demandes de congé de cet utilisateur
     */
    public function demandesConge()
    {
        return $this->hasMany(DemandeConge::class);
    }

    /**
     * Récupère le service auquel appartient l'utilisateur
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Vérifie si l'utilisateur est un RH
     */
    public function isRH()
    {
        return $this->role === 'rh';
    }

    /**
     * Vérifie si l'utilisateur est un admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est un salarié
     */
    public function isSalarie()
    {
        return $this->role === 'salarie';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}