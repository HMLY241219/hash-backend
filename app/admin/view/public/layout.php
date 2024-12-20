<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>{block name="title"}标题{/block}</title>
    <link rel="stylesheet" href="{__LAYUI__}/css/layui.css">
    <style>
        .layui-fluid {margin-top: 15px}
        .layui-table, .layui-table th, .layui-table td {text-align: center}
        /* tab box */
        .layui-tab-brief > .layui-tab-title .layui-this::after {display: none}
        .layui-tab-title {padding: 15px 0}
        .layui-tab-title li a {margin: initial}
    </style>
    {block name="style"}{/block}
    <script>
        $eb = parent._mpApi;
    </script>
</head>
<body>
{block name="content"}{/block}
<script type="text/javascript" src="{__FRAME_PATH}js/jquery.min.js"></script>
<script type="text/javascript" src="{__LAYUI__}/layui.js"></script>
<script>
    function getDateString(time, date = false) {
        if (!time) return time;

        time = new Date(time * 1000);

        return date === true ? time.toLocaleDateString() : time.toLocaleString();
    }

    function getDivNum(num1, num2, percent = true, div = false, precision = 100) {
        if (num1==0 || num2==0) return 0;
        if (div) return Math.floor((num1 / num2) * 100) / 100;
        return Math.floor(((num1 / num2) * 100) * precision) / precision + (percent ? '%' : '');
    }

    function getString(num = 0) {
        let list = ['include', 'exclude', 'higher', 'lower'];

        return list[num];
    }

    function getPayStatus(status = 0) {
        let list = [
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border">准备状态</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-blue">等待支付</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-green">支付成功</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-red">支付失败</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-orange">取消支付</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-black">退款中</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-btn-disabled">已退款</span>'
        ];

        return list[status];
    }

    function getWithStatus(status = 0) {
        let list = [
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border">准备状态</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-green">放款成功</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-blue">下单成功-放款中</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border">等待人工审核</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-red">下单失败</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-orange">放款失败</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-black">拒绝放款</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-btn-disabled">支付平台通知取消放款</span>'
        ];

        return list[status];
    }

    function getWithType(status = 0) {
        let list = [
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border">其他</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border">佣金</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-green">普通</span>',
        ];

        return list[status];
    }

    function getTransactionScenario(scenario_id = 0) {
        let list = [
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border">其他</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-green">活动赠送</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-blue">游戏交易</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border">充值</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-red">退款</span>',
            '<span class="layui-btn layui-btn-xs layui-btn-primary layui-border-red">手动加减余额</span>'
        ];

        return list[scenario_id];
    }

    function getGameType(num, lv) {
        let list = {
            100001: `<span style="color:#ff7500">Rummy</span>`,
            100002: `<span style="color:#9370db">TeenPatti</span>`,
            100003: `<span class="layui-font-yellow">AndarBahar</span>`,
            100004: `<span class="layui-font-green">7Up7Down</span>`,
            100005: `<span class="layui-font-cyan">Dragon&Tiger</span>`,
            100007: `<span class="layui-font-blue">3PattiBet</span>`,
            100008: `<span class="layui-font-purple">WingoLottery</span>`,
            //1025: `<span style="color: mediumpurple">Joker</span>`,
            //1024: `<span style="color: skyblue">AK47</span>`,
            100009: `<span style="color:#029402">SpeedRacing</span>`,
            100010: `<span style="color:#cd5c5c">ZooParty</span>`,
        };

        return list[num] || '<span class="layui-btn layui-btn-primary layui-btn-xs">后台功能暂未开发</span>';
    }

    const openImage = (src) => {
        let data = [];

        if ($.isArray(src)) {
            for (const val of src) {
                data.push({"src": val});
            }
        }
        else {
            data.push({"src": src})
        }

        return layer.photos({
            photos: {"data": data},
            closeBtn: true
        });
    };

    const openIframe = (title, url, width = 1000, height = 600) => {
        return layer.open({
            type: 2,
            area: [width + 'px', height + 'px'],
            title: title + '（点击空白区域快速关闭窗口）',
            fixed: false,
            maxmin: true,
            shade: 0.4,
            shadeClose: true,
            content: url,
            end: function () {
                layui.table.reloadData('list', {scrollPos: 'fixed'});
            }
        });
    };
</script>
{block name="script"}{/block}
</body>
</html>