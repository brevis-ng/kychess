<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
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

            return in_array(Activity::VIEWANY, $user_has_permissions);
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity|null  $activity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Activity $activity = null)
    {
        if ( $user->role_id ) {
            $user_has_permissions = [];

            $permissions = Role::find($user->role_id)->permissions;
            foreach ( $permissions as $permission ) {
                $user_has_permissions[] = $permission['action'];
            }

            return in_array(Activity::VIEW, $user_has_permissions);
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

            return in_array(Activity::CREATE, $user_has_permissions);
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity|null  $activity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Activity $activity = null)
    {
        if ( $user->role_id ) {
            $user_has_permissions = [];

            $permissions = Role::find($user->role_id)->permissions;
            foreach ( $permissions as $permission ) {
                $user_has_permissions[] = $permission['action'];
            }

            return in_array(Activity::UPDATE, $user_has_permissions);
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity|null  $activity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Activity $activity = null)
    {
        if ( $user->role_id ) {
            $user_has_permissions = [];

            $permissions = Role::find($user->role_id)->permissions;
            foreach ( $permissions as $permission ) {
                $user_has_permissions[] = $permission['action'];
            }

            return in_array(Activity::DESTROY, $user_has_permissions);
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Activity $activity)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Activity $activity)
    {
        //
    }
}
