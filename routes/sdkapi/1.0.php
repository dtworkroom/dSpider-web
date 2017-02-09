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

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

//dispatch
//Route::group(['middleware' => 'https'], function () {
Route::group([], function () {
    Route::match(["get","post"],'/test',function(){
        return "test";
    });
    Route::match(["get","post"],'/script',"SdkController@getTask" );
    Route::match(["get","post"],'/report',"SdkController@reportState" );
    Route::match(["get","post"],'/device/save',"SdkController@saveDevice" );
});