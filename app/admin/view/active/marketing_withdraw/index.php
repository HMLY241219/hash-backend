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
<!--<script type="text/html" id="toolbar">-->
<!--    <span class="layui-btn " onclick="$eb.createModalFrame(this.innerText,`{:url('add')}`)" >添加</span>-->
<!--</script>-->
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>

</script>
<script type="text/html" id="type">
    {{# if(d.type == 6){ }}
    <span class="layui-btn layui-btn-xs layui-btn-normal">破产商城</span>
    {{# }else if(d.type == 7){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm">客损商城</span>
    {{# }else if(d.type == 20){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm">客损商城2</span>
    {{# }else if(d.type == 10){ }}
    <span class="layui-btn layui-btn-xs" >首充商场</span>
    {{# }else if(d.type == 11){ }}
    <span class="layui-btn layui-btn-xs" style="color: #5A5CAD">二次充值</span>
    {{# }else if(d.type == 12){ }}
    <span class="layui-btn layui-btn-xs" style="color: #a6e1ec">三次充值</span>
    {{# }else if(d.type == 13){ }}
    <span class="layui-btn layui-btn-xs" style="color: #aa00bb">四次充值</span>
    {{# }else if(d.type == 14){ }}
    <span class="layui-btn layui-btn-xs" style="color: #A5C25C">五次充值</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger">普通商场</span>
    {{# }; }}
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
<script type="text/html" id="terminal_type">
    {{# if(d.terminal_type == 1){ }}
    <span class="layui-btn layui-btn-xs layui-btn-normal">横版</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger">竖版</span>
    {{# }; }}
</script>
<script type="text/html" id="is_new_package">
    {{# if(d.is_new_package == 1){ }}
    <span class="layui-btn layui-btn-xs layui-btn-normal">新包</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger">老包</span>
    {{# }; }}
</script>
<script type="text/html" id="status">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="status" lay-filter="is_show"  lay-text="开启|关闭" {{ d.status==1?'checked':'' }}>
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
                {field: 'id', title: 'ID', minWidth: 88,align: 'center'},
                {field: 'cash_config', title: '代付金额配置', minWidth: 120,align: 'center'},
                {field: 'currency', title: '货币类型',align: 'center', minWidth: 120},
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
            if (event === 'chanel') {
                layer.open({
                    type: 2,
                    title:'渠道管理',
                    fixed: false, //不固定
                    maxmin: true,
                    area : ['1200px','700px'],
                    anim:3,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: "{:url('marketing.chanel/index')}?id="+data.id,//内容
                    success: function(layero, index){
                        // 在新页面加载完成之后，执行以下代码
                        console.log(window[layero.find('iframe')],1111)
                        var iframe = window[layero.find('iframe')[0]['name']];
                    }
                });

            }else if(event === 'add'){
                alert('add')

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



