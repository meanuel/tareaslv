<?php

namespace App\Http\Controllers\Root\Procesos\MaestrosMatrix;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MatrixMasterController extends Controller
{
    public function permissions()
    {
        // dd(company($request));
        // dd(Auth::user()->Codigo);
        $data = DB::connection('mysql')->table('root_000105')->where('Tabusu', Auth::user()->Codigo)->get();
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
