<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

/**
 * Class CategoryForm
 *
 * @package Motor\Backend\Forms\Backend
 */
class CategoryForm extends Form
{
    /**
     * Define fields for CategoryForm
     *
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('parent_id', 'hidden')
             ->add('previous_sibling_id', 'hidden')
             ->add('next_sibling_id', 'hidden')
             ->add('name', 'text', ['label' => trans('motor-backend::backend/categories.name'), 'rules' => 'required'])
             ->add('submit', 'submit', [
                 'attr'  => ['class' => 'btn btn-primary'],
                 'label' => trans('motor-backend::backend/categories.save'),
             ]);
    }
}
