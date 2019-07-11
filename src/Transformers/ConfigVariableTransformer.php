<?php

namespace Motor\Backend\Transformers;

use League\Fractal;
use Motor\Backend\Models\ConfigVariable;

/**
 * Class ConfigVariableTransformer
 * @package Motor\Backend\Transformers
 */
class ConfigVariableTransformer extends Fractal\TransformerAbstract
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
     * @param ConfigVariable $record
     *
     * @return array
     */
    public function transform(ConfigVariable $record)
    {
        return [
            'id' => (int) $record->id
        ];
    }
}
