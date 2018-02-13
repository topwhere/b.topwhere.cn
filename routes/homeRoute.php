<?php
/**
 * Created by Sublime.
 * Author: YWW
 * Date: 2018/1/20
 * Time: 15:55
 * API 接口
 */
	/* 用户 */
	Route::get("/registerFirst",'UserController@registerFirst');
	Route::get("/registerSec",'UserController@registerSec');
	Route::get("/perfectData",'UserController@perfectData');
	Route::get("/loginIn",'UserController@loginIn');
	#Route::get("/loginIn",'UserController@loginIn');

	/* 酒店 */
	Route::get("/maphotel",'HotelController@maphotel');
	Route::get("/searchotel",'HotelController@searchotel');
	Route::get("/nearbyhotel",'HotelController@nearbyhotel');
	Route::get("/hoteldetails",'HotelController@hoteldetails');
	Route::get("/roomdetails",'HotelController@roomdetails');

	/* 筛选条件 */
	Route::get("/chooseArea",'MapController@chooseArea');

	/* 优惠券 */
	Route::get("/coupon",'CouponController@coupon');
	Route::get("/couponDetails",'CouponController@couponDetails');

	/* 个人中心 */
	Route::get("/center",'CenterController@center');
	Route::get("/mydata",'CenterController@myData');
	Route::get("/invoice",'CenterController@invoice');
	Route::get("/mydata",'CenterController@myData');
	Route::get("/myRefund",'CenterController@myRefund');
	Route::get("/refundDetails",'CenterController@refundDetails');
	Route::get("/myIntegral",'CenterController@myIntegral');

	/* 订单管理 */
	Route::get("/order",'OrderController@order');
	Route::get("/writeIndent",'OrderController@writeIndent');
	Route::get("/orderDetails",'OrderController@orderDetails');
	Route::get("/orderDetails",'OrderController@orderDetails');
	Route::get("/housePriceDetails",'OrderController@housePriceDetails');


	// Route::post("/register",'UserController@register');
	// Route::post("/validcode",'UserController@validcode');
	// Route::post("/login",'UserController@login');
	// Route::get("/sendcode/{type}/{phone}",'UserController@sendcode');
