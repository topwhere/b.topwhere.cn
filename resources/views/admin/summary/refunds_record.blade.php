@extends('admin.layout')
@section('main')
    <div class="layui-form-item demoTable">
        <button class="layui-btn" data-type="export">导出</button>
    </div>
    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
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
                    , {field: 'ordertime', title: '时间', width: 150}
                    , {field: 'name_phone', title: '顾客姓名/电话', width: 150}
                    , {field: 'total_price', title: '金额(元)', width: 150}
                    , {field: 'remark', title: '退款原因', width: 150}
                    , {field: 'message', title: '状态', width: 100}
                ]]
                , id: 'testReload'
                , page: true
                , height: 315
            });
            var $ = layui.$, active = {
                export: function () {
                    var demoReload = $('#demoReload');
                    window.location.href = '/admin/refunds_borrowrecordExcel';
                }
            };

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });

        })
    </script>
@stop