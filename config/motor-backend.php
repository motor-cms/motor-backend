<?php

return [
    'models'            => [
        'client'           => Motor\Backend\Models\Client::class,
        'language'         => Motor\Backend\Models\Language::class,
        'user'             => Motor\Backend\Models\User::class,
        'role'             => Motor\Backend\Models\Role::class,
        'permission'       => Motor\Backend\Models\Permission::class,
        'permission_group' => Motor\Backend\Models\PermissionGroup::class,
        'email_template'   => Motor\Backend\Models\EmailTemplate::class,
    ],
    'routes'            => [
        'dashboard'       => true,
        'users'           => true,
        'roles'           => true,
        'permissions'     => true,
        'clients'         => true,
        'languages'       => true,
        'email_templates' => true,
        'profile'         => true

    ],
    'flash'             => 'toastr',
    'bootstrap_version' => 4
];
