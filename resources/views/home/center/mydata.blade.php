<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>我的资料 </title>
		<link rel="stylesheet" href="/home/css/public.css" />
		<link rel="stylesheet" href="/home/css/mydatum.css" />
	    <link rel="stylesheet" href="/home/css/iosSelect.css">
		<script src="/home/js/scale.js"></script>
		<script src="/home/js/jquery-1.8.3.js"></script>
	</head>
	<body style="background:#efeff4">
		<div class="mydatum">
			<div>我的资料</div>
			<div class="back" onclick="history.go(-1)"></div>
		</div>
		<div class="personDetails">
			<div class="username">
				<label >姓名</label>
  				<input type="text" placeholder="张三"/>
			</div>
			<div class="phone">
				<label >手机号</label>
  				<input type="number" placeholder="152121210511" class="phoneNum"/>
			</div>
			<div class="email">
				<label >邮箱</label>
  				<input type="text" placeholder="286727122@qq.com" class="emailNum"/>
			</div>
			<div class="company">
				<label >公司</label>
  				<input type="text" placeholder="北京中微信通"/>
			</div>
			<div class="area selPar">
			    <label>区域</label>                 
			    <input type="hidden" name="bank_id" id="areaId" value=""placeholder="我的">                     
		        <span id="area">东南部</span>  
		         <div class="sel"></div>
			</div>
			
			<div class="department selPar">
			    <label>部门</label>                 
			    <input type="hidden" name="bank_id2" id="departmentID" value=""placeholder="我的">                     
		        <span id="department">技术部</span>  
		         <div class="sel"></div>
			</div>
			<div class="duty selPar">
			    <label>职务</label>                 
			    <input type="hidden" name="duty_id" id="dutyId" value=""placeholder="我的">                     
		        <span id="duty">web前端</span>  
		         <div class="sel"></div>
			</div>
			<div class="certificate selPar" >
			    <label>证件类型</label>                 
			    <input type="hidden" name="certificate_id" id="certificateId" value=""placeholder="我的">                     
		        <span id="certificate">身份证</span>  
		        <div class="sel"></div>
			</div>
		</div>
		<div id="save">
			保存
		</div>

	<script src="/home/js/datalists.js"></script>
<script src="/home/js/iscroll.js"></script>
<script src="/home/js/iosSelect.js"></script>
<script type="text/javascript">
    var areaDom = document.querySelector('#area');
    var areaIdDom = document.querySelector('#areaId');
    var departmentDom = document.querySelector('#department');
    var departmentIdDom = document.querySelector('#departmentID');
    var dutymentDom = document.querySelector('#duty');
    var dutyIdDom = document.querySelector('#dutyId');
    var certificateDom = document.querySelector('#certificate');
    var certificateIdDom = document.querySelector('#certificateId');
    
    
    function showit(obj1,obj2,dataList,datatitle){
    	obj1.addEventListener('click', function () {
        var bankId = obj1.dataset['id'];
        var bankName = obj1.dataset['value'];

        var bankSelect = new IosSelect(1, 
            [dataList],
            {
                container: '.container',
                title: datatitle,
                itemHeight: 100,
                itemShowCount: 3,
                oneLevelId: bankId,
                callback: function (selectOneObj) {
                    obj2.value = selectOneObj.id;
                    obj1.innerHTML = selectOneObj.value;
                    obj1.dataset['id'] = selectOneObj.id;
                    obj1.dataset['value'] = selectOneObj.value;
                }
       	 });
	   });
    }
    showit(areaDom,areaIdDom,areadata,'区域选择')
    showit(departmentDom,departmentIdDom,departmentdata,'部门选择')
    showit(duty,dutyIdDom,dutydata,'职务选择')
    showit(certificate,certificateId,certificatedata,'证件选择')

	$.ajax({
		url:'http://111.230.228.126/api/center',
		type:'get',
		success:function (data) {

		    console.log(data)
        },
		error:function (err) {

        }
	})
    $('#save').on('touchend',function () {
		$.ajax({
			url:'http://111.230.228.126/api/archives',
			type:'post',
			data:{phone:$('.phoneNum').val(),email:$('.emailNum').val()},
			success:function (sucData) {
			    alert('成功')
				console.log(sucData.da)
            },
			error:function (err) {
				console.log(err)
            }
		})

    })




</script>

</body>
</html>
