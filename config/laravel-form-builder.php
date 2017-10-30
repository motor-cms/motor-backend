<?php

return [
    'defaults'        => [
        'wrapper_class'       => 'form-group',
        'wrapper_error_class' => 'has-error',
        'label_class'         => 'control-label',
        'field_class'         => 'form-control',
        'help_block_class'    => 'help-block',
        'error_class'         => 'text-danger',
        'required_class'      => 'required'
    ],
    // Templates
    'form'            => 'laravel-form-builder::form',
    'text'            => 'laravel-form-builder::text',
    'textarea'        => 'laravel-form-builder::textarea',
    'button'          => 'laravel-form-builder::button',
    'radio'           => 'laravel-form-builder::radio',
    'checkbox'        => 'laravel-form-builder::checkbox',
    'select'          => 'laravel-form-builder::select',
    'choice'          => 'laravel-form-builder::choice',
    'repeated'        => 'laravel-form-builder::repeated',
    'child_form'      => 'laravel-form-builder::child_form',
    'collection'      => 'laravel-form-builder::collection',
    'static'          => 'laravel-form-builder::static',

    // Remove the laravel-form-builder:: prefix above when using template_prefix
    'template_prefix' => '',

    'default_namespace' => '',

    'custom_fields' => [
        'datetimepicker'     => Motor\Backend\Forms\Fields\DatetimepickerType::class,
        'datepicker'         => Motor\Backend\Forms\Fields\DatepickerType::class,
        'select2'            => Motor\Backend\Forms\Fields\Select2Type::class,
        'file_image'         => Motor\Backend\Forms\Fields\FileImageType::class,
        'file_file'          => Motor\Backend\Forms\Fields\FileFileType::class,
        'checkboxcollection' => Motor\Backend\Forms\Fields\CheckboxCollectionType::class,
        'htmleditor'         => Motor\Backend\Forms\Fields\HtmlEditorType::class,
    ]
];
