<?php

namespace App\Policies;

use App\Models\DemandeConge;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DemandeCongePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Tous les utilisateurs peuvent voir leurs propres demandes
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DemandeConge $demandeConge): bool
    {
        // Seulement les RH peuvent voir toutes les demandes
        if ($user->role === 'rh') {
            return true;
        }
        
        // Les admins peuvent voir les demandes en lecture seule pour statistiques
        if ($user->role === 'admin') {
            return true; // Accès limité en lecture seule
        }
        
        // Les salariés ne peuvent voir que leurs propres demandes
        return $user->id === $demandeConge->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Tous les utilisateurs peuvent créer des demandes
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DemandeConge $demandeConge): bool
    {
        // Seuls les RH peuvent modifier toutes les demandes
        if ($user->role === 'rh') {
            return true;
        }
        
        // Les admins n'ont pas le droit de gérer les congés
        if ($user->role === 'admin') {
            return false;
        }
        
        // Les salariés ne peuvent modifier que leurs propres demandes en attente
        return $user->id === $demandeConge->user_id && $demandeConge->statut === 'en_attente';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DemandeConge $demandeConge): bool
    {
        // Seuls les RH peuvent supprimer les demandes
        return $user->role === 'rh';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DemandeConge $demandeConge): bool
    {
        // Seuls les admins peuvent restaurer les demandes
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DemandeConge $demandeConge): bool
    {
        // Seuls les admins peuvent supprimer définitivement les demandes
        return $user->role === 'admin';
    }
    
    /**
     * Determine whether the user can approve or reject the model.
     */
    public function changeStatus(User $user, DemandeConge $demandeConge): bool
    {
        // Seuls les RH peuvent changer le statut
        return $user->role === 'rh';
    }
} 