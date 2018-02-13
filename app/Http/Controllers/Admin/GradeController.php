<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use App\Models\WxUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    public function index(){
        return view('admin.grade.index');
    }
    public function store()//获取列表数据 post
    {
        $query=Config::query();
        $res=$query->where('type','grade')->get();
        return ['code'=>0,'msg'=>'','count'=>'','data'=>$res];
    }


    public function show($id)//创建或修改显示页
    {
        $res=[];
        if ($id==0){
        }else{
            $query=Config::query();
            $res=$query->where('id',$id)->first();
        }
        return view('admin.grade.show',['data'=>$res]);
    }
    public function update(Request $request,$id)//新增修改逻辑
    {
        $data=$request->input('data');
        $query=Config::query();
        $data['type']='grade';
        if ($id==0){
            $query->create($data);
        }else{
            $query->where('id',$id)->update($data);
        }
        return ['status'=>1];
    }

    public function destroy($id)//删除
    {
        $query=Config::query();
        $query->where('id',$id)->delete();
    }

}
