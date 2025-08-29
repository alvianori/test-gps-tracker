<?php

namespace App\Policies;

use App\Models\FleetGps;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FleetGpsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('super_admin') || $user->can('fleet_gps.view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FleetGps  $fleetGps
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FleetGps $fleetGps)
    {
        if ($user->hasRole('super_admin') || $user->can('fleet_gps.view')) {
            if (!$user->hasRole('super_admin')) {
                return $user->company_id === $fleetGps->fleet->company_id;
            }
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole('super_admin') || $user->can('fleet_gps.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FleetGps  $fleetGps
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FleetGps $fleetGps)
    {
        if ($user->hasRole('super_admin') || $user->can('fleet_gps.update')) {
            if (!$user->hasRole('super_admin')) {
                return $user->company_id === $fleetGps->fleet->company_id;
            }
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FleetGps  $fleetGps
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FleetGps $fleetGps)
    {
        if ($user->hasRole('super_admin') || $user->can('fleet_gps.delete')) {
            if (!$user->hasRole('super_admin')) {
                return $user->company_id === $fleetGps->fleet->company_id;
            }
            return true;
        }
        return false;
    }
}