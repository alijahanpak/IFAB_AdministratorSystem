<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::get('/', 'AdminController@index');
});

Route::group(['middleware' => ['api' , 'auth_api:api'], 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::get('/getCountyRegions' , 'AdminController@getRegionsByCountyId');
    Route::get('/getRuralDistrictByRegionId' , 'AdminController@getRuralDistrictByRegionId');
    Route::get('/getVillagesByRuralDistrictId' , 'AdminController@getVillagesByRuralDistrictId');
    ///////////////////////////////////////////////////////////////////////////////
    Route::get('/get_all_counties' , 'AdminController@getAllCounties');
    Route::get('/get_all_seasons' , 'AdminController@getAllSeasons');
    Route::get('/get_province_plan_label' , 'AdminController@getProvincePlanLabel');

    Route::get('/getPublicParams' , 'AdminController@getPublicParams');
    Route::get('/getAmountBase' , 'AdminController@getAmountBase');
    Route::get('/getAllAmountBase' , 'AdminController@getAllAmountBase');
});


Route::group(['prefix' => 'admin/helpCenter', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::get('/getAllSubSystem' , 'HelpCenterController@getAllSubSystem');
    Route::get('/getHelpCategory' , 'HelpCenterController@getHelpCategory');
    Route::get('/getHelpCenter' , 'HelpCenterController@getHelpCenter');
});

Route::group(['middleware' => ['api' , 'auth_api:api'],'prefix' => 'admin/user', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::get('/getRoleAndPermissions ' , 'AdminController@getRoleAndPermissions');
    Route::post('/uploadAvatar ' , 'AdminController@uploadAvatar');
    Route::post('/changeAmountBase ' , 'AdminController@changeAmountBase');
});
