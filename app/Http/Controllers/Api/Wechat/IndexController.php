<?php

namespace App\Http\Controllers\Api\Wechat;

use App\Models\WxUser;
use App\Models\Config;
use App\Services\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function Index(Request $request)
    {
        if(isset($_GET['echostr'])){//认证
            return $this->valid();
        }
        //业务处理模块
        return $this->responseMsg($request);
    }

    private function responseMsg(Request $request)
    {
        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ?  $GLOBALS["HTTP_RAW_POST_DATA"] :file_get_contents("php://input");
        if (!empty($postStr)){
//            file_put_contents('./wxcast/wxlog.txt',json_encode($postStr).'======'.PHP_EOL,FILE_APPEND);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            switch ($RX_TYPE)
            {
                case "text":
                    $resultStr = $this->receiveText($postObj);
                    echo $resultStr;
                    break;
                case "event":
                    $resultStr = $this->receiveEvent($postObj);
                    break;
                default:
                    $resultStr = "";
                    break;
            }
            if (isset($postObj->bank_type)){
                $this->zfhuidiao($postObj);
            }
        }else {
            echo "";
            exit;
        }
    }

    private function zfhuidiao($postObj){//支付回调
//        file_put_contents('./zfhd.txt',json_encode($postObj).PHP_EOL,FILE_APPEND);
        $postObj=(array)$postObj;
        $sfy=db('wechat_pay_callback')->where(['transaction_id'=>$postObj['transaction_id']])->find();
        if ($sfy['id']&&$postObj['result_code']=='SUCCESS'){
            echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        }else{
            $data=['appid'=>$postObj['appid'], 'bank_type'=>$postObj['bank_type'], 'cash_fee'=>$postObj['cash_fee'], 'fee_type'=>$postObj['fee_type'], 'is_subscribe'=>$postObj['is_subscribe'], 'mch_id'=>$postObj['mch_id'], 'nonce_str'=>$postObj['nonce_str'], 'openid'=>$postObj['openid'], 'out_trade_no'=>$postObj['out_trade_no'], 'result_code'=>$postObj['result_code'], 'return_code'=>$postObj['return_code'], 'sign'=>$postObj['sign'], 'time_end'=>$postObj['time_end'], 'total_fee'=>$postObj['total_fee'], 'trade_type'=>$postObj['trade_type'], 'transaction_id'=>$postObj['transaction_id']];
            db('wechat_pay_callback')->insert($data);
            echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
//            $order->ordersuccess($postObj['out_trade_no']);
        }

    }
    private function receiveText($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的内容为：".$object->Content;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveEvent($object)//事件
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe"://关注回复
//                $subscribe=Config::where('name','subscribe')->first()['value'];
//                $contentStr = $subscribe;
                 $contentStr[] = [
                     "Title" =>"中国创客论坛",
                     "Description" =>"诚邀请您参加此次活动",
                     "PicUrl" =>"http://httproot.com/images/indexBanner.png",
                     "Url" =>"http://httproot.com/images/indexBanner.png"
                 ];
//                Mobanxiaoxi::fa(''.$object->FromUserName.'','您已注册成功','财富',date('Y/m/d H:i:s',time()),'更多精彩等您发现');
//                $object->EventKey=substr($object->EventKey,8);
                $this->scan($object);//关注事件
                break;
            case "SCAN"://扫码事件
//                $contentStr = "感谢您关注";
//                $this->scan($object);
                break;
            case "unsubscribe"://取消关注
                break;
            case "CLICK":
                switch ($object->EventKey)//菜单按钮
                {
                    case "home":
                        $contentStr[] = [
                            "Title" =>"默认菜单回复",
                            "Description" =>"您正在使用的是自定义菜单测试接口",
                            "PicUrl" =>"http://httproot.com/images/indexBanner.png",
                            "Url" =>"http://httproot.com/images/indexBanner.png"
                        ];
                        $this->scan($object);
                        break;
                    default:
                        $contentStr[] = array("Title" =>"默认菜单回复",
                            "Description" =>"您正在使用的是自定义菜单测试接口",
                            "PicUrl" =>"http://httproot.com/images/indexBanner.png",
                            "Url" =>"http://httproot.com/images/indexBanner.png");
                        break;
                }
                break;
            default:
                break;

        }
        if (is_array($contentStr)){
            $resultStr = $this->transmitNews($object, $contentStr);
        }else{
            $resultStr = $this->transmitText($object, $contentStr);
        }
        echo  $resultStr;
    }
    private function scan($obj){
        $wxyh=WxUser::where('openid',$obj->FromUserName)->first();
        if (!$wxyh){
            $token=WxConfigController::getAccessToken();
            $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token.'&openid='.$obj->FromUserName.'&lang=zh_CN';
            $rs=file_get_contents($url);//获取用户信息
            $rs=json_decode($rs,true);
            $data=[
                'openid'=>$rs['openid'],
                'zjtime'=>time(),
                'tximg'=>$rs['headimgurl'],
                'nickname'=>$rs['nickname'],
                'sex'=>$rs['sex'],
                'language'=>$rs['language'],
                'city'=>$rs['city'],
                'province'=>$rs['province'],
                'country'=>$rs['country'],
                'groupid'=>$rs['groupid']
            ];
//            $wxc=new jssample();
//            $a = $wxc->curl_file_get_contents($rs['headimgurl']);
//            file_put_contents('uploads/yhtx/'.$obj->FromUserName.'.jpg', $a);
//            $ewm=new Ewm();
//            $ewm=$ewm->cear($rs['openid'],$rs['nickname']);
//            file_put_contents('./wxcast/test.txt',json_encode($data),FILE_APPEND);
//            die;
            \App\Models\WxUser::Create($data);
//            Mobanxiaoxi::fa(''.$obj->FromUserName.'','您已注册成功','崟辰财富',date('Y/m/d H:i:s',time()),'更多精彩等您发现');
//            Mobanxiaoxi::newke(''.$obj->EventKey.'','您推荐的会员【'.$rs['nickname'].'】已成功注册',$rs['nickname'],'如该会员进行消费,我们将通知您查收佣金,感谢您的推广');
        }
        return true;
    }

    private function transmitText($object, $content, $funcFlag = 0)
    {
        $textTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        <FuncFlag>%d</FuncFlag>
        </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $funcFlag);
        return $resultStr;
    }

    private function transmitNews($object, $arr_item, $funcFlag = 0)
    {
        //首条标题28字，其他标题39字
        if(!is_array($arr_item))
            return;

        $itemTpl = "<item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
        </item>";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        $newsTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[news]]></MsgType>
        <Content><![CDATA[]]></Content>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        $item_str</Articles>
        <FuncFlag>%s</FuncFlag>
        </xml>";
        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item), $funcFlag);
        return $resultStr;
    }

    private function valid()//认证
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            die;
        }
    }

    private function checkSignature(){//认证
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = Config::where('name','token')->first()['value'];
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}
