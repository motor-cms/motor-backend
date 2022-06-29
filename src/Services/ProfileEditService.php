<?php

namespace Motor\Backend\Services;

use Illuminate\Support\Arr;
use Motor\Backend\Models\User;

/**
 * Class ProfileEditService
 */
class ProfileEditService extends BaseService
{
    protected $model = User::class;

    public function beforeUpdate()
    {
        if (Arr::get($this->data, 'password') == '') {
            unset($this->data['password']);
        } else {
            $this->data['password'] = bcrypt($this->data['password']);
        }
    }

    public function afterUpdate()
    {
        $this->uploadFile($this->request->file('avatar'), 'avatar');
    }
}
