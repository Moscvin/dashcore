<?php

use App\Http\Controllers\Api\Webhooks\WebhooksHandlerController;

use Illuminate\Support\Facades\Route;

Route::group(['controller' => WebhooksHandlerController::class, 'prefix' => 'webhooks', 'middleware' => 'gitlabWebhooksToken'], function () {
    Route::post('/', 'main');
});

Route::group(['namespace' => 'App\Http\Controllers\Api', 'prefix' => 'v1/', 'middleware' => ['api.appToken']], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('/first_login', 'FirstLoginController@main');
        Route::post('/login', 'LoginController@main');        
        Route::post('/retrieve_password', 'RetrievePasswordController@main');
    });
});

