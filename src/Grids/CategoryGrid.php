<?php

namespace Motor\Backend\Grids;

use Motor\Backend\Grid\Grid;
use Motor\CMS\Grid\Renderers\TreeRenderer;

class CategoryGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('name', trans('motor-backend::backend/categories.name'))->renderer(TreeRenderer::class);

        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.categories.edit')->onCondition('parent_id', null, '!=');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.categories.destroy')->onCondition('parent_id', null, '!=');
    }
}
