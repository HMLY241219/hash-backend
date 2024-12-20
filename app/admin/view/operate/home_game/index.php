{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">



                        <!--<div class="layui-inline">
                            <select name="a_type"  lay-filter="type" >
                                <option value="1">首页banner</option>
                                <option value="2">充值banner	</option>
                            </select>
                        </div>


                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" id="buttom" data-type="reload">搜索</button>
                        </div>-->

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
</script>
<script type="text/html" id="status">
    <input  type="checkbox" name="status"  lay-skin="switch"  value="{{d.id}}" lay-filter="is_show"  lay-text="开启|关闭" {{ d.status==1?'checked':'' }}>
</script>
<script type="text/html" id="url_type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">热门</span>
    {{# }else if(d.type == 6){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">推荐</span>
    {{# }else if(d.type == 7){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">真人</span>
    {{# }else if(d.type == 12){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">捕鱼</span>
    {{# }else if(d.type == 3){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">区块链</span>
    {{# }else if(d.type == 13){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">体育</span>
    {{# }else if(d.type == 8){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">Slots</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">厂商</span>
    {{# }; }}
</script>
<script type="text/html" id="end_type">
    {{# if(d.terrace_id == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">移动端</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">PC端</span>
    {{# }; }}
</script>
<script type="text/html" id="skin_type">
    {{# if(d.skin_type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">皮肤1</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">皮肤2</span>
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
                {field: 'id', title: 'ID', minWidth: 88},
                {field: 'name', title: 'name', minWidth: 110},
                {field: 'tag', title: 'tag', minWidth: 110},
                {field: 'icon', title: '图片', minWidth: 110, templet(d) {
                        return  '<img class="image" src='+d.icon+' style="width:50px;height:50px">'
                    }},
                {field: 'click_icon', title: '点击图标', minWidth: 110, templet(d) {
                        return  '<img class="image" src='+d.click_icon+' style="width:50px;height:50px">'
                    }},
                {field: 'weight', title: '权重', minWidth: 80, sort: true},
                {
                    field: 'type', title: '类型', minWidth: 100,templet:"#url_type"
                },
                {
                    field: 'terrace_name', title: '厂商', minWidth: 110
                    //field: 'terrace_id', title: '厂商', minWidth: 100,templet:"#end_type"
                },
                {
                    field: 'status', title: '状态', minWidth: 100,templet:"#status"
                },
                {
                    field: 'skin_type', title: '皮肤类型', minWidth: 100,templet:"#skin_type"
                },
                {field: 'admin', title: '操作人', minWidth: 110},
                {field: 'updatetime', title: '操作时间', minWidth: 180},

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
