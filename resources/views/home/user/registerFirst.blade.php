<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>注册1</title>
		<link rel="stylesheet" href="/home/css/public.css"/>
		<link rel="stylesheet" href="/home/css/registerSe.css"/>
		<script src="/home/js/scale.js"></script>
	</head>
	<body>
		<div id="wrap">
			<div class="logo"></div>
			<div class="register">
				<p class="companyId"><input type="nubmer" placeholder="请输入你公司的ID号" id="cc"/></p>
			</div>
			<div class="next">下一步</div>
		</div>
	</body>
<script>
	var next=document.getElementsByClassName('next')[0];
	next.onclick=function () {
        var getval =document.getElementById("cc").value;
        localStorage.setItem("companyId",getval);
    }

</script>
</html>
