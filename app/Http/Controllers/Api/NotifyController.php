<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use WxPay.Data;
// require_once './pay/weixin/lib/WxPay.Data.php';
// require_once './pay/alipay/lib/alipay_notify.class.php';
/*
 * 支付回调
 */
class NotifyController extends BaseController {
    const PAY_WAY_ALIPAY = 1;//支付宝
    const PAY_WAY_WEIXIN = 2;//微信
    const PAY_STATUS_SUCC= 1;//支付成功状态
    
    public function weixin(){
        $data = file_get_contents("php://input");
        #Log::write('weixin pay notify==============>:'.$data,Log::INFO);
        $result = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $out_trade_no   = $result['out_trade_no']; //商户订单号
        $result_code    = $result['result_code'];
        $transaction_id = $result['transaction_id']; //微信交易号
        $total_fee = $result['total_fee'];
        $handler = new \WxPayResults();
        $handler->FromArray($result);
        if(!$handler->CheckSign()){
            Log::write('wx notify sign error');
            exit($this->reply_wx('FAIL'));
        }
        if($result_code == 'SUCCESS'){
            $data = array('tradeid'=>$transaction_id,'outid'=>$out_trade_no,'payway'=>2,'amount'=>$total_fee*100);
            $rs   = $this->handler_shop_order($data);
        }
        if($rs){
            exit($this->reply_wx('SUCCESS'));
        }else{
            exit($this->reply_wx('FAIL'));
        }
    }

    private function reply_wx($result){
       echo "<xml><return_code><![CDATA[$result]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
    }

    /*
     * 订单支付
     */
    private function handle_shop_order($data){

    	//查找订单
    	$order = DB::table("order")->where("order_id",$data['outid'])->where("status",0)->first();
    	if(DB::table("order")->where("order_id",$data['outid'])->where("status",0)->update(array("status"=>1))){
    		$rs = true;
    	}else{
    		$rs = false;
    	}
        return $rs;
    }
}