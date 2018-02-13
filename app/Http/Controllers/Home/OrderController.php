<?php
namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
	//订单管理
	public function order(Request $request)
	{
		return view("home.order.order");
	}

	//订单详情
	public function orderDetails(Request $request)
	{
		return view("home.order.orderDetails");
	}

	//创建订单
	public function writeIndent(Request $request)
	{
		return view("home.order.writeIndent");
	}

	//房价明细
	public function housePriceDetails(Request $request)
	{
		return view("home.order.housePriceDetails");
	}



}