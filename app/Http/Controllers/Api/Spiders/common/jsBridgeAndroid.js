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