@extends('admin.layout')
@section('main')
    <div class="layui-form-item demoTable">
        <div class="layui-input-inline">
            <input type="text" class="layui-input" id="demoReload" placeholder=" - ">
        </div>
        <button class="layui-btn" data-type="reload">查询</button>
        <button class="layui-btn" data-type="export">导出</button>
    </div>
    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script>
        layui.use(['table', 'layer', 'laydate'], function () {
            var table = layui.table;
            var layer = layui.layer;
            var laydate = layui.laydate;
            laydate.render({
                elem: '#demoReload'
                , range: true
            });
            //方法级渲染
            table.render({
                elem: '#LAY_table_user'
                , url: '?_token={{csrf_token()}}'
                , method: 'post'
                , cols: [[
                    {field: 'order_id', title: '订单编号', width: 120}
                    , {field: 'ordertime', title: '时间', width: 150}
                    , {field: 'name_phone', title: '顾客姓名/电话', width: 150}
                    , {field: 'total_price', title: '金额(元)', width: 150}
                    , {field: 'message', title: '状态', width: 100}
                ]]
                , id: 'testReload'
                , page: true
                , height: 315
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
                                type: 1,
                                value: demoReload.val()
                            }
                        }
                    });
                },
                export: function () {
                    var demoReload = $('#demoReload').val();
                  window.location.href='/admin/borrowrecordexcel/?value='+demoReload+'&type=1';
                }
            };

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });

        })
    </script>
@stop