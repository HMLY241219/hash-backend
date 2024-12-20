<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
    <title>{$site_name}</title>
    <link href="{__LAYUI__}/css/layui.css" rel="stylesheet">
    <link href="{__LAYADMIN__}/src/css/admin.css" rel="stylesheet">
    <link href="{__LAYADMIN__}/src/css/login.css" rel="stylesheet">
</head>
<body>
<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">
    <div class="layadmin-user-login-main">
        <div class="layadmin-user-login-box layadmin-user-login-header">
            <h2>769GAME 管理系统</h2>
        </div>
        <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
                <input type="text" name="account" id="LAY-user-login-username" lay-verify="required" value="{:cookie('act')}"
                       placeholder="请输入账号" class="layui-input" lay-verType="tips" autocomplete="off">
            </div>
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                <input type="password" name="password" id="LAY-user-login-password" lay-verify="required"
                       placeholder="请输入密码" class="layui-input" lay-verType="tips" autocomplete="off">
            </div>
            <div class="layui-form-item">
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-username"></label>
                <input type="text" name="vercode" id="LAY-user-login-username" lay-verify="required" value=""
                       placeholder="请输入谷歌验证码" class="layui-input" lay-verType="tips" autocomplete="off">
            </div>
<!--                使用验证码的时候需要打开-->
<!--            <div class="layui-row">-->
<!--            <div class="layui-col-xs7">-->
<!--                <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>-->
<!--                <input type="text" name="vercode" id="LAY-user-login-vercode" lay-verify="number" maxlength="4"-->
<!--                       placeholder="请输入图形验证码" class="layui-input" lay-verType="tips" autocomplete="off">-->
<!--            </div>-->
<!--            <div class="layui-col-xs5">-->
<!--                <div style="margin-left: 10px;">-->
<!--                    <img src="{:url('auth/captcha')}" class="layadmin-user-login-codeimg" id="LAY-user-get-vercode">-->
<!--                </div>-->
<!--            </div>-->
<!--            </div>-->
<!--            </div>-->
            <div class="layui-form-item" style="margin-bottom: 40px;">
                <input type="checkbox" name="remember" lay-skin="primary" title="记住账号" checked>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn btn-login layui-btn-fluid" lay-submit lay-filter="*">登 入 系 统</button>
            </div>
        </div>
    </div>

    <div class="layui-trans layadmin-user-login-footer">
        <p>© 2023 All Rights Reserved.</p>
    </div>
</div>
<script src="{__LAYUI__}/layui.js"></script>
<script>
    layui.use(function () {
        var $ = layui.$, form = layui.form, layer = layui.layer;

        layer.msg('欢迎进入 {$site_name} ~ ', {
            offset: '15px',
            time: 4 * 1000
        });

        //使用验证码的时候需要打开
        // const vercode = $("#LAY-user-get-vercode"), src = vercode[0].src
        // vercode.click(function () {
        //     this.src = src + '?t=' + Math.random();
        // });

        $(document).keydown(function (e) {
            if (e.keyCode === 13) {
                $("button.btn-login").trigger('click');
            }
        })

        form.on('submit(*)', function (obj) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: `{:url('auth/doLogin')}`,
                data: obj.field,
                //使用验证码的时候需要打开
                // beforeSend: function () {
                //     const vcode = $("#LAY-user-login-vercode");
                //     if (vcode.val().length !== 4) {
                //         layer.tips('验证码输入错误!', vcode, {tips: 1});
                //         return false;
                //     }
                // },
                success: function (res) {
                    if (res.code === 0) {
                        layer.msg('登入成功，正在进入系统', {offset: '15px', icon: 16, time: 2 * 1000},
                            function () {
                                window.location.href = res.data.url;
                            });
                    } else {
                        layer.msg(res.msg, {offset: '15px', icon: 2});
                        vercode.trigger('click');
                    }
                },
                error: function () {
                    layer.alert('系统内部错误', {icon: 2});
                }
            });
        });
    });
</script>
</body>
</html>