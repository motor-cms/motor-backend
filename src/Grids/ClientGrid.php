<?php

namespace Motor\Backend\Grids;

use Motor\Core\Filter\Renderers\SearchRenderer;
use Motor\Backend\Grid\Grid;

class ClientGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->addColumn('name', trans('motor-backend::backend/clients.name'), true);
        $this->addColumn('contact_name', trans('motor-backend::backend/clients.contact'));
        $this->setDefaultSorting('id', 'ASC');
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.clients.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.clients.destroy');

        $this->filter->add(new SearchRenderer('search'));
    }
}
