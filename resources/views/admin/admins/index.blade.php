@extends('admin.layout')
@section('main')
    <style>
        .layui-table-tips-main,.layui-table-tips-main img{width: 300px;height: 300px;max-height:300px;margin: 0;padding:0;}
    </style>
    <table id="test2" lay-filter="test2"></table>
    <script type="text/html" id="barDemo" lay-filter="test2">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script type="text/html" id="seatusTpl">
        @{{#  if(d.status == 1){ }}
        <span style="color: #F581B1;">启用</span>
        @{{#  } else { }}
        <span style="color: #4cadec;">禁用</span>
        @{{#  } }}
    </script>

    <script>
        var isload=false;
        window.onload = function(){isload=true;getdata()};
        if (!isload){getdata()}
        function getdata() {
            layui.use('table', function(){
                var table = layui.table;
                //执行渲染
                var tableIns=table.render({
                    elem: '#test2'
                    ,url:'?_token={{csrf_token()}}'
//                    ,where: {key:{token: 'sasasas', id: 123}}
                    ,method: 'post'
                    ,cols: [[
//                        {checkbox: false},
                        {field: 'id', title: 'ID', width: 80,sort:true}
                        ,{field: 'name', title: '账号', width: 300}
                        ,{field: 'nickname', title: '姓名', width: 300}
                        ,{field: 'status', title: '状态', width: 120,templet:'#seatusTpl',sort:true}
                        ,{fixed: 'right', width:200, align:'center', toolbar: '#barDemo'}
                    ]]
                    ,limit: 10,height: 580,id:'tess'
                });
//                tableIns.reload({
//                    where: {
//                        key: 'xxx'
//                        ,value: 'yyy'
//                    }
//                });
                //监听工具条
                table.on('tool(test2)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('真的删除行么', function(index){
                            obj.del(); //删除对应行（tr）的DOM结构
                            layer.close(index);
                            //向服务端发送删除指令
                            var id=data.id;
                            $.ajax({
                                url:'{{url()->current()}}/'+id,
                                data:{userid:'{{auth()->id()}}',_token:'{{csrf_token()}}'},
                                type:'DELETE',
                                success:function (data) {
                                    if (data.status){
                                        layer.msg('删除成功');
                                        $('.layui-form').reset()
                                    }
                                }
                            })
                        });
                    } else if(layEvent === 'edit'){
                        var id=data.id
                        $.pjax({url: '{{url()->current()}}/'+id, container: '#main-con'})
                    }
                });
                table.on('sort(test2)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                    table.reload('tess', {initSort: obj,where: {sort:{filed:obj.field, type:obj.type}}});
                });
            });
        }
    </script>
@stop