@extends('admin.layout')
@section('main')
<style>.layui-table-tips-main,.layui-table-tips-main img{width: 300px;height: 300px;max-height:300px;margin: 0;padding:0;}</style>
    <a class="layui-btn layui-btn-primary add" href="javascript:show('{{url()->current()}}/0?city_id={{$city->CityCode}}')" >{{$city->CityName}}-添加区域</a>
    <table id="test2" lay-filter="test2"></table>
    <script type="text/html" id="barDemo" lay-filter="test2">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
<script type="text/html" id="areas">
    <button type="button" class="layui-btn layui-btn-primary layui-btn-xs" onclick="area(@{{ d.id }})">区域管理</button>
</script>
<script type="text/html" id="busines">
    <button type="button" class="layui-btn layui-btn-primary layui-btn-xs" onclick="busines(@{{ d.id }})">商圈管理</button>
</script>
<script type="text/html" id="subways">
    <button type="button" class="layui-btn layui-btn-primary layui-btn-xs" onclick="subways(@{{ d.id }})">地铁管理</button>
</script>
    <script>
        var isload=false;
        window.onload = function(){isload=true;getdata()};
        if (!isload){getdata()}
        function getdata() {
            layui.use('table', function(){
                var table = layui.table;
                //执行渲染
                table.render({
                    elem: '#test2'
                    ,url:'?_token={{csrf_token()}}&city_id={{$city->CityCode}}'
                    ,method: 'post'
                    ,cols: [[
                        {field: 'id', title: 'ID', width: 50,sort:true}
                        ,{field: 'Name', title: '城市名称', width: 130}
                        ,{fixed: 'right', width:200, align:'center', toolbar: '#barDemo'}
                    ]]
                    ,limit: 10,height: 580,id:'tess'
                });
                //监听工具条
                table.on('tool(test2)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data,layEvent = obj.event;
                    if(layEvent === 'del'){
                        layer.confirm('真的删除行么', function(index){
                            layer.close(index);
                            var id=data.Aid;
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
                        var id=data.Aid;
                        show('{{url()->current()}}/'+id)
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