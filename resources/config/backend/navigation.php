<?php

return [
    'items' => [
        0   => [
            'slug'        => 'dashboard',
            'name'        => 'backend/global.dashboard',
            'icon'        => 'fa fa-home',
            'route'       => 'backend.dashboard',
            'roles'       => [ 'SuperAdmin' ],
            'permissions' => [ 'dashboard.read' ]
        ],
        900 => [
            'slug'        => 'administration',
            'name'        => 'backend/global.administration',
            'icon'        => 'fa fa-cogs',
            'route'       => null,
            'roles'       => [ 'SuperAdmin' ],
            'permissions' => [],
            'items'       => [
                0  => [
                    'slug'        => 'users',
                    'name'        => 'backend/users.users',
                    'icon'        => 'fa fa-user',
                    'route'       => 'backend.users.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [],
                ],
                10 => [
                    'slug'        => 'languages',
                    'name'        => 'backend/languages.languages',
                    'icon'        => 'fa fa-globe',
                    'route'       => 'backend.languages.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [],
                ],
                20 => [
                    'slug'        => 'clients',
                    'name'        => 'backend/clients.clients',
                    'icon'        => 'fa fa-plus',
                    'route'       => 'backend.clients.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [],
                ],
                30 => [
                    'slug'        => 'email_templates',
                    'name'        => 'backend/email_templates.email_templates',
                    'icon'        => 'fa fa-plus',
                    'route'       => 'backend.email_templates.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [],
                ],
                40 => [
                    'slug'        => 'roles',
                    'name'        => 'backend/roles.roles',
                    'icon'        => 'fa fa-plus',
                    'route'       => 'backend.roles.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [],
                ],
                50 => [
                    'slug'        => 'permissions',
                    'name'        => 'backend/permissions.permissions',
                    'icon'        => 'fa fa-plus',
                    'route'       => 'backend.permissions.index',
                    'roles'       => [ 'SuperAdmin' ],
                    'permissions' => [],
                ]
            ]
        ]
    ]
];