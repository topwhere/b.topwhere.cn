<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function index(){
        return view('admin.city.index');
    }
    public function store()//获取列表数据 post
    {
        $res = DB::table("province_city")->where('ProvinceId',Input::get('province'))->get();
        return ['code'=>0,'msg'=>'','count'=>'','data'=>$res];
    }


    public function show($id)//创建或修改显示页
    {
        $res=[];
        if ($id==0){

        }else{            
            $res=DB::table("province_city")->where('CityCode',$id)->first();
        }
        return view('admin.city.show',['data'=>$res]);
    }
    public function update(Request $request,$id)//新增修改逻辑
    {
        $data['CityName']=$request->input('data')['CityName'];
        $data['ProvinceId']=Input::get('province');
        $query=City::query();
        if ($id==0){
            $ProvinceName = DB::table("province_city")->where("ProvinceId",Input::get('province'))->select("ProvinceName")->first();
            $data['ProvinceName'] = $ProvinceName->ProvinceName;
            $max                  = DB::table("province_city")->max('CityCode');
            $data['CityCode']     = $max+1;
            DB::table("province_city")->insert($data);
        }else{
            DB::table("province_city")->where('CityCode',$id)->update($data);
        }
        return ['status'=>1];
    }

    public function destroy($id)//删除
    {
        DB::table("province_city")->where('CityCode',$id)->delete();
         return ['status'=>1];
    }
}
