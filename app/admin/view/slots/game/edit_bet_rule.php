{extend name="public/layui"}
{block name="content"}
<style>
    #rule-edit {
        padding: 20px;
    }
    #rule-edit .layui-form-label {
        width: 200px;!important;
    }
    #rule-edit .layui-input-block {
        margin-left: 230px;!important;
    }
    #rule-edit .game-info {
        padding: 10px 0;
        font-size: 20px;
    }
</style>
<div class="layui-fluid" id="app">
    <div id="rule-edit">
        <div class="game-info">游戏名称：{$game_name}【ID：{$game_id}】</div>
        <div class="layui-tab layui-tab-brief">
            <ul class="layui-tab-title">
                {if empty($transfer_rule)}
                <li class="layui-this">页面投注</li>
                {else /}
                <li class="layui-this">页面投注</li>
                <li>转账投注</li>
                {/if}
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <form class="layui-form" name="form_page_rule">
                        {foreach $page_rule as $room=>$item}
                        <fieldset class="layui-elem-field layui-field-title">
                            {if $room == 'room_cj'}
                            <legend>初级场</legend>
                            {elseif $room == 'room_zj' /}
                            <legend>中级场</legend>
                            {elseif $room == 'room_gj' /}
                            <legend>高级场</legend>
                            {/if}
                            <div class="layui-field-box">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">输赢赔付率</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="{$room}_loss_ratio" required  lay-verify="required" placeholder="请输入输赢赔付率" autocomplete="off" class="layui-input" value="{$item.loss_ratio}">
                                    </div>
                                </div>
                                {if isset($item.nn_loss_ratio) }
                                <div class="layui-form-item">
                                    <label class="layui-form-label">输赢赔付率（牛9|牛牛）</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="{$room}_nn_loss_ratio" required  lay-verify="required" placeholder="请输入输赢赔付率" autocomplete="off" class="layui-input" value="{$item.nn_loss_ratio}">
                                    </div>
                                </div>
                                {/if}
                                {if isset($item.zx_equal_loss_ratio) }
                                <div class="layui-form-item">
                                    <label class="layui-form-label">输赢赔付率（庄闲-和）</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="{$room}_zx_equal_loss_ratio" required  lay-verify="required" placeholder="请输入输赢赔付率" autocomplete="off" class="layui-input" value="{$item.zx_equal_loss_ratio}">
                                    </div>
                                </div>
                                {/if}
                                {if isset($item.sxfee_refund_ratio) }
                                <div class="layui-form-item">
                                    <label class="layui-form-label">退款手续费率</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="{$room}_sxfee_refund_ratio" required  lay-verify="required" placeholder="请输入手续费率" autocomplete="off" class="layui-input" value="{$item.sxfee_refund_ratio}">
                                    </div>
                                </div>
                                {/if}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">限红</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="{$room}_bet_limit_coin" required  lay-verify="required" placeholder="请输入限红" autocomplete="off" class="layui-input" value="{$item.bet_limit.coin[0]}-{$item.bet_limit.coin[1]}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">格式：最小值-最大值</div>
                                </div>
                                {if !empty($item.bet_limit_other) }
                                <div class="layui-form-item">
                                    <label class="layui-form-label">限红（庄闲-和）</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="{$room}_bet_limit_other_coin" required  lay-verify="required" placeholder="请输入限红" autocomplete="off" class="layui-input" value="{$item.bet_limit_other.coin[0]}-{$item.bet_limit_other.coin[1]}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">格式：最小值-最大值</div>
                                </div>
                                {/if}
                            </div>
                        </fieldset>
                        {/foreach}
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input name="game_id" type="hidden" value="{$game_id}" />
                                <input name="rule_type" type="hidden" value="page" />
                                <button class="layui-btn" lay-submit lay-filter="submit-page-rule">立即提交</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="layui-tab-item">
                    <form class="layui-form" name="form_transfer_rule">
                        {foreach $transfer_rule as $room=>$item}
                        <fieldset class="layui-elem-field layui-field-title">
                            {if $room == 'room_cj'}
                            <legend>初级场</legend>
                            {elseif $room == 'room_zj' /}
                            <legend>中级场</legend>
                            {/if}
                            <div class="layui-field-box">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">输赢赔付率</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="{$room}_loss_ratio" required  lay-verify="required" placeholder="请输入输赢赔付率" autocomplete="off" class="layui-input" value="{$item.loss_ratio}">
                                    </div>
                                </div>
                                {if isset($item.nn_loss_ratio) }
                                <div class="layui-form-item">
                                    <label class="layui-form-label">输赢赔付率（牛9|牛牛）</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="{$room}_nn_loss_ratio" required  lay-verify="required" placeholder="请输入输赢赔付率" autocomplete="off" class="layui-input" value="{$item.nn_loss_ratio}">
                                    </div>
                                </div>
                                {/if}
                                {if isset($item.zx_equal_loss_ratio) }
                                <div class="layui-form-item">
                                    <label class="layui-form-label">输赢赔付率（庄闲-和）</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="{$room}_zx_equal_loss_ratio" required  lay-verify="required" placeholder="请输入输赢赔付率" autocomplete="off" class="layui-input" value="{$item.zx_equal_loss_ratio}">
                                    </div>
                                </div>
                                {/if}
                                {if isset($item.sxfee_refund_ratio) }
                                <div class="layui-form-item">
                                    <label class="layui-form-label">退款手续费率</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="{$room}_sxfee_refund_ratio" required  lay-verify="required" placeholder="请输入手续费率" autocomplete="off" class="layui-input" value="{$item.sxfee_refund_ratio}">
                                    </div>
                                </div>
                                {/if}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">限红-USDT</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="{$room}_bet_limit_usdt" required  lay-verify="required" placeholder="请输入限红" autocomplete="off" class="layui-input" value="{$item.bet_limit.usdt[0]}-{$item.bet_limit.usdt[1]}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">格式：最小值-最大值</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">限红-TRX</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="{$room}_bet_limit_trx" required  lay-verify="required" placeholder="请输入限红" autocomplete="off" class="layui-input" value="{$item.bet_limit.trx[0]}-{$item.bet_limit.trx[1]}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">格式：最小值-最大值</div>
                                </div>
                                {if !empty($item.bet_limit_other) }
                                <div class="layui-form-item">
                                    <label class="layui-form-label">限红-USDT（庄闲-和）</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="{$room}_bet_limit_other_usdt" required  lay-verify="required" placeholder="请输入限红" autocomplete="off" class="layui-input" value="{$item.bet_limit_other.usdt[0]}-{$item.bet_limit_other.usdt[1]}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">格式：最小值-最大值</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">限红-TRX（庄闲-和）</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="{$room}_bet_limit_other_trx" required  lay-verify="required" placeholder="请输入限红" autocomplete="off" class="layui-input" value="{$item.bet_limit_other.trx[0]}-{$item.bet_limit_other.trx[1]}">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">格式：最小值-最大值</div>
                                </div>
                                {/if}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">转账投注地址</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="{$room}_bet_address" required  lay-verify="required" placeholder="请输入投注地址" autocomplete="off" class="layui-input" value="{$item.bet_address}">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        {/foreach}
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input name="game_id" type="hidden" value="{$game_id}" />
                                <input name="rule_type" type="hidden" value="transfer" />
                                <button class="layui-btn" lay-submit lay-filter="submit-transfer-rule">立即提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    layui.use(['form','layer','laydate'], function () {
        let form = layui.form,layer = layui.layer
        // 保存游戏规则
        let saveGameRule = (obj) => {
            let data = obj.field
            let load = layer.load('保存中...')
            $.post("{:url('saveBlockGameRule')}", data, (res) => {
                layer.close(load)
                res = JSON.parse(res)
                layer.msg(res.msg);
            })
        }
        // 监听页面投注规则提交事件
        form.on("submit(submit-page-rule)", function (obj) {
            saveGameRule(obj)
            return false
        })
        // 监听转账投注规则提交事件
        form.on("submit(submit-transfer-rule)", function (obj) {
            saveGameRule(obj)
            return false
        })
    });
</script>
{/block}

