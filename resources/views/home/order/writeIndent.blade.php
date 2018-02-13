<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>填写订单</title>
		<link rel="stylesheet" href="/home/css/public.css" />
		<link rel="stylesheet" href="/home/css/writeIindent.css" />
		<link rel="stylesheet" href="/home/css/iosSelect.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet">
		<script src="/home/js/scale.js"></script>
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
		<script src="http://res.layui.com/layui/release/layer/dist/mobile/layer.js"></script>
	</head>
	<body >
		<div id="writeIndent"style="background:#efeff4;height:1200px;position:relative;">
			<div class="indentH">
				<div style="display:inline-block"><img src="/home/images/hotel.jpg" alt="" /></div>
				<div class="introduce">
					<div>万豪酒店</div>
					<ul class="z-clearfix">
						<li class="z-fl">
							<span>入住</span>
							<span>09月30日</span>
						</li>
						<li class="z-fl">
							<span>离店</span>
							<span>10月2日</span>
						</li>
					</ul>
					<div >北京市东城区建国门南大街7号</div>
				</div>
			</div>
			<div class="itdentCon z-clearfix">
				<label class="z-fl">榻榻米</label>
				<div class="count z-fr">
					<span class="reduce">-</span>
					<input class="num"value="1"/>
					<span class="increase">+</span>
				</div>
			</div>
			<div class="itdentCon ">
				<label >入住人</label>
				<input type="text" placeholder="请输入姓名"/>
			</div>
			<div class="itdentCon ">
				<label >手机号</label>
				<input type="text" placeholder="请填写手机号"/>
			</div>
			<div class="itdentCon ">
				<label >积分</label>
				<span class="integral">使用积分抵扣部分房费</span>
			</div>
			<div class="itdentCon ">
				<label >优惠券</label>
				<span class="ticket">使用优惠券抵扣部分房费</span>
			</div>
			<div class="itdentCon ">
				<label >发票</label>
				<input type="text" placeholder="请填写发票"/>
			</div>
			<div class="submit z-clearfix">
				<div class="total z-fl">
					<span>总额</span>
					<span>￥</span>
					<span class="sum">2430</span>
				</div>				
				<div class="partic z-fl"><a href="{{url('home/housePriceDetails')}}">明细</a></div>
				
				<div class="sub z-fl">提交订单</div>
			</div>
		</div>
		<!--paymentStart-->
		<div id="payment">
			<div class="closeMon"></div>
			<div class='payHe'>支付金额</div>
			<div class="payDeList usable">
				<span>积分</span>
				<span style="padding-right:30px;width:360px">立即使用</span>
				<!--<span>积分</span>
				<input type="hidden" name="integralNumId_id" id="integralNumId" value=""placeholder="我的">                     
		        <span id="integralNum">立即使用</span>  -->
		        <div class="sel"></div>
			</div>
			<div class="integralNum" style="display:none">
				<div class="temporary">暂不使用</div>
				<div class="existing">200积分</div>
			</div>
			<div class="payDeList">
				<span>优惠券</span>
				<span>暂无优惠券</span>
			</div>
			<div class="payDeList">
				<span>储值卡</span>
				<span>暂无储值卡</span>
			</div>
			<div class="payDeList">
				<span>支付方式</span>
				<span>微信</span>
			</div>
			<div class="payDeList">
				<span>需支付</span>
				<span>￥2490</span>
			</div>
			<div class="payDeList">
				<span>实际支付</span>
				<span style="color:red;font-size:32px;">￥2490</span>
			</div>
			<div id="immediatelyPay">
				立即支付
			</div>
		</div>
		<!--paymentEnd-->
		<div id="gray"></div>
		<!--particularsStart-->
		<div id="particulars" style="display:none;position:relative">
			<div class="housePrice">房价明细</div>
			<ul class='z-clearfix detailList'>
				<li class="z-fl">时间</li>
				<li class="z-fl">优惠</li>
				<li class="z-fr"> 价格</li>
			</ul>
			<ul class='z-clearfix conList'>
				<li class="z-fl">12月05日</li>
				<li class="z-fl">￥0</li>
				<li class="z-fl"> ￥2430</li>
			</ul>
			<div class="discounts z-clearfix">
				<div class="z-fl">共优惠</div>
				<div class="z-fr">￥0</div>
			</div>
			<div class="sum z-clearfix">
				<div class="z-fl">总额</div>
				<div class="z-fr">￥2430</div>
			</div>
			<div class="shut"></div>
		</div>
		<!--particularsEnd-->

		<script>
		    $('.sub').click(function(){
		    	$('#payment').show().addClass('animated bounceInUp');
		    	$('#gray').show();
		    })
		    $('.closeMon').click(function(){
		    	$('#payment').hide().addClass('animated bounceInUp');
		    	$('#gray').hide();
		    })
		    $('.usable').click(function(){
		    	$('.integralNum').toggle();
		    })
		    $('.partic').click(function(){
		    	$("#particulars").show();
		    	$("#writeIndent").hide();
		    })
		    $('.shut').click(function(){
		    	$("#particulars").hide();
		    	$("#writeIndent").show();
		    })
		</script>
		<script>
			$(document).ready(function(){
				var money =	$('.sum').html();
				$(".reduce").click(function(){
					var n=$(this).next().val();
					console.log(n)
					var num=parseInt(n)-1;
					if(num==0){ return;}
					$(this).next().val(num);
					var reduSum=  money*num
					$('.sum').html(reduSum)
				});
				$(".increase").click(function(){
					var n=$(this).prev().val();
					var num=parseInt(n)+1;
					if(num==0){ return}
					$(this).prev().val(num);
					var addSum =  money*num
					$('.sum').html(addSum)
				});
				
			
			})
		</script>


    </body>
</html>
