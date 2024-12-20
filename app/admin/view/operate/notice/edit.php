{extend name="public:layui"}

{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">公告标题</label>
                    <div class="layui-input-inline">
                        <input type="text" name="title" value="{$announcement.title}"  required  lay-verify="required" placeholder="请输入公告标题" autocomplete="off" class="layui-input">
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
    layui.use(['table','form','layer','layedit'], function () {

        var form = layui.form,table = layui.table,layer = layui.layer,layedit = layui.layedit;

        const E = window.wangEditor
        const editor = new E('#editor—wrapper')
        // 配置 server 接口地址
        editor.config.uploadImgServer = '{:url('uploadImage2')}'
        editor.config.uploadFileName = 'file'//这里是填写input file 格式的文件名name="file" 重要
        editor.config.uploadImgMaxSize = 2 * 1024 * 1024 // 2M//限制图片大小
        editor.config.uploadImgMaxLength = 1 // 一次最多上传 1 个图片

        editor.create()

        let id = '{$announcement.id}',description = '{:json_decode($announcement.content)}'; //建立编辑器;

        form.on('submit(formDemo)', function(data){
            // console.log(layedit.getContent(contentIndex))
            // console.log(data.field)
            // return ;
            $.post("{:url('save')}",{
                content:editor.txt.html(),
                title:data.field.title,
                id : id,
            },function (res) {
                res = JSON.parse(res)
                if(res.code == 200){
                    layer.msg('修改成功')
                    parent.$(".J_iframe:visible")[0].contentWindow.location.reload(); setTimeout(function(){parent.layer.close(parent.layer.getFrameIndex(window.name));},1000)

                }else {
                    layer.msg(res.msg)
                }

            })
            return false;
        });

        editor.txt.html(description) // 重新设置编辑器内容


    });

</script>
{/block}

