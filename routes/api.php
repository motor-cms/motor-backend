<?php

use Motor\Backend\Http\Controllers\Api\AdminNavigationsController;
use Motor\Backend\Http\Controllers\Api\Auth\AuthController;

Route::group([
    'middleware' => ['auth:sanctum', 'bindings', 'permission'],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], static function () {
    Route::apiResource('users', 'UsersController');
    Route::apiResource('clients', 'ClientsController');
    Route::apiResource('languages', 'LanguagesController');
    Route::apiResource('roles', 'RolesController');
    Route::apiResource('permissions', 'PermissionsController');
    Route::apiResource('permission_groups', 'PermissionGroupsController');
    Route::apiResource('email_templates', 'EmailTemplatesController');
    Route::apiResource('category_trees/{category_tree}/categories', 'CategoriesController', [
        'parameters' => [
            'category_trees' => 'category',
        ],
    ]);
    Route::apiResource('category_trees', 'CategoryTreesController', [
        'parameters' => [
            'category_trees' => 'category',
        ],
    ]);

    Route::get('profile', 'ProfileEditController@me')
         ->name('profile.read');
    Route::put('profile', 'ProfileEditController@update')
         ->name('profile.update');
    Route::apiResource('config_variables', 'ConfigVariablesController');
});

Route::post('/api/auth/register', [AuthController::class, 'register']);

Route::post('/api/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/api/me', function (Request $request) {
        return new \Motor\Backend\Http\Resources\UserResource(auth()->user());
    });

    Route::post('/api/auth/logout', [AuthController::class, 'logout']);

    Route::get('/api/admin_navigations', [AdminNavigationsController::class, 'index'])
         ->name('admin_navigations.index');
});

//Route::group([
//    'middleware' => [ 'api', 'bindings' ],
//    'namespace'  => 'Motor\Backend\Http\Controllers\Api\Auth',
//    'prefix'     => 'api/auth',
//    'as'         => 'api.auth',
//
//], static function ($router) {
//    Route::post('login', 'LoginController@login')->name('login');
//    Route::post('logout', 'LoginController@logout')->name('logout');
//    Route::post('refresh', 'LoginController@refresh')->name('refresh');
//    Route::post('me', 'LoginController@me')->name('me');
//});

Route::group([
    'middleware' => ['web', 'web_auth', 'bindings', 'permission'],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], static function () {
    Route::get('categories', 'CategoriesController@index')
         ->name('categories.index');
});
