<?php

namespace Motor\Backend\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Motor\Backend\Models\Role;
use Motor\Backend\Models\User;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('role.read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return $user->hasPermissionTo('role.read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('role.write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $user->hasPermissionTo('role.write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $user->hasPermissionTo('role.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
        //
    }
}
