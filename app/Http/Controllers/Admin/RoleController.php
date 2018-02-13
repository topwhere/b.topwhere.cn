<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * @package 展示
     * @author 石头哥 sun@httproot.com
     * data:2017/11/18
     * @param $request '注入';
     * @return object
     */
    public function index(Request $request)
    {
        return view('admin.role.index');
    }

    public function store()//获取列表数据 post
    {
        $res = Role::get();
        return ['code' => 0, 'msg' => '', 'count' => '', 'data' => $res];
    }


    public function show($id)//创建或修改显示页
    {
        $permissions = [];
        if ($id == 0) {
            $res = [];
        } else {
            $res = Role::where('id', $id)->with('permission')->first();
            foreach ($res->permission as $v) {
                $permissions[] = $v->permission_id;
            }
        }
        $permission = Permission::get();
        return view('admin.role.show', ['data' => $res, 'permission' => $permission, 'permissions' => $permissions]);
    }

    public function update(Request $request, $id)//新增修改逻辑
    {
        $data['display_name'] = $request->input('data')['display_name'];
        $data['description'] = $request->input('data')['description'];
        $permission = $request->input('permission');
        if ($id == 0) {
            $data['name'] = time();
            $role = Role::create($data);
            $role_id = $role;
        } else {
            Role::where('id', $id)->update($data);
            $role = Role::where('id', $id)->first();
            $role_id = $role['id'];
        }
        PermissionRole::where('role_id', $role_id)->delete();
        if ($permission) {
            $role->attachPermissions($permission);
        }
        return ['status' => 1];
    }

    public function destroy($id)//删除
    {
        Role::where('id', $id)->delete();
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
        $query = Permission::query();
        $query->where('id', $request->input('id'));
        $status = $request->input('status') == 'true' ? 1 : 0;
        $query->update(['status' => $status]);
    }

    /**
     * @package menu sort
     * @author 石头哥 sun@httproot.com
     * data:2017/11/20
     * @param  $res '数据'
     * @param  $ji '级别'
     * @return array
     */
    public function menuSort($res, $ji = 3)
    {
        foreach ($res as $v) {
            if ($v->pid == 0) {
                $data[] = $v;
                foreach ($res as $yik => $yi) {
                    if ($yi->pid == $v->id) {
                        $yi->display_name = '┗━ ' . $yi->display_name;
                        $data[] = $yi;
                        if ($ji == 3) {
                            foreach ($res as $er) {
                                if ($er->pid == $yi->id) {
                                    $er->display_name = '┗━━ ' . $er->display_name;
                                    $data[] = $er;
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
