<?php

namespace Motor\Backend\Services;

use Motor\Backend\Models\Language;
use Motor\Core\Filter\Renderers\PerPageRenderer;
use Motor\Core\Filter\Renderers\SearchRenderer;

class LanguageService extends BaseService
{

    protected $model = Language::class;

    public function filters()
    {
        $this->filter->add(new SearchRenderer('search'));
        $this->filter->add(new PerPageRenderer('per_page'))->setup();
    }

}