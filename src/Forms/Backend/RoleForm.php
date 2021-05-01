<?php

namespace Motor\Backend\Forms\Backend;

use Illuminate\Database\Eloquent\Collection;
use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\Permission;

/**
 * Class RoleForm
 *
 * @package Motor\Backend\Forms\Backend
 */
class RoleForm extends Form
{
    /**
     * Define fields for RoleForm
     *
     * @return mixed|void
     */
    public function buildForm()
    {
        $selected = [];
        if (is_object($this->model) && $this->model->permissions instanceof Collection) {
            foreach ($this->model->permissions as $permission) {
                $selected[] = $permission->id;
            }
        }

        $this->add('name', 'text', ['label' => trans('motor-backend::backend/roles.name'), 'rules' => 'required'])
             ->add('guard_name', 'text', [
                 'label'         => trans('motor-backend::backend/roles.guard_name'),
                 'default_value' => 'web',
                 'rules'         => 'required',
             ])
             ->add('permissions', 'choice', [
                 'label'          => trans('motor-backend::backend/permissions.permissions'),
                 'choice_options' => [
                     'wrapper'    => ['class' => 'choice-wrapper'],
                     'label_attr' => ['class' => 'label-class'],
                 ],
                 'selected'       => $selected,
                 'expanded'       => true,
                 'multiple'       => true,
                 'choices'        => Permission::pluck('name', 'id')
                                               ->toArray(),
             ])
             ->add('submit', 'submit', [
                 'attr'  => ['class' => 'btn btn-primary'],
                 'label' => trans('motor-backend::backend/roles.save'),
             ]);
    }
}
