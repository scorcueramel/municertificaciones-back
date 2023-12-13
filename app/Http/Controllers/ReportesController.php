<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReportesController extends Controller
{
    // private $epGeneraCodigo = "http://172.16.2.112:9080/sattWeb/genidrep.genidrep?";
    private $epGeneraCodigo = "http://192.0.0.58:9080/sattWeb/genidrep.genidrep?";

    public function generar_codigo(string $codigo){
        $generaCod = $this->epGeneraCodigo;


        try {
            if(!is_null($codigo)) {
                $response = Http::acceptJson()->get($generaCod."certcod=".$codigo."&opc=rptcnum");
                $resOut = $response->json();
                return response()->json(['code'=>'OK','codigo'=>$resOut]);
            }

        } catch (Exception $e) {
            return response()->json(['code'=>'error','message'=> $e->getMessage()]);
        }
    }

}
