<?php

return [
    'profile'          => [
        'name'   => 'backend/global.profile',
        'values' => [
            'read',
            'write'
        ]
    ],
    'dashboard'        => [
        'name'   => 'backend/global.dashboard',
        'values' => [
            'read'
        ]
    ],
    'clients'          => [
        'name'   => 'backend/clients.clients',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
    'users'            => [
        'name'   => 'backend/users.users',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
    'languages'        => [
        'name'   => 'backend/languages.languages',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
    'email_templates'  => [
        'name'   => 'backend/email_templates.email_templates',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'permissions'      => [
        'name'   => 'backend/permissions.permissions',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
    'roles'            => [
        'name'   => 'backend/roles.roles',
        'values' => [
            'read',
            'write',
            'delete',
        ]
    ],
    'categories'       => [
        'name'   => 'motor-backend::backend/categories.categories',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'category_trees'   => [
        'name'   => 'motor-backend::backend/category_trees.category_trees',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'config_variables' => [
        'name'   => 'motor-backend::backend/config_variables.config_variables',
        'values' => [
            'read',
            'write',
            'delete'
        ]
    ],
    'administration'   => [
        'name'   => 'motor-backend::backend/global.administration',
        'values' => [
            'read'
        ]
    ]
];