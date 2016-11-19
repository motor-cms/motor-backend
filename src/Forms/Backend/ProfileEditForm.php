<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\User;

class ProfileEditForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => trans('backend/users.name'), 'rules' => 'required'])
            ->add('password', 'repeated', ['type' => 'password', 'first_options' => ['label' => trans('backend/users.password'), 'value' => ''], 'second_options' => ['label' => trans('backend/users.password_confirm'), 'value' => '']])
            ->add('avatar', 'file_image', ['label' =>  trans('backend/global.image'), 'model' => User::class])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('backend/users.profile.save')]);
    }
}
