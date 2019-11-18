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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('api/desempenho','AgenceController@apiDesempenho')->name('apiDesempenho');
Route::post('api/grafico','AgenceController@apiGrafico')->name('apiGrafico');
Route::post('api/pizza','AgenceController@apiPizza')->name('apiPizza');