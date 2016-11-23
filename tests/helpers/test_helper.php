<?php

function create_test_user($count = 1)
{
    return factory(Motor\Backend\Models\User::class, $count)->create();
}

function create_test_permission_with_name($permission)
{
    return factory(Motor\Backend\Models\Permission::class)->create([ 'name' => $permission ]);
}

function create_test_permission($count = 1)
{
    return factory(Motor\Backend\Models\Permission::class, $count)->create();
}

function create_test_permission_group($count = 1)
{
    return factory(Motor\Backend\Models\PermissionGroup::class, $count)->create();
}

function create_test_role($count = 1)
{
    return factory(Motor\Backend\Models\Role::class, $count)->create();
}

function create_test_client($count = 1)
{
    return factory(Motor\Backend\Models\Client::class, $count)->create();
}

function create_test_language($count = 1)
{
    return factory(Motor\Backend\Models\Language::class, $count)->create();
}

function create_test_email_template($count = 1)
{
    return $email_template = factory(Motor\Backend\Models\EmailTemplate::class, $count)->create();

}