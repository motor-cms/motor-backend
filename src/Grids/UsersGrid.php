<?php

namespace Motor\Backend\Grids;

use Motor\Backend\Grid\Grid;

/**
 * Class UsersGrid
 * @package Motor\Backend\Grids
 */
class UsersGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->addColumn('name', trans('motor-backend::backend/users.name'), true);
        $this->addColumn('email', trans('motor-backend::backend/users.email'), true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.users.edit')
             ->needsPermissionTo('users.write');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.users.destroy')
             ->needsPermissionTo('users.delete');
    }
}
