@extends('admin.layout')
@section('main')
    <div class="layui-form demoTable">
        <input type="hidden" value="-1" id="hidden">
        <div class="layui-input-inline">
            <select name="status" lay-filter="test">
                <option value="-1">全部</option>
                <option value="0">未处理</option>
                <option value="1">已处理</option>
            </select>
        </div>
        <div class="layui-inline">
            <input type="text" class="layui-input" id="demoReload" placeholder="请输入客户姓名或手机号">
        </div>
        <button class="layui-btn" data-type="reload">查询</button>
    </div>
    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script type="text/html" id="statusTpl">
        @{{#  if(d.status ==0){ }}
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="comfirm">确认</a>
        @{{#  } else { }}
        @{{ d.message }}
        @{{#  } }}
    </script>
    <script>
        layui.use(['table', 'layer', 'form'], function () {
            var table = layui.table;
            var layer = layui.layer;
            var form = layui.form;
            //方法级渲染
            form.on('select(test)', function (data) {
                $('#hidden').val(data.value);
            });
            table.render({
                elem: '#LAY_table_user'
                , url: '?_token={{csrf_token()}}'
                , method: 'post'
                , cols: [[
                    {field: 'name_phone', title: '姓名/手机号', width: 120}
                    , {field: 'hotel', title: '消费酒店', width: 130}
                    , {field: 'type', title: '发票类型', width: 130}
                    , {field: 'company', title: '企业名称', width: 130}
                    , {field: 'num', title: '识别号/信用代码', width: 135}
                    , {field: 'address', title: '注册地址', width: 130}
                    , {field: 'bank_num', title: '开户行/账号', width: 150}
                    , {field: 'total', title: '总价', width: 60}
                    , {width: 60, templet: '#statusTpl', title: '状态'}
                ]]
                , id: 'testReload'
                , page: true
                , height: 315
            });
            var $ = layui.$, active = {
                reload: function () {
                    var demoReload = $('#demoReload');
                    var status = $('#hidden');

                    //执行重载
                    table.reload('testReload', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        , where: {
                            key: {
                                type: 1,
                                value: demoReload.val(),
                                status: status.val(),
                            }
                        }
                    });
                }
            };

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });

            table.on('tool(user)', function (obj) {
                var data = obj.data;
                if (obj.event === 'comfirm') {
                    layer.confirm('真的确认么', function (index) {
                        $.ajax({
                            url: '{{url()->current()}}/' + data.value,
                            data: {'_token': '{{csrf_token()}}'},
                            type: 'PUT',
                            success: function (data) {
                                if (data.status == 1) {
                                    window.location.href = '/admin/invoice';
                                }
                            }
                        });
                    })
                }
            });
        })
    </script>
@stop