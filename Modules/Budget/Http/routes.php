<?php

Route::group(['middleware' => 'web', 'prefix' => 'budget', 'namespace' => 'Modules\Budget\Http\Controllers'], function()
{
    Route::get('/', 'BudgetController@dashboard');

    /////////////////////// Report //////////////////////////////
    Route::prefix('approved_plan/capital_assets')->group(function () {
        Route::get('/provincial/report', 'BudgetReportController@approvedPlanProv');
    });
    /////////////////////// Report //////////////////////////////
    Route::prefix('admin')->group(function () {
/*        Route::get('deprived_area', 'BudgetAdminController@deprivedArea');
        Route::post('deprived_area/register', 'BudgetAdminController@registerDeprivedArea');
        Route::post('deprived_area/update', 'BudgetAdminController@updateDeprivedArea');
        Route::get('deprived_area/delete/{dId}', 'BudgetAdminController@deleteDeprivedArea');
        Route::get('deprived_area/DAIsExist/{coId}/{reId?}/{rdId?}/{viId?}', 'BudgetAdminController@DAIsExist');
        Route::get('deprived_area/DAIsExistForUpdate/{daId}/{coId}/{reId?}/{rdId?}/{viId?}', 'BudgetAdminController@DAIsExistForUpdate');*/
        /////////////////////////////////////////////////////////////////////
        //Route::get('fiscal_year', 'BudgetAdminController@fiscalYear');
        //Route::post('fiscal_year/activation', 'BudgetAdminController@fiscalYearActivation');
        //Route::get('fiscal_year/checkSectionPermissionState/{section}/{fyId}', 'BudgetAdminController@checkSectionPermissionState');
        //Route::get('fiscal_year/changeBudgetItemPermissionState/{pbId}/{state}', 'BudgetAdminController@changeBudgetItemPermissionState');
        //Route::get('fiscal_year/changeSectionPermissionState/{section}/{fyId}/{state}', 'BudgetAdminController@changeSectionPermissionState');
        //////////////////////////////////////////////////////////////////////
        //Route::get('credit_distribution_def', 'BudgetAdminController@creditDistributionDef');
/*        Route::post('credit_distribution_def/rows/register', 'BudgetAdminController@registerCreditDistributionRow');
        Route::get('credit_distribution_def/rows/delete/{cdId}', 'BudgetAdminController@deleteCreditDistributionRow');
        Route::get('credit_distribution_def/rows/CDRIsExist/{cdSubject}/{cdId?}', 'BudgetAdminController@CDRIsExist');
        Route::post('credit_distribution_def/rows/update', 'BudgetAdminController@updateCreditDistributionRow');
        Route::get('credit_distribution_def/rows/getAllItems', 'BudgetAdminController@getAllCreditDistributionRows');*/

/*        Route::post('credit_distribution_def/budget_season/register', 'BudgetAdminController@registerBudgetSeason');
        Route::get('credit_distribution_def/budget_season/delete/{bsId}', 'BudgetAdminController@deleteBudgetSeason');
        Route::get('credit_distribution_def/budget_season/BSIsExist/{bsSubject}/{bsId?}', 'BudgetAdminController@BSIsExist');
        Route::post('credit_distribution_def/budget_season/update', 'BudgetAdminController@updateBudgetSeason');*/
/*        Route::post('credit_distribution_def/plan_title/register', 'BudgetAdminController@registerPlanTitle');
        Route::get('credit_distribution_def/plan_title/CDPTIsExist/{cdptIdNumber}/{cdptSubject}/{cdptId?}', 'BudgetAdminController@CDPTIsExist');
        Route::post('credit_distribution_def/plan_title/update', 'BudgetAdminController@updatePlanTitle');
        Route::get('credit_distribution_def/plan_title/delete/{cdptId}', 'BudgetAdminController@deletePlanTitle');*/
        //////////////////////////////////////////////////////////////////////
/*        Route::get('sub_seasons', 'BudgetAdminController@subSeasons');
        //Route::post('sub_seasons/register', 'BudgetAdminController@registerSubSeason');
        Route::get('sub_seasons/delete/{ssId}', 'BudgetAdminController@deleteSubSeason');
        Route::get('sub_seasons/SSIsExist/{sId}/{tsSubject}/{tsId?}', 'BudgetAdminController@SSIsExist');
        Route::post('sub_seasons/update', 'BudgetAdminController@updateSubSeason');

        Route::get('sub_seasons/fetchData', 'BudgetAdminController@FetchTinySeasonData');
        Route::post('sub_seasons/register', 'BudgetAdminController@registerTinySeason');
        Route::post('sub_seasons/update', 'BudgetAdminController@updateTinySeason');
        Route::post('sub_seasons/delete', 'BudgetAdminController@deleteTinySeason');*/

        //Route::get('sub_seasons/get_tiny_seasons_whit_season_id', 'BudgetAdminController@getTinySeasonsWhitSeasonId');
        ///////////////////////////////////////////////////////////////////////
/*        Route::get('row_distribution_credit', 'BudgetAdminController@rowDistributionCredit');
        Route::get('row_distribution_credit/fetchData', 'BudgetAdminController@FetchRowDC');
        Route::post('row_distribution_credit/register', 'BudgetAdminController@registerRowDC');
        Route::post('row_distribution_credit/update', 'BudgetAdminController@updateRowDC');
        Route::post('row_distribution_credit/delete', 'BudgetAdminController@deleteRowDC');*/
        ///////////////////////////////////////////////////////////////////////
        //Route::get('title_of_plans', 'BudgetAdminController@titleOfPlans');
        //Route::get('title_of_plans/fetchData', 'BudgetAdminController@FetchTitleOfPlan');
        ///////////////////////////////////////////////////////////////////////
        //Route::get('how_to_run/getAllItems' , 'BudgetAdminController@getAllHowToRun');
    });
    //////////////////////////////////////////////////////////////////////////
/*    Route::prefix('credit_distribution')->group(function () {
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
    });*/
    ///////////////////////////////////////////////////////////////////////////
/*    Route::prefix('plan')->group(function () {
        Route::get('capital_assets/plans', 'PlanController@capitalAssetsApprovedPlan');
        Route::post('capital_assets/plans/register', 'PlanController@registerCapitalAssetsApprovedPlan');
        Route::get('capital_assets/plans/delete/{capId}', 'PlanController@deleteCapitalAssetsApprovedPlan');
        Route::post('capital_assets/plans/CAPIsExist', 'PlanController@CAPIsExist');
        Route::post('capital_assets/plans/update', 'PlanController@updateCapitalAssetsApprovedPlan');
        Route::get('capital_assets/plans/getAllItems', 'PlanController@getAllApprovedPlan');
    });*/
    ///////////////////////////////////////////////////////////////////////////
/*    Route::prefix('project')->group(function () {
        Route::get('capital_assets/projects', 'ProjectController@approved_projects');
        Route::get('capital_assets/projects/fetchData', 'ProjectController@FetchApprovedProjects');
        Route::post('capital_assets/projects/register', 'ProjectController@registerCapitalAssetsApprovedProject');
        Route::get('capital_assets/projects/getAllItems', 'ProjectController@getAllApprovedProjects');
    });*/
    ///////////////////////////////////////////////////////////////////////////
/*    Route::prefix('Allocation')->group(function () {
        Route::get('register_of_credit_allocation_assets/Allocation', 'AllocationOfCapitalAssetsController@register_of_credit_allocation_assets');
        Route::get('register_of_credit_allocation_assets/fetchData', 'AllocationOfCapitalAssetsController@FetchAllocation');
        Route::post('register_of_credit_allocation_assets/register', 'AllocationOfCapitalAssetsController@registerCapitalAssetsAllocation');
    });*/

});

///////////////////////////////////////// api route /////////////////////////////////

Route::group(['middleware' => ['api' , 'auth_api:api'], 'prefix' => 'budget', 'namespace' => 'Modules\Budget\Http\Controllers'], function()
{
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
        //Route::post('deprived_area/update', 'BudgetAdminController@updateDeprivedArea');
        //Route::get('deprived_area/delete/{dId}', 'BudgetAdminController@deleteDeprivedArea');
        //Route::get('deprived_area/DAIsExist/{coId}/{reId?}/{rdId?}/{viId?}', 'BudgetAdminController@DAIsExist');
        //Route::get('deprived_area/DAIsExistForUpdate/{daId}/{coId}/{reId?}/{rdId?}/{viId?}', 'BudgetAdminController@DAIsExistForUpdate');
    });

    Route::prefix('admin/credit_distribution_def')->group(function () {
        Route::get('/budget_season/fetchData', 'BudgetAdminController@fetchBudgetSeasonData');
        Route::post('/budget_season/register', 'BudgetAdminController@registerBudgetSeason');
/*        Route::get('/budget_season/delete/{bsId}', 'BudgetAdminController@deleteBudgetSeason');
        Route::post('/budget_season/update', 'BudgetAdminController@updateBudgetSeason');*/
        Route::get('/rows/fetchData', 'BudgetAdminController@fetchCreditDistributionRowsData');
        Route::post('/rows/register', 'BudgetAdminController@registerCreditDistributionRow');
        //Route::get('/rows/delete/{cdId}', 'BudgetAdminController@deleteCreditDistributionRow');
        //Route::post('/rows/update', 'BudgetAdminController@updateCreditDistributionRow');
        Route::get('/rows/getAllItems', 'BudgetAdminController@getAllCDRItems');

        Route::get('/plan_cost_title/fetchData', 'BudgetAdminController@fetchPlanOrCostTitleData');
        Route::post('/plan_cost_title/register', 'BudgetAdminController@registerPlanOrCostTitle');
        //Route::post('credit_distribution_def/plan_title/update', 'BudgetAdminController@updatePlanTitle');
        //Route::get('credit_distribution_def/plan_title/delete/{cdptId}', 'BudgetAdminController@deletePlanTitle');
        Route::get('/plan_cost_title/getAllItem', 'BudgetAdminController@getAllPlanOrCostTitleItem');

    });

    Route::prefix('approved_plan/capital_assets')->group(function () {
        Route::get('/fetchData', 'PlanController@fetchCapitalAssetsApprovedPlan');
        Route::post('/register', 'PlanController@registerCapitalAssetsApprovedPlan');
        //Route::post('/delete', 'PlanController@deleteCapitalAssetsApprovedPlan');
        //Route::post('/update', 'PlanController@updateCapitalAssetsApprovedPlan');
        Route::get('/getAllItems', 'PlanController@getAllApprovedPlan');
        Route::get('/provincial/report', 'BudgetReportController@approvedPlanProv');
    });

    Route::prefix('approved_plan/capital_assets/amendment')->group(function () {
        //Route::get('/fetchData', 'PlanController@fetchCapitalAssetsApprovedPlan');
        Route::post('/temp/register', 'PlanController@registerApprovedAmendmentTemp');
        Route::post('/temp/cancel', 'PlanController@cancelApprovedAmendmentTemp');
        Route::post('/temp/project/register', 'PlanController@registerAmendmentProjectTemp');
        Route::post('/temp/project/update', 'PlanController@updateAmendmentProjectTemp');
        Route::post('/temp/project/delete', 'PlanController@deleteAmendmentProjectTemp');
        Route::post('/temp/project/credit_source/register', 'PlanController@registerAmendmentProjectCreditSourceTemp');
        Route::post('/temp/project/credit_source/delete', 'PlanController@deleteAmendmentProjectCreditSourceTemp');
        Route::post('/temp/project/credit_source/update', 'PlanController@updateAmendmentProjectCreditSourceTemp');
        Route::post('/accept', 'PlanController@acceptApprovedAmendment');
        //Route::post('/delete', 'PlanController@deleteCapitalAssetsApprovedPlan');
        //Route::post('/update', 'PlanController@updateCapitalAssetsApprovedPlan');
        //Route::get('/getAllItems', 'PlanController@getAllApprovedPlan');
    });

    Route::prefix('approved_plan/cost')->group(function () {
        Route::get('/fetchData', 'PlanController@fetchCostAgreementData');
        Route::post('/register', 'PlanController@registerCostAgreement');
        //Route::post('/delete', 'PlanController@deleteCapitalAssetsApprovedPlan');
        //Route::post('/update', 'PlanController@updateCapitalAssetsApprovedPlan');
        Route::get('/getAllItems', 'PlanController@getAllCaItems');
        Route::post('/credit_source/register', 'PlanController@registerCaCreditSource');
        Route::get('/credit_source/getAllItem', 'PlanController@getAllcaCreditSourceItems');
    });

    Route::prefix('approved_project/capital_assets')->group(function () {
        Route::get('/fetchData', 'ProjectController@fetchApprovedProjectData');
        //Route::get('capital_assets/projects/fetchData', 'ProjectController@FetchApprovedProjects');
        Route::post('/register', 'ProjectController@registerApprovedProject');
        Route::get('/getAllItems', 'ProjectController@getAllApprovedProjects');
        Route::post('/credit_source/register', 'ProjectController@registerApCreditSource');
        Route::get('/credit_source/getAllItem', 'ProjectController@getAllApCreditSourceItems');

        //Route::get('/getAllProjectWithPlanId', 'ProjectController@getAllProjectWithPlanId');
    });

    Route::prefix('admin/how_to_run')->group(function () {
        Route::get('/getAllItems' , 'BudgetAdminController@getAllHowToRun');
    });

    Route::prefix('allocation/capital_assets')->group(function () {
        //Route::get('register_of_credit_allocation_assets/Allocation', 'AllocationOfCapitalAssetsController@register_of_credit_allocation_assets');
        Route::get('/fetchData', 'AllocationOfCapitalAssetsController@fetchAllocation');
        Route::post('/register', 'AllocationOfCapitalAssetsController@registerCapitalAssetsAllocation');
        Route::get('/getCapitalAssetsCreditSourceInfo', 'AllocationOfCapitalAssetsController@getCapitalAssetsCreditSourceInfo');
    });

    Route::prefix('allocation/cost')->group(function () {
        //Route::get('register_of_credit_allocation_assets/Allocation', 'AllocationOfCapitalAssetsController@register_of_credit_allocation_assets');
        Route::get('/fetchData', 'AllocationOfCapitalAssetsController@fetchCostAllocationData');
        Route::post('/register', 'AllocationOfCapitalAssetsController@registerCostAllocation');
        Route::get('/getCapitalAssetsCreditSourceInfo', 'AllocationOfCapitalAssetsController@getCapitalAssetsCreditSourceInfo');
    });

    Route::prefix('credit_distribution')->group(function () {
        Route::get('capital_assets/provincial/plans/fetchData', 'CreditDistributionController@fetchCreditDistributionPlan');
        Route::post('capital_assets/provincial/plans/register', 'CreditDistributionController@registerCreditDistributionPlan');
        Route::get('capital_assets/provincial/plans/getAllWithCountyId', 'CreditDistributionController@getPlansWithCountyId');
        Route::get('capital_assets/provincial/plans/getPlanRemainingAmount', 'CreditDistributionController@getPlanRemainingAmount');
//        Route::get('capital_assets/provincial/plans/delete/{cdtId}/{cdrId}', 'CreditDistributionController@deleteCreditDistributionPlan');
//        Route::get('capital_assets/provincial/plans/CDPIsExist/{cdtId}/{cdrId}', 'CreditDistributionController@CDPIsExist');
//        Route::post('capital_assets/provincial/plans/update', 'CreditDistributionController@updateCreditDistributionPlan');
        Route::get('capital_assets/provincial/proposal/fetchData', 'CreditDistributionController@fetchProvincialBudgetProposalData');
        Route::post('capital_assets/provincial/proposal/register', 'CreditDistributionController@registerProvincialBudgetProposal');

//        Route::get('capital_assets/provincial/proposal/delete/{pbpId}', 'CreditDistributionController@deleteProvincialBudgetProposal');
//        Route::post('capital_assets/provincial/proposal/update', 'CreditDistributionController@updateProvincialBudgetProposal');
//        Route::get('capital_assets/provincial/proposal/PBPIsExist/{pbpSubject}/{pbpCode}/{pbpId?}', 'CreditDistributionController@PBPIsExist');
    });
});
