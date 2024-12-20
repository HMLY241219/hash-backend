{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">

                        {if condition="$uid <= 0"}
                        <div class="layui-inline">
                            <input class="layui-input" name="uid"  autocomplete="off" placeholder="用户ID">
                        </div>
                        {/if}

                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <div id="reasons" style="width: 300px"></div>
                            </div>
                        </div>

                        <div class="layui-inline">
                            <select name="watertype" id="">
                                <option value="1">Cash流水</option>
                                <option value="2">Bonus流水</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <input type="text" name="datetable" id="date" value="{:date('Y-m-d',strtotime('-7 day')) .' - '. date('Y-m-d')}" placeholder="查询时间" autocomplete="off" class="layui-input">
                        </div>






                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" data-type="reload">搜索</button>
                        </div>
                        {if condition="$type == 2"}
                        <div class="layui-inline">
                            <div><span>赠送总和(卢比元): </span><span id="num" style="font-weight: 900;color: #f37b1d"></span></div>
                        </div>
                        {/if}

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
<script src="/static/plug/layui/xm-select.js"></script>
<script type="text/html" id="status">
    {{# if(d.status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">已完成</span>
    {{# }else if(d.status == -2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">已调整</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">未完成</span>
    {{# }; }}
</script>


<script type="text/html" id="reason">
    {{# if(d.reason == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">充值</span>
    {{# }else if(d.reason == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-primary">充值赠送</span>
    {{# }else if(d.reason == 3){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">Slots</span>
    {{# }else if(d.reason == 4){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color:#e54d42">退款</span>
    {{# }else if(d.reason == 5){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-warm">退款回退</span>
    {{# }else if(d.reason == 6){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-disabled">返水奖励</span>
    {{# }else if(d.reason == 8){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs tk_ht" style="color:#9c5897">钱包雨活动</span>
    {{# }else if(d.reason == 9){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs " style="color:#00ced1">返佣</span>
    {{# }else if(d.reason == 10){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#39b54a">Bonus转换</span>
    {{# }else if(d.reason == 11){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#1cbbb4">转盘</span>
    {{# }else if(d.reason == 12){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#6739b6">slotsJockPot</span>
    {{# }else if(d.reason == 13){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#6739b6">slots锦标赛</span>
    {{# }else if(d.reason == 14){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#9c26b0">slotsAdjust余额</span>
    {{# }else if(d.reason == 15){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#008000">Vip升级奖励</span>
    {{# }else if(d.reason == 16){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#26a65b">Vip周奖励</span>
    {{# }else if(d.reason == 17){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#eb7347">Vip月奖励</span>
    {{# }else if(d.reason == 18){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ec4758">手动加减款</span>
    {{# }else if(d.reason == 19){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#A5C25C">签到</span>
    {{# }else if(d.reason == 20){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#dd0000">3天卡</span>
    {{# }else if(d.reason == 21){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ca94ff">月卡</span>
    {{# }else if(d.reason == 22){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#A5C25C">每日奖励</span>
    {{# }else if(d.reason == 23){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ad1818">破产活动</span>
    {{# }else if(d.reason == 24){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#cc00ff">客损活动</span>
    {{# }else if(d.reason == 25){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#1c6ca1">预流失活动</span>
    {{# }else if(d.reason == 26){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#1c6ca1">破产转盘</span>
    {{# }else if(d.reason == 27){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#845dc4">存钱罐</span>
    {{# }else if(d.reason == 28){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ce8735">每日排行榜</span>
    {{# }else if(d.reason == 29){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#087ec2">任务奖励</span>
    {{# }else if(d.reason == 30){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#8a0d37">积分兑换</span>
    {{# }else if(d.reason == 32){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#ea394c">新日返水</span>
    {{# }else if(d.reason == 33){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#c8a732">新周返水</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs" style="color:#d3869b"></span>
    {{# }; }}
</script>

<script>

    layui.use(['table','form','layer','laydate','xmSelect'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        laydate.render({
            elem: '#date',
            range : true
        });

        var xmSelect = layui.xmSelect;
        //包选择
        $.get("{:url('getReason?type=')}", {
            type: {$type},
        }, function (res) {
            //console.log(res,33333333);
            res = JSON.parse(res)
            if(res.code == 200){
                var pkg_data = res.data;
                var xmSelectInstance = xmSelect.render({
                    el: '#reasons',
                    name: 'reason',
                    layVerify: 'required',
                    placeholder: '3331',
                    //max: 3,     // 最多选择 3 个
                    tips: '类型',
                    data: pkg_data,
                });

                //var resetButton = document.getElementById('reset_new');
                // 添加点击事件监听器
                /*resetButton.addEventListener('click', function() {
                    // 重置所有已选项
                    xmSelectInstance.setValue([]);
                });*/
            }else {
                layer.msg(res.msg);
            }
        });

        var limit = 500;
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('getlist',['uid'=>$uid,'type' => $type])}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'id', title: 'ID', minWidth: 80,fixed:'left',align: 'center'},
                {field: 'uid', title: '用户ID', minWidth: 110,fixed:'left',align: 'center'},
                {field: 'num', title: '变化金额(卢比元)',align: 'center', minWidth: 130,templet(d){
                        return d.num / 100
                    }},
                {field: 'total', title: '变化后余额(卢比元)',align: 'center', minWidth: 130,templet(d){
                        return d.total / 100
                    }},
                {
                    field: 'reason', title: '收支类型',align: 'center', minWidth: 110,templet:"#reason"
                },
                {field: 'createtime', title: '添加时间',align: 'center', minWidth: 180},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [500,1000,2000,5000] //每页默认显示的数量
            , done: function(res, curr, count){
                //如果是异步请求数据方式，res即为你接口返回的信息。
                //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
                // console.log(res);
                // if(res.type == 2){
                //     $('#num').text(res.sum/100)
                // }
            }
        });

        $(document).on('mouseenter', '.tk_ht', function () {
            var that = this
            var rowIndex = $(this).closest('tr').index(); // 获取行索引

            var tableData = layui.table.cache['table']; // 获取表格数据
            var tkData = tableData[rowIndex];
            $.get("{:url('tkFallback')}", {
                data: tkData,
            }, function (res) {
                res = JSON.parse(res)
                if (res.code == 200) {
                    layer.tips(res.data, that, {tips: [1, '#FFB800'], time: 0});
                } else {
                    layer.msg('之前数据无法查看');
                }
            })

        }).on('mouseleave', '.tk_ht', function () {
            layer.closeAll('tips');
        });


        // $(document).on('click', '.tk_ht', function () {
        //     // var columnIndex = $(this).closest('td').index(); // 获取列索引
        //     var rowIndex = $(this).closest('tr').index(); // 获取行索引
        //     var tableData = layui.table.cache['table']; // 获取表格数据
        //     var tkData = tableData[rowIndex];
        //
        // });


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

