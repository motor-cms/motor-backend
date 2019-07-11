<?php

namespace Motor\Backend\Lavary\Menu;

/**
 * Class Builder
 * @package Motor\Backend\Lavary\Menu
 */
class Builder extends \Lavary\Menu\Builder
{

    /**
     * Adds an item to the menu
     *
     * @param string $title
     * @param array  $options
     *
     * @return \Lavary\Menu\Item|Item
     */
    public function add($title, $options = [])
    {

        $id = isset($options['id']) ? $options['id'] : $this->id();

        $item = new Item($this, $id, $title, $options);

        $this->items->push($item);

        return $item;
    }

}