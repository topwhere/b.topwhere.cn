@extends('admin.layout')
@section('main')
    <div class="demoTable">
        <div class="layui-inline">
            <input class="layui-input" placeholder="按姓名或电话查询" name="id" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload">查询</button>

        <table id="test2" lay-filter="test2"></table>
        <button class="layui-btn" data-type="baimingdan">加入白名单</button>
    </div>
    <script type="text/html" id="barDemo">

        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        {{--<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>--}}
    </script>
    <script>
        function rooms(id) {
            $.pjax({url: 'room/?hotel_id=' + id, container: '#main-con'});
        }

        layui.use(['table', 'layer'], function () {
            var table = layui.table, layer = layui.layer;
            //执行渲染
            var tableIns = table.render({
                elem: '#test2'
                , url: '?_token={{csrf_token()}}'
                , method: 'post'
                , cols: [[
                    {type: 'checkbox'}
                    , {field: 'id', title: 'ID', width: 50, sort: true}
                    , {field: 'name', title: '姓名', width: 130}
                    , {field: 'phone', title: '电话', width: 130}
                    , {field: 'grade', title: '等级', width: 130}
                    , {field: 'integral', title: '积分', width: 130}
                    , {field: 'total', title: '总消费金额', width: 130}
                    , {field: 'created_at', title: '申请时间', width: 130}
                    , {fixed: 'right', width: 200, align: 'center', toolbar: '#barDemo'}
                ]]
                , limit: 10, height: 400, id: 'tess'
            });
            var $ = layui.$, active = {
                reload: function () {
                    var demoReload = $('#demoReload');

                    //执行重载
                    table.reload('tess', {
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
                baimingdan: function () { //获取选中数据
                    var checkStatus = table.checkStatus('tess')
                        , data = checkStatus.data;
                    tem = [];
                    if (data.length == 0) {
                        layer.msg('请选择要设置的人员');

                    } else {
                        for (i = 0; i < data.length; i++) {
                            tem[i] = data[i]['id'];
                        }

                        $.ajax({
                            url: '/admin/user_baimingdan',
                            data: {_token: '{{csrf_token()}}', tem: tem},
                            type: 'post',
                            success: function (data) {
                                layer.open({
                                    type: 1,
                                    skin: 'layui-layer-rim', //加上边框
                                    area: ['600px', '260px'], //宽高
                                    content: data
                                });
                            }
                        })
                    }
                }
            };

            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
            //监听工具条
            table.on('tool(test2)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    , layEvent = obj.event; //获得 lay-event 对应的值
                if (layEvent === 'edit') {
                    var id = data.id;
                    $.pjax({url: '{{url()->current()}}/' + id, container: '#main-con'});
                    {{--show('{{url()->current()}}/'+id)--}}
                }
            });
            table.on('sort(test2)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                table.reload('tess', {initSort: obj, where: {sort: {filed: obj.field, type: obj.type}}});
            });
        });

    </script>
@stop