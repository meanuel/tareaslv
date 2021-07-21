<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Rutas de Auth
require __DIR__ . '/Auth/AuthRoutes.php';

//Rutas de Task
require __DIR__ . '/Task/TaskRoutes.php';

<<<<<<< HEAD
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
=======
//Rutas de Formularios
require __DIR__ . '/Formulario/FormularioRoutes.php';
>>>>>>> f6862470ab82f2551e7a60b2b76ab6013cac17ca
