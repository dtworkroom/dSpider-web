<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script src="//cdn.bootcss.com/vue/2.1.6/vue.js"></script>
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
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
            .navbar{
                padding:0 50px;
            }
        }
        .modal-footer{
            border-top:none;
        }
        #spider{padding-bottom: 20px;}

        .table .glyphicon {
            margin-left: 7px;
        }
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-weight: 100;
            font-size: 15px;
            font-family:  Helvetica, Microsoft Yahei, Hiragino Sans GB, WenQuanYi Micro Hei, sans-serif;
            min-height: 100vh;
            margin: 0;
            word-wrap:break-word;
        }

        body{ padding-top: 51px;}

        a{
            cursor: pointer;
        }



    </style>

    @yield('head')

</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid" >
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


                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav" id="nav">
                        <li><a href="{{url("/document")}}">文档中心</a></li>
                        <li><a href="#">SDK下载</a></li>
                        <li><a href="#">脚本市场</a></li>
                        <li><a href="#">帮助</a></li>

                    </ul>
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
<!-- Scripts -->
<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ url('public/js/util.js')}}"></script>
@yield('footer')
</body>
</html>
