<?php

namespace Motor\Backend\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Core\Filter\Renderers\SearchRenderer;

/**
 * Class PermissionGrid
 */
class PermissionGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addColumn('group.name', trans('motor-backend::backend/permissions.group'));
        $this->addColumn('name', trans('motor-backend::backend/permissions.name'));
        $this->addColumn('guard_name', trans('motor-backend::backend/roles.guard_name'));
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.permissions.edit')
            ->needsPermissionTo('permissions.write');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.permissions.destroy')
            ->needsPermissionTo('permissions.delete');

        $this->filter->add(new SearchRenderer('search'));
    }
}
