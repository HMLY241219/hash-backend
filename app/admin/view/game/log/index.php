{extend name="public:layui" /}

{block name="title"}牌局日志{/block}
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

<!--                        <div class="layui-inline">-->
<!--                            <input class="layui-input" id="uid" type="number" min="0" autocomplete="off" placeholder="用户ID">-->
<!--                        </div>-->

                        <div class="layui-inline">
                            <input class="layui-input" name="game/id"  autocomplete="off" placeholder="游戏局数编号">
                        </div>

                        <div class="layui-inline">
                            <select name="game/type" lay-filter="game_type">
                                <option value="">游戏名称</option>
                                {volist name="game_name_type" id="vo"}
                                <option value="{$key}">{$vo}</option>
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
    <!--<a class="layui-btn layui-btn-xs layui-btn-green" lay-event="view">进程详情</a>-->
</script>


<script>
    layui.use(['table', 'form', 'layer'], function () {
        var table = layui.table, form = layui.form, $ = layui.$, elem = layui.element, laydate = layui.laydate;


        laydate.render({
            elem: '#date',
            range : true
        });

        form.render(null, 'form');

        const allcols = [[
            {field: 'game_type', title: '房间名称', minWidth: 120, sort: true, templet: function (d) {return getGameType(d.game_type, d.table_level,d.control_win_or_loser)}},
            {field: 'game_id', title: '游戏局数编号', minWidth: 140, sort: true, templet: function (d) {return d.game_id+"'"}},
            {field: 'seat_num', title: '游戏/AI/玩家人数 ', minWidth: 180, templet: function (d) {return `${d.seat_num}人 / ${d.ai_players}人 / ${d.user_num}人`}},
            {field: 'bet_all', title: '投注金额', sort: true, templet: function (d) {return getRedNumber(d.bet_all, true);}},
            {field: 'service_score', title: '税收金额', sort: true, templet: function (d) {return getRedNumber(d.service_score, true);}},
            {field: 'cards_0', title: '开奖结果', sort: true, templet: function (d) {return d.cards_0 }},
            {field: 'server_score', title: '平台SY金额', sort: true, templet: function (d) {return getRedNumber(d.server_score, true);}},
            {field: 'begin_time', title: '游戏开始时间', sort: true, templet: function (d) {return getDateString(d.begin_time);}},
            {field: 'end_time', title: '游戏结束时间', sort: true, templet: function (d) {return getDateString(d.end_time);}},
            {title: '操作', width: 120, toolbar: '#action_bar'}
        ]];
        const onecols = [[
            {field: 'game_type', title: '房间名称', minWidth: 120, sort: true, templet: function (d) {return getGameType(d.game_type, d.table_level,d.control_win_or_loser)}},
            {field: 'game_id', title: '游戏局数编号', minWidth: 167, sort: true, templet: function (d) {return d.game_id+"'"}},
            {field: 'uid', title: '用户UID', minWidth: 86},
            {field: 'bet_score', title: '投注金额', sort: true, templet: function (d) {return getRedNumber(d.bet_all, true);}},
            {field: 'service_score', title: '税收金额', sort: true, templet: function (d) {return getRedNumber(-d.service_score, true);}},
            {field: 'final_score', title: '平台SY金额', sort: true, templet: function (d) {return getRedNumber(d.server_score, true);}},
            {fixed: 'right', title: '操作', minWidth: 120, toolbar: '#action_bar'}
        ]];

        var tb = table.render({
            elem: '#logs_list',
            url: "{:url('get_list')}",
            cols: allcols,
            title: '[全局] 牌局日志',
            toolbar: '#tip',
            scrollPos: 'fixed',
            height: 'full-130',
            page: true,
            limit: 500,
            limits: [500, 1000, 2000, 5000]
        });

        //单元格工具事件
        table.on("tool(logs_list)", function (obj) {
            const data = obj.data, event = obj.event;

            let id = data.id, date = data.begin_time;
            if (data.uid > 0) {
                id = data.game_id;
                date = data.time_stamp;
            }

            if (event === 'detail') {
                const detail = layer.open({
                    type: 2,
                    area: ['1100px', '600px'],
                    title: `牌局编号 ${data.game_id} ${getGameType(data.game_type, data.table_level)} 详情如下`,
                    fixed: false,
                    maxmin: true,
                    shadeClose: true,
                    content: `{:url('details')}?id=${id}&date=${date}`
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
                    content: `{:url('view')}?id=${id}&date=${date}`
                });
            }
        });

        //选择游戏场次
        form.on("select(game_type)", function (d) {
            if (d.value === '1034')
            {
                opt = [1, 2, 3, 4, 5, 6, 7];
            }
            else if (d.value === '1033')
            {
                opt = [1, 2, 3, 4, 5, 51, 52, 53, 54, 55, 55];
            }
            else
            {
                opt = [1];
            }

            let option = '<option value="">游戏场次</option>';
            layui.each(opt, function (index, item) {
                option += `<option value="${item}">[${item}] 场次</option>`;
            })

            $("#table_level").html(option);
            form.render(null, 'form');

            return false;
        });

        active = {
            reload: function () {

                //执行重载
                if (form.val('form').uid) {
                    table.reload("logs_list", {
                        page: {
                            curr: 1
                        },
                        where:form.val('form'),
                        title: `用户ID [${uid}] 牌局日志`,
                        url: "{:url('get_records')}",
                        cols: onecols
                    });
                } else {
                    table.reload("logs_list", {
                        page: {
                            curr: 1
                        },
                        where:  form.val('form'),
                        title: '',
                        url: "{:url('get_list')}",
                        cols: allcols
                    });
                }
            },

        };

        $(".layui-form .layui-btn").on("click", function () {
            const type = $(this).data("type");
            active[type] && active[type]();
        });

    });
</script>
{/block}