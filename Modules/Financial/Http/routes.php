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
        Route::get('received/unread_count', 'RequestController@getUnReadReceivedRequestCount');
        Route::post('received/was_seen', 'RequestController@wasSeen');
        Route::get('steps/fetchData', 'RequestController@fetchRequestSteps');
        Route::get('search/normal/fetchData', 'RequestController@normalSearch');
        Route::post('referral', 'RequestController@referral');
        Route::post('response', 'RequestController@response');
        Route::post('accept', 'RequestController@accept');
        Route::post('secretariat/numbering/register', 'RequestController@numbering');
        Route::get('financing', 'FinanceController@fetchAllFinancing');
        Route::post('financing/reservation', 'FinanceController@reserveFinancing');
        Route::post('financing/accept', 'FinanceController@acceptFinancing');
    });

    Route::prefix('commodity')->group(function () {
        Route::get('/fetchData', 'CommodityController@fetchAllCommodities');
    });
});
