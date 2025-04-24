<?php

namespace Motor\Backend\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Core\Filter\Renderers\SearchRenderer;

/**
 * Class LanguageGrid
 */
class LanguageGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->addColumn('iso_639_1', trans('motor-backend::backend/languages.iso_639_1'));
        $this->addColumn('native_name', trans('motor-backend::backend/languages.native_name'), true);
        $this->addColumn('english_name', trans('motor-backend::backend/languages.english_name'), true);
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.languages.edit')
            ->needsPermissionTo('languages.write');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.languages.destroy')
            ->needsPermissionTo('languages.delete');

        $this->filter->add(new SearchRenderer('search'));
    }
}
