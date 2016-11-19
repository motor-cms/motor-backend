<?php

namespace Motor\Backend\Grids;

use Motor\Core\Filter\Renderers\SearchRenderer;
use Motor\Backend\Grid\Grid;

class EmailTemplateGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->addColumn('client.name', trans('backend/clients.client'));
        $this->addColumn('language.iso_639_1', trans('backend/languages.language'));
        $this->addColumn('name', trans('backend/global.name'), true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addEditAction(trans('backend/global.edit'), 'backend.email_templates.edit');
        $this->addDuplicateAction(trans('backend/global.duplicate'), 'backend.email_templates.duplicate');
        $this->addDeleteAction(trans('backend/global.delete'), 'backend.email_templates.destroy');

        $this->filter->add(new SearchRenderer('search'));
        $this->filter->addClientFilter();
    }
}
