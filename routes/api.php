<?php
Route::group([
    'middleware' => ['auth:api', 'bindings'],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], function () {
    Route::resource('users', 'UsersController');
    Route::resource('clients', 'ClientsController');
    Route::resource('languages', 'LanguagesController');
    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');

    Route::get('profile/me', 'ProfileEditController@me')->name('profile.me');
    Route::patch('profile/edit', 'ProfileEditController@update')->name('profile.update');
});
