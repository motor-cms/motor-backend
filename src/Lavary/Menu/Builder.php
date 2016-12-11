<?php

namespace Motor\Backend\Lavary\Menu;

class Builder extends \Lavary\Menu\Builder
{

    /**
     * Adds an item to the menu
     *
     * @param  string       $title
     * @param  string|array $acion
     *
     * @return Lavary\Menu\Item $item
     */
    public function add($title, $options = '')
    {

        $id = isset($options['id']) ? $options['id'] : $this->id();

        $item = new Item($this, $id, $title, $options);

        $this->items->push($item);

        return $item;
    }

}