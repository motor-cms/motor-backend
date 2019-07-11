<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Support\Facades\App;

/**
 * Class CollectionRenderer
 * @package Motor\Backend\Grid\Renderers
 */
class CollectionRenderer
{

    protected $value = '';

    protected $options = [ 'column' => 'name' ];


    /**
     * CollectionRenderer constructor.
     * @param      $value
     * @param null $options
     */
    public function __construct($value, $options = null)
    {
        $this->value = $value;
        if ( ! is_null($options)) {
            $this->options = $options;
        }
    }


    /**
     * @return string
     */
    public function render()
    {
        if ( ! is_array($this->value)) {
            return '';
        }

        $list = [];
        foreach ($this->value as $row) {
            $list[] = $row[$this->options['column']];
        }

        return App::make('html')->ul($list, [ 'class' => 'list-unstyled' ]);
    }
}