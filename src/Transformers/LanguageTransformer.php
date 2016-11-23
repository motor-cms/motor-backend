<?php

namespace Motor\Backend\Transformers;

use League\Fractal;
use Motor\Backend\Models\Language;

class LanguageTransformer extends Fractal\TransformerAbstract
{

    public function transform(Language $record)
    {
        return [
            'id'           => (int) $record->id,
            'iso_639_1'    => $record->iso_639_1,
            'english_name' => $record->english_name,
            'native_name'  => $record->native_name
        ];
    }
}