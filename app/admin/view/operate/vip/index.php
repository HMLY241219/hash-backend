{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">



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
    <span class="layui-btn " onclick="$eb.createModalFrame(this.innerText,`{:url('add')}`)" >添加</span>
</script>
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="delete">删除</span>

</script>
<script type="text/html" id="type">
    {{# if(d.type == 6){ }}
    <span class="layui-btn layui-btn-xs layui-btn-normal">破产商城</span>
    {{# }else if(d.type == 7){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm">客损商城</span>
    {{# }else if(d.type == 10){ }}
    <span class="layui-btn layui-btn-xs">首充商场</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger">普通商场</span>
    {{# }; }}
</script>
<script type="text/html" id="user_type">
    {{# if(d.user_type == 1){ }}
    <span class="layui-btn layui-btn-xs layui-btn-normal">广告</span>
    {{# }else if(d.user_type == 2){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm">自然</span>
    {{# }else if(d.user_type == 3){ }}
    <span class="layui-btn layui-btn-xs ">分享</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger">全部</span>
    {{# }; }}
</script>
<script type="text/html" id="terminal_type">
    {{# if(d.terminal_type == 1){ }}
    <span class="layui-btn layui-btn-xs layui-btn-normal">横版</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger">竖版</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer','laydate'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date'
        });
        laydate.render({
            elem: '#date1'
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
                {field: 'id', title: 'ID',align: "center", minWidth: 50},
                {field: 'vip', title: '用户等级',align: "center", minWidth: 80},
                {field: 'need_water', title: '需求流水(元)',align: "center", minWidth: 120,templet(d){
                        return `${(d.need_water / 100).toFixed(2)}`
                    }},
                {field: 'need_pay_price', title: '需要的充值金额(元)',align: "center", minWidth: 120,templet(d){
                        return `${(d.need_pay_price / 100).toFixed(2)}`
                    }},
                // {field: 'betrayal_bili', title: '反水比例',align: "center", minWidth: 120,templet(d){
                //     return `${(d.betrayal_bili * 100).toFixed(2)}%`
                //     }},
                {field: 'daily_reward_bili', title: '每日奖励比例',align: "center", minWidth: 120,templet(d){
                        return `${(d.daily_reward_bili * 100).toFixed(2)}%`
                    }},
                {field: 'sj_amount', title: '升级Cash奖励(元)',align: "center", minWidth: 120,templet(d){
                        return `${(d.sj_amount / 100).toFixed(2)}`
                    }},
                {field: 'sj_bonus', title: '升级Bonus奖励(元)',align: "center", minWidth: 120,templet(d){
                        return `${(d.sj_bonus / 100).toFixed(2)}`
                    }},
                // {field: 'week_order_money', title: '周奖励前1月累计充值(元)',align: "center", minWidth: 180,templet(d){
                //         return `${(d.week_order_money / 100).toFixed(2)}`
                //     }},
                {field: 'week_amount', title: '每周Cash奖励金额(元)',align: "center", minWidth: 150,templet(d){
                        return `${(d.week_amount / 100).toFixed(2)}`
                    }},
                {field: 'week_bonus', title: '每周Bonus奖励金额(元)',align: "center", minWidth: 150,templet(d){
                        return `${(d.week_bonus / 100).toFixed(2)}`
                    }},
                // {field: 'month_order_money', title: '月奖励前3月累计充值(元)',align: "center", minWidth: 180,templet(d){
                //         return `${(d.month_order_money / 100).toFixed(2)}`
                //     }},
                {field: 'month_amount', title: '每月Cash奖励金额(元)',align: "center", minWidth: 150,templet(d){
                        return `${(d.month_amount / 100).toFixed(2)}`
                    }},
                {field: 'month_bonus', title: '每月Bonus奖励金额(元)',align: "center", minWidth: 150,templet(d){
                        return `${(d.month_bonus / 100).toFixed(2)}`
                    }},
                {field: 'day_withdraw_num', title: '每日最大退款次数',align: "center", minWidth: 80},
                {field: 'day_withdraw_money', title: '每日最大退款金额(元)',align: "center", minWidth: 120,templet(d){
                        return `${(d.day_withdraw_money / 100).toFixed(2)}`
                    }},
                {field: 'withdraw_max_money', title: 'Vip退款额度(元)',align: "center", minWidth: 120,templet(d){
                        return `${(d.withdraw_max_money / 100).toFixed(2)}`
                    }},
                {field: 'order_pay_money', title: '前30天需要充值的金额',align: "center", minWidth: 120,templet(d){
                        return `${(d.order_pay_money / 100).toFixed(2)}`
                    }},
                {field: 'new_week_min_amount', title: '新版周返奖最低领取金额',align: "center", minWidth: 120,templet(d){
                        return `${(d.new_week_min_amount / 100).toFixed(2)}`
                    }},
                // {field: 'activation_money', title: '激活金额(元)',align: "center", minWidth: 120,templet(d){
                //         return `${(d.activation_money / 100).toFixed(2)}`
                //     }},
                {fixed: 'right', title: '操作', align: 'center', width: 180, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });

        {include file="public:layui_edit" /}



        //下拉选择执行事件
        form.on('select(type)',data=>{
            $('#buttom').trigger('click');
        });




        //单元格工具事件
        table.on('tool(table)', function (obj) {
            let data = obj.data;
            let event = obj.event;
            console.log(data);
            if (event === 'delete') {
                layer.confirm('是否删除该数据？', {
                    title: "删除",
                }, function(index, layero){
                    $.get("{:url('delete')}",{
                        id : data.id
                    },function (res){
                        res = JSON.parse(res)
                        if(res.code == 200){
                            layer.msg('删除成功');
                            table.reloadData("table");
                        }else {
                            layer.msg('删除失败');
                        }
                    })
                }, function(index){

                });

            }
        });


        form.on("switch(is_show)", function (obj) {
            let data = obj, value = 0,field = $(this).attr('data-field');

            if(data.elem.checked){
                value =1;
            }

            $.post("{:url('is_show')}",{
                id:data.value,
                value :value,
                field :field
            },function (res) {
                res = JSON.parse(res)
                if(res.code == 200){
                    layer.msg('修改成功');
                    table.reloadData("table");
                }else {
                    layer.msg('修改失败');
                }
            })

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



