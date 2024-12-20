{extend name="public:layout" /}

{block name="title"}个人资料{/block}
{block name="content"}
<div class="layui-fluid">
    <div class="layui-col-md6">
        <div class="layui-card">
            <div class="layui-card-header">个人资料</div>
            <div class="layui-card-body" style="padding: 15px;">
                <div class="layui-form" lay-filter="form">

                    <div class="layui-form-item">
                        <label class="layui-form-label">账号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="account" disabled autocomplete="off"
                                   class="layui-input layui-disabled" value="{$adminInfo.account}">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">昵称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="real_name" id="name" lay-verify="required" autocomplete="off"
                                   class="layui-input" value="{$adminInfo.real_name}">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">原密码</label>
                        <div class="layui-input-inline">
                            <input type="password" name="pwd" id="pwd" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">留空则不修改</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">新密码</label>
                        <div class="layui-input-inline">
                            <input type="password" name="new_pwd" id="new" lay-verify="pass" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">6-12个字符，且不能有空格</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">确认密码</label>
                        <div class="layui-input-inline">
                            <input type="password" name="new_pwd_ok" id="new2" lay-verify="pass" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">6-12个字符，且不能有空格</div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="*">保 存</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{/block}
{block name="script"}
<script>
    layui.use(['form', 'layer'], function () {
        var $ = layui.$, form = layui.form, layer = layui.layer;

        form.verify({
            pass: function (value) {
                if (value.length) {
                    if (!/^[\S]{6,12}$/.test(value)) {
                        return '密码必须6-12个字符，且不能有空格';
                    }
                }
            },
            //pass: [/^[\S]{6,12}$/, '密码必须6-12个字符，且不能有空格']
        });

        form.on('submit(*)', function (form) {
            const data = form.field;


            if (data.pwd) {
                if (!data.new_pwd) {
                    return layer.tips('请输入新密码', '#new');
                } else if (!data.new_pwd_ok) {
                    return layer.tips('请输入确认密码', '#new2');
                }

                if (data.pwd == data.new_pwd) {
                    return layer.msg('新密码与原密码输入一致', {icon: 5});
                } else if (data.new_pwd_ok != data.new_pwd) {
                    return layer.msg('两次密码输入不一致', {icon: 5});
                }
            }
            if (data.new_pwd) {
                if (!data.pwd) {
                    return layer.tips('请输入原密码', '#pwd');
                } else if (!data.new_pwd_ok) {
                    return layer.tips('请输入确认密码', '#new2');
                }
            } else {
                if (data.real_name == '{$adminInfo.real_name}') {
                    return layer.tips('改个昵称在保存吧', '#name');
                }
            }

            $.post("{:url('setAdminInfo')}", data, function (ret) {
                ret = JSON.parse(ret);

                if (ret.code === 200) {
                    return layer.alert(ret.msg, function () {
                        parent.location.reload();
                    })
                }

                return layer.alert(ret.msg, {icon: 5})
            });

        });
    });
</script>
{/block}