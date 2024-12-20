{extend name="public/layui"}
{block name="style"}
<style>
    #uid{
        cursor: pointer;

    }
    #uid:hover {
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
                            <input class="layui-input" value="{$uid}" name="a_uid|a_ordersn"  autocomplete="off" placeholder="用户ID/订单号">
                        </div>

                        <div class="layui-inline">
                            <input class="layui-input" name="a_nickname"  autocomplete="off" placeholder="用户昵称">
                        </div>


                        <div class="layui-inline">
                            <select name="a_pay/status" id="">
                                <option value="">请选择订单状态</option>
                                <option value="0">待支付</option>
                                <option value="1">已完成</option>

                            </select>
                        </div>


                        <div class="layui-inline">
                            <input class="layui-input" name="a_tradeodersn"  autocomplete="off" placeholder="第三方订单号">
                        </div>

                        <div class="layui-inline">
                            <select name="a_paytype" id="">
                                <option value="">请选择充值平台</option>
                                {volist name="pay_type" id="v"}
                                <option value="{$v.name}" >{$v.name}</option>
                                {/volist}

                            </select>
                        </div>

                        <div class="layui-inline">
                            <select name="a_active/id" id="">
                                <option value="">请选择活动类型</option>
                                <option value="0">普通充值</option>
                                {volist name="active" id="vo"}
                                <option value="{$vo.id}" >{$vo.name}</option>
                                {/volist}

                            </select>
                        </div>



                        <div class="layui-inline">
                            <select name="a_type" id="">
                                <option value="">请选择充值类型</option>
                                <option value="1">普通充值</option>
                                <option value="2">虚拟币充值</option>
                                <option value="3">人工充值</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <input class="layui-input" name="date"  value="{$createtime}" id="date" autocomplete="off" placeholder="创建日期">
                        </div>
                        <div class="layui-inline">
                            <input class="layui-input" name="date2"  value="" id="date" autocomplete="off" placeholder="用户注册时间">
                        </div>
                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="submitBtn" data-type="reload">搜索</button>
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
<script type="text/html" id="toolbar">
    <span class="layui-btn " onclick="$eb.createModalFrame(this.innerText,`{:url('peopleAdd')}`)" >人工充值</span>
</script>
<script type="text/html" id="act">

    <a class="layui-btn layui-btn-xs layui-btn-primary layui-border-green" lay-event="index">用户订单</a>
    {{# if(d.pay_status == 0){ }}
    <a class="layui-btn layui-btn-xs layui-btn-primary layui-border-red" lay-event="success">完成订单</a>
    {{# }; }}
</script>
<script type="text/html" id="pay_status">
    {{# if(d.pay_status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">已完成</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">待支付</span>
    {{# }; }}
</script>
<script type="text/html" id="type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">普通充值</span>
    {{# }else if(d.type == 3){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm">人工充值</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">数字货币</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer','laydate'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });

        var defaultToolbar = "{$defaultToolbar}"
        var decodedString = defaultToolbar.replace(/&quot;/g, '"');
        var toolbarArray = JSON.parse(decodedString);
        console.log(toolbarArray,3333);
        var limit = 200;
        table.render({
            elem: '#table'
            ,defaultToolbar: toolbarArray
            ,url: "{:url('getlist',['a_uid'=>$uid,'a_pay/status' => $status,'date' => $createtime])}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'ordersn', title: '订单号', align: "center",minWidth: 190},
                {
                    field: 'pay_status', title: '订单状态', align: "center",minWidth: 88,templet:"#pay_status"

                },
                {field: 'uid', title: '用户ID(点击查看详情)', align: "center",minWidth: 150,templet(d) {
                        return `<span id='uid'>${d.uid}</span>`;
                    }},
                {field: 'cname', title: '渠道',align: "center", minWidth: 150, },
                //{field: 'nickname', title: '昵称', minWidth: 150, },
                {field: 'name', title: '活动类型',align: "center", minWidth: 150, templet(d){
                        return d.name ? d.name : '普通充值'
                    }},
                {field: 'all_price', title: '历史充值金额(卢比)', align: "center",minWidth: 160, sort: true,templet(d){
                        return d.all_price/100
                    }},
                {field: 'tradeodersn', title: '三方渠道订单ID', align: "center",minWidth: 190, sort: true},

                {field: 'price', title: '充值金额(卢比)', align: "center",minWidth: 150, sort: true,templet(d){
                        return d.price/100
                    }},
                {field: 'price', title: '到账金额(卢比)',align: "center", minWidth: 150, sort: true,templet(d){
                        return d.price/100
                    }},
                {field: 'fee_money', title: '渠道成本(卢比)', align: "center",minWidth: 150, sort: true,templet(d){
                        return d.fee_money/100
                    }},
                {field: 'paytype', title: '充值平台', align: "center",minWidth: 110, },
                {field: 'pay_chanel', title: '充值渠道',align: "center", minWidth: 110, },
                {field: 'createtime', title: '充值时间', align: "center",minWidth: 180, },
                {field: 'finishtime', title: '到账时间', align: "center",minWidth: 180,},
                //{field: 'user_createtime', title: '用户注册时间', minWidth: 180,},
                {field: 'packname', title: '包名', align: "center",minWidth: 150, },
                {field: 'type', title: '充值类型',align: "center", minWidth: 110,templet:"#type" },
                {field: 'remark', title: '备注',align: "center", minWidth: 150, sort: true},

                // {field: 'phone', title: '电话', minWidth: 120, sort: true},
                // {field: 'email', title: '邮箱', minWidth: 200, sort: true},
                // {field: 'ip', title: 'IP', minWidth: 150, sort: true},



                {fixed: 'right', title: '操作', align: 'center', minWidth: 200, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [200,500,1000,2000] //每页默认显示的数量
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
                        'a_uid' : data.uid
                    },
                    scrollPos: 'fixed',
                });
//               table.reload("table");  //重新加载表格

            }else if(event === 'success'){

                layer.confirm('是否完成订单?',{icon: 3, title:'提示'}, function (index) {
                    const loading = layer.msg('充值中', {icon: 16, time: 30 * 1000})
                    $.post("{:url('completeOrder')}", {
                        id: data.id
                    }, function (res) {
                        console.log(res,33333333);
                        if(res.code == 200){
                            layer.close(loading); // 关闭loading
                            table.reloadData("table");
                            layer.closeAll();
                        }else {
                            layer.msg(res.msg);
                        }

                    });
                });

            }

        });

        {include file="public:submit" /}


    });



</script>
{/block}

