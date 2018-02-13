<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>酒店查询搜索</title>
		<link rel="stylesheet" href="/home/css/public.css" />
		<link rel="stylesheet" href="/home/css/hotelSeek.css" />
		<link rel="stylesheet" href="/home/css/calendar.css" />
		<link rel="stylesheet" href="/home/css/datestyle.css" />
		<script src="/home/js/scale.js"></script>
		<script src="/home/js/jquery-1.8.3.js"></script>
	</head>
	<body>
		<div class="hotelSeeK_bg"><img src="/home/images/hotelB.jpg" alt="" /></div>
		<div class="hotelTitle z-clearfix">
			<div class="back z-fl">
				<p class="inHL" onclick='history.go(-1)'></p>
			</div>
			<div class="z-fl">酒店查询搜索</div>
			<div class="filt z-fl"><a href="chooseArea.html">筛选</a></div>
		</div>
		<div class="hotelSeek_search">
			<div class="hs_header z-clearfix">
				<div class="hsLeft z-fl">
					<input type="text" placeholder="北京/万豪酒店"/>
				</div>
				<div class="hsRight z-fr">我的位置</div>
			</div>
			<!--dateStart-->
			<div id="checkinout">
				<div id="firstSelect" style="width:100%;">
					<div class="Date_lr" style="float:left;">
						<P>入驻日期</p>
						<input id="startDate" type="text" value=""style="" readonly>
					</div>
					<div class="Date_lr" style="float:right;">
						<p>离店日期</p>
						<input id="endDate" type="text" value="" style="" readonly>
					</div>
					<span class="span21">共<span class="NumDate">1</span>晚</span>
				</div>
			</div>
			<!--dateEnd-->
			<div class="find"><a href="hotelLists.html">查询</a></div>
		</div>
		<div class='recommend'>
			<div>附近推荐</div>
		</div>
		<div class="hotelList z-clearfix">
			<a href="hotelDetails.html">
				<div class="hotelImg z-fl"><img src="/home/images/hotel1.png" alt="" /></div>
				<div class="hotelData z-fl">
					<div class="hotelName">
						<span>北京励骏酒店</span>
						<span class="best">最优</span>
						<span  class="best">最优</span>
					</div>
					<p class="hotelPlace">东城区金宝街92号</p>
					<div class="starWrap">
						<span class="starNub">星级:</span>
						<span class="star"></span>
						<span class="star"></span>
						<span class="star"></span>
						<span class="star"></span>
						<span class="star"></span>
					</div>
					<ul class="environment z-clearfix">
						<li class="z-fl deduction">优惠券抵扣</li>
						<li class="z-fl merit">干净舒适</li>
						<li class="z-fl merit">交通便利</li>
					</ul>
				</div>
				<div class="hotelPrice">
					<span>¥1043</span>
					<span>起</span>
				</div>
			</a>
		</div>
		<div class="hotelList z-clearfix">
			<a href="hotelDetails.html">
				<div class="hotelImg z-fl"><img src="/home/images/hotel2.png" alt="" /></div>
				<div class="hotelData z-fl">
					<div class="hotelName">
						<span>北京丽景湾国际酒店</span>
						<span class="best">最优</span>
						<span  class="best">最优</span>
					</div>
					<p class="hotelPlace">朝阳区东四环十里堡北里28号</p>
					<div class="starWrap">
						<span class="starNub">星级:</span>
						<span class="star"></span>
						<span class="star"></span>
						<span class="star"></span>
						<span class="star"></span>
						<span class="star"></span>
					</div>
					<ul class="environment z-clearfix">
						<li class="z-fl deduction">优惠券抵扣</li>
						<li class="z-fl merit">干净舒适</li>
						<li class="z-fl merit">交通便利</li>
					</ul>
				</div>
				<div class="hotelPrice">
					<span>¥643</span>
					<span>起</span>
				</div>
			</a>
		</div>
		<div class="hotelList z-clearfix">
			<div class="hotelImg z-fl"><img src="/home/images/hotel3.png" alt="" /></div>
			<div class="hotelData z-fl">
				<div class="hotelName">
					<span>北京四季酒店</span>
					<span class="best">最优</span>
					<span  class="best">最优</span>
				</div>
				<p class="hotelPlace">朝阳区亮马桥路48号</p>
				<div class="starWrap">
					<span class="starNub">星级:</span>
					<span class="star"></span>
					<span class="star"></span>
					<span class="star"></span>
					<span class="star"></span>
					<span class="star"></span>
				</div>
				<ul class="environment z-clearfix">
					<li class="z-fl deduction">优惠券抵扣</li>
					<li class="z-fl merit">干净舒适</li>
					<li class="z-fl merit">交通便利</li>
				</ul>
			</div>
			<div class="hotelPrice">
				<span>¥1709</span>
				<span>起</span>
			</div>
		</div>
		
		<!--日期-->
		<div class="mask_calendar">
			<div class="calendar"></div>
		</div>
	<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="js/date.js"></script>
	<script>
		$(function(){
			$('#firstSelect').on('click',function () {
				$('.mask_calendar').show();
			});
			$('.mask_calendar').on('click',function (e) {
				if(e.target.className == "mask_calendar"){
					$('.calendar').slideUp(200);
	                $('.mask_calendar').fadeOut(200);
				}
			})
			$('#firstSelect').calendarSwitch({
				selectors : {
					sections : ".calendar"
				},
                index : 4,      //展示的月份个数
                animateFunction : "slideToggle",        //动画效果
                controlDay:true,//知否控制在daysnumber天之内，这个数值的设置前提是总显示天数大于90天
                daysnumber : "90",     //控制天数
                comeColor : "#2EB6A8",       //入住颜色
                outColor : "#2EB6A8",      //离店颜色
                comeoutColor : "#E0F4F2",        //入住和离店之间的颜色
                callback :function(){//回调函数
                	$('.mask_calendar').fadeOut(200);
                	var startDate = $('#startDate').val();  //入住的天数
	                var endDate = $('#endDate').val();      //离店的天数
	                var NumDate = $('.NumDate').text();    //共多少晚
	                console.log(startDate);
	                console.log(endDate);
	                console.log(NumDate);
	                //下面做ajax请求
	                //show_loading();
	                /*$.post("demo.php",{startDate:startDate, endDate:endDate, NumDate:NumDate},function(data){
	                    if(data.result==1){
	                        //成功
	                    } else {
	                        //失败
	                    }
	                });*/
                }  ,   
                comfireBtn:'.comfire'//确定按钮的class或者id
            });
			var b=new Date();
            var ye=b.getFullYear();
            var mo=b.getMonth()+1;
            mo = mo<10?"0"+mo:mo;
            var da=b.getDate();
            da = da<10?"0"+da:da;
            $('#startDate').val(ye+'-'+mo+'-'+da);
            b=new Date(b.getTime()+24*3600*1000);
            var ye=b.getFullYear();
            var mo=b.getMonth()+1;
            mo = mo<10?"0"+mo:mo;
            var da=b.getDate();
            da = da<10?"0"+da:da;
            $('#endDate').val(ye+'-'+mo+'-'+da);
        });
//		$.ajax({
//			url:'http://api.map.baidu.com/location/ip?ak=qGirhmHqGhbLABFujktQG7NDQU2Isc2W&coor=bd09ll',
//			dataType:'jsonp',
//			success:function (suc) {
//				console.log(suc);
//            },
//			err:function (err) {
//				console.log(err)
//            }
//		})
        function showPosition(position){
            var lat = position.coords.latitude; //纬度
            var lag = position.coords.longitude; //经度
            alert('纬度:'+lat+',经度:'+lag);
        }
        function showError(error){
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("定位失败,用户拒绝请求地理定位");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("定位失败,位置信息是不可用");
                    break;
                case error.TIMEOUT:
                    alert("定位失败,请求获取用户位置超时");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("定位失败,定位系统失效");
                    break;
            }
        }

            if (navigator.geolocation){
                navigator.geolocation.getCurrentPosition(showPosition,showError);
            }else{
                alert("浏览器不支持地理定位。");
            }

	</script>
</body>
</html>