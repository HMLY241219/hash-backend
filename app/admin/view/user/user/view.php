{extend name="public:layui" /}

{block name="title"}用户信息{/block}

{block name="content"}
<style>
    .remark{
        border: none;
        text-align: center;
    }
    .order{
        cursor: pointer;

    }
    .order:hover{
        color: red;
    }
    .with{
        cursor: pointer;

    }
    .with:hover{
        color: red;
    }
    .bonus{
        cursor: pointer;

    }
    .bonus:hover{
        color: red;
    }
    .cash{
        cursor: pointer;

    }
    .cash:hover{
        color: red;
    }
    .puid{
        cursor: pointer;

    }
    .puid:hover{
        color: #a94442;
    }
    .yxxq{
        cursor: pointer;
    }
    .yxxq:hover{
        color: red;
    }
    .flow{
        cursor: pointer;
    }
    .flow:hover{
        color: red;
    }
    .cashAndWithdrw{
        cursor: pointer;
    }
    .cashAndWithdrw:hover{
        color: red;
    }
    .allcolor{
        color: red;
    }
    .gluid{
        cursor: pointer;
    }
    .gluid:hover{
        color: red;
    }
    .tgrs{
        cursor: pointer;
    }
    .tgrs:hover{
        color: red;
    }
</style>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div class="layui-inline">
                            <label class="layui-form-label">曲线图时间:</label>
                        </div>

                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{:date('Y-m-d',strtotime('00:00:00 -30day')) .' - '. date('Y-m-d')}" placeholder="注册时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" data-type="reload">搜索</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="layui-card-body" style="height: 400px;margin-top: 15px">
                <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
                <div id="niuniu" style="height: 400px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>


<table class="layui-table">
    <colgroup>
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
    </colgroup>
    <tbody>
    <tr>
        <td>用户ID</td>
        <td class="allcolor">{$userInfo.uid}</td>
        <td>用户来源</td>
        <td class="allcolor">{$userInfo.cname}</td>
        <td >注册地址</td>
        <td >{$userInfo.address}</td>
        <td >登录地址</td>
        <td>{$userInfo.loginAddress}</td>
    </tr>
    <tr>
        <td>用户状态</td>
        <td class="layui-form">
            <input  type="checkbox" value="{$userInfo.uid}"  lay-skin="switch" lay-filter="encrypt"  lay-text="正常|封禁" {$userInfo.status == 1 ?'checked':''}>
        </td>
        <td>渠道号</td>
        <td>{$userInfo.channel}</td>
        <td>包名</td>
        <td>{$userInfo.appname}</td>
        <td>上级用户</td>
        <td class="allcolor puid" data-puid="{$userInfo.puid}">{$userInfo.puid}</td>
    </tr>
    <tr>
        <td>余额(C/B)</td>
        <td class="allcolor">{$userInfo.coin/100}/{$userInfo.bonus/100}</td>
        <td class="cashAndWithdrw" data-uid="{$userInfo.uid}">总充值/总退款(可点击)</td>
        <td class="allcolor">{$userInfo.total_pay_score/100}/{$userInfo.total_exchange/100}</td>
        <td>总退款率</td>
        <td class="allcolor">{$userInfo.total_bili * 100}%</td>
        <td>总赠送(C/B)</td>
        <td class="allcolor">{$userInfo.total_give_score/100}/{$userInfo.get_bonus/100}</td>
    </tr>
    <tr>
        <td >总流水(C/B)</td>
        <td class="allcolor">{$userInfo.total_cash_water_score/100}/{$userInfo.total_bonus_water_score/100}</td>
        <td >流水倍数(包含赠送Cash)</td>
        <td class="allcolor">{$userInfo.poor_coding_volume}</td>
        <td>总SY(C/B)</td>
        <td class="allcolor">{$userInfo.cash_total_score/100}/{$userInfo.bonus_total_score/100}</td>
        <td>发起的退款金额/次数</td>
        <td>{$userInfo.fq_withdraw_money/100}/{$userInfo.fq_withdraw_num}</td>
    </tr>
    <tr>
        <td class="yxxq" data-uid="{$userInfo.uid}">牌局日志(可点击)</td>
        <td></td>
        <td class="flow" data-uid="{$userInfo.uid}">流水日志(可点击)</td>
        <td></td>
        <td>今日充值/退款</td>
        <td>{$userInfo.daytotal_pay_score/100}/{$userInfo.daytotal_exchange/100}</td>
        <td>今日退款率</td>
        <td>{$userInfo.day_total_bili * 100}%</td>
    </tr>
    <tr>
        <td >当前Cash流水</td>
        <td class="allcolor">{$userInfo.now_cash_score_water/100}</td>
        <td >当前Cash需求流水</td>
        <td class="allcolor">{$userInfo.need_cash_score_water/100}</td>
        <td>当前Bonus流水</td>
        <td class="allcolor">{$userInfo.now_bonus_score_water/100}</td>
        <td>当前Bonus需求流水</td>
        <td>{$userInfo.need_bonus_score_water/100}</td>
    </tr>
    <tr>
        <td>昵称</td>
        <td>{$userInfo.nickname}</td>
        <td>VIP等级</td>
        <td>{$userInfo.vip}</td>
        <td>今日SY(C/B)</td>
        <td>{$userInfo.day_cash_total_score/100}/{$userInfo.day_bonus_total_score/100}</td>
        <td>今日赠送(C/B)</td>
        <td>{$userInfo.daytotal_give_score/100}/{$userInfo.day_bonus/100}</td>
    </tr>
    <tr>
        <td>注册IP</td>
        <td  class="allcolor">{$userInfo.ip}</td>
        <td>登录IP</td>
        <td class="allcolor">{$userInfo.login_ip}</td>
        <td >注册时间</td>
        <td >{$userInfo.regist_time}</td>
        <td>最近登录时间</td>
        <td>{$userInfo.login_time}</td>
    </tr>
    <tr>
        <td>首充/尾充</td>
        <td  class="allcolor">{$userInfo.first_pay_score/100}/{$userInfo.last_pay_price/100}</td>
<!--        <td>可退款额度</td>-->
<!--        <td>{$userInfo.withdraw_money /100}</td>-->
        <td  class="tgrs" data-uid="{$userInfo.uid}">推广人数(可点击)</td>
        <td>{$userInfo.charcount}</td>
        <td>手机号</td>
        <td>{$userInfo.phone ?: '' }</td>
    </tr>
    <tr>
        <td>姓名</td>
        <td>{$userInfo.backname}</td>
        <td>IFSC</td>
        <td>{$userInfo.ifsccode}</td>
        <td>银行账号</td>
        <td>{$userInfo.account}</td>
    </tr>
    <tr>
        <td>退款手机号</td>
        <td>{$userInfo.withDrawPhone}</td>
        <td>退款邮箱</td>
        <td>{$userInfo.withDrawEmail}</td>
    </tr>
    <tr>
        <td>备注</td>
        <td><input class="remark" type="text" placeholder="请输入备注" value="{$userInfo.des ?: ''}"></td>
        <td class="cash" data-uid="{$userInfo.uid}">赠送Cash记录</td>
        <td></td>
        <td class="bonus" data-uid="{$userInfo.uid}">赠送Bonus记录</td>
        <td></td>
        <td class="gluid" data-uid="{$userInfo.uid}">关联用户数量(可点击)</td>
        <td>{$userInfo.glUserCount}</td>
    </tr>
    </tbody>
</table>



{/block}

{block name="script"}
<script>
    layui.config({
        base: "{__PLUG_PATH}echarts/"
    }).extend({
        echarts: "echarts"
    }).use(["layer", "form", "echarts", "table","laydate"], function () {
        var $ = layui.$, layer = layui.layer, form = layui.form, echarts = layui.echarts, table = layui.table,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });

        var myChart2 = echarts.init(document.getElementById("niuniu"));
        var option = {
            title: {
                text: '玩家进30日充值、流水、SY、退款、赠送'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['充值', '流水','SY', '退款','赠送'],
                selected: { //设置进入默认显示的数据
                    '充值': false,
                    '流水': false,
                    'SY':true,
                    '退款':false,
                    '赠送':false,
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    dataView: {show: true, readOnly: false},
                    magicType: {show: true, type: ['line', 'bar']},
                    restore: {show: false},
                    saveAsImage: {show: false}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name: '充值',
                    type: 'line',
                    stack: 'Total',
                    data: [120, 132, 101, 134, 90, 230, 210]
                },
                {
                    name: '流水',
                    type: 'line',
                    stack: 'Total',
                    data: [150, 232, 201, 154, 190, 330, 410]
                },
                {
                    name: 'SY',
                    type: 'line',
                    stack: 'Total',
                    data: [220, 182, 191, 234, 290, 330, 310]
                },
                {
                    name: '退款',
                    type: 'line',
                    stack: 'Total',
                    data: [150, 232, 201, 154, 190, 330, 410]
                },
                {
                    name: '赠送',
                    type: 'line',
                    stack: 'Total',
                    data: [150, 232, 201, 154, 190, 330, 410]
                },

            ]
        };

        $(document).on('click',".order",function(){
            var orderuid =  $('.order').attr("data-uid");

            layer.open({
                type: 2,
                title:'用户充值',
                fixed: false, //不固定
                maxmin: true,
                area : ['1000px','600px'],
                anim:5,//出场动画 isOutAnim bool 关闭动画
                resize:true,//是否允许拉伸
                content: "{:url('order.order/index')}?uid="+orderuid,//内容
            });
        });

        $(document).on('click',".cashAndWithdrw",function(){
            var cashAndWithdrwUid =  $('.cashAndWithdrw').attr("data-uid");
            let url = "{:url('orderWithdraw')}?uid="+cashAndWithdrwUid;//内容
            window.open(url);
        });
        $(document).on('click',".gluid",function(){
            var glUid =  $('.gluid').attr("data-uid");
            let url = "{:url('glUid')}?uid="+glUid;//内容
            window.open(url);
        });
        $(document).on('click',".tgrs",function(){
            var TgUid =  $('.tgrs').attr("data-uid");
            let url = "{:url('tgUid')}?uid="+TgUid;//内容
            window.open(url);
        });
        $(document).on('click',".with",function(){
            var withuid =  $('.with').attr("data-uid");

            layer.open({
                type: 2,
                title:'用户退款',
                fixed: false, //不固定
                maxmin: true,
                area : ['1000px','600px'],
                anim:5,//出场动画 isOutAnim bool 关闭动画
                resize:true,//是否允许拉伸
                content: "{:url('order.withdraw/index')}?uid="+withuid,//内容
            });
        });


        $(document).on('click',".flow",function(){
            var flowuid =  $('.flow').attr("data-uid");
            let url = "{:url('user.flowlog/index')}?uid="+flowuid+"&type=1";//内容
            window.open(url);
            // layer.open({
            //     type: 2,
            //     title:'流水日志',
            //     fixed: false, //不固定
            //     maxmin: true,
            //     area : ['1000px','600px'],
            //     anim:5,//出场动画 isOutAnim bool 关闭动画
            //     resize:true,//是否允许拉伸
            //     content: "{:url('user.flowlog/index')}?uid="+flowuid+"&type=1",//内容
            // });
        });

        $(document).on('click',".bonus",function(){
            var bonusuid =  $('.bonus').attr("data-uid");
            let url = "{:url('bonus')}?uid="+bonusuid;
            window.open(url);
            // layer.open({
            //     type: 2,
            //     title:'赠送bonus',
            //     fixed: false, //不固定
            //     maxmin: true,
            //     area : ['1000px','600px'],
            //     anim:5,//出场动画 isOutAnim bool 关闭动画
            //     resize:true,//是否允许拉伸
            //     content: "{:url('bonus')}?uid="+bonusuid,//内容
            // });
        });


        $(document).on('click',".cash",function(){
            var cashuid =  $('.cash').attr("data-uid");
            let url = "{:url('user.flowlog/index')}?uid="+cashuid+"&type=2";
            window.open(url);
            // layer.open({
            //     type: 2,
            //     title:'赠送Cash',
            //     fixed: false, //不固定
            //     maxmin: true,
            //     area : ['1000px','600px'],
            //     anim:5,//出场动画 isOutAnim bool 关闭动画
            //     resize:true,//是否允许拉伸
            //     content:"{:url('user.flowlog/index')}?uid="+cashuid+"&type=2"
            // });
        });

        $(document).on('click',".yxxq",function(){
            var yxxquid =  $('.yxxq').attr("data-uid");
            let url = "{:url('slots.Slotslog/index')}?uid="+yxxquid;//内容
            window.open(url);
            // layer.open({
            //     type: 2,
            //     title:'牌局日志',
            //     fixed: false, //不固定
            //     maxmin: true,
            //     area : ['1000px','600px'],
            //     anim:5,//出场动画 isOutAnim bool 关闭动画
            //     resize:true,//是否允许拉伸
            //     content: "{:url('log')}?uid="+yxxquid,//内容
            // });
        });


        $(document).on('click',".puid",function(){
            var puiduid =  $('.puid').attr("data-puid");
            if(puiduid <= 0){
                layer.msg('抱歉！您没有上级用户!')
                return
            }
            let url = "{:url('view')}?uid="+puiduid;//内容
            window.open(url);
        });

        $('.remark').blur(function (res) {
            setRemark($(this).val());
        })
        $('.remark').bind('keypress',function(event){
            if(event.keyCode == "13")
            {
                setRemark($(this).val());
            }
        });

        function setRemark(content) {
            $.post("{:url('setRemark')}", {
                'uid' : "{$userInfo.uid}",
                'remark' : content,
            }, function (ret) {
                layer.msg('修改成功')
            });
        }


        form.on("switch(encrypt)", function (obj) {
            let data = obj, status = 0; //表示不正常

            if(data.elem.checked){
                status =1;  //表示正常
            }
            let content = status == 0 ?  '确定封禁这个用户？' : '确定解封这个用户？';
            layer.open({
                title: '提示',
                content: content,
                btn: ['确定', '取消'],
                yes: function(index, layero){
                    // 执行确定操作
                    $.post("{:url('is_normal')}",{
                        uid:data.value,
                        status :status
                    },function (res) {
                        layer.msg('修改成功');
                    })
                    location.reload();
                    layer.close(index); // 关闭弹出层
                },
                btn2: function(index, layero){
                    // 执行取消操作
                    location.reload();
                    layer.close(index); // 关闭弹出层
                }
            });


        });


        form.on("switch(free_rotary)", function (obj) {
            let data = obj, is_free_rotary = 0;

            if(data.elem.checked){
                is_free_rotary = 1;  //表示正常
            }

            if(is_free_rotary == 1){
                layer.open({
                    title: '提示',
                    content: '是否关闭用户免费参加转盘?',
                    btn: ['确定', '取消'],
                    yes: function(index, layero){
                        // 执行确定操作
                        $.post("{:url('is_free_rotary')}",{
                            uid:data.value,
                            is_free_rotary :is_free_rotary
                        },function (res) {
                            layer.msg('修改成功');
                        })
                        location.reload();
                        layer.close(index); // 关闭弹出层
                    },
                    btn2: function(index, layero){
                        // 执行取消操作
                        location.reload();
                        layer.close(index); // 关闭弹出层
                    }
                });
            }

        });

        form.on("switch(markingShop)", function (obj) {
            let data = obj, shop_status = 0; type = data.elem.getAttribute('lay-data'); //6 = 破产商场 , 7 = 客损商场

            if(data.elem.checked){
                shop_status = 1;  //表示正常
            }

            if(shop_status == 1){
                layer.open({
                    title: '提示',
                    content: '是否赠送活动充值商场?',
                    btn: ['确定', '取消'],
                    yes: function(index, layero){
                        // 执行确定操作
                        $.post("{:url('markingShop')}",{
                            uid:data.value,
                            type :type
                        },function (res) {
                            layer.msg('赠送成功');
                        })
                        location.reload();
                        layer.close(index); // 关闭弹出层
                    },
                    btn2: function(index, layero){
                        // 执行取消操作
                        location.reload();
                        layer.close(index); // 关闭弹出层
                    }
                });
            }

        });

        active = {
            reload: function () {
                console.log( form.val('form'),111111);
                setEcharts(form.val('form').date)
                // return;
                // table.reload("table", {
                //     page: {
                //         curr: 1
                //     },
                //     where: form.val('form'),
                //     scrollPos: 'fixed',
                // });
            }
        };

        $(".table-reload .layui-btn").on("click", function () {
            const type = $(this).data("type");
            active[type] && active[type]();
        });


        setEcharts()

        function setEcharts(date = '') {
            $.post("{:url('echartsdata')}?uid={$userInfo.uid}&date="+date, {}, function (ret) {
                option.xAxis.data = ret.date;
                console.log(ret.total_pay_score);
                option.series[0].data = ret.total_pay_score;
                option.series[1].data = ret.total_water_score;
                option.series[2].data = ret.total_score;
                option.series[3].data = ret.total_exchange;
                option.series[4].data = ret.total_give_score;
                //option1.title.text += '（共' + ret.data[2] + '局，今日' + ret.data[3] + '局）';
                // 设置初始显示状态，只显示充值数据
                myChart2.setOption(option);
            });
        }

    });

</script>
{/block}

