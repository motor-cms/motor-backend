<?php

namespace Motor\Backend\Forms\Backend;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Motor\Backend\Models\Role;
use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\User;

/**
 * Class UserForm
 *
 * @package Motor\Backend\Forms\Backend
 */
class UserForm extends Form
{
    /**
     * Define fields for UserForm
     *
     * @return mixed|void
     */
    public function buildForm()
    {
        $selectedRoles = [];
        $roles = Role::pluck('name', 'id')
                     ->toArray();

        if (is_object($this->model) && $this->model->roles instanceof Collection) {
            foreach ($this->model->roles as $role) {
                $selectedRoles[] = $role->id;
            }
        }

        if (Auth::user()->client_id > 0) {
            $roles = Auth::user()
                         ->roles()
                         ->pluck('name', 'id')
                         ->toArray();
        }

        if (is_null(Auth::user()->client_id)) {
            $this->add('client_id', 'select', [
                'label'       => trans('motor-backend::backend/clients.client'),
                'choices'     => config('motor-backend.models.client')::orderBy('name', 'asc')
                                                                      ->pluck('name', 'id')
                                                                      ->toArray(),
                'empty_value' => trans('motor-backend::backend/global.all'),
            ]);
        }

        $this->add('name', 'text', ['label' => trans('motor-backend::backend/users.name'), 'rules' => 'required'])
             ->add('email', 'text', ['label' => trans('motor-backend::backend/users.email'), 'rules' => 'required'])
             ->add('password', 'password', ['value' => '', 'label' => trans('motor-backend::backend/users.password')])
             ->add('avatar', 'file_image', [
                 'label' => trans('motor-backend::backend/global.image'),
                 'model' => User::class,
             ]);

        if (count($roles)) {
            $this->add('roles', 'choice', [
                'label'          => trans('motor-backend::backend/roles.roles'),
                'choice_options' => [
                    'wrapper'    => ['class' => 'choice-wrapper'],
                    'label_attr' => ['class' => 'label-class'],
                ],
                'selected'       => $selectedRoles,
                'expanded'       => true,
                'multiple'       => true,
                'choices'        => $roles,
            ]);
        }

        $this->add('submit', 'submit', [
            'attr'  => ['class' => 'btn btn-primary'],
            'label' => trans('motor-backend::backend/users.save'),
        ]);
    }
}
