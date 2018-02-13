@extends('admin.layout')
@section('main')

 <style>
     .layui-form-label{width: 166px;}
        /*.layui-form-label{width: 90px;}  .layui-form{margin-top: 20px}*/
        .layui-upload-img{width: 100px;max-height: 100px;margin-right: 10px;margin-top: 10px}
        .on{position:relative;}
        .on:before{display:block;content:"";width:20px;height:20px;background:url(/static/img/delete.jpeg) no-repeat center center;background-size:100% 100%;position:absolute;right:10px;top:10px;}
</style>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">酒店logo:</label>
            <div class="layui-input-inline">
                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="test1">上传图片</button>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="demo1" @if(isset($data->img))src="/uploads/{{$data->img}}"@endif>
                        <input type="hidden" name="img" lay-verify="img" id="oneimg" value="@if(isset($data->img)){{$data->img}}@endif">
                        <p id="demoText"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">酒店名称:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="name" value="{{$data->name or ''}}" autocomplete="off" placeholder="请输入酒店名" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">营业状态:</label>
            <div class="layui-input-inline">
                <select name="status" lay-filter="status">
                    <option value="1" @if(isset($data->status)&&$data->status==1) selected @endif>营业中</option>
                    <option value="0" @if(isset($data->status)&&$data->status==0) selected @endif>下架</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">联系电话:</label>
            <div class="layui-input-inline">
                <input type="text" name="tel" lay-verify="tel" value="{{$data->tel or '010-52895700'}}" autocomplete="off" placeholder="请输入联系电话" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">价格:</label>
            <div class="layui-input-inline">
                <input type="text" name="price" lay-verify="price" value="{{$data->price or ''}}" autocomplete="off" placeholder="请输入价格" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">设施服务:</label>
            <div class="layui-input-block">
                @foreach($server as $v)
                <input type="checkbox" name="service" vid="{{$v->id}}" @if(isset($data->service)&&(in_array($v->id,explode(',',$data->service))||$v->id==$data->service)) checked="" @endif  lay-skin="primary" title="{{$v->value}}">
                @endforeach
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">星级:</label>
            <div class="layui-input-block">
                <input type="radio" name="star" value="0" title="无" checked >
                <input type="radio" name="star" value="1" title="快捷" @if(isset($data->star)&&$data->star==1) checked @endif >
                <input type="radio" name="star" value="2" title="商务" @if(isset($data->star)&&$data->star==2) checked @endif >
                <input type="radio" name="star" value="3" title="三星级" @if(isset($data->star)&&$data->star==3) checked @endif>
                <input type="radio" name="star" value="4" title="四星级" @if(isset($data->star)&&$data->star==4) checked @endif>
                <input type="radio" name="star" value="5" title="五星级" @if(isset($data->star)&&$data->star==5) checked @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">支付方式:</label>
            <div class="layui-input-block">
                <input type="radio" name="pay" value="微信" title="微信" checked>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所属城市:</label>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <select name="province"  lay-filter="province" lay-verify="province">
                        <option value="0">请选择省份</option>
                        @if(isset($province))
                        @foreach($province as $v)
                        <option value="{{$v->id}}" @if(isset($data->province)&&$data->province==$v->id) selected @endif >{{$v->value}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <select name="city"  lay-filter="city" lay-verify="city" id="city">
                        <option value="0">请选择城市</option>
                        @if(isset($city))
                            @foreach($city as $v)
                                <option value="{{$v->id}}" @if(isset($data->city)&&$data->city==$v->id) selected @endif >{{$v->value}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="layui-form-item" pane="">
            <label class="layui-form-label">所属商圈:</label>
            <div class="layui-input-block" id="business">
                @if(isset($busines))
                @foreach($busines as $v)
                <input type="checkbox" name="business" vid="{{$v->id}}"  lay-skin="primary" title="{{$v->value}}" checked="">
                @endforeach
                @endif
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">所属地铁:</label>
            <div class="layui-input-block" id="subway">
                @if(isset($subways))
                @foreach($subways as $v)
                    <input type="checkbox" name="subway" vid="{{$v->id}}"  lay-skin="primary" title="{{$v->value}}" checked="">
                @endforeach
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">地址:</label>
            <div class="layui-input-inline">
                <input id="where" name="address" lay-verify="address" value="{{$data->address or ''}}" type="text" placeholder="请输入地址" class="layui-input">
            </div>
            <div class="layui-input-inline">
                <input id="but" type="button" value="地图查找" onClick="sear(document.getElementById('where').value);" class="layui-btn layui-btn-normal">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">经度：</label>
                <div class="layui-input-inline">
                <input id="lonlat" name="lon" lay-verify="lon" value="{{$data->lon or ''}}" type="number" maxlength="10" class="layui-input" readonly></div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">纬度：</label>
                <div class="layui-input-inline">
                    <input id="lonlat2" name="lat" lay-verify="lat" value="{{$data->lat or ''}}" type="number" maxlength="9" class="layui-input" readonly>
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
                <textarea name="profile" lay-verify="profile"  placeholder="请输入内容" class="layui-textarea">{{$data->profile or ''}}</textarea>
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
                name: function(value){if(value.length < 4){return '酒店名称至少得4个字符';}}
                ,tel: function(value){if(value.length < 8){return '电话至少得8个字符';}}
                ,price: function(value){if(value.length < 1){return '价格至少得1个字符';}}
//                ,city: function(value){if(value == 0){return '请选择城市';}}
//                ,address: function(value){if(value.length < 5){return '请输入地址,最少5个字';}}
//                ,lon: function(value){if(value.length < 1){return '缺少经度,请输入地址后定位';}}
//                ,lat: function(value){if(value.length < 1){return '缺少纬度,请输入地址后定位';}}
//                ,profile: function(value){if(value.length < 5){return '请输入简介,最少5个字符';}}
            });
            //监听提交
            form.on('submit(demo1)', function(data){
                var id='{{$data->id or 'create'}}';
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
                $.ajax({
                    url:'{{url()->current()}}',
                    data:{_token:'{{csrf_token()}}',data:data.field},
                    type:'PUT',
                    success:function (data) {
//                            window.history.back();
                        if (data.status==1){
                            window.location.href='/admin/hotel'
//                            layer.closeAll();
//                            layer.msg('提交成功');
                        }
                    }
                });
                return false;
            });
            form.render();
            form.on('select(province)',function (data) {
                $.get('/admin/hotel/create?province_id='+data.value,function (e) {
                    var city='<option value="0">请选择城市</option>';
                    for (var i=0;i<e.city.length;i++){
                        city +='<option value="'+e.city[i].id+'">'+e.city[i].value+'</option>';
                    }
                    $('#city').html(city);
                    form.render('select');
                    $('#business').html('');
                    $('#subway').html('');
                    form.render('checkbox');
                })
            });
            form.on('select(city)', function(data){
                $.get('/admin/hotel/create?city_id='+data.value,function (e) {
                    var busines='',subway='';
                    for (var i=0;i<e.busines.length;i++){
                        busines +='<input type="checkbox" name="business" vid="'+e.busines[i].id+'"  lay-skin="primary" title="'+e.busines[i].value+'">'
//                        busines +='<option value="'+e.busines[i].id+'">'+e.busines[i].value+'</option>';
                    }
                    $('#business').html(busines);
                    for (var i=0;i<e.subways.length;i++){
                        subway +='<input type="checkbox" name="subway" vid="'+e.subways[i].id+'"  lay-skin="primary" title="'+e.subways[i].value+'">'
//                        subway +='<option value="'+e.subways[i].id+'">'+e.subways[i].value+'</option>';
                    }
                    $('#subway').html(subway);
                    form.render('checkbox');
                    sear($('#city').find("option:selected").text())
                })
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
                    $('#demo1').attr('src','/uploads/'+res.data.src);
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
        @if(isset($data->lon))
        var longitude ={{$data->lon}};
        var latitude ={{$data->lat}};
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