<?php

namespace Motor\Backend\Forms\Backend;

use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Models\Client;
use Motor\Backend\Models\Language;

class EmailTemplateForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('client_id', 'select', ['label' => trans('backend/clients.client'), 'rules' => 'required', 'choices' => Client::lists('name', 'id')->toArray()])
            ->add('name', 'text', ['label' => trans('backend/global.name'), 'rules' => 'required'])
            ->add('language_id', 'select', ['label' => trans('backend/languages.language'), 'rules' => 'required', 'choices' => Language::lists('native_name', 'id')->toArray()])

            ->add('subject', 'text', ['label' => trans('backend/email_templates.subject'), 'rules' => 'required'])
            ->add('default_sender_name', 'text', ['label' => trans('backend/email_templates.default_sender_name')])
            ->add('default_sender_email', 'text', ['label' => trans('backend/email_templates.default_sender_email')])
            ->add('default_recipient_name', 'text', ['label' => trans('backend/email_templates.default_recipient_name')])
            ->add('default_recipient_email', 'text', ['label' => trans('backend/email_templates.default_recipient_email')])
            ->add('default_cc_email', 'text', ['label' => trans('backend/email_templates.default_cc_email')])
            ->add('default_bcc_email', 'text', ['label' => trans('backend/email_templates.default_bcc_email')])
            ->add('body_text', 'textarea', ['label' => trans('backend/email_templates.body_text')])
            ->add('body_html', 'textarea', ['label' => trans('backend/email_templates.body_html')])

            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('backend/email_templates.save')]);
    }
}
