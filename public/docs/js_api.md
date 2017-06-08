
# dSpider Javascript API文档

> 概述：dSpider javascript接口是爬取脚本与客户端通信的桥梁，主要功能有：数据存储、进度展示、判断执行环境、以及一些请求控制能力。dSpider 将每一个爬取任务抽象为一个session，每一个session有一个key用于标识当前爬取任务，不同的业务应有不同的key。而dSpider大多数接口都是挂载在session对象，用于表明所有的操作都是在某个session之上。


## dSpider(sessionKey,[timeOut],callback])

- 功能: 爬取任务入口点，初始化爬取任务。
- sessionKey: 当前爬取任务的key，类型为字符串，不同业务应有不同的key.
- timeOut:脚本超时时间，单位为秒，如果不设置, 默认为－1，表示没有超时限制。
- callback(session, env, dQuery):  爬取环境初始化成功后的回调，也就是真正的爬取代码的入口，需要你来提供。爬取任务初始化成功后，dSpider会回调此函数，同时将session, env, dQuery三个参数传递给callback，它们分别代表：
  1. session: 当前爬取会话对象，也是js api的主要挂载点。
  2. env : 当前爬取环境，如系统信息，sdk版本信息。
  3. dQuery：dQuery对象。dQuery兼容jQuery3.1所有api.

典型的爬取模版如下：

```javascript
//无超时限制
dSpider("email",function(session,env,$){
  //place your code here
})

//设置超时为2分钟
dSpider("email",60*2,function(session,env,$){
  //place your code here
})
```

**注：没有特殊情况，建议所有脚本都加上超时时间！**



下面我们来介绍session的所有方法：

## 数据存储

数据存储类接口：主要为get和set方法，数据会被存储在当前session缓冲区，只有当手动调用finish方法或爬取结束后会被释放，主要用于跨页面共享数据。

### set(key, value)

-  key : 需要保存数据的key,类型为字符串或数字
-  value: 需要保存的数据，可是是对象、字符串、数字。


该函数可以保证数据一定保存成功，无返回值。

### get(key)

- key:需要获取数据的key,和set对应
- 返回值：读取到的数据，如果不存在，则为undefined.

示例：

```javascript
session.set("mailCount",8);
var t=session.get("mailCount")
```

### setLocal、getLocal

set接口保存的数据在session存储区内，一旦爬取任务结束后就会被释放，有时可能需要永久保存一些数据，如记住用户账号，此时可以使用 setLocal、  getLocal方法，这样存取的数据为持久的，会一直存在，即使app重启也依然存在。

```javascript
session.setLocal("Count",8);
var t=session.getLocal("Count")
```

## 进度展示

进度展示必须提供进度信息，如果爬取过程进度不能准确预估，也应提供大概的进度信息。

### showProgress([isShow])

- isShow:可选参数，当值为 true时显示进度条，false时隐藏进度条，默认为true.


### setProgressMax(max)

- 功能：设置进度条的最大值
- max:  最大刻度值，类型为整形

### setProgress(progress,[msg])

- 功能：设置当前进度
- progress： 当前进度值；如果max为100，当前progress为50，那么此接口调用后，进度条会走到中间位置
- msg: 进度描述信息，可选参数。

### setProgressMsg(msg)

- 功能：设置进度描述信息。



示例：比如在爬取qq邮箱时，我们通过邮件列表获得需要爬取的数量count, 先调用showProgress(true)显示进度条，然后我们将count 通过setProgressMax告知系统，之后每爬一封邮件，将当前已爬取的邮件数量作为参数传递给setProgress，直到所有邮件都爬取成功，我们调用showProgress(false)隐藏掉进度条，如果没有手动隐藏，调用finish时，dSpider会自动隐藏。下面是伪代码：

```javascript
dSpider("email",function(session,env,$){
  session.showProgress()
  session.setProgressMax(count)
  //下面时爬取过程
  ...
  session.setProgress(++curCount)
  //上传数据
  ...
  //爬取结束
  session.showProgress(false)

})
```



## 数据上传(Native)

### session.push(data)

- 功能：上传数据
- data:  需要上传的数据，类型为字符串或对象（dSpider会自动转化成json）

注：

1. 调用此接口后，数据会传递给客户端，客户端可能会对数据进行缓存，然后等到爬取结束时整体上传，前端可以简单的认为从数据已经上传。
2. 该接口替代之前的session.upload接口，脚本中不要再使用upload.

### session.finish([errmsg],[content],[code])

- 功能：结束爬取
- 参数: 三个参数都为可选参数，当爬取成功时，不用传任何参数，直接调用即可，当爬取失败时，需指定相关信息：
  1. errmsg: 错误信息，简单的错误描述，类型为字符串，**不能为空字符串** ，如果为空或省略，则认为是成功。
  2. content: 自定义内容字段，可以传递一切有利于错误分析的信息，可以为空字符串，如果为空字符串，dSpider则自动上传错误发生时页面的dom树.
  3. code:错误码，具体值对应的意义由各个业务决定。可选参数，默认为2，页面变化为3。注：不能为0，dSpider内部将0作为成功态对待。

注：此接口调用结束后，则爬取结束，当前session的数据将会被释放，爬取模块退出。**finish调用将作为爬取结束的唯一标志，所以此方法必须保证被调用**。简单的示例如下：

```javascript
//爬取成功，不带任何参数
session.finish()
//errmsg为空，则认为是成功
session.finish("")
//爬取失败,content默认为当前时刻的dom树，code为2
session.finish("没有找到指定的元素，网页结构貌似变了，选择器为 .mail-content"，"", 3)
//爬取失败,网络错误(第三个参数4可以不传)
session.finish("404","网络错误，ajax请求失败",4)
```

**注：如果失败原因已知，则最好指定content，否则dSpider则会将当前页面的dom树作为content内容上传，但是dom结构一般都是非常大的，上传这些信息不仅会消耗一定流量，而且会耗时。**



## 请求控制

### session.load(url,headers)

- 功能，打开指定页面
- url页面地址
- headers请求头，类型object.

```javascript
session.load("xxx.html",{"User-Agent":"xxxx","Refer":"xxx"})
```

 **注：请求头字段首字母要大写，请求头配置只对当此请求有效。**

### session.setUserAgent(userAgent)

设置请求ua，一旦设置全局有效，之后所有请求将使用新的ua，除非手动恢复。

```javascript
session.setUserAgent("Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.23 Mobile Safari/537.36")
```

### session.autoLoadImg(load)

是否加载页面中的图片，load为bool类型。一旦设置全局有效，之后所有请求都会应用此配置

```javascript
//禁止加载图片
session.autoLoadImg(false)
```

**注：**

1. 在爬取电商类网站时一般都不需要图片，建议设为false，这样不仅会大大加快页面加载速度，而且省流量。
2. 此接口IOS暂不支持，脚本调用后，sdk将忽略

## 其它

### session.string()

- 显示所有session中通过set设置的数据到console

### session.log(str|object,[type])

- 功能：输出日志
- 参数1：要输出的内容，类型：字符串或对象
- type: 日志类型,可选参数，1为正常；2为警告；3为错误。默认为正常，用户可以自定义

由于大多数网页中都有很多原有日志，这会干扰我们的代码在调试时输出的日志，log函数会自动给我们的日志加上前缀标签“ dSpider”。log函数先将错误信息打印到控制台，然后发送给端，端上会记录日志文件便于测试。您也可以自己处理日志信息（用户可以自定义日志处理回调，详情查看sdk集成文档）；

**注：全局的log函数会默认输出type为1的日志**

### session.getArguments()

- 功能：获取客户端调用sdk时传递的参数
- 返回：对象，不存在时为空对象｛｝

有些脚本爬取时需要的参数需要客户端调用sdk时动态传递，比如，爬取邮箱信用卡账单时，不同用户的信用卡的开户行可能不一样，在爬取时，指定的发件人就不一样，客户端在调用时需要将该用户信用卡账单的发件人传递给脚本，下面以android为例，sdk中调用如下：

```java
 DSpider.build(this)
        .addArgument("sender","招商银行"）
        .start(sid,title,debugSrcFileName,debugStartUrl);
```

脚本中可以像下面这样获取：

```javascript
> session.getArguments()
> {"sender":"招商银行"}
```

### addArgument(key,value)

脚本中可以动态添加参数，主要场景是跨页面参数传递；

```javascript
session.addArgument("user",{name:"Joe",age:"18"});
```

### setArguments(jsonObject)

设置参数； 此方法会清楚原有的所有参数。

参数为可转化为json string 的object;

```javascript
session.setArguments({
  "phone":"1865244xxxx",
  "user":{
    name:"joe",
    age:"18"
  }
})
```

### showProgressExcept(url)

此api主要在显式爬取时和进度条展示有关：设置一个url, sdk在检测到页面跳转后会判断目标页url是不是此url,若不是，则自动弹起进度条。也就是说，每当页面发生跳转时，除了此url的页面不回弹起进度条，其余页面都会弹起进度条。假设要爬取邮箱，我们希望在邮箱登录页不要显示进度条，因为需要用户去登录，而用户登录成功后，我们可能会去各个邮件页面爬取内容，而爬取过程希望对用户透明，此时简单的做法就是将邮箱登录页url传递给此api。

### getConfig()

- 功能：获取配置
- 返回值：对象，不存在时为空对象｛｝

配置为云控下发，可以在后台配置。

### session.onNavigate

**注：此回调暂不支持ios** !

- 功能：页面发生跳转之前的回调；类型，属性，值为一个回调函数。

说明：有些时候需要在页面跳转之前做一些事情，比如在登录页成功之后，页面本身会自动跳转到成功后的目标页面，在此之前，我们需要弹出loading页面，以免用户看到跳转过程。此时这个回调将非常有用；

**callback(currentUrl)**

- currentUrl 为跳转前页面的url; 下面看一个例子：

假设我们现在qq邮箱登录页面，已知用户登录成功后当前页面会跳转到mail.qq.com/profile?sid=xxxxxx的页面，我们需要在跳转之前就弹出进度条，代码如下：

```javascript
 session.onNavigate=function(url){
   if(url.indexOf("mail.qq.com/profile?sid=xxxxxx")!=-1){
     session.showProgress()
   }
 }
```

 **注：此回调不能有返回值** 

## 环境检测

脚本在执行过程中有时需要系统信息或sdk提供的额外数据，这时，只靠user agent的信息是不够的，dSpider 1.0提供了些默认的数据，这些数据可能会根据业务发生变化，还记得爬取入口函数dSpider回调的第二个参数吗？它就是环境的参数，类型为对象，结构如下：

```javascript
{
  "sdk_version":"1.0",//sdk版本号
  "os_version":"4.2",//系统版本,ios下为8、9、10等
  "os":"android",//或"ios"  
}
```

os取值为“android”、“ios”

## 全局对象或函数

全局对象或函数没有挂接在session上，可以直接调用

### qs

- qs是一个全局对象，保存解析后的url queryString。用于方便提取url参数，这是非常高频的操作

```javascript
假设当前url为：
https://mail.qq.com/xx/uid=889990&sid=1266eef7ab77655
> qs["uid"]
> "889990"
> qs["sid"]
> "1266eef7ab77655"
> qs["xx"]
> undefined
 
```

注：qs返回的结果类型都为字符串，有时你可能需要的是一个整形数字，请用parseInt转换。



### waitDomAvailable(selector,success,fail)

- 功能：等待某个dom可用时（页面中可以找到），默认最长等待10s
- selector: 选择器，用于匹配dom
- success(dom,timeSpan): 可用时回调,dom为jQuery对象，timeSpan为等待的时间，用于分析。
- fail(selector): 10s后指定的dom任不用，则触发此回调，参数为之前指定的选择器。

此函数在dom动态变化的页面时非常有用

### Observe(ob, options, callback)

- 功能: 根据相应的规则，观察dom树变化，变化时触发回调
- ob：要观察的dom对象，注：对象为原生dom 对象，不可直接传递jQuery对象，对于jQuery对象，可以通过下标选择符获得原生dom对象
- options: 观察的条件，如dom中插入新内容、删除内容…具体的内容请参见[MutationObserver](https://developer.mozilla.org/zh-CN/docs/Web/API/MutationObserver) 、或者这里[http://javascript.ruanyifeng.com/dom/mutationobserver.html](http://javascript.ruanyifeng.com/dom/mutationobserver.html) ，Observe是对MutationObserver的简单封装
- callback: 回调，详细内容请参见上面恋歌链接


下面是Observe的源码，很简单

```javascript
MutationObserver = window.MutationObserver || window.WebKitMutationObserver 

 function Observe(ob, options, callback) {
    var mo = new MutationObserver(callback);
    mo.observe(ob, options);
    return mo;
}  
```



## H5页面回调

试想这么一个场景：你写了一个爬取邮箱内容的脚本，脚本在执行过程中需要用户指定一个关键字，那么该怎么做？很显然我们需要一个用户输入关键字的页面，如果是原生开发，我们可以写一个原生界面，然后要求用户输入关键字，然后在调用sdk时把用户输入的关键字传递给sdk，这样在脚本中通过getArguments获取即可获取这个关键字。这样的做的缺点有两个:

1. android和ios要分别写一个用户输入的界面，比较麻烦。
2. 如果脚本需要的参数突然变为两个，那么便只能重新发版了，也就是不灵活。

如果这个输入页可以用h5, 那么这两个问题便迎刃而解。新的方案是：在h5页面中接收用户输入，并将用户输入的关键字用session.set保存，然后跳转到要爬取的目标页面，然后在目标页时，通过session.get获取关键字即可。那么问题来了，做这个h5页面的同学在写页面的时候就要调用dspider接口，但是dspider引擎是在页面加载后才会初始化（接口在dspider初始化完成之后才可用），为了解决这个问题，我们特意提供了一个回调：

### window.onSpiderInited

dspider在初始化成功后会调用此函数，h5页面中只需要实现这个函数即可，如下：

```javascript
window.onSpiderInited=function(dSpider){
     dSpider("email",function(session,env,$) {
        //你的代码   
     })
 }
```

注：此回调中session,env,$可见，全局的对象或方法不可用，如qs、observe、log.

## ES2015 polyfill

polyfill为js 兼容的一个补丁，由于移动端系统版本差异较大，有些低版本的手机上不支持es5（es6）api如：Function.prototype.bind、JSON对象、Array.prototype.includes, String.prototye.trim等api, 为了提高爬取脚本的兼容性，dSpider底层对大多数es5－es2015新api提供了polyfill（详细列表日后将给出），所以你可以无须手动处理这些兼容问题，放心的调用。


