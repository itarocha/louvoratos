<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Arquivos
//Route::get('arquivos','ArquivoController@index');
//Route::get('arquivos/{id}','ArquivoController@show');
Route::post('arquivos','ArquivoController@save');
//Route::put('arquivos/{id}','ArquivoController@update');
//Route::delete('arquivos/{id}','ArquivoController@delete');

Route::get('/ajax/carregarcifra', 'AjaxController@carregarcifra');
