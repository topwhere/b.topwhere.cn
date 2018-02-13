@extends('admin.layout')
@section('main')
    <?php $name='会员等级'?>
<style>.layui-table-tips-main,.layui-table-tips-main img{width: 300px;height: 300px;max-height:300px;margin: 0;padding:0;}</style>
    {{--<a class="layui-btn layui-btn-primary add" href="javascript:show('{{url()->current()}}/0')" >添加{{$name}}</a>--}}
    <a class="layui-btn layui-btn-primary add" href="{{url()->current()}}/0" data-pjax>添加{{$name}}</a>
    <table id="test2" lay-filter="test2"></table>
    <script type="text/html" id="barDemo" lay-filter="test2">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>


    <script>
        function rooms(id) {
            $.pjax({url: 'room/?hotel_id='+id, container: '#main-con'});
        }
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
                    ,method: 'post'
                    ,cols: [[
//                        {field: 'id', title: 'ID', width: 50,sort:true},
                        {field: 'name', title: '名称', width: 130}
                        ,{field: 'value', title: '所需积分', width: 130}
                        ,{fixed: 'right', width:200, align:'center', toolbar: '#barDemo'}
                    ]]
                    ,limit: 10,height: 580,id:'tess'
                });
                //监听工具条
                table.on('tool(test2)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                            ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('真的删除行么', function(index){
                            obj.del(); //删除对应行（tr）的DOM结构
                            layer.close(index);
                            //向服务端发送删除指令
                            var id=data.id
                            $.ajax({
                                url:'{{url()->current()}}/'+id,
                                data:{userid:'{{auth()->id()}}',_token:'{{csrf_token()}}'},
                                type:'DELETE',
                                success:function (data) {
                                    if (data.status){
                                        layer.msg('删除成功');
                                    }
                                }
                            })
                        });
                    } else if(layEvent === 'edit'){
                        var id=data.id;
                        $.pjax({url: '{{url()->current()}}/'+id, container: '#main-con'});
                        {{--show('{{url()->current()}}/'+id)--}}
                    }
                });
                table.on('sort(test2)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                    table.reload('tess', {initSort: obj,where: {sort:{filed:obj.field, type:obj.type}}});
                });
            });
        }
        function show(url) {
            $.get(url,function (data) {
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