<?php

namespace Motor\Backend\Services;

use Illuminate\Support\Str;
use Motor\Backend\Models\Client;

/**
 * Class ClientService
 */
class ClientService extends BaseService
{
    protected $model = Client::class;

    public function beforeCreate()
    {
        $this->createSlug();
    }

    public function beforeUpdate()
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
