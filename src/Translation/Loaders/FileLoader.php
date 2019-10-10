<?php

namespace Motor\Backend\Translation\Loaders;

/**
 * Class FileLoader
 * @package Motor\Backend\Translation\Loaders
 */
class FileLoader extends \Illuminate\Translation\FileLoader
{

    /**
     * We're making the hints (which are actually the namespaces) public so we can access them in order to export
     * all the language files to a Vue compatible js file
     *
     * @var array
     */
    public $hints = [];
}
