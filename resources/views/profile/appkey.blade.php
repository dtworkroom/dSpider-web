@extends('layouts.profile')
@section('head')
    <style>
        .table .glyphicon {
            margin-left: 7px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                {{--<template v-for="(app, index) in data.data">--}}

                <h2>{{$qs["id"]==0?"新建应用":"更新应用信息"}}</h2>
                <form @submit.prevent="save" role="form">
                    <div class="form-group">
                        <label>名称</label>
                        <input class="form-control" v-model="app.name" required placeholder="应用名字,最多不要超过50个字符">
                    </div>
                    <div class="form-group">
                        <label>包名</label>
                        <input class="form-control" v-model="app.package" required
                               placeholder="如: com.wendu.dspider">
                    </div>

                    <div class="form-group">
                        <label>密钥</label>
                        <input class="form-control" v-model="app.secret" placeholder="不填时系统会自动生成随机密钥">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submit" data-loading-text="提交中..." class="btn btn-default">
                            <span class="glyphicon glyphicon-open"></span>
                            保存
                        </button>
                        <button v-if="app.id" type="button" @click="del" class="btn btn-danger" style="margin-left: 20px">
                        <span class="glyphicon glyphicon-trash"> </span>
                        删除</button>
                    </div>
                </form>
                <template v-if="configs.length>0">
                    <h2 style="margin-top: 50px">正在使用的spiders</h2>
                    <table class="table" style="margin-top: 20px;margin-bottom: 30px">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>名称</th>
                            <th>状态</th>
                            <th>调用次数</th>
                            <th>上次调用时间</th>
                            <th>移除</th>
                            <th>设置</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="config in configs">
                            <tr>
                                <td style="padding-left: 15px">@{{config.id}}</td>
                                <td>
                                    <a :href="root+'spider/'+config.spider_id">
                                    @{{config.name}}
                                    </a>
                                </td>
                                <td><a href="#">@{{config.online?"在线":"已下线"}}</a></td>
                                <td>@{{config.callCount}}</td>
                                <td>@{{config.updated_at}}</td>
                                <td>
                                    <a href="#" @click="remove(config)">
                                        <span class="glyphicon glyphicon-trash"> </span>
                                    </a>
                                </td>
                                <td class="edit">
                                <a href="#">
                                    <span class="glyphicon glyphicon-cog"> </span>
                                </a>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </template>

                <h2 v-if="configs.length==0&&app.id" style="margin-top: 30px;margin-bottom: 30px">该应用没有在使用的脚本</h2>
                <a v-if="app.id" :href="root+'store'" class="btn btn-default">
                    <span class="glyphicon glyphicon-plus"> </span>
                    添加脚本
                </a>
                <a v-if="app.id" :href="root+'profile/record/appkey/'+app.id"  class="btn btn-default">
                    <span class="glyphicon glyphicon-eye-open"> </span>
                    爬取记录
                </a>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                app: {}, //默认值
                configs: [],
                root:root
            },
            methods: {
                save: function () {
                    $("#submit").button('loading')
                    $.post(prefix + "profile/appkey/save", this.app).done(function (data) {
                        dialog(qs.id ? "更新成功" : "创建成功").setOk("确定", function () {
                            location = root + "profile/appkey/save/" + data;
                        }).show()

                    }).error(function () {
                        $("#submit").button("reset")
                    })
                },
                del: function () {
                    dialog("确定要删除" + this.app.name + "? 删除后该应用的所有信息及爬取记录都会被清空。").setCancel("取消").setOk("删除", function () {
                        $.post(prefix + "profile/appkey/delete/" + app.app.id).done(function () {
                            //alert("创建成功,正在跳转至主页")
                            location = root + "home";
                        })

                    }).show()
                },
                remove(config){
                  dialog('确定要移除脚本 "'+config.name+'" ?').setOk("移除",function(){
                      $.post(prefix+"profile/spider_config/delete/"+config.id).done(function(){
                          var index = app.configs.indexOf(config)
                          app.configs.splice(index, 1)
                      })
                  }).show()
                }
            }
        })

        if (qs.id) {
            $.post(prefix + "profile/appkey/" + qs.id).done(function (data) {
                app.app = data.appkey;
                $("title").text(app.app.name);
                app.configs=data.configs
            })
        }

    </script>
@endsection
