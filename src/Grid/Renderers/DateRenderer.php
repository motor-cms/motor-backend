<?php

namespace Motor\Backend\Grid\Renderers;

use Carbon\Carbon;

class DateRenderer
{

    protected $value = '';

    protected $options = [ ];

    protected $defaultFormat = 'Y-m-d H:i:s';


    public function __construct($value, $options = [])
    {
        $this->value   = $value;
        $this->options = $options;
    }


    public function render()
    {
        if ($this->value == '' || $this->value == null) {
            return '';
        }

        $date = Carbon::parse($this->value);

        if (isset($this->options['format'])) {
            return $date->format($this->options['format']);
        }
        return $date->format($this->defaultFormat);
    }
}