<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                 => (int) $this->id,
            'name'               => $this->name,
            'slug'               => $this->slug,
            'address'            => $this->address,
            'zip'                => $this->zip,
            'city'               => $this->city,
            'country_iso_3166_1' => $this->country_iso_3166_1,
            'website'            => $this->website,
            'contact_name'       => $this->contact_name,
            'contact_phone'      => $this->contact_phone,
            'contact_email'      => $this->contact_email,
            'description'        => $this->description,
            'is_active'          => (bool) $this->is_active,

        ];
    }
}
