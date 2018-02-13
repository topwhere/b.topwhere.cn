@extends('admin.layout')
@section('main')

    <form class="layui-form demoTable" action="">
        {{--2个隐藏区域--type代表的是类型,value代表的是值--}}
        <input type="hidden" name="type" class="type">
        <input type="hidden" name="value" class="value">
        {{--2个隐藏区域结束--}}
        {{--选择发送范围区域--}}
        <div class="layui-form-item">
            <div class="layui-input-block" style="font-size: 16px;">选择发送范围</div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input lay-filter="radiobox" type="radio" name="name" value="all" data-type="all" title="全部会员">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                @foreach($level as $d)
                    <input lay-filter="radiobox" type="radio" name="name" value="{{$d->id}}" data-type="grade"
                           title="{{$d->name}}">
                @endforeach
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input lay-filter="radiobox" type="radio" name="name" value="bai" data-type="bai" title="白名单会员">
            </div>
        </div>
        {{--选择发送范围区域结束--}}
        {{--选择发送人区域--}}
        <div class="layui-form-item">
            <div class="layui-input-block" style="font-size: 16px;">选择发送人</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
                <input type="text" name="men_tel" lay-verify="title" id="demoReload" autocomplete="off"
                       placeholder="输入会员姓名/电话查询"
                       class="layui-input">
            </div>
            <div class="layui-input-inline">
                <button class="layui-btn " type="button" data-type="reload">查询</button>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <table class="layui-hide" id="user"></table>
            </div>
        </div>
        {{--选择发送人区域结束--}}
        {{--发送优惠券--}}
        <div class="layui-form-item">
            <div class="layui-input-block ">
                <button class="layui-btn" type="button" data-type="send_coupon">确定</button>
                <button class="layui-btn layui-btn-primary" type="reset">取消</button>
            </div>
        </div>
        {{--发送优惠券结束--}}
    </form>
    <script>
        layui.use(['form', 'table'], function () {
            var form = layui.form,
                table = layui.table;
            form.render();
            //会员等级按钮的执行---给2个隐藏域进行相应的赋值，然后发给后台做判断
            form.on('radio(radiobox)', function (data) {
                $('.type').val($(data.elem).attr('data-type'));
                $('.value').val(data.value);
            });
            table.render({
                elem: '#user'
                , width: 700
                , height: 200
                , url: '/admin/search?_token={{csrf_token()}}' //数据接口
                , method: 'post'
                , cols: [[ //表头
                    {type: 'checkbox'}
                    , {field: 'name', title: '姓名', width: 150}
                    , {field: 'phone', title: '电话', width: 150}
                    , {field: 'grade_name', title: '等级', width: 105}
                    , {field: 'integral', title: '积分', width: 80}
                    , {field: 'total', title: '消费金额(元)', width: 160}
                ]]
                , id: 'userReload'
                , page: true
            });
            var $ = layui.$, active = {
                //赠送优惠券按钮
                send_coupon: function () { //获取选中数据
                    tem = [];
                    var checkStatus = table.checkStatus('userReload')
                        , data = checkStatus.data;
                    type = $('.type').val();
                    value = $('.value').val();
                    if (data.length) {
                        for (i = 0; i < data.length; i++) {
                            tem[i] = {id: data[i]['id']};
                        }
                        type = 0;
                    }
                    $.ajax({
                        url: '{{url()->current()}}',
                        data: {data: {tem, type: type, value: value}, _token: '{{csrf_token()}}'},
                        type: 'post',
                        success: function (data) {
                            if (data.status) {
                                layer.msg('发送成功');
                                window.location.href = '/admin/coupons';
                            }
                        }
                    });

                },
                //查询出人员名单按钮
                reload: function () {
                    var demoReload = $('#demoReload');
                    table.reload('userReload', {
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
                }
            };
            $('.demoTable .layui-btn').on('click', function (data) {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
        })

    </script>
@stop