<?php

Route::group(['middleware' => 'web', 'prefix' => 'budget', 'namespace' => 'Modules\Budget\Http\Controllers'], function()
{
    Route::get('/', 'BudgetController@dashboard');
});

///////////////////////////////////////// api route /////////////////////////////////

Route::group(['middleware' => ['api' , 'auth_api:api'], 'prefix' => 'budget', 'namespace' => 'Modules\Budget\Http\Controllers'], function()
{
    Route::prefix('credit_distribution')->group(function () {
        Route::get('capital_assets/provincial/plans/fetchData', 'CreditDistributionController@fetchCreditDistributionPlan');
        Route::post('capital_assets/provincial/plans/register', 'CreditDistributionController@registerCreditDistributionPlan');
        Route::get('capital_assets/provincial/plans/getAllWithCountyId', 'CreditDistributionController@getPlansWithCountyId');
        Route::get('capital_assets/provincial/plans/getPlanRemainingAmount', 'CreditDistributionController@getPlanRemainingAmount');
        Route::post('capital_assets/provincial/plans/delete', 'CreditDistributionController@deleteCreditDistributionPlan');
        Route::post('capital_assets/provincial/plans/update', 'CreditDistributionController@updateCreditDistributionPlan');
        Route::get('capital_assets/provincial/proposal/fetchData', 'CreditDistributionController@fetchProvincialBudgetProposalData');
        Route::post('capital_assets/provincial/proposal/register', 'CreditDistributionController@registerProvincialBudgetProposal');
        Route::post('capital_assets/provincial/proposal/delete', 'CreditDistributionController@deleteProvincialBudgetProposal');
        Route::post('capital_assets/provincial/proposal/update', 'CreditDistributionController@updateProvincialBudgetProposal');
        Route::post('/report', 'BudgetReportController@planProvincial');
        Route::post('/report', 'BudgetReportController@proposalProvincial');
    });

    Route::prefix('admin/sub_seasons/cost')->group(function () {
        Route::get('/fetchData', 'BudgetAdminController@FetchCostTinySeasonData');
        Route::get('/getAllItem', 'BudgetAdminController@getAllCostTinySeason');
        Route::post('/register', 'BudgetAdminController@registerCostTinySeason');
        Route::post('/update', 'BudgetAdminController@updateCostTinySeason');
        Route::post('/delete', 'BudgetAdminController@deleteCostTinySeason');
    });

    Route::prefix('admin/sub_seasons/capital_assets')->group(function () {
        Route::get('/fetchData', 'BudgetAdminController@FetchCapitalAssetsTinySeasonData');
        Route::get('/getAllItem', 'BudgetAdminController@getAllCapitalAssetsTinySeason');
        Route::post('/register', 'BudgetAdminController@registerCapitalAssetsTinySeason');
        Route::post('/update', 'BudgetAdminController@updateCapitalAssetsTinySeason');
        Route::post('/delete', 'BudgetAdminController@deleteCapitalAssetsTinySeason');
    });
    /////////////////////////
    Route::prefix('admin/season_title/cost')->group(function () {
        Route::get('/fetchData', 'BudgetAdminController@fetchCostSeasonTitleData');
        Route::get('/getWithSeasonId', 'BudgetAdminController@getCostSeasonTitleWithSId');
        Route::post('/register', 'BudgetAdminController@registerCostSeasonTitle');
        Route::post('/update', 'BudgetAdminController@updateCostSeasonTitle');
        Route::post('/delete', 'BudgetAdminController@deleteCostSeasonTitle')->middleware('auth_api:api');
    });

    Route::prefix('admin/season_title/capital_assets')->group(function () {
        Route::get('/fetchData', 'BudgetAdminController@fetchCapitalAssetsSeasonTitleData');
        Route::get('/getWithSeasonId', 'BudgetAdminController@getCapitalAssetsSeasonTitleWithSId');
        Route::post('/register', 'BudgetAdminController@registerCapitalAssetsSeasonTitle');
        Route::post('/update', 'BudgetAdminController@updateCapitalAssetsSeasonTitle');
        Route::post('/delete', 'BudgetAdminController@deleteCapitalAssetsSeasonTitle');
    });
    //////////////////////////
    Route::prefix('admin/fiscal_year')->group(function () {
        Route::get('/fetchData', 'BudgetAdminController@fetchFiscalYearData');
        Route::get('/getFyPermissionInBudget', 'BudgetAdminController@getFyPermissionInBudget');
        Route::post('/changeSectionPermissionState', 'BudgetAdminController@changeSectionPermissionState');
        Route::post('/changeBudgetItemPermissionState', 'BudgetAdminController@changeBudgetItemPermissionState');
        Route::post('/register', 'BudgetAdminController@registerTinySeason');
        Route::post('/update', 'BudgetAdminController@updateTinySeason');
        Route::post('/delete', 'BudgetAdminController@deleteTinySeason');
        Route::post('/activate', 'BudgetAdminController@fiscalYearActivate');
    });

    Route::prefix('admin/deprived_area')->group(function () {
        Route::get('fetchData', 'BudgetAdminController@fetchDeprivedAreaData');
        Route::post('/register', 'BudgetAdminController@registerDeprivedArea');
        Route::post('/update', 'BudgetAdminController@updateDeprivedArea');
        Route::post('/delete', 'BudgetAdminController@deleteDeprivedArea');
        Route::post('/report', 'BudgetReportController@deprivedAreaProv');

    });

    Route::prefix('admin/credit_distribution_def')->group(function () {
        Route::get('/budget_season/fetchData', 'BudgetAdminController@fetchBudgetSeasonData');
        Route::post('/budget_season/register', 'BudgetAdminController@registerBudgetSeason');
        Route::post('/budget_season/delete', 'BudgetAdminController@deleteBudgetSeason');
        Route::post('/budget_season/update', 'BudgetAdminController@updateBudgetSeason');
        Route::get('/rows/fetchData', 'BudgetAdminController@fetchCreditDistributionRowsData');
        Route::post('/rows/register', 'BudgetAdminController@registerCreditDistributionRow');
        Route::post('/rows/delete', 'BudgetAdminController@deleteCreditDistributionRow');
        Route::post('/rows/update', 'BudgetAdminController@updateCreditDistributionRow');
        Route::get('/rows/getAllItems', 'BudgetAdminController@getAllCDRItems');

        Route::get('/plan_cost_title/fetchData', 'BudgetAdminController@fetchPlanOrCostTitleData');
        Route::post('/plan_cost_title/register', 'BudgetAdminController@registerPlanOrCostTitle');
        Route::post('/plan_cost_title/update', 'BudgetAdminController@updatePlanTitle');
        Route::post('/plan_cost_title/delete', 'BudgetAdminController@deletePlanTitle');
        Route::get('/plan_cost_title/getAllItem', 'BudgetAdminController@getAllPlanOrCostTitleItem');
        Route::post('/report', 'BudgetReportController@planOrCostTitle');

    });

    Route::prefix('approved_plan/capital_assets')->group(function () {
        Route::get('/fetchData', 'PlanController@fetchCapitalAssetsApprovedPlan');
        Route::post('/register', 'PlanController@registerCapitalAssetsApprovedPlan');
        Route::post('/delete', 'PlanController@deleteCapitalAssetsApprovedPlan');
        Route::post('/update', 'PlanController@updateCapitalAssetsApprovedPlan');
        Route::get('/getAllItems', 'PlanController@getAllApprovedPlan');
        Route::post('/report', 'BudgetReportController@approvedPlan');
    });

    Route::prefix('approved_plan/capital_assets/amendment')->group(function () {
        Route::post('/temp/register', 'PlanController@registerApprovedAmendmentTemp');
        Route::post('/temp/cancel', 'PlanController@cancelApprovedAmendmentTemp');
        Route::post('/temp/project/register', 'PlanController@registerAmendmentProjectTemp');
        Route::post('/temp/project/update', 'PlanController@updateAmendmentProjectTemp');
        Route::post('/temp/project/delete', 'PlanController@deleteAmendmentProjectTemp');
        Route::post('/temp/project/credit_source/register', 'PlanController@registerAmendmentProjectCreditSourceTemp');
        Route::post('/temp/project/credit_source/delete', 'PlanController@deleteAmendmentProjectCreditSourceTemp');
        Route::post('/temp/project/credit_source/update', 'PlanController@updateAmendmentProjectCreditSourceTemp');
        Route::post('/accept', 'PlanController@acceptApprovedAmendment');
    });

    Route::prefix('approved_plan/cost')->group(function () {
        Route::get('/fetchData', 'PlanController@fetchCostAgreementData');
        Route::post('/register', 'PlanController@registerCostAgreement');
        Route::post('/delete', 'PlanController@deleteCostAgreement');
        Route::post('/update', 'PlanController@updateCostAgreement');
        Route::get('/getAllItems', 'PlanController@getAllCaItems');
        Route::post('/credit_source/register', 'PlanController@registerCaCreditSource');
        Route::post('/credit_source/update', 'PlanController@updateCaCreditSource');
        Route::post('/credit_source/delete', 'PlanController@deleteCostCaCreditSource');
        Route::get('/credit_source/getAllItem', 'PlanController@getAllcaCreditSourceItems');
        Route::post('/report', 'BudgetReportController@approvedProgram');
    });

    Route::prefix('approved_plan/cost/amendment')->group(function () {
        Route::post('/temp/register', 'PlanController@registerCostAmendmentTemp');
        Route::post('/temp/cancel', 'PlanController@cancelCostAmendmentTemp');
        Route::post('/temp/credit_source/register', 'PlanController@registerCostAmendmentCreditSourceTemp');
        Route::post('/temp/credit_source/delete', 'PlanController@deleteCostAmendmentCreditSourceTemp');
        Route::post('/temp/credit_source/update', 'PlanController@updateCostAmendmentCreditSourceTemp');
        Route::post('/accept', 'PlanController@acceptCostAmendment');
    });

    Route::prefix('approved_project/capital_assets')->group(function () {
        Route::get('/fetchData', 'ProjectController@fetchApprovedProjectData');
        Route::post('/update', 'ProjectController@updateApprovedProject');
        Route::post('/register', 'ProjectController@registerApprovedProject');
        Route::post('/delete', 'ProjectController@deleteApprovedProject');
        Route::get('/getAllItems', 'ProjectController@getAllApprovedProjects');
        Route::post('/credit_source/register', 'ProjectController@registerApCreditSource');
        Route::post('/credit_source/update', 'ProjectController@updateApCreditSource');
        Route::post('/credit_source/delete', 'ProjectController@deleteApCreditSource');
        Route::get('/credit_source/getAllItem', 'ProjectController@getAllApCreditSourceItems');
        Route::post('/report', 'BudgetReportController@approvedProject');
    });

    Route::prefix('admin/how_to_run')->group(function () {
        Route::get('/getAllItems' , 'BudgetAdminController@getAllHowToRun');
    });

    Route::prefix('allocation/capital_assets')->group(function () {
        Route::get('/fetchData', 'AllocationOfCapitalAssetsController@fetchAllocation');
        Route::post('/register', 'AllocationOfCapitalAssetsController@registerCapitalAssetsAllocation');
        Route::post('/update', 'AllocationOfCapitalAssetsController@updateCapitalAssetsAllocation');
        Route::post('/delete', 'AllocationOfCapitalAssetsController@deleteCapitalAssetsAllocation');
        Route::get('/getCapitalAssetsCreditSourceInfo', 'AllocationOfCapitalAssetsController@getCapitalAssetsCreditSourceInfo');
        Route::post('/report', 'BudgetReportController@capitalAssets');
    });

    Route::prefix('allocation/capital_assets/found')->group(function () {
        Route::post('/register', 'AllocationOfCapitalAssetsController@registerCapitalAssetsFound');
        Route::post('/update', 'AllocationOfCapitalAssetsController@updateCapitalAssetsFound');
        Route::post('/delete', 'AllocationOfCapitalAssetsController@deleteCapitalAssetsFound');
        Route::get('/fetchData', 'AllocationOfCapitalAssetsController@fetchFound');
        Route::get('/getAllCapitalAssetsCosts', 'AllocationOfCapitalAssetsController@getAllCapitalAssetsCosts'); // for test convert found to allocation
        Route::post('/convert_to_allocation', 'AllocationOfCapitalAssetsController@convertCapitalAssetsFoundToAllocation'); // for test convert found to allocation
        Route::post('/report', 'BudgetReportController@capitalFoundProvincial');
    });

    Route::prefix('allocation/cost')->group(function () {
        Route::get('/fetchData', 'AllocationOfCapitalAssetsController@fetchCostAllocationData');
        Route::post('/register', 'AllocationOfCapitalAssetsController@registerCostAllocation');
        Route::post('/update', 'AllocationOfCapitalAssetsController@updateCostAllocation');
        Route::post('/delete', 'AllocationOfCapitalAssetsController@deleteCostAllocation');
        Route::get('/getCostCreditSourceInfo', 'AllocationOfCapitalAssetsController@getCostCreditSourceInfo');
        Route::post('/report', 'BudgetReportController@costProvincial');
        Route::post('/report', 'BudgetReportController@costNational');
    });

    Route::prefix('allocation/cost/found')->group(function () {
        Route::post('/register', 'AllocationOfCapitalAssetsController@registerCostFound');
        Route::post('/update', 'AllocationOfCapitalAssetsController@updateCostFound');
        Route::post('/delete', 'AllocationOfCapitalAssetsController@deleteCostFound');
        Route::get('/fetchData', 'AllocationOfCapitalAssetsController@fetchCostFound');
        Route::get('/getAllExpenseCosts', 'AllocationOfCapitalAssetsController@getAllExpenseCosts'); // for test convert found to allocation
        Route::post('/convert_to_allocation', 'AllocationOfCapitalAssetsController@convertCostFoundToAllocation'); // for test convert found to allocation
        Route::post('/report', 'BudgetReportController@costFoundProvincial');
    });
});
