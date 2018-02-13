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

Route::get('/',function (){
    return redirect('admin');
});
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){
    require base_path('routes/adminRoute.php');
});
Route::group(['prefix'=>'api','namespace'=>'Api'],function (){
    require base_path('routes/apiRoute.php');
});
Route::group(['prefix'=>'home','namespace'=>'Home'],function (){
    require base_path('routes/homeRoute.php');
});