<?php

namespace Motor\Backend\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Motor\Backend\Models\ConfigVariable;
use Motor\Backend\Models\User;

class ConfigVariablePolicy
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
        return $user->hasPermissionTo('config_variable.read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\Backend\Models\ConfigVariable  $configVariable
     * @return mixed
     */
    public function view(User $user, ConfigVariable $configVariable)
    {
        return $user->hasPermissionTo('config_variable.read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('config_variable.write');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\Backend\Models\ConfigVariable  $configVariable
     * @return mixed
     */
    public function update(User $user, ConfigVariable $configVariable)
    {
        return $user->hasPermissionTo('config_variable.write');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\Backend\Models\ConfigVariable  $configVariable
     * @return mixed
     */
    public function delete(User $user, ConfigVariable $configVariable)
    {
        return $user->hasPermissionTo('config_variable.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\Backend\Models\ConfigVariable  $configVariable
     * @return mixed
     */
    public function restore(User $user, ConfigVariable $configVariable)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Motor\Backend\Models\User  $user
     * @param  \Motor\Backend\Models\ConfigVariable  $configVariable
     * @return mixed
     */
    public function forceDelete(User $user, ConfigVariable $configVariable)
    {
        //
    }
}
