<?php

namespace Motor\Backend\Providers;

use Motor\Backend\Translation\Loaders\FileLoader;

/**
 * Class TranslationServiceProvider
 */
class TranslationServiceProvider extends \Illuminate\Translation\TranslationServiceProvider
{
    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', static function ($app) {
            return new FileLoader($app['files'], $app['path.lang']);
        });
    }
}
