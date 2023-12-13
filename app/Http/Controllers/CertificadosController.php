<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CertificadosController extends Controller
{
    public function consultar_certificado(Request $request)
    {
        $cuerpo = [
            "chrceranio" => $request->CHRCERANIO,
            "vchcernumero" => $request->VCHCERNUMERO,
            "vchdoccodigo" => $request->VCHDOCCODIGO,
            "vchlotcodigo" => $request->VCHLOTCODIGO,
            "vchcurdescripcion" => $request->VCHCURDESCRIPCION,
            "vchcersolicitante" => $request->VCHCERSOLICITANTE,
            "vchviadescripcion" => $request->VCHTVIDESCRIPCION,
            "datfechadesde" => $request->DATFECHADESDE,
            "datfechahasta" => $request->DATFECHAHASTA
        ];


        $url = "http://192.0.0.57/pruebasPIDEMSS/servicios/numeracion/l2Cert?entidad=201&sistema=609&key=400";
        // $url = "172.16.2.28:8070/pidemss/servicios/numeracion/lCert?entidad=201&sistema=609&key=400";

        try {
            $response = Http::post($url, $cuerpo);
            $resp = $response->json();

            if ($resp['contenido'] > 0) {
                return response()->json(['contenido' => $resp]);
            } else {
                return response()->json(['msg' => 'Servicio no responde']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
