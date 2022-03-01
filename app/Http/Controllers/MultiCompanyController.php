<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;


class MultiCompanyController extends Controller
{
    public function index(Request $request)
    {
        // dd(company($request));
        $company = DB::connection('mysql')->table(company($request).'_000039')->get();
        return $company;
    }
}
