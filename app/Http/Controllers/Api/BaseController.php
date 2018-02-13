<?php
namespace App\Http\Controllers\Api;
#use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Routing\ResponseFactory;
Use Qcloud\Sms\SmsSingleSender;
use Constant;
header("Access-Control-Allow-Origin: *");
class BaseController extends Controller
{
	/* 必填项检测 */
	protected function check_require($key,$input)
	{
		$keyarr = explode(",", $key);
		foreach ($keyarr as $k) {
			if(!in_array($k, array_keys($input))) {
				return "缺少必填项：".$k;
			}elseif(empty($input[$k])){
				return "缺少必填项：".$k;
			}
		}
		return $input;
	}

    /* 检测用户是否登录 */
    protected function check_user($phone)
    {
        $userInfo = Db::table("wx_users")->where("phone",$phone)->first();
        if($userInfo) {
            return json_decode(json_encode($userInfo),true);
        }else{
            return false;
        }
    }

    /* 检测此手机号是否注册过 */
    protected function is_reg($phone)
    {
        if(DB::table("wx_users")->where("phone",$phone)->first()) {
            return true;
        }else{
            return false;
        }
    }

	/* 发送验证码 */
    protected function sendvcode($phone,$type)
    {
        $vcode = create_code();
        $time = time();
        $data = array(
            'mobile'=>$phone,'vtype'=>$type,'code'=>$vcode,
            'ctime'=>$time,'deadtime'=>$time+60 * 3,
        );
        DB::table("validcode")->insert($data);
        $params = array($vcode);
        if($type == 1) {
            $sms    = new SmsSingleSender(Constant::RegAppId, Constant::RegAppkey);
            $result = $sms->sendWithParam(86,$phone,Constant::RegId,$params);
        }else{
            $sms    = new SmsSingleSender(Constant::RegAppId, Constant::RegAppkey);
            $result = $sms->sendWithParam(86,$phone,Constant::LogId,$params);
        }


        $result = json_decode(object2array($result),true);
        if($result['result'] == "0"){
            return $this->res("验证码发送成功","1");
        }elseif($result['result'] == "1025"){
        	return $this->res("该手机号已超过日频率限制");
        }else{
            return $this->res('验证码发送失败');
        }
    }

    /* 验证验证码 正确返回true */
    protected function validcodes($phone,$code,$type=0){
        $result = DB::table("validcode")->where(array("mobile"=>$phone,"code"=>$code,"vtype"=>$type))->orderBy("vid" ,"DESC")->first();        
        if(empty($result) || $result->deadtime < time()){
            return false;
        }
        return true;
    }

    /* 组装发送数组 */
    protected function res($msg="非法操作",$status="0",$data=null)
    {
    	return ["status"=>$status,"msg"=>$msg,"data"=>$data];
    }
}