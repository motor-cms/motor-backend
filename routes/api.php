<?php
Route::group([
    'middleware' => ['auth:api', 'bindings'],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api',
    'prefix'     => 'api',
], function () {
    Route::resource('clients', 'ClientsController');
    Route::resource('languages', 'LanguagesController');
});
