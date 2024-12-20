{extend name="public/layui"}
{block name="style"}
<style>
    #uid{
        cursor: pointer;

    }
    #uid:hover {
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

                        <div class="layui-inline">
                            <input class="layui-input" name="uid"  autocomplete="off" placeholder="用户ID">
                        </div>


                        <div class="layui-inline">
                            <select name="type" id="">
                                <option value="">领取类型</option>
                                <option value="1">已领取</option>
                                <option value="2">未领取</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="submitBtn" data-type="reload">搜索</button>
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
<script type="text/html" id="status">
    {{# if(d.status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">已领取</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">未领取</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer','laydate'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;

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
                {field: 'uid', title: '用户ID(点击查看详情)', align: "center",minWidth: 150,templet(d) {
                        return `<span id='uid'>${d.uid}</span>`;
                    }},
                {field: 'amount', title: '反水金额',align: "center", minWidth: 120,templet(d){
                        return `${(d.amount / 100).toFixed(2)}`
                    }},
                {
                    field: 'status', title: '状态', minWidth: 100,align: "center",templet:"#status"
                },
                {field: 'betrayal_start_date', title: '实际反水日期',align: "center", minWidth: 180},
                {field: 'createtime', title: '创建时间',align: "center", minWidth: 180},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });

        $(document).on('click',"#uid",function(){
            layer.msg($(this).html());
            layer.open({
                type: 2,
                title:'用户详情',
                fixed: false, //不固定
                maxmin: true,
                area : ['1200px','700px'],
                anim:5,//出场动画 isOutAnim bool 关闭动画
                resize:true,//是否允许拉伸
                content: "{:url('user.user/view')}?uid="+$(this).html(),//内容
            });
        });
        {include file="public:submit" /}
    });



</script>
{/block}






