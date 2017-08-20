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
        Route::get('fiscal_year', 'BudgetAdminController@fiscalYear');
        Route::post('fiscal_year/activation', 'BudgetAdminController@fiscalYearActivation');
    });
    //////////////////////////////////////////////////////////////////////////
});
