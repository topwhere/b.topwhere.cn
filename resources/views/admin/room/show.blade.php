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
                <input type="text" name="name" lay-verify="name" value="{{$data->name or ''}}" autocomplete="off" placeholder="请输入房型名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">门市价格:</label>
            <div class="layui-input-inline">
                <input type="text" name="price" lay-verify="price" value="{{$data->price or ''}}" autocomplete="off" placeholder="请输入门市价格:100.00" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">会员价价格:</label>
            <div class="layui-input-inline">
                <input type="text" name="memberprice" lay-verify="memberprice" value="{{$data->memberprice or ''}}" autocomplete="off" placeholder="请输入会员价:100.00" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">预订周期:</label>
            <div class="layui-input-inline">
                <input type="text" name="period" lay-verify="period" value="{{$data->period or ''}}" autocomplete="off" placeholder="请输入预订周期(天):5" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">面积:</label>
            <div class="layui-input-inline">
                <input type="text" name="area" lay-verify="area" value="{{$data->area or ''}}" autocomplete="off" placeholder="请输入面积(平):20" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">床宽:</label>
            <div class="layui-input-inline">
                <input type="text" name="bedwidth" lay-verify="bedwidth" value="{{$data->bedwidth or ''}}" autocomplete="off" placeholder="请输入床宽(米):1.5" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">窗户:</label>
            <div class="layui-input-inline">
                <input type="radio" name="window" value="有" title="有" checked="">
                <input type="radio" name="window" value="没有" title="没有" @if(isset($data->window)&&$data->window=='没有')checked=""@endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">早餐:</label>
            <div class="layui-input-inline">
                <input type="radio" name="breakfast" value="有" title="有" checked="">
                <input type="radio" name="breakfast" value="没有" title="没有"@if(isset($data->breakfast)&&$data->breakfast=='没有')checked=""@endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">床型:</label>
            <div class="layui-input-inline">
                <input type="text" name="bedstyle" lay-verify="bedstyle" value="{{$data->bedstyle or ''}}" autocomplete="off" placeholder="请输入窗型:大床" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">楼层:</label>
            <div class="layui-input-inline">
                <input type="text" name="floors" lay-verify="floors" value="{{$data->floors or ''}}" autocomplete="off" placeholder="请输入楼层" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">入住人数:</label>
            <div class="layui-input-inline">
                <input type="text" name="num" lay-verify="num" value="{{$data->num or ''}}" autocomplete="off" placeholder="请输入可入住人数" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上网方式:</label>
            <div class="layui-input-inline">
                <input type="text" name="Internet" lay-verify="Internet" value="{{$data->Internet or ''}}" autocomplete="off" placeholder="请输入上网方式" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">无烟房:</label>
            <div class="layui-input-inline">
                {{--<input type="text" name="nonsmok" lay-verify="nonsmok" value="{{$data->nonsmok or ''}}" autocomplete="off" placeholder="请输入:是,否" class="layui-input">--}}
                <input type="radio" name="nonsmok" value="是" title="是" checked="">
                <input type="radio" name="nonsmok" value="否" title="否" @if(isset($data->nonsmok)&&$data->nonsmok=='否')checked=""@endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">备注:</label>
            <div class="layui-input-inline">
                <input type="text" name="remark" lay-verify="remark" value="{{$data->remark or ''}}" autocomplete="off" placeholder="请输入备注" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片:</label>
            <div class="layui-input-block">
                {{--<div class="layui-upload">--}}
                    {{--<button type="button" class="layui-btn" id="test1">上传图片</button>--}}
                    {{--<div class="layui-upload-list">--}}
                        {{--<img class="layui-upload-img" id="demo1" @if(isset($data->img))src="/uploads/{{$data->img}}"@endif>--}}
                        {{--<input type="hidden" name="img" lay-verify="img" id="oneimg" value="@if(isset($data->img)){{$data->img}}@endif">--}}
                        {{--<p id="demoText"></p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="images">选择图片</button>
                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                        预览：
                        <div class="layui-upload-list" id="uploadimglist">
                            @if(isset($data->img))
                                @foreach(explode(',',$data->img) as $v)
                                    <div class="upload-img" style='display: inline-block'>
                                        <img src='/uploads/{{$v}}' class='layui-upload-img'>
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
                    name: function(value){if(value.length < 3){return '公司名称至少得3个字符';}}
                    ,company_id:function(value){if(value.length < 3){return '公司id至少得3个字符';}}
                    ,address: function(value){if(value.length < 2){return '请输入公司区域,至少得2个字符';}}
                    ,department: function(value){if(value.length < 1){return '请输入公司部门';}}
                    ,duty: function(value){if(value.length < 1){return '请输入公司职务';}}
                });
                //监听提交
                form.on('submit(demo1)', function(data){
                    var img='';
                    $('.hidenimg').each(function (data) {
                        img += $(this).val()+','
                    });
                    data.field.img=img
                    console.log(data.field);
                    var id='{{$data->id or 'create'}}';
                    $.ajax({
                        url:'{{url()->current()}}',
                        data:{_token:'{{csrf_token()}}',data:data.field,hotel_id:'{{$hotel_id}}'},
                        type:'PUT',
                        success:function (data) {
                            window.history.back();
//                            if (data.status){
//                                layer.closeAll();
//                                layer.msg('提交成功');
//                                table.reload('tess', {
//                                    page: {
//                                        curr: 1 //重新从第 1 页开始
//                                    }
//                                });
//                            }
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
                            "<img src='/uploads/"+res.data.src+"' class='layui-upload-img'>"+
                            "<input type='hidden' value='"+res.data.src+"' class='hidenimg'>" +
                            "<\/div>";
                        $('#uploadimglist').append(data);
                    }
                });
                //单图片上传
                {{--var uploadInst = upload.render({--}}
                    {{--elem: '#test1'--}}
                    {{--,url: '{{route('api.imgsave')}}'--}}
                    {{--,done: function(res){--}}
                        {{--//如果上传失败--}}
                        {{--if(res.code > 0){--}}
                            {{--return layer.msg('上传失败');--}}
                        {{--}--}}
                        {{--//上传成功--}}
                        {{--$('#demo1').attr('src','/uploads/'+res.data.src);--}}
                        {{--$('#oneimg').val(res.data.src);--}}
                    {{--}--}}
                    {{--,error: function(){--}}
                        {{--//演示失败状态，并实现重传--}}
                        {{--var demoText = $('#demoText');--}}
                        {{--demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');--}}
                        {{--demoText.find('.demo-reload').on('click', function(){--}}
                            {{--uploadInst.upload();--}}
                        {{--});--}}
                    {{--}--}}
                {{--});--}}

            });
            $('#uploadimglist').on('click','.on',function () {$(this).remove()});
            $('#uploadimglist').on('mouseover','.upload-img',function () {$(this).addClass("on");}).on("mouseout",'.upload-img',function(){$(this).removeClass("on");})
    </script>
    @stop