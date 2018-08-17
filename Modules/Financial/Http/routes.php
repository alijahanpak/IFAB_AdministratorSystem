<?php

Route::group(['middleware' => 'web', 'prefix' => 'financial', 'namespace' => 'Modules\Financial\Http\Controllers'], function()
{
    Route::get('/', 'FinancialController@index');
});

Route::group(['middleware' => ['api' , 'auth_api:api'], 'prefix' => 'financial', 'namespace' => 'Modules\Financial\Http\Controllers'], function() {
    Route::prefix('request')->group(function () {
        Route::get('types/fetchData', 'RequestController@fetchRequestTypes');
        Route::get('posted/fetchData', 'RequestController@fetchPostedRequestsData');
        Route::post('register', 'RequestController@register');

        Route::get('received/fetchData', 'RequestController@fetchReceivedRequestsData');
        Route::get('steps/fetchData', 'RequestController@fetchRequestSteps');
        Route::get('search/normal/fetchData', 'RequestController@normalSearch');
        Route::post('referral', 'RequestController@referral');
        Route::post('response', 'RequestController@response');
        Route::post('accept', 'RequestController@accept');
    });

    Route::prefix('commodity')->group(function () {
        Route::get('/fetchData', 'CommodityController@fetchAllCommodities');
    });
});
