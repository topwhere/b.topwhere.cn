@extends('admin.layout')
@section('main')
<style>.layui-table-tips-main,.layui-table-tips-main img{width: 300px;height: 300px;max-height:300px;margin: 0;padding:0;}</style>
    <a class="layui-btn layui-btn-primary add" href="javascript:show('{{url()->current()}}/0?province={{$_GET['province']}}')" >添加城市</a>
    <table id="test2" lay-filter="test2"></table>
    <script type="text/html" id="barDemo" lay-filter="test2">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
<script type="text/html" id="areas">
    <button type="button" class="layui-btn layui-btn-primary layui-btn-xs" onclick="area(@{{ d.CityCode }})">区/县管理</button>
</script>
<script type="text/html" id="busines">
    <button type="button" class="layui-btn layui-btn-primary layui-btn-xs" onclick="busines(@{{ d.CityCode }})">商圈管理</button>
</script>
<!-- <script type="text/html" id="subways">
    <button type="button" class="layui-btn layui-btn-primary layui-btn-xs" onclick="subways(@{{ d.id }})">地铁管理</button>
</script> -->
    <script>
        function area(id) {
            $.pjax({url: '/admin/area/?city_id='+id, container: '#main-con'});
        }
        function busines(id) {
            $.pjax({url: '/admin/busines/?city_id='+id, container: '#main-con'});
        }
        // function subways(id) {
        //     $.pjax({url: '/admin/subways/?city_id='+id, container: '#main-con'});
        // }
        var isload=false;
        window.onload = function(){isload=true;getdata()};
        if (!isload){getdata()}
        function getdata() {
            layui.use('table', function(){
                var table = layui.table;
                //执行渲染
                var tableIns=table.render({
                    elem: '#test2'
                    ,url:'?_token={{csrf_token()}}&province={{$_GET['province']}}'
                    ,method: 'post'
                    ,cols: [[
                        {field: 'id', title: 'ID', width: 50,sort:true}
                        ,{field: 'CityName', title: '城市名称', width: 130}
                        ,{field: 'CityName', title: '区/县', width: 130, templet: '#areas'}
                        ,{field: 'CityName', title: '商圈', width: 130, templet: '#busines'}
                        // ,{field: 'CityName', title: '地铁', width: 130, templet: '#subways'}
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
                            layer.close(index);
                            //向服务端发送删除指令
                            var id=data.CityCode
                            $.ajax({
                                url:'{{url()->current()}}/'+id,
                                data:{userid:'{{auth()->id()}}',_token:'{{csrf_token()}}'},
                                type:'DELETE',
                                success:function (data) {
                                    if (data.status){
                                        obj.del();
                                        layer.msg('删除成功');
                                    }
                                }
                            })
                        });
                    } else if(layEvent === 'edit'){
                        var id=data.CityCode;
                        show('{{url()->current()}}/'+id+'?province={{$_GET['province']}}')
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