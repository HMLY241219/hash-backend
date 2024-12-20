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
                            <input class="layui-input" name="a_uid@like"  autocomplete="off" placeholder="用户ID">
                        </div>
                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{:date('Y-m-d',strtotime('00:00:00 -7day')) .' - '. date('Y-m-d')}" placeholder="注册时间" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">总充值</label>
                            <div class="layui-input-inline" style="width: 200px;">
                                <input name="min_pay" placeholder="最小总充值" class="layui-input" type="number">
                            </div>
                            <div class="layui-form-mid">-</div>
                            <div class="layui-input-inline" style="width: 200px;">
                                <input name="max_pay" placeholder="最大总充值" class="layui-input" type="number">
                            </div>
                        </div>



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
<!--<script type="text/html" id="toolbarDemo">
    <span class="layui-btn"  lay-event="RotaryAll">批量点控转盘</span>
    <span class="layui-btn"  lay-event="markingShop">批量破产商城</span>
</script>-->
<script type="text/html" id="robalt">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.uid}}" data-field="robalt" lay-filter="is_show"  lay-text="是|否" {{ d.rotary_sd_num > 0?'checked':'' }}>
</script>
<script type="text/html" id="bankruptcynum">
    <input  type="checkbox"  lay-skin="switch" lay-data="6" value="{{d.uid}}" data-field="bankruptcynum" lay-filter="is_markingShop"  lay-text="是|否" {{ d.bankruptcynum > 0?'checked':'' }}>
</script>
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-danger" lay-event="game">每日数据</span>
</script>
<script type="text/html" id="actCon">
    {{# if(d.puid == 0){ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger" lay-event="agent">分配</span>
    {{# }; }}
</script>
<script type="text/html" id="status">
    {{# if(d.status == 0){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">正常</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red hover" data-reason="{{d.reason}}" lay-event="showTip">封号</span>
    {{# }; }}
</script>
<script type="text/html" id="user_type">
    {{# if(d.user_type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">p1</span>
    {{# }else if(d.user_type == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">p2a</span>
    {{# }else if(d.user_type == 3){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">p2b</span>
    {{# }else if(d.user_type == 4){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">p3a</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">p3b</span>
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
                //{type: 'checkbox', fixed: 'left'},
                {field: 'uid', title: '用户ID(可点击)', minWidth: 88,templet(d) {
                        return `<span id='uid'>${d.uid}</span>`;
                    }},
                //{field: 'cname', title: '渠道', minWidth: 140},
                {field: 'puid', title: '上级ID', minWidth: 140},
                /*{
                    field: 'user_type', title: '设备等级', minWidth: 88,templet:"#user_type"
                },*/
                {field: 'regist_time', title: '注册时间', minWidth: 130},
                //{field: 'login_time', title: '最近登录', minWidth: 140},
                {field: 'coin', title: '余额',sort:true, minWidth: 150,templet(d){
                        return d.coin
                    }},
                {field: 'total_pay_score', title: '总充金额',sort:true, minWidth: 150,templet(d){
                        return d.total_pay_score
                    }},
                {field: 'total_exchange', title: '总退金额',sort:true, minWidth: 150,templet(d){
                        return d.total_exchange
                    }},
                /*{field: 'last_pay_time', title: '尾充时间', minWidth: 190},
                {field: 'coin', title: '余额',sort:true, minWidth: 120,templet(d){
                        return d.coin/100
                    }},*/

                //{field: 'model', title: '设备型号',sort:true, minWidth: 150},
                //{field: 'phone_price', title: '手机价格',sort:true, minWidth: 150,templet(d){return d.phone_price/100}},
                //{field: 'robalt', title: '是否赠送转盘', minWidth: 150,fixed: 'right',templet:'#robalt'},
                //{field: 'bankruptcynum', title: '是否破产商城', minWidth: 150,fixed: 'right',templet:'#bankruptcynum'},
                //{title: '操作', align: 'center', minWidth: 100, toolbar: '#act'},
                {fixed: 'right', title: '操作', align: 'center', minWidth: 100, toolbar: '#actCon'},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [100,500,1000,2000] //每页默认显示的数量
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

            }else if(event === 'game'){


                /*let url = "{:url('game')}?uid="+data.uid;
                window.open(url);*/
                let url = "{:url('game')}?uid="+data.uid+"&dates="+data.regist_time_org;
                window.open(url);
                //console.log(url);
               /*layer.open({
                    type: 2,
                    title:'游戏统计',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['60%','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: url,//内容
                });*/

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
                    title: '请输入代理ID',
                    area: ['300px', '200px'],
                    content: '<div><input type="number" class="layui-layer-input"></div>',
                    btn: ['确定', '取消'],
                    success: function(layero, index) {
                        // 获取输入框元素
                        var inputElem = layero.find('.layui-layer-input');
                        // 设置输入框的初始值
                        inputElem.val('0');
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


            }else if (obj.event == 'markingShop'){
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
                        $.post("{:url('markingShop')}",{
                            list :selectedData,
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
        form.on("switch(is_markingShop)", function (obj) {
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
                        $.post("{:url('is_markingShop')}",{
                            uid:data.value,
                            type :type
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
                        //location.reload();
                        //layer.close(index); // 关闭弹出层
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
