{extend name="public/layui"}
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
                                <option value="1">常规奖励</option>
                                <option value="2">新手奖励</option>
                                <option value="3">大R奖励</option>
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
<script type="text/html" id="type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-xs layui-btn-normal">常规奖励</span>
    {{# }else if(d.type == 2){ }}
    <span class="layui-btn layui-btn-xs layui-btn-warm">新手奖励</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-xs layui-btn-danger">大R奖励</span>
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
                {field: 'uid', title: '用户UID',align: "center", minWidth: 88},
                {field: 'money', title: '领取Cash金额',align: "center", minWidth: 120,templet(d){
                        return `${(d.money / 100).toFixed(2)}`
                    }},
                {field: 'bonus', title: '领取Bonus金额',align: "center", minWidth: 120,templet(d){
                        return `${(d.bonus / 100).toFixed(2)}`
                    }},
                {field: 'type', title: '类型',align: "center", minWidth: 120,templet: '#type'},
                {field: 'createtime', title: '参与时间',align: "center", minWidth: 180},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });


        {include file="public:submit" /}
    });



</script>
{/block}





