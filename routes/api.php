<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\_000039;
use App\Http\Controllers\MultiCompanyController;
use App\Http\Controllers\Root\Procesos\MaestrosMatrix\MatrixMasterController;
use GuzzleHttp\Client;

require __DIR__ . '/authAuna/authAunaRoutes.php';

require __DIR__ . '/maestrosMatrix/maestrosMatrix.php';

