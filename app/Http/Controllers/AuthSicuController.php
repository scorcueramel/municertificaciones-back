<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthSicuController extends Controller
{
    private $location = "http://192.0.0.154:8888/services/GandalfsoftSecurityService?wsdl";

    public function auth_login(Request $request)
    {
        $usuario = $request->username;
        $constrasena = $request->pass;
        $sistema = "";
        $ipusuario = "";

        if ($request->sistema == "") {
            $sistema = "SINE";
        } else {
            $sistema = $request->sistema;
        }
        if ($request->ipusuario == "") {
            $ipusuario = "172.16.2.234";
        } else {
            $ipusuario = $request->ipusuario;
        }

        $location = $this->location;
        $request = "
        <soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ws=\"http://ws.security.gandalfsoft.com.pe/\">
        <soapenv:Header/>
            <soapenv:Body>
            <ws:login>
                <usuario>" . $usuario . "</usuario>
                <clave>" . $constrasena . "</clave>
                <sistema>" . $sistema . "</sistema>
                <ipuser>" . $ipusuario . "</ipuser>
            </ws:login>
            </soapenv:Body>
        </soapenv:Envelope>";

        $headers = [
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: text/xml; charset=utf-8',
            'SOAPAction: "login"',
        ];

        $ch = curl_init($location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        $response = curl_exec($ch);
        // $err_status = curl_error($ch);

        $xml = simplexml_load_string($response);

        foreach ($xml->xpath("//return") as $item) {
            $json = json_encode($item);
            $convert_arr = json_decode($json, true);
        }

        return response()->json(['resp' => $convert_arr]);
    }

    public function auth_logout($sessionId)
    {
        $location = $this->location;
        $request = "
        <soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ws=\"http://ws.security.gandalfsoft.com.pe/\">
        <soapenv:Header/>
            <soapenv:Body>
                <ws:logout>
                    <sessionid>" . $sessionId . "</sessionid>
                </ws:logout>
            </soapenv:Body>
        </soapenv:Envelope>
        ";
        $headers = [
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: text/xml; charset=utf-8',
            'SOAPAction: "logout"',
        ];
        $ch = curl_init($location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        $response = curl_exec($ch);
        // $err_status = curl_error($ch);

        $xml = simplexml_load_string($response);

        foreach ($xml->xpath("//return") as $item) {
            $json = json_encode($item);
            $convert_arr = json_decode($json, true);
        }

        return response()->json(['resp' => $convert_arr]);
    }
}
