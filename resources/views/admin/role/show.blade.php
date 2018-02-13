@extends('admin.layout')
@section('main')
    <style>
        .layui-form-label{width: 166px;}
        .layui-upload-img{width: 100px;max-height: 100px;margin-right: 10px;margin-top: 10px}
        .on{position:relative;}
        .on:before{display:block;content:"";width:20px;height:20px;background:url(/static/img/delete.jpeg) no-repeat center center;background-size:100% 100%;position:absolute;right:10px;top:10px;}
    </style>
    <a onclick="javascript:window.history.back();" class="layui-btn layui-btn-primary">返回</a>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">角色名:</label>
            <div class="layui-input-inline">
                <input type="text" name="display_name" lay-verify="title" autocomplete="off" placeholder="请输入角色名" class="layui-input" value="{{$data->display_name or ''}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色描述:</label>
            <div class="layui-input-inline">
                <input type="text" name="description" lay-verify="title" autocomplete="off" placeholder="请输入角色描述" class="layui-input" value="{{$data->description or ''}}">
            </div>
        </div>
        <style>
            .RoleYiMenu{
                margin-left: 50px;
            }
            .RoleErMenu{
                margin-left: 70px;
            }
        </style>
        <div class="layui-form-item">
            {{--<label class="layui-form-label">复选框</label>--}}
            <div class="layui-input-block">
                @foreach($permission as $v)
                    @if($v->pid==0)
                        <input type="checkbox" name="permission" fid="{{$v->id}}" title="{{$v->display_name}}" @if(in_array($v->id,$permissions))checked=""@endif><br>
                        <div class="RoleYiMenu">
                            @foreach($permission as $yi)
                                @if($yi->pid==$v->id)
                                    <input type="checkbox" name="permission" fid="{{$yi->id}}" title="{{$yi->display_name}}" @if(in_array($yi->id,$permissions))checked=""@endif><br>
                                    <div class="RoleErMenu">
                                        @foreach($permission as $er)
                                            @if($er->pid==$yi->id)
                                                <input type="checkbox" name="permission" fid="{{$er->id}}" title="{{$er->display_name}}" @if(in_array($er->id,$permissions))checked=""@endif>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endforeach
                {{--<input type="checkbox" name="like[read]" title="阅读" checked="">--}}
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
                //监听提交
                form.on('submit(demo1)', function(data){
                    var chk_value =[];
                    $('input[name="permission"]:checked').each(function(){
                        chk_value.push($(this).attr('fid'));
                    });
                    var id='{{$data->id or 'create'}}';
                    $.ajax({
                        url:'{{url()->current()}}',
                        data:{_token:'{{csrf_token()}}',data:data.field,permission:chk_value},
                        type:'PUT',
                        success:function (data) {
//                            window.history.back();
                            if (data.status){
                                layer.msg('提交成功');
                                window.history.back();
                                $('.layui-form').reset()
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