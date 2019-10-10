<?php

namespace Motor\Backend\Grid\Renderers;

/**
 * Class TranslateRenderer
 * @package Motor\Backend\Grid\Renderers
 */
class TranslateRenderer
{
    protected $value = '';

    protected $options = [];

    protected $defaultFile = 'backend/global';


    /**
     * TranslateRenderer constructor.
     * @param $value
     * @param $options
     */
    public function __construct($value, array $options)
    {
        $this->value   = $value;
        $this->options = $options;
    }


    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function render()
    {
        if (isset($this->options['file'])) {
            return trans($this->options['file'] . '.' . $this->value);
        }

        return trans($this->defaultFile . '.' . $this->value);
    }
}
