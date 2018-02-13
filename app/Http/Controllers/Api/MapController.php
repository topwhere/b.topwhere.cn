<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MapController extends BaseController
{
	/* 获取全国各省省份 */
	public function getProvince(Request $request)
	{
		$province = DB::select("select distinct('ProvinceId'),ProvinceId,ProvinceName from province_city order by id ");
		array_pop($province);
		return $this->res("success",1,$province);
	}

	/* 根据省份编码获取该省份下城市名称/编码 */
	public function getCity(Request $request,$ProvinceId)
	{
		$city = DB::table("province_city")->where(array("ProvinceId"=>$ProvinceId))->select("CityCode","CityName")->get();
		return $this->res("success",1,$city);
	}

	/* 根据城市编码获取行政区域 */
	public function getDistricts(Request $request,$CityCode)
	{
		$districts = DB::table("districts")->where(array("CityCode"=>$CityCode))->select("Aid","Name")->orderBy("Aid","asc")->get();
		return $this->res("success",1,$districts);
	}

	/* 根据城市编码获取商圈 */
	public function getCommerical(Request $request,$CityCode)
	{
		$commerical = DB::table("commerical")->where(array("CityCode"=>$CityCode))->select("businessId","businessName")->orderBy("businessId","asc")->get();
		return $this->res("success",1,$commerical);
	}

	/* 获取酒店品牌 */
	public function getAllBrands()
	{
		$allBrands = DB::table("hotelbrands")->select("BrandId","ShortName as Name")->orderBy("id","asc")->get();
		return $this->res("success",1,$allBrands);
	}

	/* 获取艺龙各省、城市、商业圈、标志物数据存入本地数据库 (存入数据库，暂时不用)*/
	public function getInfo(Request $request)
	{
		$url = "http://api.elong.com/xml/v2.0/hotel/geo_cn.xml";
		$xml = json_decode(json_encode(simplexml_load_string(file_get_contents($url))),true);
		$data = $xml['HotelGeoList'];
		$province    = array();
		$districts   = array();
		$commerical  = array();
		$landmark    = array();

		foreach ($data['HotelGeo'] as $k => $v) {			
			$province[$k]['ProvinceId']    = $v['@attributes']['ProvinceId'];
			$province[$k]['ProvinceName']  = $v['@attributes']['ProvinceName'];
			$province[$k]['CityCode']      = $v['@attributes']['CityCode'];
			$province[$k]['CityName']      = $v['@attributes']['CityName'];
			$province[$k]['Country']       = $v['@attributes']['Country'];
			

			if(!empty($v['Districts']['Location'])) {
				$sql = "insert into districts (Id, Name, CityCode) values";
				foreach ($v['Districts']['Location'] as $ki => $vi) {				
					$nums = count($districts);
					$districts[$nums]             = $vi;
					$districts[$nums]['@attributes']['CityCode'] = $v['@attributes']['CityCode'];
					$nums++;
				}	
			}

			if(!empty($v['CommericalLocations']['Location'])) {
				foreach ($v['CommericalLocations']['Location'] as $kii => $vii) {
					$cnums = count($commerical);
					$commerical[$cnums]             = $vii;
					$commerical[$cnums]['@attributes']['CityCode'] = $v['@attributes']['CityCode'];
					$cnums++;
				}
			}

			if(!empty($v['LandmarkLocations']['Location'])) {
				foreach ($v['LandmarkLocations']['Location'] as $kiii => $viii) {
					$lnums = count($commerical);
					$landmark[$lnums]             = $viii;
					$landmark[$lnums]['@attributes']['CityCode'] = $v['@attributes']['CityCode'];
					$lnums++;
				}
			}
		}

		if(!empty($province)) {
			$sql = "insert into province_city (ProvinceId, ProvinceName, CityCode, CityName, Country) values";
			foreach ($province as $k => $v) {
				#DB::table("province_city")->insert($v);
				$sql .= "(".$v['ProvinceId'].",'".$v['ProvinceName']."',".$v['CityCode'].",'".$v['CityName']."','".$v['Country']."'),";
			}
			$sql = trim($sql,",");
			DB::insert($sql);
		}

		if(!empty($districts)) {
			$sql = "insert into districts (CityCode,AId,Name) values";
			foreach ($districts as $k => $v) {
				if(!empty($v['@attributes']['Id'])) {
					$sql .= "(".$v['@attributes']['CityCode'].",".$v['@attributes']['Id'].",'".$v['@attributes']['Name']."'),";
				}else{
					$sql .= "(".$v['@attributes']['CityCode'].",".$v['Id'].",'".$v['Name']."'),";
				}				
			}
				$sql = trim($sql,",");
				DB::insert($sql);
		}
		if(!empty($commerical)) {
			$sql = "insert into commerical (CityCode,businessId,businessName) values";
			foreach ($commerical as $k => $v) {
				if(!empty($v['@attributes']['Id'])) {
					$sql .= "(".$v['@attributes']['CityCode'].",".$v['@attributes']['Id'].",'".$v['@attributes']['Name']."'),";
				}else{
					$sql .= "(".$v['@attributes']['CityCode'].",".$v['Id'].",'".$v['Name']."'),";
				}				
			}
				$sql = trim($sql,",");
				DB::insert($sql);
		}

		if(!empty($landmark)) {
			$sql = "insert into landmark (CityCode,markerId,markerName) values";
			foreach ($landmark as $k => $v) {
				if(!empty($v['@attributes']['Id'])) {
					$sql .= "(".$v['@attributes']['CityCode'].",".$v['@attributes']['Id'].",'".$v['@attributes']['Name']."'),";
				}else{
					$sql .= "(".$v['@attributes']['CityCode'].",".$v['Id'].",'".$v['Name']."'),";
				}				
			}
				$sql = trim($sql,",");
				DB::insert($sql);
		}
	}

	/* 获取艺龙酒店品牌列表（存入数据库,不用） */
	public function getBrands(Request $request)
	{
		$url = "http://api.elong.com/xml/v2.0/hotel/brand_cn.xml";
		$data = json_decode(json_encode(simplexml_load_string(file_get_contents($url))),true);
		if(!empty($data)) {
			// var_dump($data);
			// die;
			$sql = "insert into hotelbrands (BrandId,GroupId,ShortName,Name,Letters) values";
			foreach ($data['HotelBrand'] as $k => $v) {				
				$sql .='('.$v['@attributes']['BrandId'].','.$v['@attributes']['GroupId'].',"'.$v['@attributes']['ShortName'].'","'.$v['@attributes']['Name'].'","'.$v['@attributes']['Letters'].'"),';				
			}
			$sql = trim($sql,',');
			DB::insert($sql);
		}
	}

	/* 去除不需要的品牌酒店 (整理数据，不用)*/
	public function deleteBrands(Request $request)
	{
		$field = "如家,汉庭,七天,锦江之星,莫泰,速8,格林豪泰,怡莱,宜必思,智选假日,全季,锦江,戴斯,华美达福朋喜来登,桔子,诺富特,美爵,万怡,喜来登,皇冠假日,开源,洲际,香格里拉,希尔顿,威斯汀,凯宾斯基,铂尔曼,希尔顿逸林,万豪 ,万丽,君悦,丽思卡尔顿,日航,柏悦,维也纳,时光漫步,雅乐轩";

		$where = explode(",", $field);
		DB::table("hotelbrands")->whereNotIn("ShortName",$where)->delete();

	}

}