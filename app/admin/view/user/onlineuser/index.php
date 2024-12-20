{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="a_uid@like"  autocomplete="off" placeholder="用户ID">
                        </div>

                        <!--<div class="layui-inline">
                            <input class="layui-input" name="a_vip"  autocomplete="off" placeholder="VIP等级">
                        </div>


                        <div class="layui-inline">
                            <select name="a_status" id="">
                                <option value="">请选择状态</option>
                                <option value="0">正常</option>
                                <option value="1">拉黑</option>

                            </select>
                        </div>-->

                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="" placeholder="注册时间" autocomplete="off" class="layui-input">
                        </div>

                        <!--<div class="layui-inline">
                            <select name="game/type" lay-filter="game_type">
                                <option value="">游戏名称</option>
                                {volist name="game_name_type" id="vo"}
                                <option value="{$key}">{$vo}</option>
                                {/volist}
                            </select>
                        </div>
                        <div class="layui-inline">
                            <select name="table/level" lay-filter="table_level" id="table_level">
                            </select>
                        </div>-->

                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" data-type="reload">搜索</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="layui-card-body">
                <table class="layui-hide" id="table" lay-filter="table"></table>
            </div>

        </div>
    </div>
</div>
{/block}
{block name="script"}
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="view">用户详情</span>
    <!--<span class="layui-btn layui-btn-xs layui-btn-warm"  lay-event="record">游戏记录</span>-->
    <span class="layui-btn layui-btn-xs layui-btn-green"  lay-event="log">牌局日志</span>
    <!--<span class="layui-btn layui-btn-xs layui-btn-normal"  lay-event="water">打码量记录</span>
    <span class="layui-btn layui-btn-xs layui-btn-primary"  lay-event="waterlog">打码量调整</span>-->
</script>
<script type="text/html" id="status">
    {{# if(d.status == 0){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">正常</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">封号</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        var limit = 200;
        laydate.render({
            elem: '#date',
            range : true
        });
        table.render({
            elem: '#table'
            ,defaultToolbar: []
            ,url: "{:url('getlist')}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbarDemo'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'uid', title: '用户ID', minWidth: 88,fixed: 'left'},
                //{field: 'vip', title: 'VIP等级', minWidth: 100, fixed: 'left',sort:true},
                //{field: 'nick_name', title: '用户昵称', minWidth: 100,fixed: 'left'},
                //{field: 'status', title: '状态', minWidth: 88, templet:'#status'},
                //{field: 'game_name_info', title: '所在游戏', minWidth: 130},
                {field: 'regist_time', title: '注册时间', minWidth: 190},
                {field: 'coin', title: '余额', minWidth: 88 ,sort:true,templet: function (d){
                        return d.coin/100
                    }},
                {field: 'total_pay_score', title: '总充值金额',sort:true, minWidth: 150,templet(d){
                        return d.total_pay_score/100
                    }},
                {field: 'total_exchange', title: '总退款金额',sort:true, minWidth: 150,templet(d){
                        return d.total_exchange/100
                    }},
                {field: 'total_bili', title: '退款率(%)',sort:true, minWidth: 150,templet(d){
                        return (d.total_bili*100).toFixed(2) + '%'
                    }},
                /*{field: 'daytotal_pay_score', title: '当日总充值金额',sort:true, minWidth: 150,templet(d){
                        return d.daytotal_pay_score/100
                    }},
                {field: 'daytotal_give_score', title: '当日赠送金额',sort:true, minWidth: 150,templet(d){
                        return d.daytotal_give_score/100
                    }},
                {field: 'daytotal_exchange', title: '当日退款金额',sort:true, minWidth: 150,templet(d){
                        return d.daytotal_exchange/100
                    }},
                {field: 'daytotal_exchange_num', title: '当日退款次数',sort:true, minWidth: 100},
                {field: 'daytotal_score', title: '当日玩家SY',sort:true, minWidth: 150,templet(d){
                        return d.daytotal_score/100
                    }},
                {field: 'first_pay_score', title: '首充金额',sort:true, minWidth: 150,templet(d){
                        return d.first_pay_score/100
                    }},
                {field: 'now_score_water', title: '当前有效游戏流水',sort:true, minWidth: 150,templet(d){
                        return d.now_score_water/100
                    }},
                {field: 'need_score_water', title: '当前要求游戏流水',sort:true, minWidth: 150,templet(d){
                        return d.need_score_water/100
                    }},
                {field: 'day_total_bili', title: '当日退款率', minWidth: 150,templet(d){
                        return (d.day_total_bili*100).toFixed(2) + '%'
                    }},*/
                {field: 'total_score', title: '玩家总SY(不含服务费)',sort:true, minWidth: 230,templet(d){
                        return (d.cash_total_score + d.bonus_total_score)/100
                    }},
                {field: 'total_give_score', title: '总赠送金额',sort:true, minWidth: 150,templet(d){
                        return d.total_give_score/100
                    }},
                /*{field: 'pttotal_score', title: '平台总SY金额(不含服务费)',sort:true, minWidth: 250,templet(d){
                        return d.pttotal_score/100
                    }},
                {field: 'sftotal_outside_score', title: '三方总SY金额',sort:true, minWidth: 180,templet(d){
                        return d.sftotal_outside_score/100
                    }},
                {field: 'total_exchange_num', title: '总退款次数',sort:true, minWidth: 100},*/
                {field: 'alltotal_water_score', title: '总有效流水',sort:true, minWidth: 150,templet(d){
                        return (d.now_cash_score_water + d.now_bonus_score_water)/100
                    }},
                /*{field: 'total_water_score', title: '平台总有效流水',sort:true, minWidth: 150,templet(d){
                        return d.total_water_score/100
                    }},
                {field: 'total_outside_water_score', title: '三方总有效流水',sort:true, minWidth: 150,templet(d){
                        return d.total_outside_water_score/100
                    }},
                {field: 'tpc_unlock', title: '已解锁TPC余额',sort:true, minWidth: 150,templet(d){
                        return d.tpc_unlock/100
                    }},
                {field: 'sytpc', title: '未解锁的TCP余额',sort:true, minWidth: 150,templet(d){
                        return d.sytpc/100
                    }},
                {field: 'total_tpc_to', title: '总退款到余额的TPC数量',sort:true, minWidth: 180,templet(d){
                        return d.total_tpc_to/100
                    }},
                {field: 'daytotal_game_num', title: '当日自研游戏次数',sort:true, minWidth: 150},
                {field: 'daytotal_outside_game_num', title: '当日三方游戏次数',sort:true, minWidth: 150},
                {field: 'total_game_num', title: '总自研游戏次数',sort:true, minWidth: 150},
                {field: 'total_outside_game_num', title: '总三方游戏次数',sort:true, minWidth: 150},*/
                {field: 'total_game_day', title: '游戏天数',sort:true, minWidth: 120},
                //{field: 'not_play_game_day', title: '连续未登录游戏天数',sort:true, minWidth: 160},
                {field: 'ip', title: '注册ip地址', minWidth: 120},
                {field: 'login_time', title: '最近登录时间', minWidth: 190},
                //{fixed: 'right', title: '操作', align: 'center', minWidth: 200, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });


        //单元格工具事件
        table.on('tool(table)', function (obj) {
            let data = obj.data;

            let event = obj.event;

            if (event === 'index') {
                table.reload("table", {
                    page: {
                        curr: 1
                    },
                    where: {
                        idordersn : data.uid
                    },
                    scrollPos: 'fixed',
                });
//               table.reload("table");  //重新加载表格

            }else if(event === 'view'){

                let url = '/admin/user.user/view.html?uid='+data.uid
                console.log(url);

               layer.open({
                    type: 2,
                    title:'用户详情',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: url,//内容
                });

            }else if(event === 'log'){

                // let url = '/admin/user.user/view.html?uid='+data.uid
                // console.log(url);
                // layer.full(
                    layer.open({
                        type: 2,
                        title:'牌局日志',
                        fixed: false, //不固定
                        maxmin: true,
                        area : ['1200px','700px'],
                        anim:5,//出场动画 isOutAnim bool 关闭动画
                        resize:true,//是否允许拉伸
                        content: "{:url('user.user/log')}?uid="+data.uid,//内容
                    })
                // )


            }else if(event === 'water'){

                // let url = '/admin/user.user/view.html?uid='+data.uid
                // console.log(url);
                // layer.full(
                layer.open({
                    type: 2,
                    title:'用户ID'+data.uid+'打码量记录',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: "{:url('water')}?uid="+data.uid,//内容
                })
                // )


            }else if(event === 'waterlog'){

                layer.open({
                    type: 2,
                    title:'打码量调整',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: "{:url('user.water/index')}?uid="+data.uid,//内容
                });

            }else if(event === 'record'){
                layer.msg('暂无法用')
                return ;
                // let url = '/admin/user.user/view.html?uid='+data.uid
                // console.log(url);

                layer.open({
                    type: 2,
                    title:'牌局日志',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: "{:url('record')}?uid="+data.uid,//内容
                });

            }

        });

        active = {
            reload: function () {
                console.log( form.val('form'),111111);
                table.reload("table", {
                    page: {
                        curr: 1
                    },
                    where: form.val('form'),
                    scrollPos: 'fixed',
                });
            }
        };

        $(".table-reload .layui-btn").on("click", function () {
            const type = $(this).data("type");
            active[type] && active[type]();
        });

        form.on('select(game_type)', function(data){
            //data.value 得到被选中的值
            var url = "{:url('getLevel')}?game_type=" + data.value;
            $.get(url,function(data){
                $("#table_level").empty();
                $("#table_level").append(new Option("场次",""));
                $.each(data,function(index,item){
                    $("#table_level").append(new Option(item,index));
                    console.log(index,item);
                });
                layui.form.render("select");
            });

        });

    });


    new Vue({
        el: '#app',
        data: {
            aaa: 0,
        },
        created(){

        },
        methods: {

        },

    })
</script>
{/block}
