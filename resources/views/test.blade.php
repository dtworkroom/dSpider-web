<!DOCTYPE html>
<html>
<head lang="zh-cmn-Hans">
    <meta charset="UTF-8">
    <title>DWebviewJavaScriptBridge Test</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=0.5,user-scalable=no"/>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>

</head>
<style>
    .btn {
        text-align: center;
        background: dodgerblue;
        color: white;
        padding: 20px;
        margin: 30px;
        font-size: 24px;
        border-radius: 4px;
        box-shadow: 4px 2px 10px #999;
    }

    .btn:active {
        opacity: .7;
        box-shadow: 4px 2px 10px #555;
    }

</style>
<body>

<div class="btn" onclick="callSyn()">同步调用</div>
<div class="btn" onclick="callAsyn()">异步调用</div>
<div class="btn" onclick="callNoArgSyn()">无参函数同步调用</div>
<div class="btn" onclick="callNoArgAsyn()">无参函数异步调用</div>
<div class="btn" onclick="callNever()">不调用(没有@JavascriptInterface标注)<br/>仅Android,IOS忽略此项</div>

<div class="btn" onclick="alert(confirm('Press a button'))">confirm test</div>
<div class="btn" onclick="alert(prompt('Please input user name.'))">prompt test</div>

<script>

    var bridge = getJsBridge();
    console.log(bridge)

    function callSyn() {
        alert(bridge.call("testSyn", {msg: "testSyn"}))
    }

    function callAsyn() {
        bridge.call("testAsyn", {msg: "testAsyn"}, function (v) {
            alert(v);
        })
    }

    function callNoArgSyn() {
        alert(bridge.call("testNoArgSyn"));
    }

    function callNoArgAsyn() {
        bridge.call("testNoArgAsyn", function (v) {
            alert(v)
        });
    }

    function callNever() {
        bridge.call("testNever", {msg: "testSyn"})
    }

    function test(arg1,arg2){
        return arg1+arg2;
    }
</script>
</body>
</html>