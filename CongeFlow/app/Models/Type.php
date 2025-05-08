<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'libelle',
        'duree',
        'couleur',
        'description',
        'paiement',
        'source_paiement',
        'taux_paiement',
        'actif'
    ];
    
    /**
     * Les congés de ce type
     */
    public function conges()
    {
        return $this->hasMany(Conge::class);
    }

    /**
     * Les demandes de congé de ce type (via la table conges)
     */
    public function demandesConge()
    {
        return $this->hasManyThrough(
            DemandeConge::class,
            Conge::class,
            'type_id', // Clé étrangère sur la table conges
            'conge_id', // Clé étrangère sur la table demande_conges
            'id', // Clé locale sur la table types
            'idConge' // Clé locale sur la table conges
        );
    }
}
