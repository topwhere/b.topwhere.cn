<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<link rel="stylesheet" href="/home/css/searchHotel.css" />
<title>查找酒店</title>
<script src="/home/js/scale.js"></script>
<style type="text/css">
/**{
    margin:0px;
    padding:0px;
}*/
/*body, button, input, select, textarea {
    font: 12px/16px Verdana, Helvetica, Arial, sans-serif;
}*/
body{
	margin:0 !important;
	}
#info {
    margin-top: 10px;
}
#container{
	min-width:750px;
	min-height:600px;
}

</style>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script>
var init = function() {
    var center = new qq.maps.LatLng(39.916527,116.397128);
    var map = new qq.maps.Map(document.getElementById('container'),{
        center: center,
        zoom: 13
    });
    var infoWin = new qq.maps.InfoWindow({
        map: map
    });
    infoWin.open();
    //tips  自定义内容
    infoWin.setContent('<div style="width:200px;padding-top:10px;">'+
        '<img style="float:left;" src=""/> '+
        '北京万豪酒店</div>');
    infoWin.setPosition(center);
}
</script>
</head>
<body onload="init()">
    <div id="container"></div>
    <!--<div id="info">
    	<p>调用open方法打开一个信息窗，内容为一张图片和一段文字。</p>
    </div>-->
    <div>
    	<div class="hotelList">
    		<div>北京香格里拉饭店</div>
    		<p>海淀区紫竹院路29号</p>
    	</div>
    	<div class="hotelList">
    		<div>北京富力万丽酒店</div>
    		<p>朝阳区东三环中路61号</p>
    	</div>
    	<div class="hotelList">
    		<div>北京丽晶酒店</div>
    		<p>东城区金宝街99号</p>
    	</div>
    	<div class="hotelList">
    		<div>北京君悦大酒店</div>
    		<p>王府井</p>
    	</div>
    </div>
    
</body>
</html>
