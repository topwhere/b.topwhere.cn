<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>优惠券</title>
		<link rel="stylesheet" href="/home/css/public.css" />
		<!--<link rel="stylesheet" href="css/myOrder.css" />-->
		<link rel="stylesheet" href="/home/css/disTicket.css" />
		<script src="/home/js/scale.js"></script>
	</head>
	<body style="background:#efeff4;margin-bottom: 70px;">
		<div class="myReH">
			<div>优惠券</div>
			<div class="inHL" onclick="history.go(-1)"></div>
		</div>
		<!--optionsStart-->
		<ul class="cut z-clearfix">
			<li class="cutlist z-fl">未使用</li>
			<li class="cutlist z-fl">&nbsp;&nbsp;已使用</li>
			<li class="cutlist z-fl">已过期</li>
			<div class="border"></div>
		</ul>
		<!--optionsEnd-->
		<!--indentAllStart-->
		<div class="indentAll indentItem" style="position:relative;z-index: 11;">
			<a href="{{url('home/couponDetails')}}">
				<div class="dtDetails z-clearfix">
					<div class="dtLf z-fl">
						<div>
							<span>￥</span>
							<span>25</span>
						</div>
						<div>1张</div>
					</div>
					<div class="dtRt z-fl">
						<div>易事达25元通用券</div>
						<div>有效期到2017.10.30</div>
						<div class="arrows"></div>
					</div>
				</div>
			</a>			
			<a href="{{url('home/couponDetails')}}">
				<div class="dtDetails z-clearfix">
					<div class="dtLf z-fl">
						<div>
							<span>￥</span>
							<span>25</span>
						</div>
						<div>1张</div>
					</div>
					<div class="dtRt z-fl">
						<div>易事达25元通用券</div>
						<div>有效期到2017.10.30</div>
						<div class="arrows"></div>
					</div>
				</div>
			</a>			
			<a href="{{url('home/couponDetails')}}">
				<div class="dtDetails z-clearfix">
					<div class="dtLf z-fl">
						<div>
							<span>￥</span>
							<span>25</span>
						</div>
						<div>1张</div>
					</div>
					<div class="dtRt z-fl">
						<div>易事达25元通用券</div>
						<div>有效期到2017.10.30</div>
						<div class="arrows"></div>
					</div>
				</div>
			</a>			
		</div>
		<!--indentAllEnd-->
		<!--unpaidStart-->
		<div class="unpaid indentItem" style="display:none">
			<div class="dtDetails z-clearfix">
				<div class="dtLf z-fl">
					<div>
						<span>￥</span>
						<span>25</span>
					</div>
					<div>1张</div>
				</div>
				<div class="dtRt z-fl">
					<div>易事达25元通用券</div>
					<div>有效期到2017.10.30</div>
					<div class="due"></div>
				</div>
			</div>
			<div class="dtDetails z-clearfix">
				<div class="dtLf z-fl">
					<div>
						<span>￥</span>
						<span>25</span>
					</div>
					<div>1张</div>
				</div>
				<div class="dtRt z-fl">
					<div>易事达25元通用券</div>
					<div>有效期到2017.10.30</div>
					<div class="due"></div>
				</div>
			</div>
			<div class="dtDetails z-clearfix">
				<div class="dtLf z-fl">
					<div>
						<span>￥</span>
						<span>25</span>
					</div>
					<div>1张</div>
				</div>
				<div class="dtRt z-fl">
					<div>易事达25元通用券</div>
					<div>有效期到2017.10.30</div>
					<div class="due"></div>
				</div>
			</div>
		</div>
		<!--unpaidEnd-->
		<!--paidStart-->
		<div class="paid indentItem" style="display:none">
			<div class="dtDetails z-clearfix">
				<div class="dtLf z-fl">
					<div>
						<span>￥</span>
						<span>25</span>
					</div>
					<div>1张</div>
				</div>
				<div class="dtRt z-fl">
					<div>易事达25元通用券</div>
					<div>有效期到2017.10.30</div>
					<div class="employ"></div>
				</div>
			</div>
			<div class="dtDetails z-clearfix">
				<div class="dtLf z-fl">
					<div>
						<span>￥</span>
						<span>25</span>
					</div>
					<div>1张</div>
				</div>
				<div class="dtRt z-fl">
					<div>易事达25元通用券</div>
					<div>有效期到2017.10.30</div>
					<div class="employ"></div>
				</div>
			</div>
			<div class="dtDetails z-clearfix">
				<div class="dtLf z-fl">
					<div>
						<span>￥</span>
						<span>25</span>
					</div>
					<div>1张</div>
				</div>
				<div class="dtRt z-fl">
					<div>易事达25元通用券</div>
					<div>有效期到2017.10.30</div>
					<div class="employ"></div>
				</div>
			</div>
		</div>
		<!--paidEnd-->
		<script src="/home/js/jquery-1.8.3.js"></script>
		<script>
		$('.cutlist').on("click", function() {
			var i = $(this).index();
			$('.indentItem').hide();
			$('.indentItem').eq(i).show();
//			$(this).addClass('hover').siblings().removeClass('hover');
			$('.border').css('left',  82+(i* 245))
		});

		</script>
	</body>
</html>
