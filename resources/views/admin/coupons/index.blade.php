@extends('admin.layout')
@section('main')
    <style>.layui-table-tips-main, .layui-table-tips-main img {
            width: 300px;
            height: 300px;
            max-height: 300px;
            margin: 0;
            padding: 0;
        }</style>
    <table id="test2" lay-filter="test2"></table>
    <script type="text/html" id="barDemo" lay-filter="test2">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <a href="{{url()->current()}}/0" class="layui-btn layui-btn-normal create">创建优惠券</a>
    <table id="demo" lay-filter="test"></table>
    <script type="text/html" id="switchTpl">
        @{{# var timestamp = Date.parse(new Date());
        timestamp = timestamp / 1000;
        }}
        @{{#  if(d.status==2){ }}
        <span>已过期</span>
        @{{#  } else { }}
        <input type="checkbox" name="status" value="@{{d.id}}" lay-skin="switch" lay-text="启用|关闭"
               lay-filter="status" @{{ d.status== 1?'checked' : '' }}>
        @{{#  } }}
    </script>
    <script type="text/html" id="bar">
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="send">发送</a>
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>

    {{--<button class="layui-btn layui-btn-normal send">发送优惠券</button>--}}
    <script>
        layui.use('table', function () {
            var table = layui.table
        ,form = layui.form;
            table.render({
                elem: '#demo'
                , height: 315
                , url: '?_token={{csrf_token()}}' //数据接口
                , method: 'post'
                , cols: [[ //表头
                    {field: 'id', title: 'ID', width: 60, sort: true}
                    , {field: 'name', title: '名称', width: 150}
                    , {field: 'value', title: '面值', width: 60}
                    , {field: 'limit', title: '最低消费', width: 100}
                    , {field: 'start', title: '有效期开始', width: 120}
                    , {field: 'end', title: '有效期结束', width: 120}
                    , {field: 'describe', title: '描述', width: 150}
                    , {field: 'status', title: '状态', width: 100, templet: '#switchTpl', unresize: true}
                    , {fixed: 'right', title: '操作', width: 178, align: 'center', toolbar: '#bar'}
                ]]
            });
            form.on('switch(status)', function (obj) {
                if (obj.elem.checked) {
                    $data = 1;
                } else {
                    $data = 0;
                }
                $.ajax({
                    url: '{{url()->current()}}/' + this.value,
                    data: {data: {status: $data}, '_token': '{{csrf_token()}}'},
                    type: 'PUT',
                    success: function (data) {

                    }
                });
            });
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                if (obj.event === 'send') {
                    var id=data.id;
                    $.pjax({url: '/admin/sendcoupon/' + id, container: '#main-con'});
                } else if (obj.event === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        $.ajax({
                            url: '{{url()->current()}}/' + data.id,
                            data: {userid: '{{auth()->id()}}', _token: '{{csrf_token()}}'},
                            type: 'DELETE',
                            success: function (data) {
                                if (data.status) {
                                    obj.del();
                                    layer.msg('删除成功');
                                }
                            }
                        });
                    });
                } else if (obj.event === 'edit') {
                    var id = data.id;
                    $.pjax({url: '{{url()->current()}}/' + id, container: '#main-con'});
                }
            });
        })

    </script>

    </div>
@endsection