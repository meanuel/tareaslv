<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\_000039;
use App\Http\Controllers\MultiCompanyController;
use App\Http\Controllers\Root\Procesos\MaestrosMatrix\MatrixMasterController;
use GuzzleHttp\Client;


//Rutas de Auth
// require __DIR__ . '/Auth/AuthRoutes.php';

//Routes Auth AUNA
require __DIR__ . '/authAuna/authAunaRoutes.php';



Route::get('/try', function () {
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'http://jsonplaceholder.typicode.com',
        // You can set any number of default request options.
        'timeout'  => 2.0,
    ]);

    $response = $client->request('GET', 'posts');

    return json_decode($response->getBody()->getContents());
});

// --------------------- Functions will go here -----------------------------

Route::get('/multi-company/{detemp}/{detapl}', function ($detemp,$detapl) {
    $detval = multiCompany($detemp, $detapl);
    return $detval;
});

// --------------------- Controllers will go here -----------------------------

// Route::get('/company/{detemp}/{detapl}', [MultiCompanyController::class, 'index']);
Route::post('/example-multi-company', [MultiCompanyController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
// ------------------------Matrix Master -------------------------------------

    Route::prefix('root')->group(function () {
        Route::prefix('/procesos')->group(function () {
            Route::prefix('/maestros-matrix')->group(function () {
                Route::get('/permisos', [MatrixMasterController::class, 'permissions']);
                Route::get('/nombres-columnas-crear/{table_name}', [MatrixMasterController::class, 'columnNamesCreate']);
                Route::get('/nombres-columnas-actualizar/{table_name}', [MatrixMasterController::class, 'columnNamesUpdate']);
                Route::post('/descripcion-columna', [MatrixMasterController::class, 'columnDescription']);

                Route::prefix('editar-datos-matrix')->group(function () {
                    Route::get('/{table_name}', [MatrixMasterController::class, 'dynamicReadValidation']);
                    Route::post('/registrar/{table_name}', [MatrixMasterController::class, 'dynamicCreateValidation']);
                    Route::put('/actualizar/{table_name}/{id}', [MatrixMasterController::class, 'dynamicUpdateValidation']);
                    Route::delete('/eliminar/{table_name}/{id}', [MatrixMasterController::class, 'dinamicDeleteValidation']);

                });
            });
        });
    });

});

