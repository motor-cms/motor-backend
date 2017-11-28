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
        // FIXME: hack for sort_positions
        $index = 0;
        if (isset($this->options['field'])) {
            if ($this->options['field'] == 'sort_position') {
                $index = 100;
            } else {
                $index = 1000;
            }
        }
        return view(Arr::get($this->options, 'template'), [ 'record' => $this->record, 'value' => $this->value, 'options' => $this->options, 'index' => $index ])->render();
    }
}