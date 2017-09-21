<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'AuthController@login');
Route::post('/signin' , 'AuthController@signin');
Route::get('/logout' , 'AuthController@signout');
Route::get('/' , function (){
    return view('index');
});