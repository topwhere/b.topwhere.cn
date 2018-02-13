 <style>
        .layui-form-label{width: 90px;}
        .layui-form{margin-top: 20px}
        .layui-upload-img{width: 100px;max-height: 100px;margin-right: 10px;margin-top: 10px}
        .on{position:relative;}
        .on:before{display:block;content:"";width:20px;height:20px;background:url(/static/img/delete.jpeg) no-repeat center center;background-size:100% 100%;position:absolute;right:10px;top:10px;}
    </style>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">备注:</label>
            <div class="layui-input-inline">
                <input type="text" name="value" lay-verify="title" value="{{$data->remark or ''}}" autocomplete="off" placeholder="请输入备注" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
            </div>
        </div>
    </form>
    <script>
            layui.use(['form', 'table','layer'], function(){
                var form = layui.form,table = layui.table;
                var layer = layui.layer;
                //监听提交
                form.on('submit(demo1)', function(data){
                    $.ajax({
                        url:'{{url()->current()}}',
                        data:{_token:'{{csrf_token()}}',data:{data:data.field,type:4}},
                        type:'PUT',
                        success:function (data) {
                            if (data.status){
                                layer.msg('修改成功');
                                window.location.href='/admin/order';
                            }
                        }
                    })
                    return false;
                });
                form.render();
            });


    </script>