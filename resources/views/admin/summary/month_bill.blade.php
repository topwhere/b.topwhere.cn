@extends('admin.layout')
@section('main')
    <div class="layui-form demoTable">
        <div class="layui-form-item">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="test3" placeholder="yyyy-MM">
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn" data-type="reload">查询</button>
                    <button class="layui-btn" data-type="export">导出</button>
                </div>
            </div>
        </div>
    </div>
    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script>
        layui.use(['table', 'layer', 'laydate'], function () {
            var table = layui.table;
            var layer = layui.layer;
            var laydate = layui.laydate;
            laydate.render({
                elem: '#test3'
                ,type: 'month'
            });

            //方法级渲染
            table.render({
                elem: '#LAY_table_user'
                , url: '?_token={{csrf_token()}}'
                , method: 'post'
                , cols: [[
                    {field: 'year_month', title: '日期', width: 120}
                    , {field: 'total_nums', title: '订单数量', width: 150}
                    , {field: 'total_price', title: '订单总金额(元)', width: 150}
                    , {field: 'total_res_price', title: '退款总金额(元)', width: 150}
                    , {field: 'total', title: '结算小计', width: 150}
                ]]
                , id: 'testReload'
                , page: true
                , height: 315
            });
            var $ = layui.$, active = {
                reload: function(){
                    var demoReload = $('#test3');

                    //执行重载
                    table.reload('testReload', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            key: {
                                type:1,
                                value: demoReload.val(),
                            }
                        }
                    });
                },
                export: function () {
                    var demoReload = $('#test3').val();
                    window.location.href='/admin/month_borrowrecordExcel/?value='+demoReload+'&type=1';
                }
            };

            $('.demoTable .layui-btn').on('click', function(){
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
        })
    </script>
@stop