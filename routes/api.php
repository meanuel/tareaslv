<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\_000039;
use App\Http\Controllers\MultiCompanyController;
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


