<?php

Route::get('/', function () {
    return redirect('/backend');
});

Route::get('/home', function () {
    return redirect('/backend');
});

Route::group([ 'middleware' => [ 'web' ], 'namespace' => 'Motor\Backend\Http\Controllers' ], function () {
    Auth::routes();
});

Route::group([
    'as'         => 'backend.',
    'prefix'     => 'backend',
    'namespace'  => 'Motor\Backend\Http\Controllers\Backend',
    'middleware' => [ 'web', 'web_auth', 'navigation' ]
], function () {

    Route::group([ 'middleware' => [ 'permission' ] ], function () {
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
            Route::get('email_templates/{email_template}/duplicate',
                'EmailTemplatesController@duplicate')->name('email_templates.duplicate');
        }

        if (config('motor-backend.routes.profile')) {
            Route::get('profile/edit', 'ProfileEditController@edit')->name('profile.edit');
            Route::patch('profile/edit', 'ProfileEditController@update')->name('profile.update');
        }
    });

});
