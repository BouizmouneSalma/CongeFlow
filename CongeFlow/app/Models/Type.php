<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'libelle',
        'duree_max',
        'couleur',
        'description',
    ];
    
    /**
     * Les demandes de congé de ce type
     */
    public function demandesConge()
    {
        return $this->hasMany(DemandeConge::class);
    }
}
