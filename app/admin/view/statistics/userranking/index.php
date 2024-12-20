{extend name="public:layui"}
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
                            <select name="ranking" lay-filter="ranking" >
                                <option value="1">用户总赢排行</option>
                                <option value="2">用户总输排行</option>
                                <option value="6">用户总充值排行</option>
                                <option value="8">用户总退款排行</option>
                                <option value="3">用户每日赢排行</option>
                                <option value="4">用户每日输排行</option>
                                <option value="7">用户每日充值排行</option>
                                <option value="9">用户每日退款排行</option>
                                <option value="10">用户Cash排行</option>
                                <option value="5">用户金币余额排行</option>
                            </select>
                        </div>


                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{:date('Y-m-d',strtotime('00:00:00 -7day')) .' - '. date('Y-m-d')}" placeholder="选择时间" autocomplete="off" class="layui-input">
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
            <div id="robale_num" style="display: none"></div>
        </div>
    </div>
</div>
{/block}
{block name="script"}


<script>

    layui.use(['table','form','layer'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });
        var limit = 100;
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('getlist')}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbarDemo'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'uid', title: '用户ID(点击查看详情)', minWidth: 150, fixed: 'left',align:'center',templet(d) {
                        return `<span id='uid'>${d.uid}</span>`;
                    }},
                {field: 'regist_time', title: '注册时间',align:'center', minWidth: 180},
                {field: 'last_pay_time', title: '最新支付时间',align:'center', minWidth: 180},
                {field: 'login_time', title: '登录时间',align:'center', minWidth: 180},
                {field: 'coin', title: '玩家余额(卢比元)',align:'center', minWidth: 150,templet(d) {
                        return d.coin ? d.coin /100 : 0;
                    }},
                {field: 'allmoneynum', title: '总充值金额/次数',align:'center', minWidth: 180,templet(d) {
                        return (d.total_pay_score ? d.total_pay_score /100 : 0) +'/'+(d.total_pay_num ? d.total_pay_num : 0) ;
                    }},
                {field: 'allexchangenum', title: '总退款金额/次数',align:'center', minWidth: 180,templet(d) {
                        return (d.total_exchange ? d.total_exchange /100 : 0) +'/'+(d.total_exchange_num ? d.total_exchange_num : 0) ;
                    }},
                {field: 'total_exchange_bili', title: '总退款率',align:'center', minWidth: 180,templet(d) {
                        return (d.total_exchange_bili * 100).toFixed(2) + '%' ;
                    }},
                {field: 'alltotal_score', title: '总游戏SY(卢比元)',align:'center', minWidth: 150,templet(d) {
                        return d.alltotal_score ? d.alltotal_score /100 : 0;
                    }},
                {field: 'daymoneynum', title: '今日充值金额/次数',align:'center', minWidth: 180,templet(d) {
                        return (d.day_total_pay_score ? d.day_total_pay_score /100 : 0) +'/'+(d.day_total_pay_num ? d.day_total_pay_num : 0) ;
                    }},

                {field: 'dayexchangenum', title: '今日退款金额/次数',align:'center', minWidth: 180,templet(d) {
                        return (d.day_total_exchange ? d.day_total_exchange /100 : 0) +'/'+(d.day_total_exchange_num ? d.day_total_exchange_num : 0) ;
                    }},
                {field: 'day_total_exchange_bili', title: '今日退款率',align:'center', minWidth: 180,templet(d) {
                        return (d.day_total_exchange_bili * 100).toFixed(2) + '%' ;
                    }},
                {field: 'daytotal_score', title: '今日游戏SY(卢比元)',align:'center', minWidth: 150,templet(d) {
                        return d.daytotal_score ? d.daytotal_score /100 : 0;
                    }},
                {field: 'tpc', title: '玩家Bonus', minWidth: 150,align:'center',templet(d) {
                        return d.tpc ? d.tpc /100 : 0;
                    }},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [100,150,200,500] //每页默认显示的数量
        });

        // // 监听表格多选事件
        // table.on('checkbox(table)', function(obj){
        //     var selectedData = table.checkStatus('table').data;
        //     console.log(selectedData); // 打印选中的数据
        // });



        // 监听表格工具栏事件
        table.on('toolbar(table)', function(obj){

            if(obj.event === 'RotaryAll'){
                var selectedData = table.checkStatus('table').data;
                if(selectedData.length === 0){
                    return;
                }

                // 将选中的数据提交到后台进行删除操作
                // 使用 Ajax 或其他方式发送请求到后台
                layer.open({
                    title: '提示',
                    content: '是否批量点控转盘?',
                    btn: ['是', '否'],
                    yes: function(index, layero){
                        // 执行确定操作
                        $.post("{:url('RotaryAll')}",{
                            list :selectedData,
                            num :$('#robale_num').html(),
                        },function (res) {
                            res = JSON.parse(res)
                            if(res.code == 200){
                                layer.msg('操作成功');
                                table.reloadData("table");
                                // layer.close(index); // 关闭弹出层
                            }else {
                                layer.msg('操作失败');
                                // layer.close(index); // 关闭弹出层
                            }
                        })

                    },
                    btn2: function(index, layero){
                        // 执行取消操作
                        layer.close(index); // 关闭弹出层
                    }
                });


            }
        });

        //单元格工具事件
        table.on('tool(table)', function (obj) {
            let data = obj.data;

            let event = obj.event;

            if (event == 'controller'){
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

            }

        });


        //下拉选择执行事件
        form.on('select(ranking)',data=>{
            $('#buttom').trigger('click');
        });

        //下拉选择执行事件
        form.on('select(robale)',data=>{
            $('#robale_num').html(data.value);
            console.log($('#robale_num').html(),777);
        });


        form.on("switch(is_show)", function (obj) {
            let data = obj, value = 0;

            if(data.elem.checked){
                value =1;
            }


            if(value == 1){
                $.post("{:url('is_show')}",{
                    uid:data.value,
                    value :value,
                    num :$('#robale_num').html(),
                },function (res) {
                    res = JSON.parse(res)
                    if(res.code == 200){
                        layer.msg('修改成功');
                        table.reloadData("table");
                    }else {
                        layer.msg('修改失败');
                    }
                })
            }


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
