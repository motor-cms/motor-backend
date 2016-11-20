<?php

namespace Motor\Backend\Forms\Backend;

use Motor\Backend\Models\Permission;
use Kris\LaravelFormBuilder\Form;

class RoleForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => trans('motor-backend::backend/roles.name'), 'rules' => 'required'])
            ->add('permissions', 'checkboxcollection', [
                'type' => 'checkbox',
                'label' => trans('motor-backend::backend/permissions.permissions'),
                'property' => 'id',    // Which property to use on the tags model for value, defualts to id
                'collection' => Permission::lists('id', 'name')->toArray(),
                'data' => null, //Permission::lists('name', 'id')->toArray(),            // Data is automatically bound from model, here we can override it
                'options' => [    // these are options for a single type
                    'label' => false,
                    'attr' => ['class' => 'permission']
                ]
            ])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('motor-backend::backend/roles.save')]);

    }
}
