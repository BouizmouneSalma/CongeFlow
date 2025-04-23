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
        // Les admins et RH peuvent voir toutes les demandes
        if (in_array($user->role, ['admin', 'rh'])) {
            return true;
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
        // Les admins et RH peuvent modifier toutes les demandes
        if (in_array($user->role, ['admin', 'rh'])) {
            return true;
        }
        
        // Les salariés ne peuvent modifier que leurs propres demandes en attente
        return $user->id === $demandeConge->user_id && $demandeConge->statut === 'en_attente';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DemandeConge $demandeConge): bool
    {
        // Seuls les admins et RH peuvent supprimer les demandes
        return in_array($user->role, ['admin', 'rh']);
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
        // Seuls les RH et admins peuvent changer le statut
        return in_array($user->role, ['rh', 'admin']);
    }
} 