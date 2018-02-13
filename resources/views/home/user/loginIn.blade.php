<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>登录</title>
		<link rel="stylesheet" href="/home/css/public.css"/>
		<link rel="stylesheet" href="/home/css/login.css"/>
		<script src="/home/js/scale.js"></script>
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	</head>
	<body>
		<div id="wrap">
			<div class="logo"></div>
			<div class="register">
				
				<p class="username" ><input type="text" name="" placeholder="请输入手机号" id="iphonevalue"/></p>
			  	<p style="margin-top: 2px;">
			  		<input type="text" placeholder="验证码" id="yzm"/>
			  		<input type="button" style="position: absolute;top:534px;" value="获取验证码" id="getCode" onclick="setTimes(this)" >
			  	</p>
			</div>
			<div class="next">登录</div>
		</div>
	</body>
	<script>

        var countdown=60;
            function setTimes(val) {

                if (countdown == 0) {
                    val.removeAttribute("disabled");
                    val.value = "获取验证码";
                    countdown = 60;
                    return false;
                } else {
                    if (countdown == 60) {
                        $.ajax({
                            url: 'http://111.230.228.126/api/sendcode/2/' + $('#iphonevalue').val(),
                            type: 'get',
                            success: function (suc) {

                                console.log(suc);
                                if (suc.msg == "验证码发送成功") {
                                    alert('验证码发送成功!')
                                }
                                else if (suc.msg == '手机号不存在，请注册') {
                                    alert('手机号不存在,请注册!')
                                }
                            },
                            error: function (err) {
								alert('请输入正确的手机号!');
                                countdown=0;
                                console.log(err);
                            }
                        });
                    }
                    val.setAttribute("disabled", true);
                    val.value = "重新发送(" + countdown + ")";
                    countdown--;
                }
                setTimeout(function () {

                    setTimes(val);
                }, 1000);
        }
		$('.next').on('click',function () {

		    $.ajax({
				url:'http://111.230.228.126/api/login',
				type:'post',
				data:{
                    phone:$('#iphonevalue').val(),
                    code:$('#yzm').val()

				},
				success:function (data) {
				    if(data.status == false)
					{
						alert('手机号码或验证码未填写!')
					}
					console.log(data);
                },
				error:function (err) {
					console.log(err)
                }
			})
        })


	</script>
</html>
