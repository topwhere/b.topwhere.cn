<?php
namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class CenterController extends Controller
{
	//个人中心首页
	public function center(Request $request)
	{
		return view("home.center.center");
	}

	//我的资料
	public function myData(Request $request)
	{
		return view("home.center.mydata");
	}

	//我的发票
	public function invoice(Request $request)
	{
		return view("home.center.invoice");
	}

	//我的退款
	public function myRefund(Request $request)
	{
		return view("home.center.myRefund");
	}

	//退款详情
	public function refundDetails(Request $request)
	{
		return view("home.center.refundDetails");
	}

	//我的积分
	public function myIntegral(Request $request)
	{
		return view("home.center.myIntegral");
	}
}
