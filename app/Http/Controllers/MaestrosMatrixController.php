<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaestrosMatrixController extends Controller
{
    public function permisos()
    {

        $data = DB::table('root_000105')->where('Tabusu', Auth::user()->Codigo)->where('Tabest', 'on')->get(['Tabtab', 'Tabcvi', 'Tabcam', 'Tabpgr', 'Tabopc']);

        return response()->json([
            'data' => $data,
            'message' => 'Retorno de datos correctos',
            'res' => 'true'
        ]);
    }

    public function datos(Request $request)
    {
        $request->validate([
            "tabla" => "required|string"
        ]);

        $permisos = DB::table('root_000105')->where('Tabusu', Auth::user()->Codigo)->where('Tabtab', $request->tabla)->first(['Tabcvi', 'Tabcam', 'Tabpgr', 'Tabopc']);

        return response()->json([
            'data' => [
                'permisos' => $permisos,
                
            ],
            'message' => 'Retorno de datos correctos',
            'res' => 'true'
        ]);
    }
}
