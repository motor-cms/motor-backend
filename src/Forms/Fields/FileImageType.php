<?php

namespace Motor\Backend\Forms\Fields;

use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Fields\InputType;

/**
 * Class FileImageType
 */
class FileImageType extends InputType
{
    /**
     * @return string
     */
    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'motor-backend::laravel-form-builder.file_image';
    }

    /**
     * @param  array  $options
     * @param  bool  $showLabel
     * @param  bool  $showField
     * @param  bool  $showError
     * @return string
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $modelData = $this->parent->getModel();

        $options['files'] = [];

        if (is_object($modelData)) {
            $items = $modelData->getMedia($this->getRealName())
                               ->reverse();
            foreach ($items as $item) {
                $options['files'][] = [
                    'id'         => $item->id,
                    'name'       => $item->file_name,
                    'image'      => $item->getUrl('thumb'),
                    'preview'    => $item->getUrl('preview'),
                    'created_at' => $item->created_at,
                ];
            }
        }
        //}

        $options['name'] = $this->getName();
        $options['name_slug'] = Str::slug($this->getName());

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
