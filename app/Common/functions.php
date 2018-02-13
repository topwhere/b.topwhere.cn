<?php

/**
 * 生成验证码
 * @Author YWW     2018-01-10
 * @param  integer $length    验证码长度
 * @return String             验证码
 */
function create_code($length = 6){
	$code = '';
	for($i = 0; $i < $length; $i++){
		$code .= mt_rand(0,9);
	}
	return $code;
}

/**
 * 生成订单号
 * @Author YWW    2018-01-10
 * @return [type] [description]
 */
function build_order_no(){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/* 生成酒店编码 */
function hotel_id()
{
    return substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/* 生成酒店房型编码 */
function rooms_id()
{
    return substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 4);
}

 /**
 *计算某个经纬度的周围某段距离的正方形的四个点
 *
 *@param lng float 经度
 *@param lat float 纬度
 *@param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
 *@return array 正方形的四个点的经纬度坐标
 */
 function returnSquarePoint($lng, $lat,$distance = 5){
    $dlng =  2 * asin(sin($distance / (2 * 6371)) / cos(deg2rad($lat)));
    $dlng = rad2deg($dlng);
     
    $dlat = $distance/6371;
    $dlat = rad2deg($dlat);
     
    return array(
                'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
                'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
                'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
                'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
                );
 }

/**
 * 计算两点地理坐标之间的距离
 * @param  Decimal $longitude1 起点经度
 * @param  Decimal $latitude1  起点纬度
 * @param  Decimal $longitude2 终点经度 
 * @param  Decimal $latitude2  终点纬度
 * @param  Int     $unit       单位 1:米 2:公里
 * @param  Int     $decimal    精度 保留小数位数
 * @return Decimal
 */
function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){
    $EARTH_RADIUS = 6370.996; // 地球半径系数
    $PI = 3.1415926;
    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI /180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

    if($unit==2){
        $distance = $distance / 1000;
    }

    return round($distance, $decimal);
}

/* 数组转对象 */
function object2array($object) {
    if (is_object($object)) {
        foreach ($object as $key => $value) {
            $array[$key] = $value;
            }    
    }else {
        $array = $object;
    }
        return $array;
}

function DirAndFile( $dirName )
{   
    $handle = opendir($dirName);
    while (false !==$file = readdir($handle)){          
        if ($file !='.' && $file != '..'){  
            $file_fullpath = $dirName.'/'.$file;  
            echo iconv('GBK', 'utf-8', $file_fullpath);  
            echo "<br />";  
            if (!is_dir($file_fullpath)){  
                unlink($file_fullpath);  
            }else{                
                rmdir($file_fullpath);                                  
            }  
        }     
    }
}