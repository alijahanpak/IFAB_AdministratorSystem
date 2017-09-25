<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::get('/', 'AdminController@index');
    ///////////////////////////// admin ajax methods //////////////////////////////
    Route::get('/getCountyRegions/{cId}' , 'AdminController@getRegionsByCountyId');
    Route::get('/getRuralDistrictByRegionId/{rId}' , 'AdminController@getRuralDistrictByRegionId');
    Route::get('/getVillagesByRuralDistrictId/{rId}' , 'AdminController@getVillagesByRuralDistrictId');
    ///////////////////////////////////////////////////////////////////////////////
    Route::get('/get_all_counties' , 'AdminController@getAllCounties');
    Route::get('/get_all_seasons' , 'AdminController@getAllSeasons');
});
