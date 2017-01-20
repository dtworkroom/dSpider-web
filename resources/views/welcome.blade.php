<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,minimal-ui"/>
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-fullscreen" content="true">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="full-screen" content="yes">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ url('public/css/index.css')}}">
</head>
<body>

<div class="header">
    <div id="stage"></div>
    <div class="logo-c">
        <span class="name">小人数据<br/> <span class="en-name" style="padding-left: 3px;"> XIAOREN DATA</span></span>
    </div>
    <div style="position: absolute; top:10px; width: 100%;">
        <nav class="navbar navbar-default" style="background: none"  >
            <div class="container-fluid" >
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">


                    <ul class="nav navbar-nav navbar-right">
                        <!-- Left Side Of Navbar -->
                        <li><a href="{{url("/document")}}">文档中心</a></li>
                        <li><a href="#">SDK下载</a></li>
                        <li><a href="#">脚本市场</a></li>
                        <li><a href="#">帮助</a></li>

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">登录</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{url("/home")}}">个人中心</a>
                                        <a href="{{ url('/logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            退出登录
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="header-text">
        <span id="logo" class="glyphicon glyphicon-globe"></span><br>
        客户端爬取解决方案
    </div>
</div>

<div id="content" style="position: relative">
    <canvas id="spider-canvas" style="position: absolute; left: 0; top:0; z-index: -1"></canvas>
    <div class="section clearfix" style="position: relative; padding-bottom: 100px; text-align: center">
        <div class="title" style="color:#408cce">DSpider简介</div>
        <div class="row intro">
            <div class="row col-md-10 col-md-offset-1 " id="features">
                <div style="" class="col-md-4">
                    <div class="title">突破IP限制</div>
                    与传统后台爬取不同的是,客户端每个设备ip都不相同,这将从根本上解决目标网站对于特定IP请求次数的限制。
                </div>
                <div style="" class="col-md-4">
                    <div class="title">使用JavaScript</div>
                    爬取脚本使用Javascript语言,前端开发者可以直接上手,这不仅使操作网页更加容易,而且极大的提高了开发效率。
                </div>
                <div style="" class="col-md-4">
                    <div class="title">云管理平台</div>
                    强大的云控平台,随时随地更新、发布脚本,监控应用状态,同时包含配置下发、错误分析、结果统计等众多功能。
                </div>
            </div>
        </div>
        <a class="btn-m" id="more" href="document/introduction"
             style="z-index: 2; position: absolute; bottom: 60px; left: 50%;margin-left: -100px;width: 200px;">
            了解更多 》
        </a>
    </div>

    <div class="section">
        <div class="title">
            海量爬取脚本,自由选择
        </div>
        <div style="position: relative;" class="introduce clearfix">
            <div class="row">
                <li class="col-md-3 col-xs-6">
                    <div class="circle"><span class="glyphicon glyphicon-credit-card"></span></div>
                    <div class="p1">信用卡账单
                        <sapn class="p2">45家银行</sapn>
                    </div>
                </li>
                <li class="col-md-3 col-xs-6">
                    <div class="circle"><span class="glyphicon glyphicon-phone"></span></div>
                    <div class="p1">运营商
                        <sapn class="p2">移动/联通/电信</sapn>
                    </div>
                </li>
                <li class="col-md-3 col-xs-6">
                    <div class="circle"><span class="glyphicon glyphicon-shopping-cart"></span></div>
                    <div class="p1">电商
                        <sapn class="p2">京东/支付宝/淘宝</sapn>
                    </div>
                </li>
                <li class="col-md-3 col-xs-6">
                    <div class="circle"><span class="glyphicon glyphicon-envelope"></span></div>
                    <div class="p1">邮箱
                        <sapn class="p2">QQ/网易/新浪</sapn>
                    </div>
                </li>
            </div>

            <a  href="#" class="btn-m">
                脚本商店发现更多 》
            </a>

        </div>
    </div>

    <div class="section">
        <div class="title">SDK下载</div>
        <div style="padding: 20px; line-height: 2em">我们提供了IOS/ANDROID SDK, 同时也提供了PC测试工具。</div>

        <a href="#" class="btn-m">
            下载中心 》
        </a>
    </div>

    <div class="section" id="footer">
        <div class="row" style="margin-left: 0">
            <div class="col-md-8 col-md-offset-2 row">
                <div class="col-md-4">
                    <a href="http://www.jianshu.com/u/e3f58786fce8">
                    <div><img class="footer-img" src="{{ url('public/img/author.png')}}"></div>
                    相关博客
                    </a>
                </div>
                <div class="col-md-4">
                    <div> <img class="footer-img" src="{{ url('public/img/demons-du.png')}}" style="border-radius: 0; "></div>
                    技术支持
                </div>
                <div class="col-md-4">
                    <div><span class="glyphicon glyphicon-phone-alt footer-img" style="font-size: 50px; line-height: 120px;  background-color: #111"></span></div>
                    商务合作
                </div>
            </div>
        </div>
        {{--<div style="color:#408cce; text-decoration: underline">使DSpider前必读。</div>--}}
    </div>

</div>
<script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ url('public/js/index.js')}}"></script>
</body>
</html>