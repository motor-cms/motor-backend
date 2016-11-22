<?php

namespace Motor\Backend\Services;

use Motor\Backend\Models\Client;
use Motor\Core\Filter\Renderers\PerPageRenderer;
use Motor\Core\Filter\Renderers\SearchRenderer;

class ClientService extends BaseService
{

    protected $model = Client::class;

    public function filters()
    {
        $this->filter->add(new SearchRenderer('search'));
        $this->filter->add(new PerPageRenderer('per_page'))->setup();
    }

}