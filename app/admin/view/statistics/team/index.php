{extend name="public:layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="a_uid"  autocomplete="off" placeholder="用户ID">
                        </div>

                        <div class="layui-inline">
                            <input class="layui-input" name="a_puid"  autocomplete="off" placeholder="上级用户ID">
                        </div>

                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{:date('Y-m-d',strtotime('-7 day')) .' - '. date('Y-m-d')}" placeholder="推广时间" autocomplete="off" class="layui-input">
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
        var limit = 30;
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
                {field: 'uid', title: '用户ID', minWidth: 88, align: "center",fixed: 'left'},
                {field: 'vip', title: '用户等级', minWidth: 88, align: "center"},
                {field: 'puid', title: '上级用户ID', minWidth: 120, align: "center"},
                // {field: 'pstatus', title: '用户状态', minWidth: 120, templet:"#pstatus"},
                {field: 'total_pay_score', title: '用户总充值', minWidth: 120, align: "center", templet(d){
                    return `${(d.total_pay_score / 100).toFixed(2)}`
                    }},
                {field: 'createtime', title: '推广时间', minWidth: 190, sort: true, align: "center"},
                {field: 'updatetime', title: '更新时间', minWidth: 190, align: "center"},

                // {fixed: 'right', title: '操作', align: 'center', minWidth: 200, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });



        {include file="public:layui_edit" /}



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
