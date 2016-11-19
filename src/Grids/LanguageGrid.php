<?php

namespace Motor\Backend\Grids;

use Motor\Core\Filter\Renderers\SearchRenderer;
use Motor\Backend\Grid\Grid;

class LanguageGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->addColumn('iso_639_1', trans('backend/languages.iso_639_1'));
        $this->addColumn('native_name', trans('backend/languages.native_name'), true);
        $this->addColumn('english_name', trans('backend/languages.english_name'), true);
        $this->addEditAction(trans('backend/global.edit'), 'backend.languages.edit');
        $this->addDeleteAction(trans('backend/global.delete'), 'backend.languages.destroy');

        $this->filter->add(new SearchRenderer('search'));
    }
}
