<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProvinceController extends Controller
{
    public function index(){
        return view('admin.province.index');
    }
    public function store()//获取列表数据 post
    {
        $res = DB::table('province_city')->groupBy('ProvinceId')->get();
        return ['code'=>0,'msg'=>'','count'=>'','data'=>$res];
    }


    public function show($id)//创建或修改显示页
    {
        $res=[];
        if ($id==0){

        }else{            
            $res=DB::table('province_city')->where('ProvinceId',$id)->first();
        }
        return view('admin.province.show',['data'=>$res]);
    }
    public function update(Request $request,$id)//新增修改逻辑
    {
        $data['ProvinceName']= $request->input('data')['ProvinceName'];        
        if ($id==0){
            #$query->create($data);
        }else{
            DB::table('province_city')->where('ProvinceId',$id)->update($data);
        }
        return ['status'=>1];
    }

    public function destroy($id)//删除
    {
        
        DB::table('province_city')->where('ProvinceId',$id)->delete();
    }
}
