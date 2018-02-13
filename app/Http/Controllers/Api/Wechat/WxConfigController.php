<?php

namespace App\Http\Controllers\Api\Wechat;

use App\Models\Config;
use App\Services\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxConfigController extends Controller
{
    public static function getAppid()
    {
        return Config::where('name','appid')->first()['value'];
    }
    public static function getSecret()
    {
        return Config::where('name','appsecret')->first()['value'];
    }
    public static function getAccessToken()
    {
        $acctokentime=Config::where('name','accessTokenTime')->first()['value'];
        if ($acctokentime<time()){
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::getAppid()."&secret=".self::getSecret();
            $res=json_decode(Common::get_Data($url),true);
            Config::updateOrCreate(['name'=>'access_token'],['name'=>'access_token','value'=>$res['access_token']]);
            Config::updateOrCreate(['name'=>'accessTokenTime'],['name'=>'accessTokenTime','value'=>time()+$res['expires_in']]);
            return $res['access_token'];
        }else{
            return Config::where('name','access_token')->first()['value'];
        }
    }

    public static function getJsapiTicket()//获取jsapiticket
    {
        $jsapi_ticket_time=Config::where('name','jsapi_ticket_time')->first()['value'];
        if ($jsapi_ticket_time<time()){
            $url="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".self::getAccessToken()."&type=jsapi";
            $res=json_decode(Common::get_Data($url),true);
            Config::updateOrCreate(['name'=>'jsapi_ticket'],['name'=>'jsapi_ticket','value'=>$res['ticket']]);
            Config::updateOrCreate(['name'=>'jsapi_ticket_time'],['name'=>'jsapi_ticket_time','value'=>time()+$res['expires_in']]);
            return $res['ticket'];
        }else{
            return Config::where('name','jsapi_ticket')->first()['value'];
        }
    }
}
