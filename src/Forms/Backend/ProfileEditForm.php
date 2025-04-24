<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\User;

/**
 * Class ProfileEditForm
 */
class ProfileEditForm extends Form
{
    /**
     * Define fields for ProfileEditForm
     *
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('name', 'text', ['label' => trans('motor-backend::backend/users.name'), 'rules' => 'required'])
            ->add('password', 'repeated', [
                'type' => 'password',
                'first_options' => ['label' => trans('motor-backend::backend/users.password'), 'value' => ''],
                'second_options' => [
                    'label' => trans('motor-backend::backend/users.password_confirm'),
                    'value' => '',
                ],
            ])
            ->add('avatar', 'file_image', [
                'label' => trans('motor-backend::backend/global.image'),
                'model' => User::class,
            ])
            ->add('submit', 'submit', [
                'attr' => ['class' => 'btn btn-primary'],
                'label' => trans('motor-backend::backend/users.profile.save'),
            ]);
    }
}
