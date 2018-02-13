@extends('admin.layout')
@section('main')
    <style>
        .layui-form{margin-top: 10px}
        .layui-form-label{width: 100px;}
        .layui-upload-img{width: 100px;max-height: 100px;margin-right: 10px;margin-top: 10px}
        .on{position:relative;}
        .on:before{display:block;content:"";width:20px;height:20px;background:url(/static/img/delete.jpeg) no-repeat center center;background-size:100% 100%;position:absolute;right:10px;top:10px;}
    </style>
    <a onclick="javascript:window.history.back();" class="layui-btn layui-btn-primary">返回</a>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">上级</label>
            <div class="layui-input-inline">
                <select name="pid" lay-verify="required" lay-search="">
                    <option value="0">直接选择或搜索选择</option>
                    @foreach($fdata as $v)
                        <option value="{{$v->id}}" @if(isset($data->pid)&&$v->id==$data->pid) selected @endif>{{$v->display_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">名称:</label>
            <div class="layui-input-inline">
                <input type="text" name="display_name" lay-verify="display_name" value="{{$data->display_name or ''}}" placeholder="请输入目录名称" autocomplete="off"  class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">链接:</label>
            <div class="layui-input-inline">
                <input type="text" name="url"  value="{{$data->url or ''}}" placeholder="请输入目录链接" autocomplete="off"  class="layui-input" >
            </div>
        </div>
        {{--<div class="layui-form-item">--}}
            {{--<label class="layui-form-label">权限:</label>--}}
            {{--<div class="layui-input-inline">--}}
                {{--<input type="text" name="name" lay-verify="name" value="{{$data->name or ''}}" placeholder="请输入目录权限" autocomplete="off"  class="layui-input" >--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="layui-form-item">
            <label class="layui-form-label">优先级:</label>
            <div class="layui-input-inline">
                <input type="text" name="sort" lay-verify="sort" value="{{$data->sort or 0}}" placeholder="目录优先级 数字越大越靠前" autocomplete="off"  class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否显示:</label>
            <div class="layui-input-inline">
                <input type="radio" name="status" value="1" title="是" checked="">
                <input type="radio" name="status" value="0" title="否" @if(isset($data->status)&&$data->status==0)checked=""@endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
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