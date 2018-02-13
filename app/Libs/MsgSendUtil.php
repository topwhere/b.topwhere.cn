<?php
class MsgSendUtil {
    
    public static $MSG_SEND_SUCCESS_STATUS = '0';
    const msg_template_reg = 'reg';
    const msg_template_backpwd = 'backpwd';
    const msg_template_editphone = 'editphone';
    
    const account = '989d51';
    const password = 'zj7rsk24bd';
    const host = 'http://api.chanzor.com/';
    
    public static function send($mobile, $code, $template = ''){
        $action = 'send';
        $txt = '您的验证码是'.$code.'【悠然呼吸】'; 
        $data = array(
            'mobile'=>$mobile,'content'=>$txt
        );
        $result = self::send_post($data,  self::host.$action);
        return $result['status'];
        //{"taskId":"161017161334422359","overage":29,"mobileCount":1,"status":0,"desc":"发送成功"}
    }
    
    public static function account(){
        $action = 'overage';
        $result = self::send_post(NULL,self::host.$action);
    }

    public static function send_post($data,$url){
        $params = json_encode($data);
        $url = $url.'?account='.  self::account.'&password='.strtoupper(md5(self::password));
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $url .= '&'.$key.'='.urlencode($value);
            }
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE ); 
        curl_setopt($curl, CURLOPT_HEADER, 0 );        // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 显示输出结果
        curl_setopt($curl, CURLOPT_POST, true );       // post传输数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params );// post传输数据
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           "content-type: application/x-www-form-urlencoded;charset=UTF-8")
        );
        $responseText = curl_exec($curl);
        return json_decode($responseText,true);
    }
}
