<?php

namespace Motor\Backend\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Motor\Backend\Console\Commands\MotorCreatePermissionsCommand;

class MotorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->config();
        $this->routes();
        $this->routeModelBindings();
        $this->translations();
        $this->views();
        $this->navigationItems();
        $this->permissions();
        $this->registerCommands();
        $this->migrations();
        $this->publishResourceAssets();
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/motor-backend.php', 'motor-backend');
        $this->mergeConfigFrom(__DIR__ . '/../../config/motor-backend-project.php', 'motor-backend-project');
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-form-builder.php', 'laravel-form-builder');
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-permission.php', 'laravel-permission');
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-menu/settings.php', 'laravel-menu.settings');
    }


    public function publishResourceAssets()
    {
        $assets = [
            __DIR__ . '/../../public/css/motor'            => public_path('css/motor'),
            __DIR__ . '/../../public/images'               => public_path('images'),
            __DIR__ . '/../../resources/assets/sass'       => resource_path('assets/sass'),
            __DIR__ . '/../../resources/assets/js'         => resource_path('assets/js'),
            __DIR__ . '/../../resources/misc/gulpfile.js'  => base_path('gulpfile.js'),
            __DIR__ . '/../../resources/misc/package.json' => base_path('package.json'),
            __DIR__ . '/../../database/seeds'              => base_path('database/seeds'),
        ];

        $this->publishes($assets, 'motor-backend-install');
    }


    public function migrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }


    public function permissions()
    {
        $config = $this->app['config']->get('motor-backend-permissions', []);
        $this->app['config']->set('motor-backend-permissions',
            array_replace_recursive(require __DIR__ . '/../../config/motor-backend-permissions.php',
                $config));
    }


    public function routes()
    {
        if ( ! $this->app->routesAreCached()) {
            require __DIR__ . '/../../routes/web.php';
            require __DIR__ . '/../../routes/api.php';
        }
    }


    public function config()
    {
        $this->publishes([
            __DIR__ . '/../../config/motor-backend-project.php'          => config_path('motor-backend-project.php'),
            __DIR__ . '/../../config/motor-backend.php'                  => config_path('motor-backend.php'),
            __DIR__ . '/../../config/motor-backend-navigation-stub.php'  => config_path('motor-backend-navigation.php'),
            __DIR__ . '/../../config/motor-backend-permissions-stub.php' => config_path('motor-backend-permissions.php'),
        ], 'motor-backend-install');
    }


    public function translations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'motor-backend');

        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/motor-backend'),
        ], 'motor-backend-translations');
    }


    public function views()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'motor-backend');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/motor-backend'),
        ], 'motor-backend-views');
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


    public function navigationItems()
    {
        $config = $this->app['config']->get('motor-backend-navigation', []);
        $this->app['config']->set('motor-backend-navigation',
            array_replace_recursive(require __DIR__ . '/../../config/motor-backend-navigation.php', $config));
    }


    public function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MotorCreatePermissionsCommand::class,
            ]);
        }
    }
}
