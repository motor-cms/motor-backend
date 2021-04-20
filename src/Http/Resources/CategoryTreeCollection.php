<?php

namespace Motor\Backend\Resources\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryTreeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
