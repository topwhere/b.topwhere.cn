<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use TopSdk; 
use TopClient;
use Constant;

class DatasController extends BaseController
{
	//初始化数据
	public function initData(Request $request)
	{
		$params       = $this->check_require("arrivaldate,departuredate,cityCode",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		/* 获取所有传入的参数 */
		$params       = $request->input();
		$c            = new \TopClient();
		$c->appKey    = \Constant::ElongAppKey;
		$c->secretKey = \Constant::ElongSecretKey;
		$c->user      = \Constant::ElongUser;
		
		$req          = new \HotelListRequest();
		//入住日期
		$req->setArrivalDate($params['arrivaldate']);
		//离店日期
		$req->setDepartureDate($params['departuredate']);
		//城市编码
		$req->setCityId($params['cityCode']);
		$req->setResultType("1,2,3,4,8");
		$resp = $c->execute($req);		
		$resp = json_decode($resp,true);
		//酒店信息
		$hotel = array();
		//房间信息
		$rooms = array();
		//预定规则
		$bookingRule = array();

		if(!empty($resp) && $resp['Code'] == "0") {
			foreach ($resp['Result']['Hotels'] as $k => $v) {
				//酒店信息
				$hotel[$k]['HotelId']       = $v['HotelId'];				
				$hotel[$k]['HotelName']     = $v['Detail']['HotelName'];
				$hotel[$k]['StarRate']      = $v['Detail']['StarRate'];
				if(!empty($v['Detail']['Category'])) {
					$hotel[$k]['Category']  = $v['Detail']['Category'];
				}
				$hotel[$k]['Address']        = $v['Detail']['Address'];
				$hotel[$k]['LowRate']        = $v['LowRate'];
				$hotel[$k]['CityCode']       = $v['Detail']['City'];
				$hotel[$k]['BusinessId']     = $v['Detail']['BusinessZone'];
				$hotel[$k]['District']       = $v['Detail']['District'];
				$hotel[$k]['Longitude']      = $v['Detail']['Longitude'];
				$hotel[$k]['Latitude']       = $v['Detail']['Latitude'];				
				$hotel[$k]['OpenShop']       = "1514736000";
				$hotel[$k]['CloseShop']      = "1735660800";
				$hotel[$k]['Facilities']     = $v['Facilities'];
				$hotel[$k]['FacilitiesName'] = $this->getFacilities($v['Facilities']);
				if(!empty($v['Detail']['ThumbNailUrl'])) {
					$hotel[$k]['ThumbNailUrl']  = $v['Detail']['ThumbNailUrl'];
				}else{
					$hotel[$k]['ThumbNailUrl']  = '';
				}				
				if(!empty($v['Detail']['Phone'])) {
					$hotel[$k]['Tel']  = $v['Detail']['Phone'];
				}else{
					$hotel[$k]['Tel']  = '';
				}
				$hotel[$k]['Features']      = $v['Detail']['Features'];				
				//预定规则
				if(!empty($v['BookingRules'])) {
					foreach ($v['BookingRules'] as $kii => $vii) {
						$bnums = count($bookingRule);
						$bookingRule[$bnums]['BookingRuleId'] = $vii['BookingRuleId'];
						$bookingRule[$bnums]['Description']   = $vii['Description'];
					}
				}

				//房间信息
				if(!empty($v['Rooms'])) {				
					foreach ($v['Rooms'] as $ki => $vi) {
						$nums = count($rooms);
						//酒店编码
						$rooms[$nums]['HotelId']      = $v['HotelId'];
						//房型编码
						$rooms[$nums]['RoomTypeId']   = $vi['RoomTypeId'];
						//房型名称
						$rooms[$nums]['Name']         = $vi['Name'];
						//房型统一价
						$rooms[$nums]['TotalRate']    = $v['LowRate'];
						if(!empty($vi['RatePlans'])) {
							$rooms[$nums]['TotalRate'] = $vi['RatePlans'][0]['TotalRate'];
							//预定规则id
							$rooms[$nums]['BookingRuleIds'] = $vi['RatePlans'][0]['BookingRuleIds'];
							//产品名称
							$rooms[$nums]['RatePlanName']   = $vi['RatePlans'][0]['RatePlanName'];
						}else{
							//预定规则id
							$rooms[$nums]['BookingRuleIds'] = '';
							//产品名称
							$rooms[$nums]['RatePlanName']   = '';
						}

						//房型所在楼层
						if(!empty($vi['Floor'])) {
							$rooms[$nums]['Floor'] = $vi['Floor'];
						}else{
							$rooms[$nums]['Floor'] = '';
						}
						//上网情况
						if(!empty($vi['Broadnet'])) {
							$rooms[$nums]['Broadnet'] = $vi['Broadnet'];
						}else{
							$rooms[$nums]['Broadnet'] = '';
						}
						//床型
						if(!empty($vi['BedType'])) {
							$rooms[$nums]['BedType'] = $vi['BedType'];
						}else{
							$rooms[$nums]['BedType'] = '';
						}
						//床型描述
						if(!empty($vi['BedDesc'])) {
							$rooms[$nums]['BedDesc'] = $vi['BedDesc'];
						}else{
							$rooms[$nums]['BedDesc'] = '';
						}
						//房间描述
						if(!empty($vi['Description'])) {
							$rooms[$nums]['Description'] = $vi['Description'];
						}else{
							$rooms[$nums]['Description'] = '';
						}
						//房间备注
						if(!empty($vi['Comments'])) {
							$rooms[$nums]['Comments'] = $vi['Comments'];
						}else{
							$rooms[$nums]['Comments'] = '';
						}
						//面积
						if(!empty($vi['Area'])) {
							$rooms[$nums]['Area'] = $vi['Area'];
						}else{
							$rooms[$nums]['Area'] = '';
						}
						//可容纳人数
						if(!empty($vi['Capcity'])) {
							$rooms[$nums]['Capcity'] = $vi['Capcity'];
						}else{
							$rooms[$nums]['Capcity'] = '';
						}
						//是否可售
						if(!empty($vi['RatePlans'][0]['Status']) && $vi['RatePlans'][0]['Status'] == false) {
							$rooms[$nums]['Status'] = 0;
						}else{
							$rooms[$nums]['Status'] = 1;
						}
						//房型照片
						if(!empty($vi['ImageUrl'])) {
							$rooms[$nums]['ImageUrl'] = $vi['ImageUrl'];
						}else{
							$rooms[$nums]['ImageUrl'] = '';
						}	
					}
				}

			}
		}

		if(!empty($hotel)) {
			$hotelsql = "insert into ysd_hotel (HotelId,HotelName,StarRate,Category,Address,LowRate,CityCode,BusinessId,District,Longitude,Latitude,OpenShop,CloseShop,Facilities,FacilitiesName,ThumbNailUrl,Features,Tel,ctime)  values";
			foreach ($hotel as $k => $v) {
				$hotelsql .= "(".$v['HotelId'].",'".$v['HotelName']."',".$v['StarRate'].",'".$v['Category']."','".$v['Address']."',".$v['LowRate'].",".$v['CityCode'].",".$v['BusinessId'].",".$v['District'].",".$v['Longitude'].",".$v['Latitude'].",".$v['OpenShop'].",".$v['CloseShop'].",'".$v['Facilities']."','".$v['FacilitiesName']."','".$v['ThumbNailUrl']."','".$v['Features']."','".$v['Tel']."',".time()."),";
			}
			$sql = trim($hotelsql,",");
			DB::insert($sql);
		}

		if(!empty($rooms)) {
			$roomsSql = "insert into ysd_rooms (HotelId,RoomTypeId,Name,TotalRate,Floor,BookingRuleIds,RatePlanName,Broadnet,BedType,BedDesc,Description,Comments,Area,Capcity,Status,ImageUrl,ctime)  values";
			foreach ($rooms as $k => $v) {
				$roomsSql .= "(".$v['HotelId'].",'".$v['RoomTypeId']."','".$v['Name']."',".$v['TotalRate'].",'".$v['Floor']."','".$v['BookingRuleIds']."','".$v['RatePlanName']."','".$v['Broadnet']."','".$v['BedType']."','".$v['BedDesc']."','".$v['Description']."','".$v['Comments']."','".$v['Area']."','".$v['Capcity']."',".$v['Status'].",'".$v['ImageUrl']."',".time()."),";
			}
			$roomsSql = trim($roomsSql,",");
			DB::insert($roomsSql);
		}

		if(!empty($bookingRule)) {
			$bookSql = "insert into ysd_room_booking_rule (BookingRuleId,Description)  values";
			foreach ($bookingRule as $k => $v) {
				$bookSql .= "(".$v['BookingRuleId'].",'".$v['Description']."'),";
			}
			$bookSql = trim($bookSql,",");
			DB::insert($bookSql);
		}


	}


	/* 根据酒店设施id,获取酒店设施名称 */
	private function getFacilities($Facilities)
	{
		$name = array("1"=>"免费wifi","5"=>"免费停车场","7"=>"免费接机服务","9"=>"室内游泳池","10"=>"室外游泳池","11"=>"健身房","12"=>"商务中心","13"=>"会议室","14"=>"酒店餐厅","15"=>"叫醒服务","16"=>"行李寄存","17"=>"双床","18"=>"大床");
		$arr  = explode(",",$Facilities);
		for ($i=0; $i < count($arr); $i++) {
			if(in_array($arr[$i], array(1,5,7,9,10,11,12,13,14,15,16,17,18))) {
				$arrName[$i] = $name[$arr[$i]];	
			}			
		}
		return implode(",", $arrName);
	}
}