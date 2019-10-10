<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('has_permission')) {
    /**
     * @param $permission
     * @return bool
     */
    function has_permission($permission)
    {
        return (Auth::user()->hasRole('SuperAdmin') || Auth::user()->hasPermissionTo($permission));
    }
}

if (! function_exists('has_role')) {
    /**
     * @param $role
     * @return bool
     */
    function has_role($role)
    {
        $role = explode(',', $role);

        return (Auth::user()->hasRole('SuperAdmin') || Auth::user()->hasAnyRole($role));
    }
}

/**
 * @param      $var
 * @param null $default
 * @return mixed|null
 */
function config_variable($var, $default = null)
{
    list($package, $group, $name) = explode('.', $var);

    $variable = \Motor\Backend\Models\ConfigVariable::where('package', $package)
                                                    ->where('group', $group)
                                                    ->where('name', $name)
                                                    ->first();
    if (! is_null($variable)) {
        return $variable->value;
    }

    return $default;
}
