<?php

namespace Motor\Backend\Grid\Renderers;

class TreeRenderer
{

    protected $value = '';

    protected $options = [];

    protected $record;


    public function __construct($value, $options = [], $record = null)
    {
        $this->value   = $value;
        $this->options = $options;
        $this->record  = $record;
    }


    public function render()
    {
        $returnValue = '';
        $ancestors = (int)$this->record->ancestors()->count();
        while ($ancestors > 1) {
            $returnValue .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $ancestors--;
        }

        return $returnValue.$this->value;
    }
}