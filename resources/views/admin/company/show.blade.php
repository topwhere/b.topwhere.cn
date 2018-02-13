@extends('admin.layout')
@section('main')
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=nr4kRz07dEX1MewduP1lSwDW62SGROHO"></script>
 <style>
     .layui-form-label{width: 166px;}
        /*.layui-form-label{width: 90px;}  .layui-form{margin-top: 20px}*/
     .on{position:relative;height: 30px;line-height: 30px;margin-right: 10px}
     .on:before{display:block;content:"";width:10px;height:10px;background:url(/static/img/delete.jpeg) no-repeat center center;background-size:100% 100%;position:absolute;right:-5px;top:-5px;}
        .layui-upload-img{width: 100px;max-height: 100px;margin-right: 10px;margin-top: 10px}
    </style>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">公司logo:</label>
            <div class="layui-input-inline">
                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="test1">上传图片</button>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="demo1" @if(isset($data->logo))src="/uploads/{{$data->logo}}"@endif>
                        <input type="hidden" name="logo" lay-verify="logo" id="oneimg" value="@if(isset($data->logo)){{$data->logo}}@endif">
                        <p id="demoText"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公司名称:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="name" value="{{$data->name or ''}}" autocomplete="off" placeholder="请输入公司名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公司ID:</label>
            <div class="layui-input-inline">
                <input type="text" name="company_id" lay-verify="company_id" value="{{$data->company_id or ''}}" autocomplete="off" placeholder="请输入公司ID" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公司区域:</label>
            <div class="layui-input-inline">
                <input type="text" name="address" lay-verify="address" value="{{$data->address or ''}}" autocomplete="off" placeholder="请输入公司区域" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公司部门:</label>
            <div class="layui-input-block" id="departmentlist">
                @if(isset($data->department))
                    @foreach(explode(',',$data->department) as $v)
                        <span class="on" >{{$v}}</span>
                    @endforeach
                @endif
                <button class="layui-btn layui-btn-xs layui-btn-normal addbun" type="button" onclick="addDepartment()">添加部门</button>
            </div>
            <input type="hidden" name="department" id="department" lay-verify="department" value="{{$data->department or ''}}">
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公司职务:</label>
            <div class="layui-input-block" id="dutylist">
                @if(isset($data->duty))
                    @foreach(explode(',',$data->duty) as $v)
                        <span class="on" >{{$v}}</span>
                    @endforeach
                @endif
                <button class="layui-btn layui-btn-xs layui-btn-normal addduty" type="button" onclick="addduty()">添加职务</button>
            </div>
            <input type="hidden" name="duty" id="duty" lay-verify="duty" value="{{$data->duty or ''}}">
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                {{--<button type="reset" class="layui-btn layui-btn-primary">重置</button>--}}
            </div>
        </div>
    </form>
    <script>
        //添加部门
        function addDepartment() {
            layer.prompt({title: '输入部门名称，并确认', formType: 3}, function(text, index){
                layer.close(index);
                $('#department').val($('#department').val()+text+',');
                $('.addbun').before('<span class="on" >'+text+'</span>');
            });
        }
        $('#departmentlist').on('click','.on',function () {
            dep=$('#department').val();
            e=$(this).text();
            dep=dep.replace(new RegExp(e+','),'');
            dep=dep.replace(new RegExp(e),'');
            $('#department').val(dep);
            $(this).remove()
        });
        //添加职务
        function addduty() {
            layer.prompt({title: '输入职务名称，并确认', formType: 3}, function(text, index){
                layer.close(index);
                $('#duty').val($('#duty').val()+text+',');
                $('.addduty').before('<span class="on" >'+text+'</span>');
            });
        }
        $('#dutylist').on('click','.on',function () {
            dep=$('#duty').val();
            e=$(this).text();
            dep=dep.replace(new RegExp(e+','),'');
            dep=dep.replace(new RegExp(e),'');
            $('#duty').val(dep);
            $(this).remove()
        });

        layui.use(['form', 'table','upload'], function(){
            var form = layui.form,table = layui.table,upload = layui.upload;
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
                $.ajax({
                    url:'{{url()->current()}}',
                    data:{_token:'{{csrf_token()}}',data:data.field},
                    type:'PUT',
                    success:function (data) {
//                            window.history.back();
                        if (data.status==1){
                            window.location.href='/admin/company'
//                            layer.closeAll();
//                            layer.msg('提交成功');
                        }
                    }
                });
                return false;
            });
            form.render();
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
@stop