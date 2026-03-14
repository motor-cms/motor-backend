<?php

use Illuminate\Support\Facades\Auth;
use Motor\Backend\Models\ConfigVariable;

function merge_local_config_with_db_configuration_variables($package)
{
    try {
        // Cache all config variables in a single query, shared across all packages
        static $allVariables = null;
        if ($allVariables === null) {
            $allVariables = \Illuminate\Support\Facades\Cache::remember('config_variables_all', 3600, function () {
                return ConfigVariable::all()->groupBy('package');
            });
        }

        foreach ($allVariables->get($package, []) as $configVariable) {
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

    // Reuse the cached collection from merge_local_config_with_db_configuration_variables
    $allVariables = \Illuminate\Support\Facades\Cache::remember('config_variables_all', 3600, function () {
        return \Motor\Backend\Models\ConfigVariable::all()->groupBy('package');
    });

    $variable = $allVariables->get($package, collect())->first(function ($v) use ($group, $name) {
        return $v->group === $group && $v->name === $name;
    });

    return $variable ? $variable->value : $default;
}
