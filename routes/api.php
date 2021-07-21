<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Rutas de Auth
require __DIR__ . '/Auth/AuthRoutes.php';

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
//Rutas de Formularios
require __DIR__ . '/Formulario/FormularioRoutes.php';
