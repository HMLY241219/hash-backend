{extend name="public/layui"}
{block name="style"}
<style>
    #scash{
        cursor: pointer;

    }
    #scash:hover {
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
                            <input type="text" name="date" id="date" value="{:date('Y-m-d') .' - '. date('Y-m-d')}" placeholder="时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <select name="pay_type_id" id="payTypeSelect" lay-search>
                                <option value="">请选择支付通道</option>
                                {volist name="pay_type" id="v"}
                                <option value="{$v.id}" >{$v.englishname}</option>
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

<script type="text/html" id="status">
    <input  type="checkbox" name="status"  lay-skin="switch"  value="{{d.level}}" lay-filter="is_show"  lay-text="开启|关闭" {{ d.status==1?'checked':'' }}>
</script>


<script type="text/html" id="type">
    {{# if(d.type == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">Cash</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">Bonus</span>
    {{# }; }}
</script>
<script>

    layui.use(['table','form','layer','laydate'], function () {
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
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-30'
            ,page : true
            ,cols: [[
                {field: 'pay_type_name', title: '支付通道', minWidth: 150,align: 'center'},
                {field: 'payment_type_name', title: '支付方式', minWidth: 150,align: 'center'},

                {field: 'user_num', title: '充值人数',align: 'center', minWidth: 110},
                {field: 'order_num', title: '订单总数',align: 'center', minWidth: 110},
                {field: 'success_num', title: '完成数量',align: 'center', minWidth: 110},
                {field: 'all_price', title: '总充值',align: 'center', minWidth: 110},
                {field: 'success_bili', title: '成功率',align: 'center', minWidth: 110},

            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [2000,5000,10000,20000] //每页默认显示的数量
            ,done: function(res, curr, count) {
                console.log(res);
            }
        });

        var tatistics_type = 1;
        form.on('select(tatisticsType)', function(data){
            tatistics_type = data.value;
        });

        // 重新渲染 select 组件
        form.render('select');

        $(document).on('click',"#scash",function(){
            var title =  $(this).attr("data-title");
            var time = $(this).attr("data-time")
            layer.open({
                type: 2,
                title:'参与用户',
                fixed: false, //不固定
                maxmin: true,
                area : ['1200px','700px'],
                anim:5,//出场动画 isOutAnim bool 关闭动画
                resize:true,//是否允许拉伸
                content: "{:url('userinfoList')}?title="+title+"&time="+time+"&tatistics_type="+tatistics_type,//内容
            });
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


    });

</script>
{/block}



