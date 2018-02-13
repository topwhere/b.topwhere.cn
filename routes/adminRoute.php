<?php
/**
 * Created by PhpStorm.
 * Author: 石头哥 sun@httproot.com
 * Date: 2017/11/17
 * Time: 15:55
 */
Route::get('/login', 'IndexController@login')->name('admin.login');//登录页
Route::post('/login', 'IndexController@loginsub')->name('admin.login');
Route::any('regist', 'IndexController@register')->name('admin.regist');//注册页面
Route::post('regist', 'IndexController@registersub')->name('admin.regist');
Route::get('logout', function () {
    Auth()->logout();
    return redirect()->route('admin.login');
})->name('admin.logout');
Route::group(['middleware' => 'adminlogin'], function () {
    Route::get('/', 'IndexController@index')->name('admin.index');//首页
    Route::post('menu/editStatus', 'MenuController@editStatus');//导航修改状态
    Route::resource('menu', 'MenuController');//导航
    Route::resource('role', 'RoleController');//角色
    Route::resource('admins', 'AdminsController');//管理员
    Route::resource('city', 'CityController');//城市管理
    Route::resource('area', 'AreaController');//区域管理
    Route::resource('busines', 'BusineController');//商圈管理
    Route::resource('subways', 'SubwayController');//地铁管理
    Route::resource('hotel', 'HotelController');//城市管理
    Route::resource('service', 'ServiceController');//设施服务
    Route::resource('room', 'RoomController');//房型管理
    Route::resource('company', 'CompanyController');//房型管理
    Route::post('user_baimingdan', 'UserController@show_baimingdan');//添加成白名单
    Route::put('user_baimingdan', 'UserController@action_baimingdan');//白名单处理
    Route::get('baimingdan', 'UserController@baimingdan');//白名单管理
    Route::post('baimingdan', 'UserController@baimingdandate');//白名单数据
    Route::put('baimingdan/{id}', 'UserController@baimingdandateAction');//白名单数据处理

    Route::resource('user', 'UserController');//用户管理
    Route::resource('integral', 'IntegralController');//积分管理
    Route::resource('grade', 'GradeController');//会员等级设置
    Route::resource('province', 'ProvinceController');//会员等级设置
//    优惠券模块路由
    Route::get('sendcoupon/{id}', 'CouponsController@sendCoupon');//发送优惠券
    Route::post('sendcoupon/{id}', 'CouponsController@sendCouponAction');//发送优惠券
    Route::post('/search', 'CouponsController@search');//查询发送人数
    Route::get('/sendcoupontotal', 'CouponsController@sendCoupontatol');//优惠券统计
    Route::post('/sendcoupontotal', 'CouponsController@dataCoupontatol');//查询发送人数
    Route::resource('coupons', 'CouponsController');//优惠券
//    优惠券模块路由结束
//    订单管理模块开始
    Route::get('/refundorder', 'OrderController@refundorder');//订单退款
    Route::post('/refundorder/{id}', 'OrderController@refundorderaction');//退款订单处理
    Route::resource('order', 'OrderController');//订单管理
//订单管理模块结束
    Route::get('/orderincome', 'SummaryController@orderincome');//订单收入
    Route::post('/orderincome', 'SummaryController@orderincomedata');//订单收入提取数据
    Route::get('/refunds_record', 'SummaryController@refunds_record');//退款记录
    Route::post('/refunds_record', 'SummaryController@refunds_record_data');//退款记录提取数据
    Route::get('/daily_bill', 'SummaryController@daily_bill');//日对账单
    Route::post('/daily_bill', 'SummaryController@daily_bill_data');//日对账单提取数据
    Route::get('/month_bill', 'SummaryController@month_bill');//月对账单
    Route::post('/month_bill', 'SummaryController@month_bill_data');//月对账单提取数据
    Route::resource('invoice', 'InvoiceController');//发票管理
    Route::get('/borrowrecordexcel', 'SummaryController@borrowrecordExcel');//订单收入数据导出
    Route::get('/daily_borrowrecordExcel', 'SummaryController@daily_borrowrecordExcel');//日账单数据导出
    Route::get('/month_borrowrecordExcel', 'SummaryController@month_borrowrecordExcel');//月账单数据导出
    Route::get('/refunds_borrowrecordExcel', 'SummaryController@refunds_borrowrecordExcel');//退款数据导出

//获取城市编码以及名称
    Route::post("/getCityCode",'HotelController@getCityCode');
    Route::post("/upIsSale",'HotelController@upIsSale');
    Route::any("/addHotel/{hotelid}",'HotelController@addHotel');
    Route::any("/getBusiness",'HotelController@getBusiness');
    Route::any("/getDistrict",'HotelController@getDistrict');
    Route::any("/delHotel",'HotelController@delHotel');

    Route::any("/rooms/{hotelid}",'RoomController@index');
    Route::any("/upStatus",'RoomController@upStatus');
    Route::any("/delRooms",'RoomController@delRooms');
    Route::any("/addRooms/{roomid}/{hotelid}",'RoomController@addRooms');

});
