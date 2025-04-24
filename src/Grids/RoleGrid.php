<?php

namespace Motor\Backend\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Core\Filter\Renderers\SearchRenderer;

/**
 * Class RoleGrid
 */
class RoleGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addColumn('name', trans('motor-backend::backend/roles.name'));
        $this->addColumn('guard_name', trans('motor-backend::backend/roles.guard_name'));
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.roles.edit')
            ->needsPermissionTo('roles.write');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.roles.destroy')
            ->needsPermissionTo('roles.delete');

        $this->filter->add(new SearchRenderer('search'));
    }
}
