@extends('admin.layout')
@section('main')
    <style>
        .layui-form-item .layui-input-block {
            width: 270px;
        }
    </style>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">公司ID:</label>
            <div class="layui-input-block">
                <input type="text" value="{{$data->company_id}}" name="company_id" placeholder="请输入公司ID"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公司名称:</label>
            <div class="layui-input-block">
                <input type="text" value="{{$data->company}}" name="company" placeholder="请输入公司名称" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">姓名:</label>
            <div class="layui-input-block">
                <input type="text" value="{{$data->name}}" name="name" placeholder="请输入姓名" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号:</label>
            <div class="layui-input-block">
                <input type="text" value="{{$data->phone}}" name="phone" placeholder="请输入手机号" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">性别:</label>
            <div class="layui-input-block">
                @if($data->sex==1)
                    <input type="radio" name="sex" value="1" title="男" checked>
                    <input type="radio" name="sex" value="0" title="女">
                @else
                    <input type="radio" name="sex" value="1" title="男">
                    <input type="radio" name="sex" value="0" title="女" checked>
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">等级:</label>
            <div class="layui-input-inline">
                <select name="grade">
                    <option value="">请选择等级</option>
                    @foreach($grade as $v)
                        @if($v['id']==$data['grade'])
                            <option value="{{$v['id']}}" selected>{{$v['name']}}</option>
                        @else
                            <option value="{{$v['id']}}">{{$v['name']}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline">
                @if($data->autoex==1)
                    <input type="radio" name="autoex" value="1" title="固定等级" checked>
                @else
                    <input type="radio" name="autoex" value="1" title="固定等级">
                @endif
            </div>
            <div class="layui-input-inline">
                @if($data->autoex==1)
                    <input type="radio" name="autoex" value="0" title="自动升级">
                @else
                    <input type="radio" name="autoex" value="0" title="自动升级" checked>
                @endif
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">积分:</label>
            <div class="layui-input-block">
                <label class="layui-form-label integral">{{$data->integral}}</label>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱:</label>
            <div class="layui-input-block">
                <input type="email" value="{{$data->email}}" name="email" placeholder="请输入邮箱" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">区域:</label>
            <div class="layui-input-block">
                <select name="area">
                    <option value="">请选择区域</option>
                    @foreach($area as $v)
                        @if($data->area==$v->id)
                            <option value="{{$v->id}}" selected>{{$v->value}}</option>
                        @else
                            <option value="{{$v->id}}">{{$v->value}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">部门:</label>
            <div class="layui-input-block">
                <select name="department">
                    <option value="">请选择部门</option>
                    @foreach(explode(',',$department[0]['department']) as $v)
                        @if($data->department==$v)
                            <option value="{{$v}}" selected>{{$v}}</option>
                        @else
                            <option value="{{$v}}">{{$v}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">职务:</label>
            <div class="layui-input-block">
                <select name="duty">
                    <option value="">请选择职务</option>
                    @foreach(explode(',',$department[0]['duty']) as $v)
                        @if($data->duty==$v)
                            <option value="{{$v}}" selected>{{$v}}</option>
                        @else
                            <option value="{{$v}}">{{$v}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">证件类型:</label>
            <div class="layui-input-block">
                <input type="text" value="{{$data->ide}}" name="ide" placeholder="请输入证件类型" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">证件号码:</label>
            <div class="layui-input-block">
                <input type="text" value="{{$data->idenum}}" name="idenum" placeholder="请输入身份证号码" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申请时间:</label>
            <div class="layui-input-block">
                <input type="text" value="{{$data->created_at}}" name="created_at" class="layui-input" id="test"
                       placeholder="yyyy-MM-dd HH:mm:ss">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
            </div>
        </div>
    </form>
    <script>
        layui.use(['form', 'laydate'], function () {
            var form = layui.form
                , layer = layui.layer
                , laydate = layui.laydate;
            laydate.render({
                elem: '#test'
                , type: 'datetime'
            });
            form.render();
            form.on('submit(demo1)', function (data) {
                $.ajax({
                    url: '{{url()->current()}}',
                    data: {data: data.field, type: 1, _token: '{{csrf_token()}}'},
                    type: 'PUT',
                    success: function (data) {
                        if (data.status) {
                            window.location.href = '/admin/user';
                        }
                    }
                })
                return false;
            });
        })

    </script>
@stop