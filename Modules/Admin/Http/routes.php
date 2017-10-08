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
});
