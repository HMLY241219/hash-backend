{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <!--<div class="layui-inline">
                            <input class="layui-input" name="a_uid@like"  autocomplete="off" placeholder="用户ID">
                        </div>-->

                        <!--<div class="layui-inline">
                            <input class="layui-input" name="a_vip"  autocomplete="off" placeholder="VIP等级">
                        </div>


                        <div class="layui-inline">
                            <select name="a_status" id="">
                                <option value="">请选择状态</option>
                                <option value="0">正常</option>
                                <option value="1">拉黑</option>

                            </select>
                        </div>-->

                        <!--<div class="layui-inline">
                            <input type="text" name="date" id="date" value="" placeholder="注册时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" data-type="reload">搜索</button>
                        </div>-->

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
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="view">用户详情</span>
    <!--<span class="layui-btn layui-btn-xs layui-btn-warm"  lay-event="record">游戏记录</span>-->
    <span class="layui-btn layui-btn-xs layui-btn-green"  lay-event="log">牌局日志</span>
</script>
<script type="text/html" id="status">
    {{# if(d.status == 0){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">正常</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">封号</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        var limit = 500;
        // 获取完整的URL
        var url = window.location.href;
        // 通过URL创建URL对象
        var urlObj = new URL(url);
        // 获取特定参数的值
        var date = urlObj.searchParams.get('date');
        var day = urlObj.searchParams.get('day');
        var type = urlObj.searchParams.get('type');
        var app = urlObj.searchParams.get('app');
        var network = urlObj.searchParams.get('network');

        laydate.render({
            elem: '#date',
            range : true
        });
        table.render({
            elem: '#table'
            ,defaultToolbar: []
            ,url: "{:url('getlist')}?date="+date+"&day="+day+"&type="+type+"&app="+app+"&network="+network
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbarDemo'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'bagname', title: '包名', minWidth: 160},
                {field: 'cname', title: '渠道', minWidth: 160},
                {field: 'val', title: '金额', minWidth: 160},

                //{fixed: 'right', title: '操作', align: 'center', minWidth: 250, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [500,1000,2000,5000] //每页默认显示的数量
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

                let url = '/admin/user.user/view.html?uid='+data.uid
                console.log(url);

               layer.open({
                    type: 2,
                    title:'用户详情',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: url,//内容
                });

            }else if(event === 'log'){

                // let url = '/admin/user.user/view.html?uid='+data.uid
                // console.log(url);
                // layer.full(
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
                // )


            }else if(event === 'water'){

                // let url = '/admin/user.user/view.html?uid='+data.uid
                // console.log(url);
                // layer.full(
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
                // )


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

            }else if(event === 'record'){
                layer.msg('暂无法用')
                return ;
                // let url = '/admin/user.user/view.html?uid='+data.uid
                // console.log(url);

                layer.open({
                    type: 2,
                    title:'牌局日志',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: "{:url('record')}?uid="+data.uid,//内容
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
