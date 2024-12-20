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
                            <input type="text" name="date" id="date" value="{:date('Y-m-d',strtotime('00:00:00 -7 day')) .' - '. date('Y-m-d')}" placeholder="时间" autocomplete="off" class="layui-input">
                        </div>


                        <div class="layui-inline">
                            <select name="tatisticsType"  lay-filter="tatisticsType">
                                <option value="1">按活动统计</option>
                                <option value="2">按天统计</option>
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
    总赠送充值：<span id="all_price" style="color: #ec4758"></span> &nbsp;&nbsp;&nbsp;&nbsp;总Cash赠送金额：<span id="zs_cash" style="color: #ec4758"></span> &nbsp;&nbsp;&nbsp;&nbsp;总Bonus赠送金额：<span id="zs_bonus" style="color: #ec4758"></span>
</script>

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
                {field: 'time', title: '时间', minWidth: 150,align: 'center'},
                {field: 'title', title: '名称', minWidth: 150,align: 'center'},
                {field: 'num', title: '参与人数(可点击)',align: 'center', minWidth: 110,templet(d) {
                        return `<span id='scash' data-title = '${d.title}' data-time = '${d.time}'>${d.num}</span>`;
                    }},
                {field: 'price', title: '充值金额',align: 'center', minWidth: 110},
                {field: 'money', title: '赠送Cash',align: 'center', minWidth: 160},
                {field: 'bonus', title: '赠送Bonus',align: 'center', minWidth: 160},

            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [2000,5000,10000,20000] //每页默认显示的数量
            ,done: function(res, curr, count) {
                console.log(res);
                var zs_cash = res.zs_money;
                var zs_bonus = res.zs_bonus;
                var all_price = res.all_price;
                $("#zs_cash").html(zs_cash);
                $("#zs_bonus").html(zs_bonus);
                $("#all_price").html(all_price);

            }
        });

        var tatistics_type = 1;
        form.on('select(tatisticsType)', function(data){
            tatistics_type = data.value;
        });

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


