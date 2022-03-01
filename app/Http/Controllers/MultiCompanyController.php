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

    public function something($detemp, $detapl)
    {
        $client = new Client([
            // Base URI is used with relative requests
            // 'base_uri' => 'http://jsonplaceholder.typicode.com',
            'base_uri' => 'http://10.17.2.35/include/root/comunapi.php?op=',
            // You can set any number of default request options.
            'timeout'  => 9.0,
        ]);
    
        $response = $client->request('GET', "consultarAliasPorAplicacion/$detemp/$detapl");
    
        $company = json_decode($response->getBody()->getContents());
        return  $company;
    }

    public function some(Request $request)
    {
        $company = $request->all();
        // dd($company['codigoInstitucion']);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://10.17.2.35/include/root/comunapi.php?op=consultarAliasPorAplicacion', [
            'form_params' => [
                'codigoInstitucion' => $company['codigoInstitucion'],
                'nombreAplicacion' => $company['nombreAplicacion']         
            ]
        ]);
        $response = json_decode($response->getBody());
        print_r($response);

    //     $ch = curl_init();
                    
    //                 $data = array( 
    //                         'codigoInstitucion'	=> $company['codigoInstitucion'],
    //                         'nombreAplicacion'		=> $company['nombreAplicacion'],
    //                     );
                    
                    
    //                 // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    //                 // set URL and other appropriate options
    //                 $options = array(
    //                             CURLOPT_URL 			=> 'http://10.17.2.35/include/root/comunapi.php?op=consultarAliasPorAplicacion',
    //                             CURLOPT_HEADER 			=> false,
    //                             CURLOPT_POSTFIELDS 		=> $data,
    //                             CURLOPT_CUSTOMREQUEST 	=> 'POST',
    //                         );

    //                 $opts = curl_setopt_array($ch, $options);
                    
                    
    //                 if( $opts === false )
    //                 echo "Opciones mal configuradas...";
                    
    //                 // grab URL and pass it to the browser
    //                 $exec = curl_exec($ch);
                    
    //                 if( $exec === false ){
    //                     echo "No hizo nada....";
    //                 }
    //                 return $exec;
                    
    //                 // close cURL resource, and free up system resources
    //                 curl_close($ch);
    }
}
