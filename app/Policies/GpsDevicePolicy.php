<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GpsDevice;
use Illuminate\Auth\Access\HandlesAuthorization;

class GpsDevicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_gps::device');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GpsDevice $gpsDevice): bool
    {
        // Jika user memiliki permission view_gps::device
        if ($user->can('view_gps::device')) {
            // Super admin dapat melihat semua data
            if ($user->hasRole('super_admin')) {
                return true;
            }
            
            // User lain hanya dapat melihat data dari company mereka sendiri
            return $user->company_id === $gpsDevice->company_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_gps::device');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GpsDevice $gpsDevice): bool
    {
        // Jika user memiliki permission update_gps::device
        if ($user->can('update_gps::device')) {
            // Super admin dapat mengupdate semua data
            if ($user->hasRole('super_admin')) {
                return true;
            }
            
            // User lain hanya dapat mengupdate data dari company mereka sendiri
            return $user->company_id === $gpsDevice->company_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GpsDevice $gpsDevice): bool
    {
        // Jika user memiliki permission delete_gps::device
        if ($user->can('delete_gps::device')) {
            // Super admin dapat menghapus semua data
            if ($user->hasRole('super_admin')) {
                return true;
            }
            
            // User lain hanya dapat menghapus data dari company mereka sendiri
            return $user->company_id === $gpsDevice->company_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_gps::device');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, GpsDevice $gpsDevice): bool
    {
        return $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, GpsDevice $gpsDevice): bool
    {
        return $user->can('{{ Restore }}');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, GpsDevice $gpsDevice): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}