<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Support\Facades\App;

class DecorationRenderer
{

    protected $value = '';

    protected $options = [];


    public function __construct($value, $options = [])
    {
        $this->value   = $value;
        $this->options = $options;
    }


    public function render()
    {
        return App::make('html')->tag('span', $this->value, $this->options);
    }
}