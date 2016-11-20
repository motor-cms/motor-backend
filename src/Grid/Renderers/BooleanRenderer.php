<?php

namespace Motor\Backend\Grid\Renderers;

class BooleanRenderer
{

    protected $value = '';

    protected $options = [ ];


    public function __construct($value, $options)
    {
        $this->value   = $value;
        $this->options = $options;
    }


    public function render()
    {
        if ($this->value == true) {
            return trans('motor-backend::backend/global.yes');
        }
        return trans('motor-backend::backend/global.no');
    }
}