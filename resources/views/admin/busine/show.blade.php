 <style>
        .layui-form-label{width: 90px;}
        .layui-form{margin-top: 20px}
        .layui-upload-img{width: 100px;max-height: 100px;margin-right: 10px;margin-top: 10px}
        .on{position:relative;}
        .on:before{display:block;content:"";width:20px;height:20px;background:url(/static/img/delete.jpeg) no-repeat center center;background-size:100% 100%;position:absolute;right:10px;top:10px;}
    </style>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">商圈名:</label>
            <div class="layui-input-inline">
                <input type="text" name="businessName" lay-verify="title" value="{{$data->businessName or ''}}" autocomplete="off" placeholder="请输入商圈名" class="layui-input">
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
                    var id='{{$data->businessId or 'create'}}';
                    $.ajax({
                        url:'{{url()->current()}}',
                        data:{_token:'{{csrf_token()}}',data:data.field,city_id:'{{$city_id}}'},
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