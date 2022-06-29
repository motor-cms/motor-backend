<?php

//Route::get('/', function () {
//    return redirect('/backend');
//});
//
//Route::get('/home', function () {
//    return redirect('/backend');
//});

Route::group([
    'middleware' => ['web'],
    'namespace'  => 'Motor\Backend\Http\Controllers',
], static function () {
    Auth::routes(config('motor-backend.routes.auth', []));
    Route::get('password/change', 'Auth\ChangePasswordController@showChangeForm')->name('auth.change-password.index');
    Route::post('password/change', 'Auth\ChangePasswordController@change')->name('auth.change-password.store');
});

Route::group([
    'as'         => 'backend.',
    'prefix'     => 'backend',
    'namespace'  => 'Motor\Backend\Http\Controllers\Backend',
    'middleware' => [
        'web',
        'web_auth',
        'navigation',
    ],
], static function () {
    Route::group(['middleware' => ['permission']], static function () {
        if (config('motor-backend.routes.dashboard')) {
            Route::get('/', [
                'as'   => 'dashboard.index',
                'uses' => 'DashboardController@show',
            ]);
            Route::get('dashboard', 'DashboardController@show')->name('dashboard.index');
        }

        if (config('motor-backend.routes.users')) {
            Route::resource('users', 'UsersController');
        }

        if (config('motor-backend.routes.roles')) {
            Route::resource('roles', 'RolesController');
        }

        if (config('motor-backend.routes.permissions')) {
            Route::resource('permissions', 'PermissionsController');
        }

        if (config('motor-backend.routes.languages')) {
            Route::resource('languages', 'LanguagesController');
        }

        if (config('motor-backend.routes.clients')) {
            Route::resource('clients', 'ClientsController');
        }

        if (config('motor-backend.routes.email_templates')) {
            Route::resource('email_templates', 'EmailTemplatesController');
            Route::get('email_templates/{email_template}/duplicate', 'EmailTemplatesController@duplicate')
                 ->name('email_templates.duplicate');
        }

        if (config('motor-backend.routes.profile')) {
            Route::get('profile/edit', 'ProfileEditController@edit')->name('profile.edit');
            Route::patch('profile/edit', 'ProfileEditController@update')->name('profile.update');
        }

        Route::resource('categories', 'CategoriesController', [
            'except' => [
                'index',
                'create',
            ],
        ]);

        Route::get('categories/{category}', 'CategoriesController@index')->name('categories.index');
        Route::get('categories/{category}/create', 'CategoriesController@create')->name('categories.create');

        Route::resource('category_trees', 'CategoryTreesController', [
            'parameters' => [
                'category_trees' => 'category',
            ],
        ]);

        Route::resource('config_variables', 'ConfigVariablesController');
        Route::get('config_variables/{config_variable}/duplicate', 'ConfigVariablesController@duplicate')
             ->name('config_variables.duplicate');
    });
});
