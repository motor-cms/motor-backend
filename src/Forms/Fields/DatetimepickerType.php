<?php

namespace Motor\Backend\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class DatetimepickerType extends FormField {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'laravel-form-builder::datetimepicker';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['attr'] = ['class' => 'form-control datetimepicker'];

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
