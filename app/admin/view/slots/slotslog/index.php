{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">



                        <div class="layui-inline">
                            <input class="layui-input" name="englishname@like"  autocomplete="off" placeholder="Slots游戏名称">
                        </div>

                        {if condition="$uid <= 0"}
                        <div class="layui-inline">
                            <input class="layui-input" name="uid"  autocomplete="off" placeholder="用户ID">
                        </div>
                        {/if}

                        <div class="layui-inline">
                            <select name="terrace/name" id="">
                                <option value="">请选择游戏厂商</option>
                                {volist name="slots_terrace" id="v"}
                                <option value="{$v.type}" >{$v.name}</option>
                                {/volist}

                            </select>
                        </div>

                        <div class="layui-inline">
                            <select name="is_settlement" id="">
                                <option value="">请选择游戏状态</option>
                                <option value="0">待结算</option>
                                <option value="1">已完成</option>
                                <option value="2">已退还</option>
                                <option value="3">已结算</option>
                                <option value="4">已回滚</option>
                            </select>
                        </div>


                        <div class="layui-inline">
                            <input type="text" name="datetable" id="date" value="{:date('Y-m-d') .' - '. date('Y-m-d')}" placeholder="查询时间" autocomplete="off" class="layui-input">
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

<script type="text/html" id="is_settlement">
    {{# if(d.is_settlement == 0){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">待结算</span>
    {{# }else if(d.is_settlement == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">已完成</span>
    {{# }else if(d.is_settlement == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color: #1c6ca1">已退还</span>
    {{# }else if(d.is_settlement == 3){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color: #cc00ff">已结算</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">已回滚</span>
    {{# }; }}
</script>

<script>

    layui.use(['table','form','layer','laydate'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });

        var limit = 30;
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('getlist',['uid'=>$uid])}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                // {field: 'parentBetId', title: '三方parentBetId', minWidth: 180,fixed:'left',templet(d) {
                //         return d.parentBetId + "\t";
                //     }},
                {field: 'betId', title: '三方BetID', minWidth: 180,fixed:'left',templet(d) {
                        return d.betId + "\t";
                    }},
                {field: 'englishname', title: 'Slots游戏名称', minWidth: 180,fixed:'left'},
                {field: 'uid', title: '用户ID', minWidth: 110,fixed:'left'},
                {field: 'terrace_name', title: '游戏厂商', minWidth: 110,fixed:'left'},
                {field: 'cashBetAmount', title: 'Cash投注金额', minWidth: 150,sort:true,templet(d){
                        return (parseFloat(d.cashBetAmount) / 100).toFixed(2);
                    }},
                {field: 'bonusBetAmount', title: 'Bonus投注金额', minWidth: 150,sort:true,templet(d){
                        return (parseFloat(d.bonusBetAmount) / 100).toFixed(2);
                    }},
                {field: 'cashTransferAmount', title: 'Cash输赢金额', minWidth: 150,sort:true,templet(d){
                        return (parseFloat(d.cashTransferAmount) / 100).toFixed(2);
                    }},
                {field: 'bonusTransferAmount', title: 'Bonus输赢金额', minWidth: 150,sort:true,templet(d){
                        return (parseFloat(d.bonusTransferAmount) / 100).toFixed(2);
                    }},

                {
                    field: 'is_settlement', title: '游戏状态', minWidth: 110,templet:"#is_settlement"
                },
                {field: 'betTime', title: '参与时间', minWidth: 180},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });

        // table.exportFile(['参与时间','更新时间'], [
        //     ['betTime', 'betEndTime', new Date().getTime()]
        // ], 'csv', {
        //     dateFormat: 'yyyy-MM-dd hh:mm:ss' // 设置时间格式
        // });

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
            },

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
