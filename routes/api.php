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
//$api = app('Dingo\Api\Routing\Router');
//$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function($api) {
//    $api->post('token', 'UserController@token');    //获取token
//    $api->post('refresh-token', 'UserController@refershToken'); //刷新token
//
//    $api->group(['middleware' => ['auth:api']], function($api) {
//        $api->post('logout', 'UserController@logout');    //登出
//        $api->get('me', 'UserController@me');    //关于我
//    });
//
//});
Route::group(['prefix'=>'admin','namespace'=>'Api'],function (){
    Route::resource('img','ImageController');//图片处理框
    Route::any('imgsave','CommonController@imgsave')->name('api.imgsave');
    Route::any('editimgsave','CommonController@editimgsave')->name('api.editimgsave');
});
//Route::post('/','Auth\AuthenticateController@authenticate');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
