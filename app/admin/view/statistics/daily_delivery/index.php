{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="" placeholder="查询时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <select name="tj_type">
                                <option value="">统计粒度</option>
                                <option value="0">按天统计</option>
                                <option value="1">合计统计</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" id="buttom" data-type="reload">搜索</button>
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
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="list">参与列表</span>
</script>
<script type="text/html" id="status">
    {{# if(d.status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">已上线</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">已下线</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer','laydate'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });
        var limit = 500;

        var defaultToolbar = "{$defaultToolbar}"
        var decodedString = defaultToolbar.replace(/&quot;/g, '"');
        var toolbarArray = JSON.parse(decodedString);
        console.log(toolbarArray,3333);


        table.render({
            elem: '#table'
            ,defaultToolbar: toolbarArray
            ,url: "{:url('getlist')}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'date', title: '日期', minWidth: 110,fixed: 'left'},
                {field: 'true_regist_num', title: '新增账号', minWidth: 100,sort: true},
                //{field: 'new_login_game_count', title: '新游戏UV', minWidth: 90},
                {field: 'login_game_count', title: '游戏率', minWidth: 80,templet(d){ return ((d.true_regist_num>0 && d.new_login_game_count>0) ? ((d.new_login_game_count/d.true_regist_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'new_recharge_money', title: '首日充值', minWidth: 90,templet(d){ return d.new_recharge_money}},
                {field: 'new_recharge_suc_num', title: '首日充值人', minWidth: 100},
                {field: 'new_recharge_suc_num', title: '首日付费率', minWidth: 100,templet(d){ return (d.true_regist_num>0 ? ((d.new_recharge_suc_num/d.true_regist_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'all_recharge_money', title: '累计充值', minWidth: 90,templet(d){ return d.all_recharge_money}},
                {field: 'all_recharge_suc_num', title: '累充人数', minWidth: 90,templet(d){ return d.all_recharge_suc_num}},
                {field: 'all_recharge_money', title: '累付费率', minWidth: 90,templet(d){ return (d.all_true_regist_num>0 ? ((d.all_recharge_suc_num/d.all_true_regist_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'first_order_money', title: '首充当日金额', minWidth: 90,templet(d){ return d.first_order_money}},
                {field: 'first_order_num', title: '首充人数', minWidth: 120,templet(d){ return d.first_order_num}},
                {field: 'all_recharge_money', title: 'LTV', minWidth: 80,templet(d){ return (d.all_true_regist_num>0 ? ((d.all_recharge_money)/d.all_true_regist_num).toFixed(2) : '0.00')}},
                {field: 'new_withdraw_money', title: '首日退款', minWidth: 90,templet(d){ return d.new_withdraw_money}},
                {field: 'new_withdraw_num', title: '首日退款人', minWidth: 100},
                {field: 'new_withdraw_money', title: '首日退款率', minWidth: 100,templet(d){ return (d.new_recharge_money>0 ? ((d.new_withdraw_money/d.new_recharge_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'all_withdraw_money', title: '累计退款', minWidth: 90,templet(d){ return d.all_withdraw_money}},
                {field: 'all_withdraw_num', title: '累计退款人', minWidth: 100,templet(d){ return d.all_withdraw_num}},
                {field: 'new_withdraw_money', title: '累计退款率', minWidth: 100,templet(d){ return (d.all_recharge_money>0 ? ((d.all_withdraw_money/d.all_recharge_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'new_recharge_money', title: '首日毛利', minWidth: 90,templet(d){ return (d.new_recharge_money-d.new_withdraw_money).toFixed(2)}},
                {field: 'all_fee', title: '累计通道成本', minWidth: 90,templet(d){ return d.all_fee}},
                {field: 'new_recharge_money', title: '累计毛利', minWidth: 90,templet(d){ return (d.all_recharge_money-d.all_withdraw_money-d.all_fee).toFixed(2)}},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [500,1000,2000,5000] //每页默认显示的数量
        });

        active = {
            reload: function () {
                //console.log( form.val('form'),111111);
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
