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
</script>
<script type="text/html" id="status">
    <input  type="checkbox"  lay-skin="switch"  value="{{d.id}}" data-field="status" lay-filter="is_show"  lay-text="开启|关闭" {{ d.status==1?'checked':'' }}>
</script>
<script type="text/html" id="status">
    {{# if(d.status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">已上线</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">已下线</span>
    {{# }; }}
</script>
<script type="text/html" id="type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">3天卡</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">月卡</span>
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
                {field: 'id', title: 'ID', minWidth: 88,align: 'center'},
                {field: 'bili', title: '返水比例',align: 'center', minWidth: 150},
                {field: 'minwater', title: '上周最小需求流水',align: 'center', minWidth: 120,templet(d){
                        return `${(d.minwater/100).toFixed(2)}`
                    }},
                {field: 'maxwater', title: '上周最大需求流水',align: 'center', minWidth: 120,templet(d){
                        return `${(d.maxwater/100).toFixed(2)}`
                    }},
                {field: 'maxamount', title: '返奖的最大金额',align: 'center', minWidth: 120,templet(d){
                        return `${(d.maxamount/100).toFixed(2)}`
                    }},
                {fixed: 'right', title: '操作', align: 'center', width: 160, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });


        //单元格工具事件
        table.on('tool(table)', function (obj) {
            let data = obj.data;
            let event = obj.event;

            console.log(data);

            if (event === 'list') {
                let url = '/admin/active.activelog/index.html?active_id='+data.id
                console.log(url);

                layer.full(layer.open({
                    type: 2,
                    title:data.name+'参与列表',
                    fixed: false, //不固定
                    maxmin: true,
                    anim:5,//出场动画 isOutAnim bool 关闭动画
                    resize:true,//是否允许拉伸
                    content: url,//内容
                }));
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
