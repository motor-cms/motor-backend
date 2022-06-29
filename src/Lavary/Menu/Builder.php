<?php

namespace Motor\Backend\Lavary\Menu;

use Illuminate\Support\Arr;

/**
 * Class Builder
 */
class Builder extends \Lavary\Menu\Builder
{
    /**
     * Adds an item to the menu
     *
     * @param  string  $title
     * @param  array  $options
     * @return \Lavary\Menu\Item|Item
     */
    public function add($title, $options = [])
    {
        $id = Arr::get($options, 'id', $this->id());

        $item = new Item($this, $id, $title, $options);

        $this->items->push($item);

        return $item;
    }
}
