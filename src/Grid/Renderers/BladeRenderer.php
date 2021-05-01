<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class BladeRenderer
 *
 * @package Motor\Backend\Grid\Renderers
 */
class BladeRenderer
{
    protected $value = '';

    protected $options = [];

    protected $record;

    /**
     * BladeRenderer constructor.
     *
     * BladeRenderer constructor.
     *
     * @param            $value
     * @param            $options
     * @param Model|null $record
     */
    public function __construct($value, $options, Model $record = null)
    {
        $this->value = $value;
        $this->options = $options;
        $this->record = $record;
    }

    /**
     * @return array|string
     * @throws \Throwable
     */
    public function render()
    {
        // FIXME: hack for sort_positions
        $index = 0;
        if (isset($this->options['field'])) {
            if ($this->options['field'] == 'sort_position') {
                $index = 100;
            } else {
                $index = 1000;
            }
        }

        return view(Arr::get($this->options, 'template'), [
            'record'  => $this->record,
            'value'   => $this->value,
            'options' => $this->options,
            'index'   => $index,
        ])->render();
    }
}
