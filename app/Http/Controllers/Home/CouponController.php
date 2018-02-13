<?php
namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class CouponController extends Controller
{
	//我的优惠券
	public function coupon(Request $request)
	{
		return view("home.coupon.coupon");
	}

	//优惠券详情
	public function couponDetails(Request $request)
	{
		return view("home.coupon.couponDetails");
	}

}