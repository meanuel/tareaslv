<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormularioController extends Controller
{
    /**
     * Mostrar lista de formularios API
     * 
     * @param Request $request
     * @return Response
     * @ToDo Mostrar Formularios con login, y no con medico como parámetro
     */
    public function getFormularios(Request $request)
    {
        $sTipo = (!empty($request->tipo)) ? $request->tipo : null ;
        $sMedico = (!empty($request->medico)) ? $request->medico : 'root';
        $aFormularios = array();
        $aListaFormularios = array();
        $dbName = env('DB_DATABASE', 'forge');

        //Cargo las formularios
        if($sTipo == 'P')
        {
            $aFormularios = Formulario::where('medico', '=', $sMedico)
                                        ->orWhere('tipo', '=', 'A')
                                        ->orderBy('tipo', 'desc')
                                        ->orderBy('medico')
                                        ->orderBy('codigo')
                                        ->get();
        }

        //Obtengo el listado de tablas
        $aTablas = DB::select('SHOW TABLES');
        //Construyo el nombre de la columna
        $sColumnaTablas = 'Tables_in_'.$dbName;

        //Armo un array con el listado de nombres de tablas para optimizar la búsqueda
        $aNameTablas = array();
        foreach ($aTablas as $oTabla) {
            $aNameTablas[] = $oTabla->$sColumnaTablas;
        }
        
        //Busco los formularios que coincidan con tablas
        foreach ($aFormularios as $oFormulario) {
            if (in_array($oFormulario->medico."_".$oFormulario->codigo, $aNameTablas)) {
                
                $oFormularioAux = ['id' => $oFormulario->medico.'_'.$oFormulario->codigo,
                                    'nombre' => $oFormulario->codigo.'-'.$oFormulario->medico.'-'.$oFormulario->tipo.'-'.$oFormulario->nombre];
                $aListaFormularios[] = $oFormularioAux;
            }
        }

        return response()->json($aListaFormularios);
    }

    /**
     * Mostrar lista de datos de un formulario API
     * 
     * @param Request $request
     * @return Response
     * @ToDo Encriptar el id del formulario 
     */
    public function getDataFormulario(Request $request)
    {
        //Valido que se envíe el id de la tabla
        $this->validate($request, [
            'id' => 'required' //Indico que el campo id es obligatorio
        ]);

        $sIdFormulario = (!empty($request->id)) ? $request->id : null ;

        //Obtengo los datos de la tabla
        $aDatosTabla = DB::table($sIdFormulario)->get();

        //Obtengo los datos de las columnas de la tabla
        $aColumnas = DB::select('SHOW COLUMNS FROM '.$sIdFormulario);
        $aNombreColumnas = array();

        //Obtengo solo el nombre de las columnas
        foreach ($aColumnas as $oColumna) {
            $aNombreColumnas[] = $oColumna->Field;
        }

        //Ordeno la respuesta en nombre de las columnas y datos de la tabla
        $aRespuesta = ['nombreColumnas' => $aNombreColumnas,
                        'data' => $aDatosTabla];
        
        return response()->json($aRespuesta);
    }
}
