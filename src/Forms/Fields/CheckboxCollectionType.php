<?php

namespace Motor\Backend\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\CollectionType;

class CheckboxCollectionType extends CollectionType
{

    /**
     * @inheritdoc
     */
    protected function createChildren()
    {
        $this->children = [];
        $type = $this->getOption('type');
        $oldInput = $this->parent->getRequest()->old($this->getNameKey());
        $currentInput = $this->parent->getRequest()->get($this->getNameKey());

        try {
            $fieldType = $this->formHelper->getFieldType($type);
        } catch (\Exception $e) {
            throw new \Exception(
                'Collection field ['.$this->name.'] requires [type] option'. "\n\n".
                $e->getMessage()
            );
        }

        $data = $this->getOption('collection', []);

        // If no value is provided, get values from current request
        if (count($data) === 0) {
            $data = $currentInput;
        }

        // Needs to have more than 1 item because 1 is rendered by default.
        // This overrides current request in situations when validation fails.
        if (count($oldInput) > 1) {
            $data = $oldInput;
        }

        if ($data instanceof Collection) {
            $data = $data->all();
        }

        $field = new $fieldType($this->name, $type, $this->parent, $this->getOption('options'));

        if ($this->getOption('prototype')) {
            $this->generatePrototype(clone $field);
        }

        if (!$data || empty($data)) {
            if ($this->getOption('empty_row')) {
                return $this->children[] = $this->setupChild(clone $field, '[0]');
            }

            return $this->children = [];
        }

        if (!is_array($data) && !$data instanceof \Traversable) {
            throw new \Exception(
                'Data for collection field ['.$this->name.'] must be iterable.'
            );
        }

        foreach ($data as $key => $val) {

            $value = false;

            $modelData = $this->getOption($this->valueProperty, []);

            // If no value is provided, get values from current request
            if (count($modelData) === 0) {
                $modelData = $currentInput;
            }

            // Needs to have more than 1 item because 1 is rendered by default.
            // This overrides current request in situations when validation fails.
            if (count($oldInput) > 1) {
                $modelData = $oldInput;
            }

            if ($modelData instanceof Collection) {
                $modelData = $data->all();
            }

            if (!is_object($modelData) && !is_array($modelData)) {
                $modelData = [];
            }

            // Check for actual value
            foreach ($modelData as $dataKey => $dataValue) {
                if (is_object($dataValue)) {
                    $newValue = $dataValue->id;
                } else {
                    $newValue = $dataValue;
                }
                if ($newValue == $val) {
                    $value = '1';
                }
            }

            $options          = $this->getOption('options');
            $options['label'] = $key;
            $this->setOption('options', $options);

            $this->children[] = $this->setupChild(clone $field, '['.$key.']', $value);
        }
    }
}
