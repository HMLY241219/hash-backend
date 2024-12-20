{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="a_uid@like"  autocomplete="off" placeholder="用户ID">
                        </div>

                        <!--<div class="layui-inline">
                            <input class="layui-input" name="a_vip"  autocomplete="off" placeholder="VIP等级">
                        </div>

                        <div class="layui-inline">
                            <input class="layui-input" name="c_phone"  autocomplete="off" placeholder="手机号">
                        </div>

                        <div class="layui-inline">
                            <div>是否绑定邮箱</div>
                            <select name="email" id="">
                                <option value="">全部</option>
                                <option value="1">是</option>
                                <option value="2">否</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <div>首充状态</div>
                            <select name="shouchong" id="">
                                <option value="">全部</option>
                                <option value="1">是</option>
                                <option value="2">否</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <div>游戏行为</div>
                            <select name="gamestatus1" id="">
                                <option value="">全部</option>
                                <option value="1">是</option>
                                <option value="2">否</option>
                            </select>
                        </div>


                        <div class="layui-inline">
                            <div>今日游戏行为</div>
                            <select name="gamestatus2" id="">
                                <option value="">全部</option>
                                <option value="3">是</option>
                                <option value="4">否</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <div>用户状态</div>
                            <select name="c_status" id="">
                                <option value="">全部</option>
                                <option value="1">正常</option>
                                <option value="0">拉黑</option>

                            </select>
                        </div>

                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{:date('Y-m-d',strtotime('00:00:00 -7day')) .' - '. date('Y-m-d')}" placeholder="注册时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <input class="layui-input" name="coin" type="number"  autocomplete="off" placeholder="余额">
                        </div>

                        <div class="layui-inline">
                            <select name="is_withdraw">
                                <option value="">是否退款</option>
                                <option value="1">是</option>
                                <option value="2">否</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <select name="login_time">
                                <option value="">最近登录时间排序</option>
                                <option value="1">升序</option>
                                <option value="2">降序</option>
                            </select>
                        </div>
                        <div class="layui-inline">
                            <input class="layui-input" name="c_device/id"  autocomplete="off" placeholder="设备号">
                        </div>-->

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
<script type="text/html" id="act">

    <span class="layui-btn layui-btn-xs layui-btn-danger" lay-event="view">用户详情</span>
    <span class="layui-btn layui-btn-primary layui-btn-xs "  style="color:#e54d42"  lay-event="zscoin">赠送记录</span>
    <span class="layui-btn layui-btn-xs layui-btn-warm"  lay-event="coin">流水记录</span>
    <span class="layui-btn layui-btn-xs layui-btn-green"  lay-event="log">牌局日志</span>
<!--    <span class="layui-btn layui-btn-xs layui-btn-danger" lay-event="controller">点控</span>-->
    {{# if(d.agent == 0){ }}
    <span class="layui-btn layui-btn-xs layui-btn-green"  lay-event="agent">代理</span>
    {{# }; }}

    <!--<span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('setUser')}?id={{d.uid}}`)">标签</span>-->
    {if condition ="($admininfo.type == 1)"}
    {/if}
    <!--    <span class="layui-btn layui-btn-xs layui-btn-normal"  lay-event="water">打码量记录</span>-->
    <!--    <span class="layui-btn layui-btn-xs layui-btn-primary"  lay-event="waterlog">打码量调整</span>-->
</script>
<script type="text/html" id="status">
    {{# if(d.status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">正常</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red hover" data-reason="{{d.reason}}" lay-event="showTip">封号</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        var limit = 100;
        laydate.render({
            elem: '#date',
            range : true
        });
        table.render({
            elem: '#table'
            ,defaultToolbar: []
            ,url: "{:url('getlist')}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbarDemo'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'uid', title: '用户ID', minWidth: 88,fixed: 'left',align: 'center'},
                //{field: 'vip', title: 'VIP等级', minWidth: 100,align: 'center',sort:true},
                {field: 'cname', title: '渠道', minWidth: 100,align: 'center'},
                {field: 'status', title: '状态', minWidth: 88,align: 'center', templet:'#status'},
                {field: 'device_id', title: '设备号',align: 'center', minWidth: 150},
                {field: 'coin', title: '余额cash/bonus', minWidth: 140 ,align: 'center',templet: function (d){
                        return d.coin/100 + ' / ' + d.bonus/100
                    }},
                /*{field: 'daytotal_pay_score', title: '当日总充值Cash',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.daytotal_pay_score/100
                    }},
                {field: 'daytotal_give_score', title: '当日赠送Cash',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.daytotal_give_score/100
                    }},
                {field: 'daytotal_exchange', title: '当日退款Cash',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.daytotal_exchange/100
                    }},
                {field: 'daytotal_exchange_num', title: '当日退款次数',align: 'center',sort:true, minWidth: 100},
                {field: 'daytotal_score', title: '当日玩家SY',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.daytotal_score/100
                    }},
                {field: 'first_pay_score', title: '首充Cash',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.first_pay_score/100
                    }},*/
                /*{field: 'day_total_bili', title: '当日退款率',align: 'center', minWidth: 150,templet(d){
                        return (d.day_total_bili*100).toFixed(2) + '%'
                    }},*/
                {field: 'total_pay_score', title: '充值',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.total_pay_score/100
                    }},
                {field: 'login_time', title: '最近登录时间', minWidth: 190,align: 'center'},
                /*{field: 'need_score_water', title: '需求流水',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.need_score_water/100
                    }},*/
                {field: 'now_score_water', title: '下注金额',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.now_score_water/100
                    }},
                {field: 'total_score', title: '输赢金额',align: 'center',sort:true, minWidth: 230,templet(d){
                        return d.total_score/100
                    }},
                {field: 'total_exchange', title: '退款总额',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.total_exchange/100
                    }},

                /*{field: 'total_give_score', title: '总赠送Cash',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.total_give_score/100
                    }},

                {field: 'total_exchange_num', title: '总退款次数',align: 'center',sort:true, minWidth: 100},
                {field: 'total_bili', title: '总退款率(%)',sort:true,align: 'center', minWidth: 150,templet(d){
                        return (d.total_bili*100).toFixed(2) + '%'
                    }},
                {field: 'alltotal_water_score', title: '总流水',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.alltotal_water_score/100
                    }},

                {field: 'all_game_water_bs', title: '总流水倍数',align: 'center',sort:true, minWidth: 150,templet(d){
                        return d.all_game_water_bs/100
                    }},
                {field: 'daytotal_game_num', title: '当日游戏次数',align: 'center',sort:true, minWidth: 150},*/
                /*{field: 'total_game_num', title: '总游戏次数',align: 'center',sort:true, minWidth: 150},
                {field: 'interval', title: '第一次退款花费时间',align: 'center', minWidth: 180},
                {field: 'total_game_day', title: '游戏天数',align: 'center',sort:true, minWidth: 120},
                {field: 'phone', title: '手机号', minWidth: 120,align: 'center'},
                {field: 'ip', title: '注册ip地址', minWidth: 120,align: 'center'},
                {field: 'regist_time', title: '注册时间', minWidth: 190,align: 'center'},*/
                //{fixed: 'right', title: '操作', align: 'center', minWidth: 420, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [100,500,1000,2000] //每页默认显示的数量
        });



        $(document).on('mouseenter', '.hover', function () {
            layer.tips($(this).attr("data-reason"), this, {tips: [1, '#FFB800'], time: 0});
        }).on('mouseleave', '.hover', function () {
            layer.closeAll('tips');
        });


        //单元格工具事件
        table.on('tool(table)', function (obj) {
            let data = obj.data;

            let event = obj.event;

            if (event === 'index') {
                table.reload("table", {
                    page: {
                        curr: 1
                    },
                    where: {
                        idordersn : data.uid
                    },
                    scrollPos: 'fixed',
                });
//               table.reload("table");  //重新加载表格

            }else if(event === 'view'){

                let url = "{:url('view')}?uid="+data.uid;
                window.open(url);


            }else if(event === 'log'){
                layer.open({
                    type: 2,
                    title:'牌局日志',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: "{:url('slots.Slotslog/index')}?uid="+data.uid,//内容
                })



            }else if(event === 'water'){


                layer.open({
                    type: 2,
                    title:'用户ID'+data.uid+'打码量记录',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: "{:url('water')}?uid="+data.uid,//内容
                })



            }else if(event === 'waterlog'){

                layer.open({
                    type: 2,
                    title:'打码量调整',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: "{:url('user.water/index')}?uid="+data.uid,//内容
                });

            }else if(event === 'coin'){


                layer.open({
                    type: 2,
                    title:'流水日志',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: "{:url('user.flowlog/index')}?uid="+data.uid+"&type=1",//内容
                });

            }else if(event === 'zscoin'){


                layer.open({
                    type: 2,
                    title:'赠送记录',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: "{:url('user.flowlog/index')}?uid="+data.uid+"&type=2",//内容
                });

            }else if (event == 'controller'){
                // 弹出层显示两个输入框
                layer.prompt({
                    formType: 2,
                    title: '请输入信息',
                    area: ['300px', '200px'],
                    content: '<div><input type="number" class="layui-layer-input" placeholder="正负分数"></div>' +
                        '<div><input type="number" class="layui-layer-input" placeholder="概率（万分比）如：100为百分一"></div>',
                    btn: ['确定', '取消'],
                    yes: function(index, layero) {
                        var score = layero.find('.layui-layer-input').eq(0).val(); // 获取第一个输入框的值
                        var ratio = layero.find('.layui-layer-input').eq(1).val(); // 获取第二个输入框的值
                        console.log('第一个值：' + score);
                        console.log('第二个值：' + ratio);

                        let loading = layer.msg('通过中', {icon: 16, time: 30 * 1000})
                        $.get("{:url('user.UserSy/oneController')}", {
                            uid: data.uid,
                            score: score,
                            ratio: ratio,
                        }, function (res) {
                            res = JSON.parse(res)
                            if (res.code == 200) {
                                layer.close(loading); // 关闭loading
                                layer.msg('点控成功');
                                table.reloadData("table");
                            } else {
                                layer.close(loading); // 关闭loading
                                table.reloadData("table");
                                layer.msg('点控失败');
                            }
                        })

                        layer.close(index);
                    }
                });

            }else if (event == 'agent'){
                layer.prompt({
                    formType: 2,
                    title: '请输入代理奖金比例(默认70% = 0.7)',
                    area: ['300px', '200px'],
                    content: '<div><input type="number" class="layui-layer-input"></div>',
                    btn: ['确定', '取消'],
                    success: function(layero, index) {
                        // 获取输入框元素
                        var inputElem = layero.find('.layui-layer-input');
                        // 设置输入框的初始值
                        inputElem.val('0.7');
                    },
                    yes: function(index, layero) {
                        var bili = layero.find('.layui-layer-input').eq(0).val(); // 获取第一个输入框的值
                        console.log('第一个值：' + bili);
                        let loadin = layer.msg('设置中', {icon: 16, time: 30 * 1000})
                        $.get("{:url('agent')}", {
                            uid: data.uid,
                            bili: bili,
                        }, function (res) {
                            res = JSON.parse(res)
                            if (res.code == 200) {
                                layer.close(loadin); // 关闭loading
                                layer.msg('设置成功');
                                table.reloadData("table");
                            } else {
                                layer.close(loadin); // 关闭loading
                                table.reloadData("table");
                                layer.msg(res.msg);
                            }
                        })

                        layer.close(index);
                    }
                });

            }

        });

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

