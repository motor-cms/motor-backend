<?php

namespace Motor\Backend\Transformers;

use League\Fractal;
use Motor\Backend\Models\PermissionGroup;

/**
 * Class PermissionGroupTransformer
 * @package Motor\Backend\Transformers
 */
class PermissionGroupTransformer extends Fractal\TransformerAbstract
{

    /**
     * @param PermissionGroup $record
     * @return array
     */
    public function transform(PermissionGroup $record)
    {
        return [
            'id'            => (int) $record->id,
            'name'          => $record->name,
            'sort_position' => (int) $record->sort_position
        ];
    }
}