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
    <input  type="checkbox" name="status"  lay-skin="switch"  value="{{d.id}}" lay-filter="is_show"  lay-text="上线|下线" {{ d.status==1?'checked':'' }}>
</script>
<script type="text/html" id="show_type">
    {{# if(d.show_type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue" style="color: #7F007F">slots厂商显示</span>
    {{# }else if(d.show_type == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-normal" style="color: #FFA00A">体育厂商显示</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-orange" style="color: #b084eb">全部地方显示</span>
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
                {field: 'name', title: '厂商名称', minWidth: 110},
                {field: 'image', title: '厂商图片', minWidth: 110, templet(d) {
                        return  '<img class="image" src='+d.image+' style="width:50px;height:50px">'
                    }},
                {field: 'images', title: '厂商图片2', minWidth: 110, templet(d) {
                        return  '<img class="image" src='+d.images+' style="width:50px;height:50px">'
                    }},
                {field: 'skin2_icon', title: '皮肤2图标', minWidth: 110, templet(d) {
                        return  '<img class="image" src='+d.skin2_icon+' style="width:50px;height:50px">'
                    }},
                {field: 'skin2_image', title: '皮肤2图片', minWidth: 110, templet(d) {
                        return  '<img class="image" src='+d.skin2_image+' style="width:50px;height:50px">'
                    }},



                {field: 'type', title: '简称', minWidth: 80},
                {field: 'weight', title: '权重', minWidth: 80, sort: true},
                {field: 'convert_bonus_bili', title: 'Bonus转化比例', minWidth: 180, sort: true, templet(d){
                    return `${(d.convert_bonus_bili * 100).toFixed(2)}%`
                    }},
                {
                    field: 'show_type', title: '显示地区', minWidth: 100,templet:"#show_type"
                },
                {
                    field: 'status', title: '状态', minWidth: 100,templet:"#status"
                },
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

