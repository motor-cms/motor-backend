<?php

namespace Motor\Backend\Grids;

use Motor\Backend\Grid\Grid;

class RoleGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addColumn('name', trans('backend/roles.name'));
        $this->addEditAction(trans('backend/global.edit'), 'backend.roles.edit');
        $this->addDeleteAction(trans('backend/global.delete'), 'backend.roles.destroy');
    }
}
