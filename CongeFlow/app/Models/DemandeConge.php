<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeConge extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'type_id',
        'dateDebut',
        'dateFin',
        'motif',
        'statut',
        'commentaire',
    ];
    
    protected $casts = [
        'dateDebut' => 'date',
        'dateFin' => 'date',
    ];
    
    /**
     * Relation avec l'utilisateur qui a demandé le congé
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relation avec le type de congé demandé
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    
    /**
     * Calcule la durée du congé en jours
     */
    public function getDureeAttribute()
    {
        return $this->dateDebut->diffInDays($this->dateFin) + 1;
    }
    
    /**
     * Retourne la classe CSS selon le statut
     */
    public function getStatusClassAttribute()
    {
        return [
            'en_attente' => 'bg-yellow-100 text-yellow-800',
            'approuvee' => 'bg-green-100 text-green-800',
            'refusee' => 'bg-red-100 text-red-800',
            'annulee' => 'bg-gray-100 text-gray-800',
        ][$this->statut] ?? 'bg-gray-100';
    }
    
    /**
     * Retourne le libellé du statut
     */
    public function getStatusLabelAttribute()
    {
        return [
            'en_attente' => 'En attente',
            'approuvee' => 'Approuvée',
            'refusee' => 'Refusée',
            'annulee' => 'Annulée',
        ][$this->statut] ?? 'Inconnu';
    }
    
    /**
     * Scope pour les demandes en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }
    
    /**
     * Scope pour les demandes approuvées
     */
    public function scopeApprouvees($query)
    {
        return $query->where('statut', 'approuvee');
    }
    
    /**
     * Scope pour les demandes refusées
     */
    public function scopeRefusees($query)
    {
        return $query->where('statut', 'refusee');
    }
}
