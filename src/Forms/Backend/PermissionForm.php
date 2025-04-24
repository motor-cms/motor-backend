<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\PermissionGroup;

/**
 * Class PermissionForm
 */
class PermissionForm extends Form
{
    /**
     * Define fields for PermissionForm
     *
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('permission_group_id', 'select', [
            'label' => trans('motor-backend::backend/permissions.group'),
            'rules' => 'required',
            'choices' => PermissionGroup::pluck('name', 'id')
                ->toArray(),
        ])
            ->add('name', 'text', ['label' => trans('motor-backend::backend/permissions.name'), 'rules' => 'required'])
            ->add('guard_name', 'text', [
                'label' => trans('motor-backend::backend/permissions.guard_name'),
                'default_value' => 'web',
                'rules' => 'required',
            ])
            ->add('submit', 'submit', [
                'attr' => ['class' => 'btn btn-primary'],
                'label' => trans('motor-backend::backend/permissions.save'),
            ]);
    }
}
