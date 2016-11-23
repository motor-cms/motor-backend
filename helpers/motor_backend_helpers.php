<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('has_permission')) {
    function has_permission($permission)
    {
        return (Auth::user()->hasRole('SuperAdmin') || Auth::user()->hasPermissionTo($permission));
    }
}

if (!function_exists('has_role')) {
    function has_role($role)
    {
        $role = explode(',', $role);

        return ( Auth::user()->hasRole('SuperAdmin') || Auth::user()->hasAnyRole($role) );
    }
}