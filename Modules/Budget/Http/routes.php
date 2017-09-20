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
        Route::post('credit_distribution_def/rows/register', 'BudgetAdminController@registerCreditDistributionRow');
        Route::get('credit_distribution_def/rows/delete/{cdId}', 'BudgetAdminController@deleteCreditDistributionRow');
        Route::get('credit_distribution_def/rows/CDRIsExist/{cdSubject}/{cdId?}', 'BudgetAdminController@CDRIsExist');
        Route::post('credit_distribution_def/rows/update', 'BudgetAdminController@updateCreditDistributionRow');
        Route::post('credit_distribution_def/budget_season/register', 'BudgetAdminController@registerBudgetSeason');
        Route::get('credit_distribution_def/budget_season/delete/{bsId}', 'BudgetAdminController@deleteBudgetSeason');
        Route::get('credit_distribution_def/budget_season/BSIsExist/{bsSubject}/{bsId?}', 'BudgetAdminController@BSIsExist');
        Route::post('credit_distribution_def/budget_season/update', 'BudgetAdminController@updateBudgetSeason');
        Route::post('credit_distribution_def/plan_title/register', 'BudgetAdminController@registerPlanTitle');
        Route::get('credit_distribution_def/plan_title/CDPTIsExist/{cdptIdNumber}/{cdptSubject}/{cdptId?}', 'BudgetAdminController@CDPTIsExist');
        Route::post('credit_distribution_def/plan_title/update', 'BudgetAdminController@updatePlanTitle');
        Route::get('credit_distribution_def/plan_title/delete/{cdptId}', 'BudgetAdminController@deletePlanTitle');
        //////////////////////////////////////////////////////////////////////
        Route::get('sub_seasons', 'BudgetAdminController@subSeasons');
        //Route::post('sub_seasons/register', 'BudgetAdminController@registerSubSeason');
        Route::get('sub_seasons/delete/{ssId}', 'BudgetAdminController@deleteSubSeason');
        Route::get('sub_seasons/SSIsExist/{sId}/{tsSubject}/{tsId?}', 'BudgetAdminController@SSIsExist');
        Route::post('sub_seasons/update', 'BudgetAdminController@updateSubSeason');

        Route::get('sub_seasons/fetchData', 'BudgetAdminController@FetchTinySeasonData');
        Route::post('sub_seasons/register', 'BudgetAdminController@registerTinySeason');
        Route::post('sub_seasons/update', 'BudgetAdminController@updateTinySeason');
        Route::post('sub_seasons/delete', 'BudgetAdminController@deleteTinySeason');
        ///////////////////////////////////////////////////////////////////////
        Route::get('row_distribution_credit', 'BudgetAdminController@rowDistributionCredit');
        Route::get('row_distribution_credit/fetchData', 'BudgetAdminController@FetchRowDC');
        Route::post('row_distribution_credit/register', 'BudgetAdminController@registerRowDC');
        Route::post('row_distribution_credit/update', 'BudgetAdminController@updateRowDC');
        Route::post('row_distribution_credit/delete', 'BudgetAdminController@deleteRowDC');
        ///////////////////////////////////////////////////////////////////////
        Route::get('title_of_plans', 'BudgetAdminController@titleOfPlans');
    });

    //////////////////////////////////////////////////////////////////////////
    Route::prefix('credit_distribution')->group(function () {
        Route::get('capital_assets/provincial/plans', 'CreditDistributionController@creditDistributionPlan');
        Route::post('capital_assets/provincial/plans/register', 'CreditDistributionController@registerCreditDistributionPlan');
        Route::get('capital_assets/provincial/plans/delete/{cdtId}/{cdrId}', 'CreditDistributionController@deleteCreditDistributionPlan');
        Route::get('capital_assets/provincial/plans/CDPIsExist/{cdtId}/{cdrId}', 'CreditDistributionController@CDPIsExist');
        Route::post('capital_assets/provincial/plans/update', 'CreditDistributionController@updateCreditDistributionPlan');
        Route::get('capital_assets/provincial/proposal', 'CreditDistributionController@provincialBudgetProposal');
        Route::get('capital_assets/provincial/proposal/getPlans/{coId}', 'CreditDistributionController@getPlans');
        Route::post('capital_assets/provincial/proposal/register', 'CreditDistributionController@registerProvincialBudgetProposal');
        Route::get('capital_assets/provincial/proposal/getPlanRemainingAmount/{cdpId}', 'CreditDistributionController@getPlanRemainingAmount');
        Route::get('capital_assets/provincial/proposal/delete/{pbpId}', 'CreditDistributionController@deleteProvincialBudgetProposal');
        Route::post('capital_assets/provincial/proposal/update', 'CreditDistributionController@updateProvincialBudgetProposal');
        Route::get('capital_assets/provincial/proposal/PBPIsExist/{pbpSubject}/{pbpCode}/{pbpId?}', 'CreditDistributionController@PBPIsExist');
    });
    ///////////////////////////////////////////////////////////////////////////
    Route::prefix('plan')->group(function () {
        Route::get('capital_assets/plans', 'PlanController@capitalAssetsApprovedPlan');
        Route::post('capital_assets/plans/register', 'PlanController@registerCapitalAssetsApprovedPlan');
        Route::get('capital_assets/plans/delete/{capId}', 'PlanController@deleteCapitalAssetsApprovedPlan');
        Route::post('capital_assets/plans/CAPIsExist', 'PlanController@CAPIsExist');
        Route::post('capital_assets/plans/update', 'PlanController@updateCapitalAssetsApprovedPlan');
    });
    ///////////////////////////////////////////////////////////////////////////

});
