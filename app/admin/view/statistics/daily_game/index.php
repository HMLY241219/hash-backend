{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">
                        <div class="layui-inline">
                            <input type="text" name="date" id="date" value="" placeholder="查询时间" autocomplete="off" class="layui-input">
                        </div>

                        <div class="layui-inline">
                            <select name="tj_type">
                                <option value="">统计粒度</option>
                                <option value="0">按天统计</option>
                                <option value="1">合计统计</option>
                                <option value="2">各游戏合计</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <select name="game/type" lay-filter="game_type">
                                <option value="">游戏名称</option>
                                {volist name="game_name_type" id="vo"}
                                <option value="{$key}">{$vo}</option>
                                {/volist}
                            </select>
                        </div>
                        <div class="layui-inline">
                            <select name="table/level" lay-filter="table_level" id="table_level">
                            </select>
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" id="buttom" data-type="reload">搜索</button>
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
    /*function skip(code){
        var newWindow = window.open("", "_blank");
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "{:url('userList')}";
        form.target = newWindow.name; // 设置表单的target属性为新窗口的名称

        var inputCode = document.createElement("input");
        inputCode.type = "hidden";
        inputCode.name = "users";
        inputCode.value = code;
        form.appendChild(inputCode);

        if ($.browser.safari)
        {
            form.action += '?t=' + new Date().getTime();
        }

        newWindow.document.body.appendChild(form);
        form.submit();
    }*/

    /*function skip(code) {
        var newWindow = window.open("", "_blank");
        var form = $("<form>")
            .attr("method", "POST")
            .attr("action", "{:url('userList')}")
            .attr("target", newWindow.name);

        var inputCode = $("<input>")
            .attr("type", "hidden")
            .attr("name", "users")
            .val(code);

        form.append(inputCode);

        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: form.serialize(),
            success: function(response) {
                // 处理成功响应
            },
            error: function(xhr, status, error) {
                // 处理错误
            },
            complete: function() {
                newWindow.focus();
            }
        });
    }*/
    function skip(code) {
        var form = document.createElement("form");
        form.style.display = "none";
        form.method = "POST";
        form.action = "{:url('userList')}";
        form.target = "_blank";

        var inputCode = document.createElement("input");
        inputCode.type = "hidden";
        inputCode.name = "users";
        inputCode.value = code;

        form.appendChild(inputCode);
        document.body.appendChild(form);

        form.submit();
    }

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
                {field: 'date', title: '日期', minWidth: 180, sort: true,fixed: 'left'},
                //{field: 'game_type', title: '游戏ID', minWidth: 100},
                {field: 'game_type', title: '游戏名', minWidth: 110,fixed: 'left', templet: function (d) {return listGameTypeNew(""+d.game_type+d.table_level)}},
                /*{field: 'user_count', title: '游戏人数', minWidth: 100,templet(d) {
                        return `<span id='open_fairness' style="color: #2196F3; cursor: pointer;text-decoration: underline;" data-users = '${d.user_md5}'>${d.user_count}</span>`;
                    }},*/
                {field: 'user_count', title: '游戏人数', minWidth: 130, templet: '<div><a class="iconfont icon-chakanbaogao" style="margin-left: 3%; color: #2196F3;border-radius: 5px; cursor: pointer;text-decoration: underline;" target="_blank" onclick="skip(`{{d.user_md5}}`)">{{ d.user_count }}</a></div>'},
                {field: 'user_count', title: '人均局数', minWidth: 100,templet(d){ return (d.user_count ? (d.game_count/d.user_count).toFixed(2) : '0.00')}},
                {field: 'bet_score', title: '游戏押注', minWidth: 100, templet(d){ return d.bet_score}},
                {field: 'coin_change', title: '游戏FJ', minWidth: 130,templet(d){ return d.coin_change}},
                {field: 'coin_change', title: 'RTP', minWidth: 100,templet(d){ return (d.bet_score>0 ? ((d.coin_change/d.bet_score)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'pay_coin_change', title: '付费RTP', minWidth: 100,templet(d){ return (d.no_bet_score>0 ? ((d.no_coin_change/d.no_bet_score)*100).toFixed(2) : '0.00') > 0 ? (d.pay_bet_score>0 ? ((d.pay_coin_change/d.pay_bet_score)*100).toFixed(2) : '0.00') : (d.bet_score>0 ? ((d.coin_change/d.bet_score)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'no_coin_change', title: '未付费RTP', minWidth: 100,templet(d){ return (d.no_bet_score>0 ? ((d.no_coin_change/d.no_bet_score)*100).toFixed(2) : '0.00')+'%'}},
                {field: 'service_score', title: '税收', minWidth: 100, templet(d){ return d.service_score}},
                {field: 'bet_score', title: '人均押注', minWidth: 130, templet(d){ return (d.user_count ? ((d.bet_score)/d.user_count).toFixed(0) : '0.00')}},
                {field: 'final_score', title: '游戏盈亏', minWidth: 150, templet: function (d) {return d.final_score}},
                {field: 'final_score', title: '人均盈亏', minWidth: 110, templet(d){ return (d.user_count ? ((d.final_score)/d.user_count).toFixed(2) : '0.00')}},

                {field: 'pay_user_count', title: '付费人数', minWidth: 100},
                {field: 'game_count', title: '游戏局数', minWidth: 100},
                {field: 'ai_bet_score', title: 'AI押注', minWidth: 130,templet(d){ return d.ai_bet_score}},
                {field: 'ai_coin_change', title: 'AI FJ', minWidth: 130,templet(d){ return d.ai_coin_change}},
                {field: 'ai_final_score', title: 'AI盈亏', minWidth: 130,templet(d){ return d.ai_final_score}},
                //{field: 'update_time', title: '更新时间', width: 160, sort: true, templet: function (d) {return formatIndiaDateTime(d.update_time);}},
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [200,500,1000,5000] //每页默认显示的数量
        });

        $(document).on('click',"#open_fairness",function(){
            var users =  $(this).attr("data-users");
            /*layer.open({
                type: 2,
                title:'用户',
                fixed: false, //不固定
                maxmin: true,
                area : ['1200px','700px'],
                anim:5,//出场动画 isOutAnim bool 关闭动画
                resize:true,//是否允许拉伸
                content: "{:url('userList')}?users="+users
            });*/

            $.ajax({
                type: "POST",
                url: "{:url('userList')}",
                data: {"users":users},
                success: function(res) {
                    var html = res;
                    //console.log(res);
                    layer.open({
                        type: 0,
                        //area: ["900px", "520px"],
                        title: "确认查看",
                        content: html,
                    });
                }
            });


        });




        active = {
            reload: function () {
                //console.log( form.val('form'),111111);
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

        form.on('select(game_type)', function(data){
            //data.value 得到被选中的值
            var url = "{:url('getLevel')}?game_type=" + data.value;
            $.get(url,function(data){
                $("#table_level").empty();
                $("#table_level").append(new Option("场次",""));
                $.each(data,function(index,item){
                    $("#table_level").append(new Option(item,index));
                    console.log(index,item);
                });
                layui.form.render("select");
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
