<?php

namespace Motor\Backend\Lavary\Menu;

use View;

/**
 * Class Menu
 *
 * @package Motor\Backend\Lavary\Menu
 */
class Menu extends \Lavary\Menu\Menu
{
    /**
     * Create a new menu instance
     *
     * @param string $name
     * @param callable $callback
     *
     * @return \Lavary\Menu\Menu
     */
    public function make($name, $callback, array $options = [])
    {
        if (is_callable($callback)) {
            if (! array_key_exists($name, $this->menu)) {
                $this->menu[$name] = new Builder($name, $this->loadConf($name));
            }

            // Registering the items
            call_user_func($callback, $this->menu[$name]);

            // Storing each menu instance in the collection
            $this->collection->put($name, $this->menu[$name]);

            // Make the instance available in all views
            View::share($name, $this->menu[$name]);

            return $this->menu[$name];
        }
    }
}
