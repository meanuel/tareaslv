<?php

namespace App\Http\Controllers\Root\Procesos\MaestrosMatrix;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MatrixMasterController extends Controller
{
    public function permissions()
    {
        // dd(company($request));
        // dd(Auth::user()->Codigo);
        $data = DB::connection('mysql')->table('root_000105')->where('Tabusu', Auth::user()->Codigo)->where('Tabest', 'on')->get();
        if($data) {
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Successful request.',
                'data'      =>  $data,
            ], 200);
        } 
        else {
            return response()->json([
                'success'   =>  false,
                'message'   =>  'The user is not logged in.',
                'data'      =>  $data,
            ], 401);
        }

    }

    public function columnNamesCreate($table_name) 
    {
        $validations = DB::connection('mysql')
        ->table('root_000105')
        ->where('Tabusu', Auth::user()->Codigo)
        ->where('Tabtab', $table_name)
        ->first();

        $data = [];
        if ($validations->Tabpgr == 'on') {
            $columns_create = [];
            $numbers_columns = DB::select(
                (new \Illuminate\Database\Schema\Grammars\MySqlGrammar)->compileColumnListing()
                    .' order by ordinal_position', ['matrix',$table_name]);
            
                foreach($numbers_columns as $item) {
                    if($item->column_name != 'Medico' & 
                            $item->column_name != 'Fecha_data' & 
                            $item->column_name != 'Hora_data' & 
                            $item->column_name != 'Seguridad' & 
                            $item->column_name != 'id'
                            ) {
                            array_push($columns_create, $item->column_name);
                        }
                }
            
                $data = $columns_create;
                if($data) {
                    return response()->json([
                        'success'   =>  true,
                        'message'   =>  'Successful request.',
                        'data'      =>  $data,
                    ], 200);
                } 
            }
            else {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  'The user can not create.',
                    'data'      =>  $data,
                ], 401);
            }
    }
    public function columnNamesUpdate($table_name) 
    {
        $columns_update = [];

        $validations = DB::connection('mysql')
        ->table('root_000105')
        ->where('Tabusu', Auth::user()->Codigo)
        ->where('Tabtab', $table_name)
        ->first();
        if ($validations->Tabcam != '*') {
            $columns_to_validate = $validations->Tabcam;
            $validated_columns = [];
            $unvalidated_columns = [];
            $columns = explode(',', $columns_to_validate);

            foreach ($columns as $column){
                $column_validation = 'SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME = "'.$column.'" and TABLE_NAME = "'.$table_name.'"';
                $results = DB::select($column_validation);
                if($results != null){
                    if($column != 'Medico' & 
                    $column != 'Fecha_data' & 
                    $column != 'Hora_data' & 
                    $column != 'Seguridad' & 
                    $column != 'id'
                    ) {
                    array_push($validated_columns, $column);
                }
                } else {
                    array_push($unvalidated_columns, $column);
                }
            }
            $columns_update = $validated_columns;
        } else {
            $numbers_columns = DB::select(
                (new \Illuminate\Database\Schema\Grammars\MySqlGrammar)->compileColumnListing()
                    .' order by ordinal_position', ['matrix',$table_name]);
            
                foreach($numbers_columns as $item) {
                    if($item->column_name != 'Medico' & 
                        $item->column_name != 'Fecha_data' & 
                        $item->column_name != 'Hora_data' & 
                        $item->column_name != 'Seguridad' & 
                        $item->column_name != 'id'
                        ) {
                        array_push($columns_update, $item->column_name);
                    }
                }
        }
        $data = $columns_update;

        if($data) {
            return response()->json([
                'success'   =>  true,
                'message'   =>  'Successful request.',
                'data'      =>  $data,
            ], 200);
        } 
        else {
            return response()->json([
                'success'   =>  false,
                'message'   =>  'The user can not update.',
                'data'      =>  $data,
            ], 401);
        }

    }

    public function dynamicReadValidation($table_name)
    {
        $validations = DB::connection('mysql')
        ->table('root_000105')
        ->where('Tabusu', Auth::user()->Codigo)
        ->where('Tabtab', $table_name)
        ->first();

        if ($validations->Tabcvi != '*') {
            $columns_to_validate = $validations->Tabcvi;
            $validated_columns = [];
            $unvalidated_columns = [];
            $columns = explode(',', $columns_to_validate);

            foreach ($columns as $column){
                $column_validation = 'SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME = "'.$column.'" and TABLE_NAME = "'.$table_name.'"';
                $results = DB::select($column_validation);

                if($results != null){
                    array_push($validated_columns, $column);
                } else {
                    array_push($unvalidated_columns, $column);
                }
            }

            array_push($validated_columns, 'id');

            $data = DB::connection('mysql')
            ->table($table_name)
            ->select($validated_columns)
            ->get();
            return compact('data', 'unvalidated_columns');
        } else {
            $unvalidated_columns = ['Todas las columnas estan permitidas'];
            $sql = 'select '.$validations->Tabcvi.' from '.$table_name;
            $data = DB::select($sql);
            return compact('data', 'unvalidated_columns');
        }

        
    }   

    public function dynamicCreateValidation($table_name, Request $request)
    {
        $validations = DB::connection('mysql')
        ->table('root_000105')
        ->where('Tabusu', Auth::user()->Codigo)
        ->where('Tabtab', $table_name)
        ->first();

        if ($validations->Tabpgr == 'on') {
            $sql = 'insert into '.$table_name; 

            $numbers_columns = DB::select(
                (new \Illuminate\Database\Schema\Grammars\MySqlGrammar)->compileColumnListing()
                    .' order by ordinal_position', ['matrix',$table_name]);
            
                $array_columns = [];
                foreach($numbers_columns as $item) {
                    if($item->column_name != 'Medico' & 
                        $item->column_name != 'Fecha_data' & 
                        $item->column_name != 'Hora_data' & 
                        $item->column_name != 'Seguridad' & 
                        $item->column_name != 'id'
                        ) {
                        array_push($array_columns, $item->column_name);
                    }
                }
            
            $columns = ' (Medico, Fecha_data, Hora_data, ';
            $values = 'values (?, ?, ?, ';

            if (!empty($array_columns)) {
            
                foreach ($array_columns as $column){
                    $columns.= $column.', ';
                    $values.= '?, ';
                }
                $columns.= 'Seguridad)';
                $values.= '?)';

                $columns = str_replace(', )', ')', $columns);
                $values = str_replace(', )', ')', $values);

                $sql.= $columns." ".$values; 

                $data = [];
                array_push($data, 'root');
                array_push($data, date('Y-m-d'));
                array_push($data, date('H:i:s'));
                foreach ($request->all() as $datum){
                    array_push($data, $datum);
                }
                array_push($data, 'C-'.Auth::user()->Codigo);
                DB::insert($sql, $data);   
            } 
        } else {
            $data = 'El usuario no tiene permiso para grabar';
            return $data;
        }
    }   

    public function dynamicUpdateValidation($table_name, Request $request, $id) {

        $validations = DB::connection('mysql')
        ->table('root_000105')
        ->where('Tabusu', Auth::user()->Codigo)
        ->where('Tabtab', $table_name)
        ->first();

        // if ($validations->Tabcam != '*') {
            $sql = 'update '.$table_name.' set ';
            $data = [];
            foreach ($request->all() as $key => $val) {
                array_push($data, " ".$key."='".$val."'");
            };
            $data = implode(',', $data);

            $sql.= $data.' where id='.$id;
            DB::update($sql);  
        // } else {
            
        // }
                   
         
    }

    public function dinamicDeleteValidation($table_name, $id)
    {
        $validations = DB::connection('mysql')
        ->table('root_000105')
        ->where('Tabusu', Auth::user()->Codigo)
        ->where('Tabtab', $table_name)
        ->first();

        if ($validations->Tabcam == '*') {
            DB::table($table_name)->where('id', '=', $id)->delete();
        } else {
            $data = 'El usurio no tiene permisos para eliminar';
            return $data;
        }
    }  

    public function table1()
    {
        $company = DB::connection('mysql')->table('root_000030')->get();
        return $company;
    }

    public function table2()
    {
        $company = DB::connection('mysql')->table('root_000106')->get();
        return $company;
    }
}
