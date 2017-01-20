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

//test

Route::match(["get", "post"], '/test', function(){
  return view("test");
});


//Auth
Auth::routes();
Route::get('/home', 'HomeController@index');

//Index
Route::get('/', function () {
    return view('welcome');
});
Route::get('/spider', function () {
    return view('welcome');
});
Route::get('/spider/{id}',"PublicController@spider");

Route::get('/apiTest', function () {
    return view('apiTest');
});

Route::get('/download',function(){
    return view("download",["title"=>"下载"]);
});

Route::get('/document/{id?}', "PublicController@doc");

Route::get('/download/docs/{id}', "PublicController@downloadDoc");
Route::get('/download/open/{name}', "PublicController@downloadWithStatistic");


//web route
Route::group(['middleware' => 'auth', 'prefix' => 'profile'], function () {

    Route::group(['middleware' => 'auth', 'prefix' => 'spider'], function () {
        Route::get('/save/{id?}', function ($id=0) {
            return view('profile.spider-edit',qs(['id'=>$id]));
        });
        Route::get('/', function () {
            return view('profile.spiders',['title'=>"我的脚本"]);
        });
    });

    Route::get('/appkey/save/{id?}', function($id=0){
        return view('profile.appkey',qs(['id'=>$id]));
    });

    Route::get('/record/appkey/{id}', function($id=0){
        return view('profile.records',qs(['id'=>$id]));
    });

    Route::get('/record/spider/{id}', "PublicController@getRecordsBySpiderId");

    Route::get('/record/{id}', "PublicController@record");


   // Route::get('/{id}', "ProfileController@index");

});






