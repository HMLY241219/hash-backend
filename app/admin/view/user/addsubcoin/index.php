{extend name="public/layui"}
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
                            <input type="text" name="date" id="date" value="{:date('Y-m-d') .' - '. date('Y-m-d')}" placeholder="时间" autocomplete="off" class="layui-input">
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
<script type="text/html" id="toolbar">
    <span class="layui-btn " onclick="$eb.createModalFrame(this.innerText,`{:url('add')}`)" >添加</span>
</script>

<script type="text/html" id="status">
    <input  type="checkbox" name="status"  lay-skin="switch"  value="{{d.level}}" lay-filter="is_show"  lay-text="开启|关闭" {{ d.status==1?'checked':'' }}>
</script>
<script type="text/html" id="money_type">
    {{# if(d.money_type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">Cash</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">Bonus</span>
    {{# }; }}
</script>

<script type="text/html" id="coin_type">
    {{# if(d.coin_type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">赠送</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">充值</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer','laydate'], function () {
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
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'id', title: 'ID', minWidth: 80,align:'center'},
                {field: 'uid', title: '用户ID', minWidth: 120,align:'center'},
                {field: 'coin', title: '操作金额(元)',align:'center', minWidth: 110,templet(d){
                        return (d.coin / 100).toFixed(2)
                    }},
                {field: 'money_type', title: '金币类型',align:'center', minWidth: 110,templet:"#money_type"},
                {field: 'coin_type', title: '操作类型',align:'center', minWidth: 110,templet:"#coin_type"},

                {field: 'admin_id', title: '操作人',align:'center', minWidth: 110},
                {field: 'updatetime', title: '操作时间',align:'center', minWidth: 180},
                {field: 'remark', title: '备注',align:'center', minWidth: 250},

            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
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

