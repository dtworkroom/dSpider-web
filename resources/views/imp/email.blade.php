@extends('layouts.phone')

@section('content')
    <input id="wd" type="text" style="margin-top: 30% " placeholder="请输入关键字" autofocus/>
    <button disabled>下一步</button>
    <script>
        window.onSpiderInited = function (dSpider) {
            dSpider("email", function (session, env, $) {
                var url = {
                    "sina": "http://mail.sina.cn/?vt=4",
                    "QQ": "https://w.mail.qq.com/cgi-bin/loginpage?f=xhtml",
                    "163": "http://smart.mail.163.com/?dv=smart",
                    "126": "http://smart.mail.126.com/"
                }
                var btn = $("button");
                var wd = $("#wd")
                $("input").on("input", function (e) {
                    if (wd.val().trim().length != 0) {
                        btn.removeAttr("disabled")
                    } else {
                        btn.attr("disabled", "disabled")
                    }
                })
                wd.val(session.getLocal("wd")).trigger("input")
                btn.click(function () {
                    var suffix = qs["t"]
                    if (url[suffix]) {
                        session.setLocal("wd", wd.val())
                        session.addArgument("wd",wd.val())
                        btn.text("加载中...").attr("disabled", "disabled");
                        location.href = url[suffix];
                    } else {
                        alert("参数错误");
                    }

                })
            })
        }
    </script>
@endsection

