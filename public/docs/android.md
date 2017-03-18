
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

sdk有两种调用方式：显式爬取和静默爬取，显式爬取展示爬取过程进度，会带进度ui。而静默爬取则没有ui.

在调用sdk之前，需要先做两件事：

1. 在dspider官网注册后在控制台创建应用。
2. 创建应用后，添加需要爬虫到你的应用。

### 显式爬取

#### 启动爬取

每一个爬取任务对应一个脚本，每一个爬虫都有一个id, 我们称之为sid。

```java
DSpider.build(context)
       .start(sid);
```

#### 获取爬取数据

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



#### API列表

 **build(context)**

- 功能: 创建dspider实例
- context: 当前activity context
- 返回：DSpider实例

**start(int sid,[String title])**

- 功能：启动爬取任务
- sid: spider id, 需要执行的爬取功能id
- title:可选参数，爬取页默认标题。


 **addArgument(String name,Object value)**

- 功能：调用sdk时添加调用参数，该参数会传递到爬取脚本，脚本中可以通过session.getArguments()方法获得。

假设有一个爬取邮件的spider,需要两个参数，一个关键字wd, 和需要爬取的邮件数量count，我们可以如下方式调用：

```java
DSpider.build(this,"1")
       .addArgument("wd","招商银行")
       .addArgument("count",20)
       .start(sid);
```

### 静默爬取

提供了一个自定义控件DSpiderView，你可以将它放到当前界面z序的最后面，或者将其隐藏。

```java
spiderView.start(sid, spiderEventListener);
SpiderEventListener spiderEventListener=new SpiderEventListener() {
        @Override
        public void onResult(String sessionKey, List<String> data) {
          //在此获取爬取结果
        }

        @Override
        public void onProgress(int progress, int max) {
        }

        @Override
        public void onProgressShow(boolean isShow) {
        }

        @Override
        public void onProgressMsg(String msg) { 
        }

        @Override
        public void onError(final int code, final String msg) {
           //错误处理
        }
    };  
```

爬取过程中，脚本会触发多次回调给端，端只需要实现关注回调接口即可。用户也可以自定义进度ui。

#### API列表

**void start(int sid, SpiderEventListener)** 

- SpiderEventListener 为爬取过程回调，开发者只需实现感兴趣的。

**boolean canRetry()**

检测是否可以重试，一般在onError中调用

**void retry()**

重试，如果可以重试，调用此方法可以启动重试。

## 调试支持

dspider所有爬取脚本都是从服务器下发，但调试模式下会从本地加载，假设你写了一个爬取脚本a.js，爬取的起始页面地址为：https://xx.com

1. 将a.js放到assets目录下

2. 以调试模式启动sdk:

   ```java
   //显式爬取
   DSpider.build(this)
          .startDebug(sid,"爬取测试","a.js","https://xx.com");
   //静默爬取
   spiderView.startDebug("爬取测试","https://xx.com")
   ```
