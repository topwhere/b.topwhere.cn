<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商户管理系统</title>
    <link rel="stylesheet" href="/vendor/layui/css/layui.css" media="all">
    {{--<link rel="stylesheet" href="/css/bootstrap.min.css">--}}
    {{--<link rel="stylesheet" href="/css/bootstrap-responsive.css">--}}
    <script type="text/javascript"
            src="http://api.map.baidu.com/api?v=2.0&ak=nr4kRz07dEX1MewduP1lSwDW62SGROHO"></script>
    <script src="/vendor/layui/layui.js"></script>
    <script src="/js/jquery-1.11.0.min.js"></script>
    <script src="/js/jquery.pjax.js"></script>
    <script src="/js/admin.js"></script>
    @yield('header')
    <style>
        .layui-layout-admin {
            overflow: hidden
        }

        .header .logo {
            float: left;
        }

        .header .layui-nav {
            position: absolute;
            right: 0;
            top: 0;
            padding: 0;
        }

        .layui-tab-brief {
            position: relative;
            left: 0;
            right: 0;
        }

        .layui-tab-title li a {
            display: -webkit-inline-box;
            height: 40px;
        }

        .clear-float {
            clear: both
        }

        .layui-header {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            height: 60px;
        }

        .content {
            position: absolute;
            top: 66px;
            left: 205px;
            width: 85%;
        }
    </style>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header header">
        <a class="logo" href="/">
            {{--<img src="/static/img/logo-219.png" alt="layui">--}}
        </a>
        <ul class="layui-nav topmenu" style="left: 300px">
            @inject('Common', 'App\Services\CommonService')
            @foreach($Common->getTopMenu as $v)
                @permission($v->name)
                <li class="layui-nav-item "><a href="javascript:void(0);" data-id="{{$v->id}}"
                                               onclick="topMenu.bind(this)()" data-pjax>{{$v->display_name}}</a></li>
                @endpermission
            @endforeach
            {{--<li class="layui-nav-item layui-this">--}}
            {{--<a href="javascript:;">产品</a>--}}
            {{--<dl class="layui-nav-child">--}}
            {{--<dd><a href="">选项1</a></dd>--}}
            {{--<dd><a href="">选项2</a></dd>--}}
            {{--<dd><a href="">选项3</a></dd>--}}
            {{--</dl>--}}
            {{--</li>--}}
        </ul>
        <ul class="layui-nav">
            <li class="layui-nav-item">
                <a href="javascript:;"><img src="http://t.cn/RCzsdCq" class="layui-nav-img">{{auth()->user()->name}}</a>
                <dl class="layui-nav-child">
                    {{--<dd><a href="javascript:;">安全管理</a></dd>--}}
                    <dd><a href="{{route('admin.logout')}}">退出登录</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    <div class="layui-side layui-bg-black nav-left">
        <div class="layui-side-scroll">
            @foreach($Common->getMenu as $v)
                @if($v->pid==0)
                    <ul id="letfMenu{{$v->id}}" class="layui-nav layui-nav-tree layui-inline" lay-filter=""
                        style="margin-right: 10px;display: none">
                        @foreach($Common->getMenu as $yi)
                            @if($yi->pid==$v->id)
                                @permission($yi->name)
                                <li class="layui-nav-item layui-nav-itemed">
                                    <a href="javascript:;">{{$yi->display_name}}</a>
                                    @foreach($Common->getMenu as $er)
                                        @if($er->pid==$yi->id)
                                            <dl class="layui-nav-child">
                                                @permission($er->name)
                                                <dd>
                                                    <a class="site-active @if(url()->current()==url($er->url)) layui-this @endif "
                                                       href="{{url($er->url)}}" data-pjax>{{$er->display_name}}</a></dd>
                                                @endpermission
                                                {{--@permission('site/index')<dd><a class="site-active" href="{{url('/admin/menu')}}" data-pjax >型号管理</a></dd>@endpermission--}}
                                            </dl>
                                        @endif
                                    @endforeach
                                </li>
                                @endpermission
                            @endif
                        @endforeach
                    </ul>
                @endif
                {{--<li class="layui-nav-item"><a href="">社区</a></li>--}}
            @endforeach
            {{--@yield('daohang')--}}
        </div>
    </div>
    <div class="content">
        <div class="layui-tab" lay-filter="demo" lay-allowclose="true" style="margin: 10px 0 0 0px;">
            <ul class="layui-tab-title" id="nav-rap"></ul>
        </div>
        <div class="layui-tab layui-tab-brief main-content" id="main-con">
            @yield('main')
        </div>
    </div>
    <div class="clear-float"></div>
</div>
</body>
<script>
    $(document).pjax('a[data-pjax]', '#main-con');
    //    顶部菜单 状态
    if (!localStorage.getItem('topMenu')) {
        $('.topmenu >li:first').addClass('layui-this');
        dataid = $('.topmenu >li:first a').data('id');
        $('#letfMenu' + dataid).css('display', 'block')
    } else {
        var topmenu = localStorage.getItem('topMenu');
        $('a[data-id=' + topmenu + ']').parent().addClass('layui-this');
        $('#letfMenu' + topmenu).css('display', 'block')
    }

    function topMenu() {
        dataid = $(this).data('id');
        $('#letfMenu' + dataid).css('display', 'block');
        $('#letfMenu' + dataid).siblings().css('display', 'none');
        localStorage.setItem('topMenu', dataid);
    }

    var layer;
    layui.use(['element', 'layer'], function () {
        layer = layui.layer;
        var $ = layui.jquery, element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块
        $('.site-active').on('click', function () {
            var title = $(this).html();
            var href = $(this).attr('href');
            var exis = false;
            $('#nav-rap li').each(function () {
                if ($(this).attr('lay-id') == href) {
                    exis = true;
                }
            });
            if (exis) {
                element.tabChange('demo', href);
            } else {
                element.tabAdd('demo', {
                    title: '<a href="' + href + '" data-pjax >' + title + '</a>'//用于演示
                    , id: href //实际使用一般是规定好的id，这里以时间戳模拟下
                });
                element.tabChange('demo', href);
            }
        });
    });
</script>
</html>