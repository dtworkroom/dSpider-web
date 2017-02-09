@extends('layouts.profile')
@section('head')
    {{--<link href="{{ url('public/css/spider-edit.css')}}" rel="stylesheet">--}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <form role="form" @submit.prevent="submit" enctype="multipart/form-data" id="script">
                    <div class="form-group">
                        <label style="margin-right: 16px">所属Spider:</label>
                        <a :href="root+'spider/'+script.spider_id">@{{spider_name}}</a>
                    </div>
                    <div class="form-group">
                        <label>Min SDK Version  </label>
                        <select v-model="script.min_sdk">
                            <option value="1.0.0">1.0.0</option>
                            <option value="2.0.0">2.0.0</option>
                        </select>
                        <p style="margin-top: 8px; color: #888">脚本支持的最低sdk版本。</p>
                    </div>
                    <div class="form-group">
                        <label>状态</label><br>
                        <input type="checkbox" v-model="script.online"> 上线 (选中后,该脚本将会立即上线生效)
                    </div>
                    <div class="form-group">
                        <label>优先级</label><br>
                        <input type="number" min="0" v-model="script.priority">
                        <p style="margin-top: 8px;color: #888">大于0的整数,数字越大,优先级越高</p>
                    </div>

                    <div class="form-group">
                        <label>脚本源代码</label>
                        <textarea class="form-control" rows="15" v-model.trim="script.content" required
                                  placeholder="将代码粘贴到此处"></textarea>
                    </div>

                    <button id="submit" type="submit" data-loading-text="Loading..." class="btn btn-middle btn-primary">
                        提交
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>

        //初始化数据 后面不应该再使用
        var script = {
            "online": false,
            "min_sdk": "1.0.0",
            "priority":0,
            "spider_id":qs.spider_id
        }
        var spider_name=decodeURI(location.search.substr(4));
        $("title").text(spider_name)
        var app = new Vue({
            el: '#script',
            data: {
                script: script,
                root:root,
                spider_name:spider_name
            },
            computed: {

            },
            methods: {
                submit: function () {
                    var $btn = $("#submit").button('loading')
                    $.post(prefix+"profile/script/save", this.script).done(function (data) {
                        dialog("更新成功!去查看?").setOk("确定", function () {
                            location.href=root+"script/"+data;
                        }).setCancel("留在本页").show();
                    }).always(function(){
                        $btn.button('reset')
                    })

                }
            }
        })
        if (qs.id) {
            $.post(prefix + "profile/script/" + qs.id).done(function (data) {
                console.log(data)
                app.script = data;
                //$("title").text(data.spider.name)
            })
        }

    </script>
@endsection