<form class="layui-form" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">等级:</label>
        <div class="layui-input-inline">
            <select name="grade">
                <option value="" selected>请选择等级</option>
                @foreach($grade as $v)
                    <option value="{{$v['id']}}">{{$v['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="layui-input-inline">
            <input type="radio" name="autoex" value="1" title="固定等级">
        </div>
        <div class="layui-input-inline">
            <input type="radio" name="autoex" value="0" title="自动升级">
        </div>
    </div>
    <div class="layui-input-block">
        <button class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
    </div>
</form>
<script>
    layui.use(['form', 'table'], function () {
        var form = layui.form,
            table = layui.table,
            layer = layui.layer;
        form.on('submit(demo1)', function (data) {
            $.ajax({
                url: '/admin/user_baimingdan',
                data: {_token: '{{csrf_token()}}', data: data.field, tem: '{{$tem}}'},
                type: 'PUT',
                success: function (data) {
                    if (data.status) {
                        table.reload('tess', {
                            page: {
                                curr: 1 //重新从第 1 页开始
                            }
                        });
                        layer.closeAll();
                        layer.msg('保存成功');

                    }
                }
            })
            return false;
        });
        form.render();
    });
</script>