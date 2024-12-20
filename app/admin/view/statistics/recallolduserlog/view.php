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
<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm layui-btn-primary">
            召回总充值金额：<span id="old_price" style="color: red"></span> &nbsp;&nbsp;&nbsp;&nbsp;召回总退款金额：<span id="old_exchange" style="color: red"></span>
            &nbsp;&nbsp;&nbsp;&nbsp;总召回退款率：<span id="old_total_bili" style="color: red"></span> &nbsp;&nbsp;&nbsp;&nbsp;总充值：<span id="total_pay_score" style="color: red"></span>
            &nbsp;&nbsp;&nbsp;&nbsp;总退款金额：<span id="total_exchange" style="color: red"></span>&nbsp;&nbsp;&nbsp;&nbsp;总退款率：<span id="total_bili" style="color: red"></span>
        </button>
    </div>

</script>
<script type="text/html" id="pstatus">
    {{# if(d.pstatus == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#a5c261">valid</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#8900d1">Invalid</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });
        var limit = 200;
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('getUserArray',['time'=>$time,'package_id'=>$package_id])}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbarDemo'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'uid', title: '用户ID(点击查看详情)', minWidth: 150,templet(d) {
                        return `<span id='uid'>${d.uid}</span>`;
                    }},
                {field: 'old_price', title: '召回充值', minWidth: 120,templet(d){
                        return `${(d.old_price / 100).toFixed(2)}`
                    }},
                {field: 'old_exchange', title: '召回退款', minWidth: 120,templet(d){
                        return `${(d.old_exchange / 100).toFixed(2)}`
                    }},
                {field: 'recall_total_bili', title: '召回退款率', minWidth: 88},
                {field: 'total_pay_score', title: '累计充值', minWidth: 120,templet(d){
                        return `${(d.total_pay_score / 100).toFixed(2)}`
                    }},
                {field: 'total_exchange', title: '累计TK', minWidth: 120,templet(d){
                        return `${(d.total_exchange / 100).toFixed(2)}`
                    }},
                {field: 'total_bili', title: '退款率', minWidth: 88},
                {field: 'createtime', title: '召回时间', minWidth: 190, sort: true},

                // {fixed: 'right', title: '操作', align: 'center', minWidth: 200, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [200,500,1000,2000] //每页默认显示的数量
            ,done: function(res, curr, count) {
                var old_price = 0,old_exchange=0,total_pay_score=0,total_exchange=0,old_total_bili = 0,total_bili = 0,data = res.data;
                data.forEach(function(value, index) {
                    `${old_price = (parseFloat(value.old_price) +  parseFloat(old_price)).toFixed(2)}`;
                    `${old_exchange = (parseFloat(value.old_exchange) +  parseFloat(old_exchange)).toFixed(2)}`;
                    `${total_pay_score = (parseFloat(value.total_pay_score) +  parseFloat(total_pay_score)).toFixed(2)}`;
                    `${total_exchange = (parseFloat(value.total_exchange) +  parseFloat(total_exchange)).toFixed(2)}`;
                });
                old_total_bili = old_price > 0 ? ((old_exchange/old_price).toFixed(4) * 100).toFixed(2)+'%' : (old_exchange/100).toFixed(2)+'%'
                total_bili = total_pay_score > 0 ? ((total_exchange/total_pay_score).toFixed(4) * 100).toFixed(2)+'%' : (old_exchange/100).toFixed(2)+'%'
                $("#old_price").html((old_price/100).toFixed(2));
                $("#old_exchange").html((old_exchange/100).toFixed(2));
                $("#total_pay_score").html((total_pay_score/100).toFixed(2));
                $("#total_exchange").html((total_exchange/100).toFixed(2));
                $("#old_total_bili").html(old_total_bili);
                $("#total_bili").html(total_bili);
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


