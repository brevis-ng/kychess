<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
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
        if ( $user->role_id ) {
            $user_has_permissions = [];

            $permissions = Role::find($user->role_id)->permissions;
            foreach ( $permissions as $permission ) {
                $user_has_permissions[] = $permission['action'];
            }

            return in_array(Permission::VIEWANY, $user_has_permissions);
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Permission $permission)
    {
        if ( $user->role_id ) {
            $user_has_permissions = [];

            $permissions = Role::find($user->role_id)->permissions;
            foreach ( $permissions as $permission ) {
                $user_has_permissions[] = $permission['action'];
            }

            return in_array(Permission::VIEW, $user_has_permissions);
        }
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

            return in_array(Permission::CREATE, $user_has_permissions);
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Permission $permission = null)
    {
        if ( $user->role_id ) {
            $user_has_permissions = [];

            $permissions = Role::find($user->role_id)->permissions;
            foreach ( $permissions as $permission ) {
                $user_has_permissions[] = $permission['action'];
            }

            return in_array(Permission::UPDATE, $user_has_permissions);
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Permission $permission = null)
    {
        if ( $user->role_id ) {
            $user_has_permissions = [];

            $permissions = Role::find($user->role_id)->permissions;
            foreach ( $permissions as $permission ) {
                $user_has_permissions[] = $permission['action'];
            }

            return in_array(Permission::DESTROY, $user_has_permissions);
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Permission $permission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Permission $permission)
    {
        //
    }
}
