<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

class PermissionForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('permission_group_id', 'select', ['label' => trans('motor-backend::backend/permissions.group'), 'rules' => 'required', 'choices' => \Motor\Backend\Models\PermissionGroup::lists('name', 'id')->toArray()])
            ->add('name', 'text', ['label' => trans('motor-backend::backend/permissions.name'), 'rules' => 'required'])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('motor-backend::backend/permissions.save')]);
    }
}
