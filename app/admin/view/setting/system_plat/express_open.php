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
                    <h5>开通短信服务</h5>
                </div>
                <div id="store-attr" class="mp-form" v-cloak="">
                    <i-Form :label-width="80" style="width: 100%">
                        <template>
                            <template>
                                <Form-Item>
                                    <Row>
                                        <i-Col span="13">
                                            <i-Input placeholder="请选择快递公司" v-model="form.express" style="width: 80%"
                                                     type="text"></i-Input>
                                        </i-Col>
                                    </Row>
                                </Form-Item>
                                <Form-Item>
                                    <Row>
                                        <i-Col span="13">
                                            <i-Input placeholder="请选择电子面单模版" v-model="form.temp" style="width: 80%"
                                                     type="text"></i-Input>
                                        </i-Col>
                                    </Row>
                                </Form-Item>
                                <Form-Item>
                                    <Row>
                                        <i-Col span="13">
                                            <i-Input placeholder="请输入寄件人姓名" v-model="form.name" style="width: 80%"
                                                     type="text"></i-Input>
                                        </i-Col>
                                    </Row>
                                </Form-Item>
                                <Form-Item>
                                    <Row>
                                        <i-Col span="13">
                                            <i-Input placeholder="请输入寄件人电话" v-model="form.phone" style="width: 80%"
                                                     type="text"></i-Input>
                                        </i-Col>
                                    </Row>
                                </Form-Item>
                                <Form-Item>
                                    <Row>
                                        <i-Col span="13">
                                            <i-Input placeholder="请输入寄件人详细地址" v-model="form.address" style="width: 80%"
                                                     type="text"></i-Input>
                                        </i-Col>
                                    </Row>
                                </Form-Item>
                                <Form-Item>
                                    <Row>
                                        <i-Col span="13">
                                            <i-Input placeholder="请输入云打印机编号" v-model="form.siid" style="width: 80%"
                                                     type="text"></i-Input>
                                        </i-Col>
                                    </Row>
                                </Form-Item>
                            </template>
                            <Form-Item>
                                <Row>
                                    <i-Col span="13" offset="6">
                                        <i-Button type="primary" @click="submit">确认开通</i-Button>
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
<script>
    var _vm;
    mpFrame.start(function (Vue) {
        new Vue({
            data() {
                return {
                    form: {
                        express: '',
                        temp: '',
                        name: '',
                        phone: '',
                        address: '',
                        siid: ''
                    },
                    isSend: true,
                }
            },
            methods: {
                submit() {
                    var that = this;
                    $eb.axios.post("{:Url('go_express_open')}", that.form).then(function (res) {
                        if (res.status == 200 && res.data.code == 200) {
                            $eb.message('success', res.data.msg || '提交成功!');
                            $eb.closeModalFrame(window.name);
                            location.href = "{:url('setting.systemPlat/index')}";
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