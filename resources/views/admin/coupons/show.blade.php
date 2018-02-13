@extends('admin.layout')
@section('main')
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">优惠券名称:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="required" autocomplete="off" placeholder="请输入优惠券名称"
                       value="{{$data['name'] or ''}}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">面值:</label>
            <div class="layui-input-inline">
                <input type="text" name="value" lay-verify="required" placeholder="请输入面值" autocomplete="off"
                       value="{{$data['value'] or ''}}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">注册赠送:</label>
            <div class="layui-input-inline">
                @if(isset($data['reggive'])&&$data['reggive']==1)
                    <input type="radio" name="reggive" value="1" title="是" checked>
                    <input type="radio" name="reggive" value="0" title="否">
                @else
                    <input type="radio" name="reggive" value="1" title="是">
                    <input type="radio" name="reggive" value="0" title="否" checked>
                @endif
            </div>
        </div>
        <div class="layui-form-item" pane="">
            <label class="layui-form-label">使用限制:</label>
            <div class="layui-input-block">
                <input type="checkbox" lay-skin="primary" value="1" title="满" checked>
                <input style="display: inline;width:100px;position: relative;left: -10px;" type="text" name="limit"
                       value="{{$data['limit'] or ''}}" autocomplete="off"
                       class="layui-input">元,即可使用
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">有效日期:</label>
            <div class="layui-form-mid layui-word-aux">
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="text" name="start" id="date1" value="{{$data['start'] or ''}}" lay-verify="date"
                           placeholder="开始时间" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">~</div>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="text" name="end" id="date"
                           value="{{$data['end'] or ''}}" lay-verify="date"
                           placeholder="开始时间" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">描述:</label>
            <div style="width: 400px" class="layui-input-block">
                    <textarea name="describe"
                              placeholder="请输入内容" class="layui-textarea">{{$data['describe'] or ''}}</textarea>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
            </div>
        </div>
    </form>
    <script>
        layui.use(['form', 'layedit', 'laydate'], function () {
            var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;

            //日期
            laydate.render({
                elem: '#date'
            });
            laydate.render({
                elem: '#date1'
            });
            form.on('submit(demo1)', function (data) {
                $.ajax({
                    url: '{{url()->current()}}',
                    data: {_token: '{{csrf_token()}}', data: data.field},
                    type: 'PUT',
                    success: function (data) {
//                            window.history.back();
                        console.log(data);
                        if (data.status == 1) {
                            window.location.href = '/admin/coupons'
//                            layer.closeAll();
//                            layer.msg('提交成功');
                        }
                    }
                });
                return false;
            });
            //创建一个编辑器
            var editIndex = layedit.build('LAY_demo_editor');
            form.render();
        });
    </script>
@stop