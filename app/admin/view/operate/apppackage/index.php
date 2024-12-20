{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">


                        <div class="layui-inline">
                            <select name="a_type"  lay-filter="type" >
                                <option value="">全部</option>
                                <option value="1">主包</option>
                                <option value="2">分享包</option>
                            </select>
                        </div>


                        <div class="layui-inline">
                            <input class="layui-input" name="a_appname"  autocomplete="off" placeholder="请输入包名">
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
<script type="text/html" id="toolbar">
    <span class="layui-btn " onclick="$eb.createModalFrame(this.innerText,`{:url('create_app')}`)" >添加</span>
</script>
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>
    <span class="layui-btn layui-btn-xs layui-btn-blue" onclick="$eb.createModalFrame(this.innerText,`{:url('config')}?id={{d.id}}`)">配置</span>
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="chanel">渠道</span>
    <span class="layui-btn layui-btn-xs layui-btn-blue" onclick="$eb.createModalFrame(this.innerText,`{:url('Adapp')}?id={{d.id}}`)">Ad应用</span>
</script>
<script type="text/html" id="type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">主包</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">分享包</span>
    {{# }; }}
</script>

<script type="text/html" id="hide">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="hide" lay-filter="is_show"  lay-text="开启|关闭" {{ d.hide==1?'checked':'' }}>
</script>
<script type="text/html" id="is_genuine_gold">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="is_genuine_gold" lay-filter="is_show"  lay-text="是|否" {{ d.is_genuine_gold==1?'checked':'' }}>
</script>
<script type="text/html" id="flashback">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="flashback" lay-filter="is_show"  lay-text="是|否" {{ d.flashback==1?'checked':'' }}>
</script>
<script type="text/html" id="gps_status">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="gps_status" lay-filter="is_show"  lay-text="是|否" {{ d.gps_status==1?'checked':'' }}>
</script>
<script type="text/html" id="kefu_status">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="kefu_status" lay-filter="is_show"  lay-text="是|否" {{ d.kefu_status==1?'checked':'' }}>
</script>
<script type="text/html" id="cashgame_status">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="cashgame_status" lay-filter="is_show"  lay-text="是|否" {{ d.cashgame_status==1?'checked':'' }}>
</script>

<script type="text/html" id="pullingame_status">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="pullingame_status" lay-filter="is_show"  lay-text="是|否" {{ d.pullingame_status==1?'checked':'' }}>
</script>

<script type="text/html" id="show_down">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="show_down" lay-filter="is_show"  lay-text="是|否" {{ d.show_down==1?'checked':'' }}>
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
                {field: 'id', title: '包ID', minWidth: 88},
                {field: 'bagname', title: '包中文名', minWidth: 120},
                {field: 'appname', title: '包名', minWidth: 150},
                {field: 'remark1', title: '备注', edit: 'text', minWidth: 80},
                {field: 'type', title: '类型', minWidth: 80, templet:"#type"},
                {field: 'hide', title: '投放状态', minWidth: 100, templet:"#hide"},
                {field: 'is_genuine_gold', title: '是否是纯真金包', minWidth: 150, templet:"#is_genuine_gold"},
                {field: 'cashgame_status', title: '不充值玩游戏', minWidth: 130, templet:"#cashgame_status"},
                {field: 'pullingame_status', title: '是否直接拉入游戏', minWidth: 150, templet:"#pullingame_status"},
                {field: 'gps_status', title: '是否开启gps检测', minWidth: 150, templet:"#gps_status"},
                {field: 'real_name', title: '操作人', minWidth: 110},
                {field: 'updatetime', title: '操作时间', minWidth: 180},
                {fixed: 'right', title: '操作', align: 'center', width: 240, toolbar: '#act'}
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
                    content: "{:url('operate.Chanel/index')}?id="+data.id,//内容
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


