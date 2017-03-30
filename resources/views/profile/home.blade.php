@extends('layouts.profile')

@section('head')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                {{--<template v-for="(app, index) in data.data">--}}
                <h2>个人信息</h2>
                <form role="form" @submit.prevent="update" id="spider">
                    <div class="form-group">
                        <label>昵称</label>
                        <input class="form-control" v-model="data.name" required placeholder="不要超过50个字符">
                    </div>
                    <div class="form-group">
                        <label>邮箱</label>
                        <input class="form-control" v-model="data.email" required disabled
                               placeholder="邮箱">
                    </div>
                    <a href="#" onclick=" document.getElementById('logout-form').submit(); return false;">退出登录</a>
                    <button type="submit" v-show="data.name!=originalName" style="margin-left: 20px;"
                            class="btn btn-success btn-sm">提交更新
                    </button>
                </form>

                <h2 style="margin-top: 40px">我的应用</h2>
                <table class="table" v-if="data.appKey&&data.appKey.length>0">
                    <thead>
                    <tr>
                        <th>标号</th>
                        <th>App Id</th>
                        <th>名称</th>
                        <th>包名</th>
                        <th>状态</th>
                        <th>创建日期</th>
                        <th>编辑</th>
                        <th>统计</th>

                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="(appkey, index) in data.appKey">
                        <tr>
                            <td>@{{index+1}}</td>
                            <td>@{{ appkey.id }}</td>
                            <td>@{{appkey.name}}</td>
                            <td>@{{appkey.package}}</td>
                            <td v-if="appkey.state==1" style="color: green">正常</td>
                            <td v-else>被禁用</td>
                            <td>@{{appkey.created_at}}</td>
                            <td>
                                <a :href="'./profile/appkey/save/'+appkey.id">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                            </td>

                            <td>
                                <a :href='root+"profile/record/appkey/"+appkey.id'><span class="glyphicon glyphicon-stats"></span></a>
                            </td>

                        </tr>
                    </template>
                    </tbody>
                </table>
                <a href="profile/appkey/save" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>
                    添加应用</a>
                {{--</template>--}}
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        var name = ""
        var app = new Vue({
            el: '#app',
            data: {
                data: {}, //默认值
                originalName: "",
                root:root
            },
            methods: {
                save: function (id) {
                    location = "./spide" + (id ? "/" + id : "");
                },
                update: function () {
                    $.post(prefix + "profile/update", {name: app.data.name}).done(function (data) {
                        alert("更新成功!")
                        app.originalName = app.data.name;
                    })
                }
            }
        })

        $.post(prefix + "profile").done(function (data) {
            app.originalName = data.name;
            app.data = data;

        })

    </script>
@endsection
