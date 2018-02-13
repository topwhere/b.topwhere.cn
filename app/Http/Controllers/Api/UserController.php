<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class UserController extends BaseController
{   

	/* 通过公司id获取公司的区域、公司部门、公司职务 */
	public function getcompany(Request $request)
	{
		$params = $this->check_require("company_id",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$list    = array();
		$company = DB::table("companies")->where(array("company_id"=>$params['company_id']))->first();
		if(empty($company)) {
			return $this->res("公司id不存在");
		}else{
			$list['address']     = $company->address;
			$list['department']  = explode(",", $company->department);
			$list['duty']        = explode(",", $company->duty);
		}
		return $this->res("success",1,$list);
	}

	/* app用户注册 */
	public function register(Request $request)
	{	
		//必填项检测
		$params = $this->check_require("phone,company_id,name,sex,email,company,area,department,duty,ide",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		if($this->is_reg($params['phone'])) {
			return $this->res("手机号已被注册");
		}

		$params['created_at'] = date("Y-m-d H:i:s",time());
		//新增用户
		if(DB::table("wx_users")->insert($params)) {
			return $this->res("注册成功",1);
		}else{
			return $this->res("注册失败",0);
		}
	}

	/* 用户登录 */
	public function login(Request $request)
	{
		//必填项检测
		$params = $this->check_require("phone,code",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}

		if(!$this->is_reg($params['phone'])) {
			return $this->res("手机号不存在，请注册");
		}
		//验证验证码是否正确或者失效
		if(!$this->validcodes($params['phone'],$params['code'],2)) {
			return $this->res('验证码错误或已失效');
		}

		$info = DB::table("wx_users")->where(array("phone"=>$params['phone']))->first();
		if($info) {
			session(array("userInfo"=>$info));
			return $this->res("登录成功",1,$info);
		}else{
			return $this->res("登录失败");
		}
	}

	/* 用户退出 */
	public function loginout(Request $request)
	{	
		$request->session()->forget("userInfo");
		if(!session("userInfo")) {
			return $this->res("退出成功",1);
		}
	}

	/* 发送验证码 */
	public function sendcodes(Request $request,$type,$phone)
	{
		if(empty($phone)) {
			return $this->res("请填写手机号");
		}
		switch ($type) {
			case '1':       //注册
				if($this->is_reg($phone)) {					
					return $this->res("手机号已存在");								
				}
				break;
			case '2':       //登录
				if(!$this->is_reg($phone)) {
					return $this->res("手机号不存在，请注册");
				}
				break;
			default:
				return $this->res("不支持的短信类型");
				break;
		}
		return $this->sendvcode($phone,$type);
	}

	/* 验证验证码是否正确或者失效 */
	public function validcode(Request $request)
	{
		$params = $this->check_require("type,phone,code",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		//验证手机号是否已被注册
		if($this->is_reg($params['phone'])) {
			return $this->res("手机号已被注册");
		}
		//验证验证码是否正确或者失效
		if(!$this->validcodes($params['phone'],$params['code'],$params['type'])) {
			return $this->res('验证码错误或已失效');
		}

		return $this->res("验证成功",1);
	}

}