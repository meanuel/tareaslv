<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Rutas de Auth
require __DIR__ . '/Auth/AuthRoutes.php';

//Rutas de Task
require __DIR__ . '/Task/TaskRoutes.php';

//Rutas de Formularios
require __DIR__ . '/Formulario/FormularioRoutes.php';