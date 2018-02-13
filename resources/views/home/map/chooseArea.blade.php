<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>筛选</title>
		<link rel="stylesheet" href="/home/css/public.css" />
		<link rel="stylesheet" href="/home/css/filter.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
		<script src="/home/js/scale.js"></script>
		<script src="/home/js/vue.js"></script>
	</head>
	<body>
	<div  id="app">
		<div class="filterHeader">
			<div>筛选</div>
			<div class='inHL' onclick="history.go(-1)"></div>
		</div>
		<div class="filWrap z-clearfix">
			<ul class="filList z-fl">
				<li class="space addStyle">省份</li>
				<li>选择城市</li>
				<li>行政区域</li>
				<li class="space">商圈</li>
				<li>酒店品牌 </li>
				<li>价格区间</li>
			</ul>
			<div class="filCon z-fl">
				<ul class="Province filItem" style="display:block">
					<li v-for="(item,index) in theProvince" @click='ProvinceClick(item.ProvinceId,index)' :class="{high:index==selectItemProvince}">{{item.ProvinceName}}
						<img style='position:absolute;right:23px;top:37px;' class='removeImg'src='images/select.png' v-show="index == selectItemProvince">
					</li>
				</ul>
				<ul class="city filItem" id="cityVue">
					<li v-for="(itemCity,index) in cityData" :class="{high:index==selectItemCity}" @click="cityClick(itemCity.CityCode,index)">{{itemCity.CityName}}
						<img style='position:absolute;right:23px;top:37px;' class='removeImg'src='images/select.png' v-show="index == selectItemCity">

					</li>
				</ul>
				<ul class="Administrative filItem">
					<li v-for="(itemAdmin,index) in AdministrativeData" @click="AdminClick(itemAdmin.Aid,index)" :class="{high:index==selectItemAdmin}">{{itemAdmin.Name}}
						<img style='position:absolute;right:23px;top:37px;' class='removeImg'src='images/select.png' v-show="index == selectItemAdmin">

					</li>
				</ul>
				<ul class="business filItem">
					<li v-for="(itemBusiness,index) in BusinessData" @click="businessClick(itemBusiness.businessId,index)" :class="{high:index==selectItemBusiness}">{{itemBusiness.businessName}}
						<img style='position:absolute;right:23px;top:37px;' class='removeImg'src='images/select.png' v-show="index == selectItemBusiness">

					</li>
				</ul>

				<ul class="hotel filItem5 filItem"style="display:none" >
					<li v-for="(itemHotel,index) in hotelData" @click="hotelClick(itemHotel.BrandId,index)" :class="{high:index==selectItemHotel}">{{itemHotel.Name}}
						<img style='position:absolute;right:23px;top:37px;' class='removeImg'src='images/select.png' v-show="index == selectItemHotel">
					</li>
				</ul>

				<ul class="price filItem6 filItem z-clearfix">
					<li></li>
				</ul>
			</div>
		</div>
		<div class="ensure z-clearfix">
			<div class="reset z-fl" @click="Reset">重置</div>
			<div class="conf z-fl">确定</div>
		</div>
	</div>
		<script>
			new Vue({
				el:'#app',
				data:{
				    theProvince:[],
					cityData:[],
                    AdministrativeData:[],
                    BusinessData:[],
                    hotelData:[],
					selectItemProvince:-1,
					selectItemCity:-1,
					selectItemAdmin:-1,
					selectItemBusiness:-1,
					selectItemHotel:-1,

				},
                methods:{
                    ProvinceClick:function (a,index) {
//                        $(this).append("<img style='position:absolute;right:23px;top:37px;' class='removeImg'src='images/select.png'>");
						this.selectItemProvince=index;
                        this.selectItemCity=-1;
						this.selectItemAdmin=-1;
                        this.selectItemBusiness=-1;

                        var that=this;
                        //获取城市 a为省份编码
                        $.ajax({
                            url: 'http://111.230.228.126/api/getCity/'+a,
                            success: function (cityData) {
                                that.cityData=cityData.data;
                                console.log(that.cityData);
                            },
							error:function (err) {
							console.log(err)
                            }
                        });
                    },
                    cityClick:function (a,index) {
                        var that=this;
                        that.selectItemCity=index;
                        that.selectItemAdmin=-1;
                        //获取行政区 a为城市编码
                        $.ajax({
							url:'http://111.230.228.126/api/getDistricts/'+a,
							success:function (AdminData) {
							    that.AdministrativeData=AdminData.data;
							    console.log('行政区',that.AdministrativeData);
                            },
							error:function (err) {
								console.log('失败')
                            }
						});
                        //获取商圈
						that.selectItemBusiness=-1;
                        that.selectItemHotel=-1;

                        $.ajax({
                            url:'http://111.230.228.126/api/getCommerical/'+a,
                            success:function (businessData) {
                                console.log('商圈',businessData.data);
                                that.BusinessData=businessData.data;
                            },
                            error:function (err) {
                                console.log('请求失败')
                            }
                        });

                    },
					//行政点击
                    AdminClick:function (a,index) {
                        var that=this;
                        that.selectItemAdmin=index;
                        that.selectItemBusiness=-1;
                        that.selectItemHotel=-1;

                    },
                    //商圈
                    businessClick:function (a,index) {
                        var that=this;
                        that.selectItemHotel=-1;
                        that.selectItemBusiness=index;
                    },
                    //酒店
                    hotelClick:function (a,index) {
                        var that=this;
                        that.selectItemHotel=index;

                    },
                    //重置
                    Reset:function () {
						    this.selectItemProvince=-1;
                            this.selectItemCity=-1;
                            this.selectItemAdmin=-1;
                            this.selectItemBusiness=-1;
                            this.selectItemHotel=-1;
							$('.filCon .filItem').hide();
							$('.filCon .filItem').eq(0).show();
						    $('.filList li').eq(0).addClass('addStyle').siblings().removeClass('addStyle');

                    }
				},created:function(){
					var that=this;
					//页面加载获取省份
                    $.ajax({
                        url:'http://111.230.228.126/api/getProvince',
                        success:function (suc) {

                            that.theProvince = suc.data;
                            console.log(suc.data)
                        },
						error:function (err) {
                            console.log(err.data)
							alert('获取数据出错啦')
                        }
                    });
                    //获取酒店品牌
                    $.ajax({
                        url:'http://111.230.228.126/api/getAllBrands',
                        success:function (suc) {
                            that.hotelData = suc.data;
                            console.log(suc.data)

                        }
                    });

                }

			});

			$('.filList li').click(function(){
				var i = $(this).index();
				$('.filCon .filItem').hide();
				$('.filCon .filItem').eq(i).show();
				$(this).siblings().removeClass('addStyle');
				$(this).addClass('addStyle');
			})




		</script>
	</body>
</html>
