{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">

                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <select name="game_id"  lay-filter="type" >
                                <option value="">全部</option>
                                <option value="1511">Blastx</option>
                                <option value="1514">Aviator</option>
                                <option value="1515">Lucky Jet</option>
                                <option value="1516">Rocket Queen</option>
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
<script type="text/html" id="big_reward">
    {{# if(d.big_reward == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">大奖</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">小奖</span>
    {{# }; }}
</script>
<script type="text/html" id="type">
    {{# if(d.type == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">金币</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">TPC</span>
    {{# }; }}
</script>
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?game_id={{d.game_id}}&time={{d.time}}`)">编辑</span>
</script>
<script type="text/html" id="status">
    <input  type="checkbox" name="status"  lay-skin="switch"  value="{{d.level}}" lay-filter="is_show"  lay-text="开启|关闭" {{ d.status==1?'checked':'' }}>
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
            ,page : false
            ,cols: [[
                {field: 'game_id', title: '游戏ID', minWidth: 40},
                {field: 'game_name', title: '名称', minWidth: 120},
                {field: 'time', title: '时间', minWidth: 120},
                {field: 'value', title: '机器人个数', minWidth: 120},
                {fixed: 'right', title: '操作', align: 'center', width: 130, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });
        //下拉选择执行事件
        form.on('select(type)',data=>{
            $('#buttom').trigger('click');
        });

        form.on("switch(is_show)", function (obj) {
            let data = obj, status = 0;

            if(data.elem.checked){
                status =1;
            }

            $.post("{:url('is_show')}",{
                level:data.value,
                status :status
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
                        level : data.level
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

            }else if(event === 'add'){
                alert('add')

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





