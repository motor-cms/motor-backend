<?php

namespace Motor\Backend\Grids;

use Motor\Core\Filter\Renderers\SearchRenderer;
use Motor\Backend\Grid\Grid;

class ClientGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->addColumn('name', trans('backend/clients.name'), true);
        $this->addColumn('contact_name', trans('backend/clients.contact'));
        $this->setDefaultSorting('id', 'ASC');
        $this->addEditAction(trans('backend/global.edit'), 'backend.clients.edit');
        $this->addDeleteAction(trans('backend/global.delete'), 'backend.clients.destroy');

        $this->filter->add(new SearchRenderer('search'));
    }
}
