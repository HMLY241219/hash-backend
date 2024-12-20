{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="a_name"  autocomplete="off" placeholder="提现渠道">
                        </div>

                        <div class="layui-inline">
                            <select name="a_status" id="">
                                <option value="">状态</option>
                                <option value="0">关闭</option>
                                <option value="1">开启</option>

                            </select>
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
    <span class="layui-btn " onclick="$eb.createModalFrame(this.innerText,`{:url('add')}`)" >添加</span>
</script>
<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="delete">删除</span>
</script>
<script type="text/html" id="upi_status">
    {{# if(d.upi_status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">是</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">否</span>
    {{# }; }}
</script>
<script type="text/html" id="is_specific_channel">
    {{# if(d.is_specific_channel == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">是</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">否</span>
    {{# }; }}
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
            ,url: "{:url('getlist')}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'id', title: 'ID', minWidth: 88,fixed: 'left'},
                {field: 'name', title: '渠道名称', minWidth: 110,fixed: 'left'},
                {field: 'englishname', title: '客户端名称', minWidth: 120,fixed: 'left'},
                {field: 'icon', title: 'logo', minWidth: 110, templet(d) {
                        return  '<img class="image" src='+d.icon+' style="width:50px;height:50px">'
                    }},
                {field: 'minmoney', title: '提现最小金额(元)', minWidth: 150, templet(d){
                        return d.minmoney /100
                    }},
                {field: 'maxmoney', title: '提现最大金额(元)', minWidth: 150, templet(d) {
                        return d.maxmoney /100
                    }},
                {field: 'fee_bili', title: '手续费(比例)', minWidth: 120, },
                {field: 'fee_money', title: '手续费(固定值雷亚尔元)', minWidth: 170 , templet(d){
                        return d.fee_money /100
                    }},
                {field: 'weight', title: '权重', minWidth: 80, sort: true},
                {field: 'ht_weight', title: '后台排序权重', minWidth: 80, sort: true},
                {
                    field: 'status', title: '状态', minWidth: 100,templet:"#status"
                },
                {
                    field: 'upi_status', title: '是否支持UPI', minWidth: 100,templet:"#upi_status"
                },
                {
                    field: 'is_specific_channel', title: '是否是特定通道', minWidth: 150,templet:"#is_specific_channel"
                },
                {field: 'video_url', title: '视频链接', minWidth: 80, sort: true},
                {field: 'admin_id', title: '操作人', minWidth: 110},
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

