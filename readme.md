# Motor Backend

You can install this package via composer using this command:

```bash
composer require dfox288/motor-backend
```

Next, you must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    Motor\Backend\Providers\MotorServiceProvider::class,
];
```

Then you need to replace the ViewServiceProvider with an alternate one

```php
//        Illuminate\View\ViewServiceProvider::class,             <-- we're replacing this so we can use blade templates from strings
        Wpb\String_Blade_Compiler\ViewServiceProvider::class,
```

Then you need to add a bunch of other service providers

```php
        Collective\Html\HtmlServiceProvider::class,
        Laracasts\Flash\FlashServiceProvider::class,
        Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Dimsav\Translatable\TranslatableServiceProvider::class,
        Sofa\Eloquence\ServiceProvider::class,
        Lavary\Menu\ServiceProvider::class,
        Culpa\CulpaServiceProvider::class,
        Kris\LaravelFormBuilder\FormBuilderServiceProvider::class,
        Spatie\MediaLibrary\MediaLibraryServiceProvider::class,
        Barryvdh\Cors\ServiceProvider::class,
        Fideloper\Proxy\TrustedProxyServiceProvider::class,
        Spatie\Permission\PermissionServiceProvider::class,
        Motor\Core\Providers\MotorServiceProvider::class,
```

...replace one facade accessor

```php
//        'Schema'    => Illuminate\Support\Facades\Schema::class,
        'Schema'       => Culpa\Facades\Schema::class, // we use the culpa schema for easier migrations
```

...and add some facade accessors

```php
        'Form'        => Collective\Html\FormFacade::class,
        'Html'        => Collective\Html\HtmlFacade::class,
        'Flash'       => Laracasts\Flash\Flash::class,
        'Image'       => Intervention\Image\Facades\Image::class,
        'Menu'        => Lavary\Menu\Facade::class,
        'FormBuilder' => Kris\LaravelFormBuilder\Facades\FormBuilder::class,
```


Then, install the necessary assets
```bash
php artisan vendor:publish --tag=motor-backend-install --force
```

Run migrations

```bash
php artisan migrate
```

Run the UserTableSeeder to get access to the backend

```bash
php artisan db:seed --class=UsersTableSeeder
```

Run npm install and gulp to generate the necessary assets for the backend

```bash
npm install && gulp
```

Add/replace the web and web_auth middleware groups to your Http/Kernel.php

```php
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'web_auth'     => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Motor\Backend\Http\Middleware\Authenticate::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
		'api' => [
			'throttle:60,1',
			'bindings',
		],
	];
```

...and add 'navigation' and 'permission' to your $routeMiddleware array

```php
        'navigation' => \Motor\Backend\Http\Middleware\BackendNavigation::class,
        'permission' => \Motor\Backend\Http\Middleware\CheckPermission::class,
```

Change the user class in your config/auth.php providers array

```php
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Motor\Backend\Models\User::class
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
```

Generate the permissions with

```bash
php artisan motor:create:permissions
```

Add this method to your exception handler

```php
    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(\Symfony\Component\HttpKernel\Exception\HttpException $e)
    {
        $status = $e->getStatusCode();

        if (view()->exists("motor-backend::errors.{$status}")) {
            return response()->view("motor-backend::errors.{$status}", ['exception' => $e], $status, $e->getHeaders());
        } else {
            return $this->convertExceptionToResponse($e);
        }
    }
```

...and replace the render method

```php
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException)
        {
            if (!$request->acceptsHtml())
            {
                return response()->json([
                    'message' => 'Record not found',
                ], 404);
            }
        }

        return parent::render($request, $exception);
    }
```

## Credits

- [Reza Esmaili](https://github.com/dfox288)

## About Motor
...

## License

The MIT License (MIT).