<?php

namespace Motor\Backend\Forms\Fields;

use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Fields\InputType;
use Motor\Backend\Helpers\MediaHelper;
use Motor\Media\Transformers\FileTransformer;

class FileAssociationType extends InputType
{

    protected function getTemplate()
    {
        // At first it tries to load config variable,
        // and if fails falls back to loading view
        // resources/views/fields/datetime.blade.php
        return 'motor-backend::laravel-form-builder.file_association';
    }


    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $modelData = $this->parent->getModel();

        $options['file_association'] = false;

        if (is_object($modelData)) {
            $fileAssociation = $modelData->file_associations()->where('identifier', $this->getRealName())->first();
            if (!is_null($fileAssociation)) {
                $data = fractal($fileAssociation->file, new FileTransformer())->toArray();

                $options['file_association'] = json_encode($data['data']);
            }
        }

        $options['name'] = $this->getName();
        $options['name_slug'] = Str::slug($this->getName());

        return parent::render($options, $showLabel, $showField, $showError);
    }
}
