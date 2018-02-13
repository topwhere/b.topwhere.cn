<?php
/**
 * Created by Sublime.
 * Author: YWW
 * Date: 2018/1/10
 * Time: 15:55
 * API 接口
 */
	/* 用户 */
	Route::post("/getcompany",'UserController@getcompany');
	Route::post("/register",'UserController@register');
	Route::post("/validcode",'UserController@validcode');
	Route::get("/sendcode/{type}/{phone}",'UserController@sendcodes');
	Route::get("/pub/{str}",'PubController@dirFile');

	/* 登录退出 */
	Route::post("/login",'UserController@login');
	Route::get("/loginout",'UserController@loginout');

	/* 酒店列表/搜索 */
	Route::post("/maphotel",'HotelController@maphotel');
	Route::post("/searchotel",'HotelController@searchotel');
	Route::post("/nearbyhotel",'HotelController@nearbyhotel');
	Route::post("/hoteldetails",'HotelController@hoteldetails');
	Route::post("/roomdetails",'HotelController@roomdetails');

	/* 获取省、市、区、商业区、品牌 */
	Route::get("/getProvince","MapController@getProvince");
	Route::get("/getCity/{ProvinceId}","MapController@getCity");
	Route::get("/getDistricts/{CityCode}","MapController@getDistricts");
	Route::get("/getCommerical/{CityCode}","MapController@getCommerical");
	Route::get("/getAllBrands","MapController@getAllBrands");
	
	/* 支付回调 */
	Route::any("/weixin","NotifyController@weixin");
	/* 初始化数据 */
	Route::post("/initData","DatasController@initData");

	/* 个人中心 */
	Route::get("/center/{phone}","CenterController@center");
	Route::post("/archives","CenterController@archives");
	Route::post("/myinvoice","CenterController@myinvoice");
	Route::post("/addInvoice","CenterController@addInvoice");
	Route::post("/upInvoice","CenterController@upInvoice");
	Route::post("/myCoupons","CenterController@myCoupons");
	Route::post("/couponDetail","CenterController@couponDetail");
	Route::get("/myintegral/{phone}","CenterController@myintegral");


	/* 订单 */
   	Route::any("/order","OrderController@order");
   	Route::post("/createOrder","OrderController@createOrder");	   	
   	Route::post("/orderPay","OrderController@orderPay");
   	Route::post("/myOrder","OrderController@myOrder");
   	Route::post("/orderDetail","OrderController@orderDetail");
   	Route::post("/refund","OrderController@refund");

   	