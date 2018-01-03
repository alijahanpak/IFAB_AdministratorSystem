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

/*Route::get('/user', function (Request $request) {
    return Auth::user()->id;
})->middleware('auth_api:api');*/

Route::post('/login' , 'AuthController@login_api');
Route::post('/userIsAuthorize' , 'AuthController@userIsAuthorize')->middleware('auth_api:api');
Route::get('/getAuthUserInfo' , 'AuthController@getAuthUserInfo')->middleware('auth_api:api');
Route::post('/resetPassword' , 'AuthController@resetPassword')->middleware('auth_api:api');
//Route::post('/refresh_token' , 'AuthController@refreshToken');