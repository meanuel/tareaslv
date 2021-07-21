<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Rutas de Auth
require __DIR__ . '/Auth/AuthRoutes.php';

//Rutas de tareas
require __DIR__ . '/Task/TaskRoutes.php';

//Rutas de Formularios
require __DIR__ . '/Formulario/FormularioRoutes.php';
