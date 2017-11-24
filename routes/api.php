<?php
Route::group([
    'middleware' => [ 'auth:api', 'bindings', 'permission' ],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], function () {
    Route::resource('users', 'UsersController');
    Route::resource('clients', 'ClientsController');
    Route::resource('languages', 'LanguagesController');
    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('email_templates', 'EmailTemplatesController');
    Route::resource('categories', 'CategoriesController');

    Route::get('profile/me', 'ProfileEditController@me')->name('profile.read');
    Route::patch('profile/edit', 'ProfileEditController@update')->name('profile.update');

});

Route::group([
    'middleware' => [ 'api', 'bindings' ],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api\Auth',
    'prefix' => 'api/auth',
    'as'         => 'api.auth',

], function ($router) {

    Route::post('login', 'LoginController@login')->name('login');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::post('refresh', 'LoginController@refresh')->name('refresh');
    Route::post('me', 'LoginController@me')->name('me');

});
