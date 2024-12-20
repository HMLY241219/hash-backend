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

    function skip(code,date,type){
        var url = "{:url('user.Orderuser/index?id=')}"+code+"&type="+type+"&daydate="+date;
        //console.log(code);
        //window.location.href = url;
        window.open(url);
    }

    layui.use(['table','form','layer','laydate'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });
        var limit = 500;
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('getlist')}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'date', title: '日期', minWidth: 130,fixed: 'left'},
                {field: 'recharge_money', title: '总充值', minWidth: 100,sort: true,templet(d){ return d.recharge_money}},
                {field: 'give_bonus', title: '总赠送bonus', minWidth: 100,sort: true,templet(d){ return d.give_bonus}},
                {field: 'give_bonus_users', title: '赠送bonus人数', minWidth: 100, templet:
                    '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.give_bonus_users}}`,`{{d.date}}`,1)">{{ d.give_bonus_num }}</a></div>'
                },
                {field: 'bonus_win', title: 'bonus赢金', minWidth: 100,sort: true,templet(d){ return d.bonus_win}},
                {field: 'bonus_losing', title: 'bonus输金', minWidth: 100,sort: true,templet(d){ return d.bonus_losing}},
                {field: 'balance_bonus', title: 'bonus余额', minWidth: 100,sort: true,templet(d){ return d.balance_bonus}},
                {field: 'give_cash', title: '总赠送cash', minWidth: 100,sort: true,templet(d){ return d.give_cash}},
                {field: 'cash_water', title: 'cash流水', minWidth: 100,sort: true,templet(d){ return d.cash_water}},
                {field: 'cash_water_multiple', title: 'cash流水倍数', minWidth: 100,sort: true,templet(d){ return d.cash_water_multiple}},
                {field: 'bonus_water', title: 'bonus流水', minWidth: 100,sort: true,templet(d){ return d.bonus_water}},
                {field: 'bonus_water_multiple', title: 'bonus流水倍数', minWidth: 100,sort: true,templet(d){ return d.bonus_water_multiple}},
                {field: 'bonus_cash_transition', title: 'bonus转化cash金额', minWidth: 120,sort: true,templet(d){ return d.bonus_cash_transition}},
                {field: 'bonus_transition_users', title: 'bonus转化cash人数', minWidth: 100, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.bonus_transition_users}}`,`{{d.date}}`,1)">{{ d.bonus_transition_num }}</a></div>'
                },
                {field: 'bonus_transition_bill', title: 'bonus转化百分比（%）', minWidth: 120,sort: true,templet(d){ return d.bonus_transition_bill}},
                {field: 'bonus_pay_bill', title: '赠送cash占比（%）', minWidth: 120,sort: true,templet(d){ return d.bonus_pay_bill}},

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
