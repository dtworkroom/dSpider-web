/**
 * Created by du on 16/9/1.
 */

var $ = dQuery;
function _logstr(str) {
    str = str || " "
    return typeof str == "object" ? JSON.stringify(str) : (new String(str)).toString()
}
function log(str) {
    var s = window.curSession
    if (s) {
        s.log(str)
    } else {
        console.log("dSpider: " + _logstr(str))
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

//爬取入口
function dSpider(sessionKey, callback) {
    //判断调用源,如果是在onSpiderInited中调用,则下发脚本中的dSpider函数不执行
    if (window.onSpiderInited && this != 5) {
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
    session._init()
    var extras = DataSession.getExtraData()
    extras = JSON.parse(extras || "{}")
    var args = DataSession.getArguments()
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
}

$(function () {
    var f = window.onSpiderInited;
    f && f(dSpider.bind(5))
})

//邮件爬取入口
function dSpiderMail(sessionKey, callback) {
    dSpider(sessionKey, function (session, env, $) {
        callback(session.getLocal("u"), session.getLocal("wd"), session, env, $);
    })
}

/**
 * Created by du on 16/8/17.
 */
var bridge=getJsBridge();
function callHandler(){
    var f=arguments[2];
    if (f) {
        arguments[2] = safeCallback(f)
    }
    return bridge.call.apply(bridge,arguments);
}
function DataSession(key) {
    this.key = key;
    log("start called")
    this.finished=false;
    callHandler("start", {sessionKey:key})
}

DataSession.getExtraData = function (f) {
    log("getExtraData called")
    return callHandler("getExtraData")
}

DataSession.getArguments= function (f) {
    log("getArguments called")
    return callHandler("getArguments")
}

DataSession.prototype = {
    _save: function () {
        callHandler("set", {key: this.key, value: JSON.stringify(this.data)})
    },
    _init: function () {
        var data=callHandler("get", {key:this.key});
        this.data=JSON.parse(data || "{}");
        this.local=JSON.parse(callHandler("read",{key:this.key})|| "{}");
    },

    get: function (key) {
        log("get called")
        return this.data[key];
    },
    set: function (key, value) {
        log("set called")
        this.data[key]=value;
        this._save();
    },

    showProgress: function (isShow) {
        log("showProgress called")
        callHandler("showProgress", {show:isShow === undefined ? true : !!isShow});
    },
    setProgressMax: function (max) {
        log("setProgressMax called")
        callHandler("setProgressMax", {progress:max});
    },
    setProgress: function (progress) {
        log("setProgress called")
        callHandler("setProgress", {progress:progress});
    },
    setProgressMsg:function(msg){
        if(!msg) return;
        callHandler("setProgressMsg",{msg:msg})
    },
    finish: function (errmsg, content, code,stack) {
        var ret = {sessionKey:this.key, result: 0, msg: ""}
        if (errmsg) {
            var ob = {
                url: location.href,
                msg: errmsg,
                args:this.getArguments()
                // content: content||document.documentElement.outerHTML ,
            }
            stack&&(ob.stack=stack);
            ret.result = code || 2;
            ret.msg = JSON.stringify(ob);
        }
        log("finish called")
        this.finished=true;
        callHandler("finish", ret);

    },
    upload: function (value,f) {
        if (value instanceof Object) {
            value = JSON.stringify(value);
        }
        log("push called")
        callHandler("push", {"sessionKey": this.key, "value": value});
    },
    load:function(url,headers){
        headers=headers||{}
        if(typeof headers!=="object"){
            alert("the second argument of function load  must be Object!")
            return
        }
        callHandler("load",{url:url,headers:headers});
    },
    setUserAgent:function(str){
        callHandler("setUserAgent",{userAgent:str})
    },

    autoLoadImg:function(load){
        callHandler("autoLoadImg",{load:load===true})
    },

    string: function () {
        log(this.data)
    },
    log: function(str,type) {
        str=_logstr(str);
        console.log("dSpider: "+str)
        callHandler("log",{type:type||1,msg:str})
    },
    setLocal: function (k, v) {
        log("save called")
        this.local[k]=v;
        callHandler("save", {key: this.key, value: JSON.stringify(this.local)})
    },
    getLocal: function (k) {
        log("read called")
        return this.local[k];
    }
};
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