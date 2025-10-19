<?php

use Illuminate\Support\Facades\Route;

Route::group ([
    'prefix' => 'api',
    'namespace' => 'App\Http\Controllers',
], function () {
    
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
    });

    Route::group(['middleware' => 'jwt.auth.middleware'], function() {
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UserController@index');
            Route::post('/', 'UserController@post');
        });
        Route::group(['prefix' => 'clearance'], function () {
            Route::get('/', 'ClearanceController@index');
            Route::get('{id}', 'ClearanceController@show');
        });
    });
});