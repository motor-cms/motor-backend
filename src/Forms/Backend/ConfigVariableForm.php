<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

/**
 * Class ConfigVariableForm
 * @package Motor\Backend\Forms\Backend
 */
class ConfigVariableForm extends Form
{

    /**
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('package', 'text',
                [ 'label' => trans('motor-backend::backend/config_variables.package'), 'rules' => 'required' ])
             ->add('group', 'text',
                 [ 'label' => trans('motor-backend::backend/config_variables.group'), 'rules' => 'required' ])
             ->add('name', 'text',
                 [ 'label' => trans('motor-backend::backend/config_variables.name'), 'rules' => 'required' ])
             ->add('value', 'text',
                 [ 'label' => trans('motor-backend::backend/config_variables.value'), 'rules' => 'required' ])
             ->add('submit', 'submit', [
                 'attr'  => [ 'class' => 'btn btn-primary' ],
                 'label' => trans('motor-backend::backend/config_variables.save')
             ]);
    }
}
