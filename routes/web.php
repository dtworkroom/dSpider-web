<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/



//Route::get('t/{id}/{name?}', "Test@index")->where("id","[0-9]+")->where("name","[a-zA-z0-9]+");
//
//Route::group(['prefix' => 't'], function () {
//    Route::get('/', "Test@test");
//    Route::get('/{id}/{name?}', "Test@index");
//        //->where("name","[a-zA-z0-9]+");
//});
//Route::get('/test', "Account@login");

//Auth
Auth::routes();
Route::get('/home', 'HomeController@index');

//Index
Route::get('/', function () {
    return view('welcome');
});
Route::get('/apiTest', function () {
    return view('apiTest');
});

//web route
Route::group(['middleware' => 'auth','prefix' => 'profile'], function () {

//    Route::match(["get","post"],'/{id}', "ProfileController@index");

});






