<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<title>注册2</title>
		<link rel="stylesheet" href="/home/css/public.css"/>
		<link rel="stylesheet" href="/home/css/registerFi.css"/>
		<script src="/home/js/scale.js"></script>
		<script src="/home/js/jquery-1.8.3.js"></script>
	</head>
	<body>
		<div id="wrap">
			<div class="logo"></div>
			<div class="register">
				
				<p class="username" ><input type="text" name="" placeholder="请输入姓名"/></p>
			  	<p class="userphoto" ><input type="number" name="" class="phone" placeholder="请输入手机号" id="thePhone"/></p>
			  	<p >
			  		<input type="text" placeholder="验证码" class="yzm"/>
			  		<input type="button" id="getCode"  onclick="setTimes(this)" value="获取验证码">
			  	</p>
			</div>
			<div class="next">下一步</div>
		</div>
	</body>
	<script src="/home/js/jquery.jsonp.js"></script>

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
                $.ajax(
                    {
                        type: 'get',
                        url: 'http://111.230.228.126/api/sendcode/1/' + $('.phone').val(),
                        success: function (data) {
                            console.log(data);
                            alert(data.msg)
                        },
                        error: function (err) {
                            alert('请填写正确的手机号或姓名!');
                            console.log(err)
                        }
                    }
                );

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
			url:'http://111.230.228.126/api/validcode',
			type:'post',
			data:{type:1,phone:$('#thePhone').val(),code:$('.yzm').val()},
			success:function (data) {
				console.log(data);
				alert(data.msg);

            },
			error:function (err) {
			    alert('获取数据失败')
				console.log(err);
            }

		})

    })
</script>
</html>
