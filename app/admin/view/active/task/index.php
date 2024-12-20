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
<script type="text/html" id="status">
    <input  type="checkbox" name="status"  lay-skin="switch"  value="{{d.id}}" lay-filter="is_show"  lay-text="开启|关闭" {{ d.status==1?'checked':'' }}>
</script>
<script type="text/html" id="task_time">
    {{# if(d.task_time == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">周一任务</span>
    {{# }else if(d.task_time == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ca94ff">周二任务</span>
    {{# }else if(d.task_time == 3){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#cc00ff">周三任务</span>
    {{# }else if(d.task_time == 4){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#cc0000">周四任务</span>
    {{# }else if(d.task_time == 5){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#2D93CA">周五任务</span>
    {{# }else if(d.task_time == 6){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ad9361">周六任务</span>
    {{# }else if(d.task_time == 7){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm">周日任务</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">每周任务</span>
    {{# }; }}
</script>
<script type="text/html" id="type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">游戏局数</span>
    {{# }else if(d.type == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ca94ff">游戏赢得局数</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">游戏赢金</span>
    {{# }; }}
</script>
<script type="text/html" id="game_code">
    {{# if(d.game_code == 0){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">全部自研</span>
    {{# }else if(d.game_code == 1003){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ca94ff">TeenPatti</span>
    {{# }else if(d.game_code == 1502){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#cc00ff">Wheel Of Fortune</span>
    {{# }else if(d.game_code == 1503){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#cc0000">Dranon Tiger</span>
    {{# }else if(d.game_code == 1051){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#2D93CA">Lucky Dice</span>
    {{# }else if(d.game_code == 1052){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ad9361">Jhandi Munda</span>
    {{# }else if(d.game_code == 1053){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#cc8500">Lucky Ball</span>
    {{# }else if(d.game_code == 1054){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#a1d9f2">3 Patti Bet</span>
    {{# }else if(d.game_code == 1055){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#a5c261">Andar Bahar</span>
    {{# }else if(d.game_code == 1062){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ac4142">Mine</span>
    {{# }else if(d.game_code == 1070){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#a5c261">Mines</span>
    {{# }else if(d.game_code == 1071){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ca94ff">Mines2</span>
    {{# }else if(d.game_code == 1072){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#cc00ff">Blastx</span>
    {{# }else if(d.game_code == 1399){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#c71c56">Aviator</span>
    {{# }else if(d.game_code == 2151){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm">Lucky Jet</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">Rocket Queen</span>
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
                {field: 'id', title: 'ID', minWidth: 88,align: "center"},
                {field: 'title', title: '名称', minWidth: 110,align: "center"},
                {field: 'introduction', title: '简介', minWidth: 110,align: "center"},
                {field: 'task_time', title: '任务时间', minWidth: 100, align: "center",templet:"#task_time"},
                {field: 'game_code', title: '游戏类型', minWidth: 180, align: "center", templet:"#game_code"},
                {field: 'type', title: '任务类型', minWidth: 100,  align: "center",templet:"#type"},
                {field: 'num', title: '完成次数/对应金额',  align: "center",minWidth: 110},
                {field: 'zs_cash', title: '赠送Cash', align: "center", minWidth: 110,templet(d){
                    return `${(d.zs_cash/100).toFixed(2)}`
                    }},
                {field: 'zs_bonus', title: '赠送Bonus',  align: "center",minWidth: 110,templet(d){
                        return `${(d.zs_bonus/100).toFixed(2)}`
                    }},
                {field: 'zs_integral', title: '赠送积分',  align: "center",minWidth: 110,templet(d){
                        return `${(d.zs_integral/100).toFixed(2)}`
                    }},
                {field: 'weight', title: '权重',  align: "center",minWidth: 110},
                {fixed: 'right', title: '操作', align: 'center', width: 130, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });


        form.on("switch(is_show)", function (obj) {
            let data = obj, status = 0;

            if(data.elem.checked){
                status =1;
            }

            $.post("{:url('is_show')}",{
                id:data.value,
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

        //点击图片放大
        $(document).on('click', '.image',function(){
            layer.photos({
                photos: {
                    "title": "", //相册标题
                    "id": 123, //相册id
                    "start": 0, //初始显示的图片序号，默认0
                    "data": [   //相册包含的图片，数组格式
                        {
                            "alt": "图片名",
                            "pid": 666, //图片id
                            "src": $(this).attr ("src"), //原图地址
                            "thumb": "" //缩略图地址
                        }
                    ]
                }
                ,anim: 0 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
            })

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

