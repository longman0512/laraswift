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

// Route::middleware('auth:api')->post('/getplantedtree', function (Request $request) {
//     return response()->json(
//     ['status'=>true]
// );
// });

// Route::group(['prefix' => 'v1'], function(){
//     Route::post('/getplantedtree', '\App\Http\Controllers\TreeController@getplantedtree');
// });

Route::post('/getplantedtree', '\App\Http\Controllers\APIcontroller@getplantedtree');
