<?php

namespace Motor\Backend\Grid\Renderers;

/**
 * Class MultipleRenderer
 * @package Motor\Backend\Grid\Renderers
 */
class MultipleRenderer
{

    protected $value = '';

    protected $options = [];


    /**
     * MultipleRenderer constructor.
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
        if ( ! is_array($this->value)) {
            return '';
        }

        return implode(', ', $this->value);
    }
}