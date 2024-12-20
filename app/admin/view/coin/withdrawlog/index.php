{extend name="public/layui"}

{block name="style"}
<style>
    .layui-table-cell{
        font-size: 12px;
    }

    .alldiv span.fontcolor:nth-of-type(1) {
        color:#e54d42;
    }

    .alldiv span.fontcolor:nth-of-type(2) {
        color: #1cbbb4;
    }
    .alldiv span.fontcolor:nth-of-type(3){
        color: #fbbd08;
    }
    .alldiv span.fontcolor:nth-of-type(4){
        color: #0081ff;
    }
    .alldiv span.fontcolor:nth-of-type(5){
        color: #39b54a;
    }
    .alldiv span.fontcolor:nth-of-type(6){
        color: #aa00bb;
    }
    #uid{
        cursor: pointer;

    }
    #uid:hover{
        color: red;
    }
    .alldiv p {
        margin: 0; /* 去掉段落前后的外边距 */
    }
    .glusernum{
        cursor: pointer;
    }
    .glusernum:hover{
        color: red;
    }
    .sendEmailLog{
        cursor: pointer;
    }
    .sendEmailLog:hover{
        color: red;
    }
    .game_log{
        cursor: pointer;
    }
    .game_log:hover{
        color: red;
    }
    .fkgl{
        color: red;
    }
</style>
{/block}

{block name="content"}

<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="a_uid" value="{$uid}" autocomplete="off" placeholder="用户ID">
                        </div>

                        <div class="layui-inline">
                            <input class="layui-input" name="a_ordersn"  autocomplete="off" placeholder="退款订单号">
                        </div>


                        <div class="layui-inline">
                            <select name="a_withdraw/type" id="">
                                <option value="">请选择退款平台</option>
                                {volist name="withdraw_type" id="v"}
                                <option value="{$v.name}" >{$v.name}</option>
                                {/volist}

                            </select>
                        </div>

                        <div class="layui-inline">
                            <select name="a_status" id="">
                                <option value="3">待审核</option>
                                <option value="">全部</option>
                                <option value="0">处理中</option>
                                <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>退款完成</option>
                                <option value="2" <?php echo ($status == 2) ? 'selected' : ''; ?>>退款失败</option>
                                <option value="-1">审核驳回</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <select name="siyutype" id="">
                                <option value="1">普通用户</option>
                                <option value="0">私域网红</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <select name="a_idle/order" id="">
                                <option value="0">正常订单</option>
                                <option value="1">闲置订单</option>
                            </select>
                        </div>



                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{$createtime}" placeholder="退款时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" data-type="reload">搜索</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="layui-card-body">
                <table class=" layui-table" id="table" lay-size="sm" lay-filter="table"></table>
            </div>

        </div>
    </div>
</div>
{/block}
{block name="script"}
<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm layui-btn-primary">
            普通金额：<span id="pt_money"></span> &nbsp;&nbsp;&nbsp;&nbsp;返利金额：<span id="fl_money"></span>
        </button>
        <span class="layui-btn "  lay-event="reviewAll">批量审核成功订单</span>
        <span class="layui-btn "  lay-event="rejectAll">批量驳回订单</span>
        <span class="layui-btn "  lay-event="idleAll">批量闲置订单</span>
    </div>

</script>

<script type="text/html" id="act">
    {{# if(d.status != 0){ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="block">拉黑订单</span>
    {{# }; }}
    {{# if(d.status == 3){ }}
    <span class="layui-btn layui-btn-xs" lay-event="examine">审核 <i class="layui-icon layui-icon-down"></i></span>
    {{# }; }}
    {{# if(d.status == 0){ }}
    <span class="layui-btn layui-btn-xs" lay-event="examine">售后 <i class="layui-icon layui-icon-down"></i></span>
    {{# }; }}
    {{# if(d.status == 2 || d.status == 0|| d.status == -1){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm"  lay-event="send_app_email">发送APP短信</span>
    {{# }; }}
</script>

<script type="text/html" id="status">
    {{# if(d.status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">退款完成</span>
    {{# }else if(d.status == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">退款失败</span>
    {{# }else if(d.status == 3){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-primary">待审核</span>
    {{# }else if(d.status == -1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-warm">审核驳回</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-disabled">处理中</span>
    {{# }; }}
</script>


<script>

    layui.use(['table','form','layer','laydate'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate,dropdown = layui.dropdown;
        laydate.render({
            elem: '#date',
            range : true
        });

        var defaultToolbar = "{$defaultToolbar}"
        var decodedStringTwo = defaultToolbar.replace(/&quot;/g, '"');
        var toolbarArray = JSON.parse(decodedStringTwo);
        console.log(toolbarArray,3333);


        var limit = 100;
        table.render({
            elem: '#table'
            ,defaultToolbar: toolbarArray
            ,url: "{:url('getlist',['a_uid'=>$uid,'a_status' => $status,'date' => $createtime,'a_idle/order'=>0])}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbarDemo'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,lineStyle: 'height: 180px;'
            ,cols: [[
                {type: 'checkbox', fixed: 'left'},
                {field: 'ordersn', title: '订单号', minWidth: 120, align:'center',templet(d){
                        return `<div class='alldiv'>平台订单号:<span class='fontcolor'>${d.ordersn}</span><br>三方订单号:<span class='fontcolor'>${d.platform_id}</span></div>`
                    }},
                {
                    field: 'status', title: '订单状态', minWidth: 88,align:'center',templet(d){
                        return getStatus(d.status)
                    }

                },
                {field: 'money', title: '退款金额', minWidth: 100,sort : true,align:'center',templet(d){
                        return `<div class='alldiv'><span class='fontcolor'>${d.money/100}</span></div>`
                    }},
                {field: 'withdrawal_method', title: '退款数据', minWidth: 180,align:'center',templet(d){
                        return `<div class='alldiv'>退款方式:<span class='fontcolor'>${d.type}</span><br>三方代付平台名称:<span class='fontcolor'>${d.withdraw_type}</span><br>退款手续费:<span class='fontcolor'>${d.fee_money/100}</span><br>到账金额:<span class='fontcolor'>${d.really_money/100}</span></div>`;
                    }},
                {field: 'time', title: '退款时间', minWidth: 180,align:'center',templet(d){
                        return `<div class='alldiv'>创建时间:<span class='fontcolor'>${d.createtime}</span><br>完成时间:<span class='fontcolor'>${d.finishtime}</span></div>`;
                    }},

                {field: 'uid', title: '用户ID(点击查看详情)', minWidth: 150, align:'center',templet(d) {
                        return `<span id='uid'>${d.uid}</span><br><span class='game_log' data-uid='${d.uid}'>牌局日志(可点击)</span><br><span class='fkgl'>${auditdesclist(d.auditdesc)}</span><br>流水倍数:<span>${d.water_multiple}</span>`;
                    }},
                {field: 'history', title: '退款前数据', minWidth: 180,align:'center',templet(d) {
                        return `<div class='alldiv'>余额:<span class='fontcolor'>${d.before_money /100}</span><br>充值金额:<span class='fontcolor'>${d.order_coin /100}</span><br>成功退款金额:<span class='fontcolor'>${d.withdraw_coin/100}</span><br>总退款率:<span class='fontcolor'>${(d.withdraw_bili * 100).toFixed(2)}%</span></div>`;
                    }},
                {field: 'user_associated', title: '用户关联', minWidth: 180,align:'center',templet(d){
                        return `<div class='alldiv'><p class="glusernum" data-uid="${d.uid}">关联用户数量:</p><span class='fontcolor'>${d.gl_user}</span><br>关联用户充值金额:<span class='fontcolor'>${d.gl_order/100}</span><br>关联用户退款金额:<span class='fontcolor'>${d.gl_withdraw/100}</span><br>关联用户退款率:<span class='fontcolor'>${(d.gl_refund_bili * 100).toFixed(2)}%</span></div>`;
                    }},

                {field: 'other_associated', title: '其它关联', minWidth: 180,align:'center',templet(d){
                        return `<div class='alldiv'>设备关联:<span class='fontcolor'>${d.gl_device}</span><br>手机号关联:<span class='fontcolor'>${d.gl_phone}</span><br>邮箱关联:<span class='fontcolor'>${d.gl_email}</span><br>银行卡账户关联:<span class='fontcolor'>${d.gl_bankaccount}</span><br>ip关联:<span class='fontcolor'>${d.gl_ip}</span></div>`;
                    }},


                {field: 'auditInformation', title: '审核信息', minWidth: 180,align:'center',templet(d){
                        return `<div class='alldiv'>触发审核的原因:<span class='fontcolor'>${auditdesclist(d.auditdesc)}</span><br>审核人:<span class='fontcolor'>${d.real_name}</span><br>审核备注信息:<span class='fontcolor'>${d.remark}</span></div>`;
                    }},

                {field: 'withdrawal_method', title: '退款信息', minWidth: 180,align:'center',templet(d){
                        return `<div class='alldiv'>名字:<span class='fontcolor'>${d.backname}</span><br>账户:<span class='fontcolor'>${d.bankaccount}</span><br>IFSC:<span class='fontcolor'>${d.ifsccode}</span></div>`;
                    }},
                {field: 'now_withdraw_money', title: '当前可退款金额', minWidth: 180,align:'center',templet(d){
                        return `<div class='alldiv'>当前可退款Cash:<span class='fontcolor'>${d.now_withdraw_money/100}</span><br>当前可提返利奖励:<span class='fontcolor'>${d.commission_money/100}</span></div>`
                    }},
                {field: 'chinese_error', title: '三方错误信息', align:'center',minWidth: 150,templet(d) {
                        return `<span class='sendEmailLog' data-withdrawId="${d.id}">${d.chinese_error}</span>`;
                    }},
                {field: 'control', title: '风控信息【用户退款订单提交那一时刻的用户余额+每一笔成功退款订单的金额<=总充值金额+总赠送金额+总SY-总税收】', align:'center',minWidth: 180},
                {field: 'send_fail_num', title: '发送APP站内短信次数', minWidth: 150, align:'center'},
                {fixed: 'right', field: 'act',title: '操作', align: 'center', minWidth: 200, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [100,200,500,1000,2000], //每页默认显示的数量

            done: function(res, curr, count) {
                console.log(res);
                var pt_money = res.pt_money;
                var fl_money = res.fl_money;
                $("#pt_money").html(pt_money);
                $("#fl_money").html(fl_money);
                console.log('pt_money:'+pt_money)
                console.log('fl_money:'+fl_money)
            }
        });

        function auditdesclist(auditdesc) {
            var config = ['正常退款','客损金额小于了配置','打码量充值比小于配置','非广告用户特殊地区今日总充值大于配置','非广告用户特殊地区今日总提现大于配置','非广告用户累计退款最大金额','非广告用户单笔最大退款金额','标签需要审核的用户','直接风控的包','关联用户退款率过高']
            return config[auditdesc]
        }


        function getStatus(status){
            if(status == 1){
                var str = '<div class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">退款完成</div>'
            }else if(status == 2){
                var str = '<div class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">退款失败</div>'
            }else if(status == 3){
                var str = '<div class="layui-btn layui-btn-primary layui-btn-xs layui-border-primary">待审核</div>'
            }else if(status == -1){
                var str = '<div class="layui-btn layui-btn-primary layui-btn-xs layui-border-warm">审核驳回</div>'
            }else{
                var str = '<div class="layui-btn layui-btn-primary layui-btn-xs layui-border-disabled">处理中</div>'
            }
            return str;
        }

        $(document).on('click',".game_log",function(){
            var yxxquid =  $(this).attr("data-uid");
            let url = "{:url('slots.Slotslog/index')}?uid="+yxxquid;//内容
            window.open(url);
            // window.open(url);
            // layer.open({
            //     type: 2,
            //     title:'牌局日志',
            //     fixed: false, //不固定
            //     maxmin: true,
            //     area : ['1200px','700px'],
            //     anim:5,//出场动画 isOutAnim bool 关闭动画
            //     resize:true,//是否允许拉伸
            //     content: url,//内容
            // });
        });

        $(document).on('click',"#uid",function(){
            layer.msg($(this).html());
            layer.open({
                type: 2,
                title:'用户详情',
                fixed: false, //不固定
                maxmin: true,
                area : ['1200px','700px'],
                anim:5,//出场动画 isOutAnim bool 关闭动画
                resize:true,//是否允许拉伸
                content: "{:url('user.user/view')}?uid="+$(this).html(),//内容
            });
        });


        $(document).on('click',".glusernum",function(){
            var uid = $(this).attr("data-uid");
            let url = "{:url('association')}?uid="+uid
            window.open(url);
            // var uid = $(this).attr("data-uid");
            //
            // layer.open({
            //     type: 2,
            //     title:'关联用户',
            //     fixed: false, //不固定
            //     maxmin: true,
            //     area : ['1200px','700px'],
            //     anim:5,//出场动画 isOutAnim bool 关闭动画
            //     resize:true,//是否允许拉伸
            //     content: "{:url('association')}?uid="+uid,//内容
            // });
        });

        $(document).on('click',".sendEmailLog",function(){
            var withdrawId = $(this).attr("data-withdrawId");
            layer.open({
                type: 2,
                title:'发送内容',
                fixed: false, //不固定
                maxmin: true,
                area : ['1100px','600px'],
                anim:5,//出场动画 isOutAnim bool 关闭动画
                resize:true,//是否允许拉伸
                content: "{:url('sendEmailLog')}?withdrawId="+withdrawId,//内容
            });
        });




        // 监听表格工具栏事件
        table.on('toolbar(table)', function(obj){
            var selectedData = table.checkStatus('table').data;
            if(selectedData.length === 0){
                return;
            }
            if(obj.event === 'reviewAll'){

                // 将选中的数据提交到后台进行删除操作
                // 使用 Ajax 或其他方式发送请求到后台
                var bottonStatus = true;
                layer.open({
                    title: '提示',
                    content: '是否批量处理订单?',
                    btn: ['是', '否'],
                    yes: function(index, layero){
                        // 执行确定操作
                        if(bottonStatus){
                            bottonStatus = false;
                            let loading = layer.msg('通过中', {icon: 16, time: 30 * 1000})
                            $.post("{:url('reviewAll')}",{
                                list :selectedData,
                            },function (res) {
                                res = JSON.parse(res)
                                if(res.code == 200){
                                    layer.close(loading); // 关闭loading
                                    layer.msg(res.msg);
                                    table.reloadData("table");
                                    // layer.close(index); // 关闭弹出层
                                }else {
                                    layer.close(loading); // 关闭loading
                                    layer.msg(res.msg);
                                    table.reloadData("table");
                                    // layer.close(index); // 关闭弹出层
                                }
                            })
                        }


                    },
                    btn2: function(index, layero){
                        // 执行取消操作
                        layer.close(index); // 关闭弹出层
                    }
                });


            }else if(obj.event === 'rejectAll'){
                var wbool = false;
                layer.prompt({
                    formType: 0,
                    value: '',
                    title: '请输入驳回原因',
                    area: ['800px', '350px'] //自定义文本域宽高
                }, function(value, index, elem){
                    if (!wbool) {
                        wbool = true;
                        layer.close(index);
                        let loading = layer.msg('驳回中', {icon: 16, time: 30 * 1000})
                        $.get("{:url('rejectAll')}", {
                            list :selectedData,
                            remark: value
                        }, function (res) {
                            res = JSON.parse(res)
                            if (res.code == 200) {
                                layer.close(loading); // 关闭loading
                                layer.msg('驳回成功');
                                table.reloadData("table");
                            } else {
                                layer.close(loading); // 关闭loading
                                layer.msg('驳回失败');
                                table.reloadData("table");
                            }
                        })
                    }
                });
            }else if(obj.event === 'idleAll'){
                var wbool = false;
                layer.confirm('确定批量处理吗?',{icon: 3, title:'普通订单会变为闲置订单，并且不会出现在普通订单中。反之'}, function (index) {
                    if(!wbool){
                        wbool = true
                        $.get("{:url('idleAll')}", {
                            list :selectedData,
                        }, function (res) {
                            console.log(res,33333333);
                            res = JSON.parse(res)
                            if(res.code == 200){
                                layer.msg('闲置成功');
                                table.reloadData("table");
                                layer.closeAll();
                            }else {
                                layer.msg(res.msg);
                                layer.closeAll();
                            }

                        });
                    }
                });
            }
        });



        //单元格工具事件
        table.on('tool(table)', function (obj) {
            let data = obj.data;

            let event = obj.event;

            if (event === 'block') {
                layer.confirm('确定要拉黑该比订单吗?',{icon: 3, title:'提示'}, function (index) {

                    $.get("{:url('black_withdraw_log')}", {
                        ordersn: data.ordersn,
                    }, function (res) {
                        console.log(res,33333333);
                        res = JSON.parse(res)
                        if(res.code == 200){
                            layer.msg('拉黑成功');
                            table.reloadData("table");
                            layer.closeAll();
                        }else {
                            layer.msg(res.msg);
                        }

                    });
                });
//               table.reload("table");  //重新加载表格

            }else if(event === 'aa'){

                layer.confirm('是否完成订单?',{icon: 3, title:'提示'}, function (index) {

                    $.post("{:url('successOrder')}", {
                        id: data.id
                    }, function (res) {
                        console.log(res,33333333);
                        if(res.code == 200){
                            table.reloadData("table");
                            layer.closeAll();
                        }else {
                            layer.msg(res.msg);
                        }

                    });
                });

            }else if(event === 'send_app_email'){
                layer.prompt({
                    formType: 0,
                    value: '',
                    title: '请输入邮件内容',
                    area: ['800px', '350px'] //自定义文本域宽高
                }, function(value, index, elem){
                    layer.close(index);
                    let loading = layer.msg('发送中', {icon: 16, time: 30 * 1000})
                    $.get("{:url('send_fail_email')}", {
                        ordersn: data.ordersn,
                        content: value
                    }, function (res) {
                        res = JSON.parse(res)
                        if (res.code == 200) {
                            layer.close(loading); // 关闭loading
                            layer.msg('发送成功');
                            table.reloadData("table");
                        } else {
                            layer.close(loading); // 关闭loading
                            table.reloadData("table");
                            layer.msg('发送失败');
                        }
                    })

                });
            } else if(event === 'examine'){
                //下拉菜单
                // var xialaData = data.status == 0 ? [{
                //         title: '审核驳回'
                //         ,id: 'reject'
                //     }] :
                //     [{
                //         title: '审核成功'
                //         ,id: 'success'
                //     },{
                //         title: '审核驳回'
                //         ,id: 'reject'
                //     }]
                var xialaData = [{
                    title: '审核成功'
                    ,id: 'success'
                },{
                    title: '审核驳回'
                    ,id: 'reject'
                }];
                dropdown.render({
                    elem: this //触发事件的 DOM 对象
                    ,show: true //外部事件触发即显示
                    ,data: xialaData
                    ,click: function(menudata){
                        if(menudata.id === 'success'){

                            var wbool = false;
                            layer.prompt({
                                formType: 0,
                                value: '',
                                title: data.status == 0 ? '这是一笔审核中的订单,请谨慎处理!' : '请输入通过原因',
                                area: ['800px', '350px'] //自定义文本域宽高
                            }, function(value, index, elem){
                                if (!wbool) {
                                    wbool = true;
                                    layer.close(index);
                                    let loading = layer.msg('通过中', {icon: 16, time: 30 * 1000})
                                    $.get("{:url('successOrder')}", {
                                        ordersn: data.ordersn,
                                        remark: value
                                    }, function (res) {
                                        res = JSON.parse(res)
                                        if (res.code == 200) {
                                            layer.close(loading); // 关闭loading
                                            layer.msg(res.msg);
                                            table.reloadData("table");
                                        } else {
                                            layer.close(loading); // 关闭loading
                                            table.reloadData("table");
                                            layer.msg(res.msg);
                                        }
                                    })
                                }
                            });
                        } else if(menudata.id === 'reject'){
                            var wbool = false;
                            layer.prompt({
                                formType: 0,
                                value: '',
                                title: data.status == 0 ? '这是一笔审核中的订单,请谨慎处理!' : '请输入通过原因',
                                area: ['800px', '350px'] //自定义文本域宽高
                            }, function(value, index, elem){
                                if (!wbool) {
                                    wbool = true;
                                    layer.close(index);
                                    let loading = layer.msg('驳回中', {icon: 16, time: 30 * 1000})
                                    $.get("{:url('reject')}", {
                                        ordersn: data.ordersn,
                                        remark: value
                                    }, function (res) {
                                        res = JSON.parse(res)
                                        if (res.code == 200) {
                                            layer.msg('驳回成功');
                                            table.reloadData("table");
                                            layer.close(loading); // 关闭loading
                                        } else {
                                            layer.msg('驳回失败');
                                            table.reloadData("table");
                                            layer.close(loading); // 关闭loading
                                        }
                                    })
                                }
                            });

                        }
                    }
                    ,align: 'right' //右对齐弹出
                    ,style: 'box-shadow: 1px 1px 10px rgb(0 0 0 / 12%);' //设置额外样式
                })
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
