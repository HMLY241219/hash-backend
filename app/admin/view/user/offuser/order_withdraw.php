{extend name="public:layui"}
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
<script type="text/html" id="type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">充值</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color:#e54d42">提现</span>
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
            ,url: "{:url('orderWithdrawIndex',['uid' => $uid])}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbarDemo'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'money', title: '充值金额', minWidth: 120,align: 'center',templet(d){
                        return (d.money / 100).toFixed(2);
                    }},
                {field: 'zs_money', title: '赠送Cash', minWidth: 120,align: 'center',align: 'center',templet(d){
                        return  is_zs_money_bonus(d.active_id) ? (d.zs_money / 100).toFixed(2) : 0;
                    }},
                {field: 'zs_bonus', title: '赠送Bonus', minWidth: 120,align: 'center',templet(d){
                        return  is_zs_money_bonus(d.active_id) ? (d.zs_bonus / 100).toFixed(2) : 0;
                    }},
                {field: 'type', title: '类型', minWidth: 88,align: 'center',templet:'#type'},
                {field: 'finishtime', title: '完成时间',align: 'center', minWidth: 190},


            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });



        {include file="public:layui_edit" /}


        function is_zs_money_bonus(active_id) {
            var active_array = [5, 6, 7, 31, 32, 33, 34]; // 几种周卡不需要显示
            for (var i = 0; i < active_array.length; i++) {
                if (active_array[i] === active_id) {
                    return false;
                }
            }
            return true;
        }


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


