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

<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>
    <!--<span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="list">参与列表</span>-->
</script>
<script type="text/html" id="status">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="status" lay-filter="is_show"  lay-text="开启|关闭" {{ d.status==1?'checked':'' }}>
</script>
<script type="text/html" id="status">
    {{# if(d.status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">已上线</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">已下线</span>
    {{# }; }}
</script>
<script type="text/html" id="type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">3天卡</span>
    {{# }else if(d.type == 3){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm " style="color:#ca4440;border-color: #ca4440">破产活动</span>
    {{# }else if(d.type == 4){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm " style="color:#dddd00;border-color: #dddd00">客损活动</span>
    {{# }else if(d.type == 6){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm " style="color:#aa00bb;border-color: #aa00bb">客损活动2</span>
    {{# }else if(d.type == 7){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm " style="color:#a1d9f2;border-color: #5A5CAD">存钱罐</span>
    {{# }else if(d.type == 8){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm " style="color:#ac2925;border-color: #cc0000">活动日活动</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">月卡</span>
    {{# }; }}
</script>
<script type="text/html" id="user_type">
    {{# if(d.user_type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">广告</span>
    {{# }else if(d.user_type == 2){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm " style="color:#ca4440;border-color: #ca4440">自然</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">分享</span>
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
                {field: 'id', title: 'ID', minWidth: 88,align: 'center'},
                {field: 'name', title: '活动名称',align: 'center', minWidth: 150},
                {
                    field: 'type', title: '类型',align: 'center', minWidth: 100,templet:"#type"
                },
                {field: 'image', title: '图片', minWidth: 110,align: 'center', templet(d) {
                        return  '<img class="image" src='+d.image+' style="width:50px;height:50px">'
                    }},
                {field: 'price', title: '支付价格',align: 'center', minWidth: 120,templet(d){
                        return `${(d.price/100).toFixed(2)}`
                    }},
                {field: 'min_order_price', title: '历史充值最小金额',align: 'center', minWidth: 120,templet(d){
                        return `${(d.min_order_price/100).toFixed(2)}`
                    }},
                {field: 'max_order_price', title: '历史充值最大金额',align: 'center', minWidth: 120,templet(d){
                        return `${(d.max_order_price/100).toFixed(2)}`
                    }},
                {field: 'lose_money', title: '余额低于多少',align: 'center', minWidth: 120,templet(d){
                        return `${(d.lose_money/100).toFixed(2)}`
                    }},
                {field: 'customer_money', title: '客损金额',align: 'center', minWidth: 120,templet(d){
                        return `${(d.customer_money/100).toFixed(2)}`
                    }},
                {field: 'lose_water_multiple',align: 'center', title: '流水倍数低于多少倍', minWidth: 120},
                {field: 'high_water_multiple',align: 'center', title: '流水倍数高于多少倍', minWidth: 120},
                {field: 'withdraw_bili',align: 'center', title: '退款比例低于多少', minWidth: 120},
                {field: 'piggy_money',align: 'center', title: '存钱罐累计存钱金额', minWidth: 120},
                {field: 'num', title: '活动参与次数',align: 'center', minWidth: 120},
                {field: 'day', title: '连续领取多少天',align: 'center', minWidth: 180},
                {field: 'active_tage_hour', title: '标记多少小时后不能参加该活动ID',align: 'center', minWidth: 180},
                // {
                //     field: 'user_type', title: '用户类型',align: 'center', minWidth: 100,templet:"#user_type"
                // },
                {
                    field: 'status', title: '状态',align: 'center', minWidth: 100,templet:"#status"
                },
                {fixed: 'right', title: '操作', align: 'center', width: 160, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });


        //单元格工具事件
        table.on('tool(table)', function (obj) {
            let data = obj.data;
            let event = obj.event;

            console.log(data);

            if (event === 'list') {
                let url = '/admin/active.activelog/index.html?active_id='+data.id
                console.log(url);

                layer.full(layer.open({
                    type: 2,
                    title:data.name+'参与列表',
                    fixed: false, //不固定
                    maxmin: true,
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: url,//内容
                }));
            }else if(event === 'add'){
                alert('add')
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

        //点击图片放大
        $(document).on('click', '.image',function(){
            layer.photos({
                photos: {
                    "title": "", //相册标题
                    "id": 123, //相册id
                    "start": 0, //初始显示的图片序号，默认0
                    "data": [   //相册包含的图片，数组格式
                        {
                            "alt": "图片名",
                            "pid": 666, //图片id
                            "src": $(this).attr ("src"), //原图地址
                            "thumb": "" //缩略图地址
                        }
                    ]
                }
                ,anim: 0 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
            })

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

