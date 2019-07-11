<?php

namespace Motor\Backend\Grid\Renderers;

use Carbon\Carbon;

/**
 * Class DateRenderer
 * @package Motor\Backend\Grid\Renderers
 */
class DateRenderer
{

    protected $value = '';

    protected $options = [];

    protected $defaultFormat = 'Y-m-d H:i:s';


    /**
     * DateRenderer constructor.
     * @param       $value
     * @param array $options
     */
    public function __construct($value, $options = [])
    {
        $this->value   = $value;
        $this->options = $options;
    }


    /**
     * @return string
     */
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