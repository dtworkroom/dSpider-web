@extends('layouts.profile')
@section('head')
    {{--<link href="{{ url('public/css/spider-edit.css')}}" rel="stylesheet">--}}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <form role="form" @submit.prevent="submit" enctype="multipart/form-data" id="spider">
                    <div class="form-group">
                        <label>脚本名称</label>
                        <input class="form-control" v-model="spider.name" required placeholder="不要超过50个字符">
                    </div>
                    <div class="form-group">
                        <label>介绍</label>
                        <input class="form-control" v-model="spider.description" required
                               placeholder="一句话简介,不要超过200个字符">
                    </div>

                    <div class="form-group">
                        <label>起始地址</label>
                        <input type="url" class="form-control" v-model="spider.startUrl" required
                               placeholder="起始页面url">
                    </div>
                    <div class="form-group">
                    <label>图标</label>
                    <a class="btn btn-default" onclick="file.click()" style="width: 100px; height: 33px">
                       <span id="file-tit" style="color: #777">选择图标</span>
                      <input type="file" id="file" onchange="onfileChange(this)"  style="display: none; width: 100%;height: 100% ">
                    </a>
                    <div>
                        <img v-show="spider.icon" :src="root+'storage/app/img/icon/'+spider.icon" style="display: none; margin-top: 15px; width: 90px; height: 90px;" id="preview">
                    </div>
                    <p class="file-help-block" style="margin-top: 5px;">图标可选,但公开脚本必须有图标,尺寸120*120;</p>
                    </div>
                    <div class="form-group">
                        <label>分类 </label>
                        <select v-model="spider.category">
                            <option value="0">无</option>
                            <option value="1">征信</option>
                            <option value="2">邮箱</option>
                            <option value="3">小说</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>是否公开</label><br>
                        <input type="checkbox" v-model="spider.public"> 公开 (选中后,该脚本会被其它人检索到)
                    </div>
                    <div class="form-group">
                        <label>默认 User-Agent</label><br>
                        <label class="radio-inline">
                            <input type="radio" name="ua" v-model="spider.ua" value="1"> 手机
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="ua" v-model="spider.ua" value="2"> 电脑
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="ua" v-model="spider.ua" value="3"> 自动
                        </label>
                    </div>

                    <div class="form-group">
                        <label>支持的平台</label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" v-model="support" value="1"> Android
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" v-model="support" value="2"> IOS
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" v-model="support" value="4"> PC
                        </label>
                    </div>

                    <div class="form-group">
                        <label>权限</label><br>
                        <label class="checkbox-inline">
                            <input type="checkbox" v-model="access" value="1"> 允许下发
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" v-model="access" value="2"> 允许查看源码
                        </label>
                    </div>

                    <div class="form-group">
                        <label>脚本源代码</label>
                        <textarea class="form-control" rows="10" v-model.trim="spider.content" required
                                  placeholder="将代码粘贴到此处"></textarea>
                    </div>

                    <div class="form-group">
                        <label>默认配置</label>
                        <textarea class="form-control" rows="10" v-model.trim="spider.defaultConfig"
                                  placeholder="必须为合法的json对象字符串,可以不填"></textarea>
                    </div>

                    <div class="form-group">
                        <label>脚本描述</label>
                        <textarea class="form-control" rows="10" v-model.trim="spider.readme"
                                  placeholder="脚本功能、使用方法等,可以不填,支持markdown"></textarea>
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
      var ok=false;
      function onfileChange(e){
            var filePath=e.value;
            var help=$(".file-help-block");
            if(e.files[0].size>50000){
                help.css("color","red").text("文件大小不能超过50KB");
            }
            console.log(filePath)
            var ext;
            $.each(["png","jpg","jpeg","gif"],function(_,el){
              if(filePath.indexOf(el)!=-1){
                  ok=true;
                  ext=el;
                  var windowURL = window.URL || window.webkitURL;
                  var dataURL;
                  var $img = $("#preview");
                  if(e.files && e.files[0]){
                      dataURL = windowURL.createObjectURL(e.files[0]);
                      $img.attr('src',dataURL);
                  }else{
                      var imgObj = $img[0];
                      imgObj.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                      imgObj.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = filePath;
                  }
                  $img.show();
                  return false;
              }
            })
            $("#file-tit").text("重新选择")
            if(ok){
                var arr=filePath.split('\\');
                var fileName=arr[arr.length-1];
                help.css("color","#777").text(fileName);
            }else{
                help.css("color","red").text("文件类型有误！只能是png、jpg、jpeg、gif.");
                return false
            }
        }

        //初始化数据 后面不应该再使用
        var spider = {
            "public": 1,//是否公开，0代表私有脚本，1代表公开脚本，公开脚本可以被其它用户检索到。
            "ua": 2,//默认爬取的起始ua，1:手机 2:pc
            "access": 3,
            "support": 0
        }

        var app = new Vue({
            el: '#spider',
            data: {
                spider: {},
                root:root
            },
            computed: {
                access: {
                    set(v){
                        this.spider.access = getAccess(v)
                    },
                    get(){
                        return parseAccess(this.spider.access)
                    }
                },
                support: {
                    set(v){
                        this.spider.support = getAccess(v)
                    },
                    get(){
                        return parseAccess(this.spider.support)
                    }
                }
            },
            methods: {
                submit: function () {
                    var c = this.spider.defaultConfig
                    if (c&&c.trim() != "" && !isJson(c, "默认配置项的值必须是合法json对象字符串!")) {
                        return;
                    }
                    var $btn = $("#submit").button('loading')
                    var formData = new FormData();
                    if(ok) {
                        formData.append("icon", $("#file")[0].files[0]);
                    }
                    formData.append("spider",JSON.stringify(this.spider));
                    $.ajax({
                        url : prefix + "profile/spider/save",
                        type : 'POST',
                        data : formData,
                        processData : false,
                        contentType : false,
                        success : function(data) {
                            alert("更新成功")
                            dialog("更新成功!去查看?").setOk("去查看", function () {
                                location=root+"spider/"+data;
                            }).setCancel("留在本页").show();
                            $btn.button('reset')
                        },
                        error : function() {
                            $btn.button('reset')
                        }
                    });
//                    $.post(prefix + "profile/spider/save", this.spider).done(function (data) {
//                        alert("更新成功")
//                        dialog("更新成功!去查看?").setOk("去查看", function () {
//                            location=root+"spider/"+data;
//                        }).setCancel("留在本页").show();
//                    }).always(function(){
//                        $btn.button('reset')
//                    })

                }
            }
        })
        if (qs.id) {
            $.post(prefix + "spider/" + qs.id).done(function (data) {
                app.spider = data;
            })
        } else {
            app.spider = spider;
        }

    </script>
@endsection