<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\Language;

class EmailTemplateForm extends Form
{
    public function buildForm()
    {
        $clients = config('motor-backend.models.client')::lists('name', 'id')->toArray();
        $this
            ->add('client_id', 'select', ['label' => trans('motor-backend::backend/clients.client'), 'rules' => 'required', 'choices' => $clients])
            ->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])
            ->add('language_id', 'select', ['label' => trans('motor-backend::backend/languages.language'), 'rules' => 'required', 'choices' => Language::lists('native_name', 'id')->toArray()])

            ->add('subject', 'text', ['label' => trans('motor-backend::backend/email_templates.subject'), 'rules' => 'required'])
            ->add('default_sender_name', 'text', ['label' => trans('motor-backend::backend/email_templates.default_sender_name')])
            ->add('default_sender_email', 'text', ['label' => trans('motor-backend::backend/email_templates.default_sender_email')])
            ->add('default_recipient_name', 'text', ['label' => trans('motor-backend::backend/email_templates.default_recipient_name')])
            ->add('default_recipient_email', 'text', ['label' => trans('motor-backend::backend/email_templates.default_recipient_email')])
            ->add('default_cc_email', 'text', ['label' => trans('motor-backend::backend/email_templates.default_cc_email')])
            ->add('default_bcc_email', 'text', ['label' => trans('motor-backend::backend/email_templates.default_bcc_email')])
            ->add('body_text', 'textarea', ['label' => trans('motor-backend::backend/email_templates.body_text')])
            ->add('body_html', 'textarea', ['label' => trans('motor-backend::backend/email_templates.body_html')])

            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('motor-backend::backend/email_templates.save')]);
    }
}
