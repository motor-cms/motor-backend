<?php

use Illuminate\Support\Facades\Auth;
use Motor\Backend\Models\ConfigVariable;

function merge_local_config_with_db_configuration_variables($package)
{
    try {
        foreach (ConfigVariable::where('package', $package)
                               ->get() as $configVariable) {
            $config = app('config')->get($configVariable->group, []);
            app('config')->set($configVariable->group, array_replace_recursive($config, [$configVariable->name => $configVariable->value]));
        }
    } catch (\Exception $e) {
        // Do nothing if the database doesn't exist
    }
}

if (! function_exists('has_permission')) {
    /**
     * @param $permission
     * @return bool
     */
    function has_permission($permission)
    {
        return Auth::user()
                    ->hasRole('SuperAdmin') || Auth::user()
                                                   ->hasPermissionTo($permission);
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

        return Auth::user()
                    ->hasRole('SuperAdmin') || Auth::user()
                                                   ->hasAnyRole($role);
    }
}

/**
 * @param    $var
 * @param  null  $default
 * @return mixed|null
 */
function config_variable($var, $default = null)
{
    [$package, $group, $name] = explode('.', $var);

    $variable = \Motor\Backend\Models\ConfigVariable::where('package', $package)
                                                    ->where('group', $group)
                                                    ->where('name', $name)
                                                    ->first();
    if (! is_null($variable)) {
        return $variable->value;
    }

    return $default;
}
