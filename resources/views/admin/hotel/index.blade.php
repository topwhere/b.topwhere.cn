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
                        <option value="-1">全部酒店</option>
                        <option value="0" >营业中</option>
                        <option value="1">下架</option>
                    </select>  
                </div>
                <div class="layui-input-inline" style="margin-left: 2px;padding: 2px;width: 100px"> 
                    <select name="province" class="layui-select" style="display: block" onchange="getCityCode(this)">
                        <option value="-1">请选择省</option>
                        @foreach ($province as $item)
                            <option value="{{ $item->ProvinceId }}">{{ $item->ProvinceName }}</option>
                        @endforeach                        
                    </select>
                </div>
                <div class="layui-input-inline" style="margin-left: 2px;padding: 2px;width: 100px;margin-right: 80px"> 
                    <select name="city" class="layui-select city" style="display: block">
                         <option value="-1">请选择市</option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="keywords" placeholder="输入酒店名称进行搜索"
                           autocomplete="off">
                </div>
                <button class="layui-btn" data-type="reload" type="submit">搜索</button>                
            </div>            
            <a href="{{ url('admin/addHotel/0') }}" class="layui-btn" style="margin: -24px 12%">添加酒店</a>
        </div>
    </form>
    <div class="layui-table-box">
        <div class="layui-table-header">
            <table class="layui-table" cellspacing="0" cellpadding="0" border="0">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>酒店名称</th>
                        <th>电话</th>
                        <th>地址</th>
                        <th>简介</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hotelist as $item)
                        <tr>
                            <td>{{ $item->HotelId }}</td>
                            <td>{{ $item->HotelName }}</td>
                            <td>{{ $item->Tel }}</td>
                            <td>{{ $item->Address }}</td>
                            <td>{{ $item->Features }}</td>
                            <td>
                                <select hid="{{ $item->HotelId }}" sale="{{ $item->IsSale }}" onchange="upIsSale(this)">
                                    <option value="0" @if($item->IsSale == 0) selected="selected"  @endif >营业中</option>
                                    <option value="1" @if($item->IsSale == 1) selected="selected"  @endif >下架</option>
                                </select>
                            </td>
                            <td>
                                <a href="{{ url('admin/addHotel/'. $item->HotelId .'') }}" style="cursor: pointer;">修改</a>
                                <a class="del" onclick="delHotel({{$item->HotelId}})" style="cursor: pointer;">删除</a>
                                <a href="{{ url('admin/rooms/'. $item->HotelId .'') }}" style="cursor: pointer;">查看房型</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: right;">{!! $hotelist->links() !!}</div>
        </div>
    </div>
@stop

<script type="text/javascript">
    function getCityCode(obj) {        
        var ProvinceId = $(obj).val();
        if(ProvinceId > 0 ) {
            $.post("{{url('admin/getCityCode')}}",{ProvinceId:ProvinceId,_token:'{{csrf_token()}}'},function(data){
                if(data) {
                    var html = [];
                    for(var i=0;i<data.length;i++) {
                        var opt = data[i];
                        html.push("<option value="+opt.CityCode+">"+opt.CityName+"</option>");
                    }
                    $(".city").html(html.join(''));
                }
            })
        }
    }    

    function upIsSale(obj) {
        var IsSale  = $(obj).attr("sale");
        var HotelId = $(obj).attr("hid");
        if(IsSale == 0) {
            IsSale = 1;
        }else{
            IsSale = 0;
        }

        $.post("{{ url('admin/upIsSale') }}",{HotelId:HotelId,IsSale:IsSale,_token:'{{csrf_token()}}'},function(data) {
            if(data.status == 1) {
                alert(data.msg);
            }
        })
    }

    function delHotel(HotelId) {
        if(confirm("确定要删除吗？")) {
            $.post("{{ url('admin/delHotel') }}",{HotelId:HotelId,_token:'{{csrf_token()}}'},function(data){
                if(data.status == 1) {
                    alert(data.msg);
                    location.href = "{{ url('admin/hotel') }}";
                }
            })
        }
    }


</script>