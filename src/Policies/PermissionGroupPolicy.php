<?php

namespace Motor\Backend\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Motor\Backend\Models\PermissionGroup;
use Motor\Backend\Models\User;

class PermissionGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \Motor\Backend\Models\User  $user
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
     * @param  \Motor\Backend\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('permission_group.read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\Backend\Models\PermissionGroup  $permissionGroup
     * @return mixed
     */
    public function view(User $user, PermissionGroup $permissionGroup)
    {
        return $user->hasPermissionTo('permission_group.read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('permission_group.write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\Backend\Models\PermissionGroup  $permissionGroup
     * @return mixed
     */
    public function update(User $user, PermissionGroup $permissionGroup)
    {
        return $user->hasPermissionTo('permission_group.write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\Backend\Models\PermissionGroup  $permissionGroup
     * @return mixed
     */
    public function delete(User $user, PermissionGroup $permissionGroup)
    {
        return $user->hasPermissionTo('permission_group.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\Backend\Models\PermissionGroup  $permissionGroup
     * @return mixed
     */
    public function restore(User $user, PermissionGroup $permissionGroup)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\Backend\Models\PermissionGroup  $permissionGroup
     * @return mixed
     */
    public function forceDelete(User $user, PermissionGroup $permissionGroup)
    {
        //
    }
}
