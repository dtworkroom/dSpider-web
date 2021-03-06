<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,minimal-ui"/>
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-fullscreen" content="true">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="full-screen" content="yes">
    <title>{{$title??""}}</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    {{--<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.css" rel="stylesheet">--}}
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
        ;window.qs={!! isset($qs)?json_encode($qs):'{}' !!}
    </script>

    <style>
        @media (min-width: 768px) {
            .modal-sm {
                width: 400px;
            }
        }
        .modal-footer{
            border-top:none;
        }
        #spider{padding-bottom: 20px;}

        .table .glyphicon {
            margin-left: 7px;
        }

        .table > tbody > tr > td{
        vertical-align: middle;
        }

        html, body {
            background-color: #fff;
            color: #636b6f;
            font-weight: 100;
            font-size: 15px;
            font-family:  Helvetica, Microsoft Yahei, Hiragino Sans GB, WenQuanYi Micro Hei, sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        a{
            cursor: pointer;
        }

        select {
          width: 100px;
            height: 30px;
            background: #fff;
        }

        #app>.container,#app{
            min-height: 75vh;
        }

        /*清除ie的默认选择框样式清除，隐藏下拉箭头*/
        select::-ms-expand { display: none; }
    </style>

    @yield('head')

</head>
<body>
<div id="app">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">

                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav" id="nav">
                    <li><a href="{{url("/home")}}">我的应用</a></li>
                    <li><a href="{{url("/profile/spider")}}">我的爬虫</a></li>
                    <li><a href="{{url("/store")}}" target="_blank">{{ config('wording.store', 'Laravel') }}</a></li>
                    <li><a href="{{url("/document")}}">文档中心</a></li>
                    <li><a href="{{url("/md/help")}}">帮助</a></li>

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">

                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
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

    {{--alert--}}
    <div id="alert" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id='dlg-close' class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 id="dlg-title" class="modal-title">提示</h4>
                </div>
                <div class="modal-body">
                    <p id="alert-text">One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="dlg-cancel" class="btn btn-primary" data-dismiss="modal">取消</button>
                    <button type="button" id="dlg-ok" class="btn btn-default" data-dismiss="modal">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    @yield('content')
</div>
<div style="border-top: #e8e8e8 1px solid; text-align: center; padding: 40px;line-height: 2em; margin-top: 50px; color: #333; font-size: 14px;">
    Copyright © 2016-2017 {{config("app.name")}}(dspider.dtworkroom.com) All Rights Reserved.
</div>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<script src="{{ url('public/js/util.js')}}"></script>
@yield('footer')
</body>
</html>
