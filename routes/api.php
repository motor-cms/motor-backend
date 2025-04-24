<?php

use Illuminate\Validation\ValidationException;
use Motor\Backend\Http\Controllers\Api\Auth\AuthController;
use Motor\Backend\Http\Controllers\Api\Auth\LoginController;
use Motor\Backend\Http\Controllers\Api\CategoriesController;
use Motor\Backend\Http\Controllers\Api\CategoryTreesController;
use Motor\Backend\Http\Controllers\Api\ClientsController;
use Motor\Backend\Http\Controllers\Api\ConfigVariablesController;
use Motor\Backend\Http\Controllers\Api\EmailTemplatesController;
use Motor\Backend\Http\Controllers\Api\LanguagesController;
use Motor\Backend\Http\Controllers\Api\PermissionGroupsController;
use Motor\Backend\Http\Controllers\Api\PermissionsController;
use Motor\Backend\Http\Controllers\Api\ProfileEditController;
use Motor\Backend\Http\Controllers\Api\RolesController;
use Motor\Backend\Http\Controllers\Api\UsersController;
use Motor\Backend\Models\User;
use Illuminate\Http\Request;

Route::group([
    'middleware' => ['auth:api', 'bindings', 'permission'],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], static function () {
    Route::apiResource('users', UsersController::class);
    Route::apiResource('clients', ClientsController::class);
    Route::apiResource('languages', LanguagesController::class);
    Route::apiResource('roles', RolesController::class);
    Route::apiResource('permissions', PermissionsController::class);
    Route::apiResource('permission_groups', PermissionGroupsController::class);
    Route::apiResource('email_templates', EmailTemplatesController::class);
    Route::apiResource('category_trees', CategoryTreesController::class, [
        'parameters' => [
            'category_trees' => 'category',
        ],
    ]);
    Route::apiResource('category_trees/{category_tree}/categories', CategoriesController::class);

    Route::get('profile', [ProfileEditController::class, 'me'])
         ->name('profile.read');
    Route::put('profile', [ProfileEditController::class, 'update'])
         ->name('profile.update');
    Route::apiResource('config_variables', ConfigVariablesController::class);
});

Route::group([
    'prefix'     => 'api/sanctum',
    'as'         => 'api.sanctum.',
], static function ($router) {
    //Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/login', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            //'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->tokens()->where('name', $request->email)->delete();

        return $user->createToken($request->email)->plainTextToken;
    });
    Route::middleware('auth:sanctum')->get('auth/me', function (Request $request) {
        return $request->user();
    });
    Route::post('auth/logout', [AuthController::class, 'logout']);
});


Route::group([
    'middleware' => ['api', 'bindings'],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api\Auth',
    'prefix'     => 'api/auth',
    'as'         => 'api.auth',

], static function ($router) {
    Route::post('login', [LoginController::class, 'login'])
         ->name('login');
    Route::post('logout', [LoginController::class, 'logout'])
         ->name('logout');
    Route::post('refresh', [LoginController::class, 'refresh'])
         ->name('refresh');
    Route::post('me', [LoginController::class, 'me'])
         ->name('me');
});

Route::group([
    'middleware' => ['web', 'web_auth', 'bindings', 'permission'],
    'namespace'  => 'Motor\Backend\Http\Controllers\Api',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], static function () {
    Route::get('categories', [CategoriesController::class, 'index'])
         ->name('categories.index');
});
