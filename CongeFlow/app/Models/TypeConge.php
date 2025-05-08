<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeConge extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'droits_annuels',
        'couleur',
        'actif'
    ];

    /**
     * Les demandes de congés de ce type
     */
    public function demandesConge()
    {
        return $this->hasMany(DemandeConge::class, 'type_id');
    }
} 