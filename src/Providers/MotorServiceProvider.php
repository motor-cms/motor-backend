<?php

namespace Motor\Backend\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Motor\Backend\Console\Commands\MotorCreatePermissionsCommand;
use Motor\Backend\Models\Category;
use Motor\Backend\Models\ConfigVariable;

/**
 * Class MotorServiceProvider
 *
 * @package Motor\Backend\Providers
 */
class MotorServiceProvider extends ServiceProvider
{
    protected $policies = [
        'Motor\Backend\Models\User' => 'Motor\Backend\Policies\UserPolicy',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('attachment', static function ($content, $filename, $format = 'application/json') {
            $headers = [
                'Content-type'        => $format,
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ];

            return Response::make($content, 200, $headers);
        });

        $this->routes();
        $this->routeModelBindings();
        $this->permissions();
        $this->registerCommands();
        $this->migrations();
        $this->registerPolicies();
        merge_local_config_with_db_configuration_variables('motor-backend');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/ide-helper.php', 'ide-helper');
        $this->mergeConfigFrom(__DIR__.'/../../config/culpa.php', 'culpa');
        $this->mergeConfigFrom(__DIR__.'/../../config/media-library.php', 'medialibrary');
        $this->mergeConfigFrom(__DIR__.'/../../config/motor-backend.php', 'motor-backend');
        $this->mergeConfigFrom(__DIR__.'/../../config/motor-backend-project.php', 'motor-backend-project');
        $this->mergeConfigFrom(__DIR__.'/../../config/permission.php', 'permission');
    }

    /**
     * Set migration path
     */
    public function migrations()
    {
        $this->loadMigrationsFrom(realpath(__DIR__.'/../../database/migrations'));
    }

    /**
     * Merge permission config file
     */
    public function permissions()
    {
        $config = $this->app['config']->get('motor-backend-permissions', []);
        $this->app['config']->set('motor-backend-permissions', array_replace_recursive(require __DIR__.'/../../config/motor-backend-permissions.php', $config));
    }

    /**
     * Set routes
     */
    public function routes()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/../../routes/api.php';
        }
    }

    /**
     * Add route model bindings
     */
    public function routeModelBindings()
    {
        Route::bind('user', static function ($id) {
            return config('motor-backend.models.user')::findOrFail($id);
        });

        Route::bind('role', static function ($id) {
            return config('motor-backend.models.role')::findOrFail($id);
        });

        Route::bind('permission', static function ($id) {
            return config('motor-backend.models.permission')::findOrFail($id);
        });

        Route::bind('language', static function ($id) {
            return config('motor-backend.models.language')::findOrFail($id);
        });

        Route::bind('client', static function ($id) {
            return config('motor-backend.models.client')::findOrFail($id);
        });

        Route::bind('email_template', static function ($id) {
            return config('motor-backend.models.email_template')::findOrFail($id);
        });

        Route::bind('category', static function ($id) {
            return Category::findOrFail($id);
        });

        Route::bind('config_variable', static function ($id) {
            return ConfigVariable::findOrFail($id);
        });
    }

    /**
     * Register artisan commands
     */
    public function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MotorCreatePermissionsCommand::class,
            ]);
        }
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies() as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public function policies()
    {
        return $this->policies;
    }
}
