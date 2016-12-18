<?php

namespace Motor\Backend\Transformers;

use League\Fractal;
use Motor\Backend\Models\CategoryTree;

class CategoryTreeTransformer extends Fractal\TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];


    /**
     * Transform record to array
     *
     * @param CategoryTree $record
     *
     * @return array
     */
    public function transform(CategoryTree $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
