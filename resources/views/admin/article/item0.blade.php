<form class="form form-horizontal" id="form-edit">
    {{csrf_field()}}
    <div class="row cl hidden">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>id：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input id="id" name="id" type="text" class="input-text"
                   value="{{ isset($data->id) ? $data->id : '' }}" placeholder="作品id">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>作品名称：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input id="name" name="name" type="text" class="input-text"
                   value="{{ isset($data->name) ? $data->name : '' }}" placeholder="请输入作品名称">
        </div>
    </div>
    <div class="row cl item c-999">
        <label class="form-label col-xs-4 col-sm-2"></label>
        <div class="formControls col-xs-8 col-sm-9">
            <div>
                <span>最多可以设置30个汉字</span>
            </div>
        </div>
    </div>
    <div class="row cl item">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属业务/类型：</label>
        <div class="formControls col-xs-8 col-sm-9">
             <span class="select-box" style="width: 150px;">
                 <select id="busi_name" name="busi_name" class="select" onchange="selectBusiName();">
                     <option value="">请选择</option>
                     @foreach(\App\Components\Utils::BUSI_NAME_VAL as $key=>$value)
                         <option value="{{$key}}" {{$data->busi_name==strval($key)?'selected':''}}>{{$value}}</option>
                     @endforeach
                 </select>
             </span>
            <span class="select-box" style="width: 150px;">
                 <select id="article_type_id" name="article_type_id" class="select">
                     <option value="">请选择</option>
                     @if(isset($data->article_type))
                         <option value="{{$data->article_type->id}}"
                                 selected="selected">{{$data->article_type->name}}</option>
                     @endif
                 </select>
             </span>
        </div>
    </div>

    <script id="artilce-type-content-template" type="text/x-dot-template">
        <option value="">请选择</option>
        @{{ for(var i=0;i
        <it.length;i++) { }}
        <option value="@{{=it[i].id}}">@{{=it[i].name}}</option>
        @{{ } }}
    </script>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2">设定作者：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input id="author" name="author" type="text" class="input-text"
                   value="{{ isset($data->author) ? $data->author : '' }}" placeholder="请输入作者">
        </div>
    </div>
    <div class="row cl item c-999">
        <label class="form-label col-xs-4 col-sm-2"></label>
        <div class="formControls col-xs-8 col-sm-9">
            <div>
                <span>如果不设定作者，则默认为归属用户信息</span>
            </div>
        </div>
    </div>
    <div class="row cl item">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>归属作者：</label>
        <div class="formControls col-xs-8 col-sm-9">
             <span class="select-box" style="width: 350px;">
                 @if(isset($data->user))
                     <span>{{$data->user->nick_name}}</span>
                 @else
                     <select id="user_id" name="user_id" class="select">
                     <option value="">请选择</option>
                         @foreach($admin_users as $admin_user)
                             <option value="{{$admin_user->id}}">{{$admin_user->nick_name}}</option>
                         @endforeach
                 </select>
                 @endif
             </span>
            <span class="ml-5 c-999">
                此处的归属作者为关联的用户，可以跳转至用户首页
            </span>
        </div>
    </div>

    <div class="row cl item">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>作品缩略图：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input id="img" name="img" type="text" class="input-text" style=""
                   value="{{ isset($data->img) ? $data->img : ''}}"
                   placeholder="请输入选择图片">
            <div id="container" class="margin-top-10">
                <img id="pickfiles"
                     src="{{ isset($data->img) ? $data->img : URL::asset('/img/upload.png') }}"
                     style="width: 350px;">
            </div>
            <div style="font-size: 12px;margin-top: 10px;" class="c-999">*请上传800*600比例尺寸图片</div>
        </div>
    </div>
    <div class="row cl item">
        <label class="form-label col-xs-4 col-sm-2">作品简述：</label>
        <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="desc" name="desc" class="textarea" placeholder="请输入作品简述..." rows=""
                              cols="">{{ isset($data->desc) ? $data->desc : '' }}</textarea>
        </div>
    </div>

    <div class="row cl mt-20">
        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
            <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存配置
            </button>
        </div>
    </div>
</form>

@include('vendor.ueditor.assets')

<script type="text/javascript">

    $(function () {
        //获取七牛token
        initQNUploader();
        //表单提交
        $("#form-edit").validate({
            rules: {
                name: {
                    required: true,
                },
                img: {
                    required: true,
                },
                busi_name: {
                    required: true,
                },
            },
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            submitHandler: function (form) {

                var index = layer.load(2, {time: 10 * 1000}); //加载

                $(form).ajaxSubmit({
                    type: 'POST',
                    url: "{{ URL::asset('/admin/article/edit')}}",
                    success: function (ret) {
                        console.log(JSON.stringify(ret));
                        if (ret.result) {
                            layer.msg('保存成功', {icon: 1, time: 1000});
                            location.replace('{{URL::asset('/admin/article/edit')}}?item={{$item}}&id=' + ret.ret.id);
                        } else {
                            layer.msg(ret.message, {icon: 2, time: 1000});
                        }

                        layer.close(index);
                    },
                    error: function (XmlHttpRequest, textStatus, errorThrown) {
                        layer.msg('保存失败', {icon: 2, time: 1000});
                        console.log("XmlHttpRequest:" + JSON.stringify(XmlHttpRequest));
                        console.log("textStatus:" + textStatus);
                        console.log("errorThrown:" + errorThrown);
                    }
                });
            }

        });
    });


    //初始化七牛上传模块
    function initQNUploader() {
        var uploader = Qiniu.uploader({
            runtimes: 'html5,flash,html4',      // 上传模式，依次退化
            browse_button: 'pickfiles',         // 上传选择的点选按钮，必需
            container: 'container',//上传按钮的上级元素ID
            // 在初始化时，uptoken，uptoken_url，uptoken_func三个参数中必须有一个被设置
            // 切如果提供了多个，其优先级为uptoken > uptoken_url > uptoken_func
            // 其中uptoken是直接提供上传凭证，uptoken_url是提供了获取上传凭证的地址，如果需要定制获取uptoken的过程则可以设置uptoken_func
            uptoken: "{{$upload_token}}", // uptoken是上传凭证，由其他程序生成
            // uptoken_url: '/uptoken',         // Ajax请求uptoken的Url，强烈建议设置（服务端提供）
            // uptoken_func: function(file){    // 在需要获取uptoken时，该方法会被调用
            //    // do something
            //    return uptoken;
            // },
            get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的uptoken
            // downtoken_url: '/downtoken',
            // Ajax请求downToken的Url，私有空间时使用，JS-SDK将向该地址POST文件的key和domain，服务端返回的JSON必须包含url字段，url值为该文件的下载地址
            unique_names: true,              // 默认false，key为文件名。若开启该选项，JS-SDK会为每个文件自动生成key（文件名）
            // save_key: true,                  // 默认false。若在服务端生成uptoken的上传策略中指定了sava_key，则开启，SDK在前端将不对key进行任何处理
            domain: 'http://twst.isart.me/',     // bucket域名，下载资源时用到，必需
            max_file_size: '100mb',             // 最大文件体积限制
            flash_swf_url: 'path/of/plupload/Moxie.swf',  //引入flash，相对路径
            max_retries: 3,                     // 上传失败最大重试次数
            dragdrop: true,                     // 开启可拖曳上传
            drop_element: 'container',          // 拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
            chunk_size: '4mb',                  // 分块上传时，每块的体积
            auto_start: true,                   // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
            //x_vars : {
            //    查看自定义变量
            //    'time' : function(up,file) {
            //        var time = (new Date()).getTime();
            // do something with 'time'
            //        return time;
            //    },
            //    'size' : function(up,file) {
            //        var size = file.size;
            // do something with 'size'
            //        return size;
            //    }
            //},
            init: {
                'FilesAdded': function (up, files) {
                    plupload.each(files, function (file) {
                        // 文件添加进队列后，处理相关的事情
//                                            alert(alert(JSON.stringify(file)));
                    });
                },
                'BeforeUpload': function (up, file) {
                    // 每个文件上传前，处理相关的事情
//                        console.log("BeforeUpload up:" + up + " file:" + JSON.stringify(file));
                },
                'UploadProgress': function (up, file) {
                    // 每个文件上传时，处理相关的事情
//                        console.log("UploadProgress up:" + up + " file:" + JSON.stringify(file));
                },
                'FileUploaded': function (up, file, info) {
                    // 每个文件上传成功后，处理相关的事情
                    // 其中info是文件上传成功后，服务端返回的json，形式如：
                    // {
                    //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                    //    "key": "gogopher.jpg"
                    //  }
                    console.log(JSON.stringify(info));
                    var domain = up.getOption('domain');
                    var res = JSON.parse(info);
                    //获取上传成功后的文件的Url
                    var sourceLink = domain + res.key;
                    $("#img").val(sourceLink);
                    $("#pickfiles").attr('src', sourceLink);
//                        console.log($("#pickfiles").attr('src'));
                },
                'Error': function (up, err, errTip) {
                    //上传出错时，处理相关的事情
                    console.log(err + errTip);
                },
                'UploadComplete': function () {
                    //队列文件处理完毕后，处理相关的事情
                },
                'Key': function (up, file) {
                    // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                    // 该配置必须要在unique_names: false，save_key: false时才生效

                    var key = "";
                    // do something with key here
                    return key
                }
            }
        });
    }

    /*
     * 选择业务分类
     *
     * By TerryQi
     *
     */
    function selectBusiName() {
        var busi_name = $("#busi_name").val();
        //如果busi_name不为空
        if (!judgeIsAnyNullStr(busi_name)) {
            var index = layer.load(2, {time: 10 * 1000}); //加载
            var param = {
                busi_name: busi_name,
                _token: '{{ csrf_token() }}'
            }
            articleType_getListByCon("{{URL::asset('')}}", param, function (ret) {
                //提交成功
                if (ret.result == true) {
                    layer.close(index);
                    $("#article_type_id").html("");
                    var msgObj = ret.ret;
                    var interText = doT.template($("#artilce-type-content-template").text());
                    $("#article_type_id").append(interText(msgObj));
                }
            })
        }
    }

</script>
