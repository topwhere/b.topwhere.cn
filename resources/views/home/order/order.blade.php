<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>我的订单</title>
		<link rel="stylesheet" href="/home/css/public.css" />
		<link rel="stylesheet" href="/home/css/myOrder.css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet">
		<script src="/home/js/scale.js"></script>
	</head>
	<body style="background:#efeff4;margin-bottom: 70px;">
		<div class="myReH">
			<div>我的订单</div>
			<div class="inHL" onclick="history.go(-1)"></div>
		</div>
		<!--optionsStart-->
		<ul class="cut z-clearfix">
			<li class="cutlist z-fl">全部订单</li>
			<li class="cutlist z-fl">&nbsp;&nbsp;待支付</li>
			<li class="cutlist z-fl">已支付</li>
			<div class="border"></div>
		</ul>
		<!--optionsEnd-->
		
		<!--indentAllStart-->
		<div class="indentAll indentItem" style="position:relative;z-index: 11;">
			<a href="{{url('home/orderDetails')}}">
				<div class="reDetails">
					<div class="reList">
						<div class="reItemName">北京南锣鼓巷汉庭酒店&nbsp;(南锣鼓巷十四街)</div>
						<div class="not">已取消</div>
						<p><span>北京市东城区南锣鼓巷十四街</span></p>
						<ul class="z-clearfix">
							<li class="z-fl">
								<span>入住&nbsp;</span>
								<span>09/30</span>
							</li>
							<li class="z-fl">
								<span>离店&nbsp;</span>
								<span>10/02</span>
							</li>
							<li class="z-fl">
								<div class="all">共三晚</div>
							</li>
						</ul>	
						<div class="price z-clearfix">
							<div>¥2088</div>
							<!--<div class='status'></div>-->
						</div>
					</div>
					<!--<div class="empty"></div>-->
				</div>
			</a>
			<div class="reDetails">
				<div class="reList">
					<div class="reItemName">北京南锣鼓巷汉庭酒店&nbsp;(南锣鼓巷十四街)</div>
					<div class="not">已入驻</div>
					<p><span>北京市东城区南锣鼓巷十四街</span></p>
					<ul class="z-clearfix">
						<li class="z-fl">
							<span>入住&nbsp;</span>
							<span>09/30</span>
						</li>
						<li class="z-fl">
							<span>离店&nbsp;</span>
							<span>10/02</span>
						</li>
						<li class="z-fl">
							<div class="all">共三晚</div>
						</li>
					</ul>	
					<div class="price z-clearfix">
						<div>¥2088</div>
						<div class='status'>续订</div>
					</div>
				</div>
				<!--<div class="empty"></div>-->
			</div>
			<div class="reDetails">
				<div class="reList">
					<div class="reItemName">北京南锣鼓巷汉庭酒店&nbsp;(南锣鼓巷十四街)</div>
					<div class="not">已结束</div>
					<p><span>北京市东城区南锣鼓巷十四街</span></p>
					<ul class="z-clearfix">
						<li class="z-fl">
							<span>入住&nbsp;</span>
							<span>09/30</span>
						</li>
						<li class="z-fl">
							<span>离店&nbsp;</span>
							<span>10/02</span>
						</li>
						<li class="z-fl">
							<div class="all">共三晚</div>
						</li>
					</ul>	
					<div class="price z-clearfix">
						<div>¥2088</div>
						<!--<div class='status'></div>-->
					</div>
				</div>
				<!--<div class="empty"></div>-->
			</div>
			<div class="reDetails">
				<div class="reList">
					<div class="reItemName">北京南锣鼓巷汉庭酒店&nbsp;(南锣鼓巷十四街)</div>
					<div class="not" style="color:#189afe">未入住</div>
					<p><span>北京市东城区南锣鼓巷十四街</span></p>
					<ul class="z-clearfix">
						<li class="z-fl">
							<span>入住&nbsp;</span>
							<span>09/30</span>
						</li>
						<li class="z-fl">
							<span>离店&nbsp;</span>
							<span>10/02</span>
						</li>
						<li class="z-fl">
							<div class="all">共三晚</div>
						</li>
					</ul>	
					<div class="price z-clearfix">
						<div>¥2088</div>
						<div class='status'>申请退款</div>
					</div>
				</div>
				<!--<div class="empty"></div>-->
			</div>
		</div>
		<!--indentAllEnd-->
		<!--unpaidStart-->
		<div class="unpaid indentItem" style="display:none">
			<div class="reDetails">
				<div class="reList">
					<div class="reItemName">北京南锣鼓巷汉庭酒店&nbsp;(南锣鼓巷十四街)</div>
					<!--<div class="not">未入住</div>-->
					<p><span>北京市东城区南锣鼓巷十四街</span></p>
					<ul class="z-clearfix">
						<li class="z-fl">
							<span>入住&nbsp;</span>
							<span>09/30</span>
						</li>
						<li class="z-fl">
							<span>离店&nbsp;</span>
							<span>10/02</span>
						</li>
						<li class="z-fl">
							<div class="all">共三晚</div>
						</li>
					</ul>	
					<div class="price z-clearfix">
						<div>¥2088</div>
						<!--<div class='status'>退款中</div>-->
						<div class="payment">立即付款</div>
						<div class="closeIndent">取消订单</div>
					</div>
				</div>
				<!--<div class="empty"></div>-->
			</div>
		</div>
		<!--unpaidEnd-->
		<!--paidStart-->
		<div class="paid indentItem" style="display:none">
			<div class="reDetails">
				<div class="reList">
					<div class="reItemName">北京南锣鼓巷汉庭酒店&nbsp;(南锣鼓巷十四街)</div>
					<div class="not">已入住</div>
					<p><span>北京市东城区南锣鼓巷十四街</span></p>
					<ul class="z-clearfix">
						<li class="z-fl">
							<span>入住&nbsp;</span>
							<span>09/30</span>
						</li>
						<li class="z-fl">
							<span>离店&nbsp;</span>
							<span>10/02</span>
						</li>
						<li class="z-fl">
							<div class="all">共三晚</div>
						</li>
					</ul>	
					<div class="price z-clearfix">
						<div>¥2088</div>
						<!--<div class='status'>退款中</div>-->
					</div>
				</div>
				<!--<div class="empty"></div>-->
			</div>
			<div class="reDetails">
				<div class="reList">
					<div class="reItemName">北京南锣鼓巷汉庭酒店&nbsp;(南锣鼓巷十四街)</div>
					<div class="not" style="color:#189afe">未入住</div>
					<p><span>北京市东城区南锣鼓巷十四街</span></p>
					<ul class="z-clearfix">
						<li class="z-fl">
							<span>入住&nbsp;</span>
							<span>09/30</span>
						</li>
						<li class="z-fl">
							<span>离店&nbsp;</span>
							<span>10/02</span>
						</li>
						<li class="z-fl">
							<div class="all">共三晚</div>
						</li>
					</ul>	
					<div class="price z-clearfix">
						<div>¥2088</div>
						<div class='status'>申请退款</div>
					</div>
				</div>
				<!--<div class="empty"></div>-->
			</div>
		</div>
		<!--paidEnd-->
		<!--refundHintStart-->
		<div id="refundHint">
			<div>请填写退款原因</div>
			<textarea placeholder="在此填写" id="" cols="29" rows="7" ></textarea>
			<div class="choice">
				<div class="wClose">取消</div>
				<div class="confirm">确定</div>
			</div>
		</div>
		<!--refundHintEnd-->
		<!--hintStart-->
		<div id="tHint">
			<div>您的申请退款已经提交成功,管理员会在1-3个工作日内审核,请耐心等待...</div>
			<div class="hintConfirm">确定</div>
		</div>
		<!--hintEnd-->
		<div id="gray"></div>
		<script src="/home/js/jquery-1.8.3.js"></script>
		
		<script>
		
		
		$('.cutlist').on("click", function() {
			var i = $(this).index();
			
			$('.indentItem').hide();
			$('.indentItem').eq(i).show();
//			$(this).addClass('hover').siblings().removeClass('hover');
			$('.border').css('left',  74+(i* 240))
		});
		$('.status').click(function(){
		    	$('#refundHint').show().addClass('animated bounceInDown');
		    	tc_center('refundHint');
		    	$('#gray').show();
	    })
		$('.wClose').click(function(){
		    	$('#refundHint').hide();
		    	$('#gray').hide();
	    })
		$('.confirm').click(function(){
				$('#refundHint').hide();
		    	$('#tHint').show();
		    	tc_center('tHint');
		    	$('#gray').show();
	    })
		$('.hintConfirm').click(function(){
		    	$('#tHint').hide();
		    	$('#gray').hide();
	    })
		
		function tc_center(obj){
//			console.log($(window).scrollTop())
//			console.log($(window).height())
//			console.log($(window).outerHeight())
			var _top=(($(window).innerHeight()+$(window).scrollTop())-$("#"+obj).height())/2;
			var _left=($(window).innerWidth()-$("#"+obj).width())/2;
			$("#"+obj).css({top:_top,left:_left});
		}	

		</script>
	</body>
</html>
