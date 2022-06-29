<?php

namespace Motor\Backend\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Core\Filter\Renderers\SearchRenderer;

/**
 * Class EmailTemplateGrid
 */
class EmailTemplateGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->addColumn('client.name', trans('motor-backend::backend/clients.client'));
        $this->addColumn('language.iso_639_1', trans('motor-backend::backend/languages.language'));
        $this->addColumn('name', trans('motor-backend::backend/global.name'), true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.email_templates.edit')
             ->needsPermissionTo('email_templates.write');
        $this->addDuplicateAction(trans('motor-backend::backend/global.duplicate'), 'backend.email_templates.duplicate')
             ->needsPermissionTo('email_templates.write');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.email_templates.destroy')
             ->needsPermissionTo('email_templates.delete');

        $this->filter->add(new SearchRenderer('search'));
        $this->filter->addClientFilter();
    }
}
