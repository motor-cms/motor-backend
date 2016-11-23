<?php

namespace Motor\Backend\Transformers;

use League\Fractal;
use Motor\Backend\Models\Role;

class RoleTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'permissions'
    ];

    public function transform(Role $record)
    {
        return [
            'id'   => (int) $record->id,
            'name' => $record->name
        ];
    }

    /**
     * Include Permissions
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includePermissions(Role $record)
    {
        $permissions = $record->permissions;
        if ( ! is_null($permissions)) {
            return $this->collection($permissions, new PermissionTransformer());
        }
    }
}