<?php

namespace Motor\Backend\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Motor\Backend\Models\Permission;
use Motor\Backend\Models\Role;
use Motor\Backend\Models\User;

/**
 * Class UserService
 * @package Motor\Backend\Services
 */
class UserService extends BaseService
{
    protected $model = User::class;


    public function filters()
    {
        $this->filter->addClientFilter();
    }


    public function beforeCreate()
    {
        $this->data['password']  = bcrypt($this->data['password']);
        $this->data['api_token'] = Str::random(60);
    }


    public function afterCreate()
    {
        if (has_permission('roles.write')) {
            foreach (Arr::get($this->data, 'roles', []) as $role) {
                $this->record->assignRole($role);
            }
        }
        if (has_permission('permissions.write')) {
            foreach (Arr::get($this->data, 'permissions', []) as $permission) {
                $this->record->givePermissionTo(Permission::find((int) $permission));
            }
        }
        $this->uploadFile($this->request->file('avatar'), 'avatar');
    }


    public function beforeUpdate()
    {
        // Special case to filter out the users api token when calling over the api
        if (Arr::get($this->data, 'api_token')) {
            unset($this->data['api_token']);
        }

        if (Arr::get($this->data, 'password') == '') {
            unset($this->data['password']);
        } else {
            $this->data['password'] = bcrypt($this->data['password']);
        }
    }


    public function afterUpdate()
    {
        if (has_permission('roles.write')) {
            if (is_array(Arr::get($this->data, 'roles'))) {
                foreach (Role::all() as $role) {
                    $this->record->removeRole($role);
                }
            }
        }

        if (has_permission('permissions.write')) {
            if (is_array(Arr::get($this->data, 'permissions'))) {
                foreach (Permission::all() as $permission) {
                    $this->record->revokePermissionTo($permission);
                }
            }
        }

        $this->afterCreate();
    }
}
