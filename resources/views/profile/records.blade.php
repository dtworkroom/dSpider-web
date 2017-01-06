@extends('layouts.profile')

@section('head')
    <style>
        #appinfo {
            color: #000;
            padding: 20px 0;
            margin-bottom: 20px;;
            text-align: center;
            background: #fcfcfc;
            border: #f5f5f5 1px solid;
        }

        #appinfo span {
            margin-left: 3px;
            margin-right: 20px;
            color: #555;
        }

        label{
            margin-right: 10px;
        }
        a{cursor: pointer}
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 ">
                <div class="panel panel-default">
                    <div class="panel-heading">应用统计</div>
                    <div class="panel-body">
                        <div id="appinfo">
                            应用名称:<span><a :href="'../appkey/save/'+app.id">@{{app.name}}</a></span>
                            App Id:<span>@{{app.id}}</span>
                            包名:<span> @{{app.package}} </span>
                        </div>
                        <div class="form-group">
                            <label>脚本筛选: </label>
                            <div class="dropdown" style="display:inline-block;">
                                <button class="btn btn-default dropdown-toggle " type="button" id="dropdownMenu1"
                                        data-toggle="dropdown">
                                    <span id="spider_text">全部脚本</span>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    <li @click="ch_spider(0)"><a>全部脚本</a></li>
                                    <li v-for="config of configs"  @click="ch_spider(config.spider_id,config.name)"><a>@{{config.name}}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>结果状态: </label>
                            <label class="radio-inline">
                                 <input type="radio" name="state" @click="ch_state(1000)"  v-model="state" value="1000"> 全部
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="state" @click="ch_state(0)" v-model="state" value="0"> 成功
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="state" @click="ch_state(1)" v-model="state" value="1"> 失败
                            </label>

                        </div>

                        <div style="font-weight: bold; font-size: 18px;">
                            @{{data.total>0?"共"+data.total+"条记录。":"暂无爬取记录。"}}
                        </div>

                    </div>
                    <table class="table table-striped" v-if="data.data.length>0">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>脚本名</th>
                            <th>状态</th>
                            <th>app版本</th>
                            <th>时间</th>
                            <th>sdk版本</th>
                            <th>详情</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="(record, index) in data.data">
                            <tr>
                                <td style="padding-left: 15px">@{{index+data.from}}</td>
                                <td>@{{record.name}}</td>
                                <td>
                                    <span :style='{color:record.state=="失败"?"red":"green"}'>@{{record.state}}</span>
                                </td>
                                <td>@{{record.app_version}}</td>
                                <td>@{{record.updated_at}}</td>
                                <td>@{{record.sdk_version}}</td>
                                <td>
                                    <a :href="root+'profile/record/'+record.id"><span class="glyphicon glyphicon-eye-open"></span></a>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>


                </div>
                {{--超过一页显示分页--}}
                <nav v-if="data.last_page>1" style="text-align: center">
                    <ul class="pagination">
                        <li :class="{disabled:data.current_page==1}"><a @click="go(data.current_page-1)">&laquo;</a></li>
                        <template v-for="n of 10">
                            <li v-if="data.current_page+n-1<=data.last_page" :class="{ active:n==1 }">
                                <a @click="go(data.current_page+n-1)"> @{{data.current_page+n-1}} </a>
                            </li>
                        </template>
                        <li :class="{disabled:data.current_page==data.last_page}"><a @click="go(data.current_page+1)">&raquo;</a></li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        //save spider names id=>name
        var names = {};

        var app = new Vue({
            el: '#app',
            data: {
                app: {},
                configs: {},
                data: {total: 0, data: []}, //默认值
                //默认请求参数
                state:1000,
                spider_id:0,
                //route
                root:root

            },
            methods: {
                ch_spider:function(id,name){
                    var args=getArgs()
                    args.page=1;
                    if(id==0) {
                        args.spider_id=undefined;
                    }else{
                        args.spider_id=id;
                    }
                    location.hash=JSON.stringify(args);
                },
                ch_state:function(state){
                    var args=getArgs()
                    args.page=1;
                    if(state== 1000) {
                        args.state=undefined;
                    }else{
                        args.state=state;
                    }
                    location.hash=JSON.stringify(args);
                },
                go:function(page){
                    if(page<=this.data.last_page) {
                        var args = getArgs()
                        args.page = page;
                        location.hash = JSON.stringify(args);
                    }
                }
            }
        })

        function getArgs(){
           return JSON.parse(location.hash.substr(1)||"{}")
        }

        function mapData(data) {
            data.data.forEach(function (item) {
                item.name = names[item.spider_id]
                item.state = item.state >0 ? "失败" : "成功";
                return item
            })
            return data;
        }

        $.post(prefix + "profile/appkey/" + qs.id).done(function (data) {
            app.app = data.appkey;
            app.configs = data.configs
            data.configs.forEach(function (item) {
                names[item.spider_id] = item.name;
            })
            var state=getArgs().state
            if(state!=undefined) app.state=state;
            update();
            addEventListener('hashchange', function(){
                update()
            })
        })

       var lastArgs={};
       function update() {
           var args=getArgs()
           var w=$("#spider_text");
           if(!args.spider_id){
               w.text("全部脚本")
           }else{
               w.text(names[args.spider_id])
           }
           args= $.extend({appKey_id: qs.id, pageSize: 40,page:1},args);
           if(JSON.stringify(args)!=JSON.stringify(lastArgs)) {
               lastArgs=args
               $.post(prefix + "profile/records",args).done(function (data) {
                   app.data = mapData(data);
               })
           }
       }


    </script>
@endsection
