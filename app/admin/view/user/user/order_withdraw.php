{extend name="public:layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div class="layui-inline">
                            <input type="text" name="datetable" id="date" value="{:date('Y-m-d',strtotime('-7 day')) .' - '. date('Y-m-d')}" placeholder="查询时间" autocomplete="off" class="layui-input">
                        </div>






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
<script type="text/html" id="type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">充值</span>
    {{# }else if(d.type == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-primary">充值赠送</span>
    {{# }else if(d.type == 3){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">Slots</span>
    {{# }else if(d.type == 4){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color:#e54d42">退款</span>
    {{# }else if(d.type == 5){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-warm">退款回退</span>
    {{# }else if(d.type == 6){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-disabled">返水奖励</span>
    {{# }else if(d.type == 8){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs tk_ht" style="color:#9c5897">钱包雨活动</span>
    {{# }else if(d.type == 9){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color:#00ced1">返佣</span>
    {{# }else if(d.type == 10){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#39b54a">Bonus转换</span>
    {{# }else if(d.type == 11){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#1cbbb4">转盘</span>
    {{# }else if(d.type == 12){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#6739b6">slotsJockPot</span>
    {{# }else if(d.type == 13){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#6739b6">slots锦标赛</span>
    {{# }else if(d.type == 14){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#9c26b0">slotsAdjust余额</span>
    {{# }else if(d.type == 15){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#008000">Vip升级奖励</span>
    {{# }else if(d.type == 16){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#26a65b">Vip周奖励</span>
    {{# }else if(d.type == 17){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#eb7347">Vip月奖励</span>
    {{# }else if(d.type == 18){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ec4758">手动加减款</span>
    {{# }else if(d.type == 19){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#A5C25C">签到</span>
    {{# }else if(d.type == 20){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#dd0000">3天卡</span>
    {{# }else if(d.type == 21){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ca94ff">月卡</span>
    {{# }else if(d.type == 22){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#A5C25C">每日奖励</span>
    {{# }else if(d.type == 23){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ad1818">破产活动</span>
    {{# }else if(d.type == 24){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#cc00ff">客损活动</span>
    {{# }else if(d.type == 25){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#1c6ca1">预流失活动</span>
    {{# }else if(d.type == 26){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#1c6ca1">破产转盘</span>
    {{# }else if(d.type == 27){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#845dc4">存钱罐</span>
    {{# }else if(d.type == 28){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ce8735">每日排行榜</span>
    {{# }else if(d.type == 29){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#087ec2">任务奖励</span>
    {{# }else if(d.type == 30){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#8a0d37">积分兑换</span>
    {{# }else if(d.type == 32){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ea394c">新日返水</span>
    {{# }else if(d.type == 33){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#c8a732">新周返水</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#d3869b"></span>
    {{# }; }}
</script>
<script type="text/html" id="active_type">
    {{# if(d.name == 100){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">普通退款</span>
    {{# }else if(d.name == 101){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ca4440">活动赠送</span>
    {{# }else if(d.name){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#1c6ca1">{{d.name}}</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color:#e54d42">普通充值</span>
    {{# }; }}
</script>
<script type="text/html" id="wake_status">
    {{# if(d.wake_status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">唤醒</span>
    {{# }else if(d.wake_status == 0){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#1c6ca1">原生</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });
        var limit = 200;
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('orderWithdrawIndex',['uid' => $uid])}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbarDemo'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'money', title: '充值金额', minWidth: 120,align: 'center',templet(d){
                        return (d.money / 100).toFixed(2);
                    }},
                {field: 'zs_money', title: '赠送Cash', minWidth: 120,align: 'center',align: 'center',templet(d){
                        return  is_zs_money_bonus(d.active_id) ? (d.zs_money / 100).toFixed(2) : 0;
                    }},
                {field: 'zs_bonus', title: '赠送Bonus', minWidth: 120,align: 'center',templet(d){
                        return  is_zs_money_bonus(d.active_id) ? (d.zs_bonus / 100).toFixed(2) : 0;
                    }},

                {field: 'name', title: '充值类型', minWidth: 88,align: 'center',templet:'#active_type'},
                {field: 'type', title: '类型', minWidth: 88,align: 'center',templet:'#type'},
                {field: 'wake_status', title: '是否是唤醒', minWidth: 88,align: 'center',templet:'#wake_status'},
                {field: 'paytype', title: '支付通道', minWidth: 88,align: 'center'},
                {field: 'finishtime', title: '完成时间',align: 'center', minWidth: 190},


            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [200,500,1000,5000] //每页默认显示的数量
        });



        {include file="public:layui_edit" /}


        function is_zs_money_bonus(active_id) {
            var active_array = [1,2,3]; // 几种周卡不需要显示
            for (var i = 0; i < active_array.length; i++) {
                if (active_array[i] === active_id) {
                    return false;
                }
            }
            return true;
        }


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


