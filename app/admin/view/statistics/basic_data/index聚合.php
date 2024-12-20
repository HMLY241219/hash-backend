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

                        {if condition="$adminInfo.type == 1"}
                        <div class="layui-inline">
                            <select name="channels" lay-filter="channels">
                                <option value="">下级</option>
                                {volist name="adminlevel" id="vo"}
                                <option value="{$vo.channels}">{$vo.account}--{$vo.level}级用户</option>
                                {/volist}
                            </select>
                        </div>
                        {/if}

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
        var limit = 200;
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
                //{field: 'true_regist_num', title: '新增账号', minWidth: 120,sort: true},
                {field: 'device_num', title: '新增设备/游戏/游戏率', minWidth: 200,templet(d) {
                        return d.device_num + ' / ' + d.new_login_game_count + ' / ' + ((d.new_login_game_count>0 && d.true_regist_num>0) ? ((d.new_login_game_count/d.true_regist_num)*100).toFixed(2) : '0.00')+'%';
                    }},
                {field: 'login_count', title: '老账号/游戏/游戏率', minWidth: 200,templet(d) {
                        return (d.login_count-d.true_regist_num) + ' / ' + (d.login_game_count-d.new_login_game_count) + ' / ' + ((d.login_count-d.true_regist_num)>0 ? (((d.login_game_count-d.new_login_game_count)/(d.login_count-d.true_regist_num))*100).toFixed(2) : '0.00')+'%';
                    }},
                {field: 'login_count', title: '日活/日活游戏/游戏率', minWidth: 200,templet(d) {
                        return d.login_count + ' / ' + d.login_game_count + ' / ' + ((d.login_count>0 && d.login_game_count>0) ? ((d.login_game_count/d.login_count)*100).toFixed(2) : '0.00')+'%';
                    }},
                {field: 'recharge_suc_num', title: '付费率总/新/老', minWidth: 200,templet(d) {
                        return (d.login_count>0 ? ((d.recharge_suc_num/d.login_count)*100).toFixed(2) : '0.00')+'%' + ' / ' + (d.true_regist_num>0 ? ((d.new_recharge_suc_num/d.true_regist_num)*100).toFixed(2) : '0.00')+'%' + ' / ' + ((d.login_count-d.true_regist_num)>0 ? (((d.recharge_suc_num-d.new_recharge_suc_num)/(d.login_count-d.true_regist_num))*100).toFixed(2) : '0.00')+'%';
                    }},
                {field: 'recharge_money', title: '充值总/新/老', minWidth: 200,templet(d) {
                        return d.recharge_money/100 + ' / ' + d.new_recharge_money/100 + ' / ' + d.old_recharge_money/100;
                    }},
                {field: 'recharge_suc_num', title: '充值人数总/新/老', minWidth: 180,templet:
                        '<div>{{d.recharge_suc_num}} / <a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.new_recharge_suc_users}}`,`{{d.date}}`,1)">{{ d.new_recharge_suc_num }}</a> / <a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.old_recharge_suc_users}}`,`{{d.date}}`,2)">{{ d.recharge_suc_num-d.new_recharge_suc_num }}</a></div>'},
                {field: 'recharge_suc_count', title: '充值次数总/新/老', minWidth: 200,templet(d) {
                        return d.recharge_suc_count + ' / ' + d.new_recharge_suc_count + ' / ' + d.old_recharge_suc_count;
                    }},
                {field: 'recharge_money', title: 'ARPU总/新/老', minWidth: 180,templet(d) {
                        return (d.login_count>0 ? ((d.recharge_money/100)/d.login_count).toFixed(2) : '0.00') + ' / ' + (d.new_login_count>0 ? ((d.new_recharge_money/100)/d.new_login_count).toFixed(2) : '0.00') + ' / ' + ((d.login_count-d.new_login_count) ? (((d.recharge_money-d.new_recharge_money)/100)/(d.login_count-d.new_login_count)).toFixed(2) : '0.00');
                    }},
                {field: 'recharge_suc_num', title: 'ARPPU总/新/老', minWidth: 180,templet(d) {
                        return (d.recharge_suc_num>0 ? ((d.recharge_money/100)/d.recharge_suc_num).toFixed(0) : '0.00') + ' / ' + (d.new_recharge_suc_num>0 ? ((d.new_recharge_money/100)/d.new_recharge_suc_num).toFixed(0) : '0.00') + ' / ' + ((d.recharge_suc_num-d.new_recharge_suc_num)>0 ? (((d.recharge_money-d.new_recharge_money)/100)/(d.recharge_suc_num-d.new_recharge_suc_num)).toFixed(0) : '0.00');
                    }},
                {field: 'recharge_money', title: '退款总/新/老', minWidth: 200,templet(d) {
                        return d.withdraw_money/100 + ' / ' + d.new_withdraw_money/100 + ' / ' + (d.withdraw_money-d.new_withdraw_money)/100;
                    }},
                {field: 'recharge_money', title: '退款率总/新/老', minWidth: 200,templet(d) {
                        return (d.recharge_money>0 ? ((d.withdraw_money/d.recharge_money)*100).toFixed(2) : '0.00')+'%' + ' / ' + (d.new_recharge_money>0 ? ((d.new_withdraw_money/d.new_recharge_money)*100).toFixed(2) : '0.00')+'%' + ' / ' + ((d.recharge_money-d.new_recharge_money)>0 ? (((d.withdraw_money-d.new_withdraw_money)/(d.recharge_money-d.new_recharge_money))*100).toFixed(2) : '0.00')+'%';
                    }},
                {field: 'recharge_suc_num', title: '退款人数总/新/老', minWidth: 180,templet:
                        '<div>{{d.withdraw_suc_num}} / <a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.new_withdraw_users}}`,`{{d.date}}`,3)">{{ d.new_withdraw_num }}</a> / <a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.old_withdraw_users}}`,`{{d.date}}`,4)">{{ d.withdraw_suc_num-d.new_withdraw_num }}</a></div>'
                },
                {field: 'fee_money', title: '支付成本/毛利/毛利率', minWidth: 200,templet(d) {
                        return ((parseFloat(d.fee_money)+parseFloat(d.withdraw_fee_money))/100).toFixed(0) + ' / ' + (d.profit/100).toFixed(0) + ' / ' + (d.recharge_money>0 ? ((d.profit/d.recharge_money)*100).toFixed(2) : '0.00') + '%';
                    }},
                {field: 'recharge_money', title: '复购率总/新/老', minWidth: 200,templet(d) {
                        return (d.recharge_suc_num>0 ? ((d.repurchase_num/d.recharge_suc_num)*100).toFixed(2) : '0.00')+'%' + ' / ' + (d.new_recharge_suc_num>0 ? ((d.new_repurchase_num/d.new_recharge_suc_num)*100).toFixed(2) : '0.00')+'%' + ' / ' + ((d.recharge_suc_num-d.new_recharge_suc_num)>0 ? (((d.repurchase_num-d.new_repurchase_num)/(d.recharge_suc_num-d.new_recharge_suc_num))*100).toFixed(2) : '0.00')+'%';
                    }},
                //{field: 'true_regist_num', title: '真金注册用户数', minWidth: 130},
                //{field: 'new_login_game_count', title: '新游戏UV', minWidth: 110},
                //{field: 'new_login_game_count', title: '新游戏UV', minWidth: 150},
                //{field: 'true_regist_num', title: '新增游戏率', minWidth: 120,templet(d){ return ((d.new_login_game_count>0 && d.true_regist_num>0) ? ((d.new_login_game_count/d.true_regist_num)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'login_count', title: '日活', minWidth: 80},
                //{field: 'login_game_count', title: '日活游戏UV', minWidth: 110},
                //{field: 'login_game_count', title: '总游戏率', minWidth: 110,templet(d){ return ((d.login_count>0 && d.login_game_count>0) ? ((d.login_game_count/d.login_count)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_login_count', title: '老用户登录人数', minWidth: 140,templet(d){ return (d.login_count-d.true_regist_num)}},
                //{field: 'new_login_game_count', title: '老游戏人数', minWidth: 130,templet(d){ return (d.login_game_count-d.new_login_game_count)}},
                //{field: 'new_login_count', title: '老游戏率', minWidth: 110,templet(d){ return ((d.login_count-d.true_regist_num)>0 ? (((d.login_game_count-d.new_login_game_count)/(d.login_count-d.true_regist_num))*100).toFixed(2) : '0.00')+'%'}},

                //{field: 'recharge_money', title: '总充值', minWidth: 100,templet(d){ return d.recharge_money/100}},
                //{field: 'recharge_suc_num', title: '总充值人数', minWidth: 100},
                //{field: 'ARPU', title: 'ARPU', minWidth: 80,templet(d){ return (d.login_count>0 ? ((d.recharge_money/100)/d.login_count).toFixed(2) : '0.00')}},
                //{field: 'recharge_suc_num', title: '日活付费率', minWidth: 120,templet(d){ return (d.login_count>0 ? ((d.recharge_suc_num/d.login_count)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_recharge_suc_num', title: '新增付费率', minWidth: 100,templet(d){ return (d.true_regist_num>0 ? ((d.new_recharge_suc_num/d.true_regist_num)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_recharge_suc_num', title: '老付费率', minWidth: 130,templet(d){ return ((d.login_count-d.true_regist_num)>0 ? (((d.recharge_suc_num-d.new_recharge_suc_num)/(d.login_count-d.true_regist_num))*100).toFixed(2) : '0.00')+'%'}},

                //{field: 'new_recharge_money', title: '新充值金额', minWidth: 130,templet(d){ return d.new_recharge_money/100}},
                //{field: 'old_recharge_money', title: '老充值金额', minWidth: 130,templet(d){ return d.old_recharge_money/100}},
                /*{field: 'new_recharge_suc_num', title: '新用户充值人数(点击查看用户)', minWidth: 170,templet(d) {
                        return `<a id='new_recharge_suc_num' href="{:url('user.orderuser/index')}">${d.new_recharge_suc_num}</a>`;
                    }},*/
                //{field: 'new_recharge_suc_num', title: '新充值人数', minWidth: 130, templet: '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.new_recharge_suc_users}}`,`{{d.date}}`,1)">{{ d.new_recharge_suc_num }}</a></div>'},

                //{field: 'new_recharge_suc_count', title: '新充值次数', minWidth: 130},
                //{field: 'old_recharge_num', title: '老充值人数', minWidth: 130, templet: '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.old_recharge_suc_users}}`,`{{d.date}}`,2)">{{ d.recharge_suc_num-d.new_recharge_suc_num }}</a></div>'},
                //{field: 'old_recharge_suc_count', title: '老充值次数', minWidth: 130},
                
                //{field: 'new_recharge_num', title: '新ARPU', minWidth: 120,templet(d){ return (d.new_login_count>0 ? ((d.new_recharge_money/100)/d.new_login_count).toFixed(2) : '0.00')}},
                //{field: 'old_recharge_num', title: '老ARPU', minWidth: 120,templet(d){ return ((d.login_count-d.new_login_count) ? (((d.recharge_money-d.new_recharge_money)/100)/(d.login_count-d.new_login_count)).toFixed(2) : '0.00')}},
                //{field: 'withdraw_money', title: '总退款金额', minWidth: 100,templet(d){ return d.withdraw_money/100}},
                //{field: 'recharge_money', title: '总退款率', minWidth: 100,templet(d){ return (d.recharge_money>0 ? ((d.withdraw_money/d.recharge_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'recharge_withdraw_dif', title: '充提差', minWidth: 100,templet(d){ return (d.recharge_money-d.withdraw_money)/100}},
                //{field: 'new_withdraw_money', title: '新用户退款', minWidth: 130,templet(d){ return d.new_withdraw_money/100}},
                //{field: 'new_withdraw_money', title: '老用户退款', minWidth: 130,templet(d){ return (d.withdraw_money-d.new_withdraw_money)/100}},
                //{field: 'withdraw_suc_num', title: '退款人数', minWidth: 100},
                //{field: 'new_withdraw_num', title: '新退款人数', minWidth: 130, templet: '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.new_withdraw_users}}`,`{{d.date}}`,3)">{{ d.new_withdraw_num }}</a></div>'},
                //{field: 'new_withdraw_num', title: '老退款人数', minWidth: 130, templet: '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.old_withdraw_users}}`,`{{d.date}}`,4)">{{ d.withdraw_suc_num-d.new_withdraw_num }}</a></div>'},
                //{field: 'new_withdraw_money', title: '新增退款率', minWidth: 130,templet(d){ return (d.new_recharge_money>0 ? ((d.new_withdraw_money/d.new_recharge_money)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_withdraw_money', title: '老退款率', minWidth: 130,templet(d){ return ((d.recharge_money-d.new_recharge_money)>0 ? (((d.withdraw_money-d.new_withdraw_money)/(d.recharge_money-d.new_recharge_money))*100).toFixed(2) : '0.00')+'%'}},

                //{field: 'recharge_money', title: 'ARPPU', minWidth: 100,templet(d){ return (d.recharge_suc_num>0 ? ((d.recharge_money/100)/d.recharge_suc_num).toFixed(2) : '0.00')}},
                //{field: 'new_recharge_money', title: '新用户ARPPU', minWidth: 130,templet(d){ return (d.new_recharge_suc_num>0 ? ((d.new_recharge_money/100)/d.new_recharge_suc_num).toFixed(2) : '0.00')}},
                //{field: 'new_recharge_money', title: '老用户ARPPU', minWidth: 130,templet(d){ return ((d.recharge_suc_num-d.new_recharge_suc_num)>0 ? (((d.recharge_money-d.new_recharge_money)/100)/(d.recharge_suc_num-d.new_recharge_suc_num)).toFixed(2) : '0.00')}},
                //{field: 'repurchase_num', title: '当日复购率', minWidth: 130,templet(d){ return (d.recharge_suc_num>0 ? ((d.repurchase_num/d.recharge_suc_num)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_repurchase_num', title: '新用户复购率', minWidth: 130,templet(d){ return (d.new_recharge_suc_num>0 ? ((d.new_repurchase_num/d.new_recharge_suc_num)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_repurchase_num', title: '老用户复购率', minWidth: 130,templet(d){ return ((d.recharge_suc_num-d.new_recharge_suc_num)>0 ? (((d.repurchase_num-d.new_repurchase_num)/(d.recharge_suc_num-d.new_recharge_suc_num))*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'recharge_suc_count', title: '充值成功率', minWidth: 130,templet(d){ return (d.recharge_count>0 ? ((d.recharge_suc_count/d.recharge_count)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_recharge_suc_count', title: '新充值成功率', minWidth: 130,templet(d){ return (d.new_recharge_count>0 ? ((d.new_recharge_suc_count/d.new_recharge_count)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'old_recharge_suc_count', title: '老充值成功率', minWidth: 130,templet(d){ return (d.old_recharge_count>0 ? ((d.old_recharge_suc_count/d.old_recharge_count)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'withdraw_suc_count', title: '退款成功率', minWidth: 130,templet(d){ return ((parseFloat(d.withdraw_suc_count)+parseFloat(d.withdraw_fai_count))>0 ? ((d.withdraw_suc_count/(parseFloat(d.withdraw_suc_count)+parseFloat(d.withdraw_fai_count)))*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_withdraw_suc_count', title: '新增退款成功率', minWidth: 130,templet(d){ return ((parseFloat(d.new_withdraw_suc_count)+parseFloat(d.new_withdraw_fai_count))>0 ? ((d.new_withdraw_suc_count/(parseFloat(d.new_withdraw_suc_count)+parseFloat(d.new_withdraw_fai_count)))*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_withdraw_suc_count', title: '老用户退款成功率', minWidth: 130,templet(d){ return (((parseFloat(d.withdraw_suc_count)+parseFloat(d.withdraw_fai_count))-(parseFloat(d.new_withdraw_suc_count)+parseFloat(d.new_withdraw_fai_count)))>0 ? (((d.withdraw_suc_count-d.new_withdraw_suc_count)/((parseFloat(d.withdraw_suc_count)+parseFloat(d.withdraw_fai_count))-(parseFloat(d.new_withdraw_suc_count)+parseFloat(d.new_withdraw_fai_count))))*100).toFixed(2) : '0.00')+'%'}},

                //{field: 'self_game_betting_money', title: '押注金额', minWidth: 120,templet(d){ return d.self_game_betting_money/100 }},
                //{field: 'self_game_award_money', title: '总FJ', minWidth: 100,templet(d){ return d.self_game_award_money/100 }},
                //{field: 'self_game_award_rate', title: 'RTP', minWidth: 100,templet(d){ return d.self_game_award_rate+'%' }},//返奖率
                //{field: 'per_count', title: '人均游戏场次', minWidth: 150},
                //{field: 'per_count_br', title: '人均百人场次', minWidth: 150},
                {field: 'total_service_score', title: '税收', minWidth: 100,templet(d){ return (d.total_service_score/100).toFixed(0)}},
                {field: 'first_order_num', title: '首充率', minWidth: 130,templet(d){ return (d.login_count>0 ? ((d.first_order_num/d.login_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'game_rate_br', title: '百人游戏率', minWidth: 110,templet(d){ return d.game_rate_br+'%' }},
                //{field: 'profit', title: '今日毛利', minWidth: 100,templet(d){ return d.profit/100}},
                //{field: 'profit_rate', title: '今日毛利率', minWidth: 100,templet(d){ return (d.recharge_money>0 ? (((d.recharge_money-d.withdraw_money)/d.recharge_money)*100).toFixed(2) : '0.00') + '%'}},
                //{field: 'fee_money', title: '支付成本', minWidth: 100,templet(d){ return (parseFloat(d.fee_money)+parseFloat(d.withdraw_fee_money))/100}},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [200,500,1000,5000], //每页默认显示的数量
            done: function (res) {
                var admin_type = {$adminInfo.type};
                if (admin_type == 0) {
                    // 显示self_game_award_rate这列
                    $('#table').next().find('th[data-field="self_game_award_rate"]').show();
                    $('#table').next().find('td[data-field="self_game_award_rate"]').show();
                    $('#table').next().find('th[data-field="per_count"]').show();
                    $('#table').next().find('td[data-field="per_count"]').show();
                    $('#table').next().find('th[data-field="per_count_br"]').show();
                    $('#table').next().find('td[data-field="per_count_br"]').show();
                    $('#table').next().find('th[data-field="game_rate_br"]').show();
                    $('#table').next().find('td[data-field="game_rate_br"]').show();
                } else {
                    // 隐藏self_game_award_rate这列
                    $('#table').next().find('th[data-field="self_game_award_rate"]').hide();
                    $('#table').next().find('td[data-field="self_game_award_rate"]').hide();
                    $('#table').next().find('th[data-field="per_count"]').hide();
                    $('#table').next().find('td[data-field="per_count"]').hide();
                    $('#table').next().find('th[data-field="per_count_br"]').hide();
                    $('#table').next().find('td[data-field="per_count_br"]').hide();
                    $('#table').next().find('th[data-field="game_rate_br"]').hide();
                    $('#table').next().find('td[data-field="game_rate_br"]').hide();
                }
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
