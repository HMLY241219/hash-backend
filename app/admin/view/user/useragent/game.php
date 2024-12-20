{extend name="public/layui"}

{block name="title"}列表{/block}
{block name="content"}
<style>
    .remark{
        border: none;
        text-align: center;
    }
    .order{
        cursor: pointer;

    }
    .order:hover{
        color: red;
    }
    .with{
        cursor: pointer;

    }
    .with:hover{
        color: red;
    }
    .yxxq{
        cursor: pointer;

    }
    .yxxq:hover{
        color: red;
    }
    .allcolor{
        color: red;
    }
</style>


<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                {if condition ="empty($userInfo)"}
                <table class="layui-table">
                    <span style="text-align: center;">无数据</span>
                </table>
                {else/}

                {volist name="userInfo" id="vo"}
                    <table class="layui-table" style="width: 700px;">

                            <tbody>
                            <tr>
                                <td>{$vo.day}日SY / 税收 / 充值 / 退款 / 退款率</td>
                                <td>{$vo.total_score} / {$vo.total_service_score} / {$vo.total_pay_score} / {$vo.total_exchange} / {$vo.total_bili}%</td>
                                <!--<td>税收</td>
                                <td>{$vo.total_service_score}</td>
                                <td>充值</td>
                                <td>{$vo.total_pay_score}</td>-->
                            </tr>
                            <!--<tr>
                                <td>退款</td>
                                <td>{$vo.total_exchange}</td>
                                <td>退款率</td>
                                <td>{$vo.total_bili}%</td>
                            </tr>-->
                            </tbody>

                    </table>
                {/volist}
                {/if}
            </div>
        </div>
    </div>
</div>


{/block}

{block name="script"}
<script>
    layui.config({
        base: "{__PLUG_PATH}echarts/"
    }).extend({
        echarts: "echarts"
    }).use(["layer", "form", "echarts", "table"], function () {
        var $ = layui.$, layer = layui.layer, form = layui.form, echarts = layui.echarts, table = layui.table;



        $('.remark').blur(function (res) {
            setRemark($(this).val());
        })
        $('.remark').bind('keypress',function(event){
            if(event.keyCode == "13")
            {
                setRemark($(this).val());
            }
        });


    });

</script>
{/block}
