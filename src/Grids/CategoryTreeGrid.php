<?php

namespace Motor\Backend\Grids;

use Motor\Backend\Grid\Grid;

/**
 * Class CategoryTreeGrid
 * @package Motor\Backend\Grids
 */
class CategoryTreeGrid extends Grid
{
    protected function setup()
    {
        $this->addColumn('name', trans('motor-backend::backend/categories.name'));
        $this->addAction(
            trans('motor-backend::backend/category_trees.show_nodes'),
            'backend.categories.index',
            [ 'class' => 'btn-primary' ]
        );
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.category_trees.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.category_trees.destroy');
    }
}
