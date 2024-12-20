{extend name="public:layout" /}

{block name="title"}游戏记录{/block}
{block name="content"}
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">

            <div class="layui-form" lay-filter="form">
                <div class="layui-card">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="datetable" id="date" autocomplete="off" placeholder="选择日期">
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" data-type="reload">
                                <i class="layui-icon layui-icon-search"></i> 搜索
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="layui-card-body">
                <table class="layui-hide" id="logs_list" lay-filter="logs_list"></table>
            </div>

        </div>
    </div>
</div>
{/block}
{block name="script"}
<script type="text/html" id="action_bar">
    <a class="layui-btn layui-btn-primary layui-border-green layui-btn-xs" lay-event="info">用户详情</a>
    <a class="layui-btn layui-btn-primary layui-border-blue layui-btn-xs" lay-event="log">牌局日志</a>
</script>

<script>
    layui.config({
        base: '{__PUBLIC_PATH}layui/module/'
    }).extend({
        echarts: 'echarts'
    }).use(['layer', 'form', 'echarts', 'table'], function () {
        var table = layui.table, form = layui.form, $ = layui.$, echarts = layui.echarts, laydate = layui.laydate;

        laydate.render({
            elem: '#date',
            range : true
        });
        form.render(null, 'form');

        table.render({
            elem: '#logs_list',
            url: "{:url('record_list')}?uid={$uid}",
            cols: [[
                {
                    field: 'time_stamp', title: '日期', width: 101, sort: true, totalRowText: '当前合计：',
                    templet: function (d) {
                        return getDateString(d.time_stamp, true)
                    }
                },
                {
                    field: 'game_type', title: '房间名称', minWidth: 120,
                    templet: function (d) {return getGameType(d.game_type, d.table_level)}
                },
                {field: 'game_num', title: '游戏局数', totalRow: '共 {{= d.TOTAL_NUMS }} 局'},
                {field: 'win_num', title: '赢钱局数', totalRow: '共 {{= d.TOTAL_NUMS }} 局'},
                {field: 'lose_num', title: '输钱局数', totalRow: '共 {{= d.TOTAL_NUMS }} 局'},
                {
                    field: 'win_precision', title: '赢钱局数占比', minWidth: 115,
                    templet: function (d) {return getDivisor(d.win_num, d.game_num)}
                },
                {
                    field: 'lose_precision', title: '输钱局数占比', minWidth: 115,
                    templet: function (d) {return getDivisor(d.lose_num, d.game_num)}
                },
                {
                    field: 'user_score', title: '房间SY', minWidth: 113, totalRow: '{{= d.TOTAL_NUMS/100 }} 卢比',
                    templet: function (d) {return getRedNumber(d.user_score, true);}
                },
                {
                    field: 'bet_score', title: '游戏流水', minWidth: 113, totalRow: '{{= d.TOTAL_NUMS/100 }} 卢比',
                    templet: function (d) {return getRedNumber(d.bet_score, true)}
                },
                {
                    field: 'service_score', title: '游戏税收', totalRow: '{{= d.TOTAL_NUMS/100 }} 卢比',
                    templet: function (d) {return getRedNumber(d.service_score, true)}
                },
                {
                    field: 'kill_score', title: '收分金额', totalRow: '{{= d.TOTAL_NUMS/100 }} 卢比',
                    templet: function (d) {return getRedNumber(d.kill_score, true)}
                },
                {
                    field: 'give_score', title: '送分金额', totalRow: '{{= d.TOTAL_NUMS/100 }} 卢比',
                    templet: function (d) {return getRedNumber(d.give_score, true)}
                },
                {
                    field: 'return', title: 'RTP',
                    templet: function (d) {return getDivisor(d.user_score, d.bet_score, false, true)}
                },
                {title: '操作', minWidth: 165, toolbar: '#action_bar'}
            ]],
            title: '用户ID [{$uid}] 游戏记录',
            toolbar: '#tip',
            height: 'full-130',
            totalRow: true,
            page: true,
            limit: 500,
            limits: [500, 1000, 2000, 5000]
        });

        //单元格工具事件
        table.on("tool(logs_list)", function (obj) {
            const data = obj.data, event = obj.event;

            if (event === 'info') {
                layer.open({
                    type: 2,
                    area: ['1000px', '650px'],
                    title: `用户ID ${data.uid}详情如下`,
                    fixed: false,
                    maxmin: true,
                    shadeClose: true,
                    content: `{:url('member.index/userinfo')}?id=${data.uid}`
                });
            }

            if (event === 'log') {
                const full = layer.open({
                    type: 2,
                    area: ['1000px', '650px'],
                    title: `用户ID ${data.uid}、房间名称 ${getGameType(data.game_type, data.table_level)}、 游戏日期 [${getDateString(data.time_stamp, true)}]、 牌局日志如下`,
                    fixed: false,
                    maxmin: true,
                    shadeClose: true,
                    //content: `{:url('member.index/log')}?uid=${data.uid}`
                    content: `{:url('member.index/log')}?uid=${data.uid}&game_type=${data.game_type}&table_level=${data.table_level}&date=${data.time_stamp}`
                });
                layer.full(full);
                return false;
            }

        });

        active = {
            reload: function () {
                const date = $("#date").val(),
                    game_type = $("#game_type").val(),
                    table_level = $("#table_level").val();

                //执行重载
                table.reload("logs_list", {
                    page: {
                        curr: 1 //重新从第1页开始
                    },
                    where: {
                        dates: date,
                        game_type: game_type,
                        table_level: table_level
                    },
                    scrollPos: 'fixed',
                });
            },

        };

        $(".layui-form .layui-btn").on("click", function () {
            const type = $(this).data("type");
            active[type] && active[type]();
        });

    });
</script>
{/block}