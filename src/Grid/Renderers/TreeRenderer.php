<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TreeRenderer
 */
class TreeRenderer
{
    protected $value = '';

    protected $options = [];

    protected $record;

    /**
     * TreeRenderer constructor.
     */
    public function __construct($value, array $options = [], ?Model $record = null)
    {
        $this->value = $value;
        $this->options = $options;
        $this->record = $record;
    }

    /**
     * @return string
     */
    public function render()
    {
        $returnValue = '';
        $ancestors = (int) $this->record->ancestors()
            ->count();
        while ($ancestors > 1) {
            $returnValue .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $ancestors--;
        }

        return $returnValue.$this->value;
    }
}
