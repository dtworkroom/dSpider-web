@extends('layouts.profile')
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

        #btn_group {
            margin: 30px 0 50px;
        }

        #btn_group a {
            margin-left: 20px;
        }

        .appitem {
            padding: 8px 5px;
            color: #337ab7;
            cursor: pointer;
            border-bottom: #f3f3f3 1px solid;
        }

        .appitem:hover {
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
                        <span>App名称:</span>
                        <a title="查看应用详情" href="{{url("profile/appkey/save/".$app->id)}}">{{$app->name}}</a>
                    </div>
                    <div>
                        <span>App包名:</span>
                        <a title="查看应用详情" href="{{url("profile/appkey/save/".$app->id)}}">{{$app->package}}</a>
                    </div>
                    <div>
                        <span>App版本:</span>
                        {{$record->app_version}}
                    </div>
                    <div>
                        <span>Sdk版本:</span>
                        {{$record->sdk_version}}
                    </div>
                    <div>
                        <span>执行spider:</span>
                        <a title="查看spider详情" href="{{url("spider/".$spider->id)}}">{{$spider->name}}</a>
                    </div>
                    <div>
                        <span>脚本id:</span>
                        <a title="查看脚本详情" href="{{url("script/".$record->script_id)}}">{{$record->script_id}}</a>
                    </div>


                    <div>
                        <span>设备ID:</span>
                        {{$device->id}}
                    </div>

                    <div>
                        <span>设备UID:</span>
                        {{$device->identifier}}
                    </div>

                    <div>
                        <span>设备系统:</span>
                        <?php
                        $type=[1=>'Android',2=>"Ios",3=>'Windows',4=>'Osx',5=>'Linux'];
                        echo $type[$device->os_type]." ".$device->os_version
                        ?>
                    </div>

                    <div>
                        <span>设备机型:</span>
                        {{$device->model??"--"}}
                    </div>

                    <div>
                        <span>爬取时间:</span>
                        {{$record->updated_at}}
                    </div>

                    <div class="{{$record->content?"form-group":""}} code">
                        <span>爬取配置:</span>
                        @if (trim($record->content)):
                        <pre><code> <?php
                                $json = json_decode($record->content);
                                echo htmlentities(json_encode($json, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
                                ?></code></pre>
                        @else
                            原脚本默认
                        @endif
                    </div>

                    <div>
                        <span>爬取状态:</span>
                        {!! $record->state==0?"<span style='color:green'>成功</span>":"<span style='color:red'>失败</span>" !!}
                    </div>

                    @if($record->state>0)
                        <div class="form-group code">
                           <span>错误信息:</span>
                           <pre><code><?php
                                   $json = json_decode($record->msg);
                                   echo  htmlentities(str_replace("(\\r\\n|\\n)","\r\n\t\t",json_encode($json, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)));
                                   ?></code></pre>
                        </div>
                    @endif

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