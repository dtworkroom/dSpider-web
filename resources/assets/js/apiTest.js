/**
 * Created by du on 16/12/8.
 */
var util=require("./util.js")
//测试log
util.log("xx")
var prefix="api/"
function addScript(){
    $.post(prefix+"profile/spider/save",{
        name:"test",
        content:"dSpider(\"test\", function(session,env,$) {\r\nlog(session)\r\n})" ,
        startUrl:"https://www.baidu.com"
    }).done(util.handle())
}
function addAppKey(){
    $.post(prefix+"profile/appkey/save",{
        name:"小赢卡带"
    }).done(util.handle())
}


$("#spiders").click(function(){
    $.post(prefix+"spiders")
        .done(util.handle())
})