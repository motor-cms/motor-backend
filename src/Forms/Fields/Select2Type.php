<?php

namespace Motor\Backend\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\SelectType;

/**
 * Class Select2Type
 */
class Select2Type extends SelectType
{
    /**
     * @return string
     */
    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'motor-backend::laravel-form-builder.select2';
    }

    /**
     * @param  bool  $showLabel
     * @param  bool  $showField
     * @param  bool  $showError
     * @return string
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        return parent::render($options, $showLabel, $showField, $showError);
    }
}
