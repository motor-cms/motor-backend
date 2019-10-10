<?php

namespace Motor\Backend\Transformers;

use League\Fractal;
use Motor\Backend\Models\Permission;

/**
 * Class PermissionTransformer
 * @package Motor\Backend\Transformers
 */
class PermissionTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'group'
    ];


    /**
     * @param Permission $record
     * @return array
     */
    public function transform(Permission $record)
    {
        return [
            'id'                  => (int) $record->id,
            'name'                => $record->name,
            'permission_group_id' => $record->permission_group_id,
        ];
    }


    /**
     * Include permission group
     *
     * @param Permission $record
     * @return Fractal\Resource\Item
     */
    public function includeGroup(Permission $record)
    {
        if (! is_null($record->group)) {
            return $this->item($record->group, new PermissionGroupTransformer());
        }
    }
}
