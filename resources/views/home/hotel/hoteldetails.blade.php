<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>酒店详情</title>
		<link rel="stylesheet" href="/home/css/public.css" />
		<link rel="stylesheet" href="/home/css/hotelDetails.css" />
		<link rel="stylesheet" href="/home/css/calendar.css" />
		<link rel="stylesheet" href="/home/css/datestyle.css" />
		<script src="/home/js/scale.js"></script>
	</head>
	<body style="background:#f0eff5">
		<div class="hotelSeeK_bg"><img src="/home/images/hotelB.jpg" alt="" /></div>
		<div class="hotelTitle z-clearfix">
			<div class="back z-fl">
				<p class="inHL" onclick="history.go(-1)"></p>
			</div>
			<div class="z-fl">酒店详情</div>
		</div>
		<div class="hotelSeek_search">
			<div class="hs_header z-clearfix">
				<div class="hsImg z-fl"><img src="/home/images/hotel1.png" style="width:100%;height:100%;"alt="" /></div>
				<div class="hotDetail z-fl">
					<p class="hotName">万豪酒店</p>
					<p>最优</p>
					<p>最优</p>
					<div class="hlPlace">北京市东城区建国门南大街7号</div>
					<a href="hotelIntroduce.html"><div class="cli"></div></a>
				</div>
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
		</div>
		<div class='recommend'>
			<div class="starWrap z-clearfix">
					<p class="starNub z-fl">星级:</span>
					<p class="star z-fl"></p>
					<p class="star z-fl"></p>
					<p class="star z-fl"></p>
					<p class="star z-fl"></p>
					<p class="star z-fl"></p>
			</div>
		</div>
		<div class="romtype z-clearfix">
			<div class="romtypeL z-fl">
				<div>客房<a href="roomDetails.html"><img src="/home/images/up.png" alt="" /></a></div>
				<!--<span></span>-->
			</div>
			<div class="romtypeR  z-fr">
				<span>¥999</span>
				<span>起</span>
			</div>
		</div>
		<div class="bookCon">
			<div class="book z-clearfix">
				<div class="z-fl">会员价</div>
				<div class="z-fr reserve"><a href="{{url('home/writeIndent')}}">预定</a></div>
				<div class="z-fr">¥1080</div>
				<div class="z-fr">无早</div>
			</div>
			<div class="book z-clearfix">
				<div class="z-fl">会员价</div>
				<div class="z-fr reserve"><a href="{{url('home/writeIndent')}}">预定</a></div>
				<div class="z-fr">¥1280</div>
				<div class="z-fr">双早</div>
			</div>
		</div>
		<div class="romtype z-clearfix">
			<div class="romtypeL z-fl">
				<div>行政间<a href="roomDetails.html"><img src="/home/images/up.png" alt="" /></a></div>
			</div>
			<div class="romtypeR  z-fr">
				<span>¥1098</span>
				<span>起</span>
			</div>
		</div>
		<div class="romtype z-clearfix">
			<div class="romtypeL z-fl">
				<div>单间套房<img src="/home/images/up.png" alt="" /></div>
			</div>
			<div class="romtypeR  z-fr">
				<span>¥1308</span>
				<span>起</span>
			</div>
		</div>
		<div class="romtype z-clearfix">
			<div class="romtypeL z-fl">
				<div>豪华间<img src="/home/images/up.png" alt="" /></div>
			</div>
			<div class="romtypeR  z-fr">
				<span>¥1400</span>
				<span>起</span>
			</div>
		</div>
		<div class="romtype z-clearfix">
			<div class="romtypeL z-fl">
				<div>标准套房<img src="/home/images/up.png" alt="" /></div>
			</div>
			<div class="romtypeR  z-fr">
				<span>¥1680</span>
				<span>起</span>
			</div>
		</div>
		
		<div class="romtype z-clearfix">
			<div class="romtypeL z-fl">
				<div>行政套间<img src="/home/images/up.png" alt="" /></div>
			</div>
			<div class="romtypeR  z-fr">
				<span>¥1898</span>
				<span>起</span>
			</div>
		</div>
		<!--日期-->
		<div class="mask_calendar">
			<div class="calendar"></div>
		</div>
	<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="/home/js/date.js"></script>
	<script>
		$('.romtypeR').click(function(){
			$('.bookCon').toggle();
		})
	
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
	</script>
</body>
</html>