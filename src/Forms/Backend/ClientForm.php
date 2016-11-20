<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

class ClientForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])
            ->add('slug', 'text', ['label' => trans('motor-backend::backend/clients.slug')])
            ->add('is_active', 'checkbox', ['label' => trans('motor-backend::backend/clients.is_active')])
            ->add('description', 'textarea', ['label' => trans('motor-backend::backend/clients.description')])

            ->add('zip', 'text', ['label' => trans('motor-backend::backend/global.address.zip')])
            ->add('city', 'text', ['label' => trans('motor-backend::backend/global.address.city')])
            ->add('country_iso_3166_1', 'select2', ['label' => trans('motor-backend::backend/global.address.country'), 'choices' => \Symfony\Component\Intl\Intl::getRegionBundle()->getCountryNames()])

            ->add('contact_name', 'text', ['label' => trans('motor-backend::backend/clients.contact')])
            ->add('contact_phone', 'text', ['label' => trans('motor-backend::backend/global.contact.phone')])
            ->add('contact_email', 'text', ['label' => trans('motor-backend::backend/global.contact.email')])
            ->add('website', 'text', ['label' => trans('motor-backend::backend/global.contact.website')])

            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('motor-backend::backend/clients.save')]);
    }
}
