<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index(){
        return view('admin.company.index');
    }
    public function store()//获取列表数据 post
    {
        $query=Company::query();
        $res=$query->get();
        return ['code'=>0,'msg'=>'','count'=>'','data'=>$res];
    }


    public function show($id)//创建或修改显示页
    {
        $res=[];
        if ($id==0){
        }else{
            $query=Company::query();
            $res=$query->where('id',$id)->first();
        }
        return view('admin.company.show',['data'=>$res]);
    }
    public function update(Request $request,$id)//新增修改逻辑
    {
        $data=$request->input('data');
        unset($data['file']);
        $data['department']=trim($data['department'], ",");
        $data['duty']=trim($data['duty'], ",");
        $query=Company::query();
        if ($id==0){
            $query->create($data);
        }else{
            $query->where('id',$id)->update($data);
        }
        return ['status'=>1];
    }

    public function destroy($id)//删除
    {
        $query=Company::query();
        $query->where('id',$id)->delete();
    }

}
