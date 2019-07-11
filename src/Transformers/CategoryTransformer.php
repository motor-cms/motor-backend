<?php

namespace Motor\Backend\Transformers;

use League\Fractal;
use Motor\Backend\Models\Category;

/**
 * Class CategoryTransformer
 * @package Motor\Backend\Transformers
 */
class CategoryTransformer extends Fractal\TransformerAbstract
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
     * @param Category $record
     *
     * @return array
     */
    public function transform(Category $record)
    {
        return [
            'id'   => (int) $record->id,
            'name' => $record->name
        ];
    }
}
