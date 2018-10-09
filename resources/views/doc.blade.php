@extends('layouts.public')
@section('head')
    <style>
        #spider > div > span {
            display: inline-block;
            width: 150px;
            color: #000;
            margin-right: 15px;
        }

        #spider > div {
            color: #777;
            line-height: 2em;
        }

        #doc {
            /*padding: 26px;*/
            /*border: #f2f2f2 1px solid;*/
            border-radius: 3px;
            line-height: 1.8em;
            color: #555;
        }

        .left>a:last-child{
            margin-top: 15px;
        }

        h1 {
            padding-bottom: 10px;
            border-bottom: #ddd 1px solid;
            padding-top: 5px;
        }

        h1, h2, h3 {
            color: #000;
        }

        pre {
            position: relative;
            margin-bottom: 24px;
            border-radius: 3px;
            border: 1px solid #C3CCD0;
            font-size: 10px;
            background-color: #fbfbfb
        }

        code {
            display: block;
            padding: 12px 24px;
            font-weight: 300;
            font-size: 0.8em;
            line-height: 20px;
            margin: 10px 0;
        }

        pre .hljs {
            padding: 0;
            background: inherit;
        }

        pre code {
            margin: 0;
        }

        pre code {
            white-space: inherit;
        }


        blockquote {
            margin: 20px 0;
            font-size: inherit;
        }

        .pre-numbering {
            position: absolute;
            top: 0;
            left: 0;
            width: 20px;
            padding: 10px 2px 9px 0;
            border-right: 1px solid #C3CCD0;
            border-radius: 3px 0 0 3px;
            background-color: #EEE;
            text-align: right;
            font-size: 0.8em;
            line-height: 20px;
            color: #AAA;
            text-align: center;
            margin-bottom: 0;
            display: none;
        }

        .content > div {
            height: 100%;
        }


        .left{
           padding-top: 20px;
        }

        .left a {
            display: block
        }

        .menu {
            /*background: #f8f8f8;*/
            margin-top: 10px;
            border-top: #f2f2f2 1px solid;
            padding-top: 10px;

        }

        .menu, .right {
            display: none;
        }

        .right {
            max-width: 900px;
        }

        /*#nav a{*/
           /*padding-left: 15px;*/
        /*}*/

        @media (min-width: 768px) {
            .right {
                padding: 0 25px 50px 50px;
                margin-left: 330px;
            }

            .left {
                background: #fff;
                position: fixed;
                overflow-y: auto;
                width: 330px;
                padding: 20px 20px 150px 50px;
                border-right: #f2f2f2 1px solid;
                /*box-shadow: 2px 2px 5px #ccc;*/
            }

            .pre-numbering {
                display: block;
            }

            code.has-numbering {
                padding-left: 21px;
            }
            pre{
                font-size: 13px;
            }

        }



        .newh2 {
            padding: 5px 0
        }

        .newh3 {
            padding-left: 5px
        }
        .newh4 {
            padding-left: 10px
        }

        .left-cap {
            display: block
        }

    </style>
    <script>
        //        $("body").fadeOut(100)
    </script>

@endsection
@section('content')
    <div class="container-fluid content">
        <div class="left">
            <a href="{{url('document/introduction')}}">DSpider 简介</a>
            <a href="{{url('document/ios')}}">IOS SDK集成</a>
            <a href="{{url('document/android')}}">Android SDK集成</a>
            <a href="{{url('document/js_api')}}">Javascript API文档</a>
            <div class="menu" >
                本页目录
            </div>
            <a href="#doc" class="hidden-xs">
                <span class="glyphicon glyphicon-circle-arrow-up"></span>
                返回顶部
            </a>
        </div>
        <div class="right">
            <div class="form-group">

                <div id="doc">
                    {{ $content."\r\n\r\n**最后更新时间:".$time."**"  }}
                </div>
                <a target="_blank" href="{{url("download/docs/$id")}}" class="btn btn-default" style="margin-top: 20px">
                    <span class="glyphicon glyphicon-download-alt"></span>
                    下载本文档
                </a>
            </div>
        </div>
    </div>


@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/marked@0.3.6/marked.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/highlightjs@9.10.0/styles/github.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/highlightjs@9.10.0/highlight.pack.min.js"></script>
    <script>
        function addRowNo(data, adjust) {
            var t = $('<div></div>').html(data);
            t.find("pre code").each(function () {
                var lines = $(this).text().split('\n').length - (adjust == undefined ? 0 : 1);
                var $numbering = $('<ul/>').addClass('pre-numbering');
                $(this).addClass('has-numbering').parent().append($numbering);
                for (var i = 1; i <= lines; i++) {
                    $numbering.append($('<li/>').text(i));
                }
            })
            return t.html()
        }
        marked.setOptions({
            breaks: true,
            highlight: function (code) {
                return hljs.highlightAuto(code).value;
            }
        });

        marked($("#doc").text(), function (t, b) {
            $("#doc").html(addRowNo(b, 1))
        })


            $("#doc").find("h2,h3,h4,h5,h6").attr("id", function(i,v){
                var id= v+i
                var tag = $(this).get(0).localName;
                $(".menu").append('<a class="new' + tag
                        + ' left-cap" href="#' + id+ '">' + $(this).text() + '</a>');
               return id
            });


        $(function () {
            $("#footer").hide()
            $(window).on("hashchange", function () {
                var target = $(location.hash);
                if (target.length == 1) {
                    var top = target.offset().top - 66;
                    if (top > 0) {
                        $('html,body').animate({scrollTop: top}, 300);
                    }
                }
            }).trigger("hashchange")
        })

        $("a").attr("href", function (_, v) {
            if (!v || v == "#") {
                return "javascript:alert('即将上线,敬请期待')"
            }
        })
        $(".menu,.right").fadeIn(400)
        $("title").text($('h1').text())
    </script>
@endsection