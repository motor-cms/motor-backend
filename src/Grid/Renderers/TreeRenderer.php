<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TreeRenderer
 * @package Motor\Backend\Grid\Renderers
 */
class TreeRenderer
{
    protected $value = '';

    protected $options = [];

    protected $record;


    /**
     * TreeRenderer constructor.
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
        $returnValue = '';
        $ancestors   = (int) $this->record->ancestors()->count();
        while ($ancestors > 1) {
            $returnValue .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $ancestors--;
        }

        return $returnValue . $this->value;
    }
}
