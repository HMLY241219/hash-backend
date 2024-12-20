{extend name="public/layui"}
{block name="style"}
<style>
    #uid{
        cursor: pointer;

    }
    #uid:hover{
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

<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>
    <span class="layui-btn layui-btn-xs layui-btn-danger"  lay-event="list">参与列表</span>
</script>
<script type="text/html" id="status">
    {{# if(d.status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">已上线</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">已下线</span>
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
        var limit = 2000;
        var userIds = "{$users}";
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('getUserinfoList')}" //['users' => $users]
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,where:{
                "users":userIds
            }
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'uid', title: '用户ID(点击查看详情)', minWidth: 150, align:'center',fixed: 'left',templet(d) {
                        return `<span id='uid'>${d.uid}</span>`;
                    }},
                {field: 'total_pay_score', title: '总充值', minWidth: 150, align:'center',templet(d) {return d.total_pay_score/100}},
                {field: 'total_exchange', title: '总AAC', minWidth: 150, align:'center',templet(d) {return d.total_exchange/100}},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [2000,3000,4000,5000] //每页默认显示的数量
        });


        $(document).on('click',"#uid",function(){
            layer.msg($(this).html());
            layer.open({
                id :'user',
                type: 2,
                title:'用户详情',
                fixed: false, //不固定
                maxmin: true,
                area : ['1000px','600px'],
                anim:5,//出场动画 isOutAnim bool 关闭动画
                resize:true,//是否允许拉伸
                content: "{:url('user.user/view')}?uid="+$(this).html(),//内容
                zIndex: 9999
            });

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

