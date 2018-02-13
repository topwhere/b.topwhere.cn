 <style>
        .layui-form-label{width: 90px;}
        .layui-form{margin-top: 20px}
    </style>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">服务名:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="value" value="{{$data->name or ''}}" autocomplete="off" placeholder="请输入要添加的设施服务" class="layui-input">
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
            layui.use(['form','table'], function(){
                var form = layui.form,table = layui.table;
                //监听提交
                form.on('submit(demo1)', function(data){
                    var id='{{$data->id or 'create'}}';
                    $.ajax({
                        url:'{{url()->current()}}',
                        data:{_token:'{{csrf_token()}}',data:data.field},
                        type:'PUT',
                        success:function (data) {
//                            window.history.back();
                            if (data.status){
                                layer.closeAll();
                                layer.msg('提交成功');
                                table.reload('tess', {
                                    page: {
                                        curr: 1 //重新从第 1 页开始
                                    }
                                });
                            }
                        }
                    })
                    return false;
                });
                form.render();
            });


    </script>