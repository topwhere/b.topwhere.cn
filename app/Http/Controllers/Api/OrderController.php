<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\YsdHotel;
use App\Models\Room;
use App\Models\Order;
use TopSdk; 
use TopClient;
use Constant;

class OrderController extends BaseController
{

	//填写订单页
	public function order(Request $request)
	{	

		$params       = $this->check_require("arrivaldate,departuredate,hotelId,roomTypeId,phone",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}

		$user  = $this->check_user($params['phone']);
		if($user == false) {
			return $this->res("请登录！");
		}
		
		$hotel = DB::table("ysd_hotel")->where("HotelId",$params['hotelId'])->select("HotelName","Address")->first();
		$data  = array();
		$data['integral']  = $user['integral'];
		$data['hotelName'] = $hotel->HotelName;
		$data['address']   = $hotel->Address;
		$data['roomTypeId']= $params['roomTypeId']; 
		if(!empty($data)) {
			return $this->res("success",1,$data);
		}else{
			return $this->res("房间不存在");
		}
	}

	//提交订单
	public function createOrder(Request $request)
	{
		$params   = $this->check_require("arrivaldate,departuredate,hotelId,roomtypeId,openid,name,tel,phone,price,total,invoice,capcity",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}

		$user = $this->check_user($params['phone']);
		if($user == false) {
			return $this->res("请登录！");
		}

		$OpenShop  = strtotime($params['arrivaldate']);
		$CloseShop = strtotime($params['departuredate']);		
		$day = ceil(($CloseShop-$OpenShop)/86400);
		
		$hotel = DB::table("ysd_hotel")->where("OpenShop","<=",$OpenShop)->where("CloseShop",">=",$CloseShop)->where("HotelId",$params['hotelId'])->first();
		if(empty($hotel)) {
			return $this->res("您预定的日期，不在酒店营业时间范围");
		}
		$room = DB::table("ysd_rooms")->where("RoomTypeId",$params['roomtypeId'])->first();
		if(empty($room)) {
			return $this->res("房间不存在，请与酒店确认");
		}
		if($room->Status != 1) {
			return $this->res("房间不可售或满房，请与酒店确认");
		}
		if($room->Capcity > $params['capcity']) {
			return $this->res("入住人数大于房间规定人数，不可办理入住");
		}
		if($room->TotalRate == "-1") {
			return $this->res("房间不可售，请与酒店确认");
		}
		if($room->Week != 0 && $room->Week < $day) {
			return $this->res("您预定的周期大于房间预定的周期，不可预定"); 
		}

		$order             = array();
		$order['openid']   = $params['openid'];
		$order['hotel_id'] = $params['hotelId'];
		$order['order_id'] = $user['company_id'].build_order_no();
		$order['hotelname']= $hotel->HotelName;
		$order['room']     = $room->Name;
		$order['breakfast']= $room->RatePlanName;
		$order['totime']   = $params['arrivaldate'];
		$order['endtime']  = $params['departuredate'];
		$order['name']     = $params['name'];
		$order['phone']    = $params['phone'];
		$order['price']    = $params['price'];
		$order['total']    = $day*$params['price'];
		$order['invoice']  = $params['invoice'];
		$order['ordertime']  = date("Y-m-d",time());
		$order['created_at']  = date("Y-m-d H:i:s",time());
		$order['status']   = 0;

		$notifyUrl = "http://".$_SERVER['HTTP_HOST']."/api/weixin.html";
		$ordersn   = $order['order_id'];
		$total     = $order['total']*100;

		if(DB::table("orders")->insert($order)) {
			$wxPayInfo     = $this->setWxData($notifyUrl,$ordersn,$total);
			$wxPayInfo     = json_decode($wxPayInfo,true);
			$wxPayInfo['notifyUrl'] = $notifyUrl;
			$wxPayInfo['total']     = $total;
			$wxPayInfo['order_id']  = $ordersn;
			return $this->res("订单创建成功",1,$wxPayInfo);
		}else{
			return $this->res("订单创建失败");
		}
	}

	//订单付款
	public function orderPay(Request $request)
	{
		#$phone = $request->input("phone");
		$params   = $this->check_require("order_id,phone",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$user = $this->check_user($params['phone']);
		if($user == false) {
			return $this->res("请登录！");
		}

		$order = DB::table("orders")->where("order_id",$params['order_id'])->first();
		$OpenShop = strtotime($order->totime);
		$CloseShop= strtotime($order->endtime);

		$hotel = DB::table("ysd_hotel")->where("OpenShop","<=",$OpenShop)->where("CloseShop",">=",$CloseShop)->where("HotelId",$order->hotel_id)->first();
		if(empty($hotel)) {
			return $this->res("您预定的日期，不在酒店营业时间范围");
		}
		$room = DB::table("ysd_rooms")->where("HotelId",$order->hotel_id)->where("Name",$order->room)->first();
		if(empty($room)) {
			return $this->res("房间不存在，请与酒店确认");
		}
		if($room->Status != 1) {
			return $this->res("房间不可售或满房，请与酒店确认");
		}
		if($room->TotalRate == "-1") {
			return $this->res("房间不可售，请与酒店确认");
		}

		
		$ordersn    = $order->order_id;
		$total      = $order->total;
		$notifyUrl  = "http://".$_SERVER['HTTP_HOST']."/api/weixin.html";

		$wxPayInfo     = $this->setWxData($notifyUrl,$ordersn,$total);
		$wxPayInfo     = json_decode($wxPayInfo,true);
		$wxPayInfo['notifyUrl'] = $notifyUrl;
		$wxPayInfo['total']     = $total;

		return $this->res("success",1,$wxPayInfo);
	}

	//我的订单  type: -1 全部  1 待支付  2已支付  3退款
	public function myOrder(Request $request)
	{
		$params   = $this->check_require("type,phone",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$user = $this->check_user($params['phone']);
		if($user == false) {
			return $this->res("请登录！");
		}

		/* 获取所有传入的参数 */  
		$params     = $request->input();
		if(empty($params['page'])) {
			$page       = 1;
		}else{
			$page       = $params['page'];
		}	
		$size  = 10;	
		$where = "o.openid = '".$user['openid']."'";	

		if($params['type'] == 1) {
			$where .= " AND o.status = 0";
		}elseif($params['type'] == 2) {
			$where .= " AND o.status = 1";
		}elseif($params['type'] == 3) {
			$where .= " AND o.status = 4";
		}


		$sql = "select o.id,o.order_id,h.HotelName,h.Address,o.totime,o.endtime,o.total,o.status from orders as o left join ysd_hotel as h on o.hotel_id = h.HotelId  where ".$where." order by o.id desc limit ".($page-1)*$size.",".$size;

		$data = DB::select($sql);
		if(!empty($data)) {
			foreach ($data as $k => $v) {
				$data[$k]->night = ceil((strtotime($v->endtime) - strtotime($v->totime))/86400);
			}
			return $this->res("success",1,$data);
		}
	}	

	//订单详情
	public function orderDetail(Request $request)
	{
		$params   = $this->check_require("order_id,phone",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$user = $this->check_user($params['phone']);
		if($user == false) {
			return $this->res("请登录！");
		}

		$info = DB::table("orders as o")
		      ->join("ysd_hotel as h","o.hotel_id","=","h.HotelId")
		      ->select("o.id","h.HotelName","h.Address","h.Tel","o.name","o.totime","o.endtime","o.name","o.phone","o.breakfast","o.invoice","o.order_id")
		      ->where("o.order_id",$params['order_id'])
		      ->get();     
		if(!empty($info)) {
			foreach ($info as $k => $v) {
				$info[$k]->night = ceil((strtotime($v->endtime) - strtotime($v->totime))/86400);
			}
		} 

		return $this->res("success",1,$info);     
	}


	//申请退款
	public function refund(Request $request)
	{
		$params   = $this->check_require("order_id,remark,phone",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$user = $this->check_user($params['phone']);
		if($user == false) {
			return $this->res("请登录！");
		}

		$data = array();
		$data['status'] = 4;
		$data['remark'] = $params['remark'];
		#$data['efundablestatus'] = 0;
		$data['year']     = date("Y",time());
		$data['year_month'] = date("Y-m",time());
		$data['year_month_day'] = date("Y-m-d",time());

		if(DB::table("orders")->where("order_id",$params['order_id'])->update($data)) {
			return $this->res("提交成功，请等待酒店审核",1);
		}else{
			return $this->res("提交失败，请与酒店联系",1);
		}
	}

	//组装微信参数
	public function setWxData($notifyUrl,$ordersn,$total)
	{
		//①、获取用户openid
		$tools = new \JsApiPay();
		// $openId = $tools->GetOpenid();

		$orderInfo              = array();
		$orderInfo['appid']     = \Constant::APPID;
		$orderInfo['prepay_id'] = $ordersn;
		$order = $tools->GetJsApiParameters($orderInfo);
		return $order;
	}



}