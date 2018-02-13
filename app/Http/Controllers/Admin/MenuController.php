<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * @package 展示
     * @author 石头哥 sun@httproot.com
     * data:2017/11/18
     * @param $request '注入';
     * @return object
     */
    public function index(Request $request){
        return view('admin.menu.index');
    }
    public function store()//获取列表数据 post
    {
        $res=Permission::orderby('sort','desc')->get();
        $data=$this->menuSort($res);
        return ['code'=>0,'msg'=>'','count'=>'','data'=>$data];
    }
    public function show($id)//创建或修改显示页
    {
        if ($id==0){
            $res=[];
        }else{
            $res=Permission::where('id',$id)->first();
        }
        $fdatas=Permission::orderby('sort','desc')->select(['id','display_name','pid','sort'])->get();
        $fdata=$this->menuSort($fdatas,2);
        return view('admin.menu.show',['data'=>$res,'fdata'=>$fdata]);
    }
    public function update(Request $request,$id)//新增修改逻辑
    {
        $data=$request->input('data');
        if ($id==0){
            $data['name']=time();
            Permission::create($data);
        }else{
            Permission::where('id',$id)->update($data);
        }
        return ['status'=>1];
    }

    public function destroy($id)//删除
    {
        $pdata=Permission::where('pid',$id)->get();
        if (count($pdata)>0){//有下级
            return ['status'=>0,'msg'=>'请删除下级菜单'];
        }else{
            Permission::where('id',$id)->delete();
            return ['status'=>1];
        }
    }

    /**
     * @package 修改状态
     * @author 石头哥 sun@httproot.com
     * data:2017/11/21
     * @param unknown $
     * @return unknown
     */
    public function editStatus(Request $request)
    {
        $query=Permission::query();
        $query->where('id',$request->input('id'));
        $status=$request->input('status')=='true'?1:0;
        $query->update(['status'=>$status]);
    }
    /**
     * @package menu sort
     * @author 石头哥 sun@httproot.com
     * data:2017/11/20
     * @param  $res '数据'
     * @param  $ji '级别'
     * @return array
     */
    public function menuSort($res,$ji=3){
        foreach ($res as $v) {
            if ($v->pid==0){
                $data[]=$v;
                foreach ($res as $yik=>$yi){
                    if ($yi->pid==$v->id){
                        $yi->display_name='┗━ '.$yi->display_name;
                        $data[]=$yi;
                        if ($ji==3){
                            foreach ($res as $er){
                                if ($er->pid==$yi->id){
                                    $er->display_name='┗━━ '.$er->display_name;
                                    $data[]=$er;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }
}
