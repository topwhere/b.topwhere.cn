<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\CommonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    /**
     * @package 后台首页
     * @author 石头哥 sun@httproot.com
     * data:2017/11/17
     * @param unknown $
     * @return unknown
     */
    public function index(Request $request){
        return view('admin.index');
    }

    /**
     * @package 登录页面
     * @author 石头哥 sun@httproot.com
     * data:2017/11/17
     * @param unknown $
     * @return unknown
     */
    public function login(){
        return view('admin.login');
    }

    /**
     * @package loginsub
     * @author 石头哥 sun@httproot.com
     * data:2017/11/18
     * @param unknown $
     * @return array
     */
    public function loginsub(Request $request){
        $name=Input::get('data.name');
        $password=Input::get('data.password');
        $admin=User::where('name',$name)->where('type','admin')->where('status',1)->first();
        if ($admin){
            if (CommonService::pass($password)==$admin['password']){
                Auth::login($admin);
                return ['status'=>1];
            }
        }
        return ['status'=>0,'msg'=>'账号或密码错误'];
    }
}
