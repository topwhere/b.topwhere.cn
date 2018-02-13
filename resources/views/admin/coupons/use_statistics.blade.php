@extends('admin.layout')
@section('main')
    <a href="" type="button" class="layui-btn layui-btn-normal">按券查看</a>
    <table id="demo" lay-filter="test"></table>
    <script>
        layui.use('table', function () {
            var table = layui.table
                , form = layui.form;
            table.render({
                elem: '#demo'
                , height: 315
                , url: '?_token={{csrf_token()}}' //数据接口
                , method: 'post'
                , page: true
                , cols: [[ //表头
                    {field: 'name', title: '名称', width: 150}
                    , {field: 'value', title: '面值', width: 60}
                    , {field: 'limit', title: '最低消费', width: 100}
                    , {field: 'start', title: '有效期开始', width: 120}
                    , {field: 'end', title: '有效期结束', width: 120}
                    , {field: 'describe', title: '描述', width: 150}
                    , {field: 'num', title: '发送总数', width: 150}
                    , {field: 'no_use_num', title: '未使用', width: 150}
                ]]
            });
        })
    </script>
@endsection