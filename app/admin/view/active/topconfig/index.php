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
<script type="text/html" id="toolbar">
    <span class="layui-btn " onclick="$eb.createModalFrame(this.innerText,`{:url('add')}`)" >添加</span>
</script>
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="delete">删除</span>
</script>
<script type="text/html" id="user_type">
    {{# if(d.user_type == 1){ }}
    <span class="layui-btn layui-btn-xs layui-btn-normal">广告</span>
    {{# }else if(d.user_type == 2){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm">自然</span>
    {{# }else if(d.user_type == 3){ }}
    <span class="layui-btn layui-btn-xs ">分享</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger">全部</span>
    {{# }; }}
</script>
<script type="text/html" id="type">
    {{# if(d.type == 0){ }}
    <span class="layui-btn layui-btn-xs layui-btn-normal">每日排行配置</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger">每周团队排行配置</span>
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
                {field: 'id', title: 'ID',align: "center", minWidth: 88},
                {field: 'rank', title: '排名（范围使用逗号隔开）',align: "center", minWidth: 140},
                {field: 'cash', title: '赠送cash金额（分）',align: "center", minWidth: 120},
                {field: 'bonus', title: '赠送bonus金额(分)',align: "center", minWidth: 180},
                {field: 'type', title: '类型',align: "center", minWidth: 80,toolbar: '#type'},
                {field: 'admin', title: '操作人',align: "center", minWidth: 80},
                {field: 'update_time', title: '操作时间',align: "center", minWidth: 120},
                {fixed: 'right', title: '操作', align: 'center', width: 180, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });

        {include file="public:layui_edit" /}



        //下拉选择执行事件
        form.on('select(type)',data=>{
            $('#buttom').trigger('click');
        });




        //单元格工具事件
        table.on('tool(table)', function (obj) {
            let data = obj.data;
            let event = obj.event;
            console.log(data);
            if (event === 'delete') {
                layer.confirm('是否删除该数据？', {
                    title: "删除",
                }, function(index, layero){
                    $.get("{:url('delete')}",{
                        id : data.id
                    },function (res){
                        res = JSON.parse(res)
                        if(res.code == 200){
                            layer.msg('删除成功');
                            table.reloadData("table");
                        }else {
                            layer.msg('删除失败');
                        }
                    })
                }, function(index){

                });

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

    });



</script>
{/block}





