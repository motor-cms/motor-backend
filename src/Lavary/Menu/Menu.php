<?php

namespace Motor\Backend\Lavary\Menu;

class Menu extends \Lavary\Menu\Menu {

    /**
     * Create a new menu instance
     *
     * @param  string  $name
     * @param  callable  $callback
     * @return \Lavary\Menu\Menu
     */
    public function make($name, $callback)
    {
        if(is_callable($callback))
        {

            $menu = new Builder($name, $this->loadConf($name));

            // Registering the items
            call_user_func($callback, $menu);

            // Storing each menu instance in the collection
            $this->collection->put($name, $menu);

            // Make the instance available in all views
            \View::share($name, $menu);

            return $menu;
        }
    }

}