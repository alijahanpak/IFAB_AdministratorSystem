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
        Route::post('update', 'RequestController@update');
        Route::post('attachment/new', 'RequestController@addNewAttachments');
        Route::post('attachment/delete', 'RequestController@deleteAttachment');
        Route::get('received/fetchData', 'RequestController@fetchReceivedRequestsData');
        Route::get('received/unread_count', 'RequestController@getUnReadReceivedRequestCount');
        Route::post('received/was_seen', 'RequestController@wasSeen');
        Route::get('steps/fetchData', 'RequestController@fetchRequestSteps');
        Route::get('search/normal/fetchData', 'RequestController@normalSearch');
        Route::post('referral', 'RequestController@referral');
        Route::post('response', 'RequestController@response');
        Route::post('block', 'RequestController@block');
        Route::post('terminate', 'RequestController@terminate');
        Route::post('accept', 'RequestController@accept');
        Route::post('secretariat/numbering/register', 'RequestController@numbering');
        Route::get('financing', 'FinanceController@fetchAllFinancing');
        Route::post('financing/reservation', 'FinanceController@reserveFinancing');
        Route::post('financing/accept', 'FinanceController@acceptFinancing');
        Route::post('financing/cost/delete', 'FinanceController@deleteCostFinancing');
        Route::post('financing/cost/update', 'FinanceController@updateCostFinancing');
        Route::post('financing/cap/delete', 'FinanceController@deleteCapFinancing');
        Route::post('financing/cap/update', 'FinanceController@updateCapFinancing');
        Route::post('financing/supply_from_refund', 'FinanceController@supplyFromRefund');
        Route::post('contract/insert', 'ContractController@addNewContract');
        Route::post('contract/accept', 'ContractController@accept');
        Route::post('contract/delete', 'ContractController@delete');
        Route::post('contract/update', 'ContractController@update');
        Route::get('contract/fetchPercentageIncreaseData', 'ContractController@getPercentageIncrease');
        Route::post('factor/insert', 'FactorController@addNewFactor');
        Route::post('factor/accept', 'FactorController@accept');
        Route::post('factor/delete', 'FactorController@delete');
        Route::post('factor/update', 'FactorController@update');

    });

    Route::prefix('refund')->group(function () {
        Route::post('/factor/new', 'FactorController@addNewRefundFactor');
        Route::post('/factor/accept', 'FactorController@acceptAndCalculate');
        Route::post('/factor/reject', 'FactorController@reject');
        Route::post('/factor/delete', 'FactorController@deleteRefundFactor');
        Route::post('/factor/check_request', 'FactorController@checkRefundFactorRequest');
        Route::get('/get_all_refund', 'RefundController@fetchAllRefund');
        Route::get('/fetch_all_refund', 'RefundController@fetchAllRefundData');
    });

    Route::prefix('commodity')->group(function () {
        Route::get('/fetchData', 'CommodityController@fetchAllCommodities');
    });

    Route::prefix('executor')->group(function () {
        Route::get('/fetchData', 'ExecutorController@fetchAllExecutors');
    });

    Route::prefix('seller')->group(function () {
        Route::get('/fetchData', 'SellerController@fetchAllSellers');
    });

    Route::prefix('draft')->group(function () {
        Route::post('/register', 'DraftController@register');
        Route::post('/accept', 'DraftController@accept');
        Route::post('/accept_minute', 'DraftController@acceptMinute');
        Route::post('/numbering', 'DraftController@numbering');
        Route::get('/get_percentage_decrease' , 'DraftController@getPercentageDecrease');
        Route::post('/was_seen', 'DraftController@wasSeen');
        Route::post('/block', 'DraftController@block');
    });

    Route::prefix('check')->group(function () {
        Route::get('/get_check_verifier' , 'CheckController@getCheckVerifier');
        Route::post('/generate' , 'CheckController@generateChecks');
        Route::post('/print/update' , 'CheckController@updateCheckFields');
        Route::get('/list/get_all_data' , 'CheckController@fetchAllChecks');
        Route::post('/deliver' , 'CheckController@deliver');
    });

    Route::prefix('report')->group(function () {
        Route::post('/request' , 'ReportController@request');
        Route::post('/draft' , 'ReportController@draft');
        Route::post('/document' , 'ReportController@document');
        Route::post('/payment_request' , 'ReportController@paymentRequest');
        Route::post('/check' , 'ReportController@check');
    });

    Route::prefix('payment_request')->group(function () {
        Route::post('/register', 'PayRequestController@register');
        Route::get('/get_pay_request_steps' , 'PayRequestController@fetchPayRequestSteps');
        Route::post('/accept', 'PayRequestController@accept');
        Route::post('/numbering', 'PayRequestController@numbering');
        Route::post('/was_seen', 'PayRequestController@wasSeen');
        Route::post('/block', 'PayRequestController@block');
    });

    Route::prefix('deposit')->group(function () {
        Route::get('/fetch_deposit_percentage_category' , 'DepositController@getDepositPercentage');
    });

    Route::prefix('admin')->group(function () {
        Route::post('/check/format/register' , 'CheckController@registerNewFormat');
        Route::get('/check/format/fetch' , 'CheckController@fetchAllCheckFormat');
        Route::get('/check/format/fetch_active_format' , 'CheckController@getActiveCheckFormat');
    });
});
