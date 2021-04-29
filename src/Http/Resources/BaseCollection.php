<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Support\Arr;

class BaseCollection extends BaseResourceCollection
{
    public function toArrayRecursive()
    {
        $resourceResponse = $this->toResponse(request());

        return Arr::get(json_decode($resourceResponse->getContent(), true), 'data');
    }
}
