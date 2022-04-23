<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

Route::get('/MaestrosMatrix/permisos', 'MaestrosMatrixController@permisos')->middleware('auth:sanctum');
Route::post('/MaestrosMatrix/datos', 'MaestrosMatrixController@datos')->middleware('auth:sanctum');
