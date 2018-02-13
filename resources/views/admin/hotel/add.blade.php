@extends('admin.layout')
@section('main')
    <?php $name = '酒店'?>
 <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">酒店logo:</label>
            <div class="layui-input-inline">
                <div class="layui-upload">                    
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="demo1" @if(isset($info->ThumbNailUrl)) src="{{ $info->ThumbNailUrl }}" @endif style="width: 300px ">
                        <input type="hidden" name="ThumbNailUrl" lay-verify="ThumbNailUrl" id="oneimg" value=" @if(isset($info->ThumbNailUrl)){{$info->ThumbNailUrl}}@endif ">
                        <p id="demoText"></p>
                    </div>
                    <button type="button" class="layui-btn" id="test1">上传图片</button>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">酒店名称:</label>
            <div class="layui-input-inline">
                <input type="text" name="HotelName" lay-verify="HotelName" value="{{ $info->HotelName or ''}}" autocomplete="off" placeholder="请输入酒店名" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">营业状态:</label>
            <div class="layui-input-inline">
                <select name="IsSale" lay-fiter="status">
                    <option value="0" @if(isset($info->IsSale)&&$info->IsSale==0) selected @endif>营业中</option>
                    <option value="1" @if(isset($info->IsSale)&&$info->IsSale==1) selected @endif>下架</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">联系电话:</label>
            <div class="layui-input-inline">
                <input type="text" name="Tel" lay-verify="Tel" value="{{$info->Tel or '010-52895700'}}" autocomplete="off" placeholder="请输入联系电话" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">价格:</label>
            <div class="layui-input-inline">
                <input type="text" name="LowRate" lay-verify="LowRate" value="{{$info->LowRate or ''}}" autocomplete="off" placeholder="请输入价格" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">设施服务:</label>
            <div class="layui-input-block">
            	@if(!empty($facilities)) 
	                @foreach($facilities as $v)
	                	<input type="checkbox" name="Facilities" vid="{{$v->id}}" @if(isset($info->Facilities)&&(in_array($v->id,explode(',',$info->Facilities))||$v->id==$info->Facilities)) checked="" @endif  lay-skin="primary" title="{{$v->name}}">
	                @endforeach
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">星级:</label>
            <div class="layui-input-block">
                <input type="radio" name="StarRate" value="0" title="无"     @if(isset($info->StarRate) && $info->StarRate == 0) checked @endif >
                <input type="radio" name="StarRate" value="1" title="快捷"   @if(isset($info->StarRate) && $info->StarRate == 1) checked @endif >
                <input type="radio" name="StarRate" value="2" title="商务"   @if(isset($info->StarRate) && $info->StarRate == 2) checked @endif>
                <input type="radio" name="StarRate" value="3" title="三星级" @if(isset($info->StarRate) && $info->StarRate == 3) checked @endif >
                <input type="radio" name="StarRate" value="4" title="四星级" @if(isset($info->StarRate) && $info->StarRate == 4) checked @endif >
                <input type="radio" name="StarRate" value="5" title="五星级" @if(isset($info->StarRate) && $info->StarRate == 5) checked @endif >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">支付方式:</label>
            <div class="layui-input-block">
                <input type="radio" name="pay" value="微信" title="微信" checked>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">酒店品牌:</label>
            <div class="layui-input-inline" >
                <select name="BrandId" lay-fiter="status" id="BrandId">
                        <option>请选择</option>
                        @if(isset($brands))
                            @foreach($brands as $item)
                            <option value="{{ $item->BrandId }}" @if(isset($info->BrandId)&&$item->BrandId == $info->BrandId) selected="selected" @endif  >{{ $item->ShortName }}</option>
                            @endforeach
                        @endif 
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所属城市:</label>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <select name="province"  lay-filter="province" lay-verify="province">
                        <option value="0">请选择省份</option>
                        @if(isset($province))
	                        @foreach ($province as $item)
	                            <option value="{{ $item->ProvinceId }}" @if(isset($ProvinceId->ProvinceId)&&$item->ProvinceId == $ProvinceId->ProvinceId) selected="selected" @endif  >{{ $item->ProvinceName }}</option>
	                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <select name="city"  lay-filter="city" lay-verify="city" id="city">
                        <option value="0">请选择城市</option>
                        @if(!empty($cityCode)) {
                        	@foreach($cityCode as $item)
                        		<option value="{{ $item->CityCode }}" @if($item->CityCode == $info->CityCode) selected="selected" @endif  >{{ $item->CityName }}</option>
                        	@endforeach
                    	}
                    	@endif
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">行政区域:</label>
            <div class="layui-input-inline" >
                <select name="District" lay-fiter="status" id="district">
                    @if(isset($district))
                        @foreach($district as $v)
                        <option value="{{ $v->Aid }}" @if($v->Aid == $info->District) selected="selected" @endif  >{{ $v->Name }}</option>
                        @endforeach
                    @endif 
                </select>
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">所属商圈:</label>
            <div class="layui-input-block" id="business">
                @if(isset($busines))
	                @foreach($busines as $v)
	                	<input type="checkbox" name="BusinessId" vid="{{$v->businessId}}"  title="{{$v->businessName}}" @if(isset($info->BusinessId)&&(in_array($v->businessId,explode(',',$info->BusinessId))||$v->businessId==$info->BusinessId)) checked="" @endif  lay-skin="primary">
	                @endforeach
                @endif 
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">地址:</label>
            <div class="layui-input-inline" style="width: 50%">
                <input id="where" name="Address" lay-verify="Address" value="{{ $info->Address or ''}}" type="text" placeholder="请输入地址" class="layui-input">
            </div>
            <div class="layui-input-inline">
                <input id="but" type="button" value="地图查找" onClick="sear(document.getElementById('where').value);" class="layui-btn layui-btn-normal">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">经度：</label>
                <div class="layui-input-inline">
                <input id="lonlat" name="Longitude" lay-verify="Longitude" value="{{ $info->Longitude or '' }}" type="number" maxlength="10" class="layui-input" readonly></div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">纬度：</label>
                <div class="layui-input-inline">
                    <input id="lonlat2" name="Latitude" lay-verify="Latitude" value="{{ $info->Latitude or '' }}" type="number" maxlength="9" class="layui-input" readonly>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
                <div id="allmap" style="height:500px;width:700px;"></div>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">简介:</label>
            <div class="layui-input-block">
                <textarea name="Features" lay-verify="Features"  placeholder="请输入内容" class="layui-textarea">{{$info->Features or ''}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                {{--<button type="reset" class="layui-btn layui-btn-primary">重置</button>--}}
            </div>
        </div>
    </form>
        <script>
        layui.use(['form', 'table','upload'], function(){
            var form = layui.form,table = layui.table,upload = layui.upload;
            form.verify({
//                img:function (value) {if (value.length<10){return '请上传酒店logo';}},
                HotelName: function(value){if(value.length < 4){return '酒店名称至少得4个字符';}}
                ,Tel: function(value){if(value.length < 8){return '电话至少得8个字符';}}
                ,LowRate: function(value){if(value.length < 1){return '价格至少得1个字符';}}
//                ,city: function(value){if(value == 0){return '请选择城市';}}
//                ,address: function(value){if(value.length < 5){return '请输入地址,最少5个字';}}
//                ,lon: function(value){if(value.length < 1){return '缺少经度,请输入地址后定位';}}
//                ,lat: function(value){if(value.length < 1){return '缺少纬度,请输入地址后定位';}}
//                ,profile: function(value){if(value.length < 5){return '请输入简介,最少5个字符';}}
            });
            //监听提交
            form.on('submit(demo1)', function(data){
                var id='{{$info->id or 'create'}}';
//                var service ='';
//                $('input[name="service"]:checked').each(function(){
//                    service +=','+$(this).attr('vid')
//                });
//                if (service.length<1){layer.msg('请选择设施服务');return false;}
//                data.field.service=service;
//
//                var business =[];
//                $('input[name="business"]:checked').each(function(){
//                    business +=','+$(this).attr('vid')
//                });
//                if (business.length<1){layer.msg('请选择商圈');return false;}
//                data.field.business=business;
//
//                var subway =[];
//                $('input[name="subway"]:checked').each(function(){
//                    subway +=','+$(this).attr('vid')
//                });
//                if (subway.length<1){layer.msg('请选择地铁');return false;}
//                data.field.subway=subway;
				var Facilities = '';
				var FacilitiesName = '';
				$('input[name="Facilities"]:checked').each(function(){
	               	Facilities +=','+$(this).attr('vid');
	                FacilitiesName +=','+$(this).attr('title');
	            });
				data.field.Facilities = Facilities;
				data.field.FacilitiesName = FacilitiesName;

				var BusinessId = '';
				$('input[name="BusinessId"]:checked').each(function(){
	                BusinessId +=','+$(this).attr('vid');
	            });
				data.field.BusinessId = BusinessId;

                $.ajax({
                    url:'{{url()->current()}}',
                    data:{_token:'{{csrf_token()}}',data:data.field},
                    type:'PUT',
                    success:function (data) {
//                            window.history.back();
                        if (data.status==1){
                            window.location.href="{{url('admin/hotel')}}"
//                            layer.closeAll();
//                            layer.msg('提交成功');
                        }
                    }
                });
                return false;
            });
            form.render();
            form.on('select(province)',function (data) {
                $.post("{{ url('admin/getCityCode') }}",{ProvinceId:data.value,_token:'{{csrf_token()}}'},function(e) {	
                    var city='<option value="0">请选择城市</option>';
                    for (var i=0;i<e.length;i++){
                    	var opt = e[i];
                        city +='<option value="'+opt.CityCode+'">'+opt.CityName+'</option>';
                    }
                    $('#city').html(city);
                    form.render('select');
                    $('#business').html('');
                    $('#subway').html('');
                    form.render('checkbox');
                })
            });
            form.on('select(city)', function(data){
                $.post("{{ url('admin/getBusiness') }}",{CityCode:data.value,_token:'{{csrf_token()}}'},function(e) {	
                    var busines='',subway='';
                    for (var i=0;i<e.length;i++){
                    	var opt = e[i];
                        busines +='<input type="checkbox" name="BusinessId" vid="'+opt.businessId+'"  lay-skin="primary" title="'+opt.businessName+'">';
                    }
                    $('#business').html(busines);
                    form.render('checkbox');
                	sear($('#city').find("option:selected").text())
                });
                $.post("{{ url('admin/getDistrict') }}",{CityCode:data.value,_token:'{{csrf_token()}}'},function(e) {   
                    var district='';
                    for (var i=0;i<e.length;i++){
                        var opt = e[i];
                        district +='<option value="'+opt.Aid+'">'+opt.Name+'</option>';
                    }
                    $('#district').html(district);
                    form.render('select');
                    //sear($('#city').find("option:selected").text())
                });


            });
            //单图片上传
            var uploadInst = upload.render({
                elem: '#test1'
                ,url: '{{route('api.imgsave')}}'
                ,done: function(res){
                    //如果上传失败
                    if(res.code > 0){
                        return layer.msg('上传失败');
                    }
                    //上传成功
                    $('#demo1').attr('src',res.data.src);
                    $('#oneimg').val(res.data.src);
                }
                ,error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });
        });
</script>
	<script type="text/javascript" defer="false">
	        //如果经纬度没有给个默认值
	        @if(isset($info->Longitude))
	        var longitude ={{$info->Longitude}};
	        var latitude ={{$info->Latitude}};
	        @else
	        var longitude = 116.418659;
	        var latitude = 40.063048;
	        @endif
	        var map;
	        map=new BMap.Map("allmap");
	        map.setDefaultCursor("crosshair");
	        map.enableScrollWheelZoom();
	        var point = new BMap.Point(longitude, latitude);
	        map.centerAndZoom(point, 19);
	        var gc = new BMap.Geocoder();
	        map.addControl(new BMap.NavigationControl());
	//        map.addControl(new BMap.OverviewMapControl());//右下角小地图
	//        map.addControl(new BMap.ScaleControl());//标尺
	//        map.addControl(new BMap.MapTypeControl());//右上角工具
	        mapmaker(point);
	        var marker;

	        function mapmaker(point) {
	            map.clearOverlays();
	            marker = new BMap.Marker(point);
	            map.addOverlay(marker);
	//            marker.addEventListener("click", function(e) {
	//                document.getElementById("lonlat").value = e.point.lng;
	//                document.getElementById("lonlat2").value = e.point.lat;
	//            });
	            marker.enableDragging();
	            marker.addEventListener("dragend", function (e) {
	                document.getElementById("lonlat").value = e.point.lng;
	                document.getElementById("lonlat2").value = e.point.lat;
	                gc.getLocation(e.point, function (rs) {
	//                        showLocationInfo(e.point, rs);
	                });
	            });
	        }

	        function showLocationInfo(pt, rs) {
	            var opts = {
	                width: 250,
	                height: 150,
	                title: "当前位置"
	            };
	            var addComp = rs.addressComponents;
	            var addr = "当前位置：" + addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber + "<br/>";
	            addr += "纬度: " + pt.lat + ", " + "经度：" + pt.lng;
	            var infoWindow = new BMap.InfoWindow(addr, opts);
	            marker.openInfoWindow(infoWindow);
	        }

	        //单击获取点击的经纬度
	        map.addEventListener("click", function (e) {
	            document.getElementById("lonlat").value = e.point.lng;
	            document.getElementById("lonlat2").value = e.point.lat;
	//
	            mapmaker(e.point)
	//            var marker = new BMap.Marker();// 创建标注
	//            map.addOverlay(marker);
	        });
	        var traffic = new BMap.TrafficLayer();
	        map.addTileLayer(traffic);
	        function iploac(result) {
	            var cityName = result.name;
	        }

	        var myCity = new BMap.LocalCity();
	        myCity.get(iploac);
	        function sear(result) {
	            var local = new BMap.LocalSearch(map, {
	                renderOptions: {
	                    map: map
	                }
	            });
	            local.search(result);
	        }
	</script>
@stop