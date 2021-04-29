<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class BaseResourceCollection extends ResourceCollection
{
    public function toArrayRecursive()
    {
        $resourceResponse = $this->toResponse(request());

        return Arr::get(json_decode($resourceResponse->getContent(), true), 'data');
    }
}
