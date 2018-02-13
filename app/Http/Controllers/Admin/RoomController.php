<?php

namespace App\Http\Controllers\Admin;

use App\Models\Hotels;
use App\Models\Rooms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\YsdHotel;
use App\Models\YsdRoom;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    
    //房型列表
    public function index(Request $request,$hotelid)
    {
        //获取房型列表
        //$roomModel  = new YsdRoom();
        $roomModel  = DB::table('ysd_rooms as r')->where("isdel",0);
        $params     = $request->input();
        if($hotelid > 0) {
            if(!empty($params) && $params['hotelid'] > 0) {
                $roomModel = $roomModel->where("r.HotelId",$params['hotelid']);
                $hotelid       = $params['hotelid'];
            }else{
                $roomModel = $roomModel->where("r.HotelId",$hotelid);
            }
        }else{
            if(!empty($params) && $params['hotelid'] > 0) {
                $roomModel = $roomModel->where("r.HotelId",$params['hotelid']);
                $hotelid       = $params['hotelid'];
            }
        }


        if(!empty($params['status']) && $params['status'] != "-1") {
            $roomModel = $roomModel->where("r.Status",$params['status']-1);
        }
        //房型列表
        $roomlist = $roomModel->join("ysd_hotel as h","r.HotelId","=","h.HotelId")->select("h.HotelId","h.HotelName","r.RoomTypeId","r.Name","r.id","r.TotalRate","r.MerPrice","r.Status","r.Week")->paginate(10);

        //获取所有的酒店
        $hotelModel = new YsdHotel();
        $hotelist = $hotelModel->where("is_delete",0)->get();
        return view('admin.room.index',['hotelist'=>$hotelist,"roomlist"=>$roomlist,"params"=>$params,'hotelid'=>$hotelid]);
    }

    //添加/编辑酒店房型
    public function addRooms(Request $request,$roomid,$hotelid)
    {
        $params   = $request->input();
        if(!empty($params)) {
            if($roomid > 0) {
                //更新
                $data = $params['data'];            
                if(!empty($data)) {
                    $data['HotelId']   = $hotelid;
                    if($data['RatePlanName'] == "含早") {
                        $data['IsBreakFast'] = 1;
                    }else{
                        $data['IsBreakFast'] = 0;
                    }

                    $bedType = explode("-", $data['BedType']);
                    $data['BedType'] = $bedType[1];
                    $data['BedTypeId'] = $bedType[0];
                    $data['ImageUrl']     = $data['img'];
                    unset($data['img']);
                    unset($data['file']);  
                    if(DB::table('ysd_rooms')->where("id",$roomid)->update($data)) {
                        return array('status'=>1);
                    }
                }
            }else{
                //新增
                $data = $params['data'];       
                if(!empty($data)) {
                    $data['HotelId']   = $hotelid;
                    if($data['RatePlanName'] == "含早") {
                        $data['IsBreakFast'] = 1;
                    }else{
                        $data['IsBreakFast'] = 0;
                    }
                    $bedType = explode("-", $data['BedType']);
                    $data['BedType']      = $bedType[1];
                    $data['BedTypeId']    = $bedType[0];
                    $data['ImageUrl']     = $data['img'];
                    $data['RoomTypeId']   = rooms_id();
                    $data['ctime']        = time();
                    $data['HotelId']      = $data['Hotel'];
                    unset($data['img']);
                    unset($data['file']);
                    unset($data['Hotel']);
                    if(DB::table('ysd_rooms')->insert($data)) {
                        return array('status'=>1);
                    }
                }
            }
        }else{
            
            //获取房型信息
            $info    = DB::table("ysd_rooms")->where('id',$roomid)->first();
            //获取床型
            $bedType = DB::table("ysd_bedtype")->get();
            //获取所有的酒店
            $hotelModel = new YsdHotel();
            $hotelist = $hotelModel->where("is_delete",0)->get();

            return view('admin.room.add',['data'=>$info,'bedType'=>$bedType,'hotelid'=>$hotelid,"hotelist"=>$hotelist]);
        }
    }

    //根据房型id 更改房型状态
    public function upStatus(Request $request)
    {
        $params = $request->input();
        $info   = DB::table('ysd_rooms')->where("id",$params['id'])->where("Status",$params['status'])->first();  
        if(empty($info)) {
            DB::table('ysd_rooms')->where("id",$params['id'])->update(array("Status"=>$params['status']));
        }
        return array("status"=>1,"msg"=>"操作成功！");
    }

    //删除酒店
    public function delRooms(Request $request)
    {
        $params   = $request->input();
        if(DB::table('ysd_rooms')->where("id",$params['id'])->update(array("isdel"=>1))) {
            return array("status"=>1,"msg"=>"删除成功");
        }
    }
}
