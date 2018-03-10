<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Support\Arr;

class FileRenderer
{

    protected $value = '';

    protected $options = [];

    protected $record;


    public function __construct($value, $options = [], $record = null)
    {
        $this->value   = $value;
        $this->options = $options;
        $this->record  = $record;
    }


    public function render()
    {
        $media = $this->record->getFirstMedia(Arr::get($this->options, 'file'));

        return view('motor-backend::grid.actions.file', ['media' => $media, 'record' => $this->record ])->render();

    }
}