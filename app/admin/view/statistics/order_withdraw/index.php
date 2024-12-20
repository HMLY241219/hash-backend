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
<script type="text/html" id="new_recharge_suc_num">
    <a href=""  class="layui-table-link" target="_self">{{ d.new_recharge_suc_num }}</a>
</script>
<script type="text/html" id="ageTpl">
    <div>
        <span class="age-value">{{d.new_recharge_suc_num}}</span>
        <a class="age-link" href="javascript:void(0);">View Details</a>
    </div>
</script>
<script>

    function skip(code,type){
        var url = "{:url('user.Orderuser/index?id=')}"+code+"&type="+type;
        //console.log(code);
        //window.location.href = url;
        window.open(url);
    }

    function withdraw(status,date){
        var url = "{:url('coin.Withdrawlog/index?uid=&status=')}"+status+"&date="+date;
        window.open(url);
    }

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
            ,url: "{:url('getlist')}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'date', title: '日期', minWidth: 190,fixed: 'left'},
                //{field: 'recharge_money', title: '总充值', minWidth: 100,templet(d){ return d.recharge_money/100}},
                //{field: 'recharge_suc_num', title: '总充值人数', minWidth: 100},

                //{field: 'new_recharge_money', title: '新充值金额', minWidth: 130,templet(d){ return d.new_recharge_money/100}},
                //{field: 'old_recharge_money', title: '老充值金额', minWidth: 130,templet(d){ return d.old_recharge_money/100}},
                /*{field: 'new_recharge_suc_num', title: '新用户充值人数(点击查看用户)', minWidth: 170,templet(d) {
                        return `<a id='new_recharge_suc_num' href="{:url('user.orderuser/index')}">${d.new_recharge_suc_num}</a>`;
                    }},*/
                //{field: 'new_recharge_suc_num', title: '新充值人数', minWidth: 220, templet: '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.new_recharge_suc_users}}`,1)">{{ d.new_recharge_suc_num }}</a></div>'},

                //{field: 'new_recharge_suc_count', title: '新用户充值次数', minWidth: 130},
                //{field: 'old_recharge_num', title: '老充值人数', minWidth: 130, templet: '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.old_recharge_suc_users}}`,2)">{{ d.recharge_suc_num-d.new_recharge_suc_num }}</a></div>'},
                //{field: 'old_recharge_suc_count', title: '老用户充值次数', minWidth: 130},

                //{field: 'withdraw_money', title: '总退款金额', minWidth: 100,templet(d){ return d.withdraw_money/100}},
                //{field: 'recharge_money', title: '总退款率', minWidth: 100,templet(d){ return (d.recharge_money>0 ? ((d.withdraw_money/d.recharge_money)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'recharge_withdraw_dif', title: '充提差', minWidth: 100,templet(d){ return (d.recharge_money-d.withdraw_money)/100}},
                //{field: 'new_withdraw_money', title: '新用户退款', minWidth: 130,templet(d){ return d.new_withdraw_money/100}},
                //{field: 'new_withdraw_money', title: '老用户退款', minWidth: 130,templet(d){ return (d.withdraw_money-d.new_withdraw_money)/100}},
                //{field: 'withdraw_suc_num', title: '退款人数', minWidth: 100},
                //{field: 'new_withdraw_num', title: '新退款人数', minWidth: 130, templet: '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.new_withdraw_users}}`,3)">{{ d.new_withdraw_num }}</a></div>'},
                //{field: 'new_withdraw_num', title: '老退款人数', minWidth: 130, templet: '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.old_withdraw_users}}`,4)">{{ d.withdraw_suc_num-d.new_withdraw_num }}</a></div>'},
                //{field: 'new_withdraw_money', title: '新增退款率', minWidth: 130,templet(d){ return (d.new_recharge_money>0 ? ((d.new_withdraw_money/d.new_recharge_money)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_withdraw_money', title: '老退款率', minWidth: 130,templet(d){ return ((d.recharge_money-d.new_recharge_money)>0 ? (((d.withdraw_money-d.new_withdraw_money)/(d.recharge_money-d.new_recharge_money))*100).toFixed(2) : '0.00')+'%'}},

                {field: 'recharge_suc_count', title: '充值成功率', minWidth: 130,templet(d){ return (d.recharge_count>0 ? ((d.recharge_suc_count/d.recharge_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'new_recharge_suc_count', title: '新充值成功率', minWidth: 130,templet(d){ return (d.new_recharge_count>0 ? ((d.new_recharge_suc_count/d.new_recharge_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'old_recharge_suc_count', title: '老充值成功率', minWidth: 130,templet(d){ return (d.old_recharge_count>0 ? ((d.old_recharge_suc_count/d.old_recharge_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'withdraw_suc_count', title: '退款成功数', minWidth: 110, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="withdraw(1,`{{d.date}}`)">{{ d.withdraw_suc_count }}</a></div>'
                },
                {field: 'withdraw_fai_count', title: '退款失败数', minWidth: 110, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="withdraw(2,`{{d.date}}`)">{{ d.withdraw_fai_count }}</a></div>'
                },
                {field: 'withdraw_suc_count', title: '退款成功率', minWidth: 110,templet(d){ return ((parseFloat(d.withdraw_suc_count)+parseFloat(d.withdraw_fai_count))>0 ? ((d.withdraw_suc_count/(parseFloat(d.withdraw_suc_count)+parseFloat(d.withdraw_fai_count)))*100).toFixed(2) : '0.00')+'%'}},
                {field: 'new_withdraw_suc_count', title: '新增退款成功率', minWidth: 130,templet(d){ return ((parseFloat(d.new_withdraw_suc_count)+parseFloat(d.new_withdraw_fai_count))>0 ? ((d.new_withdraw_suc_count/(parseFloat(d.new_withdraw_suc_count)+parseFloat(d.new_withdraw_fai_count)))*100).toFixed(2) : '0.00')+'%'}},
                {field: 'new_withdraw_suc_count', title: '老用户退款成功率', minWidth: 150,templet(d){ return (((parseFloat(d.withdraw_suc_count)+parseFloat(d.withdraw_fai_count))-(parseFloat(d.new_withdraw_suc_count)+parseFloat(d.new_withdraw_fai_count)))>0 ? (((d.withdraw_suc_count-d.new_withdraw_suc_count)/((parseFloat(d.withdraw_suc_count)+parseFloat(d.withdraw_fai_count))-(parseFloat(d.new_withdraw_suc_count)+parseFloat(d.new_withdraw_fai_count))))*100).toFixed(2) : '0.00')+'%'}},
                {field: 'rr_pay_rate', title: 'rr_pay充值成功率', minWidth: 150,templet(d){ return d.rr_pay_rate+'%'}},
                {field: 'rr_pay_ratew', title: 'rr_pay提现成功率', minWidth: 150,templet(d){ return d.rr_pay_ratew+'%'}},
                {field: 'fun_pay_rate', title: 'fun_pay充值成功率', minWidth: 150,templet(d){ return d.fun_pay_rate+'%'}},
                {field: 'fun_pay_ratew', title: 'fun_pay提现成功率', minWidth: 150,templet(d){ return d.fun_pay_ratew+'%'}},
                {field: 'ser_pay_rate', title: 'ser_pay充值成功率', minWidth: 150, templet(d){ return d.ser_pay_rate+'%'}},
                {field: 'ser_pay_ratew', title: 'ser_pay提现成功率', minWidth: 150, templet(d){ return d.ser_pay_ratew+'%'}},
                {field: 'tm_pay_rate', title: 'tm_pay充值成功率', minWidth: 150, templet(d){ return d.tm_pay_rate+'%'}},
                {field: 'tm_pay_ratew', title: 'tm_pay提现成功率', minWidth: 150, templet(d){ return d.tm_pay_ratew+'%'}},
                {field: 'go_pay_rate', title: 'go_pay充值成功率', minWidth: 150, templet(d){ return d.go_pay_rate+'%'}},
                {field: 'go_pay_ratew', title: 'go_pay提现成功率', minWidth: 150, templet(d){ return d.go_pay_ratew+'%'}},
                {field: 'eanishop_pay_rate', title: 'eanishop_pay充值成功率', minWidth: 150, templet(d){ return d.eanishop_pay_rate+'%'}},
                {field: 'eanishop_pay_ratew', title: 'eanishop_pay提现成功率', minWidth: 150, templet(d){ return d.eanishop_pay_ratew+'%'}},
                {field: 'waka_pay_rate', title: 'waka_pay充值成功率', minWidth: 150, templet(d){ return d.waka_pay_rate+'%'}},
                {field: 'waka_pay_ratew', title: 'waka_pay提现成功率', minWidth: 150, templet(d){ return d.waka_pay_ratew+'%'}},

            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500], //每页默认显示的数量
            done: function (res) {
                $(".layui-table-link").each(function () {
                //$('#table').find('td[data-field="new_recharge_suc_num"]').each(function () {
                    var id = $(this).prevAll('td[data-field="new_recharge_suc_num"]').text();
                    alert(id);
                    //$(this).attr("href", "/Orderuser/index?order_data_after=" + $(this).parent().parent().siblings().attr("data-content")+ "&shopname=" + $("#ShopId").val());
                })

            }

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
