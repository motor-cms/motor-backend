<?php

namespace Motor\Backend\Services;

use Illuminate\Support\Arr;
use Motor\Backend\Models\Permission;
use Motor\Backend\Models\Role;

class RoleService extends BaseService
{

    protected $model = Role::class;


    public function afterCreate()
    {
        foreach (Arr::get($this->data, 'permissions', []) as $key => $permission) {
            $this->record->givePermissionTo(Permission::find((int)$permission));
        }
    }


    public function afterUpdate()
    {
        foreach (Permission::all() as $permission) {
            $this->record->revokePermissionTo($permission);
        }

        $this->afterCreate();

    }

}