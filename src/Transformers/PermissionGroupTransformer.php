<?php

namespace Motor\Backend\Transformers;

use League\Fractal;
use Motor\Backend\Models\PermissionGroup;

class PermissionGroupTransformer extends Fractal\TransformerAbstract
{

    public function transform(PermissionGroup $record)
    {
        return [
            'id'            => (int) $record->id,
            'name'          => $record->name,
            'sort_position' => (int) $record->sort_position
        ];
    }
}