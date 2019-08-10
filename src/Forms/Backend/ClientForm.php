<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Symfony\Component\Intl\Countries;

/**
 * Class ClientForm
 * @package Motor\Backend\Forms\Backend
 */
class ClientForm extends Form
{

    /**
     * Define fields for ClientForm
     *
     * @return mixed|void
     */
    public function buildForm()
    {
        $this->add('name', 'text', [ 'label' => trans('motor-backend::backend/global.name'), 'rules' => 'required' ])
             ->add('slug', 'text', [ 'label' => trans('motor-backend::backend/clients.slug') ])
             ->add('is_active', 'checkbox', [ 'label' => trans('motor-backend::backend/clients.is_active') ])
             ->add('description', 'textarea', [ 'label' => trans('motor-backend::backend/clients.description') ])
             ->add('address', 'text', [ 'label' => trans('motor-backend::backend/global.address.address_1') ])
             ->add('zip', 'text', [ 'label' => trans('motor-backend::backend/global.address.zip') ])
             ->add('city', 'text', [ 'label' => trans('motor-backend::backend/global.address.city') ])
             ->add('country_iso_3166_1', 'select2', [
                 'label'   => trans('motor-backend::backend/global.address.country'),
                 'choices' => Countries::getNames()
             ])
             ->add('contact_name', 'text', [ 'label' => trans('motor-backend::backend/clients.contact') ])
             ->add('contact_phone', 'text', [ 'label' => trans('motor-backend::backend/global.contact.phone') ])
             ->add('contact_email', 'text', [ 'label' => trans('motor-backend::backend/global.contact.email') ])
             ->add('website', 'text', [ 'label' => trans('motor-backend::backend/global.contact.website') ])
             ->add('submit', 'submit', [
                 'attr'  => [ 'class' => 'btn btn-primary' ],
                 'label' => trans('motor-backend::backend/clients.save')
             ]);
    }
}
