<?php
namespace App\Http\Controllers\Home;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class HotelController extends Controller
{
	/* 地图寻找酒店 */
	public function maphotel(Request $request)
	{
		return view('home.hotel.maphotel');
	}

	/* 酒店搜索 */
	public function searchotel(Request $request)
	{
		return view('home.hotel.searchotel');
	}

	/* 附近酒店 */
	public function nearbyhotel(Request $request)
	{
		return view('home.hotel.nearbyhotel');
	}

	/* 酒店详情 */
	public function hoteldetails(Request $request)
	{
		return view('home.hotel.hoteldetails');
	}

	/* 单房间详情 */
	public function roomdetails(Request $request)
	{
		return view('home.hotel.roomdetails');
	}
}