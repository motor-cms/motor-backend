<?php

namespace Motor\Backend\Grid;

/**
 * Class Row
 */
class Row extends Base
{
    protected $cells = [];

    /**
     * Add cell to row
     *
     * @param  Cell  $cell
     * @return $this
     */
    public function addCell(Cell $cell)
    {
        $this->cells[$cell->getName()] = $cell;

        return $this;
    }

    /**
     * Get cell by column name
     *
     * @param $name
     * @return bool|mixed
     */
    public function getCell(string $name)
    {
        if (isset($this->cells[$name])) {
            return $this->cells[$name];
        }

        return false;
    }

    /**
     * Get all cells
     *
     * @return array
     */
    public function getCells(): array
    {
        return $this->cells;
    }
}
