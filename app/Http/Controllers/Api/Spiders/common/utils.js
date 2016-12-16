/**
 * Created by du on 16/9/1.
 */

var $ = dQuery;
var jQuery=$;
String.prototype.format = function () {
    var args = Array.prototype.slice.call(arguments);
    var count = 0;
    return this.replace(/%s/g, function (s, i) {
        return args[count++];
    });
};

String.prototype.trim = function () {
    return this.replace(/(^\s*)|(\s*$)/g, '');
};

String.prototype.empty = function () {
    return this.trim() === "";
};

//兼容<ios9.3,<android4.4
Function.prototype.bind = Function.prototype.bind || function () {
        var fn = this, presetArgs = [].slice.call(arguments);
        var context = presetArgs.shift();
        return function () {
            return fn.apply(context, presetArgs.concat([].slice.call(arguments)));
        }
};

function log(str) {
    var s = window.curSession
    if (s) {
        s.log(str)
    } else {
        console.log("dSpider: " + typeof str == "string" ? str : JSON.stringify(str))
    }
}

//异常捕获
function errorReport(e) {
    var stack = e.stack ? e.stack.replace(/http.*?inject\.php.*?:/ig, " " + _su + ":") : e.toString();
    var msg = "语法错误: " + e.message + "\nscript_url:" + _su + "\n" + stack
    if (window.curSession) {
        curSession.log(msg);
        curSession.finish(e.message, "", 3, msg);
    }
}

String.prototype.endWith = function (str) {
    if (!str) return false;
    return this.substring(this.length - str.length) === str;
};

//queryString helper
window.qs = [];
var s = decodeURI(location.search.substr(1));
var a = s.split('&');
for (var b = 0; b < a.length; ++b) {
    var temp = a[b].split('=');
    qs[temp[0]] = temp[1] ? temp[1] : null;
}
MutationObserver = window.MutationObserver || window.WebKitMutationObserver

function safeCallback(f) {
    if (!(f instanceof Function)) return f;
    return function () {
        try {
            f.apply(this, arguments)
        } catch (e) {
            errorReport(e)
        }
    }
}
//设置$异常处理器
$.safeCallback = safeCallback;
$.errorReport = errorReport;

function hook(fun) {
    return function () {
        if (!(arguments[0] instanceof Function)) {
            t = arguments[0];
            log("warning: " + fun.name + " first argument should be function not string ")
            arguments[0] = function () {
                eval(t)
            };
        }
        arguments[0] = safeCallback(arguments[0]);
        return fun.apply(this, arguments)
    }
}

//hook setTimeout,setInterval异步回调
var setTimeout = hook(window.setTimeout);
var setInterval = hook(window.setInterval);

//dom 监控
function DomNotFindReport(selector) {
    var msg = "元素不存在[%s]".format(selector)
    log(msg)
}

function waitDomAvailable(selector, success, fail) {
    var timeout = 10000;
    var t = setInterval(function () {
        timeout -= 10;
        var ob = $(selector)
        if (ob[0]) {
            clearInterval(t)
            success(ob, 10000 - timeout)
        } else if (timeout == 0) {
            clearInterval(t)
            var f = fail || DomNotFindReport;
            f(selector)
        }
    }, 10);
}

function Observe(ob, options, callback) {
    var mo = new MutationObserver(callback);
    mo.observe(ob, options);
    return mo;
}

//$,api加载成功的标志是window.xyApiLoaded=true,所有操作都必须在初始化成功之后
function apiInit() {
    $.noConflict();
    var withCheck = function (attr) {
        var f = DataSession.prototype[attr];
        return function () {
            if (this.finished) {
                log("call " + attr + " ignored, finish has been called! ")
            } else {
                return f.apply(this, arguments);
            }
        }
    }

    for (var attr in DataSession.prototype) {
        DataSession.prototype[attr] = withCheck(attr);
    }
    var t = setInterval(function () {
        if (!(window._xy || window.bridge)) {
            return;
        }
        window.xyApiLoaded = true;
        clearInterval(t);
    }, 20);
}

//爬取入口
function dSpider(sessionKey, callback) {
    //判断调用源,如果是在onSpiderInited中调用,则下发脚本中的dSpider函数不执行
    if (window.onSpiderInited && this !=5) {
        return;
    }
    var t = setInterval(function () {
        if (window.xyApiLoaded) {
            clearInterval(t);
        } else {
            return;
        }
        var session = new DataSession(sessionKey);
        var onclose = function () {
            log("onNavigate:" + location.href)
            session._save()
            if (session.onNavigate) {
                session.onNavigate(location.href);
            }
        }
        $(window).on("beforeunload", onclose)
        window.curSession = session;
        session._init(function () {
            DataSession.getExtraData(function (extras) {
                extras = JSON.parse(extras || "{}")
                DataSession.getArguments(function (args) {
                    $(safeCallback(function () {
                        $("body").on("click", "a", function () {
                            $(this).attr("target", function (_, v) {
                                if (v == "_blank") return "_self"
                            })
                        })
                        log("dSpider start!")
                        session.getConfig = function () {
                            return typeof _config === "object" ? _config : {}
                        }
                        session.getArguments = function () {
                            return JSON.parse(args)
                        }
                        callback(session, extras, $);
                    }))
                })
            })
        })
    }, 20);
}


$(function () {
    var f = window.onSpiderInited;
    f&&f(dSpider.bind(5))
})

//邮件爬取入口
function dSpiderMail(sessionKey, callback) {
    dSpider(sessionKey, function (session, env, $) {
        callback(session.getLocal("u"), session.getLocal("wd"), session, env, $);
    })
}