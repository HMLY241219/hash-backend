{extend name="public:layui"}
{block name="content"}
<style>
    .layui-card {
        width: 500px;
        margin: 30px auto;
        padding: 20px;
    }

    .layui-progress {
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>

<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">导入召回用户ID</label>
                    <div class="layui-input-inline">
                        <button type="button" class="layui-btn" id="selectFile">选择文件</button>
                    </div>
                    <div id="fileName" class="layui-form-mid layui-word-aux">请选择要导入的文件</div>
                </div>


                <div class="layui-progress" lay-showPercent="true" lay-filter="demo" id="uploadProgress" style="display: none;">
                    <div class="layui-progress-bar layui-bg-green" lay-percent="0%"></div>
                </div>

<!--                <div class="layui-form-item">-->
<!--                    <label class="layui-form-label">请输入发送内容</label>-->
<!--                    <div class="layui-input-inline">-->
<!--                        <input type="text" id="messageInput" name="messageInput" required lay-verify="required" placeholder="请输入发送内容" autocomplete="off" class="layui-input">-->
<!--                    </div>-->
<!--                    <div class="layui-form-mid layui-word-aux">请输入要发送的内容</div>-->
<!--                </div>-->


                <div class="layui-form-item">
                    <label class="layui-form-label">选择包名</label>
                    <div class="layui-input-inline">
                        <select name="messageInput" lay-filter="package">

                            <option value="0">请选择</option>
                            {volist name='recallOldPackage' id='val'}
                            <option  value="{$val.package_id}">{$val.bagname}</option>
                            {/volist}

                        </select>
                    </div>
                    <div class="layui-form-mid layui-word-aux">选择一个发送的包</div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    layui.use(['upload', 'layer', 'form', 'element'], function () {
        var upload = layui.upload;
        var layer = layui.layer;
        var form = layui.form;
        var element = layui.element;

        var fileContent = null; // 保存文件内容
        // 上传文件
        upload.render({
            elem: '#selectFile',
            url: "{:url('upload')}", // 替换为实际的文件上传接口
            exts: 'xls|xlsx', //只允许上传excel文件
            before: function () {
                layer.msg('文件上传中...', {icon: 16, shade: 0.3, time: 0});
                $('#fileName').text('文件上传中...');
                $('#uploadProgress').show();
            },
            done: function (res) {
                if (res.code === 200) {
                    layer.msg('文件上传成功', {icon: 1});
                    $('#fileName').text('上传完成');
                    console.log(res,5555);
                    fileContent = res.data; // 假设已经获取到文件内容

                } else {
                    layer.msg('文件上传失败', {icon: 2});
                    $('#fileName').text('请选择要导入的文件');
                }
            },
            error: function () {
                layer.msg('文件上传失败', {icon: 2});
                $('#fileName').text('请选择要导入的文件');
            },
            progress: function (percent) {
                var progressBar = $('#uploadProgress .layui-progress-bar');
                progressBar.css('width', percent + '%');
                element.progress('demo', percent + '%');
            }
        });

        // 提交表单
        form.on('submit(formDemo)', function (data) {
            var message = data.field.messageInput;

            if (!fileContent) {
                layer.msg('请先选择文件', {icon: 0});
                return false;
            }
            console.log(message,1111)
            console.log(fileContent,333)

            let loading = layer.msg('发送中', {icon: 16, time: 30 * 1000})
            // 发送文件内容和发送内容到后台进行处理
            $.post("{:url('send')}", {
                uidArray: fileContent,
                content: message
            }, function (res) {
                layer.close(loading); // 关闭loading
                res = JSON.parse(res);

                if (res.code == 200) {
                    layer.msg(res.msg, {icon: 1});
                    parent.$(".J_iframe:visible")[0].contentWindow.location.reload(); setTimeout(function(){parent.layer.close(parent.layer.getFrameIndex(window.name));},1000)
                } else {
                    layer.msg(res.msg, {icon: 2});
                    parent.$(".J_iframe:visible")[0].contentWindow.location.reload(); setTimeout(function(){parent.layer.close(parent.layer.getFrameIndex(window.name));},1000)
                    // 处理提交失败情况
                }

            });

            return false;// 阻止表单的默认提交
        });
    });
</script>
{/block}