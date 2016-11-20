<?php

namespace Motor\Backend\Grids;

use Motor\Backend\Grid\Grid;

class PermissionGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addColumn('name', trans('motor-backend::backend/roles.name'));
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.permissions.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.permissions.destroy');
    }
}
