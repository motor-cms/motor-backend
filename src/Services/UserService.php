<?php

namespace Motor\Backend\Services;

use Illuminate\Support\Arr;
use Motor\Backend\Models\Role;
use Motor\Backend\Models\User;

class UserService extends BaseService
{

    protected $model = User::class;

    public function beforeCreate()
    {
        $this->data['password']  = bcrypt($this->data['password']);
        $this->data['api_token'] = str_random(60);
    }


    public function afterCreate()
    {
        foreach (Arr::get($this->data, 'roles', []) as $role => $value) {
            $this->record->assignRole($role);
        }
        $this->uploadFile($this->request->file('avatar'), 'avatar');
    }

    public function beforeUpdate()
    {
        if (Arr::get($this->data, 'password') == '') {
            unset( $this->data['password'] );
        } else {
            $this->data['password'] = bcrypt($this->data['password']);
        }

    }

    public function afterUpdate()
    {
        foreach (Role::all() as $role) {
            $this->record->removeRole($role);
        }

        $this->afterCreate();
    }

}