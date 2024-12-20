{extend name="public:layui"}

{block name="content"}
<link href="https://unpkg.com/@wangeditor/editor@latest/dist/css/style.css" rel="stylesheet">
<style>
    #editor—wrapper {
        border: 1px solid #ccc;
        z-index: 100; /* 按需定义 */
    }
    #toolbar-container { border-bottom: 1px solid #ccc; }
    #editor-container { height: 500px; }
</style>
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">公告标题</label>
                    <div class="layui-input-inline">
                        <input type="text" name="title"  required  lay-verify="required" placeholder="请输入新闻标题" autocomplete="off" class="layui-input">
                    </div>
                    <!--                    <div class="layui-form-mid layui-word-aux">管理员账号必填用于登录</div>-->
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">内容</label>
                    <div class="layui-input-block">
                        <div id="editor—wrapper">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                        <!--                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>-->
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
{/block}
{block name="script"}
<script src="https://cdn.jsdelivr.net/npm/wangeditor@latest/dist/wangEditor.min.js"></script>
<script>
    const E = window.wangEditor
    const editor = new E('#editor—wrapper')

    // 配置 server 接口地址
    editor.config.uploadImgServer = '{:url('uploadImage2')}'
    editor.config.uploadFileName = 'file'//这里是填写input file 格式的文件名name="file" 重要
    editor.config.uploadImgMaxSize = 2 * 1024 * 1024 // 2M//限制图片大小
    editor.config.uploadImgMaxLength = 1 // 一次最多上传 1 个图片

    editor.create()
</script>

<script>
    layui.use(['table','form','layer','layedit','upload'], function () {

        var form = layui.form,table = layui.table,layer = layui.layer,layedit = layui.layedit;

        form.on('submit(formDemo)', function(data){
            $.post("{:url('save')}",{
                // content:layedit.getContent(contentIndex),
                content:editor.txt.html(),
                title:data.field.title,
            },function (res) {
                res = JSON.parse(res)
                if(res.code == 200){
                    layer.msg('创建成功')
                    parent.$(".J_iframe:visible")[0].contentWindow.location.reload(); setTimeout(function(){parent.layer.close(parent.layer.getFrameIndex(window.name));},1000)
                }else {
                    layer.msg(res.msg)
                }

            })
            return false;
        });

        var upload = layui.upload;
        //执行实例
        var uploadInst = upload.render({
            elem: '#uploadBtn', //绑定元素
            url: '{:url('uploadImage')}', //上传接口
            done: function (res) {
                //上传完毕回调
                if (res.code === 0) {
                    //上传成功，将图片路径显示在预览区域
                    document.getElementById('previewImg').src = res.data.src;
                    document.getElementById('imageInput').value = res.data.src;
                } else {
                    //上传失败
                    layer.msg(res.msg, {icon: 5});
                }
            },
            error: function () {
                //请求异常回调
                layer.msg('上传失败，请重试', {icon: 5});
            }
        });
    });


</script>

{/block}

