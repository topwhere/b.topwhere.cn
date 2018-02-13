<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busines;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class BusineController extends Controller
{
    public function index(Request $request){
        $id=Input::get('city_id');
        $city = DB::table("province_city")->where('CityCode',$id)->first();
        return view('admin.busine.index',['city'=>$city]);
    }
    public function store()//获取列表数据 post
    {
        $res=DB::table("commerical")->where('CityCode',Input::get('city_id'))->get();
        return ['code'=>0,'msg'=>'','count'=>'','data'=>$res];
    }


    public function show($id)//创建或修改显示页
    {
        $res=[];
        if ($id==0){

        }else{
            $res=DB::table("commerical")->where('businessId',$id)->first();
        }
        return view('admin.busine.show',['data'=>$res,'city_id'=>Input::get('city_id')]);
    }
    public function update(Request $request,$id)//新增修改逻辑
    {
        $data['businessName']=$request->input('data')['businessName'];
        if ($id==0){
            $data['CityCode']=Input::get('city_id');
            $max = DB::table("commerical")->where("CityCode",Input::get('city_id'))->max("businessId");
            $data['businessId'] = $max+1;
            DB::table("commerical")->insert($data);
        }else{
            DB::table("commerical")->where('businessId',$id)->update($data);
        }
        return ['status'=>1];
    }

    public function destroy($id)//删除
    {
        DB::table("commerical")->where('businessId',$id)->delete();
        return ['status'=>1];
    }
}
