<?php

namespace Motor\Backend\Forms\Fields;

use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Fields\InputType;

/**
 * Class FileFileType
 * @package Motor\Backend\Forms\Fields
 */
class FileFileType extends InputType
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'motor-backend::laravel-form-builder.file_file';
    }


    /**
     * @param array $options
     * @param bool  $showLabel
     * @param bool  $showField
     * @param bool  $showError
     * @return string
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $modelData = $this->parent->getModel();

        // Check if we're in a child form
        //$childForm = ( ! is_null($this->parent->getName()) ? true : false );

        $options['files'] = [];

        //if ($childForm) {
        //    if (isset($modelData[$this->parent->getName()]) && isset($modelData[$this->parent->getName()]['id'])) {
        //        $record = app($this->getOption('model'))::find($this->parent->getModel()[$this->parent->getName()]['id']);
        //        if ( ! is_null($record)) {
        //            $items = $record->getMedia($this->getRealName());
        //            if (isset($items[0])) {
        //                $options['file_name'] = $items[0]->file_name;
        //            }
        //        }
        //    }
        //} elseif (is_object($modelData)) {
        //    $items            = $modelData->getMedia($this->getRealName())->reverse();
        //    if (!isset($options['files'])) {
        //        $options['files'] = [];
        //        foreach ($items as $item) {
        //            $options['files'][] = [
        //                'id'         => $item->id,
        //                'name'       => $item->file_name,
        //                'created_at' => $item->created_at
        //            ];
        //        }
        //    }
        //}

        if (is_object($modelData)) {
            $items = $modelData->getMedia($this->getRealName())->reverse();
            foreach ($items as $item) {
                $options['files'][] = [
                    'id'         => $item->id,
                    'name'       => $item->file_name,
                    'created_at' => $item->created_at
                ];
            }
        }

        $options['name']      = $this->getName();
        $options['name_slug'] = Str::slug($this->getName());

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
