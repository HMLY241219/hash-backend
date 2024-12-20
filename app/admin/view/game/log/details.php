{extend name="public:layui" /}

{block name="title"}牌局详情{/block}
{block name="style"}
<style>
    .layui-fluid {font-family: "Helvetica Neue", arial, sans-serif;}
    .inner_td {display: flex;margin: -1px;}
    .inner_td span {flex: 1;}
</style>
{/block}

{block name="content"}

{if condition="$info['game_type']==1002"} <!-- 印度炸金花TP -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} [{$info.table_level}] 开奖结果</h3>
    </div>
    <div class="layui-col-md12">
        <?php
        $list = getCardType(true);
        unset($list[0]);
        $list = implode(' < ', $list);
        ?>
        <h4>{$list}</h4>
        <?php unset($list); ?>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>手牌</td>
                        <td>牌型</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td class="inner_td"><span>{$vo.cards_0|getCardName}</span><span>{$vo.cards_1|getCardName}</span><span>{$vo.cards_2|getCardName}</span></td>
                        <td>{$vo.value_1|getCardType} {$vo.value_2==1?'[弃牌]':''}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1001"} <!-- 印度拉米 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} [{$info.table_level}] 开奖结果</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <!--                        <td>手牌</td>-->
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>

                        <!--                        <td class="inner_td">-->
                        <!--                            <span>{$vo.add_bet_0|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_1|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_2|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_3|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_4|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_5|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_6|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_7|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_8|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_9|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_10|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_11|getCardName}</span>-->
                        <!--                            <span>{$vo.add_bet_12|getCardName}</span>-->
                        <!--                        </td>-->
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1504"} <!-- 7UP骰子 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info['cards_0'] + $info['cards_1']} 点</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>2-6</td>
                        <td>7</td>
                        <td>8-12</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.add_bet_0/100}</td>
                        <td>{$vo.add_bet_2/100}</td>
                        <td>{$vo.add_bet_1/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1501"} <!-- 新AB -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info.cards_0==0?'A':'B'} - {$info.cards_1}</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>Andar</td>
                        <td>Bahar</td>
                        <td>1~5</td>
                        <td>6~10</td>
                        <td>11~15</td>
                        <td>16~25</td>
                        <td>26~30</td>
                        <td>31~35</td>
                        <td>36~40</td>
                        <td>41~more</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.add_bet_0/100}</td>
                        <td>{$vo.add_bet_1/100}</td>
                        <td>{$vo.add_bet_2/100}</td>
                        <td>{$vo.add_bet_3/100}</td>
                        <td>{$vo.add_bet_4/100}</td>
                        <td>{$vo.add_bet_5/100}</td>
                        <td>{$vo.add_bet_6/100}</td>
                        <td>{$vo.add_bet_7/100}</td>
                        <td>{$vo.add_bet_8/100}</td>
                        <td>{$vo.add_bet_9/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1507"} <!-- 国王和皇后 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info['value_1']|getResultBy1028}</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>KING</td>
                        <td>QUEEN</td>
                        <td>TIE</td>
                        <td>SUITED TIE</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.add_bet_0/100}</td>
                        <td>{$vo.add_bet_1/100}</td>
                        <td>{$vo.add_bet_2/100}</td>
                        <td>{$vo.add_bet_3/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1506"} <!-- wingo -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info['cards_0']}</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>1,2,3,4(绿色)</td>
                        <td>0,5(紫色)</td>
                        <td>6,7,8,9(红色)</td>
                        <td>0</td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                        <td>9</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.add_bet_0/100}</td>
                        <td>{$vo.add_bet_1/100}</td>
                        <td>{$vo.add_bet_2/100}</td>
                        <td>{$vo.add_bet_3/100}</td>
                        <td>{$vo.add_bet_4/100}</td>
                        <td>{$vo.add_bet_5/100}</td>
                        <td>{$vo.add_bet_6/100}</td>
                        <td>{$vo.add_bet_7/100}</td>
                        <td>{$vo.add_bet_8/100}</td>
                        <td>{$vo.add_bet_9/100}</td>
                        <td>{$vo.add_bet_10/100}</td>
                        <td>{$vo.add_bet_11/100}</td>
                        <td>{$vo.add_bet_12/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1508"} <!-- 百人金花 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12" style="padding-bottom: 20px;">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info.value_1?'海盗':'船长'} - {$info.value_2|getResultBy1026}</h3>
    </div>
    <div class="layui-col-md6" style="border-right: groove;">
        {$info['cards_0']|getCardName} &emsp; {$info['cards_1']|getCardName} &emsp; {$info['cards_2']|getCardName}
    </div>
    <div class="layui-col-md6">
        {$info['cards_3']|getCardName} &emsp; {$info['cards_4']|getCardName} &emsp; {$info['cards_5']|getCardName}
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>Captain船长</td>
                        <td>Pirate海盗</td>
                        <td>大对子</td>
                        <td>金花</td>
                        <td>顺子</td>
                        <td>金顺子</td>
                        <td>豹子</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.add_bet_0/100}</td>
                        <td>{$vo.add_bet_1/100}</td>
                        <td>{$vo.add_bet_2/100}</td>
                        <td>{$vo.add_bet_3/100}</td>
                        <td>{$vo.add_bet_4/100}</td>
                        <td>{$vo.add_bet_5/100}</td>
                        <td>{$vo.add_bet_6/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1025"} <!-- Joker -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} 开奖结果</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>权重值</td>
                        <td>点控目标值</td>
                        <td>点控等级</td>
                        <td>个控目标值</td>
                        <td>下注金额</td>
                        <td>下注结果</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.weight}</td>
                        <td>{$vo.point_score}</td>
                        <td>{$vo.point_lv|getPointLevel}</td>
                        <td>{$vo.personal_score}</td>
                        <td>{$vo.bet_score/100}</td>
                        <td>{$info.control_win_or_loser|getBetResult}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1024"} <!-- AK47 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} 开奖结果</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>权重值</td>
                        <td>点控目标值</td>
                        <td>点控等级</td>
                        <td>个控目标值</td>
                        <td>下注金额</td>
                        <td>下注结果</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.weight}</td>
                        <td>{$vo.point_score}</td>
                        <td>{$vo.point_lv|getPointLevel}</td>
                        <td>{$vo.personal_score}</td>
                        <td>{$vo.bet_score/100}</td>
                        <td>{$info.control_win_or_loser|getBetResult}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1505"} <!-- 印度骰子 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>2个3倍、3个5倍、4个10倍、5个20倍、6个100倍</h3>
        <h3>{$info.game_type|getGameType|raw} 开奖结果</h3>

        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>骰子1</td>
                        <td>骰子2</td>
                        <td>骰子3</td>
                        <td>骰子4</td>
                        <td>骰子5</td>
                        <td>骰子6</td>
                    </tr>
                    <tr>
                        <td>{$info['cards_0'] + 1}点</td>
                        <td>{$info['cards_1'] + 1}点</td>
                        <td>{$info['cards_2'] + 1}点</td>
                        <td>{$info['cards_3'] + 1}点</td>
                        <td>{$info['cards_4'] + 1}点</td>
                        <td>{$info['cards_5'] + 1}点</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>1点</td>
                        <td>2点</td>
                        <td>3点</td>
                        <td>4点</td>
                        <td>5点</td>
                        <td>6点</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.add_bet_0/100}</td>
                        <td>{$vo.add_bet_1/100}</td>
                        <td>{$vo.add_bet_2/100}</td>
                        <td>{$vo.add_bet_3/100}</td>
                        <td>{$vo.add_bet_4/100}</td>
                        <td>{$vo.add_bet_5/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==2001"} <!-- SLOTS 水果机 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw}开奖结果</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1503"} <!-- 龙虎 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">

    <div class="layui-col-md12" style="padding-bottom: 20px;">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info.value_1|getResultBy1021}</h3>
    </div>
    <div class="layui-col-md6" style="border-right: groove;">
        <h4>龙: {$info['cards_0']|getCardName}</h4>
    </div>
    <div class="layui-col-md6">
        <h4>虎: {$info['cards_1']|getCardName}</h4>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>Dragon龙</td>
                        <td>Tiger虎</td>
                        <td>Tie</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                        <td>投注时间</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.add_bet_0/100}</td>
                        <td>{$vo.add_bet_1/100}</td>
                        <td>{$vo.add_bet_2/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                        <td>{:date('Y-m-d H:i:s',$vo.time_stamp)}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{elseif condition="$info['game_type']==1509"} <!-- Andar Bahar -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    {if condition="$info['value_2']==-1"}
    <div class="layui-col-md12" style="padding-bottom: 20px;">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info.value_1|getOneOldAb}</h3>
    </div>
    {else/}
    <div class="layui-col-md12" style="padding-bottom: 20px;">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info.value_2|getTwoOldAb}</h3>
    </div>
    {/if}
    <div class="layui-col-md12" style="padding-bottom: 20px;">
        <h3>{$info['value_2']|getOldAbSession}</h3>
    </div>


</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>黑</td>
                        <td>红</td>
                        <td>梅</td>
                        <td>方</td>
                        <td>左</td>
                        <td>右</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                        <td>投注时间</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.add_bet_0/100}</td>
                        <td>{$vo.add_bet_1/100}</td>
                        <td>{$vo.add_bet_2/100}</td>
                        <td>{$vo.add_bet_3/100}</td>
                        <td>{$vo.add_bet_4/100}</td>
                        <td>{$vo.add_bet_5/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                        <td>{:date('Y-m-d H:i:s',$vo.time_stamp)}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1019"} <!-- 新TP -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12" style="padding-bottom: 20px;">
        <h3>{$info.game_type|getGameType|raw} 开奖结果</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>权重值</td>
                        <td>点控目标值</td>
                        <td>点控等级</td>
                        <td>个控目标值</td>
                        <td>A</td>
                        <td>B</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.weight}</td>
                        <td>{$vo.point_score}</td>
                        <td>{$vo.point_lv|getPointLevel}</td>
                        <td>{$vo.personal_score}</td>
                        <td>{$vo.add_bet_0/100}</td>
                        <td>{$vo.add_bet_1/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1502"} <!-- 转盘游戏 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info['cards_0']|getResultBy1018}</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>黄</td>
                        <td>蓝</td>
                        <td>红</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.add_bet_0/100}</td>
                        <td>{$vo.add_bet_1/100}</td>
                        <td>{$vo.add_bet_2/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{elseif condition="$info['game_type']==1003"} <!-- 印度炸金花新TP -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} [{$info.table_level}] 开奖结果</h3>
    </div>
    <div class="layui-col-md12">
        <?php
        $list = getCardType(true);
        unset($list[0]);
        $list = implode(' < ', $list);
        ?>
        <h4>{$list}</h4>
        <?php unset($list); ?>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>手牌</td>
                        <td>牌型</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td class="inner_td"><span>{$vo.cards_0|getCardName}</span><span>{$vo.cards_1|getCardName}</span><span>{$vo.cards_2|getCardName}</span></td>
                        <td>{$vo.value_1|getCardType} {$vo.value_2==1?'[弃牌]':''}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1511"} <!-- 火箭 Blastx；逃跑倍数：records.add_bet_4，开奖倍数：table.cards_0 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info['cards_0']/100}倍</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>下注</td>
                        <td>逃跑倍数</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.bet_score/100}</td>
                        <td>{$vo.add_bet_4/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1510 || $info['game_type']==1512 || $info['game_type']==1513"} <!-- 地雷 Mine -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} 开奖结果</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>下注</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.bet_score/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{elseif condition="$info['game_type']==1514"} <!-- 飞机 Aviator；下注1：records.add_bet_2，下注2：records.add_bet_3，逃跑倍数1：records.add_bet_4，逃跑倍数2：records.add_bet_5，开奖倍数：table.cards_0 -->
{include file="public:game_header" /}
<div class="layui-fluid" style="text-align: center">
    <div class="layui-col-md12">
        <h3>{$info.game_type|getGameType|raw} 开奖结果: {$info['cards_0']/100}倍</h3>
    </div>
</div>
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body">
                <table class="layui-table">
                    <tbody>
                    <tr>
                        <td>用户ID</td>
                        <td>用户类型</td>
                        <td>下注1</td>
                        <td>下注2</td>
                        <td>逃跑倍数1</td>
                        <td>逃跑倍数2</td>
                        <td>玩家SY</td>
                        <td>税收</td>
                    </tr>
                    {volist name="dataList" id="vo"}
                    <tr>
                        <td><a href="javascript:;" class="users" title="点击查看用户详情">{$vo.uid}</a></td>
                        <td>{if $vo.is_android eq 1}机器人{else}玩家{/if}</td>
                        <td>{$vo.add_bet_2/100}</td>
                        <td>{$vo.add_bet_3/100}</td>
                        <td>{$vo.add_bet_4/100}</td>
                        <td>{$vo.add_bet_5/100}</td>
                        <td>{$vo.sy/100}</td>
                        <td>{$vo.service_score/100}</td>
                    </tr>
                    {/volist}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{else/}
<div class="layui-fluid" style="text-align: center">
    <h2>开发中...</h2>
</div>
{/if}

{/block}

{block name="script"}
<script>



    layui.use(["layer", "form", "table"], function () {
        var $ = layui.$, layer = layui.layer, form = layui.form, echarts = layui.echarts, table = layui.table;

        $(".users").on("click", (e) => {
            const uid = e.target.innerText;

            const full = layer.open({
                type: 2,
                area: ['1000px', '500px'],
                title: `用户ID [${uid}] 详情`,
                fixed: false,
                maxmin: true,
                shadeClose: true,
                content: `{:url('user.user/view')}?uid=${uid}`
            });

            //layer.full(full);
        });

    });
</script>
{/block}
