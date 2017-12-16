<?php

namespace Motor\Backend\Forms\Backend;

use Illuminate\Database\Eloquent\Collection;
use Motor\Backend\Models\Role;
use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\User;

class UserForm extends Form
{
    public function buildForm()
    {
        $selected = [];
        if (is_object($this->model) && $this->model->roles instanceof Collection) {
            foreach ($this->model->roles as $role) {
                $selected[] = $role->id;
            }
        }

        $clients = config('motor-backend.models.client')::pluck('name', 'id')->toArray();
        $this
            ->add('client_id', 'select', ['label' => trans('motor-backend::backend/clients.client'), 'choices' => $clients, 'empty_value' => trans('motor-backend::backend/global.all')])
            ->add('name', 'text', ['label' => trans('motor-backend::backend/users.name'), 'rules' => 'required'])
            ->add('email', 'text', ['label' => trans('motor-backend::backend/users.email'), 'rules' => 'required'])
            ->add('password', 'password', ['value' => '', 'label' => trans('motor-backend::backend/users.password')])
            ->add('avatar', 'file_image', ['label' =>  trans('motor-backend::backend/global.image'), 'model' => User::class])
            ->add('roles', 'choice', [
                'label' => trans('motor-backend::backend/roles.roles'),
                'choice_options' => [
                    'wrapper'    => [ 'class' => 'choice-wrapper' ],
                    'label_attr' => [ 'class' => 'label-class' ],
                ],
                'selected' => $selected,
                'expanded' => true,
                'multiple' => true,
                'choices' => Role::pluck('name', 'id')->toArray(),
            ])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('motor-backend::backend/users.save')]);
    }
}
