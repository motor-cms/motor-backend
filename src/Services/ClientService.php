<?php

namespace Motor\Backend\Services;

use Illuminate\Support\Str;
use Motor\Backend\Models\Client;

/**
 * Class ClientService
 *
 * @package Motor\Backend\Services
 */
class ClientService extends BaseService
{
    protected $model = Client::class;

    function beforeCreate()
    {
        $this->createSlug();
    }

    function beforeUpdate()
    {
        $this->createSlug();
    }

    private function createSlug()
    {
        if ($this->data['slug'] == '') {
            $this->data['slug'] = Str::slug($this->data['name']);
        } else {
            $this->data['slug'] = Str::slug($this->data['slug']);
        }
    }
}
