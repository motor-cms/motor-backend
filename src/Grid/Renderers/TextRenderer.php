<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Support\Arr;

/**
 * Class TextRenderer
 *
 * @package Motor\Backend\Grid\Renderers
 */
class TextRenderer
{
    protected $value = '';

    protected $options = [];

    /**
     * TextRenderer constructor.
     *
     * @param $value
     * @param $options
     */
    public function __construct($value, array $options = [])
    {
        $this->value = $value;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->value === '' && Arr::get($this->options, 'empty_text')) {
            return Arr::get($this->options, 'empty_text');
        }

        return $this->value;
    }
}
