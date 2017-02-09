@extends('layouts.profile')

@section('head')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 ">
                <div class="panel panel-default">
                    <div class="panel-heading">我的爬虫</div>
                    <div class="panel-body">
                        <span style="margin-right: 30px; color: #000">脚本共计: @{{data.total}} </span>
                        <button @click="save()" type="button" class="btn btn-default btn-middle">
                        <span class="glyphicon glyphicon-plus"></span> 新建
                        </button>
                    </div>
                    <table class="table" v-if="data.total>0">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>名称</th>
                            <th>公开</th>
                            <th>被调次数</th>
                            <th>更新时间</th>
                            <th>脚本</th>
                            <th>编辑</th>
                            <th>详情</th>
                            <th>统计</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="(spider, index) in data.data">
                            <tr>
                                <td style="padding-left: 15px">@{{index+1}}</td>
                                <td><a :href='root+"spider/"+spider.id'>@{{spider.name}}</a></td>
                                <td>@{{spider.public?"是":"否"}}</td>
                                <td>@{{spider.callCount}}</td>
                                <td>@{{spider.updated_at}}</td>
                                <td class="edit" @click="addScript(spider.id,spider.name)">
                                <a><span class="glyphicon glyphicon-plus"></span></a>
                                </td>
                                <td class="edit" @click="save(spider.id)">
                                <a><span class="glyphicon glyphicon-edit"></span></a>
                                </td>
                                <td class="edit">
                                <a :href='root+"spider/"+spider.id'><span class="glyphicon glyphicon-eye-open"></span></a>
                                </td>
                                </td>
                                <td class="edit">
                                <a :href='root+"profile/record/spider/"+spider.id+"?name="+spider.name'><span class="glyphicon glyphicon-stats"></span></a>
                                </td>

                            </tr>
                        </template>
                        </tbody>
                    </table>

                </div>
                {{--超过一页显示分页--}}
                <nav v-if="data.last_page>1" style="text-align: center">
                    <ul class="pagination">
                        <li :class="{disabled:data.prev_page_url==null}"><span>&laquo;</span></li>
                        <template v-for="n of 10">
                            <li v-if="data.current_page+n-1<=data.last_page"  :class="{ active:n==data.current_page }">
                                <a :href="'?page='+n"> @{{n}} </a>
                            </li>
                        </template>
                        <li :class="{disabled:data.next_page_url==null}"><a href="#">&raquo;</a></li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                data: {total: 0}, //默认值
                root:root

            },
            methods: {
                save: function (id) {
                    location = "./spider/save" + (id ? "/" + id : "");
                },
                addScript:function(id,name){
                    location="./script/save/"+id+"?sn="+name;
                }
            }
        })

        $.post(prefix + "spiders").done(function (data) {
            app.data = data;
        })

    </script>
@endsection
