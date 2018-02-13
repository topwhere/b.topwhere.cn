@extends('admin.layout')
@section('main')
 <style>
        .layui-form{margin-top: 20px}
        .layui-form-label{width: 166px;}
        .layui-upload-img{width: 100px;max-height: 100px;margin-right: 10px;margin-top: 10px}
        .on{position:relative;}
        .on:before{display:block;content:"";width:20px;height:20px;background:url(/static/img/delete.jpeg) no-repeat center center;background-size:100% 100%;position:absolute;right:10px;top:10px;}
    </style>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">房型名称:</label>
            <div class="layui-input-inline">
                <input type="text" name="Name" lay-verify="name" value="{{ $data->Name or '' }}" autocomplete="off" placeholder="请输入房型名称" class="layui-input">
            </div>
        </div>
        @if($hotelid == 0)
        <div class="layui-form-item">
            <label class="layui-form-label">所属酒店:</label>
            <div class="layui-input-inline">
                <select name="Hotel" class="layui-select " lay-verify="hotel">
                    @if(isset($hotelist))
                    	@foreach($hotelist as $item)
                    		<option value="{{ $item->HotelId }}">{{ $item->HotelName }}</option>
                    	@endforeach	
                	@endif
                </select>
            </div>
        </div>
        @endif
        <div class="layui-form-item">
            <label class="layui-form-label">门市价格:</label>
            <div class="layui-input-inline">
                <input type="text" name="TotalRate" lay-verify="price" value="{{ $data->TotalRate or '' }}" autocomplete="off" placeholder="请输入门市价格:100.00" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">会员价价格:</label>
            <div class="layui-input-inline">
                <input type="text" name="MerPrice" lay-verify="memberprice" value="{{ $data->MerPrice or '' }}" autocomplete="off" placeholder="请输入会员价:100.00" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">预订周期:</label>
            <div class="layui-input-inline">
                <input type="text" name="Week" lay-verify="period" value="{{ $data->Week or '' }}" autocomplete="off" placeholder="请输入预订周期(天):5，填0为无限制" class="layui-input">
                <span style="color: red">备注：填0为无限制</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">面积:</label>
            <div class="layui-input-inline">
                <input type="text" name="Area" lay-verify="area" value="{{ $data->Area or '' }}" autocomplete="off" placeholder="请输入面积(平):20" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">床型:</label>
            <div class="layui-input-inline">
            	<select name="BedType" class="layui-select ">
                    @if(isset($bedType))
                    		<option value="-1">请选择</option>
                    	@foreach($bedType as $item)
                    		<option value="{{ $item->id }}-{{$item->name}}" @if(isset($data->BedTypeId)&& $data->BedTypeId== $item->id) selected @endif>{{ $item->name }}</option>
                    	@endforeach	
                	@endif
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">床宽:</label>
            <div class="layui-input-inline">
                <input type="text" name="BedWidth" lay-verify="bedwidth" value="{{ $data->BedWidth or '' }}" autocomplete="off" placeholder="请输入床宽(米):1.5" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">窗户:</label>
            <div class="layui-input-inline">
                <input type="radio" name="IsWindow" value="1" title="有"     @if(isset($data->IsWindow)&& $data->IsWindow==1) checked="" @endif>
                <input type="radio" name="IsWindow" value="0" title="没有"   @if(isset($data->IsWindow)&& $data->IsWindow==0) checked="" @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">早餐:</label>
            <div class="layui-input-inline">
                <input type="radio" name="RatePlanName" value="含早"   title="含早"     @if(isset($data->IsBreakFast)&& $data->IsBreakFast==1) checked="" @endif>
                <input type="radio" name="RatePlanName" value="不含早" title="不含早"   @if(isset($data->IsBreakFast)&& $data->IsBreakFast==0) checked="" @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">楼层:</label>
            <div class="layui-input-inline">
                <input type="text" name="Floor" lay-verify="floors" value="{{ $data->Floor or ''}}" autocomplete="off" placeholder="请输入楼层" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">入住人数:</label>
            <div class="layui-input-inline">
                <input type="text" name="Capcity" lay-verify="num" value="{{ $data->Capcity or ''}}" autocomplete="off" placeholder="请输入可入住人数" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上网方式:</label>
            <div class="layui-input-inline">
                <select name="Broadnet" class="layui-select Broadnet">
                    <option value="0" @if(isset($data->Broadnet)&& $data->Broadnet=='0') selected @endif>无</option>
                    <option value="1" @if(isset($data->Broadnet)&& $data->Broadnet=='1') selected @endif>免费宽带</option>
                    <option value="2" @if(isset($data->Broadnet)&& $data->Broadnet=='2') selected @endif>收费宽带</option>
                    <option value="3" @if(isset($data->Broadnet)&& $data->Broadnet=='3') selected @endif>免费wifi</option>
                    <option value="4" @if(isset($data->Broadnet)&& $data->Broadnet=='4') selected @endif>收费wifi</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">无烟房:</label>
            <div class="layui-input-inline">
                <input type="radio" name="Smoking" value="1" title="是" @if(isset($data->Smoking)&& $data->Smoking==1) checked="" @endif>
                <input type="radio" name="Smoking" value="0" title="否" @if(isset($data->Smoking)&& $data->Smoking==0) checked="" @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">备注:</label>
            <div class="layui-input-inline">
                <input type="text" name="Comments" lay-verify="remark" value="{{ $data->Comments or '' }}" autocomplete="off" placeholder="请输入备注" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="images">选择图片</button>
                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                        预览：
                        <div class="layui-upload-list" id="uploadimglist">
                            @if(isset($data->ImageUrl))
                                @foreach(explode(',',$data->ImageUrl) as $v)
                                    <div class="upload-img" style='display: inline-block'>
                                        <img src='{{$v}}' class='layui-upload-img'>
                                        <input type='hidden' value='{{$v}}' class='hidenimg'>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </blockquote>
                </div>
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
            layui.use(['form','table','upload'], function(){
                var form = layui.form,upload = layui.upload;
                form.verify({
                    logo:function (value) {if (value.length<10){return '请上传公司logo';}},
                    name: function(value){if(value.length < 3){return '房型名称至少得3个字符';}}

                });
                //监听提交
                form.on('submit(demo1)', function(data){
                    var img='';
                    $('.hidenimg').each(function (data) {
                        img += $(this).val()+','
                    });
                    data.field.img=img
                    console.log(data.field);
                    $.ajax({
                        url:'{{url()->current()}}',
                        data:{_token:'{{csrf_token()}}',data:data.field},
                        type:'PUT',
                        success:function (data) {
                            window.location.href = "{{ url('admin/rooms/0') }}";
                        }
                    })
                    return false;
                });
                form.render();
                //多图片上传
                upload.render({
                    elem: '#images'
                    ,url: '{{route('api.imgsave')}}'
                    ,multiple: true
                    ,accept:'images'
                    ,size: 1000
                    ,before: function(obj){
                        //预读本地文件示例，不支持ie8
                        obj.preview(function(index, file, result){
//                            $('#uploadimglist').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img">')
                        });
                    }
                    ,done: function(res){
                        //上传完毕
                        var data="<div class='upload-img' style='display: inline-block'> "+
                            "<img src="+res.data.src+" class='layui-upload-img'>"+
                            "<input type='hidden' value='"+res.data.src+"' class='hidenimg'>" +
                            "<\/div>";
                        $('#uploadimglist').append(data);
                    }
                });
            });
            $('#uploadimglist').on('click','.on',function () {$(this).remove()});
            $('#uploadimglist').on('mouseover','.upload-img',function () {$(this).addClass("on");}).on("mouseout",'.upload-img',function(){$(this).removeClass("on");})
    </script>
    @stop