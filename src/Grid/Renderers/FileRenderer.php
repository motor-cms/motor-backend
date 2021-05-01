<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class FileRenderer
 *
 * @package Motor\Backend\Grid\Renderers
 */
class FileRenderer
{
    protected $value = '';

    protected $options = [];

    protected $record;

    /**
     * FileRenderer constructor.
     *
     * @param            $value
     * @param array $options
     * @param Model|null $record
     */
    public function __construct($value, array $options = [], Model $record = null)
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
        $media = $this->record->getFirstMedia(Arr::get($this->options, 'file'));

        return view('motor-backend::grid.actions.file', ['media'   => $media,
                                                         'record'  => $this->record,
                                                         'options' => $this->options,
            ])->render();
    }
}
