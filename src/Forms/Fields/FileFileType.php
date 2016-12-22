<?php

namespace Motor\Backend\Forms\Fields;

use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Fields\InputType;

class FileFileType extends InputType {

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'motor-backend::laravel-form-builder.file_file';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $modelData = $this->parent->getModel();

        // Check if we're in a child form
        $childForm = (!is_null($this->parent->getName()) ? true : false);

        if ($childForm) {
            if (isset($modelData[$this->parent->getName()]) && isset($modelData[$this->parent->getName()]['id'])) {
                $record = app($this->getOption('model'))::find($this->parent->getModel()[$this->parent->getName()]['id']);
                if (!is_null($record)) {
                    $items = $record->getMedia($this->getRealName());
                    if (isset($items[0])) {
                        $options['file_name'] = $items[0]->file_name;
                    }
                }
            }
        } elseif (is_object($modelData)) {
            $items = $modelData->getMedia($this->getRealName());
            if (isset($items[0])) {
                $options['file_name'] = $items[0]->file_name;
            }
        }


        $options['name_slug'] = Str::slug($this->getName());

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
