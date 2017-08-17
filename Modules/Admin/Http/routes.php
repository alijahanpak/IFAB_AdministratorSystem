<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::get('/', 'AdminController@index');
    ///////////////////////////// admin ajax methods //////////////////////////////
    Route::get('/getCountyRegions/{cId}' , 'AdminController@getRegionsByCountyId');
    Route::get('/getRuralDistrictByRegionId/{rId}' , 'AdminController@getRuralDistrictByRegionId');
    Route::get('/getVillagesByRuralDistrictId/{rId}' , 'AdminController@getVillagesByRuralDistrictId');
    ///////////////////////////////////////////////////////////////////////////////
});
