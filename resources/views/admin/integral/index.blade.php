@extends('admin.layout')
@section('main')
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">注册规则:</label>
            <div class="layui-form-mid layui-word-aux">
                注册即送
            </div>
            <div class="layui-input-inline">
                <input type="text" value="{{$reg[0]['value'] or ''}}" name="reg" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                积分
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">获取规则:</label>
            <div class="layui-form-mid layui-word-aux">
                每消费
            </div>
            <div class="layui-input-inline">
                <input type="text" value="{{$consumption[0]['value'] or ''}}" name="consumption" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                元,可得
            </div>
            <div class="layui-input-inline">
                <input type="text" value="{{$consumption_integral[0]['value'] or ''}}" name="consumption_integral"
                       class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                积分
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">使用规则:</label>
            <div class="layui-form-mid layui-word-aux">
                每使用
            </div>
            <div class="layui-input-inline">
                <input type="text" value="{{$use_integral[0]['value'] or ''}}" name="use_integral" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                积分,抵扣
            </div>
            <div class="layui-input-inline">
                <input type="text" value="{{$use[0]['value'] or ''}}" name="use" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                元
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
            </div>
        </div>

    </form>
    <script>
        layui.use(['form'], function () {
            var form = layui.form
            //监听提交
            form.on('submit(demo1)', function (data) {
                $.ajax({
                    url: '{{url()->current()}}/0',
                    data: {data: data.field, '_token': '{{csrf_token()}}'},
                    type: 'PUT',
                    success: function (data) {
                        if (data.status == 1) {
                            window.location.href = '/admin/integral';
                        }
                    }
                });
                return false;
            });


        });
    </script>

@stop