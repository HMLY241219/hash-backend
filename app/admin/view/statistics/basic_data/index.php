{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{:date('Y-m-d',strtotime('00:00:00 -30day')) .' - '. date('Y-m-d')}" placeholder="查询时间" autocomplete="off" class="layui-input">
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
                {field: 'true_regist_num', title: '新增账号', minWidth: 110,sort: true},
                // {field: 'device_num', title: '新增设备', minWidth: 110,sort: true},
                //{field: 'true_regist_num', title: '真金注册用户数', minWidth: 130},
                //{field: 'new_login_game_count', title: '新游戏UV', minWidth: 95},
                //{field: 'new_login_game_count', title: '新游戏UV', minWidth: 150},
                {field: 'true_regist_num', title: '新游戏率', minWidth: 90,templet(d){ return ((d.new_login_game_count>0 && d.true_regist_num>0) ? ((d.new_login_game_count/d.true_regist_num)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'new_login_count', title: '老用户', minWidth: 80,templet(d){ return (d.login_count-d.true_regist_num)}},
                //{field: 'new_login_game_count', title: '老游戏人数', minWidth: 100,templet(d){ return (d.login_game_count-d.new_login_game_count)}},
                {field: 'new_login_count', title: '老游戏率', minWidth: 90,templet(d){ return ((d.login_count-d.true_regist_num)>0 ? (((d.login_game_count-d.new_login_game_count)/(d.login_count-d.true_regist_num))*100).toFixed(2) : '0.00')+'%'}},

                //{field: 'first_order_num', title: '首充率', minWidth: 80,templet(d){ return (d.login_count>0 ? ((d.first_order_num/d.login_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'login_count', title: 'DAU', minWidth: 110},

                {field: 'recharge_money', title: '总充值', minWidth: 110,templet(d){ return parseFloat(d.recharge_money).toFixed(2)}},
                {field: 'new_recharge_money', title: '新充值', minWidth: 110,templet(d){ return parseFloat(d.new_recharge_money).toFixed(2)}},
                {field: 'old_recharge_money', title: '老充值', minWidth: 110,templet(d){ return parseFloat(d.old_recharge_money).toFixed(2)}},

                {field: 'withdraw_money', title: '总退款', minWidth: 110,templet(d){ return parseFloat(d.withdraw_money).toFixed(2)}},
                {field: 'new_withdraw_money', title: '新退款', minWidth: 110,templet(d){ return parseFloat(d.new_withdraw_money).toFixed(2)}},
                {field: 'new_withdraw_money', title: '老退款', minWidth: 110,templet(d){ return (d.withdraw_money-d.new_withdraw_money).toFixed(2)}},
                //{field: 'recharge_suc_num', title: '付费人数(总/新/老)', minWidth: 140, templet: function (d) { return d.recharge_suc_num + '/' + d.new_recharge_suc_num +'/' + (d.recharge_suc_num-d.new_recharge_suc_num)}},
                {field: 'recharge_suc_num', title: '付费人数(总/新/老)', minWidth: 180, templet:
                        '<div>{{ d.recharge_suc_num }} / <a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.new_recharge_suc_users}}`,`{{d.date}}`,1)">{{ d.new_recharge_suc_num }}</a>({{d.new_recharge_suc_count}}) / <a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.old_recharge_suc_users}}`,`{{d.date}}`,2)">{{ d.recharge_suc_num-d.new_recharge_suc_num }}</a>({{ d.recharge_suc_count-d.new_recharge_suc_count }})</div>'
                },
                {field: 'recharge_suc_num', title: '退款人数(总/新/老)', minWidth: 180, templet:
                        '<div>{{ d.withdraw_suc_num }} / <a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.new_withdraw_users}}`,`{{d.date}}`,3)">{{ d.new_withdraw_num }}</a>({{d.new_withdraw_suc_count}}) / <a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.old_withdraw_users}}`,`{{d.date}}`,4)">{{ d.withdraw_suc_num-d.new_withdraw_num }}</a>({{ d.withdraw_suc_count-d.new_withdraw_suc_count }})</div>'
                },
                {field: 'recharge_suc_num', title: '付费率(总/新/老)', minWidth: 180, templet: function (d) {
                        return getDivNum(d.recharge_suc_num, d.login_count,false) + ' /' + getDivNum(d.new_recharge_suc_num,d.true_regist_num,false) + ' /' + getDivNum(d.recharge_suc_num-d.new_recharge_suc_num,d.login_count-d.true_regist_num)
                    }},
                {field: 'withdraw_money', title: '退款率(总/新/老)', minWidth: 180, templet: function (d) {
                        return getDivNum(d.withdraw_money, d.recharge_money,false) + ' /' + getDivNum(d.new_withdraw_money,d.new_recharge_money,false) + ' /' + getDivNum(d.withdraw_money-d.new_withdraw_money,d.recharge_money-d.new_recharge_money)
                    }},

                //{field: 'recharge_suc_num', title: '付费频率', minWidth: 90,templet(d){ return (d.recharge_suc_count>0 ? (d.recharge_suc_num/d.recharge_suc_count).toFixed(2) : '0')}},
                //{field: 'recharge_money', title: '总退款率', minWidth: 90,templet(d){ return (d.recharge_money>0 ? ((d.withdraw_money/d.recharge_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'recharge_withdraw_dif', title: '充提差', minWidth: 80,templet(d){ return (d.recharge_money-d.withdraw_money).toFixed(2)}},
                //{field: 'total_service_score', title: '税收', minWidth: 100,templet(d){ return d.total_service_score/100}},
                {field: 'fee_money', title: '支付成本', minWidth: 90,templet(d){ return (parseFloat(d.fee_money)+parseFloat(d.withdraw_fee_money)).toFixed(2)}},
                // {field: 'fee_money', title: '支付成本', minWidth: 90,templet(d){ return (parseFloat(d.fee_money))/100}},
                {field: 'profit', title: '毛利', minWidth: 80,templet(d){ return d.profit}},
                {field: 'profit_rate', title: '毛利率', minWidth: 80,templet(d){ return (d.recharge_money>0 ? ((d.profit/d.recharge_money)*100).toFixed(2) : '0.00') + '%'}},

                /*{field: 'new_recharge_suc_num', title: '新充人数(次数)', minWidth: 130, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.new_recharge_suc_users}}`,`{{d.date}}`,1)">{{ d.new_recharge_suc_num }}({{d.new_recharge_suc_count}})</a></div>'
                },
                {field: 'old_recharge_num', title: '老充人数(次数)', minWidth: 130, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.old_recharge_suc_users}}`,`{{d.date}}`,2)">{{ d.recharge_suc_num-d.new_recharge_suc_num }}({{ d.recharge_suc_count-d.new_recharge_suc_count }})</a></div>'
                },
                {field: 'recharge_suc_num', title: '总充人数(次数)', minWidth: 140,templet(d) {
                        return d.recharge_suc_num + '(' + d.recharge_suc_count + ')';
                    }},*/

                /*{field: 'new_withdraw_money', title: '新退款率', minWidth: 130,templet(d){ return (d.new_recharge_money>0 ? ((d.new_withdraw_money/d.new_recharge_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'new_withdraw_money', title: '老退款率', minWidth: 130,templet(d){ return ((d.recharge_money-d.new_recharge_money)>0 ? (((d.withdraw_money-d.new_withdraw_money)/(d.recharge_money-d.new_recharge_money))*100).toFixed(2) : '0.00')+'%'}},
*/
                {field: 'ARPU', title: 'ARPU', minWidth: 80,templet(d){ return (d.login_count>0 ? ((d.recharge_money)/d.login_count).toFixed(2) : '0.00')}},
                {field: 'new_recharge_num', title: '新ARPU', minWidth: 80,templet(d){ return (d.true_regist_num>0 ? ((d.new_recharge_money)/d.true_regist_num).toFixed(2) : '0.00')}},
                {field: 'old_recharge_num', title: '老ARPU', minWidth: 80,templet(d){ return ((d.login_count-d.true_regist_num) ? (((d.recharge_money-d.new_recharge_money))/(d.login_count-d.true_regist_num)).toFixed(2) : '0.00')}},
                {field: 'recharge_money', title: 'ARPPU', minWidth: 80,templet(d){ return (d.recharge_suc_num>0 ? ((d.recharge_money)/d.recharge_suc_num).toFixed(2) : '0.00')}},
                {field: 'new_recharge_money', title: '新ARPPU', minWidth: 90,templet(d){ return (d.new_recharge_suc_num>0 ? ((d.new_recharge_money)/d.new_recharge_suc_num).toFixed(2) : '0.00')}},
                {field: 'new_recharge_money', title: '老ARPPU', minWidth: 90,templet(d){ return ((d.recharge_suc_num-d.new_recharge_suc_num)>0 ? (((d.recharge_money-d.new_recharge_money))/(d.recharge_suc_num-d.new_recharge_suc_num)).toFixed(2) : '0.00')}},
                /*{field: 'new_withdraw_num', title: '新退人数(占比)', minWidth: 130, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.new_withdraw_users}}`,`{{d.date}}`,3)">{{ d.new_withdraw_num }}({{ getDivNum(d.new_withdraw_num,d.new_recharge_suc_num) }})</a></div>'
                },
                {field: 'new_withdraw_num', title: '老退人数(占比)', minWidth: 130, templet:
                        '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.old_withdraw_users}}`,`{{d.date}}`,4)">{{ d.withdraw_suc_num-d.new_withdraw_num }}({{ getDivNum(d.withdraw_suc_num-d.new_withdraw_num, d.recharge_suc_num-d.new_recharge_suc_num) }})</a></div>'
                },
                {field: 'withdraw_suc_num', title: '总退人数(占比)', minWidth: 130,templet(d) {
                        return d.withdraw_suc_num + '(' + getDivNum(d.withdraw_suc_num,d.recharge_suc_count) + ')';
                    }},*/


                {field: 'repurchase_num', title: '复购率', minWidth: 80,templet(d){ return (d.recharge_suc_num>0 ? ((d.repurchase_num/d.recharge_suc_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'new_repurchase_num', title: '新复购率', minWidth: 90,templet(d){ return (d.new_recharge_suc_num>0 ? ((d.new_repurchase_num/d.new_recharge_suc_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'new_repurchase_num', title: '老复购率', minWidth: 90,templet(d){ return ((d.recharge_suc_num-d.new_recharge_suc_num)>0 ? (((d.repurchase_num-d.new_repurchase_num)/(d.recharge_suc_num-d.new_recharge_suc_num))*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'login_game_count', title: '日活游戏UV', minWidth: 100},
                {field: 'login_game_count', title: '总游戏率', minWidth: 90,templet(d){ return ((d.login_count>0 && d.login_game_count>0) ? ((d.login_game_count/d.login_count)*100).toFixed(2) : '0.00')+'%'}},
                //{field: 'sms_click_num', title: '短信点击数', minWidth: 110},
                //{field: 'sms_start_num', title: '短信启动数', minWidth: 110},
                /*{field: 'new_recharge_suc_num', title: '新用户充值人数(点击查看用户)', minWidth: 170,templet(d) {
                        return `<a id='new_recharge_suc_num' href="{:url('user.orderuser/index')}">${d.new_recharge_suc_num}</a>`;
                    }},*/

                //{field: 'new_recharge_suc_count', title: '新充值次数', minWidth: 130},
                //{field: 'old_recharge_suc_count', title: '老充值次数', minWidth: 130},
                


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
                //{field: 'game_rate_br', title: '百人游戏率', minWidth: 110,templet(d){ return d.game_rate_br+'%' }},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [200,500,1000,5000], //每页默认显示的数量
            done: function (res) {
                /*var admin_type = {$adminInfo.type};
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
                } else {*/
                    // 隐藏self_game_award_rate这列
                    $('#table').next().find('th[data-field="self_game_award_rate"]').hide();
                    $('#table').next().find('td[data-field="self_game_award_rate"]').hide();
                    $('#table').next().find('th[data-field="per_count"]').hide();
                    $('#table').next().find('td[data-field="per_count"]').hide();
                    $('#table').next().find('th[data-field="per_count_br"]').hide();
                    $('#table').next().find('td[data-field="per_count_br"]').hide();
                    $('#table').next().find('th[data-field="game_rate_br"]').hide();
                    $('#table').next().find('td[data-field="game_rate_br"]').hide();
                //}
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
