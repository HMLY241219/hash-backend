{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{:date('Y-m-d').' - '. date('Y-m-d')}" placeholder="查询时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <select id="departmentFirstLevel" name="app" lay-filter="departmentFirstLevel">
                                <option value="">请选择应用</option>
                            </select>
                        </div>
                        <div class="layui-inline">
                            <select id="departmentSecondaryLevel" name="network" lay-filter="departmentSecondaryLevel">
                                <option value="">请选择渠道</option>
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

    layui.use(['table', 'form', 'layer', 'laydate'], function () {
        var form = layui.form, table = layui.table, layer = layui.layer, laydate = layui.laydate;

        laydate.render({
            elem: '#date',
            range: true
        });

        var ChannelData = "{$ChannelData}";
        var decodedString = ChannelData.replace(/&quot;/g, '"');
        var ChannelDataArray = JSON.parse(decodedString);
        console.log(ChannelDataArray, 3333);

        // 初始化第一个选择框
        var firstSelect = document.getElementById('departmentFirstLevel');
        ChannelDataArray.forEach(function (item) {
            var option = document.createElement('option');
            option.value = item.value;
            option.text = item.name;
            firstSelect.appendChild(option);
        });
        form.render('select'); // 重新渲染选择框

        // 监听第一个选择框的变化
        form.on('select(departmentFirstLevel)', function (data) {
            var selectedValue = data.value;
            var secondSelect = document.getElementById('departmentSecondaryLevel');

            // 清空第二个选择框
            secondSelect.innerHTML = '<option value="">请选择渠道</option>';

            // 填充第二个选择框
            ChannelDataArray.forEach(function (item) {
                if (item.value === selectedValue) {
                    item.list.forEach(function (subItem) {
                        var option = document.createElement('option');
                        option.value = subItem.value;
                        option.text = subItem.name;
                        secondSelect.appendChild(option);
                    });
                }
            });

            form.render('select'); // 重新渲染选择框
        });

        var limit = 10000;


        var defaultToolbar = "{$defaultToolbar}"
        var decodedStringTwo = defaultToolbar.replace(/&quot;/g, '"');
        var toolbarArray = JSON.parse(decodedStringTwo);
        console.log(toolbarArray,3333);

        table.render({
            elem: '#table',
            defaultToolbar: toolbarArray,
            url: "{:url('getlist')}",
            cellMinWidth: 80, // 全局定义常规单元格的最小宽度
            method: 'post',
            toolbar: '#toolbar',
            totalRow: true, // 开启合计行
            height: 'full-200',//固定高度-即固定表头固定第一行首行
            page: true,
            cols: [[
                { field: 'campaign_network', title: '名称', minWidth: 180, sort: true ,align: 'center',fixed: 'left'},
                { field: 'attribution_clicks', title: '点击(归因)', minWidth: 180, sort: true ,align: 'center'},
                { field: 'installs', title: '安装', minWidth: 180, sort: true,align: 'center' },
                { field: 'completeregistration_events', title: 'CompleteRegistration', minWidth: 180, sort: true,align: 'center' },
                { field: 'firstpurchase_events', title: 'firstPurchase', minWidth: 180, sort: true,align: 'center' },
                { field: 'todayfirstpurchase_events', title: 'todayfirstPurchase', minWidth: 180, sort: true,align: 'center' },
                { field: 'purchase_events', title: 'Purchase', minWidth: 180, sort: true,align: 'center' },
                { field: 'all_revenue', title: '所有收入', minWidth: 180, sort: true,align: 'center' },
                { field: 'all_revenue_total_d0', title: '0D 所有收入总计', minWidth: 180, sort: true,align: 'center' },
                { field: 'waus', title: '平均 WAU', minWidth: 180, sort: true,align: 'center' },
                { field: 'retention_rate_d1', title: '1D 留存率', minWidth: 180, sort: true,align: 'center' },
                { field: 'retention_rate_d3', title: '3D 留存率', minWidth: 180, sort: true,align: 'center' },
                { field: 'retention_rate_d7', title: '7D 留存率', minWidth: 180, sort: true,align: 'center' },

            ]],
            limit: limit, // 每页默认显示的数量
            limits: [10000, 20000, 30000, 50000] // 每页默认显示的数量
        });

        active = {
            reload: function () {
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
</script>
{/block}