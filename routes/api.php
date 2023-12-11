<?php

use App\Http\Controllers\AuthSicuController;
use App\Http\Controllers\CertificadosController;
use App\Http\Controllers\ReportesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/sicu/login', [AuthSicuController::class,'auth_login']);
Route::get('/auth/sicu/{sessionid}/logout', [AuthSicuController::class,'auth_logout']);
Route::post('/acertificado/consulta', [CertificadosController::class,'consultar_certificado']);
Route::get('/reportes/genera/{codigo}/codigo', [ReportesController::class,'generar_codigo']);

