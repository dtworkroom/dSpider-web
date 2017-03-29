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

        #spider{
            padding-top: 20px;
        }

        #btn_group {
            margin: 30px 0 50px;
        }

        #btn_group a {
            margin-left: 20px;
        }
        .appitem{
            padding:8px 5px;
            color:#337ab7 ;
            cursor: pointer;
            border-bottom: #f3f3f3 1px solid;
        }

        .appitem:hover{
            background: #f7f7f7;
        }

        #doc {
            background: #fbfbfb;
            padding: 26px;
            border: #f2f2f2 1px solid;
            border-radius: 3px;
            color: #555;
        }

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
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <div id="spider">
                    <h3>基本信息</h3>
                    <div>
                        <span>所属Spider:</span>
                        <a href="{{url("spider/".$script->spider->id)}}">{{$script->spider->name}}</a>
                    </div>
                    <div>
                        <span>本脚本ID:</span>
                        {{$script->spider->id}}
                    </div>
                    <div>
                        <span>支持SDK的最低版本:</span>
                        {{$script->min_sdk}}
                    </div>
                    <div>
                        <span>优先级:</span>
                        {{$script->priority}}
                    </div>
                    <div>
                        <span>状态:</span>
                        {!!  $script->online?"已上线":"<span style='color:red'>未上线</span>" !!}
                    </div>

                    <div>
                        <span>被调次数:</span>
                        {{$script->callCount}}
                    </div>
                    <div>
                        <span>创建时间:</span>
                        {{$script->created_at}}
                    </div>

                    <div>
                        <span>更新时间:</span>
                        {{$script->updated_at}}
                    </div>

                    <div class="form-group code">
                        <h3>脚本源码</h3>
                        @if(isset($script->content))
                        <pre><code>{!! trim($script->content)  !!} </code></pre>
                        @else
                        作者未公开源码.
                        @endif
                    </div>


                    <div>
                        @if(!Auth::guest() &&  Auth::user()->id==$script->spider->user_id)
                            <a href="{{url("profile/script/save/".$script->spider_id."/".$script->id."?sn=".$script->spider->name)}}" class="btn btn-middle btn-primary">
                                <span class="glyphicon glyphicon-edit"></span>
                                编辑
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
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
        hljs.initHighlightingOnLoad();
        $(".code").html(function (_, html) {
            return addRowNo(html)
        })

    </script>
@endsection