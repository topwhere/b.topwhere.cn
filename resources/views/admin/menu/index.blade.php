@extends('admin.layout')
@section('main')
    <style>.layui-table-tips-main,.layui-table-tips-main img{width: 300px;height: 300px;max-height:300px;margin: 0;padding:0;}</style>
    <a class="layui-btn layui-btn-primary add" href="{{url()->current()}}/0" data-pjax>添加菜单</a>
    <table id="test2" lay-filter="test2"></table>

    <script type="text/html" id="checkboxTpl">
        <input type="checkbox" name="status" value="@{{ d.id }}" title="显示" lay-filter="status" @{{ d.status == 1 ? 'checked' : '' }}>
    </script>
    <script type="text/html" id="barDemo" lay-filter="test2">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script>
        var isload=false;
        window.onload = function(){isload=true;getdata()};
        if (!isload){getdata()}
        function getdata() {
            layui.use(['table','form'], function(){
                var table = layui.table,form = layui.form;
                //执行渲染
                table.render({
                    elem: '#test2'
                    ,url:'?_token={{csrf_token()}}'
                    ,method: 'post'
                    ,cols: [[
                        {field: 'id', title: 'ID', sort:true,width:60}
                        ,{field: 'display_name', title: '目录名称',width:200}
                        ,{field: 'url', title: '目录链接',width:180}
                        ,{field:'status', title:'是否显示', templet: '#checkboxTpl',width:120}
                        ,{fixed: 'right', width:200, align:'center', toolbar: '#barDemo'}
                    ]]
                    ,limit: 30,height: 'full',id:'tess',cellMinWidth:80
                });

                //监听工具条
                table.on('tool(test2)', function(obj){
                    var data = obj.data,layEvent = obj.event;
                    if(layEvent === 'del'){
                        layer.confirm('真的删除行么', function(index){
                            layer.close(index);
                            //向服务端发送删除指令
                            var id=data.id;
                            $.ajax({
                                url:'{{url()->current()}}/'+id,
                                data:{userid:'{{auth()->id()}}',_token:'{{csrf_token()}}'},
                                type:'DELETE',
                                success:function (data) {
                                    if (data.status==1){
                                        layer.msg('删除成功');
                                        obj.del();
                                    }
                                    if(data.status==0){
                                        layer.msg(data.msg);
                                    }
                                }
                            })
                        });
                    } else if(layEvent === 'edit'){
                        var id=data.id;
                        $.pjax({url: '{{url()->current()}}/'+id, container: '#main-con'});
                        {{--$.ajax({--}}
                        {{--url:'{{url()->current()}}/'+id,--}}
                        {{--data:{userid:'{{auth()->id()}}',_token:'{{csrf_token()}}'},--}}
                        {{--headers: {--}}
                        {{--'X-PJAX':true,--}}
                        {{--'X-PJAX-Container':'#container',--}}
                        {{--'X-Requested-With':'XMLHttpRequest'--}}
                        {{--},--}}
                        {{--type:'get',--}}
                        {{--success:function (data) {--}}
                        {{--layer.open({--}}
                        {{--type: 1,--}}
                        {{--skin: 'layui-layer-rim', //加上边框--}}
                        {{--area: ['620px', '640px'], //宽高--}}
                        {{--content: data--}}
                        {{--});--}}
                        {{--}--}}
                        {{--});--}}
                    }
                });
                table.on('sort(test2)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                    table.reload('tess', {initSort: obj,where: {sort:{filed:obj.field, type:obj.type}}});
                });
                //监听显示操作
                form.on('checkbox(status)', function(obj){
                    var id=this.value;
                    var status=obj.elem.checked;
                    $.post('/admin/menu/editStatus',{id:id,status:status,_token:'{{csrf_token()}}'},function () {})
                });
            });
        }
    </script>
@stop
