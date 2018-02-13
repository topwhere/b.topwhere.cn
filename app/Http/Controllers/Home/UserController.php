<?php
namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
	//注册第一步
	public function registerFirst(Request $request)
	{
		return view('home.user.registerFirst');
	}

	//注册第二步
	public function registerSec(Request $request)
	{
		return view('home.user.registerSec');
	}

	//完善资料
	public function perfectData(Request $request)
	{
		return view('home.user.perfectData');
	}

	//登录
	public function loginIn(Request $request)
	{
		return view('home.user.loginIn');
	}
}


