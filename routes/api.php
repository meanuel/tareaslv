<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group([
    'prefix' => 'task'
], function () {
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('tasks', 'TaskController@indexApi');
        Route::post('store', 'TaskController@storeApi');
        Route::get('editView/{id}', 'TaskController@editViewApi');
        Route::post('edit', 'TaskController@editApi');
        Route::post('destroy', 'TaskController@destroyApi');


    });
});
