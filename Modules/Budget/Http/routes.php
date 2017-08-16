<?php

Route::group(['middleware' => 'web', 'prefix' => 'budget', 'namespace' => 'Modules\Budget\Http\Controllers'], function()
{
    Route::get('/', 'BudgetController@index');
    Route::get('/deprived_area', 'BudgetController@deprivedArea');
});
