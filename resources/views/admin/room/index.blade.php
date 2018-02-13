@extends('admin.layout')
@section('main')
    <?php $name = '酒店'?>
     <style>.layui-table-tips-main, .layui-table-tips-main img {width: 300px;height: 300px;max-height: 300px;margin: 0;padding: 0;}
     <style type="text/css">
        #pull_right{
            text-align:center;
        }
        .pull-right {
            /*float: left!important;*/
        }
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }
        .pagination > li {
            display: inline;
        }
        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #428bca;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            color: #2a6496;
            background-color: #eee;
            border-color: #ddd;
        }
        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #428bca;
            border-color: #428bca;
        }
        .pagination > .disabled > span,
        .pagination > .disabled > span:hover,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > a,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }
        .clear{
            clear: both;
        }
    </style>
    </style>
    <form class="layui-form demoTable" action="" method="get">
        <input type="hidden" id="hidden" value="-1">
        <div class="layui-form-item">
            <div class="layui-inline">                
                <div class="layui-input-inline" style="margin-left: 15px;width: 100px">                    
                    <select name="status" class="layui-select" style="display: block">
                        <option value="-1">全部房型</option>
                        <option value="2" @if(isset($params['status'])&&$params['status']== 2) selected="selected" @endif>营业中</option>
                        <option value="1" @if(isset($params['status'])&&$params['status']== 1) selected="selected" @endif>下架</option>
                    </select>  
                </div>
                <div class="layui-input-inline" style="margin-left: 2px;padding: 2px;width: 150px"> 
                    <select name="hotelid" class="layui-select" style="display: block" onchange="getCityCode(this)">
                        <option value="-1">请选择酒店</option>
                        @if(isset($hotelist))
                            @foreach ($hotelist as $item)
                                <option value="{{ $item->HotelId }}" @if(isset($params['hotelid'])&&$params['hotelid']== $item->HotelId) selected="selected" @endif>{{ $item->HotelName }}</option>
                            @endforeach
                        @endif                        
                    </select>
                </div>
                <button class="layui-btn" data-type="reload" type="submit">搜索</button>                
            </div>            
            <a @if(isset($hotelid)) href='{{ url("admin/addRooms/0/$hotelid") }}' @else href="{{ url('admin/addRooms/0/0') }}"  @endif class="layui-btn" style="margin: -24px 12%">添加房型</a>
        </div>
    </form>
    <div class="layui-table-box">
        <div class="layui-table-header">
            <table class="layui-table" cellspacing="0" cellpadding="0" border="0">
                <thead>
                    <tr>                        
                        <th>酒店名称</th>
                        <th>房型名称</th>
                        <th>门市价格</th>
                        <th>会员价格</th>
                        <th>预定周期</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($roomlist))
                        @foreach($roomlist as $item)
                        <tr>
                            <td>{{ $item->HotelName }}</td>
                            <td>{{ $item->Name }}</td>
                            <td>{{ $item->TotalRate }}</td>
                            <td>{{ $item->MerPrice }}</td>
                            <td>{{ $item->Week ? $item->Week : "无限制"}}</td>
                            <td> 
                                <select hid="{{ $item->id }}" sale="{{ $item->Status }}" onchange="upStatus(this)">
                                    <option value="1" @if($item->Status == 1) selected="selected"  @endif >营业中</option>
                                    <option value="0" @if($item->Status == 0) selected="selected"  @endif >下架</option>
                                </select>
                            </td>
                            <td>
                                <a href="{{ url('admin/addRooms/'. $item->id .'/'. $item->HotelId .'') }}" style="cursor: pointer;">修改</a>
                                <a class="del" onclick="delRooms({{$item->id}})" style="cursor: pointer;">删除</a>
                            </td>
                        </tr>
                        @endforeach
                    @endif    
                </tbody>
            </table>
           
        </div>
    </div>
@stop

<script type="text/javascript">
    function upStatus(obj) {
        var status  = $(obj).attr("sale");
        var id = $(obj).attr("hid");
        if(status == 0) {
            status = 1;
        }else{
            status = 0;
        }

        $.post("{{ url('admin/upStatus') }}",{id:id,status:status,_token:'{{csrf_token()}}'},function(data) {
            if(data.status == 1) {
                alert(data.msg);
            }
        })
    }

    function delRooms(id) {
        if(confirm("确定要删除吗？")) {
            $.post("{{ url('admin/delRooms') }}",{id:id,_token:'{{csrf_token()}}'},function(data){
                if(data.status == 1) {
                    alert(data.msg);
                    location.href = location.href;
                }
            })
        }
    }

</script>