<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>后台登录</title>
    <link rel="stylesheet" href="/vendor/layui/css/layui.css"  media="all">
</head>
<body>
<style>
    body{background: #cccccc}
    .logmain{background:#ffffff;width: 400px;height: 248px;margin: auto;margin-top: 200px;padding: 20px 30px 10px 0;}
    .loginlog{font-size: 30px;  text-align: center;  line-height: 60px;}
</style>
<div class="logbody">
    <div class="logmain">
        <div class="loginlog">管理后台登录</div>
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">账号:</label>
                <div class="layui-input-block">
                    <input type="text" name="name" lay-verify="name" autocomplete="off" placeholder="请输入账号" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码:</label>
                <div class="layui-input-block">
                    <input type="password" name="password" lay-verify="password" autocomplete="off" placeholder="请输入密码" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    {{--<a class="layui-btn layui-btn-primary" style="margin-left: 20px" href="{{route('admin.regist')}}" >立即注册</a>--}}
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<script src="/vendor/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    layui.use(['form', 'layedit', 'laydate'], function(){
        var $ = layui.jquery,form = layui.form,layer = layui.layer;
        //自定义验证规则
        form.verify({
            name: function(value){
                if(value.length < 5){
                    return '账号至少得5个字符';
                }
            }
            ,password: [/(.+){5,12}$/, '密码必须5到12位']
        });

        //监听提交
        form.on('submit(demo1)', function(data){
//            layer.alert(JSON.stringify(data.field), {
//                title: '最终的提交信息'
//            })
            $.post('{{route('admin.login')}}',{_token:'{{csrf_token()}}',data:data.field},function (data) {
                if(data.status==0){
                    layer.msg(data.msg)
                }
                if(data.status==1){
                    window.location.href='{{route('admin.index')}}'
                }
            });
            return false;
        });
    });
</script>