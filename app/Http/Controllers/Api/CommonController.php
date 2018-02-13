<?php

namespace App\Http\Controllers\Api;

use App\Services\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CommonController extends Controller
{
    public function imgsave(Request $request)
    {
        //修改config下的filesystems 'root' => storage_path('app'),改成如下
        //'root' =>public_path('uploads'),
        $path = $request->file('file')->store('avatars');
        $path = "http://".$_SERVER['HTTP_HOST'].'/uploads/'.$path;
//        echo Storage::get($path);
        echo json_encode(['code'=>0, 'msg'=>'', 'data'=>['src'=>$path]]);
    }

    public function editimgsave(Request $request)
    {
        $path = $request->file('file')->store('avatars');

        echo json_encode(['code'=>0, 'msg'=>'', 'data'=>['src'=>$_SERVER['HTTP_ORIGIN'].'/uploads/'.$path]]);
    }

    //腾讯地图地址转经纬度
    public function getLatLong(Request $request)
    {
        $url="http://apis.map.qq.com/ws/geocoder/v1/?address=".$request->input('address')."&key=ZETBZ-QNXWF-YW4JL-NW62G-WXNIK-MAFVR";
        $res=Common::get_Data($url);
        return $res;
    }
    public function smsSend()
    {
//        $type, $nationCode, $phoneNumber, $msg, $extend = "", $ext = "";
//        0, "86", $phoneNumber2, "测试短信，普通单发，深圳，小明，上学。", "", ""
        $url='https://yun.tim.qq.com/v5/tlssmssvr/sendsms';
        $appid='1400035326';
        $appkey="31ab516849b6035dff06a32ea017e8a8";
        $nationCode="86";
        $phoneNumber="18310031093";
        $type=0;
        $msg='321321为您的注册验证码，请于10分钟内填写。如非本人操作，请忽略本短信，中微信通全国服务热线：400-056-1190.座机：010-64125951';
        $extend='';
        $ext='';
        $random = $this->getRandom();
        $curTime = time();
        $wholeUrl = $url."?sdkappid=" . $appid . "&random=" . $random;
        $data = new \stdClass();
        $tel = new \stdClass();
        $tel->nationcode = "".$nationCode;
        $tel->mobile = "".$phoneNumber;

        $data->tel = $tel;
        $data->type = (int)$type;
        $data->msg = $msg;
        $data->sig = hash("sha256",
            "appkey=".$appkey."&random=".$random."&time=".$curTime."&mobile=".$phoneNumber, FALSE);
        $data->time = $curTime;
        $data->extend = $extend;
        $data->ext = $ext;
//        return $this->util->sendCurlPost($wholeUrl, $data);
        $dsa=Common::post_Data($wholeUrl,json_encode($data));
        var_dump(json_decode($dsa));
    }
    function getRandom() {
        return rand(100000, 999999);
    }

}


