<?php
namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
	/* 获取全国各省省份 */
	public function chooseArea(Request $request)
	{
		return view('home.map.chooseArea');
	}

	
}