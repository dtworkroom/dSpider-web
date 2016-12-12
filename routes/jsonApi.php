<?php

//auth
Route::get('/login', 'AuthController@login');

//Upload device info
Route::match(["get","post"],'/device/save',"DeviceController@save" );
Route::match(["get","post"],'/device/{id}',"DeviceController@info" );

//dispatch
Route::match(["get","post"],'/script',"SpiderController@getScript" );
Route::match(["get","post"],'/task',"SpiderController@getTask" );
Route::match(["get","post"],'/report',"CrawlRecordsController@reportState" );
//
Route::match(["get","post"],'/user/{id}', "UserController@index");
Route::match(["get","post"],'/spiders',"SpiderController@index" );
Route::match(["get","post"],'/spider/{id}', "SpiderController@getById");


//user center
Route::group(['middleware' => 'auth.api','prefix' => 'profile'], function () {
    //spider
    Route::group(['prefix' => 'spider'], function () {
        Route::get('/',"SpiderController@getAllByUser" );
        Route::match(["get","post"],'/save', "SpiderController@save");
        Route::match(["get","post"],'/delete/{id}', "SpiderController@delete");
       // Route::match(["get","post"],'/{id}', "SpiderController@getOwnById");
    });

    Route::group(['prefix' => 'spider_config'], function () {
        Route::match(["get","post"],'/save', "SpiderConfigController@save");
        Route::match(["get","post"],'/delete/{id}', "SpiderConfigController@delete");
        Route::match(["get","post"],'/{id}', "SpiderConfigController@getById");
    });


    Route::group(['prefix' => 'appkey'], function () {
       // Route::match(["get","post"],'/', "AppKeyController@getAllByUser");
        Route::match(["get","post"],'/save', "AppKeyController@save");
        Route::match(["get","post"],'/{id}/configs', "AppKeyController@getConfigs");
        Route::match(["get","post"],'/{id}', "AppKeyController@getById");

    });

    Route::group(['prefix' => 'records'], function () {
         Route::match(["get","post"],'/', "CrawlRecordsController@getCrawlRecords");
         Route::match(["get","post"],'/{id}', "CrawlRecordsController@getCrawlRecordById");
    });

   // Route::match(["get","post"],'/', "ProfileController@index");
});

//todo 管理员身份认证
Route::group(['middleware' => 'auth.api','prefix' => 'admin'], function () {
    Route::match(["get","post"],'/spider_config/delete/{id}', "AppKeyController@delete");
    Route::match(["get","post"],'/spider_config/save', "AppKeyController@save");
});






