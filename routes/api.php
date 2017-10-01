<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/login' , 'AuthController@login_api');
Route::post('/userIsAuthorize' , 'AuthController@userIsAuthorize')->middleware('auth_api:api');

/*Route::get('/user', function () {
    echo Auth::user()->name;
})->middleware('auth_api:api');*/