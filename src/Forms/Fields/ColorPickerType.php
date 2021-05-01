<?php

namespace Motor\Backend\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

/**
 * Class ColorPickerType
 *
 * @package Motor\Backend\Forms\Fields
 */
class ColorPickerType extends FormField
{
    /**
     * @return string
     */
    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'motor-backend::laravel-form-builder.colorpicker';
    }

    /**
     * @param array $options
     * @param bool $showLabel
     * @param bool $showField
     * @param bool $showError
     * @return string
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['attr'] = ['class' => 'form-control colorpicker'];

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
