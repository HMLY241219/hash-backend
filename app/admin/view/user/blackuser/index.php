{extend name="public/layui"}
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


                        <div class="layui-inline">
                            <input class="layui-input" name="a_uid"  autocomplete="off" placeholder="用户ID">
                        </div>


                        <div class="layui-inline">
                            <input class="layui-input" name="a_reason"  autocomplete="off" placeholder="封禁原因">
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
    <span class="layui-btn "  lay-event="unblockingUsers">批量解封用户</span>
</script>
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>

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
                {type: 'checkbox', fixed: 'left'},
                {field: 'uid', title: '用户ID(点击查看详情)', minWidth: 150,templet(d) {
                        return `<span id='uid'>${d.uid}</span>`;
                    }},
                {field: 'reason', title: '封禁原因', minWidth: 150},
                {field: 'real_name', title: '操作人', minWidth: 150},
                {field: 'createtime', title: '操作时间', minWidth: 180},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500,1000,2000,5000] //每页默认显示的数量
        });


        // 监听表格工具栏事件
        table.on('toolbar(table)', function(obj){

            if(obj.event === 'unblockingUsers'){
                var selectedData = table.checkStatus('table').data;
                if(selectedData.length === 0){
                    return;
                }

                // 将选中的数据提交到后台进行删除操作
                // 使用 Ajax 或其他方式发送请求到后台
                layer.open({
                    title: '提示',
                    content: '是否批量解封用户?',
                    btn: ['是', '否'],
                    yes: function(index, layero){
                        // 执行确定操作
                        let loading = layer.msg('解封中', {icon: 16, time: 30 * 1000})
                        $.post("{:url('unblockingUsers')}",{
                            list :selectedData,
                        },function (res) {
                            res = JSON.parse(res)
                            layer.close(loading); // 关闭loading
                            if(res.code == 200){
                                layer.msg('操作成功');
                                table.reloadData("table");
                                // layer.close(index); // 关闭弹出层
                            }else {

                                layer.msg('操作失败');
                                // layer.close(index); // 关闭弹出层
                            }
                        })

                    },
                    btn2: function(index, layero){
                        // 执行取消操作
                        layer.close(index); // 关闭弹出层
                    }
                });


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

        //单元格工具事件
        table.on('tool(table)', function (obj) {
            let data = obj.data;
            let event = obj.event;

            console.log(data);

            if (event === 'list') {

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


