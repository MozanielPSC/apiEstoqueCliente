<?php

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

Route::post('signIn', 'App\Http\Controllers\Auth@signIn');
Route::post('retornoprocesso', 'App\Http\Controllers\Processo@retorno');
Route::post('consultaParametros', 'App\Http\Controllers\Order@consultaParametros');
Route::post('usuario','App\Http\Controllers\User@select');
Route::post('usuarioSenha', 'App\Http\Controllers\User@senha');
Route::prefix('separacao')->group(function () {
    Route::post('codigo/{codpedido}', 'App\Http\Controllers\Order@separacao');
    Route::post('proximo', 'App\Http\Controllers\Order@proximo');
    Route::post('status', 'App\Http\Controllers\Order@status');
    Route::post('confirmaRecebimento', 'App\Http\Controllers\Order@confirmaRecebimento');
});
Route::prefix('pedidos')->group(function () {
    Route::post('create', 'App\Http\Controllers\Order@cadastraPedido');
});
Route::prefix('products')
    ->group(function () {
        Route::post('byDesc', 'App\Http\Controllers\Product@getByDesc');
        Route::post('byCode', 'App\Http\Controllers\Product@getByCode');
    });

Route::prefix('empresas')
    ->group(function () {
        Route::post('byCnpj', 'App\Http\Controllers\Empresa@searchByCnpj');
        Route::post('create', 'App\Http\Controllers\Empresa@createEnterprise');
        Route::post('update', 'App\Http\Controllers\Empresa@updateEnterprise');
    });
Route::prefix('codigo')->group(function () {
    Route::post('show/{idCnpj}', 'App\Http\Controllers\Codigo@showCodigos');
    Route::post('create', 'App\Http\Controllers\Codigo@createCodigo');
    Route::post('cadastro', 'App\Http\Controllers\Codigo@cadastro');
});
Route::prefix('terminal')
    ->group(function () {
        Route::post('byKey/{key}', 'App\Http\Controllers\Terminal@findByKey');
        Route::post('create', 'App\Http\Controllers\Terminal@createTerminal');
    });
