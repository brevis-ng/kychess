<?php

namespace App\Policies;

use App\Models\Config;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Config $config)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ( $user->role_id ) {
            $user_has_permissions = [];

            $permissions = Role::find($user->role_id)->permissions;
            foreach ( $permissions as $permission ) {
                $user_has_permissions[] = $permission['action'];
            }

            return in_array(Config::SHORTCUT, $user_has_permissions);
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Config $config = null)
    {
        if ( $user->role_id ) {
            $user_has_permissions = [];

            $permissions = Role::find($user->role_id)->permissions;
            foreach ( $permissions as $permission ) {
                $user_has_permissions[] = $permission['action'];
            }

            return in_array(Config::SHORTCUT, $user_has_permissions);
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Config $config)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Config $config)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Config $config)
    {
        //
    }
}
