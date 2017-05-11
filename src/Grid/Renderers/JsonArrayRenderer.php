<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Support\Arr;

class JsonArrayRenderer
{

    protected $value = '';

    protected $options = [];

    protected $record;

    protected $defaultCurrency = 'EUR';


    public function __construct($value, $options = [], $record = null)
    {
        $this->value   = $value;
        $this->options = $options;
        $this->record  = $record;
    }


    public function render()
    {
        if ($this->value == '' || $this->value == null || $this->value == 'null') {
            return '';
        }

        $values = json_decode(html_entity_decode($this->value), true);
        if (isset($this->options['translation_file'])) {
            foreach($values as $key => $value) {
                $values[$key] = trans($this->options['translation_file'].'.'.$value);
            }
        }
        return implode(', ', $values);

    }
}