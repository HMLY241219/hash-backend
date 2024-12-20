{extend name="public:layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="{:date('Y-m-d') .' - '. date('Y-m-d')}" placeholder="打码量日期" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline">
                            <select name="reason" id="">
                                <option value="">类型</option>
                                <option value="-1">清空</option>
                                {volist name="reason" id="item"}
                                <option value="{$key}">{$item}</option>
                                {/volist}
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
<script type="text/html" id="reason">
    {{# if(d.operate == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">清空</span>
    {{# }else if(d.reason == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-primary">普通充值</span>
    {{# }else if(d.reason == 26){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">WELCOME活动充值</span>
    {{# }else if(d.reason == 27){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color:#e54d42">破产活动充值</span>
    {{# }else if(d.reason == 28){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-warm">100%充值活动充值</span>
    {{# }else if(d.reason == 29){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-disabled">每日充值活动充值</span>
    {{# }else if(d.reason == 18){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color:#f37b1d">每日竞赛奖励</span>
    {{# }else if(d.reason == 20){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color:#fbbd08">每日返水奖励</span>
    {{# }else if(d.reason == 103){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color:#fbbd08">手动修改目标流水</span>
    {{# }else{ }}

    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });
        var limit = 30;
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('waterlist',['uid' => $uid])}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbarDemo'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'time_stamp', title: '时间', minWidth: 190,fixed: 'left'},
                {field: 'reason', title: '分类', minWidth: 120,templet:"#reason"},
                {field: 'coins', title: '金额', minWidth: 88},
                {field: 'water', title: '需求的流水', minWidth: 120},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });



        {include file="public:layui_edit" /}



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
