<?php

namespace Motor\Backend\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Motor\Backend\Models\User;

/**
 * Class UserService
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
        if (Auth::user()->client_id > 0) {
            $this->record->client_id = Auth::user()->client_id;
        }

        $this->data['api_token'] = Str::random(60);

        $this->updatePassword();
    }

    public function afterCreate()
    {
        $this->syncRolesAndPermissions();
        $this->uploadFiles();
    }

    public function beforeUpdate()
    {
        // Special case to filter out the users api token when calling over the api
        if (Arr::get($this->data, 'api_token')) {
            unset($this->data['api_token']);
        }
        $this->updatePassword();
    }

    public function afterUpdate()
    {
        $this->syncRolesAndPermissions();
        $this->uploadFiles();
    }

    private function updatePassword()
    {
        if (Arr::get($this->data, 'password') == '') {
            unset($this->data['password']);
        } else {
            $this->data['password'] = bcrypt($this->data['password']);
        }
    }

    private function uploadFiles()
    {
        $this->uploadFile($this->request->file('avatar'), 'avatar');
    }

    private function syncRolesAndPermissions()
    {
        $this->record->syncRoles(Arr::get($this->data, 'roles', []));

        $this->record->syncPermissions(Arr::get($this->data, 'permissions', []));
    }
}
