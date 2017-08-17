<?php

Route::group(['middleware' => 'web', 'prefix' => 'budget', 'namespace' => 'Modules\Budget\Http\Controllers'], function()
{
    Route::get('/', 'BudgetController@index');

    /////////////////////// budget admin routes //////////////////////////////
    Route::get('/admin/deprived_area', 'BudgetAdminController@deprivedArea');
    Route::post('/admin/deprived_area/register', 'BudgetAdminController@registerDeprivedArea');
    //////////////////////////////////////////////////////////////////////////
});
