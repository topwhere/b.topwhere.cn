<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Services\CommonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminsController extends Controller
{
    /**
     * @package 展示
     * @author 石头哥 sun@httproot.com
     * data:2017/11/18
     * @param $request '注入';
     * @return object
     */
    public function index(Request $request){
        return view('admin.admins.index');
    }
    public function store(Request $request)//获取列表数据 post
    {
        $query=User::query();
        $query->where('type','admin');
        $sort=$request->get('sort');
        if (!empty($sort['filed'])){
            $query->orderBy($sort['filed'],$sort['type']);
        }
//        $request->input('limit')
        $res=$query->get()->toarray();
        return ['code'=>0,'msg'=>'','count'=>'','data'=>$res];
    }


    public function show($id)//创建或修改显示页
    {
        if (empty($id)){
            $user='';
        }else{
            $user=User::where('id',$id)->with('roleuser')->first();
        }
        $role=Role::get();
        return view('admin.admins.show',['data'=>$user,'role'=>$role]);
    }
    public function update(Request $request,$id)//新增修改逻辑
    {
            $input=$request->input()['data'];
            $data=[
                'name'=>$input['name'],
                'status'=>$input['status'],
                'nickname'=>$input['nickname'],
                'type'=>'admin'
            ];
            if (empty($id)){//新增
                $data['password']=CommonService::pass($input['password']);
                $user=User::Create($data);
                $user_id=$user->id;
            }else{//修改
                if (!empty($input['password'])){
                    $data['password']=CommonService::pass($input['password']);
                }
                User::where('id',$id)->update($data);
                $user_id=$id;
            }
            $user=User::where('id',$user_id)->first();
            $roleuser=RoleUser::where('user_id',$user_id)->first();
            if ($roleuser){
                RoleUser::where('user_id',$user_id)->update(['role_id'=>$input['role']]);
            }else{
                $user->attachRole($input['role']);
            }
            return ['status'=>1];
    }

    public function destroy($id)//删除
    {
        Permission::where('id',$id)->delete();
    }
}
