<?php

namespace Motor\Backend\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class MotorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../resources/config/motor-backend.php' => config_path('motor-backend.php'),
        ]);

        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../../routes/web.php';
        }
        $this->routeModelBindings();
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../resources/config/motor-backend.php', 'motor-backend'
        );

    }

    public function routeModelBindings()
    {
        Route::bind('user', function ($id) {
            return config('motor-backend.models.user')::findOrFail($id);
        });

        Route::bind('role', function ($id) {
            return config('motor-backend.models.role')::findOrFail($id);
        });

        Route::bind('permission', function ($id) {
            return config('motor-backend.models.permission')::findOrFail($id);
        });

        Route::bind('language', function ($id) {
            return config('motor-backend.models.language')::findOrFail($id);
        });

        Route::bind('client', function ($id) {
            return config('motor-backend.models.client')::findOrFail($id);
        });

        Route::bind('email_template', function ($id) {
            return config('motor-backend.models.email_template')::findOrFail($id);
        });
    }
}
