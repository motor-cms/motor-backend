<?php

use Motor\Backend\Http\Controllers\Auth\ChangePasswordController;
use Motor\Backend\Http\Controllers\Backend\CategoriesController;
use Motor\Backend\Http\Controllers\Backend\CategoryTreesController;
use Motor\Backend\Http\Controllers\Backend\ClientsController;
use Motor\Backend\Http\Controllers\Backend\ConfigVariablesController;
use Motor\Backend\Http\Controllers\Backend\DashboardController;
use Motor\Backend\Http\Controllers\Backend\EmailTemplatesController;
use Motor\Backend\Http\Controllers\Backend\LanguagesController;
use Motor\Backend\Http\Controllers\Backend\PermissionsController;
use Motor\Backend\Http\Controllers\Backend\ProfileEditController;
use Motor\Backend\Http\Controllers\Backend\RolesController;
use Motor\Backend\Http\Controllers\Backend\UsersController;

Route::group([
    'middleware' => ['web'],
    'namespace'  => 'Motor\Backend\Http\Controllers',
], static function () {
    Auth::routes(config('motor-backend.routes.auth', []));
    Route::get('password/change', [ChangePasswordController::class, 'showChangeForm'])
         ->name('auth.change-password.index');
    Route::post('password/change', [ChangePasswordController::class, 'change'])
         ->name('auth.change-password.store');
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
                'uses' => [DashboardController::class, 'show'],
            ]);
            Route::get('dashboard', [DashboardController::class, 'show'])
                 ->name('dashboard.index');
        }

        if (config('motor-backend.routes.users')) {
            Route::resource('users', UsersController::class);
        }

        if (config('motor-backend.routes.roles')) {
            Route::resource('roles', RolesController::class);
        }

        if (config('motor-backend.routes.permissions')) {
            Route::resource('permissions', PermissionsController::class);
        }

        if (config('motor-backend.routes.languages')) {
            Route::resource('languages', LanguagesController::class);
        }

        if (config('motor-backend.routes.clients')) {
            Route::resource('clients', ClientsController::class);
        }

        if (config('motor-backend.routes.email_templates')) {
            Route::resource('email_templates', EmailTemplatesController::class);
            Route::get('email_templates/{email_template}/duplicate', [EmailTemplatesController::class, 'duplicate'])
                 ->name('email_templates.duplicate');
        }

        if (config('motor-backend.routes.profile')) {
            Route::get('profile/edit', [ProfileEditController::class, 'edit'])
                 ->name('profile.edit');
            Route::patch('profile/edit', [ProfileEditController::class, 'update'])
                 ->name('profile.update');
        }

        Route::resource('categories', CategoriesController::class, [
            'except' => [
                'index',
                'create',
            ],
        ]);

        Route::get('categories/{category}', [CategoriesController::class, 'index'])
             ->name('categories.index');
        Route::get('categories/{category}/create', [CategoriesController::class, 'create'])
             ->name('categories.create');

        Route::resource('category_trees', CategoryTreesController::class, [
            'parameters' => [
                'category_trees' => 'category',
            ],
        ]);

        Route::resource('config_variables', ConfigVariablesController::class);
        Route::get('config_variables/{config_variable}/duplicate', [ConfigVariablesController::class, 'duplicate'])
             ->name('config_variables.duplicate');
    });
});
