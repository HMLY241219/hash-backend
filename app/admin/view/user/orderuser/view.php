{extend name="public:layui" /}

{block name="title"}用户信息{/block}

{block name="content"}
<style>
    .remark{
        border: none;
        text-align: center;
    }
</style>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body" style="height: 400px;margin-top: 15px">
                <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
                <div id="niuniu" style="height: 400px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
<!--                    <colgroup>-->
<!--                        <col width="200">-->
<!--                        <col width="150">-->
<!--                        <col width="200">-->
<!--                        <col width="150">-->
<!--                        <col width="200">-->
<!--                        <col width="350">-->
<!--                    </colgroup>-->
                    <tbody>
                    <tr>
                        <td>用户昵称</td>
                        <td>{$userInfo.nick_name}</td>
                        <td>当日充值金额(卢比元)</td>
                        <td>{$userInfo.daytotal_pay_score/100}</td>
                        <td>总充值金额(卢比元)</td>
                        <td>{$userInfo.total_pay_score/100}</td>
                    </tr>
                    <tr>
                        <td>用户ID</td>
                        <td>{$userInfo.uid}</td>
                        <td>当日赠送金额(卢比元)</td>
                        <td>{$userInfo.daytotal_give_score/100}</td>
                        <td>总赠送金额(卢比元)</td>
                        <td>{$userInfo.total_give_score/100}</td>
                    </tr>
                    <tr>
                        <td>用户状态</td>
                        <td class="layui-form">
                            <input  type="checkbox" value="{$userInfo.uid}"  lay-skin="switch" lay-filter="encrypt"  lay-text="正常|封禁" {$userInfo.status == 0 ?'checked':''}>
                        </td>
                        <td>今日退款金额(卢比元)</td>
                        <td>{$userInfo.daytotal_exchange/100}</td>
                        <td>总退款金额(卢比元)</td>
                        <td>{$userInfo.total_exchange/100}</td>
                    </tr>
                    <tr>
                        <td>玩家展示的VIP等级</td>
                        <td>{$userInfo.vip}</td>
                        <td>当日退款次数</td>
                        <td>{$userInfo.daytotal_exchange_num}</td>
                        <td>总退款次数</td>
                        <td>{$userInfo.total_exchange_num}</td>
                    </tr>
                    <tr>
                        <td>是否是刷子邦</td>
                        <td>{$userInfo.is_brushgang == 1 ? '是' : '否'}</td>
                        <td>当前有效游戏流水(卢比元)</td>
                        <td>{$userInfo.now_score_water/100}</td>
                        <td>总游戏流水(卢比元)</td>
                        <td>{$userInfo.alltotal_water_score/100}</td>
                    </tr>
                    <tr>
                        <td>用户包名</td>
                        <td>{$userInfo.appname}</td>
                        <td>平台总有效流水(卢比元)</td>
                        <td>{$userInfo.total_water_score/100}</td>
                        <td>三方总有效流水(卢比元)</td>
                        <td>{$userInfo.total_outside_water_score/100}</td>
                    </tr>
                    <tr>
                        <td>用户渠道号</td>
                        <td>{$userInfo.channel}</td>
                    </tr>
                    <tr>
                        <td>余额(卢比元)</td>
                        <td>{$userInfo.coin/100}</td>
                        <td>当前要求的流水(卢比元)</td>
                        <td>{$userInfo.need_score_water/100}</td>
                    </tr>
                    <tr>
                        <td>已解锁的TPC余额</td>
                        <td>{$userInfo.tpc_unlock/100}</td>
                        <td>当日退款率</td>
                        <td>{$userInfo.day_total_bili * 100}%</td>
                        <td>总退款率</td>
                        <td>{$userInfo.total_bili * 100}%</td>
                    </tr>
                    <tr>
                        <td>未解锁TPC余额</td>
                        <td>{$userInfo.sytpc/100}</td>
                        <td>当日SY金额(卢比元)</td>
                        <td>{$userInfo.daytotal_score/100}</td>
                        <td>总SY金额(卢比元不含服务费)</td>
                        <td>{$userInfo.total_score/100}</td>
                    </tr>
                    <tr>
                        <td>用户来源</td>
                        <td>{$userInfo.user_package_source}</td>
                        <td>平台总SY金额(卢比元不含服务费)</td>
                        <td>{$userInfo.pttotal_score/100}</td>
                        <td>三方总SY金额</td>
                        <td>{$userInfo.sftotal_outside_score/100}</td>
                    </tr>
                    <tr>
                        <td>总退款到余额TPC数量</td>
                        <td>{$userInfo.total_tpc_to/100}</td>
                        <td>当日自研游戏游戏次数</td>
                        <td>{$userInfo.daytotal_game_num}</td>
                        <td>总自研游戏游戏次数</td>
                        <td>{$userInfo.total_game_num}</td>
                    </tr>
                    <tr>
                        <td>首充金额(卢比元)</td>
                        <td>{$userInfo.first_pay_score/100}</td>
                        <td>当日三方游戏游戏次数</td>
                        <td>{$userInfo.daytotal_outside_game_num}</td>
                        <td>总三方游戏游戏次数</td>
                        <td>{$userInfo.total_outside_game_num}</td>
                    </tr>
                    <tr>
                        <td>返水比例</td>
                        <td>{$userInfo.chahback}%</td>
                        <td>返水总金额</td>
                        <td>{$userInfo.total_water_to_coins /100}</td>
                        <td>待领取返水金额</td>
                        <td>{$userInfo.water_to_coins /100}</td>
                    </tr>
                    <tr>
                        <td>游戏天数</td>
                        <td>{$userInfo.total_game_day}</td>
                        <td>推广码</td>
                        <td>{$userInfo.code}</td>
                    </tr>
                    <tr>
                        <td>连续未游戏天数</td>
                        <td>{$userInfo.not_play_game_day}</td>
                        <td>下家等级提升解锁的金额(卢比元)</td>
                        <td>{$userInfo.vip_back /100}</td>
                        <td>下家等级提升解锁的总金额(卢比元)</td>
                        <td>{$userInfo.total_vip_back /100}</td>
                    </tr>
                    <tr>
                        <td>注册IP地址</td>
                        <td>{$userInfo.ip}</td>
                        <td>推广赠送未解锁的金额(卢比元)</td>
                        <td>{$userInfo.sy_vip_back/100}</td>
                    </tr>
                    <tr>
                        <td>注册地址</td>
                        <td>{$userInfo.address}</td>
                        <td>今日推广人数</td>
                        <td>{$userInfo.day_charcount|raw}</td>
                        <td>总推广人数</td>
                        <td>{$userInfo.charcount}</td>
                    </tr>
                    <tr>
                        <td>注册时间</td>
                        <td>{$userInfo.regist_time}</td>
                        <td>今日返利金额(卢比元)</td>
                        <td>{$userInfo.dayreally_commission_allmoney/100}</td>
                        <td>总返利金额(卢比元)</td>
                        <td>{$userInfo.really_commission_allmoney/100}</td>
                    </tr>
                    <tr>
                        <td>最近登录时间</td>
                        <td>{$userInfo.login_time}</td>
                        <td>银行卡信息</td>
                        <td></td>
                        <td>UPI信息</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>邮箱</td>
                        <td>{$userInfo.email ?: '' }</td>
                        <td>姓名</td>
                        <td>{$userInfo.backname}</td>
                        <td>姓名</td>
                        <td>{$userInfo.upikname}</td>
                    </tr>
                    <tr>
                        <td>手机号</td>
                        <td>{$userInfo.phone ?: '' }</td>
                        <td>IFSC代码</td>
                        <td>{$userInfo.ifsccode}</td>
                        <td>UPI账号</td>
                        <td>{$userInfo.upiaccount}</td>
                    </tr>
                    <tr>
                        <td>备注</td>
                        <td><input class="remark" type="text" placeholder="请输入备注" value="{$userInfo.des ?: ''}"></td>
                        <td>银行账号</td>
                        <td>{$userInfo.bankaccount}</td>
                        <td>邮箱</td>
                        <td>{$userInfo.upiemail}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>邮箱</td>
                        <td>{$userInfo.bankemail}</td>
                        <td>手机号</td>
                        <td>{$userInfo.upiemail}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>手机号</td>
                        <td>{$userInfo.bankphone}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{/block}

{block name="script"}
<script>
    layui.config({
        base: "{__PLUG_PATH}echarts/"
    }).extend({
        echarts: "echarts"
    }).use(["layer", "form", "echarts", "table"], function () {
        var $ = layui.$, layer = layui.layer, form = layui.form, echarts = layui.echarts, table = layui.table;


        var myChart2 = echarts.init(document.getElementById("niuniu"));
        var option = {
            title: {
                text: '玩家进30日充值、SY、退款'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['充值', 'SY', '退款']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
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

            ]
        };

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
            let data = obj, status = 1; //表示不正常

            if(data.elem.checked){
                status =0;  //表示正常
            }
            let content = status == 1 ?  '确定封禁这个用户？' : '确定解封这个用户？';
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

        // myChart2.setOption(option)
        //设置折线图数据
        $.post("{:url('echartsdata',['uid'=>$userInfo.uid])}", {}, function (ret) {

            option.xAxis.data = ret.date;
            console.log(ret.total_pay_score);
            option.series[0].data = ret.total_pay_score;
            option.series[1].data = ret.total_score;
            option.series[2].data = ret.total_exchange;
            //option1.title.text += '（共' + ret.data[2] + '局，今日' + ret.data[3] + '局）';
            myChart2.setOption(option);
        });
        //myChart2.setOption(option1);
        //layer.msg('Hello World');

    });

</script>
{/block}
