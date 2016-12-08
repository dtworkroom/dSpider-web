**环境配置**

1. 新建一个名为dspider的数据库，然后将根目录下spider.sql导入该数据库
2. 修改根目录下.env里和数据库相关的配置

   ```php
     DB_DATABASE=dspider
     DB_USERNAME=xxx 
     DB_PASSWORD=xxx
   ```
3. 前端资源用的是[Elixir](http://laravelacademy.org/post/5962.html) 使用方法点我）来管理，需要安装相关依赖。

   ```javascript
   npm install
   ```


将所有的html/css/js放置resourses下对应的目录，gulp打完包后会在public下生成相应文件，在你的页面中引入public下的文件即可。api接口文档位于根目录下。

注：项目中不使用.html/.htm，一律使用blade模版，文件名 xx.blade.php，resources/views/apiTest.blade.php为示例，访问路由为 apiTest.

**环境要求**

php>=7.0

mysql>=5.0



如何新建页面：

1. 先在resources/views/下创建一个页面模版

2. 在routes/web.php中新建一条路由，如apiTest:

   ```php
   Route::get('/apiTest', function () {
       return view('apiTest'); 
   });
   ```

view的参数对应模版文件前缀名，接下来就可以apiTest路由访问apiTest.blade.php页面。

