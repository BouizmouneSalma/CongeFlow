<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conge extends Model
{
    use HasFactory;

    /**
     * La clé primaire n'est pas 'id' par défaut
     */
    protected $primaryKey = 'idConge';

    protected $fillable = [
        'titre',
        'description',
        'dateCreation',
        'type_id'
    ];

    protected $casts = [
        'dateCreation' => 'datetime'
    ];

    /**
     * Relation avec le type de congé
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Relation avec les demandes de congé
     */
    public function demandes()
    {
        return $this->hasMany(DemandeConge::class, 'conge_id', 'idConge');
    }
}
