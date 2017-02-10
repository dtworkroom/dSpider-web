@extends('layouts.profile')

@section('head')
    <style>
        #appinfo {
            padding: 20px 0;
            margin-bottom: 20px;;
            text-align: center;
            background: #fcfcfc;
            border-radius: 4px;
            border: #f5f5f5 1px solid;
        }

        #appinfo>span {
            margin-left: 3px;
            margin-right: 20px;
            color: #555;
        }

        label{
            margin-right: 10px;
            font-weight: normal;
        }
        a{cursor: pointer}

        .state{
            padding-top: 20px;
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 ">

                    <h2>应用统计</h2>

                        <div id="appinfo">
                            脚本名:<span> <a>xx</a></span>
                            结果:
                            <span>
                                @{{data.total>0?"共"+data.total+"条记录。":"暂无爬取记录。"}}
                            </span>
                            使用的应用数:
                            <span>
                                @{{data.app_count}}
                            </span>

                            <div class="form-group state">
                                <label>结果状态: </label>
                                <label class="radio-inline">
                                    <input type="radio" name="state" @click="ch_state(1000)"  v-model="state" value="
                                    1000"> 全部
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="state" @click="ch_state(0)" v-model="state" value="0"> 成功
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="state" @click="ch_state(1)" v-model="state" value="1"> 失败
                                </label>

                            </div>

                    </div>
                    <h2>详细列表 <span style=" font-size: 15px; color: #000;margin-left: 20px">
                            @{{data.total>0?"共 "+data.total+" 条记录。":"暂无爬取记录。"}}
                     </span></h2>
                    <table class="table table-striped" v-if="data.data.length>0">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>应用名</th>
                            <th>状态</th>
                            <th>app版本</th>
                            <th>sdk版本</th>
                            <th>时间</th>
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
                                <td>@{{record.sdk_version}}</td>
                                <td>@{{record.updated_at}}</td>
                                <td>
                                    <a :href="root+'profile/record/'+record.id"><span
                                                class="glyphicon glyphicon-eye-open"></span></a>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>


                </div>
                {{--超过一页显示分页--}}
                <nav v-if="data.last_page>1" style="text-align: center">
                    <ul class="pagination">
                        <li :class="{disabled:data.current_page==1}"><a @click="go(data.current_page-1)">&laquo;</a>
                        </li>
                        <template v-for="n of 10">
                            <li v-if="data.current_page+n-1<=data.last_page" :class="{ active:n==1 }">
                                <a @click="go(data.current_page+n-1)"> @{{data.current_page+n-1}} </a>
                            </li>
                        </template>
                        <li :class="{disabled:data.current_page==data.last_page}"><a @click="go(data.current_page+1)"
                            >&raquo;</a></li>
                    </ul>
                </nav>

            </div>
    </div>
@endsection

@section('footer')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                app: {},
                data: {total: 0, data: []}, //默认值
                //route
                state: 1000,
                root: root

            },
            methods: {
                go: function (page) {
                    if (page <= this.data.last_page) {
                        var args = getArgs()
                        args.page = page;
                        location.hash = JSON.stringify(args);
                    }
                },
                ch_state: function (state) {
                    var args = getArgs()
                    args.page = 1;
                    if (state == 1000) {
                        args.state = undefined;
                    } else {
                        args.state = state;
                    }
                    location.hash = JSON.stringify(args);
                },
            }
        })

        function getArgs() {
            return JSON.parse(location.hash.substr(1) || "{}")
        }

        function mapData(data) {
            data.data.forEach(function (item) {
                item.state = item.state > 0 ? "失败" : "成功";
                return item
            })
            return data;
        }


        var state = getArgs().state
        if (state != undefined) app.state = state;
        update();
        addEventListener('hashchange', function () {
            update()
        })
        var lastArgs = {};
        function update() {
            var args = getArgs()
            args = $.extend({spider_id: qs.id, pageSize: 40, page: 1}, args);
            if (JSON.stringify(args) != JSON.stringify(lastArgs)) {
                lastArgs = args
                $.post(prefix + "profile/records/spider/" + qs.id, args).done(function (data) {
                    app.data = mapData(data);
                })
            }
        }

        $("title").text(qs.name)
        $("#appinfo a").attr("href", root + "spider/" + qs.id).text(qs.name)


    </script>
@endsection
