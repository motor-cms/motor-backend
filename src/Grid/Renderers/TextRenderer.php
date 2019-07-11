<?php

namespace Motor\Backend\Grid\Renderers;

/**
 * Class TextRenderer
 * @package Motor\Backend\Grid\Renderers
 */
class TextRenderer
{

    protected $value = '';

    protected $options = [];


    /**
     * TextRenderer constructor.
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
        return $this->value;
    }
}