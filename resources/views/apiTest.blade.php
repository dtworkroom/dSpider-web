<!DOCTYPE html>
<html>
<head lang="zh-cmn-Hans">
    <meta charset="UTF-8">
    <title>APi test</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=0.5,user-scalable=no"/>
    <script src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>


</head>
<style>
</style>
<body>
API TEST

<button id="spiders">All spiders</button>

<script src="public/js/apiTest.js"></script>
<script>
    var prefix="api/"
    var log=console.log.bind(console);
    function addScript(){
        $.post(prefix+"profile/spider/save",{
            name:"test",
            content:"dSpider(\"test\", function(session,env,$) {\r\nlog(session)\r\n log(env)\r\n})" ,
            startUrl:"https://www.baidu.com"
        }).done(log)
    }
    function addAppKey(){
        $.post(prefix+"profile/appkey/save",{
            name:"小赢卡带"
        }).done(log)
    }
</script>
</body>
</html>