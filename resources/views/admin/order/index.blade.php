@extends('admin.layout')
@section('main')
    <div class="demoTable">
        筛选
        <div class="layui-inline">
            <input class="layui-input" name="id" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload">搜索</button>
    </div>

    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script type="text/html" id="barDemo">
        @{{#  if(d.status == 1){ }}
        <a class="layui-btn layui-btn-xs" lay-event="agree">同意</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="refuse">拒绝</a>
        @{{#  } else { }}
        @{{ d.message }}
        @{{#  } }}
    </script>

    <script type="text/html" id="bar">
        <a class="layui-btn layui-btn-xs" lay-event="remarks">备注</a>
    </script>


    <script>
        layui.use(['table', 'layer'], function () {
            var table = layui.table;
            var layer = layui.layer;

            //方法级渲染
            table.render({
                elem: '#LAY_table_user'
                , url: '?_token={{csrf_token()}}'
                , method: 'post'
                , cols: [[
                    {field: 'order_id', title: '订单编号', width: 120}
                    , {field: 'hotelname', title: '酒店', width: 80}
                    , {field: 'room', title: '房型', width: 80}
                    , {field: 'time', title: '到/离店时间', width: 120}
                    , {field: 'name_phone', title: '姓名/电话', width: 160}
                    , {field: 'price', title: '单价', width: 60}
                    , {field: 'total', title: '总价', width: 60}
                    , {field: 'ordertime', title: '订单时间', width: 100}
                    , {field: 'remark', title: '退单原因', width: 100}
                    , {width: 120, align: 'center', title: '订单状态', toolbar: '#barDemo'}
                    , {fixed: 'right', width: 80, align: 'center', toolbar: '#bar'}
                ]]
                , id: 'testReload'
                , page: true
                , height: 315
            });
            table.on('tool(user)', function (obj) {
                var data = obj.data;
                if (obj.event === 'agree') {
                    layer.confirm('该订单真的同意么?', function (index) {
                        $.ajax({
                            url: '{{url()->current()}}/' + data.id,
                            data: {data: {type: 2}, '_token': '{{csrf_token()}}'},
                            type: 'PUT',
                            success: function (data) {
                                if (data.status == 1) {
                                    window.location.href = '/admin/order';
                                }
                            }
                        });
                    });

                } else if (obj.event === 'refuse') {
                    layer.confirm('该订单真的拒绝么?', function (index) {
                        $.ajax({
                            url: '{{url()->current()}}/' + data.id,
                            data: {data: {type: 3}, '_token': '{{csrf_token()}}'},
                            type: 'PUT',
                            success: function (data) {
                                if (data.status == 1) {
                                    window.location.href = '/admin/order';
                                }
                            }
                        });
                    });
                } else if (obj.event === 'remarks') {
                    show('{{url()->current()}}/' + data.id);

                }
            });

            var $ = layui.$, active = {
                reload: function () {
                    var demoReload = $('#demoReload');

                    //执行重载
                    table.reload('testReload', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        , where: {
                            key: {
                                value: demoReload.val()
                            }
                        }
                    });
                }

            };

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
        });

        function show(url) {
            $.get(url, function (data) {
                layer.open({
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    area: ['420px', '260px'], //宽高
                    content: data
                });
            });

        }
    </script>

@stop