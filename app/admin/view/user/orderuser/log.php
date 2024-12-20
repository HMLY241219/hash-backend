{extend name="public:layui" /}

{block name="title"}用户列表{/block}
{block name="content"}
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">

            <div class="layui-form" lay-filter="form">
                <div class="layui-card">
                    <div class="layui-card-body layui-row layui-col-space10">


                        <div class="layui-inline">
                            <input type="text" name="datetable" id="date" value="{:date('Y-m-d') .' - '. date('Y-m-d')}" placeholder="查询时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <input class="layui-input" name="game/id" id="game_id" autocomplete="off" placeholder="局数编号">
                        </div>

                        <div class="layui-inline">
                            <select name="game/type">
                                <option value="">游戏类型</option>
                                {volist name="game_name_type" id="vo"}
                                <option value="{$key}" >{$vo}</option>
                                {/volist}
                            </select>
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
    <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="detail">牌局详情</a>
    <a class="layui-btn layui-btn-xs layui-btn-green" lay-event="view">进程详情</a>
</script>

<script>

    layui.use(['table', 'form', 'layer'], function () {
        var table = layui.table, form = layui.form, $ = layui.$, laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });
        form.render(null, 'form');

        table.render({
            elem: "#logs_list",
            url: "{:url('log_list')}?uid={$uid}",
            cols: [[
                {
                    field: 'game_type', title: '房间名称', minWidth: 120, sort: true,
                    templet: function (d) {return getGameType(d.game_type, d.table_level)}
                },
                {field: 'game_id', title: '牌局编号', minWidth: 165, sort: true},
                {
                    field: 'bet_score', title: '投注金额', minWidth: 86,
                    templet: function (d) {
                        return getRedNumber(d.bet_score, true);
                    }
                },
                {
                    field: 'final_score', title: '玩家SY金额', minWidth: 130,
                    templet: function (d) {
                        return getRedNumber(d.final_score, true);
                    }
                },
                // {
                //     field: 'before_score', title: '当局开始前余额', minWidth: 128,
                //     templet: function (d) {
                //         if (d.game_type == 1034) {
                //             return getRedNumber(d.total_score - d.final_score, true);
                //         }
                //         return getRedNumber(d.total_score + d.service_score - d.final_score, true);
                //     }
                // },
                {
                    field: 'total_score', title: '当局结束后余额', minWidth: 128,
                    templet: function (d) {
                        if (d.game_type == 1034) {
                            return getRedNumber(d.total_score - d.service_score, true);
                        }
                        return getRedNumber(d.total_score, true);
                    }
                },
                {
                    field: 'service_score', title: '当局税收', minWidth: 86,
                    templet: function (d) {
                        return getRedNumber(d.service_score, true);
                    }
                },
                {field: 'time_stamp', title: '当局开始时间', minWidth: 160, sort: true, templet: function (d) {return getDateString(d.time_stamp);}},
                {fixed: 'right', title: '操作', minWidth: 180, toolbar: '#action_bar'}
            ]],
            title: `用户ID [{$uid}] 牌局日志`,
            toolbar: '#tip',
            height: 'full-130',
            page: true,
            limit: 30,
            limits: [30, 50, 100, 200]
        });

        //单元格工具事件
        table.on("tool(logs_list)", function (obj) {
            const data = obj.data, event = obj.event;

            if (event === "detail") {
                const detail = layer.open({
                    type: 2,
                    area: ['1100px', '600px'],
                    title: `牌局编号 ${data.game_id} ${getGameType(data.game_type, data.table_level)} 详情如下`,
                    fixed: false,
                    maxmin: true,
                    content: `{:url('game.log/details')}?id=${data.game_id}&date=${data.time_stamp}`
                });

                if (data.game_type == 1027) {
                    layer.full(detail);
                }
            }else if(event === "view"){
                let detail1 = layer.open({
                    type: 2,
                    area: ['1100px', '600px'],
                    title: `牌局编号 ${data.game_id} ${getGameType(data.game_type, data.table_level)} 进程如下`,
                    fixed: false,
                    maxmin: true,
                    content: `{:url('game.log/view')}?id=${data.game_id}&date=${data.time_stamp}`
                });
            }
        });

        active = {
            reload: function () {

                table.reload('logs_list', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    },
                    where: form.val('form'),
                    scrollPos: 'fixed',
                });
            }
        };

        $(".layui-form .layui-btn").on('click', function () {
            const type = $(this).data('type');
            active[type] && active[type]();
        });

    });
</script>
{/block}