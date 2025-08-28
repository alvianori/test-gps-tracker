<?php

namespace App\Policies;

use App\Models\GpsTrack;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class GpsTrackPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_gps::track');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GpsTrack $gpsTrack): bool
    {
        // Jika user memiliki permission view_gps::track
        if ($user->can('view_gps::track')) {
            // Super admin dapat melihat semua data
            if ($user->hasRole('super_admin')) {
                return true;
            }
            
            // Cek apakah GPS device milik company user
            $deviceCompanyId = DB::table('gps_devices')
                ->where('id', $gpsTrack->gps_device_id)
                ->value('company_id');
                
            return $user->company_id === $deviceCompanyId;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_gps::track');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GpsTrack $gpsTrack): bool
    {
        // Jika user memiliki permission update_gps::track
        if ($user->can('update_gps::track')) {
            // Super admin dapat mengupdate semua data
            if ($user->hasRole('super_admin')) {
                return true;
            }
            
            // Cek apakah GPS device milik company user
            $deviceCompanyId = DB::table('gps_devices')
                ->where('id', $gpsTrack->gps_device_id)
                ->value('company_id');
                
            return $user->company_id === $deviceCompanyId;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GpsTrack $gpsTrack): bool
    {
        // Jika user memiliki permission delete_gps::track
        if ($user->can('delete_gps::track')) {
            // Super admin dapat menghapus semua data
            if ($user->hasRole('super_admin')) {
                return true;
            }
            
            // Cek apakah GPS device milik company user
            $deviceCompanyId = DB::table('gps_devices')
                ->where('id', $gpsTrack->gps_device_id)
                ->value('company_id');
                
            return $user->company_id === $deviceCompanyId;
        }
        
        return false;
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_gps::track');
    }
}