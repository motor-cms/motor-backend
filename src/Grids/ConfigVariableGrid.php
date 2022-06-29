<?php

namespace Motor\Backend\Grids;

use Motor\Backend\Grid\Grid;

/**
 * Class ConfigVariableGrid
 */
class ConfigVariableGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('package', trans('motor-backend::backend/config_variables.package'), true);
        $this->addColumn('group', trans('motor-backend::backend/config_variables.group'), true);
        $this->addColumn('name', trans('motor-backend::backend/config_variables.name'), true);
        $this->addColumn('value', trans('motor-backend::backend/config_variables.value'), true);
        $this->setDefaultSorting('package', 'ASC');
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.config_variables.edit');
        $this->addDuplicateAction(trans('motor-backend::backend/global.duplicate'), 'backend.config_variables.duplicate')
             ->needsPermissionTo('config_variables.write');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.config_variables.destroy');
    }
}
