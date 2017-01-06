
# dSpider Android SDK集成文档

## Android studio集成

 ### 1.下载sdk 

https://dspider.dtworkroom.com/download/android_sdk

 ### 2. 导入aar包

添加到工程libs目录，然后在build.gradle的dependencies 中添加

```javascript
   dependencies{
     compile(name: "spidersdk-release", ext: "aar")
   }
```

 ### 3. 混淆支持

如果您的工程开启了混淆，请将如下代码添加到proguard-rules.pro

```java
   -keepattributes *JavascriptInterface*
   -keepattributes Signature
   -keepattributes *Annotation*
   -keepclassmembers class wendu.spidersdk.JavaScriptBridge {
         public *;
      }
   -keep class wendu.spidersdk.DSpider
   -keep class wendu.spidersdk.DSpider.Result
```

## SDK调用

### 调用

每一个爬取任务对应一个脚本，每一个脚本都有一个id, 我们称之为sid。每一个app都有一个appkey, 每个app可以执行多个爬取任务。appkey支持的sid需要在后台添加。

```java
DSpider.build(context,appkey)
       .start(sid);
```

### 获取爬取数据

```java
protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == DSpider.REQUEST ) {
            if(resultCode == RESULT_OK) {
                DSpider.Result resultData = DSpider.getLastResult(this)；
            } 
        }
       ...
    }
```



## API列表

### build(context,String appkey)

- 功能: 创建dspider实例
- context: 当前activity context
- appkey: 你的appkey (后台申请)
- 返回：DSpider实例

### start(int sid)

- 功能：启动爬取任务
- sid: spider id, 需要执行的爬取功能id


### addArgument(String name,Object value)

- 功能：调用sdk时添加调用参数，该参数会传递到爬取脚本，各脚本所需参数请参照该脚本使用说明，默认不需要。

假设有一个爬取邮件的spider,需要两个参数，一个关键字wd, 和需要爬取的邮件数量count，我们可以如下方式调用：

```java
DSpider.build(this,"1")
       .addArgument("wd","招商银行")
       .addArgument("count",20)
       .start(sid);
```



## 调试支持

dspider所有爬取脚本都是从服务器下发，但调试模式下会从本地加载，假设你写了一个爬取脚本a.js，爬取的起始页面地址为：https://xx.com

1. 将a.js放到assets目录下

2. 以调试模式启动sdk:

   ```java
   DSpider.build(this,"1")
          .setDebug(true)
          .start(sid,"a.js","https://xx.com");
   ```

如果你的脚本已经上传服务器（sid存在），当setDebug传false时便会加载服务端脚本，为true时则会加载本地脚本，此时DSpider会忽略sid。