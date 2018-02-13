<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>发票</title>
		<link rel="stylesheet" href="/home/css/public.css" />
		<link rel="stylesheet" href="/home/css/invoice.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
		<script src="/home/js/scale.js"></script>
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
		<style>
			
		</style>
	</head>
	<body style="background:#efeff4;height:1200px;">
		<div class="invoiceHeader">
			<div>发票</div>
			<div class="inHL" onclick="history.go(-1)"></div>
			<div class="save">保存</div>
		</div>
		<div class="addinWrap" style="display:block">
			<div class="invoMiddle">
				<div class="invoH">常用发票信息</div>
				<div class="inLists z-clearfix">
					<div class="sign  z-fl">
						<p class=""></p>
					</div>
					<p class="invoName z-fl">
						<span>个人&nbsp;(住宿费)</span>
						<span>(普票)</span>
					</p>
					<div class="dele z-fr">
						<p class=""></p>
					</div>
					<div class="edit z-fr">
						<p class=""></p>
					</div>
				</div>
			</div>
			<div class="addInvo">
				<div>+添加发票信息</div>
			</div>
		</div>
		<div id="invoCon"class="invoCon" style="display:none">
			<div class="oftenInfo">常用发票信息</div>
			<div class="invoStyle">
				<div class="common z-clearfix">
					<div >增值税普通发票<img src="/home/images/1.png" alt="" class="checkShow " style=""/></div>
				</div>
				<div class="specially z-clearfix">
					<div>增值税专用发票<img src="/home/images/1.png" alt="" class="check"/></div>
				</div>
			</div>
			<div class="invoInfo">发票信息</div>
			<div class="infoList">
				<label >企业名称</label>
				<input type="text"placeholder="营业执照上的法定名称" />
			</div>
			<div class="infoList">
				<label >信用代码</label>
				<input type="text"placeholder="统一社会信用代码" />
			</div>
			<div class="infoList">
				<label >注册地址</label>
				<input type="text"placeholder="公司注册地址" />
			</div>
			<div class="infoList">
				<label >联系电话</label>
				<input type="number"placeholder="区号-总机" />
			</div>
			<div class="infoList">
				<label >开户行</label>
				<input type="text"placeholder="对外付款的开户行" />
			</div>
			<div class="infoList">
				<label >开户行账号</label>
				<input type="text"placeholder="对外付款的银行账号" />
			</div>
		</div>
		<script>
		</script>
		<script>
		
			
			$('.invoStyle div').click(function(){
				$(this).children().children().show();
				$(this).siblings().children().children().hide();
			})
			$('.addInvo').on("click",function(){
				$('.addinWrap').hide();
				$("#invoCon").show();
				$(".save").show();
			})
		var time = 0;//初始化起始时间  
		$(".inLists").on('touchstart', function(e){  
		    e.stopPropagation();  
		     e.preventDefault();
		    var index=$(".inLists").index($(this));  
		    console.log(index)
		    console.log($(this))
		    time = setTimeout(function(){  
		        showCloseImg(index);  
		    }, 500);
		});  
		  
		$(".inLists").on('touchend',  function(e){  
		    e.stopPropagation();  
		     e.preventDefault();
		    clearTimeout(time);    
		});  
		  
		function showCloseImg(index){  
			var e=$(".inLists").eq(index);  
		  console.log(e)
		  e.children().addClass("show");
		  console.log(e.children())
		  
		}  
		
  
		</script>
	</body>
</html>
