<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
#use Illuminate\Support\Facades\Session;

/* 个人中心 */
class CenterController extends BaseController
{
	/* 个人中心首页/个人资料 */
	public function center(Request $request,$phone)
	{  
		//判断用户是否登录
		$userInfo = $this->check_user($phone);
		if($userInfo == false) {
			return $this->res("请登录！");
		}
		//返回用户信息
		return $this->res("success",1,$userInfo);
	}

	/* 我的资料提交 */
	public function archives(Request $request)
	{   
		//判断用户登录
		$params   = $this->check_require("phone",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$userInfo = $this->check_user($params['phone']);
		if($userInfo == false) {
			return $this->res("请登录！");
		}
		$insert   = array();
		$params   = $request->input();
		if(!empty($params['tel'])) {
			if($this->is_reg($params['tel'])) {
				return $this->res("手机号已被注册");
			}
			$insert['phone'] = $params['tel'];
		}
		if(!empty($params["email"])) {
			$insert['email'] = $params['email'];
		}

		if(!empty($insert)) {
			$info = DB::table("wx_users")->where(array("id"=>$userInfo['id']))->update($insert);
			if($info) {
				$userInfo = DB::table("wx_users")->where(array("id"=>$userInfo['id']))->first();
				if($userInfo) {
					session("userInfo",$userInfo);
					return $this->res("保存成功",1,$userInfo);
				}
			}else{
				return $this->res("保存失败");
			}
		}
	}

	/* 我的发票 */
	public function myinvoice(Request $request)
	{
		//判断用户登录
		$params   = $this->check_require("phone",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$userInfo = $this->check_user($params['phone']);
		if($userInfo == false) {
			return $this->res("请登录！");
		}

		$data = DB::table("invoices")->where("openid",$userInfo['openid'])->get();
		if(!empty($data)) {
			return $this->res("success",1,$data);
		}else{
			return $this->res("暂无发票信息");
		}
	}

	/* 新增发票信息 */
	public function addInvoice(Request $request)
	{
		//判断用户登录
		$params   = $this->check_require("phone,type,name,num,address,tel,bank,banknum,openid",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$userInfo = $this->check_user($params['phone']);
		if($userInfo == false) {
			return $this->res("请登录！");
		}
		$userInfo = $this->check_user($params['phone']);
		if($userInfo == false) {
			return $this->res("请登录！");
		}

		unset($params['phone']);
		$params['created_at'] = date("Y-m-d H:i:s",time());
		if(DB::table("invoices")->insert($params)) {
			return $this->res("保存成功",1);
		}else{
			return $this->res("保存失败");
		}
	}

	/* 修改发票信息 */
	public function upInvoice(Request $request)
	{
		//判断用户登录
		$params   = $this->check_require("phone,type,name,num,address,tel,bank,banknum,openid,id",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$userInfo = $this->check_user($params['phone']);
		if($userInfo == false) {
			return $this->res("请登录！");
		}
		unset($params['phone']);
		$params['updated_at'] = date("Y-m-d H:i:s",time());
		if(DB::table("invoices")->where("id",$params['id'])->update($params)) {
			return $this->res("保存成功",1);
		}else{
			return $this->res("保存失败");
		}
	}

	/* 我的优惠券 @type:1 未使用 2 已使用 3 已过期 */
	public function myCoupons(Request $request)
	{
		//判断用户登录
		$params   = $this->check_require("type,phone",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$userInfo = $this->check_user($params['phone']);
		if($userInfo == false) {
			return $this->res("请登录！");
		}

		$where = " u.openid ='".$userInfo['openid']."'";
		if($params['type'] == 1) {
			$where .= " AND u.status = 0 AND c.end >".date("Y-m-d",time());
		}elseif($params['type'] == 2) {
			$where .= " AND u.status = 1";
		}elseif($params['type'] == 3) {
			$where .= " AND c.end <".date("Y-m-d",time());
		}

		$sql = "select u.coupon_id,c.name,c.value,c.start,c.end,c.describe from coupon_users as u join coupons as c  on u.coupon_id = c.id where ".$where." order by u.id desc";
		$data = DB::select($sql);
		if(!empty($data)) {
			return $this->res("success",1,$data);
		}else{
			return $this->res("暂无优惠券");
		}
	}


	/* 优惠券详情 */
	public function couponDetail(Request $request)
	{
		//判断用户登录
		$params   = $this->check_require("coupon_id,phone",$request->input());
		if(!is_array($params)) {
			return $this->res($params);
		}
		$userInfo = $this->check_user($params['phone']);
		if($userInfo == false) {
			return $this->res("请登录！");
		}

		$data = DB::table("coupons")->where("id",$params['coupon_id'])->select("describe")->first();
		if(!empty($data)) {
			return $this->res("success",1,$data);
		}else{
			return $this->res("暂无优惠券详情");
		}
	}

	/* 我的积分 */
	public function myintegral(Request $request,$phone)
	{
		//判断用户登录
		$userInfo = $this->check_user($phone);
		if($userInfo == false) {
			return $this->res("请登录！");
		}

		$data = DB::table("wx_users")->where("id",$userInfo['id'])->select("integral")->first();
		return $this->res("sucess",1,$data);

	}

}	