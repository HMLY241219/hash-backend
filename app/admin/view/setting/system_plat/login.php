<!DOCTYPE html>
<html lang="zh-CN">
<head>
    {include file="public/head"}

    <link href="/system/frame/css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="/system/frame/css/style.min.css?v=3.0.0" rel="stylesheet">
    <title>{$title|default=''}</title>
    <style>
        .check {
            color: #ff0000
        }

        .demo-upload {
            display: block;
            height: 33px;
            text-align: center;
            border: 1px solid transparent;
            border-radius: 4px;
            overflow: hidden;
            background: #fff;
            position: relative;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .2);
            margin-right: 4px;
        }

        .demo-upload img {
            width: 100%;
            height: 100%;
            display: block;
        }

        .demo-upload-cover {
            display: none;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, .6);
        }

        .demo-upload:hover .demo-upload-cover {
            display: block;
        }

        .demo-upload-cover i {
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            margin: 0 2px;
        }

        .code-send {
            cursor: pointer;
        }
    </style>
    <script>
        window.test = 1;
    </script>
</head>
<body>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>账户登录</h5>
                </div>
                <div id="store-attr" class="mp-form" v-cloak="">
                    <div class="ibox-content">
                        <div id="app">
                                <Alert type="success">如果忘记密码，可以点击<a href="{:Url('setting.systemPlat/modify')}" style="color: #0000ff">忘记密码</a>

                                ；如果还没有开通一号通账号,可以立即<a href="{:Url('setting.systemPlat/register')}" style="color: #0000ff">注册账户</a>
                                </Alert>
                        </div>
                    </div>
                    <div class="p-m m-t-sm">
                        <i-Form :label-width="80" style="width: 100%">
                            <template>
                                <template>
                                    <Form-Item>
                                        <Row>
                                            <i-Col span="13">
                                                <i-Input placeholder="手机号或账号" v-model="form.account" style="width: 80%"
                                                         type="text" value="{{ account }}"></i-Input>
                                            </i-Col>
                                        </Row>
                                    </Form-Item>
                                    <Form-Item>
                                        <Row>
                                            <i-Col span="13">
                                                <i-Input placeholder="密码/token" v-model="form.password"
                                                         style="width: 80%" type="password" value="{{ password }}"></i-Input>
                                            </i-Col>
                                        </Row>
                                    </Form-Item>
                                </template>
                                <Form-Item>
                                    <Row>
                                        <i-Col span="13" offset="6">
                                            <i-Button type="primary" @click="submit">提交</i-Button>
                                        </i-Col>
                                    </Row>
                                </Form-Item>

                            </template>
                        </i-Form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var _vm;
    var account = "<?php echo $account;?>";
    var password = "<?php echo $password;?>";
    mpFrame.start(function (Vue) {
        new Vue({
            data() {
                return {
                    form: {
                        account: account,
                        password: password
                    },
                    isSend: true,
                }
            },
            methods: {
                submit() {
                    let url = window.location.href;
                    let str = url.slice(url.indexOf('=')+1);
                    if(str == 1){
                        str = 'index';
                    }
                    var that = this;
                    $eb.axios.post("{:Url('go_login')}", that.form).then(function (res) {
                        if (res.status == 200 && res.data.code == 200) {
                            $eb.message('success', res.data.msg || '提交成功!');
                            $eb.closeModalFrame(window.name);
                            location.href = "{:url('setting.systemPlat/"+str+"')}";
                        } else {
                            $eb.message('error', res.data.msg || '请求失败!');
                        }
                    }).catch(function (err) {
                        $eb.message('error', err);
                    })
                },
            },
            mounted() {

            }
        }).$mount(document.getElementById('store-attr'));
    });
</script>
</body>