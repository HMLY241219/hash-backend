{extend name="public:layui"}
{block name="style"}
<style>
    #recallold_num{
        cursor: pointer;

    }
    #recallold_num:hover {
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
<script type="text/html" id="pstatus">
    {{# if(d.pstatus == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#a5c261">valid</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#8900d1">Invalid</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });
        var limit = 200;
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('getlist')}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbarDemo'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'time', title: '发送时间', minWidth: 150},
                {field: 'sms_num', title: '发送数量', minWidth: 120},
                //{field: 'recallold_num', title: '召回数量', minWidth: 120},
                //{field: 'click_num', title: '点击数量', minWidth: 120},
                {field: 'recallold_num', title: '召回数量(点击查看详情)', minWidth: 150,templet(d) {
                        return `<span id='recallold_num' data-time='${d.time}' data-packageId='${d.package_id}'>${d.recallold_num}</span>`;
                    }},
                {field: 'bagname', title: '包名', minWidth: 120},
                // {fixed: 'right', title: '操作', align: 'center', minWidth: 200, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [200,500,1000,2000] //每页默认显示的数量
        });




        $(document).on('click',"#recallold_num",function(){
            var time =  $(this).attr("data-time");
            var package_id =  $(this).attr("data-packageId");
            let url = "{:url('view')}?time="+time+"&package_id="+package_id;//内容
            window.open(url);
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
            }
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

