<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Subways;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SubwayController extends Controller
{
    public function index(Request $request){
        $id=Input::get('city_id');
        $query=City::query();
        $city=$query->where('id',$id)->first();
        return view('admin.subway.index',['city'=>$city]);
    }
    public function store()//获取列表数据 post
    {
        $query=Subways::query();
        $res=$query->where('city_id',Input::get('city_id'))->get();
        return ['code'=>0,'msg'=>'','count'=>'','data'=>$res];
    }


    public function show($id)//创建或修改显示页
    {
        $res=[];
        if ($id==0){

        }else{
            $query=Subways::query();
            $res=$query->where('id',$id)->first();
        }
        return view('admin.subway.show',['data'=>$res,'city_id'=>Input::get('city_id')]);
    }
    public function update(Request $request,$id)//新增修改逻辑
    {
        $data['value']=$request->input('data')['value'];
        $query=Subways::query();
        if ($id==0){
            $data['city_id']=Input::get('city_id');
            $query->create($data);
        }else{
            $query->where('id',$id)->update($data);
        }
        return ['status'=>1];
    }

    public function destroy($id)//删除
    {
        $query=Subways::query();
        $query->where('id',$id)->delete();
        return ['status'=>1];
    }
}
