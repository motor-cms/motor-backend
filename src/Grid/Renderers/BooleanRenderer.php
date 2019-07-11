<?php

namespace Motor\Backend\Grid\Renderers;

/**
 * Class BooleanRenderer
 * @package Motor\Backend\Grid\Renderers
 */
class BooleanRenderer
{

    protected $value = '';

    protected $options = [];


    /**
     * BooleanRenderer constructor.
     * @param $value
     * @param $options
     */
    public function __construct($value, $options)
    {
        $this->value   = $value;
        $this->options = $options;
    }


    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function render()
    {
        if ($this->value == true) {
            return trans('motor-backend::backend/global.yes');
        }

        return trans('motor-backend::backend/global.no');
    }
}