<?php

namespace Motor\Backend\Lavary\Menu;

/**
 * Class Item
 * @package Motor\Backend\Lavary\Menu
 */
class Item extends \Lavary\Menu\Item
{

    /**
     * Decide if the item should be active
     */
    public function checkActivationStatus()
    {

        parent::checkActivationStatus();

        if ($this->builder->conf['restful'] == true) {

            $path  = ltrim(parse_url($this->url(), PHP_URL_PATH), '/');
            $rpath = \Request::path();

            if ($this->builder->conf['rest_base']) {

                $base = ( is_array($this->builder->conf['rest_base']) ) ? implode('|',
                    $this->builder->conf['rest_base']) : $this->builder->conf['rest_base'];

                [ $path, $rpath ] = preg_replace('@^(' . $base . ')/@', '', [ $path, $rpath ], 1);
            }

            // HACK TO SUPPORT ALIASES FOR NAVIGATION ITEMS
            foreach (explode(',', $this->attributes['aliases']) as $alias) {
                if (preg_match("@^{$alias}(/.+)?\z@", $rpath)) {

                    $this->activate();
                }
            }
        }
    }
}