@extends('admin.layout')
@section('main')
    <style>
        .layui-form-label{width: 166px;}
        .layui-upload-img{width: 100px;max-height: 100px;margin-right: 10px;margin-top: 10px}
        .on{position:relative;}
        .on:before{display:block;content:"";width:20px;height:20px;background:url(/static/img/delete.jpeg) no-repeat center center;background-size:100% 100%;position:absolute;right:10px;top:10px;}
    </style>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">账号:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="name" autocomplete="off" placeholder="请输入账号" class="layui-input" value="{{$data->name or ''}}">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">密码:</label>
            <div class="layui-input-inline">
                <input type="password" name="password" lay-verify="password" autocomplete="off" placeholder="请输入密码" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">姓名:</label>
            <div class="layui-input-inline">
                <input type="text" name="nickname" lay-verify="nickname" autocomplete="off" placeholder="请输入姓名" class="layui-input" value="{{$data->nickname or ''}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所属角色</label>
            <div class="layui-input-inline">
                <select name="role" lay-filter="aihao" lay-verify="role">
                    <option value=""></option>
                    {{--<option value="0">超级管理员</option>--}}
                    @foreach($role as $v)
                        <option value="{{$v->id}}" @if(isset($data->roleuser)&&$data->roleuser->role_id==$v->id)selected=""@endif >{{$v->display_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="status"  value="0" title="禁用" @if(isset($data->status)&&$data->status==0) checked=""@endif >
                <input type="radio" name="status" value="1" title="启用" @if(isset($data->status)&&$data->status==1) checked=""@endif>
                {{--<input type="radio" name="sex" value="禁" title="禁用" disabled="">--}}
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
        function getdata() {
            layui.use(['form', 'layedit', 'laydate','upload'], function(){
                var form = layui.form
                    ,layer = layui.layer;
                //自定义验证规则
                form.verify({
                    name: function(value){
                        if(value.length < 5){
                            return '账号至少得5个字符';
                        }
                    },
                    role: function(value){
                        if(value.length < 1){
                            return '请选择角色';
                        }
                    },
                    status:function(value){
                        console.log(value);
                        if(value.length < 1){
                            return '请选择状态';
                        }
                    },
                });
                //监听提交
                form.on('submit(demo1)', function(data){
                    if(data.field.status.length<1){
                        return false;
                    }
                    var id='{{$data->id or 'create'}}';
                    $.ajax({
                        url:'{{url()->current()}}',
                        data:{_token:'{{csrf_token()}}',data:data.field},
                        type:'PUT',
                        success:function (data) {
//                            window.history.back();
                            if (data.status){
//                                layer.msg('提交成功');
//                                layer.closeAll();
                                window.history.back();
//                                $('.layui-form').reset()
                            }
                        }
                    })
                    return false;
                });
                form.render();
            });
        }
        var isload=false;
        window.onload = function(){isload=true;getdata()};
        if (!isload){getdata()}
    </script>
@stop