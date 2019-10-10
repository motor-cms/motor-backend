<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class JsonArrayRenderer
 * @package Motor\Backend\Grid\Renderers
 */
class JsonArrayRenderer
{
    protected $value = '';

    protected $options = [];

    protected $record;

    protected $defaultCurrency = 'EUR';

    /**
     * JsonArrayRenderer constructor.
     *
     * @param            $value
     * @param array      $options
     * @param Model|null $record
     */
    public function __construct($value, array $options = [], Model $record = null)
    {
        $this->value   = $value;
        $this->options = $options;
        $this->record  = $record;
    }


    /**
     * @return string
     */
    public function render()
    {
        if ($this->value == '' || $this->value == null || $this->value == 'null') {
            return '';
        }

        $values = json_decode(html_entity_decode($this->value), true);
        if (isset($this->options['translation_file'])) {
            foreach ($values as $key => $value) {
                $values[$key] = trans($this->options['translation_file'] . '.' . $value);
            }
        }

        return implode(', ', $values);
    }
}
