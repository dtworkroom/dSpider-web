
# IOS SDK集成文档

## 集成

 ### 1.下载 

sdk下载：https://dspider.dtworkroom.com/download/ios_sdk

demo： https://github.com/wendux/DSpiderDemo-ios

 ### 2. 导入静态库

添加include/spidersdk文件夹到你的工程，然后添加静态库(libspidersdk.a)编译链接: build phases=>link binary with libraries ，添加即可。

### 3. 爬取

sdk有两种调用方式：**显式爬取**和**静默爬取**，显式爬取展示爬取过程进度，会带进度ui。而静默爬取则没有ui.

在调用sdk之前，需要先做两件事：

1. 在dspider官网注册后在控制台创建应用。

2. 创建应用后，添加需要爬虫到你的应用。

   ​

## 初始化

无论是显式爬取还是静默爬取，调用sdk的第一步都要先初始化：

```objective-c
[dSpider init:appId];
```

创建完应用后，系统会自动为该应用分配一个 App Id, 可在用户中心查看。

## 显式爬取

### 启动爬取

每一个爬取任务对应一个脚本，每一个爬虫都有一个id, 我们称之为sid。title为爬取进度页标题。

```objective-c
 DSpiderViewController *controller=[[DSpiderViewController alloc]init];
 controller.resultDelegate=self;
 [self presentViewController:controller animated:YES completion:nil];
 //执行1号spider(sid=1) 详情：https://dspider.dtworkroom.com/spider/1
 [controller start:1 title:@"测试"];
```

### 获取爬取数据

通过resultDelegate处理爬取结果，下面是接口定义

```objective-c
//For DSpiderViewController delegate 
@protocol DSpiderResult<NSObject>
@optional
- (void) onSucceed:(NSString *) sessionKey data:(NSMutableArray * ) data;
- (void) onFail:(int)code :(NSString *)msg;
- (BOOL) onRetry:(int)code :(NSString *)msg;
@end
```

onRetry: 为保证爬取成功率，一个爬虫可以拥有多个爬取脚本，每个脚本都有一个优先级，然后会按优先级，从高到低下发重试(请参考帮助文档：https://dspider.dtworkroom.com/md/help)。sdk提供了干涉重试逻辑的一种机制，可以通过 实现onRetry接口来实现，如果返回为YES,则继续重试，如果为NO,则不会再重试，直接返回上次错误信息。onRetry的参数为上个脚本的错误码和错误信息。



### DSpiderViewController  API列表

#### **-(void)start:(int) sid title:(NSString *)title**

- 功能：启动爬取任务
- sid: spider id, 需要执行的爬取功能id
- title:可选参数，爬取页默认标题。


#### **-(void)setArguments:(NSDictionary *) args;**

- 功能：调用sdk时添加调用参数，该参数会传递到爬取脚本，脚本中可以通过session.getArguments()方法获得。

假设有一个爬取邮件的spider,需要两个参数，一个关键字wd, 和需要爬取的邮件数量count，我们可以如下方式调用：

```java
//oc
[controller setArguments:@{@"wd":@"招商银行",@"count":@20}];

//javascript,值为object对象
>session.getArguments()
>{wd:"招商银行",count:20}  

```

## 静默爬取

提供了一个自定义控件DSpiderDataView，你可以将它放到当前界面最后面，或者将其隐藏。需要设置一个DSpiderDelegate代理，用来处理脚本事件和数据：

```objective-c
spiderView.delegate=self;
[spiderView start:1];
```

DSpiderDelegate定义

```objective-c

	 //在此获取爬取结果；爬取结束且成功后会调用此回调。data为一个列表，
     //脚本中每调用一次push,端上便将传过来的数据加入到此列表
      - (void) onResult:(NSString *) sessionKey data:(NSMutableArray * ) data;
          
     //错误处理，爬取失败会走到这里，错误码见下文
      - (void) onError:(int)code :(NSString *)msg;
         
	 //此回调供自定义进度条时使用：脚本会传递进度信息给端，当前进度值为 progress/max.
     //静默爬取可忽略此回调.
      - (void) onProgress:(int)progress :(int)max;
 
  	 //此回调供自定义进度条时使用：脚本会动态设置是否显示进度条，但显示时isShow为true,
     //隐藏时则为false. 静默爬取可忽略此回调.
      - (void) onProgressShow:(bool) isShow;
          
     //此回调供自定义进度条时使用：脚本可能会在不同爬取阶段输出不同的提示信息，
     //端上可以在此回调中接收处理进度消息。
      - (void) onProgressMsg:(NSString *)msg;
         
  
     //此回调供自定义进度条时使用,也可以统计重试次数等。
     //此回调脚本下发成功后，执行前被调用，scriptIndex表示当前下发的是第几个脚本。
     //端上可以在此处理一些逻辑，比如scriptIndex >1时可提示 "正在重试新的方案"
      - (void) onScriptLoaded:(int) tryTimes;

     //脚本中每调用一次log函数，此方法都会被调用，可以在此处理日志，也可以自定义数据结构和脚本通信。
     - (void) onLog:(NSString *)msg :(int) type;
 
```

爬取过程中，脚本会触发多次回调给端，端上只需要实现关注回调接口即可。用户也可以自定义进度ui。

### DSpiderDataView API列表

#### -(void)start:(int) sid;

启动指定sid的脚本

#### **-(void) stop** 

停止爬取

#### -(bool)canRetry

检测是否可以重试，一般在onError中调用

#### -(void)retry;

重试，如果可以重试，调用此方法可以启动重试。

#### -(void)setArguments:(NSDictionary *) args;

设置传递给脚本的参数map，sdk内部会将arguments转化为json对象传递给js脚本。

## 调试支持

dspider所有爬取脚本都是从服务器下发，但调试模式下会从本地加载，DSpiderViewController和DSpiderDataView都提供了一个方法：

```java
//DSpiderViewController
-(void)startDebug:(NSString *)title debugScript:(NSString *)debugScript debugUrl:(NSString *)debugUrl;
//DSpiderDataView
-(void)startDebug:(NSString *)debugScript debugUrl:(NSString *)debugUrl{
```
-  debugScript为脚本源码
- debugUrl为爬取起始页面url

## 错误码

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

采用第二种方法，DSpiderViewController和DSpiderDataView都提供了一个持久化代理 persistenceDelegate

，下面是持久化接口的定义，我们在存取数据时根据用户id隔离就行

```java
@protocol Persistence<NSObject>
@optional
-(void) save:(NSString*)key :(NSString *) value;
-(NSString *)read: (NSString*)key;
@end
```
