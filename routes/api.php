<?php
Route::group([
    'middleware' => [ 'auth:api', 'bindings', 'permission' ],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], static function () {
    Route::apiResource('users', 'UsersController');
    Route::resource('clients', 'ClientsController');
    Route::resource('languages', 'LanguagesController');
    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('permission_groups', 'PermissionGroupsController');
    Route::resource('email_templates', 'EmailTemplatesController');
    Route::resource('categories', 'CategoriesController');

    Route::get('profile', 'ProfileEditController@me')->name('profile.read');
    Route::put('profile', 'ProfileEditController@update')->name('profile.update');
    Route::resource('config_variables', 'ConfigVariablesController');
});

Route::group([
    'middleware' => [ 'api', 'bindings' ],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api\Auth',
    'prefix'     => 'api/auth',
    'as'         => 'api.auth',

], static function ($router) {
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::post('refresh', 'LoginController@refresh')->name('refresh');
    Route::post('me', 'LoginController@me')->name('me');
});

Route::group([
    'middleware' => [ 'web', 'web_auth', 'bindings', 'permission' ],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], static function () {
    Route::get('categories', 'CategoriesController@index')->name('categories.index');
});
