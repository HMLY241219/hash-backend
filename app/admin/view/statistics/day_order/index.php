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
                {field: 'all_money2', title: '总充值', minWidth: 100,sort: true,templet(d){ return d.all_money2}},
                {field: 'm100', title: '100充值/占比', minWidth: 120,templet(d){ return d.m100/100 + ' / ' + (d.all_money>0 ? ((d.m100/d.all_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'm300', title: '300充值/占比', minWidth: 120,templet(d){ return d.m300/100 + ' / ' + (d.all_money>0 ? ((d.m300/d.all_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'm500', title: '500充值/占比', minWidth: 120,templet(d){ return d.m500/100 + ' / ' + (d.all_money>0 ? ((d.m500/d.all_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'm1000', title: '1000充值/占比', minWidth: 120,templet(d){ return d.m1000/100 + ' / ' + (d.all_money>0 ? ((d.m1000/d.all_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'm3000', title: '3000充值/占比', minWidth: 120,templet(d){ return d.m3000/100 + ' / ' + (d.all_money>0 ? ((d.m3000/d.all_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'm5000', title: '5000充值/占比', minWidth: 120,templet(d){ return d.m5000/100 + ' / ' + (d.all_money>0 ? ((d.m5000/d.all_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'm10000', title: '10000充值/占比', minWidth: 120,templet(d){ return d.m10000/100 + ' / ' + (d.all_money>0 ? ((d.m10000/d.all_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'm20000', title: '20000充值/占比', minWidth: 120,templet(d){ return d.m20000/100 + ' / ' + (d.all_money>0 ? ((d.m20000/d.all_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'm49999', title: '49999充值/占比', minWidth: 120,templet(d){ return d.m49999/100 + ' / ' + (d.all_money>0 ? ((d.m49999/d.all_money)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'all_count', title: '总充笔数', minWidth: 100,sort: true},
                {field: 'c100', title: '100笔数/占比', minWidth: 120,templet(d){ return d.c100 + ' / ' + (d.all_count>0 ? ((d.c100/d.all_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'c300', title: '300笔数/占比', minWidth: 120,templet(d){ return d.c300 + ' / ' + (d.all_count>0 ? ((d.c300/d.all_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'c500', title: '500笔数/占比', minWidth: 120,templet(d){ return d.c500 + ' / ' + (d.all_count>0 ? ((d.c500/d.all_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'c1000', title: '1000笔数/占比', minWidth: 120,templet(d){ return d.c1000 + ' / ' + (d.all_count>0 ? ((d.c1000/d.all_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'c3000', title: '3000笔数/占比', minWidth: 120,templet(d){ return d.c3000 + ' / ' + (d.all_count>0 ? ((d.c3000/d.all_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'c5000', title: '5000笔数/占比', minWidth: 120,templet(d){ return d.c5000 + ' / ' + (d.all_count>0 ? ((d.c5000/d.all_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'c10000', title: '10000笔数/占比', minWidth: 120,templet(d){ return d.c10000 + ' / ' + (d.all_count>0 ? ((d.c10000/d.all_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'c20000', title: '20000笔数/占比', minWidth: 120,templet(d){ return d.c20000 + ' / ' + (d.all_count>0 ? ((d.c20000/d.all_count)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'c49999', title: '49999笔数/占比', minWidth: 120,templet(d){ return d.c49999 + ' / ' + (d.all_count>0 ? ((d.c49999/d.all_count)*100).toFixed(2) : '0.00')+'%'}},
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
