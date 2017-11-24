<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Support\Arr;

class BladeRenderer
{

    protected $value = '';

    protected $options = [];

    protected $record;


    public function __construct($value, $options, $record = null)
    {
        $this->value   = $value;
        $this->options = $options;
        $this->record  = $record;
    }


    public function render()
    {
        return view(Arr::get($this->options, 'template'), [ 'record' => $this->record ])->render();
    }
}