/**
 * Created by du on 16/12/8.
 */
var ah = require("ajax-hook")
log = console.log.bind(console);

prefix="/api/"
root="/"
if(location.hostname.indexOf("dspider.")==-1){
    prefix = "/dSpider-web/api/"
    root="/dSpider-web/"
}

ah.hookAjax({
    onload: function (xhr) {
        try {
            //console.log("onload called: %O", xhr)
            if (xhr.status == 200) {
                var ret = JSON.parse(xhr.responseText);
                if (ret.code == 0) {
                    xhr.response = xhr.responseText = ret.data;
                } else {
                    if (ret.code == -10) {
                        location = root+"login"
                        return true
                    }else if(ret.code==404||ret.code==403){
                        location= root+ret.code;
                    }
                    else {
                        xhr.status = 4832;
                        xhr.statusText = xhr.responseText;
                    }
                }
            }
        } catch (e) {}
    }
})

var _ajax = $.ajax;
$.ajax = function (_, __) {
    var ob = _ajax(_, __);
    var hasErrorHandler = false;
    var fail = ob.fail;
    var _fail = function (callback) {
        return fail.call(ob, function (xhr) {
            if (xhr.status == 4832) {
                var ret = JSON.parse(xhr.statusText)
                callback(ret.msg, ret.code)
            } else {
                callback(xhr.statusText, xhr.status)
            }
        })
    }
    _fail(function (msg, status) {
        if (hasErrorHandler) return;
        alert(msg + "<div style='color:lightcoral;padding-top: 10px;'>error code: " + status + "</div>", "出错了")
    })

    ob.fail = function (callback) {
        hasErrorHandler = true;
        return _fail(callback)
    }

    ob.error=_fail;


    return ob;
}
//全局对话框
dialog = function (msg, title) {
    var onOk, onCancel, onClose;
    var okBtn = "确定", cancelBtn = "";
    var wrapper=function(callback){
        return function (){
            $("#dlg-close").off("click",onClose);
            $("#dlg-ok").off("click",onOk);
            $("#dlg-cancel").off("click",onCancel);
            callback&&callback();
        }
    }
    return {
        setOk: function (s, c) {
            okBtn = s || okBtn
            onOk = wrapper(c);
            return this;
        },
        setCancel: function (s, c) {
            cancelBtn = s
            onCancel = wrapper(c);
            return this;
        },
        setClose: function (c) {
            onClose = wrapper(c);
            return this;
        },
        show:function(){
            var cancel = $("#dlg-cancel")
            if (cancelBtn) {
                cancel.text(cancelBtn).click(onCancel).show();
            } else {
                cancel.hide()
            }
            $("#dlg-close").click(onClose);
            $("#dlg-ok").text(okBtn).click(onOk)
            $("#dlg-title").text(title || "提示");
            $("#alert-text").html(msg || "Hi, I am beautiful alert.")
            $("#alert").modal("show");
            return this
        },
        hide:function(){
            $("#alert").modal("hide");
        }
    }
}

var _alert = alert;
alert = function (msg, title) {
    if ($ && $("#alert-text")[0]) {
        dialog(msg, title).show()
    } else {
        _alert(msg)
    }
}

isJson = function (s, tip) {
    try {
        s = JSON.parse(s)
        var t = typeof s;
        if (Array.isArray(s)) {
            t = "Array"
        } else if (t == "object") {
            return true;
        }
        s = '错误的类型:' + t + ' , 必须是Object {}';

    } catch (e) {
        s = e.message
    }
    tip !== undefined && alert(tip + "<br><br>" + s);
    return false;
}
//解析权限为数组
parseAccess = function (v) {
    if (!v) return [];
    var i = 0;
    return v.toString(2)
        .split("")
        .reverse()
        .map(function (v) {
            return Math.pow(2, i++) * v;
        })
}
//合并权限
getAccess = function (v) {
    return v.reduce(function (p, n) {
        return parseInt(p) + parseInt(n)
    }, 0);
}

//导航激活
$("#nav a").filter(function(){
    var h=location.href
    var r=$(this).attr("href")
    return !(h.indexOf(r) && h.indexOf(r + "?"));

}).parent().addClass("active")


