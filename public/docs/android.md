
# Android SDK集成文档

## Android studio集成

 ### 1.下载 

sdk下载：https://dspider.dtworkroom.com/download/android_sdk

demo： https://github.com/wendux/DSpiderDemo-Android

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
```

sdk有两种调用方式：**显式爬取**和**静默爬取**，显式爬取展示爬取过程进度，会带进度ui。而静默爬取则没有ui.

在调用sdk之前，需要先做两件事：

1. 在dspider官网注册后在控制台创建应用。
2. 创建应用后，添加需要爬虫到你的应用。

## 初始化

无论是显式爬取还是静默爬取，调用sdk的第一步都要先初始化：

```java
DSpider.init(Context,AppId);
```

创建完应用后，系统会自动为该应用分配一个 App Id, 可在用户中心查看。

## 显式爬取

### 启动爬取

每一个爬取任务对应一个脚本，每一个爬虫都有一个id, 我们称之为sid。title为爬取进度页标题。

```java
DSpider.build(context)
       .start(title,sid);
```

### 获取爬取数据

```java
protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == DSpider.REQUEST ) {
            if(resultCode == RESULT_OK) {
                DSpider.Result resultData = DSpider.getLastResult()；
            } 
        }
       ...
}
```

### DSpider API列表

####  **build(context)**

- 功能: 创建dspider实例
- context: 当前activity context
- 返回：DSpider实例

#### **start(int sid,[String title])**

- 功能：启动爬取任务
- sid: spider id, 需要执行的爬取功能id
- title:可选参数，爬取页默认标题。


####  **addArgument(String name,Object value)**

- 功能：调用sdk时添加调用参数，该参数会传递到爬取脚本，脚本中可以通过session.getArguments()方法获得。

假设有一个爬取邮件的spider,需要两个参数，一个关键字wd, 和需要爬取的邮件数量count，我们可以如下方式调用：

```java
DSpider.build(this,"1")
       .addArgument("wd","招商银行")
       .addArgument("count",20)
       .start(sid);
```

#### DSpider.Result  getLastResult()

- 获取上次**显式爬取**的结果
- 返回值Result结构，包括爬取到的数据、错误码、错误信息。

### DSpider setOnRetryTip(int type,String msg)

为保证爬取成功率，一个爬虫可以拥有多个爬取脚本，每个脚本都有一个优先级，然后会按优先级，从高到低下发(请参考帮助文档：https://dspider.dtworkroom.com/md/help)。此方法用于设置爬取脚本失败且还有其它脚本可用时给用户的提示方式和提示信息：

| type        | 解释                             |
| ----------- | ------------------------------ |
| TYPE_TOAST  | 提示为toast形式                     |
| TYPE_DIALOG | 提示为对话框形式，此时点“确定”则继续，点“取消”则结束爬取 |
| TYPE_NONE   | 无提示，忽略msg,  自动重试.              |

建议：最好加上提示，理由时有时爬取在走道50%失败时，此时进度条刚走到一半，爬取会从头开始，进度条又会从0开始，如果没有提示而直接重试的话，体验会很怪。

### DSpider setOnRetryListener(OnRetryListener retryListener)

- 设置重试策略回调。

有时setOnRetryTip接口并不能满足所有需求，假设一个爬虫有五个脚本，但是我们只想让它最多尝试三次，此时可以设置此回调。

```java
  DSpider.build(this)
 .setOnRetryListener(new OnRetryListener() {
                int count=0;
                 //返回true则重试，false则中断重试直接返回， code和msg分别为上次错误码和错误信息。
                @Override
                public boolean onRetry(int code, String msg) {
                    count++;
                    if(count>3){
                        return false;
                    }
                    return true;
                }
      })
      .start(1,"测试")
```

## 静默爬取

提供了一个自定义控件DSpiderView，你可以将它放到当前界面z序的最后面，或者将其隐藏。

```java
spiderView.start(sid, spiderEventListener);
SpiderEventListener spiderEventListener=new SpiderEventListener() {
        @Override
        public void onResult(String sessionKey, List<String> data) {
          //在此获取爬取结果；爬取结束且成功后会调用此回调。data为一个列表，
          //脚本中每调用一次push,端上便将传过来的数据加入到此列表
        }
  
        @Override
        public void onError(final int code, final String msg) {
           //错误处理，爬取失败会走到这里，错误码见下文
        }

        @Override
        public void onProgress(int progress, int max) {
          //此回调供自定义进度条时使用：脚本会传递进度信息给端，当前进度值为 progress/max.
          //静默爬取可忽略此回调.
        }

        @Override
        public void onProgressShow(boolean isShow) {
          //此回调供自定义进度条时使用：脚本会动态设置是否显示进度条，但显示时isShow为true,
          //隐藏时则为false. 静默爬取可忽略此回调.
        }

        @Override
        public void onProgressMsg(String msg) { 
          //此回调供自定义进度条时使用：脚本可能会在不同爬取阶段输出不同的提示信息，
          //端上可以在此回调中接收处理进度消息。
        }
  
        @Override
        public void onScriptLoaded(int scriptIndex){
          //此回调供自定义进度条时使用,也可以统计重试次数等。
          //此回调脚本下发成功后，执行前被调用，scriptIndex表示当前下发的是第几个脚本。
          //端上可以在此处理一些逻辑，比如scriptIndex >1时可提示 "正在重试新的方案"
        }
  
  		@Override
        public void onLog(String log, int type) {
         //脚本中每调用一次log函数，此方法都会被调用，可以在此处理日志，也可以自定义数据结构和脚本通信。
        }
       
    };  
```

爬取过程中，脚本会触发多次回调给端，端上只需要实现关注回调接口即可。用户也可以自定义进度ui。

### SpiderView API列表

#### **void start(int sid, SpiderEventListener)** 

SpiderEventListener 为爬取过程回调，开发者只需实现感兴趣的。

#### **void stop()** 

停止爬取

#### **boolean canRetry()**

检测是否可以重试，一般在onError中调用

#### **void retry()**

重试，如果可以重试，调用此方法可以启动重试。

#### setArguments(Map<String, Object> arguments)

设置传递给脚本的参数map，sdk内部会将arguments转化为json对象传递给js脚本。

#### setArguments(String  jsonString)

功能同上，只是参数类型变味string. 注：string必须为合法的json字符串

#### clearCache()

清楚爬取缓存，会清楚cookie信息等。

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




## 错误码

错误码定义在DSpider.Result内部类中

| 错误码                        | 意义                    |
| -------------------------- | --------------------- |
| STATE_SUCCEED              | 成功                    |
| STATE_WEB_ERROR            | 目标网站服务器错误，可能时4xx,5xx. |
| STATE_SCRIPT_ERROR         | 爬取脚本错误：脚本中触发了异常。      |
| STATE_PAGE_CHANGED         | 目标网页发生变化（导致目前脚本不可用）。  |
| STATE_TIMEOUT              | 爬取超时（超时时间在脚本中设置）      |
| STATE_DSPIDER_SERVER_ERROR | dspider服务器连接失败        |
| STATE_ERROR_MSG            | sdk提示类错误，此时可以输出错误信息。  |



## 数据持久化接口

有时，脚本中需要持久保存一些信息，下次爬取时可能会使用，比如保存用户名，下次打开登录页时，脚本自动填充进去。sdk中默认会存储在sharedPreferences中，按sessionKey隔离，这也就意味着不同sessionKey不能访问彼此的持久话数据。但是，有时候，这并不能完全满足业务需求，比如现在有关个需求是：爬取用户通话记录，端在每次调用爬取时，都会将当前用户手机号传递给脚本，假设脚本会在用户登录成功后会调用持久化接口保存用户密码（第二次爬取时就不用输入密码了），这样在客户端用户不变的时候是没有问题的，但是如果用户换账号登录，这时后手机号已经变了，脚本取出的密码还是上一个手机号的，这时就会有问题。解决这个问题的方法有两个：

1. 脚本同时保存手机号＝》密码。
2. 端上将持久化的数据根据用户uid进行隔离。

第一种，脚本端逻辑比较复杂，如果同时有好几个业务，这样会带来大量的重复工作，并且也不安全（同一个脚本可以读取不同用户的信息）

采用第二种方法，我们只需要在初始化时实现持久化接口就行：

```java
DSpider.setPersistenceImp(new IPersistence() {
            //每个用户的信息存储在各自的域下,域通过userid区分
            private SharedPreferences sharedPreferences=context. 
                    getSharedPreferences(UserInfo.getUserId() + "_dspider", Context.MODE_PRIVATE);
            @Override
            public void save(String key, String value) {
                if (TextUtils.isEmpty(value)) {
                    sharedPreferences.edit().remove(key).commit();
                } else {
                    sharedPreferences.edit().putString(key, value).commit();
                }
            }
  
            @Override
            public String read(String key) {
                return sharedPreferences.getString(key, "");
            }
 });
```