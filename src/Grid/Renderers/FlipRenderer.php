<?php

namespace Motor\Backend\Grid\Renderers;

/**
 * Class FlipRenderer
 * @package Motor\Backend\Grid\Renderers
 */
class FlipRenderer
{
    protected $value = '';

    protected $options = [];


    /**
     * FlipRenderer constructor.
     * @param $value
     * @param $options
     */
    public function __construct($value, $options)
    {
        $this->value   = $value;
        $this->options = $options;
    }


    /**
     * @return string
     */
    public function render()
    {
        if ($this->value == true) {
            return '<button class="btn btn-xs btn-default">' . trans('motor-backend::backend/global.yes') . '</button>';
        }

        return '<button class="btn btn-xs btn-default">' . trans('motor-backend::backend/global.no') . '</button>';
    }
}
