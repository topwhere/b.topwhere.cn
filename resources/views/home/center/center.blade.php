<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>个人中心</title>
		<link rel="stylesheet" href="/home/css/public.css" />
		<link rel="stylesheet" href="/home/css/myCenter.css" />
		<script src="/home/js/scale.js"></script>
		<script src="/home/js/jquery-1.8.3.js"></script>
	</head>
	<body style="background:#efeff4">
		<a href="{{url('home/mydata')}}">
			<div id="myCenter" class="z-clearfix">
				<div class="portrait z-fl">
					<img src="/home/images/per.png" alt="" />
				</div>
				<div class="personInfo z-fl">
					<div>蓝月</div>
					<p>
						<span>编号:&nbsp;</span>
						<span>AWE15464454</span>
					</p>
					<p>
						<span>公司:&nbsp;</span>
						<span>北京中微信通网络科技有限公司</span>
					</p>
				</div>
			</div>
		</a>
		<div id="centerDetails">
			<p>
				<a href="{{url('home/order')}}">我的订单</a>
				<a href="{{url('home/order')}}"><span class="arrows"></span></a>
			</p>
			<p>
				<a href="{{url('home/coupon')}}">我的优惠券</a>
				<a href="{{url('home/coupon')}}"><span class="arrows"></span></a>
			</p>
			<p>
				<a href="{{url('home/invoice')}}">我的发票</a>
				<a href="{{url('home/invoice')}}"><span class="arrows"></span></a>
			</p>
			<p>
				<a href="{{url('home/myRefund')}}">我的退款</a>
				<a href="{{url('home/myRefund')}}"><span class="arrows"></span></a>
			</p>
			<p>
				<a href="{{url('home/myIntegral')}}">我的积分</a>
				<a href="{{url('home/myIntegral')}}"><span class="arrows"></span></a>
			</p>
			<p>
				<a href="javascript:void(0)">客服</a>
				<a href=""><span class="arrows"></span></a>
			</p>
		</div>
		<div class="quit">退出</div>
	</body>
<script>
	$('.quit').on('click',function () {

        $.ajax({
            url:'http://111.230.228.126/api/loginout',
            type:'get',
            success:function (data) {
                console.log(data);
                alert(data.msg);
            },
            error:function (err) {
                console.log(err);
            }
        })
    })


</script>
</html>
