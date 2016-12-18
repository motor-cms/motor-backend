<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

class CategoryTreeForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => trans('motor-backend::backend/categories.name'), 'rules' => 'required'])
            ->add('scope', 'text', ['label' => trans('motor-backend::backend/category_trees.scope'), 'rules' => 'required'])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('motor-backend::backend/category_trees.save')]);
    }
}
