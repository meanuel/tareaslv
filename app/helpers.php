<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


function multiCompany($detemp, $detapl)
{
    $company = DB::connection('mysql')->table('root_000051')
    ->select('Detval AS detval')
    ->where([
            ['Detemp', $detemp],
            ['Detapl', $detapl]
        ])
    ->get();

    if($company != null) {
        $detval = $company[0]->detval;
        return $detval;
    } else {
        return 'The company does not exist';
    }
}

function company(Request $request){
    $company = $request->all();
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://10.17.2.35/include/root/comunapi.php?op=consultarAliasPorAplicacion', [
            'form_params' => [
                'codigoInstitucion' => $company['codigoInstitucion'],
                'nombreAplicacion' => $company['nombreAplicacion']         
            ]
        ]);
        $response = json_decode($response->getBody());
        
        return $response;
}

