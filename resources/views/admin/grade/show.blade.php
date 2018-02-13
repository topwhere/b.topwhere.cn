@extends('admin.layout')
@section('main')
 <style>
     .layui-form-label{width: 166px;}
        /*.layui-form-label{width: 90px;}  .layui-form{margin-top: 20px}*/
     .on{position:relative;height: 30px;line-height: 30px;margin-right: 10px}
     .on:before{display:block;content:"";width:10px;height:10px;background:url(/static/img/delete.jpeg) no-repeat center center;background-size:100% 100%;position:absolute;right:-5px;top:-5px;}
        .layui-upload-img{width: 100px;max-height: 100px;margin-right: 10px;margin-top: 10px}
    </style>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">等级名称:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="name" value="{{$data->name or ''}}" autocomplete="off" placeholder="请输入等级名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所需积分:</label>
            <div class="layui-input-inline">
                <input type="text" name="value" lay-verify="value" value="{{$data->value or ''}}" autocomplete="off" placeholder="请输入所需积分" class="layui-input">
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
        layui.use(['form'], function(){
            var form = layui.form;
            form.verify({
                name: function(value){if(value.length < 2){return '等级名称至少得2个字符';}}
            });
            //监听提交
            form.on('submit(demo1)', function(data){
                var id='{{$data->id or 'create'}}';
                console.log(data.field);
                $.ajax({
                    url:'{{url()->current()}}',
                    data:{_token:'{{csrf_token()}}',data:data.field},
                    type:'PUT',
                    success:function (data) {
                        if (data.status==1){
                            window.location.href='/admin/grade';
//                            layer.closeAll();
                            layer.msg('提交成功');
                        }
                    }
                });
                return false;
            });
            form.render();
        });
</script>
@stop