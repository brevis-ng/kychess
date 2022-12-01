<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>layuimini-单页版 v2 - 基于Layui的后台管理系统前端模板</title>
    <meta name="keywords" content="layuimini,layui,layui模板,layui后台,后台模板,admin,admin模板,layui mini">
    <meta name="description" content="layuimini基于layui的轻量级前端后台管理框架，最简洁、易用的后台框架模板，面向所有层次的前后端程序,只需提供一个接口就直接初始化整个框架，无需复杂操作。">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="{{ asset('layuimini/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('layuimini/lib/layui-v2.5.5/css/layui.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('layuimini/lib/font-awesome-4.7.0/css/font-awesome.min.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('layuimini/css/layuimini.css?v=2.0.6.1') }}" media="all">
    <link rel="stylesheet" href="{{ asset('layuimini/css/themes/default.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('layuimini/css/public.css') }}" media="all">
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style id="layuimini-bg-color">
    </style>
</head>
<body class="layui-layout-body layuimini-all">
<div class="layui-layout layui-layout-admin">

    <div class="layui-header header">
        <div class="layui-logo layuimini-logo layuimini-back-home"></div>

        <div class="layuimini-header-content">
            <a>
                <div class="layuimini-tool"><i title="展开" class="fa fa-outdent" data-side-fold="1"></i></div>
            </a>

            <!--电脑端头部菜单-->
            <!-- <ul class="layui-nav layui-layout-left layuimini-header-menu layuimini-menu-header-pc layuimini-pc-show">
            </ul> -->

            <!--手机端头部菜单-->
            <!-- <ul class="layui-nav layui-layout-left layuimini-header-menu layuimini-mobile-show">
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="fa fa-list-ul"></i> 选择模块</a>
                    <dl class="layui-nav-child layuimini-menu-header-mobile">
                    </dl>
                </li>
            </ul> -->

            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;">{{ LaravelLocalization::getCurrentLocaleNative() }}</a>
                    <dl class="layui-nav-child">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <dd>
                            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                            @if( hash_equals(LaravelLocalization::getCurrentLocale(), $localeCode) )
                            <i class="fa fa-check" style="color: #3ec483;"></i>
                            @endif
                            </a>
                        </dd>
                        @endforeach
                    </dl>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" data-refresh="刷新"><i class="fa fa-refresh"></i></a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" data-clear="清理" class="layuimini-clear"><i class="fa fa-trash-o"></i></a>
                </li>
                <li class="layui-nav-item mobile layui-hide-xs" lay-unselect>
                    <a href="javascript:;" data-check-screen="full"><i class="fa fa-arrows-alt"></i></a>
                </li>
                @auth
                <li class="layui-nav-item layuimini-setting">
                    <a href="javascript:;">{{ Auth::user()->name }}</a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a href="javascript:;" layuimini-content-href="page/user-password.html" data-title="{{ __('home.password_change') }}" data-icon="fa fa-gears">{{ __('home.password_change') }}<span class="layui-badge-dot"></a>
                        </dd>
                        <dd>
                            <hr>
                        </dd>
                        <dd>
                            <a href="{{ route('auth.destroy') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="login-out">{{ __('home.logout') }}</a>
                            <form id="logout-form" action="{{ route('auth.destroy') }}" method="POST" style="display: none;">@csrf</form>
                        </dd>
                    </dl>
                </li>
                @endauth
                <li class="layui-nav-item layuimini-select-bgcolor" lay-unselect>
                    <a href="javascript:;" data-bgcolor="配色方案"><i class="fa fa-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
    </div>

    <!--无限极左侧菜单-->
    <div class="layui-side layui-bg-black layuimini-menu-left">
    </div>

    <!--初始化加载层-->
    <div class="layuimini-loader">
        <div class="layuimini-loader-inner"></div>
    </div>

    <!--手机端遮罩层-->
    <div class="layuimini-make"></div>

    <!-- 移动导航 -->
    <div class="layuimini-site-mobile"><i class="layui-icon"></i></div>

    <div class="layui-body">

        <div class="layui-card layuimini-page-header layui-hide">
            <div class="layui-breadcrumb layuimini-page-title">
            </div>
        </div>

        <div class="layuimini-content-page">
        </div>

    </div>

</div>
<script src="{{ asset('layuimini/lib/layui-v2.5.5/layui.js') }}" charset="utf-8"></script>
<script src="{{ asset('layuimini/js/lay-config.js?v=2.0.0') }}" charset="utf-8"></script>
<script>
    layui.use(['jquery', 'layer', 'miniAdmin'], function () {
        var $ = layui.jquery,
            layer = layui.layer,
            miniAdmin = layui.miniAdmin;

        var options = {
            iniUrl: "{{ route('home.menu') }}",//"/layuimini/api/init.json",    // 初始化接口
            clearUrl: "/layuimini/api/clear.json", // 缓存清理接口
            renderPageVersion: false,    // 初始化页面是否加版本号
            bgColorDefault: 3,      // 主题默认配置
            multiModule: true,          // 是否开启多模块
            menuChildOpen: false,       // 是否默认展开菜单
            loadingTime: 0,             // 初始化加载时间
            pageAnim: true,             // 切换菜单动画
        };
        miniAdmin.render(options);
    });
</script>
</body>
</html>
