<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Support\Facades\App;

/**
 * Class DecorationRenderer
 */
class DecorationRenderer
{
    protected $value = '';

    protected $options = [];

    /**
     * DecorationRenderer constructor.
     */
    public function __construct($value, array $options = [])
    {
        $this->value = $value;
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        return App::make('html')
            ->tag('span', $this->value, $this->options);
    }
}
