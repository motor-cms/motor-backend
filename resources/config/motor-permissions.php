<?php

return [
    'dashboard'       => [
        'name'   => 'backend/global.dashboard',
        'values' => [
            'read'
        ]
    ],
    'clients'         => [
        'name'   => 'backend/clients.clients',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
    'users'           => [
        'name'   => 'backend/users.users',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
    'languages'       => [
        'name'   => 'backend/languages.languages',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
    'email_templates' => [
        'name'   => 'backend/email_templates.email_templates',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
    'permissions'     => [
        'name'   => 'backend/permissions.permissions',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
    'roles'           => [
        'name'   => 'backend/roles.roles',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
];