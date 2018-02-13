<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\YsdHotel;

class HotelController extends Controller
{
    
	//酒店列表
    public function index(Request $request)
    {   
        $hotelModel = new YsdHotel();
        $params     = $request->input();
        $hotelModel = $hotelModel->where("is_delete",0);
        if(!empty($params['status']) && $params['status'] != "-1") {
        	$hotelModel = $hotelModel->where("IsSale",$params['status']);
        }
        if(!empty($params['city'])) {
        	$hotelModel = $hotelModel->where("CityCode",$params['city']);
        }

        if(!empty($params['keywords'])) {
        	$hotelModel = $hotelModel->where("HotelName","like",'%'.$params['keywords'].'%');
        }

        $hotelist = $hotelModel->paginate(10);        
        $province = DB::table('province_city')->groupBy('ProvinceId')->get();

        return view('admin.hotel.index',['hotelist'=>$hotelist,"province"=>$province,'params'=>$params]);
    }

    //添加/编辑酒店
    public function addHotel(Request $request,$hotelid)
    {
    	$params   = $request->input();
    	if(!empty($params)) {
    		if($hotelid > 0) {
    			//更新
    			$data = $params['data'];   			
    			if(!empty($data)) {
    				$data['CityCode']   = $data['city'];
    				$data['Facilities'] = trim($data['Facilities'],",");
    				$data['BusinessId'] = trim($data['BusinessId'],",");
    				$data['FacilitiesName'] = trim($data['FacilitiesName'],",");
    				unset($data['file']);
    				unset($data['pay']);
    				unset($data['province']);
    				unset($data['city']);
    				if(DB::table('ysd_hotel')->where("HotelId",$hotelid)->update($data)) {
    					return array('status'=>1);
    				}
    			}
    		}else{
    			//新增
    			$data = $params['data'];
    			if(!empty($data)) {
    				$data['ctime']      = time();
    				$data['CityCode']   = $data['city'];
    				$data['Facilities'] = trim($data['Facilities'],",");
    				$data['BusinessId'] = trim($data['BusinessId'],",");
    				$data['FacilitiesName'] = trim($data['FacilitiesName'],",");
    				$data['HotelId']    = hotel_id();
    				unset($data['file']);
    				unset($data['pay']);
    				unset($data['province']);
    				unset($data['city']);
    				if(DB::table('ysd_hotel')->insert($data)) {
    					return array('status'=>1);
    				}
    			}
    		}
    	}else{
    		$hotelInfo  = array();
    		$facilities = array();			
    		$ProvinceId = array();
    		$busines    = array();
    		$cityCode   = array();
            $district   = array();
    		//获取全国所有的省份
	    	$province   = DB::table('province_city')->groupBy('ProvinceId')->get();
	    	//服务设施
	    	$facilities = DB::table("ysd_facilities")->get();
            //酒店品牌
            $brands     = DB::table('hotelbrands')->get();
            // var_dump($brands);
            // die;
    		if($hotelid > 0) {
    			//获取酒店信息
	    		$hotelInfo  = DB::table("ysd_hotel")->where("HotelId",$hotelid)->first();    			    		
	    		//通过城市编码获取省份编码
	    		$ProvinceId = DB::table('province_city')->where("CityCode",$hotelInfo->CityCode)->select("ProvinceId")->first();    		
	    		//通过城市编码获取商圈
	    		$busines    = DB::table('commerical')->where("CityCode",$hotelInfo->CityCode)->get();
	    		//通过省份编码获取该省份下所有的城市
	    		$cityCode   = DB::table('province_city')->where("ProvinceId",$ProvinceId->ProvinceId)->get();
                //通过城市编码获取该城市下所有的行政区域
                $district   = DB::table('districts')->where("CityCode",$hotelInfo->CityCode)->get();
    		}

    		return view('admin.hotel.add',["info"=>$hotelInfo,"facilities"=>$facilities,"province"=>$province,"ProvinceId"=>$ProvinceId,"busines"=>$busines,'cityCode'=>$cityCode,'district'=>$district,"brands"=>$brands]);
    	}
    }

    //删除酒店
    public function delHotel(Request $request)
    {
        $params   = $request->input();
        if(DB::table('ysd_hotel')->where("HotelId",$params['HotelId'])->update(array('is_delete'=>1))) {
            return array("status"=>1,"msg"=>"删除成功");
        }
    }

    //获取城市编码
    public function getCityCode(Request $request)
    {
    	$params   = $request->input();
    	$cityCode = DB::table("province_city")->select("CityCode","CityName")->where("ProvinceId",$params['ProvinceId'])->get();
    	return $cityCode;
    }

    //根据酒店id 更改酒店状态
    public function upIsSale(Request $request)
    {
    	$params = $request->input();
    	$info   = DB::table('ysd_hotel')->where("HotelId",$params['HotelId'])->where("IsSale",$params['IsSale'])->first();	
		if(empty($info)) {
			DB::table('ysd_hotel')->where("HotelId",$params['HotelId'])->update(array("IsSale"=>$params['IsSale']));
		}
		return array("status"=>1,"msg"=>"操作成功！");

    }

    /* 通过城市编码，获取行政区域 */
    public function getDistrict(Request $request)
    {
        $params = $request->input();
        $info   = DB::table("districts")->where("CityCode",$params['CityCode'])->get();
        return $info;
    }

    /* 通过城市编码，获取城市商圈 */
    public function getBusiness(Request $request)
    {
    	$params = $request->input();
    	$info   = DB::table("commerical")->where("CityCode",$params['CityCode'])->get();
    	return $info;
    }



}