<?php

use Illuminate\Support\Facades\Auth;

function has_permission($permission)
{
    return (Auth::user()->hasRole('SuperAdmin') || Auth::user()->hasPermissionTo($permission));
}

function has_role($role)
{
    $role = explode(',', $role);
    return (Auth::user()->hasRole('SuperAdmin') || Auth::user()->hasAnyRole($role));
}