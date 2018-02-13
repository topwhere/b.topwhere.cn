<?php
/**
 * Created by PhpStorm.
 * User: sun
 * Date: 2017/7/15
 * Time: 09:49
 */
namespace App\Services;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Http\Request;

class CommonService extends Controller{
    public $getTopMenu;
    public $getMenu;
    public function __construct()
    {
        $this->getTopMenu=$this->getTopMenu();
        $this->getMenu=$this->getMenu();
    }
    public static function pass($pass)
    {
        return hash_hmac('ripemd160',$pass,'secret');
    }
    public function getTopMenu()
    {
        $menus=Permission::where('status',1)->where('pid',0)
            ->orderby('sort','desc')->get();
        return $menus;
    }

    /**
     * @package getMenu
     * @author 石头哥 sun@httproot.com
     * data:2017/11/20
     * @param unknown $
     * @return unknown
     */
    public function getMenu(){
        $menus=Permission::where('status',1)->orderby('sort','desc')->get();
        return $menus;
    }
    function Menu($data , $id = 0 , $lev = 0) {
        static $menu = [];
        foreach($data as $key => $value){
            if($value['pid'] == $id) {
                $value['lev'] = $lev;
                $menu[] = $value;
                $this->Menu($data , $value['id'] , $lev+1);
            }
        }
        return $menu;
    }
    // 以POST方式提交数据
    public static function post_Data($url, $param=null, $is_file = false, $return_array = true) {
        if (! $is_file && is_array ( $param )) {
            $param = json_encode($param);
        }
        if ($is_file) {
            $header [] = "content-type: multipart/form-data; charset=UTF-8";
        } else {
            $header [] = "content-type: application/json; charset=UTF-8";
        }
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        if($param != null){
            curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );
        }
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        $res = curl_exec ( $ch );
//        return $res;die;
        $flat = curl_errno ( $ch );
        if ($flat) {
            $data = curl_error ( $ch );
        }
//        var_dump($res);
        curl_close ( $ch );
//        $return_array && $res = json_decode ( $res, true );
        return $res;
    }

    public static function get_Data($url,$is_file = false, $return_array = true){
        if ($is_file) {
            $header [] = "content-type: multipart/form-data; charset=UTF-8";
        } else {
            $header [] = "content-type: application/json; charset=UTF-8";
        }
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "GET" );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        $res = curl_exec ( $ch );
        $flat = curl_errno ( $ch );
        if ($flat) {
            $data = curl_error ( $ch );
        }
        curl_close ( $ch );
//        $return_array && $res = json_decode ( $res );
        return $res;
    }
    //算两经纬度的距离
    public static function getDistance($lng1,$lat1,$lng2,$lat2){
        //将角度转为狐度
        $radLat1=deg2rad($lat1);//deg2rad()函数将角度转换为弧度
        $radLat2=deg2rad($lat2);
        $radLng1=deg2rad($lng1);
        $radLng2=deg2rad($lng2);
        $a=$radLat1-$radLat2;
        $b=$radLng1-$radLng2;
        $s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137*1000;
        return $s;
    }

    /**
     * 根据经纬度和半径计算出范围
     * @param string $lat 经度
     * @param String $lng 纬度
     * @param float $radius 半径
     * @return Array 范围数组
     */
    public static function calcScope($lat, $lng, $radius) {
        $degree = (24901*1609)/360.0;
        $dpmLat = 1/$degree;
        $radiusLat = $dpmLat*$radius;
        $minLat = $lat - $radiusLat;       // 最小经度
        $maxLat = $lat + $radiusLat;       // 最大经度

        $mpdLng = $degree*cos($lat * (PI/180));
        $dpmLng = 1 / $mpdLng;
        $radiusLng = $dpmLng*$radius;
        $minLng = $lng - $radiusLng;      // 最小纬度
        $maxLng = $lng + $radiusLng;      // 最大纬度

        /** 返回范围数组 */
        $scope = array(
            'minLat'    =>  $minLat,
            'maxLat'    =>  $maxLat,
            'minLng'    =>  $minLng,
            'maxLng'    =>  $maxLng
        );
        return $scope;
    }
    /**
     * 二维数组根据字段进行排序
     * @params array $array 需要排序的数组
     * @params string $field 排序的字段
     * @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
     */
    public  static function  arraySequence($array, $field, $sort = 'SORT_DESC')
    {
        $arrSort = array();
        foreach ($array as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        array_multisort($arrSort[$field], constant($sort), $array);
        return $array;
    }
}