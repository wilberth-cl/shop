<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Support\Jsonable;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('categoria','API\CategoriaController')->names('api.categoria');
Route::apiResource('producto','API\ProductoController')->names('api.producto');
Route::delete('/eliminarimagen/{id}','API\ProductoController@eliminarimagen')->name('api.eliminarimagen');
//Route::get('/autocompletar', 'API\AutocompletarController@autocompletar')->name('autocompletar');
//PRUEBAS JUNTO CON VISTA search.blade.php
Route::get('/busqueda', 'API\AutocompletarController@index');
Route::get('/autocompletar', 'API\AutocompletarController@search')->name('api.autocompletar');

Route::get('/busquedados', 'API\AutocompletarController@indexdos');
