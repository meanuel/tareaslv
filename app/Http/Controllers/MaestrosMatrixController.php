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

        // permisos
        $permisos = DB::table('root_000105')->where('Tabusu', Auth::user()->Codigo)->where('Tabtab', $request->tabla)->first(['Tabcvi', 'Tabcam', 'Tabpgr', 'Tabopc']);

        // detalle
        $tabla_consecutivo = explode('_', $request->tabla);
        $detalle = DB::table('det_formulario')->where('medico', $tabla_consecutivo[0])->where('codigo', $tabla_consecutivo[1])->where('activo', 'A')->get(['campo', 'descripcion', 'tipo', 'posicion', 'comentarios']);

        // descripcion
        $descripciones = DB::table('root_000030')->where('Dic_Usuario', $tabla_consecutivo[0])->where('Dic_Formulario', $tabla_consecutivo[1])->get(['Dic_Campo', 'Dic_Descripcion']);

        // data
        $data = DB::table($request->tabla)->get();

        return response()->json([
            'data' => [
                'permisos' => $permisos,
                'detalles' => $detalle,
                'descripciones' => $descripciones,
                'data' => $data
            ],
            'message' => 'Retorno de datos correctos',
            'res' => 'true'
        ]);
    }
}
