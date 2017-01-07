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
            margin-left: 21px;
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
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div id="spider">
                    <div>
                        <span>脚本名称:</span> {{$spider->name}}
                    </div>
                    <div>
                        <span>介绍:</span>
                        {{$spider->description}}
                    </div>

                    <div>
                        <span>起始地址:</span>
                        {{$spider->startUrl}}
                    </div>

                    <div>
                        <span>是否公开:</span>
                        {{$spider->public?"是":"否"}}
                    </div>
                    <div>
                        <span>默认User-Agent:</span>
                        {{$spider->public==1?"手机":$spider==2?"电脑":"自动"}}
                    </div>

                    <div>
                        <span>支持的平台:</span>
                        <?php
                        $s = "";
                        if ($spider->support & 1) $s .= ($s ? " / " : "") . "Android";
                        if ($spider->support & 2) $s .= ($s ? " / " : "") . "Ios";
                        if ($spider->support & 4) $s .= ($s ? " / " : "") . "Pc";
                        echo $s;
                        ?>
                    </div>

                    <div>
                        <span>权限:</span>
                        <?php
                        $s = "";
                        if ($spider->access & 1) $s .= ($s ? " / " : "") . "允许下发";
                        if ($spider->access & 2) $s .= ($s ? " / " : "") . "允许查看源代码";
                        echo $s;
                        ?>
                    </div>

                    <div>
                        <span>被调次数:</span>
                        {{$spider->callCount}}
                    </div>
                    <div>
                        <span>创建时间:</span>
                        {{$spider->created_at}}
                    </div>

                    <div>
                        <span>更新时间:</span>
                        {{$spider->updated_at}}
                    </div>

                    <div class="{{trim($spider->defaultConfig)?"form-group":""}} code">
                        <span>默认配置:</span>
                        @if (trim($spider->defaultConfig)):
                        <pre><code>{{trim($spider->defaultConfig)}}</code></pre>
                        @else
                            无
                        @endif
                    </div>

                    <div class="form-group code">
                        <span>脚本源代码:</span>
                        <pre><code>{{trim($spider->content)}} </code></pre>
                    </div>

                    <div class="{{trim($spider->defaultConfig)?"form-group":""}}">
                        <span>脚本文档:</span>
                        @if (trim($spider->readme))
                            <div id="doc">{{trim($spider->readme)}}</div>
                        @else
                            无
                        @endif
                    </div>

                    <div id="btn_group">
                        <button id="add" data-id="{{$spider->id}}" data-uid="{{Request::user()?Request::user()->id:0}}" data-loading-text="Loading..." class="btn btn-middle btn-primary">
                            添加到我的应用
                        </button>
                        @if(\Illuminate\Support\Facades\Request::user()->id==$spider->user_id)
                            <a href="{{url("profile/spider/save/".$spider->id)}}" class="btn btn-middle btn-default">
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

        hljs.initHighlightingOnLoad();
        $(".code").html(function (_, html) {
            return addRowNo(html)
        })

        $("#doc").html(function (_, html) {
            return marked(html, function (t, b) {
                return addRowNo(b, 1)
            })
        })
        $("#add").click(function () {
            var uid=$(this).data("uid"); //user id
            var sid=$(this).data("id"); //spider id
            if(uid){
                $.post(prefix+"profile/appkey").done(function (data) {
                    if(data.length==0){
                        dialog("您还没有应用,请先创建应用后操作.").setOk("去创建", function () {
                            location=root+"profile/appkey/save";
                        }).show()
                        return
                    }
                    data=data.map(function (o) {
                        if(o.state==1) {
                            return "<div class='appitem' data-id='" + o.id + "'>" + o.name + "</div>";
                        }
                    })

                    dialog("<div>"+data.join("")+"</div>","请选择应用").setOk("取消").show();
                    $(".appitem").one('click',function () {
                        var key=$(this).data("id")
                        $.post(prefix+"profile/spider_config/save",{spider_id:sid,appKey_id:key})
                                .done(function (data) {
                                    dialog("添加成功!").setOk("去查看", function () {
                                      location=root+"profile/appkey/save/"+key
                                    }).show()
                                })
                    })
                })
            }else{
                dialog("添加脚本需要先登录").setOk("去登录", function () {
                    location=root+"login";
                }).show()

            }


        })

    </script>
@endsection