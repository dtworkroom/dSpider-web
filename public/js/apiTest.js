!function(t){function r(n){if(e[n])return e[n].exports;var o=e[n]={i:n,l:!1,exports:{}};return t[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}var e={};return r.m=t,r.c=e,r.i=function(t){return t},r.d=function(t,r,e){Object.defineProperty(t,r,{configurable:!1,enumerable:!0,get:e})},r.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return r.d(e,"a",e),e},r.o=function(t,r){return Object.prototype.hasOwnProperty.call(t,r)},r.p="",r(r.s=2)}([function(t,r,e){var n=e(1);log=void 0,prefix="api/",root="/",location.hostname.indexOf("dspider.")!=-1&&(prefix="/dSpider-web/api/",root="/dSpider-web/"),n.hookAjax({onload:function(t){try{if(200==t.status){var r=JSON.parse(t.responseText);if(0==r.code)t.response=t.responseText=r.data;else{if(r.code==-10)return location=root+"login",!0;404==r.code||403==r.code?location=root+r.code:(t.status=4832,t.statusText=t.responseText)}}}catch(e){}}});var o=$.ajax;$.ajax=function(t,r){var e=o(t,r),n=!1,i=e.fail,a=function(t){return i.call(e,function(r){if(4832==r.status){var e=JSON.parse(r.statusText);t(e.msg,e.code)}else t(r.statusText,r.status)})};return a(function(t,r){n||alert(t+"<div style='color:lightcoral;padding-top: 10px;'>error code: "+r+"</div>","出错了")}),e.fail=function(t){return n=!0,a(t)},e.error=a,e},dialog=function(t,r){var e,n,o,i="确定",a="",c=function(t){return function(){$("#dlg-close").off("click",o),$("#dlg-ok").off("click",e),$("#dlg-cancel").off("click",n),t&&t()}};return{setOk:function(t,r){return i=t||i,e=c(r),this},setCancel:function(t,r){return a=t,n=c(r),this},setClose:function(t){return o=c(t),this},show:function(){var c=$("#dlg-cancel");return a?c.text(a).click(n).show():c.hide(),$("#dlg-close").click(o),$("#dlg-ok").text(i).click(e),$("#dlg-title").text(r||"提示"),$("#alert-text").html(t||"Hi, I am beautiful alert."),$("#alert").modal("show"),this},hide:function(){$("#alert").modal("hide")}}};var i=alert;alert=function(t,r){$&&$("#alert-text")[0]?dialog(t,r).show():i(t)},isJson=function(t,r){try{t=JSON.parse(t);var e=typeof t;if(Array.isArray(t))e="Array";else if("object"==e)return!0;t="错误的类型:"+e+" , 必须是Object {}"}catch(n){t=n.message}return void 0!==r&&alert(r+"<br><br>"+t),!1},parseAccess=function(t){if(!t)return[];var r=0;return t.toString(2).split("").reverse().map(function(t){return Math.pow(2,r++)*t})},getAccess=function(t){return t.reduce(function(t,r){return parseInt(t)+parseInt(r)},0)},$("#nav a").filter(function(){var t=location.href,r=$(this).attr("href");return!(t.indexOf(r)&&t.indexOf(r+"?"))}).parent().addClass("active")},function(t,r){!function(t){var r;t.hookAjax=function(t){function e(t){return function(){return this[t+"_"]||this.xhr[t]}}function n(r){return function(e){var n=this.xhr,o=this;return 0!=r.indexOf("on")?void(this[r+"_"]=e):void(t[r]?n[r]=function(){t[r](o)||e.apply(n,arguments)}:n[r]=e)}}function o(r){return function(){var e=[].slice.call(arguments);t[r]&&t[r].call(this,e,this.xhr)||this.xhr[r].apply(this.xhr,e)}}return r=r||XMLHttpRequest,XMLHttpRequest=function(){var t=this;this.xhr=new r;for(var i in this.xhr){var a="";try{a=typeof t.xhr[i]}catch(c){}"function"===a?t[i]=o(i):Object.defineProperty(t,i,{get:e(i),set:n(i)})}},r},t.unHookAjax=function(){r&&(XMLHttpRequest=r),r=void 0}}(t.exports)},function(t,r,e){var n=e(0);n.log("xx");var o="api/";$("#spiders").click(function(){$.post(o+"spiders").done(n.handle())})}]);