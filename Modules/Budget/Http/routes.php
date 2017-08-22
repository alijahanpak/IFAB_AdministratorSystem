<?php

Route::group(['middleware' => 'web', 'prefix' => 'budget', 'namespace' => 'Modules\Budget\Http\Controllers'], function()
{
    Route::get('/', 'BudgetController@dashboard');

    /////////////////////// budget admin routes //////////////////////////////
    Route::prefix('admin')->group(function () {
        Route::get('deprived_area', 'BudgetAdminController@deprivedArea');
        Route::post('deprived_area/register', 'BudgetAdminController@registerDeprivedArea');
        Route::post('deprived_area/update', 'BudgetAdminController@updateDeprivedArea');
        Route::get('deprived_area/delete/{dId}', 'BudgetAdminController@deleteDeprivedArea');
        Route::get('deprived_area/DAIsExist/{coId}/{reId?}/{rdId?}/{viId?}', 'BudgetAdminController@DAIsExist');
        Route::get('deprived_area/DAIsExistForUpdate/{daId}/{coId}/{reId?}/{rdId?}/{viId?}', 'BudgetAdminController@DAIsExistForUpdate');
        /////////////////////////////////////////////////////////////////////
        Route::get('fiscal_year', 'BudgetAdminController@fiscalYear');
        Route::post('fiscal_year/activation', 'BudgetAdminController@fiscalYearActivation');
        Route::get('fiscal_year/checkSectionPermissionState/{section}/{fyId}', 'BudgetAdminController@checkSectionPermissionState');
        Route::get('fiscal_year/changeBudgetItemPermissionState/{pbId}/{state}', 'BudgetAdminController@changeBudgetItemPermissionState');
        Route::get('fiscal_year/changeSectionPermissionState/{section}/{fyId}/{state}', 'BudgetAdminController@changeSectionPermissionState');
        //////////////////////////////////////////////////////////////////////
        Route::get('credit_distribution_def', 'BudgetAdminController@creditDistributionDef');
        Route::post('credit_distribution_def/register', 'BudgetAdminController@registerCreditDistributionDef');
        Route::get('credit_distribution_def/delete/{cdId}', 'BudgetAdminController@deleteCreditDistributionDef');
        Route::get('credit_distribution_def/CDRIsExist/{cdSubject}/{cdId?}', 'BudgetAdminController@CDRIsExist');
        Route::post('credit_distribution_def/update', 'BudgetAdminController@updateCreditDistributionDef');
    });
    //////////////////////////////////////////////////////////////////////////
});
