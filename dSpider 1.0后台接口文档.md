# dSpider 1.0后台接口文档
domain: api.dspider.dtworkroom.com.
basePath prefix: api/ 
version:1.0

注：

1. 一个spider代表一个爬虫脚本。
2. 所有请求请使用post方法。

**标准返回**

| 字断名  | 类型     | 必需   | 说明                             |
| ---- | ------ | :--- | ------------------------------ |
| code | int    | 是    | 结果状态码：0：成功；非0代表错误，其中－10表示需要登录； |
| data | --     | 是    | 成功时返回具体数据，失败时返回错误信息或为空字符串      |
| msg  | string | 是    | 提示信息。                          |

示例：

```json
//成功返回
{
  "code":0,
  "data":{...},
  "msg":"Login succeed!"
}
//失败返回  
{
  "code":-10,
  "data":"",
  "msg":"Need login!"
}
```



**标准分页参数**

所有支持分页的接口中默认有两个请求参数

| 字断名       | 类型   | 必需          | 说明    |
| --------- | ---- | ----------- | ----- |
| page      | int  | 否（省略时默认为1）  | 当前页数  |
| pageCount | int  | 否（省略时默认为20） | 每页记录数 |

## 1.用户认证

### 1.1 登录

url: login

请求参数：

| 字断名      | 类型     | 必需   | 说明       |
| -------- | ------ | ---- | -------- |
| email    | string | 是    | 注册邮箱     |
| password | string | 是    | 密码       |
| remember | bool   | 是    | 是否记住登录状态 |



## 2.公共接口

### 2.1获取一个spider脚本信息

url: spider/{id}

返回数据：

```javascript
{
    "code": 0,
    "data": {
        "id": 1,
        "name": "test",//脚本名称
        "user_id": 1,//脚本作者id
        "content": "dSpider(){alert('xx')}",//脚本源代码，不一定存在，当前用户对该脚本具有读权限时存在。
        "description": null,//脚本描述信息，string
        "support": 0,//支持的平台。按位与；1支持安卓; 1<<1:ios; 1<<2:pc
        "star": 0,//用户评星数
        "chargeType": 0,//收费方式：0:免费；1:一次性付费；2:按调用次数付费
        "freeLimits": 100,//免费调用次数
        "price": 0,//chargeType为1时为一次性总价，等于2时则为每次调用单价
        "defaultConfig": null,//默认配置，string.
        "callCount": 39,//被执行的总次数
        "public":1,//是否公开，0代表私有脚本，1代表公开脚本，公开脚本可以被其它用户检索到。  
        "startUrl":"xxxxx",//爬虫起始地址  
        "access": 3,//脚本作者赋予使用者的权限 按位与；1:允许使用者调用; 1<<1:允许查看脚本源码
        "size" : 384,//脚本大小，单位B. 
        "created_at": "2016-12-03 11:02:18",
        "updated_at": "2016-12-05 05:42:56"
    },
    "msg": "Ok"
}
```

### 2.2获取所有spider。

url: /spiders

**支持分页。**

返回数据: spider数组.

```javascript
{
    "code": 0,
    "data": [{},...],
    "msg": "Ok"
}
```

注：此接口中的spider对象没有content属性。



## 3.个人中心

### 3.1 获取个人信息

url:profile

返回数据：

```javascript
{
    "code": 0,
    "data": {
        "id": 1,
        "name": "wendu",
        "email": "824783146@qq.com",
        "appKey": [{ //用户所有的appkey数组
            "id": 2,//appkey id
            "user_id": 1,//该appkey的用户id
            "secret": "xxxxxxxxxxx", //appkey的密钥
            "name": "dSpider",//该appkey 对应的app的名字
            "state": 1,//该appkey的状态，1:正常；2:被禁用
            "created_at": "2016-12-03 11:03:59",
            "updated_at": "2016-12-03 11:03:59"
        }]
    },
    "msg": "Ok"
}
```

### 3.2 新建／更新spider

url:profile/spider/save

请求参数

| 字断名           | 类型     | 必需   | 说明                                       |
| :------------ | ------ | ---- | :--------------------------------------- |
| name          | string | 是    | 最长50个字符                                  |
| content       | string | 是    | 脚本源码                                     |
| startUrl      | string | 是    | 爬虫的起始地址                                  |
| id            | int    | 否    | spider id,存在时为更新，否则为新建                   |
| description   | string | 否    | 描述信息，一般为脚本使用介绍                           |
| support       | int    | 否    | 支持的平台，android:0b1; iOS:0b10; PC:0b100, 支持的平台按位或即为最终 support 。 默认为7,即0b111 |
| chargeType    | int    | 否    | 计费方式， 0:免费；1:一次性付费；2:按调用次数付费。默认为0；       |
| price         | float  | 否    | 价格；对应chargeType, 默认为0                    |
| defaultConfig | string | 否    | 默认配置，存在时必需是合法的json字符串，可空。                |
| access        | int    | 否    | 用户对当前脚本的权限；可下发：0b1；可以查看源码：0b10; 最终的权限值按位或即可。默认为3即0b11 |
| freeLimits    | int    | 否    | 如果为收费的脚本，可以允许免费体验调用的次数。默认100.            |
| public        | bool   | 否    | 是否公开，默认为false,即私有脚本                      |



返回：

data：新添加的spider  id.

### 3.3 删除spider

url: profile/spider/delete/{id}

返回：

data: 删除的spider的id

### 3.4 获取当前用户所有spider

url:profile/spider

返回数据结构同2.2。

### 3.5 获取用户所有appkey

url: profile/appkey

返回数据：appkey数组，结构同接口3.1中的appkey字断。

### 3.6 获取单个appkey

url:profile/appkey/{id}

返回数据：appkey结构。

### 3.7 删除appkey

url: profile/appkey/delete/{id}

返回： 删除的appkey的id

### 3.8 新建/更新appkey

url: profile/appkey/save

请求参数：

| 字段名    | 类型     | 必选   | 描述                         |
| ------ | ------ | ---- | -------------------------- |
| secret | string | 否    | 空则自动生成密钥，否则需提供至少6位的密钥      |
| name   | string | 是    | app 名字                     |
| id     | int    | 否    | appkey id, 存在该字断时为更新，否则为新建 |

返回：appkey id；

### 3.9 获取指定id的配置信息

url: profile/spider_config/{id}

若appkey对某个spider有权限，则便会存在针对该spider的一条配置信息。

 返回配置信息：

```javascript
{
    "code": 0,
    "data": {
        "id": 2,
        "content": null,//配置内容
        "spider_id": 1,
        "appKey_id": 2,
        "online": 1,//是否在线，0代表该爬虫已下线，1代表在线 
        "callCount": 39,//该spider在当前appkey下调用的次数
        "created_at": "2016-12-03 11:03:59",
        "updated_at": "2016-12-05 05:42:56"
    },
    "msg": "Ok"
}
```

### 3.10 获取指定appkey下所有的配置信息

返回数据：配置信息数组，配置信息结构同3.9中data字断。

### 3.11 给指定appkey添加／更新配置

如果是添加：只有该appkey将要添加的spider为免费并且在线时才会成功，否则会失败

url: profile/spider_config/save。

请求参数：

| 字断名       | 类型     | 必需                 | 描述                      |
| --------- | ------ | ------------------ | ----------------------- |
| spider_id | int    | 是                  |                         |
| appKey_id | int    | 是                  |                         |
| content   | string | 否（存在时必需为合法json字符串） |                         |
| id        | int    | 否（存在时为更新，否则为新建）    | 当前配置id                  |
| online    | bool   | 否（默认为true）         | 是否在线，false代表下线，true代表上线 |

### 3.12 查看指定id的爬取记录

每次爬取都会生成一条记录，可以通过其id获取记录详情。

url: profile/record/{id}

返回值：

```javascript
{
    "code": 0,
    "data": {
        "id": 1, 
        "appKey_id": 2,
        "spider_id": 1,
        "config": null,//爬取时使用的配置
        "state": -1,//爬取结果状态，－1:任务初始化成功；－2:爬取中；0:爬取成功；大于0为失败
        "msg": null,//错误信息，成功时为null,失败时为json字符串
        "extra": －－,//sdk版本、系统版本、机型等信息
        "platform": 2,//爬取的端，1:android; 2:ios; 4:pc
        "created_at": "2016-12-07 06:43:13",//爬取开始时间
        "updated_at": "2016-12-07 06:43:13"//爬取结束时间
    },
    "msg": "Ok"
}
```
当爬取失败时msg对应的json结构为：
```javascript
{
  "url":"xxx",//失败时的页面地址
  "msg":"",//错误描述
  "content":"", //错误内容；错误内容可由脚本自行指定；如果脚本未指定，则默认为错误页面的整个dom树字符串
}
```

extra为json字符串，不同平台不一样，下面是android下的数据：

```javascript
{
    "device": "HWNXT",
    "version_name": "1.0",
    "sdk_int": "23",
    "id": "HUAWEINXT-AL10",
    "fingerprint": "HUAWEI\/NXT-AL10\/HWNXT:6.0\/HUAWEINXT-AL10\/C00B368:user\/release-keys",
    "brand": "HUAWEI",
    "release": "6.0",
    "version_code": "1",
    "cpu_abi": "arm64-v8a",
    "board": "NXT-AL10",
    "model": "HUAWEI NXT-AL10"
}
```

## 管理员权限(web 1.0先不考虑)

### 4.1 给指定appkey添加/更新配置

只有授予了appkey某个spider的权限时才会生成一条配置，收回权限时则会删除该条配置

url: admin/spider_config/save。

请求参数：

| 字断名       | 类型     | 必需                 | 描述                      |
| --------- | ------ | ------------------ | ----------------------- |
| spider_id | int    | 是                  |                         |
| appKey_id | int    | 是                  |                         |
| content   | string | 否（存在时必需为合法json字符串） |                         |
| id        | int    | 否（存在时为更新，否则为新建）    | 当前配置id                  |
| online    | bool   | 否（默认为true）         | 是否在线，false代表下线，true代表上线 |

返回：更新或添加成功时data为该条配置id.

### 4.2 删除某条配置

删除appkey对应的某个spider的配置意味着撤销对该spider的授权。

url: admin/spider_config/delete/{id}

