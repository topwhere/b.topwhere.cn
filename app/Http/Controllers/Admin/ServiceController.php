<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index(Request $request){
        return view('admin.service.index');
    }
    public function store()//获取列表数据 post
    {
        // $query=Config::query();
        // $res=$query->where('type','service')->get();
        $res = DB::table("ysd_facilities")->get();
        return ['code'=>0,'msg'=>'','count'=>'','data'=>$res];
    }


    public function show($id)//创建或修改显示页
    {
        $res=[];
        if ($id==0){

        }else{
            $res = DB::table("ysd_facilities")->where("id",$id)->first();
        }
        return view('admin.service.show',['data'=>$res]);
    }
    public function update(Request $request,$id)//新增修改逻辑
    {
        $data['name']=$request->input('data')['name'];
        $query=Config::query();
        if ($id==0){
            DB::table("ysd_facilities")->insert($data);
        }else{
            DB::table("ysd_facilities")->where('id',$id)->update($data);
        }
        return ['status'=>1];
    }

    public function destroy($id)//删除
    {
        DB::table("ysd_facilities")->where("id",$id)->delete();
        return ['status'=>1];
    }


}
