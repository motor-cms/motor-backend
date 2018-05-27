<?php

namespace Motor\Backend\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Motor\Backend\Console\Commands\MotorCreatePermissionsCommand;
use Illuminate\Support\Facades\Response;

class MotorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('attachment', function ($content, $filename, $format = 'application/json') {

            $headers = [
                'Content-type'        => $format,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            return Response::make($content, 200, $headers);
        });

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
        $this->bladeDirectives();
    }


    public function bladeDirectives()
    {
        Blade::directive('boxWrapper', function () {
            return config('motor-backend-html.box_wrapper');
        });

        Blade::directive('boxHeader', function () {
            return config('motor-backend-html.box_header');
        });

        Blade::directive('boxBody', function () {
            return config('motor-backend-html.box_body');
        });

        Blade::directive('boxFooter', function () {
            return config('motor-backend-html.box_footer');
        });

        Blade::directive('defaultButtonSize', function () {
            return config('motor-backend-html.default_button_size');
        });
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/medialibrary.php', 'medialibrary');
        $this->mergeConfigFrom(__DIR__ . '/../../config/motor-backend.php', 'motor-backend');
        $this->mergeConfigFrom(__DIR__ . '/../../config/motor-backend-html.php', 'motor-backend-html');
        $this->mergeConfigFrom(__DIR__ . '/../../config/motor-backend-project.php', 'motor-backend-project');
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-form-builder.php', 'laravel-form-builder');
        $this->mergeConfigFrom(__DIR__ . '/../../config/permission.php', 'permission');
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-menu/settings.php', 'laravel-menu.settings');
    }


    public function publishResourceAssets()
    {
        $assets = [
            __DIR__ . '/../../resources/assets/sass'   => resource_path('assets/sass'),
            __DIR__ . '/../../resources/assets/js'     => resource_path('assets/js'),
            __DIR__ . '/../../resources/assets/images' => resource_path('assets/images'),
            __DIR__ . '/../../resources/assets/npm'    => resource_path('assets/npm'),
            __DIR__ . '/../../database/seeds'          => base_path('database/seeds'),
        ];

        $this->publishes($assets, 'motor-backend-install-resources');
    }


    public function migrations()
    {
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../../database/migrations'));
    }


    public function permissions()
    {
        $config = $this->app['config']->get('motor-backend-permissions', []);
        $this->app['config']->set('motor-backend-permissions',
            array_replace_recursive(require __DIR__ . '/../../config/motor-backend-permissions.php', $config));
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
        ], 'motor-backend-install-config');
    }


    public function translations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'motor-backend');

        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/motor-backend'),
        ], 'motor-backend-install-translations');
    }


    public function views()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'motor-backend');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/motor-backend'),
        ], 'motor-backend-install-views');
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

        Route::bind('category', function ($id) {
            return \Motor\Backend\Models\Category::findOrFail($id);
        });

        Route::bind('config_variable', function ($id) {
            return \Motor\Backend\Models\ConfigVariable::findOrFail($id);
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
