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

        h1, h2, h3,h4 {
            color: #000;
        }
        h4{margin-top: 20px}

        pre {
            position: relative;
            margin-bottom: 24px;
            border-radius: 3px;
            word-wrap: normal;
            border: 1px solid #C3CCD0;
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

        code.has-numbering {
            margin-left: 30px;
        }

        .pre-numbering {
            position: absolute;
            top: 0;
            left: 0;
            width: 27px;
            padding: 10px 0px 9px 0;
            border-right: 1px solid #C3CCD0;
            border-radius: 3px 0 0 3px;
            background-color: #EEE;
            text-align: right;
            font-size: 12px;
            line-height: 20px;
            color: #AAA;
            text-align: center;
            margin-bottom: 0;
        }

        blockquote {
            margin: 20px 0;
            font-size: inherit;
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
    <div class="container">
      <div class="row">
            <div class="form-group col-md-10 col-md-offset-1" >
                <div id="doc">
                    {{ $content }}
                </div>
                <div style="margin: 50px 0"> {{ "本文最后更新时间:".$time}} </div>
            </div>
      </div>
    </div>
@endsection

@section('footer')
    <script src="//cdn.bootcss.com/marked/0.3.6/marked.min.js"></script>
    <link href="//cdn.bootcss.com/highlight.js/9.7.0/styles/github.min.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/highlight.js/9.7.0/highlight.min.js"></script>
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


        $(function () {
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
                return "javascript:alert('暂未上线,敬请期待')"
            }
        })
        $("title").text($('h1').text())
    </script>
@endsection