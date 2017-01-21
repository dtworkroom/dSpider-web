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
    <title>脚本市场</title>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    {{--<link rel="stylesheet" href="{{ url('public/css/index.css')}}">--}}
</head>
<style>
    body {
        color: #666;
        font-weight: 300;
        position: relative;
    }
    .navbar-default .navbar-nav>.active>a,
    .navbar-default .navbar-nav>.active>a:focus,
    .navbar-default .navbar-nav>.active>a:hover,
    #navbar-brand {
        color: #333;
    }

    @media (min-width: 768px) {

    }

    .grid .row {
        padding: 16px;
    }

    .grid .row:not(:first-child) {
        top: -33px;
        position: relative;
    }

    .grid .row [class ^="col-"] {
        padding: 20px 16px;
        height: 165px;
        border: 1px solid #e8e8e8;
        transition: all .3s;
    }

    .grid .row [class ^="col-"]:hover {
      background: #f8f8f8;
    }

    .grid .row img{
        height: 60px;
        float: left;
        opacity: .9;
    }
    .s-cap{
        float: left;
        margin-left: 10px;
    }
    .s-title{
        font-size: 16px;
        color: #333;
        line-height: 2em;
        overflow: hidden;
        width: 120px;
        height: 2em;
    }
    .s-title-bottom{
        font-size: 14px;
        overflow: hidden;
    }
    .s-des{
        margin-top: 10px;
        font-size: 13px;
        color: #888;
        line-height: 1.5em;
        height: 3em;
        text-overflow : ellipsis;
        overflow: hidden;
    }
    .s-tag{
        font-size:13px; position: absolute;right: 0; bottom: 0; padding:3px 5px; background:#e8e8e8;
    }

    .tit {
        border-left: #333 4px solid;
        padding-left: 5px;
        font-weight: bold;
        margin-left: 2px;
    }

    @media (min-width: 992px) {
        .container {
            width: 960px;
        }

        .grid .row [class ^="col-"]:not(:first-child) {
            border-left: none;
        }
    }

    @media (max-width: 767px) {
        .grid .row [class ^="col-"]:not(:first-child) {
            border-top: none;
        }
    }

</style>
<body data-spy="scroll" data-target=".navbar-fixed-top" data-offset="71">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" id="navbar-brand" href="#" ><span class="glyphicon glyphicon-fire"></span> 脚本商店</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="#1"><span class="glyphicon glyphicon-credit-card" style="top: 2px"></span> 征信</a></li>
                <li><a href="#2"><span class="glyphicon glyphicon-envelope"></span> 邮箱</a></li>
                <li><a href="#3"><span class="glyphicon glyphicon-book"></span> 小说</a></li>

            </ul>
            <div class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="输入脚本名称" style="padding-right: 30px;">
                    <span class="glyphicon glyphicon-search" style="right: 30px; top:2px;"></span>
                </div>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="./"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}"><span class="glyphicon glyphicon-user"></span> 登录</a></li>
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
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<?php $i=1; ?>
<div class="container"  style="margin: 70px auto;">
  @foreach($categories as $name=>$category)
   <div class="tit" id="{{$i++}}">{{$name}}</div>
     <div class="grid">
   @foreach($category as $key=>$spider)
        @if($key%4==0)
           <div class="row">
        @endif
            <div class="col-md-3 col-sm-6">
                <div class="clearfix">
                    <img src="public/img/icon/{{$spider->icon}}">
                    <div class="s-cap">
                        <div class="s-title">{{$spider->name}}</div>
                        <div class="s-title-bottom">调用次数: {{$spider->callCount}}</div>
                    </div>
                </div>
                <div class="s-des">
                    {{$spider->description}}
                </div>
                <div class="s-tag">{{$spider->user_id==0?"官方":"开发者提供"}}</div>
            </div>
       @if($key%4==3||$key==count($category)-1)
            </div>
       @endif
     @endforeach
      </div>
@endforeach
</div>
{{--<div class="container" style="margin-top: 70px">--}}
    {{--<div class="tit">最新脚本</div>--}}
    {{--<div class="grid">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-3">--}}
                {{--<div class="clearfix">--}}
                {{--<img src="public/img/icon/email.png">--}}
                    {{--<div class="s-cap">--}}
                        {{--<div class="s-title"></div>--}}
                        {{--<div></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="s-des">--}}
                {{--</div>--}}
                {{--<div class="s-tag">官方</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--xx--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--xx--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--xx--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-3">--}}
                {{--xx--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--xx<br>--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--xx--}}
            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<div style="border-top: #e8e8e8 1px solid; text-align: center; padding: 40px">
    版权所有
</div>
<script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(window).on("hashchange", function () {
        var target = $(location.hash);
        if (target.length == 1) {
            var top = target.offset().top - 66;
            if (top > 0) {
                $('html,body').animate({scrollTop: top}, 300);
            }
        }
    }).trigger("hashchange")

</script>
<script src="{{ url('public/js/store.js')}}"></script>
</body>
</html>