<?php

namespace App\Policies;

use App\Models\FleetUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FleetUserPolicy
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
        return $user->hasRole('super_admin') || $user->hasPermissionTo('fleet_user.view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FleetUser  $fleetUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FleetUser $fleetUser)
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        
        if ($user->hasPermissionTo('fleet_user.view')) {
            return $user->company_id === $fleetUser->fleet->company_id;
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
        return $user->hasRole('super_admin') || $user->hasPermissionTo('fleet_user.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FleetUser  $fleetUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FleetUser $fleetUser)
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        
        if ($user->hasPermissionTo('fleet_user.update')) {
            return $user->company_id === $fleetUser->fleet->company_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FleetUser  $fleetUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FleetUser $fleetUser)
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        
        if ($user->hasPermissionTo('fleet_user.delete')) {
            return $user->company_id === $fleetUser->fleet->company_id;
        }
        
        return false;
    }
}