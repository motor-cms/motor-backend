<?php

namespace Motor\Backend\Transformers;

use League\Fractal;
use Motor\Backend\Models\Client;

/**
 * Class ClientTransformer
 * @package Motor\Backend\Transformers
 */
class ClientTransformer extends Fractal\TransformerAbstract
{

    /**
     * @param Client $record
     * @return array
     */
    public function transform(Client $record)
    {
        return [
            'id'                 => (int) $record->id,
            'slug'               => $record->slug,
            'name'               => $record->name,
            'is_active'          => (bool) $record->is_active,
            'zip'                => $record->zip,
            'city'               => $record->city,
            'country_iso_3166_1' => $record->country_iso_3166_1,
            'website'            => $record->website,
            'contact_name'       => $record->contact_website,
            'contact_phone'      => $record->contact_phone,
            'contact_email'      => $record->contact_email,
            'description'        => $record->description
        ];
    }
}