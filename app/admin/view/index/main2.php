{extend name="public:layout" /}

{block name="title"}控制台{/block}
{block name="style"}
<link rel="stylesheet" href="{__LAYADMIN__}/src/css/admin.css" media="all">
{/block}
{block name="content"}
<div class="layui-fluid" style="padding: 0 15px;">
    <div class="layui-row layui-col-space15">
        <div class="time_text">
            <span id="countdown"></span>
        </div>

        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    充值金额
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">{$day_data.recharge_money/100}</p>
                    <p>
                        卢比
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-dollar"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    充值人数
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">{$day_data.recharge_suc_num}</p>
                    <p>
                        人
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-user"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    支付成功订单
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">{$day_data.recharge_suc_count}</p>
                    <p>
                        笔
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-flag"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    支付成功率
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">{$day_data.recharge_count ? round(($day_data.recharge_suc_count/$day_data.recharge_count)*100, 2) : 0} %</p>
                    <p>
                        率
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-chart"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    退款金额
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">{$day_data.withdraw_money/100}</p>
                    <p>
                        卢比
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-dollar"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    退款人数
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">{$day_data.withdraw_suc_num}</p>
                    <p>
                        人
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-android"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    退款成功订单
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">{$day_data.withdraw_suc_count}</p>
                    <p>
                        人
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-android"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    退款率
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">{$day_data.recharge_money ? round(($day_data.withdraw_money/$day_data.recharge_money)*100, 2) : 0} %</p>
                    <p>
                        率
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-chart"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    新增注册
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">{$day_data.regist_num}</p>
                    <p>
                        人
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-android"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    登录人数
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">{$day_data.login_count}</p>
                    <p>
                        人
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-cellphone"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="layui-col-sm6 layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">
                    打码量
                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">暂无</p>
                    <p>
                        量
                        <span class="layuiadmin-span-color">
                            <i class="layui-inline layui-icon layui-icon-return" style="padding:0;transform:rotate(90deg);"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="layui-col-sm12">
            <div class="layui-card">
                <div class="layui-card-header">
                    访问量
                    <!--<div class="layui-btn-group layuiadmin-btn-group">
                        <a href="javascript:;" class="layui-btn layui-btn-primary layui-btn-xs">去年</a>
                        <a href="javascript:;" class="layui-btn layui-btn-primary layui-btn-xs">今年</a>
                    </div>-->
                </div>
                <div class="layui-card-body">
                    <div class="layui-row">
                        <div class="layui-col-sm8">
                            <div class="layadmin-carousel layadmin-dataview" data-anim="fade">
                                <div carousel-item id="LAY-index-1">
                                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-col-sm4">
                            <div class="layuiadmin-card-list">
                                <p class="layuiadmin-normal-font">月访问数</p>
                                <span>同上期增长</span>
                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">
                                    <div class="layui-progress-bar" lay-percent="30%"></div>
                                </div>
                            </div>
                            <div class="layuiadmin-card-list">
                                <p class="layuiadmin-normal-font">月充值数</p>
                                <span>同上期增长</span>
                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">
                                    <div class="layui-progress-bar" lay-percent="20%"></div>
                                </div>
                            </div>
                            <div class="layuiadmin-card-list">
                                <p class="layuiadmin-normal-font">月注册数</p>
                                <span>同上期增长</span>
                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">
                                    <div class="layui-progress-bar" lay-percent="25%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">数据概览</div>
                <div class="layui-card-body">

                    <div class="layadmin-carousel layadmin-dataview" data-anim="fade">
                        <div carousel-item id="LAY-index-2">
                            <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
{/block}
{block name="script"}
<script>
    var brazilOffset = -11;
    var now = new Date();
    var brazilTime = new Date(now.getTime() + brazilOffset * 60 * 60 * 1000);
    var Year = brazilTime.getFullYear();
    var Month = (brazilTime.getMonth()+1).toString().length<2 ? '0'+(brazilTime.getMonth()+1) : brazilTime.getMonth()+1;
    var day = brazilTime.getDate().toString().length<2 ? '0'+brazilTime.getDate() : brazilTime.getDate();
    var hours = brazilTime.getHours().toString().length<2 ? '0'+brazilTime.getHours() : brazilTime.getHours();
    var min = brazilTime.getMinutes().toString().length<2 ? '0'+brazilTime.getMinutes() : brazilTime.getMinutes();
    var secon = brazilTime.getSeconds().toString().length<2 ? '0'+brazilTime.getSeconds() : brazilTime.getSeconds();
    $('#countdown').html(
        '时间(Brazil)：'+ Year +'-'+ Month +'-'+ day+' '+hours + ':' +min+':' + secon
    );

    function startCountdown() {
        // 印度时区的时间偏移量为-2.5小时
        var brazilOffset = -2.5;
        // 获取当前时间
        var now = new Date();
        // 将当前时间调整为印度时区的时间
        var brazilTime = new Date(now.getTime() + brazilOffset * 60 * 60 * 1000);
        // 更新倒计时元素的内容
        var Year = brazilTime.getFullYear();
        var Month = (brazilTime.getMonth()+1).toString().length<2 ? '0'+(brazilTime.getMonth()+1) : brazilTime.getMonth()+1;
        var day = brazilTime.getDate().toString().length<2 ? '0'+brazilTime.getDate() : brazilTime.getDate();
        var hours = brazilTime.getHours().toString().length<2 ? '0'+brazilTime.getHours() : brazilTime.getHours();
        var min = brazilTime.getMinutes().toString().length<2 ? '0'+brazilTime.getMinutes() : brazilTime.getMinutes();
        var secon = brazilTime.getSeconds().toString().length<2 ? '0'+brazilTime.getSeconds() : brazilTime.getSeconds();
        $('#countdown').html(
            '时间(India)：'+ Year +'-'+ Month +'-'+ day+' '+hours + ':' +min+':' + secon
        );
    }

    layui.use('layer', function() {
        // 每秒钟执行一次倒计时函数
        setInterval(startCountdown, 1000);
    });

    layui.config({
        base: '{__LAYUI__}/mod/'
    }).extend({
        echarts: 'echarts'
    }).use(['echarts'], function () {
        const $ = layui.$, echarts = layui.echarts;

        //var myChart1 = echarts.init(document.getElementById("LAY-index-1"));
        var echartsApp = [], options = [
            {
                tooltip: {
                    trigger: 'axis'
                },
                calculable: true,
                legend: {
                    data: ['访问量', '注册量', '平均访问量']
                },
                xAxis: [
                    {
                        type: 'category',
                        data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        name: '访问量',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    },
                    {
                        type: 'value',
                        name: '注册量',
                        axisLabel: {
                            formatter: '{value}'
                        }
                    }
                ],
                series: [
                    {
                        name: '访问量',
                        type: 'line',
                        //data: [900, 850, 950, 1000, 1100, 1050, 1000, 1150, 1250, 1370, 1250, 1100]
                        data: []
                    },
                    {
                        name: '注册量',
                        type: 'line',
                        yAxisIndex: 1,
                        //data: [850, 850, 800, 950, 1000, 950, 950, 1150, 1100, 1240, 1000, 950]
                        data: []
                    },
                    {
                        name: '平均访问量',
                        type: 'line',
                        //data: [870, 850, 850, 950, 1050, 1000, 980, 1150, 1000, 1300, 1150, 1000]
                        data: []
                    }
                ]
            }
        ]
            , elemDataView = $('#LAY-index-1').children('div')
            , renderDataView = function (index) {
            echartsApp[index] = echarts.init(elemDataView[index], layui.echartsTheme);
            //echartsApp[index].setOption(options[index]);

            $.post("{:url('visitChart')}", {}, function (ret) {

                //options.xAxis.data = ret.date;
                //console.log(ret.data.visit_count);
                options[0].series[0].data = ret.data.visit_count;
                options[0].series[1].data = ret.data.regist_count;
                options[0].series[2].data = ret.data.ave_visit_count;
                echartsApp[index].setOption(options[0]);
            });
            window.onresize = echartsApp[index].resize;
        };
        renderDataView(0);

        /*$.post("{:url('visitChart')}", {}, function (ret) {

            //options.xAxis.data = ret.date;
            //console.log(ret.data.visit_count);
            options[0].series[0].data = ret.data.visit_count;
            options[0].series[1].data = ret.data.regist_count;
            options[0].series[2].data = ret.data.ave_visit_count;
            echartsApp[0].setOption(options[0]);
        });*/



        var echartsApp1 = [], options1 = [
            //今日流量趋势
            {
                title: {
                    text: '今日流量趋势',
                    x: 'center',
                    textStyle: {
                        fontSize: 14
                    }
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['', '']
                },
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: ['06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30']
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: [{
                    name: 'PV',
                    type: 'line',
                    smooth: true,
                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
                    data: [111, 222, 333, 444, 555, 666, 3333, 33333, 55555, 66666, 33333, 3333, 6666, 11888, 26666, 38888, 56666, 42222, 39999, 28888, 17777, 9666, 6555, 5555, 3333, 2222, 3111, 6999, 5888, 2777, 1666, 999, 888, 777]
                }, {
                    name: 'UV',
                    type: 'line',
                    smooth: true,
                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
                    data: [11, 22, 33, 44, 55, 66, 333, 3333, 5555, 12666, 3333, 333, 666, 1188, 2666, 3888, 6666, 4222, 3999, 2888, 1777, 966, 655, 555, 333, 222, 311, 699, 588, 277, 166, 99, 88, 77]
                }]
            }/*{
             title: {
             text: '最近一周新增的用户量',
             x: 'center',
             textStyle: {
             fontSize: 14
             }
             },
             tooltip : { //提示框
             trigger: 'axis',
             formatter: "{b}<br>新增用户：{c}"
             },
             xAxis : [{ //X轴
             type : 'category',
             data : ['11-07', '11-08', '11-09', '11-10', '11-11', '11-12', '11-13']
             }],
             yAxis : [{  //Y轴
             type : 'value'
             }],
             series : [{ //内容
             type: 'line',
             data:[200, 300, 400, 610, 150, 270, 380],
             }]
             }*/
        ]
            , elemDataView1 = $('#LAY-index-2').children('div')
            , renderDataView1 = function (index) {
            echartsApp1[index] = echarts.init(elemDataView1[index], layui.echartsTheme);
            echartsApp1[index].setOption(options1[index]);
            //window.onresize = echartsApp1[index].resize;
            admin.resize(function () {
                echartsApp1[index].resize();
            });
        };
        renderDataView1(0);

    });
</script>
<style>
    #countdown {
        font-weight: bold;
    }
    .time_text {
        text-align: right;
    }
</style>
{/block}