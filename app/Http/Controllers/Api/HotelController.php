<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\YsdHotel;
use App\Models\Room;
use TopSdk; 
use TopClient;
use Constant;

class HotelController extends BaseController
{
	/* 地图寻找酒店 */
	public function maphotel(Request $request)
	{ 
		$params       = $this->check_require("arrivaldate,departuredate,longitude,latitude",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}

		$coordinate = returnSquarePoint($params['longitude'],$params['latitude']);
		$OpenShop   = strtotime($params['arrivaldate']);
		$CloseShop  = strtotime($params['departuredate']);
		$data = DB::table("ysd_hotel")
			  ->where("OpenShop","<=",$OpenShop)
			  ->where("CloseShop",">=",$CloseShop)
			  ->where("Latitude",">",$coordinate['right-bottom']['lat'])
			  ->where("Latitude","<",$coordinate['left-top']['lat'])
			  ->where("longitude","<",$coordinate['right-bottom']['lng'])
			  ->where("longitude",">",$coordinate['left-top']['lng'])
			  ->where("is_delete",0)
			  ->select("HotelId","HotelName","Address")
			  ->get();

		if(!empty($data)) {
			return $this->res("success","1",$data);
		}else{
			return $this->res("未查找到您想要的酒店信息");
		}				
	}

	/* 酒店搜索 */
	public function searchotel(Request $request)
	{
		$params       = $this->check_require("arrivaldate,departuredate,cityCode",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$params     = $request->input();
		if(empty($params['page'])) {
			$page       = 1;
		}else{
			$page       = $params['page'];
		}
		$size       = 10;

		$OpenShop   = strtotime($params['arrivaldate']);
		$CloseShop  = strtotime($params['departuredate']);
		$where  = "";
		$where .= " OpenShop <=".$OpenShop." AND CloseShop >= ".$CloseShop." AND CityCode =".$params['cityCode']." AND is_delete = 0 ";
		//经纬度
		if(!empty($params['longitude']) && !empty($params['latitude'])) {
			$coordinate = returnSquarePoint($params['longitude'],$params['latitude']);
			$where .= " AND Latitude > ".$coordinate['right-bottom']['lat']." AND Latitude <".$coordinate['left-top']['lat']." AND Longitude <".$coordinate['right-bottom']['lng']." AND Longitude >".$coordinate['left-top']['lng'];
		}
		//关键词搜索(酒店名)
		if(!empty($params['keywords'])) {			
			$where .= " AND HotelName like '%".$params['keywords']."%'";
		}
		//价格区间最低价格
		if(!empty($params['lowRate'])) {
			$where .= " AND LowRate >= ".$params['lowRate'];
		}
		//价格区间最高价格
		if(!empty($params['highRate'])) {	
			$where .= "AND LowRate <=".$params['highRate'];
		}
		//行政区域
		if(!empty($params['aid'])) {
			$where .= " AND DistanceAsc =".$params['aid'];
		}
		//商圈编码
		if(!empty($params['businessId'])) {
			$where .= " AND BusinessId =".$params['businessId'];
		}
		//品牌编码
		if(!empty($params['brandId'])) {
			$where= " AND BrandId =".$params['brandId'];
		}
		//排序
		if(!empty($params['sort']) && $params['sort'] == "DistanceAsc") {
			$order = "juli asc";
		}elseif(!empty($params['sort']) && $params['sort'] == "RateAsc"){
			$order = "LowRate asc";
		}elseif(!empty($params['sort']) && $params['sort'] == "RateDesc"){
			$order = "LowRate desc";
		}else{
			$order = "juli desc";
		}
		$sql  = "SELECT HotelId,LowRate,Facilities,HotelName,StarRate,Address,ThumbNailUrl,Features, ROUND(6378.138*2*ASIN(SQRT(POW(SIN((22.299439*PI()/180-Latitude*PI()/180)/2),2)+COS(22.299439*PI()/180)*COS(Latitude*PI()/180)*POW(SIN((114.173881*PI()/180-Longitude*PI()/180)/2),2)))*1000) AS juli FROM ysd_hotel where ".$where." ORDER BY ".$order.' limit '.($page-1)*$size.",".$size;

		$data = DB::select($sql);
		if(!empty($data)) {
			return $this->res("success",1,$data);			
		}else{
			return $this->res("未查找到您想要的酒店信息");
		}
	}

	/* 附近酒店 */
	public function nearbyhotel(Request $request)
	{
		$params       = $this->check_require("arrivaldate,departuredate,cityCode,longitude,latitude",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		/* 获取所有传入的参数 */
		$params     = $request->input();
		if(empty($params['page'])) {
			$page       = 1;
		}else{
			$page       = $params['page'];
		}
		$OpenShop   = strtotime($params['arrivaldate']);
		$CloseShop  = strtotime($params['departuredate']);
		$ysd = new YsdHotel();
		//入住日期
		$ysd = $ysd->where("OpenShop","<=",$OpenShop);
		//离店日期
		$ysd = $ysd->where("CloseShop",">=",$CloseShop);
		//城市编码
		$ysd = $ysd->where("CityCode",$params['cityCode']);
		//经纬度
		$coordinate = returnSquarePoint($params['longitude'],$params['latitude']);
		$ysd = $ysd->where("Latitude",">",$coordinate['right-bottom']['lat']);
		$ysd = $ysd->where("Latitude","<",$coordinate['left-top']['lat']);
		$ysd = $ysd->where("Longitude","<",$coordinate['right-bottom']['lng']);
		$ysd = $ysd->where("Longitude",">",$coordinate['left-top']['lng']);
		$ysd = $ysd->where("is_delete",0);

		$data = $ysd
			 ->select("HotelId","LowRate","Facilities","HotelName","StarRate","Address","ThumbNailUrl","Features","Longitude","Latitude")
			 ->offset(($page-1)*10)
			 ->limit(10)
			 ->get();

		if(!empty($data)) {
			foreach ($data as $k => $v) {
				$data[$k]->distance   = getDistance($v->Longitude,$v->Latitude,$params['longitude'],$params['latitude'])."千米";
				$data[$k]->Facilities = explode(",", $v->Facilities);
			}
		}
		return $this->res("success",1,$data);
	}

	/* 酒店详情 */
	public function hoteldetails(Request $request)
	{
		$params       = $this->check_require("arrivaldate,departuredate,hotelId",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		/* 获取所有传入的参数 */
		$params       = $request->input();
		$OpenShop   = strtotime($params['arrivaldate']);
		$CloseShop  = strtotime($params['departuredate']);
		//联合查询
		$detail = DB::table("ysd_rooms as r")
			  ->join("ysd_hotel as h","r.HotelId","=","h.HotelId")
			  ->where("r.HotelId",$params['hotelId'])
			  ->where("h.OpenShop","<=",$OpenShop)
			  ->where("h.CloseShop",">=",$CloseShop)
			  ->where("r.isdel",0)
			  ->select("r.HotelId","h.HotelName","h.StarRate","h.Address","h.Tel as Phone","h.ThumbNailUrl","r.ImageUrl as Images","r.RoomTypeId","r.Name","r.Status","r.TotalRate","r.Status")
			  ->get();
		return $this->res("success",1,$detail);		
	}

	/* 单房间详情 */
	public function roomdetails(Request $request)
	{
		$params       = $this->check_require("arrivaldate,departuredate,hotelId,roomtypeId",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		/* 获取所有传入的参数 */
		$params       = $request->input();
		$room         = new Room();
		$room         = $room->where("HotelId",$params['hotelId']);
		$room         = $room->where("RoomTypeId",$params['roomtypeId']);
		$detail       = $room->select("Name","Area","BedType","BedDesc","Description","Comments","Capcity","Status","ImageUrl","Broadnet","RatePlanName","Floor")->get();

		if(empty($detail)) {
			return $this->res("未查找到您想要的房型信息");
		}else{
			return $this->res("success",1,$detail);
		}		
	}
}