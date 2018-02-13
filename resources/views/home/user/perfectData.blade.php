<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>完善资料 </title>
		<link rel="stylesheet" href="/home/css/public.css" />
		<link rel="stylesheet" href="/home/css/perfectDatum.css" />
	    <link rel="stylesheet" href="/home/css/iosSelect.css">
		<script src="/home/js/scale.js"></script>
	</head>
	<body style="background:#efeff4">
		<div class="perfectDatum">
			<div>完善资料</div>
			<div class="back" onclick="history.go(-1)"></div>
		</div>
		<div class="personDetails">
			<div class="username">
				<label >姓名</label>
  				<input type="text" placeholder="请输入" class="nameName"/>
			</div>
			<div class="phone">
				<label >手机号</label>
  				<input type="number" placeholder="请输入" class="phoneName"/>
			</div>
			<div class="sex selPar" >
			    <label>性别</label>                 
			    <input type="hidden" name="sex_id" id="sexId" value=""placeholder="我的">                     
		        <span id="sex">请选择</span>  
		        <div class="sel"></div>
			</div>
			<div class="email">
				<label >邮箱</label>
  				<input type="email" placeholder="请输入" class="emailName"/>
			</div>
			<div class="company">
				<label >公司</label>
  				<input type="text" placeholder="请输入" class="companyName"/>
			</div>
			<div class="area selPar">
			    <label>区域</label>                 
			    <input type="hidden" name="bank_id" id="areaId" value=""placeholder="我的">                     
		        <span id="area">请选择</span>  
		         <div class="sel"></div>
			</div>
			
			<div class="department selPar">
			    <label>部门</label>                 
			    <input type="hidden" name="bank_id2" id="departmentID" value=""placeholder="我的">                     
		        <span id="department">请选择</span>  
		         <div class="sel"></div>
			</div>
			<div class="duty selPar">
			    <label>职务</label>                 
			    <input type="hidden" name="duty_id" id="dutyId" value=""placeholder="我的">                     
		        <span id="duty">请选择</span>  
		         <div class="sel"></div>
			</div>
			<div class="certificate selPar" >
			    <label>证件类型</label>                 
			    <input type="hidden" name="certificate_id" id="certificateId" value=""placeholder="我的">                     
		        <span id="certificate">请选择</span>  
		        <div class="sel"></div>
			</div>
		</div>
		<div id="submit">
			提交
		</div>
<script src="/home/js/datalists.js"></script>
<script src="/home/js/iscroll.js"></script>
<script src="/home/js/iosSelect.js"></script>
<script src="/home/js/jquery-1.8.3.js"></script>
<script type="text/javascript">
    var areaDom = document.querySelector('#area');
    var areaIdDom = document.querySelector('#areaId');
    var departmentDom = document.querySelector('#department');
    var departmentIdDom = document.querySelector('#departmentID');
    var dutymentDom = document.querySelector('#duty');
    var dutyIdDom = document.querySelector('#dutyId');
    var certificateDom = document.querySelector('#certificate');
    var certificateIdDom = document.querySelector('#certificateId');
    var sexDom = document.querySelector('#sex');
    var sexIdDom = document.querySelector('#sexId');


    var companyId = localStorage.getItem("companyId");
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
    showit(sex,sexId,sexdata,'请输入')

    var theSex=null;
    if($('#sex').html()=='男')
    {
        theSex=1;
    }else {
        theSex=2;
    }
	$('#submit').on('click',function () {

		$.ajax({
			url:'http://111.230.228.126/api/register',
			type:'post',
			data:{
                phone:$('.phoneName').val(),
				company_id:companyId,
				name:$('.nameName').val(),
				sex:theSex,
				email:$('.emailName').val(),
				company:$('.companyName').val(),
				area:$('#area').html(),
				department:$('#department').html(),
				duty:$('#duty').html(),
				ide:$('#certificate').html()
			},
			success:function (data) {
				console.log(data);
            },
			error:function (err) {
				console.log(err)
            }
		})




    })



</script>

</body>
</html>
