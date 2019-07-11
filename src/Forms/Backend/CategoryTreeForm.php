<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

/**
 * Class CategoryTreeForm
 * @package Motor\Backend\Forms\Backend
 */
class CategoryTreeForm extends Form
{

    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('name', 'text',
                [ 'label' => trans('motor-backend::backend/categories.name'), 'rules' => 'required' ])
             ->add('scope', 'text',
                 [ 'label' => trans('motor-backend::backend/category_trees.scope'), 'rules' => 'required' ])
             ->add('submit', 'submit', [
                 'attr'  => [ 'class' => 'btn btn-primary' ],
                 'label' => trans('motor-backend::backend/category_trees.save')
             ]);
    }
}
