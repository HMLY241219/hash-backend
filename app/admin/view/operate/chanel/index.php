{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <!--                        <div class="layui-inline">-->
                        <!--                            <input class="layui-input" name="a_appname"  autocomplete="off" placeholder="包名">-->
                        <!--                        </div>-->
                        <!---->
                        <!---->
                        <!--                        <div class="layui-inline">-->
                        <!--                            <input class="layui-input" name="a_package/id"  autocomplete="off" placeholder="包ID">-->
                        <!--                        </div>-->
                        <!---->
                        <!---->
                        <!---->
                        <!---->
                        <!--                        <div class="layui-inline">-->
                        <!--                            <button class="layui-btn layui-btn-normal" data-type="reload">搜索</button>-->
                        <!--                        </div>-->

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
    <span class="layui-btn " onclick="window.parent.$eb.createModalFrame(this.innerText,`{:url('add',['package_id' => $package_id])}`)" >添加</span>
</script>
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="window.parent.$eb.createModalFrame(this.innerText,`{:url('edit')}?channel={{d.channel}}`)">编辑</span>
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="delete">删除</span>
    <span class="layui-btn layui-btn-xs layui-btn-normal" onclick="window.parent.$eb.createModalFrame(this.innerText,`{:url('ChannelPoint')}?channel={{d.channel}}&type={{d.type}}&appname={{d.appname}}`)">打点</span>
    <span class="layui-btn layui-btn-xs layui-btn-blue" onclick="window.parent.$eb.createModalFrame(this.innerText,`{:url('AdChannel')}?channel={{d.channel}}&package_id={{d.package_id}}`)">Ad渠道</span>
</script>
<script type="text/html" id="status">
    <input  type="checkbox" name="status"  lay-skin="switch"  value="{{d.id}}" lay-filter="is_show"  lay-text="开启|关闭" {{ d.status==1?'checked':'' }}>
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
            ,url: "{:url('getlist',['a_package/id' => $package_id])}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-60'
            ,page : true
            ,cols: [[
                {field: 'channel', title: '渠道ID', minWidth: 110,fixed: 'left'},
                {field: 'ctag', title: '广告码', minWidth: 120 },
                {field: 'cname', title: '渠道名称', minWidth: 120 },
                {field: 'remark', title: '备注信息', edit: 'text', minWidth: 120},
                {field: 'real_name', title: '操作人', minWidth: 110},
                {field: 'updatetime', title: '操作时间', minWidth: 180},

                {fixed: 'right', title: '操作', align: 'center', width: 240, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });

        {include file="public:layui_edit" /}
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
                        channel : data.channel
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
