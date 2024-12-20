{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="" placeholder="查询时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <select name="tj_type">
                                <option value="">统计粒度</option>
                                <option value="0">按天统计</option>
                                <option value="1">合计统计</option>
                            </select>
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

        </div>
    </div>
</div>
{/block}
{block name="script"}

<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="list">参与列表</span>
</script>
<script type="text/html" id="status">
    {{# if(d.status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">已上线</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">已下线</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer','laydate'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });
        var limit = 500;
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
                {field: 'date', title: '日期', minWidth: 130,fixed: 'left'},
                {field: 'all_num', title: '总人数', minWidth: 100,sort: true,templet(d){ return d.all_num}},
                {field: 'n10', title: '10分钟内/占比', minWidth: 120,templet(d){ return d.n10 + ' / ' + (d.all_num>0 ? ((d.n10/d.all_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'n20', title: '20分钟内/占比', minWidth: 120,templet(d){ return d.n20 + ' / ' + (d.all_num>0 ? ((d.n20/d.all_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'n30', title: '30分钟内/占比', minWidth: 120,templet(d){ return d.n30 + ' / ' + (d.all_num>0 ? ((d.n30/d.all_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'n60', title: '1小时内/占比', minWidth: 120,templet(d){ return d.n60 + ' / ' + (d.all_num>0 ? ((d.n60/d.all_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'n120', title: '2小时内/占比', minWidth: 120,templet(d){ return d.n120 + ' / ' + (d.all_num>0 ? ((d.n120/d.all_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'n720', title: '12小时内/占比', minWidth: 120,templet(d){ return d.n720 + ' / ' + (d.all_num>0 ? ((d.n720/d.all_num)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'n1440', title: '24小时内/占比', minWidth: 120,templet(d){ return d.n1440 + ' / ' + (d.all_num>0 ? ((d.n1440/d.all_num)*100).toFixed(2) : '0.00')+'%'}},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [500,1000,2000,5000] //每页默认显示的数量
        });

        active = {
            reload: function () {
                //console.log( form.val('form'),111111);
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
