<?php

namespace Motor\Backend\Forms\Fields;

use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Fields\InputType;

class FileImageType extends InputType
{

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'motor-backend::laravel-form-builder.file_image';
    }


    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $modelData = $this->parent->getModel();

        // Check if we're in a child form
        //$childForm = ( ! is_null($this->parent->getName()) ? true : false );

        $options['files'] = [];

        //if ($childForm) {
        //    dd($this->parent->getModel());
        //    if (isset($modelData[$this->parent->getName()]) && isset($modelData[$this->parent->getName()]['id'])) {
        //        $record = app($this->getOption('model'))::find($this->parent->getModel()[$this->parent->getName()]['id']);
        //        if ( ! is_null($record)) {
        //            $items            = $record->getMedia($this->getRealName())->reverse();
        //            foreach ($items as $item) {
        //                $options['files'][] = [
        //                    'id'         => $item->id,
        //                    'name'       => $item->file_name,
        //                    'image'      => $item->getUrl('thumb'),
        //                    'preview'    => $item->getUrl('preview'),
        //                    'created_at' => $item->created_at
        //                ];
        //            }
        //        }
        //    }
        //} elseif (is_object($modelData)) {
            $items            = $modelData->getMedia($this->getRealName())->reverse();
            foreach ($items as $item) {
                $options['files'][] = [
                    'id'         => $item->id,
                    'name'       => $item->file_name,
                    'image'      => $item->getUrl('thumb'),
                    'preview'    => $item->getUrl('preview'),
                    'created_at' => $item->created_at
                ];
            }
        //}

        $options['name']      = $this->getName();
        $options['name_slug'] = Str::slug($this->getName());

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
