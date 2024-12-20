{extend name="public/container"}
{block name="head_top"}
<!-- 全局js -->
<script src="{__PLUG_PATH}echarts/echarts.common.min.js"></script>
<script src="{__PLUG_PATH}echarts/theme/macarons.js"></script>
<script src="{__PLUG_PATH}echarts/theme/westeros.js"></script>
<script src="{__FRAME_PATH}js/jquery.min.js"></script>
<script src="{__PLUG_PATH}layui/layui.js"></script>
{/block}
{block name="content"}
<div class="layui-card layui-form" lay-filter="form">
    <div class="layui-form-item">
        <label class="layui-form-label">所选包名</label>
        <div class="layui-input-block col-8">
            <select name="enterprise_type_id" id="package" lay-filter="enterprise_type">
                {if condition="$status"}
                <option value="">全部</option>
                {/if}
                {volist name='packname' id='vo'}

                <option value="{$vo.id}"  {if condition ="($vo.id eq $package_id)"}selected {/if}>{$vo.bagname .'  ----  '.$vo.appname.'  ----  '.$vo.remark1}</option>
                {/volist}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所选渠道</label>
        <div class="layui-input-block col-8">
            <select name="enterprise_template_id" lay-filter="enterprise_template" id="enterprise_template">
                <option value="">全部</option>
                {volist name='chanel' id='val'}
                <option value="{$val.channel}"  {if condition ="($val.channel eq $chanels)"}selected {/if}>{$val.cname}</option>
                {/volist}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">下级渠道</label>
        <div class="layui-input-block col-8">
            <select name="er_enterprise_template_id" lay-filter="er_enterprise_template" id="er_enterprise_template">
                <option value="">全部</option>
                {volist name='er_chanel' id='valer'}
                <option value="{$valer.channel}"  {if condition ="($valer.channel eq $er_chanels)"}selected {/if}>{$valer.cname}</option>
                {/volist}
            </select>
        </div>
    </div>
    {neq name="package_id" value="1"}
    <div class="layui-form-item">
        <label class="layui-form-label">分享数据</label>
        <div class="layui-input-block col-8">
            <select name="enterprise_sharstatus" lay-filter="enterprise_sharstatus" id="enterprise_sharstatus">
                <option value="1"   {if condition ="($sharstatus eq 1)"}selected {/if}>是</option>
                <option value="2"  {if condition ="($sharstatus eq 2)"}selected {/if}>否</option>

            </select>
        </div>
    </div>
    {/neq}

</div>

<div class="time_text">
    <span id="countdown"></span>
</div>

{if condition ="($admin_type eq 1)"}
<div class="url_text">
    <span id="url_text"><a target="_blank" href="https://share.3377win.com?af_status=share-link&clickLabel=MA==&agent={$admininfo.account}">点击获取落地页</a></span>
</div>
{if condition ="($admininfo.id eq 40)"}
<div class="url_text">
    <span id="url_text"><a target="_blank" href="https://share.3377win.com?af_status=share-link&clickLabel=MA==&agent={$admininfo.account}">点击获取H5落地页</a></span>
</div>
{/if}
<div class="url_text">
    <span id="url_text2">可上分余额：{$admininfo.put_money/100}</span>
</div>
{/if}

{if condition ="($admininfo.roles eq 8)"}
    <div class="url_text">
        <span id="url_text2">可上分余额：{$admininfo.put_money/100}</span>
    </div>
{/if}
<!--骚气的动图-->
<!--<video src="https://img-baofun.zhhainiao.com/market/semvideo/214c0566b204488989bc2f1e3ea0a470_preview.mp4" data-index="0" muted="muted" loop="loop" autoplay="autoplay" x5-video-player-type="h5" class="slide-video" data-v-5b1197d5=""></video>-->

<!--    <img style="width: 100%"  src="https://img-baofun.zhhainiao.com/pcwallpaper_ugc/live/9762d9c1d10b580c2429cfb8bcc6bdac.mp4.jpg">-->
<!--https://img-baofun.zhhainiao.com/market/semvideo/214c0566b204488989bc2f1e3ea0a470_preview.jpg-->
<!--清纯mp4-->
<!--<video src="https://img-baofun.zhhainiao.com/market/12/63df12d2b8c1641ca6a7ce22fad638de_preview.mp4" data-index="0" muted="muted" loop="loop" autoplay="autoplay" x5-video-player-type="h5" class="slide-video" data-v-5b1197d5=""></video>-->
<!--https://img-baofun.zhhainiao.com/market/12/63df12d2b8c1641ca6a7ce22fad638de_preview.mp4-->

<div class="layui-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">今日数据</li>
        <li>汇总数据</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!--------------------------今日数据---------------------------------->
            <div class="row">
                <!-------当前在线人数（实时）------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>自研在线</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('user.onlineuser/index')}" data-index="1">
                            <div class="ibox-content">
                                <h1 class="no-margins" id="on_line">{$div_data.on_line ?? 0}</h1>
                                <small>人</small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------最高同时游戏人数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>最高在线</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="4">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.max_game_count ?? 0}</h1>
                                <small>人</small>
                            </div>
                        </a>
                    </div>
                </div>
                {if condition ="($admin_type eq 0)"}
                {/if}
                <!-------今日活跃玩家（实时）------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>登录用户</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5"> <!--/admin/count.login_count/index.html-->
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.login_count ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日注册玩家（实时）------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>新注册用户（zj）</h5>
                        </div>
                        <a class="J_menuItem" href="" data-index="5"><!--{:url('user.User/index')}-->
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.true_regist_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日注册真金玩家------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>今日注册真金玩家（实时）</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.true_regist_count ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日注册金币玩家------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>今日注册金币玩家（实时）</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('user.GoldUserList/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.gold_regist_count ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日注册设备------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">设备数</span>
                            <h5>今日注册设备数（实时）</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('user.GoldUserList/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.device_num ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日充值订单数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">订单数</span>
                            <h5>充值订单数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('coin.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.recharge_count ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日充值成功订单数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">订单数</span>
                            <h5>成功订单数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('coin.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.recharge_suc_count ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日充值订单成功率------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>支付成功率</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('coin.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.recharge_count>0 ? round(($div_data.day_data.recharge_suc_count/$div_data.day_data.recharge_count)*100,2) : 0}%</h1>
                                <small><a href="javascript:;">成功率</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日充值人数（去重）------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>充值人数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('coin.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.recharge_suc_num ?? 0}/{$div_data.day_data.new_recharge_suc_num ?? 0}/{$div_data.day_data.old_recharge_suc_num ?? 0}</h1>
                                <small><a href="javascript:;">总/新/老</a></small>
                            </div>
                        </a>
                    </div>
                </div>

                <!-------今日充值成功人数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>今日充值成功人数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('order.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.recharge_suc_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日新用户充值人数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>今日新用户充值人数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('order.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.new_recharge_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日老用户充值人数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>今日老用户充值人数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('order.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.old_recharge_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日新用户充值订单数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">订单数</span>
                            <h5>今日新用户充值订单数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('order.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.new_recharge_count ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日老用户充值订单数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">订单数</span>
                            <h5>今日老用户充值订单数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('order.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.old_recharge_count ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日新用户充值成功订单数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">订单数</span>
                            <h5>今日新用户充值成功订单数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('order.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.new_recharge_suc_count ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日老用户充值成功订单数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">订单数</span>
                            <h5>今日老用户充值成功订单数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('order.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.old_recharge_suc_count ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日新用户充值订单成功率------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>今日新用户充值订单成功率</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('order.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.new_recharge_count ? round(($div_data.day_data.new_recharge_suc_count/$div_data.day_data.new_recharge_count)*100,2) : 0}%</h1>
                                <small><a href="javascript:;">成功率</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日老用户充值订单成功率------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>今日老用户充值订单成功率</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('order.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.old_recharge_count ? round(($div_data.day_data.old_recharge_suc_count/$div_data.day_data.old_recharge_count)*100,2) : 0}%</h1>
                                <small><a href="javascript:;">成功率</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日充值金额------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>充值金额</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('coin.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.recharge_money ? $div_data.day_data.recharge_money : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日新用户充值金额------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>新用户充值</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('coin.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.new_recharge_money ? $div_data.day_data.new_recharge_money : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日老用户充值金额------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>老用户充值</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('coin.Order/index')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.old_recharge_money ? $div_data.day_data.old_recharge_money : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>

                <!-------今日投注人数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>今日投注人数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('statistics.DailyBonus/userList')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$cash_bonus_data.bet_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>

                <!-------今日未投注人数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>未投注人数</h5>
                        </div>
                        <a class="J_menuItem" href="{:url('statistics.DailyBonus/userList2')}" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$cash_bonus_data.not_bet_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>

                <!-------今日退款金额------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>退款金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.withdraw_money ? $div_data.day_data.withdraw_money : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日新用户退款金额------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>新用户退款</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.new_withdraw_money ? $div_data.day_data.new_withdraw_money : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日老用户退款金额------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>老用户退款</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.trues ? $div_data.day_data.old_withdraw_money : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>

                <!-------今日退款率------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>退款率</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.all_withdraw_rate ?? 0} /{$div_data.day_data.new_withdraw_rate ?? 0} /{$div_data.day_data.old_withdraw_rate ?? 0}%</h1>
                                <small><a href="javascript:;">总/新/老</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日退款人数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>退款人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.withdraw_suc_num ?? 0}/{$div_data.day_data.new_withdraw_num ?? 0}/{$div_data.day_data.old_withdraw_suc_num ?? 0}</h1>
                                <small><a href="javascript:;">总/新/老</a></small>
                            </div>
                        </a>
                    </div>
                </div>

                <!-------今日充值渠道成本------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>渠道成本</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.fee_money ? $div_data.day_data.fee_money : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日游戏投注金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>游戏投注金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.trues ? ($div_data.day_data.self_game_betting_money+$div_data.day_data.three_game_betting_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日游戏FJ金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>游戏FJ金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.trues ? ($div_data.day_data.self_game_award_money+$div_data.day_data.three_game_award_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日游戏RTP------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>RTP</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.trues && ($div_data.day_data.self_game_betting_money+$div_data.day_data.three_game_betting_money) ? round((($div_data.day_data.self_game_award_money+$div_data.day_data.three_game_award_money)/($div_data.day_data.self_game_betting_money+$div_data.day_data.three_game_betting_money))*100,2) : 0}%</h1>
                                <small><a href="javascript:;">率</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->

                <!-------今日自研游戏投注人数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>今日游戏投注人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.self_game_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日自研游戏投注金额------------->
                {if condition ="($admin_type eq 0)"}
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日游戏投注金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.self_game_betting_money ? ($div_data.day_data.self_game_betting_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->

                <!-------今日自研游戏FJ金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日游戏FJ金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.self_game_award_money ? ($div_data.day_data.self_game_award_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日自研游戏RTP------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>今日游戏RTP</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.self_game_betting_money ? round(($div_data.day_data.self_game_award_money/$div_data.day_data.self_game_betting_money)*100,2) : 0}%</h1>
                                <small><a href="javascript:;">百分百</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                {/if}
                <!-------今日自研游戏利润------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日游戏利润</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:game_log();" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.self_game_profit ? ($div_data.day_data.self_game_profit)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日三方游戏投注人数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>今日三方游戏投注人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.three_game_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日三方游戏投注金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日三方游戏投注金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.three_game_betting_money ? ($div_data.day_data.three_game_betting_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日三方游戏FJ金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日三方游戏FJ金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.three_game_award_money ? ($div_data.day_data.three_game_award_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日三方游戏RTP------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>今日三方游戏RTP</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.three_game_betting_money ? round(($div_data.day_data.three_game_award_money/$div_data.day_data.three_game_betting_money)*100,2) : 0}%</h1>
                                <small><a href="javascript:;">RTP</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日三方游戏利润------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日三方游戏利润</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.three_game_profit ? ($div_data.day_data.three_game_profit)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日退款订单数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">订单数</span>
                            <h5>今日退款订单数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.withdraw_count ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日退款系统自动通过订单数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">订单数</span>
                            <h5>退款自动通过</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.withdraw_auto_count ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日退款待审核订单数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">订单数</span>
                            <h5>退款待审核订单数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.withdraw_review_count ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!---游戏税收--->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>游戏税收</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.total_service_score ? ($div_data.day_data.total_service_score)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日退款成功订单数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">订单数</span>
                            <h5>退款成功</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.withdraw_suc_count ?? 0}</h1>
                                <small><a href="javascript:;">个</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日退款订单成功率------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>退款成功率</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.withdraw_suc_rate}%</h1>
                                <small><a href="javascript:;">成功率</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------今日充提差------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日充提差</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.recharge_withdraw_dif ? ($div_data.day_data.recharge_withdraw_dif)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日平台利润率------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>今日平台利润率</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.recharge_money>0 ? round((($div_data.day_data.recharge_money - $div_data.day_data.withdraw_money)/$div_data.day_data.recharge_money)*100,2) : 0}%</h1>
                                <small><a href="javascript:;">利润率</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日平台利润------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日平台利润</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.profit ? ($div_data.day_data.profit)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日平台注册赠送金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>注册赠送金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.regist_award_money ? ($div_data.day_data.regist_award_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日游戏投注人数------------->
                <!--{if condition ="($admin_type eq 0)"}
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>游戏投注人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.self_game_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                {/if}-->
                <!-------今日平台利润金额------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>平台毛利</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.profit ? $div_data.day_data.profit : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                    </div>
                </div>
                <!-------今日轮盘参与人数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>轮盘参与人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.rotary_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日活动赠送金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>活动赠送金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_active_zs ? ($div_data.day_active_zs)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日TPC退款到余额的数量------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日TPC退款到余额的数量</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.tpc_withdraw_money ? ($div_data.day_data.tpc_withdraw_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日返水人数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>今日返水人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.back_water_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日返水金额退款到余额的数量------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日返水金额退款到余额的数量</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.back_water_withdraw_balance ? ($div_data.day_data.back_water_withdraw_balance)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日推广人数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>推广人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.popularize_num ?? 0}</h1>
                                <small><a href="javascript:;">人</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日下家VIP等级提升给上家解锁的金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日下家VIP等级提升给上家解锁的金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.next_to_up_unlock_money ? ($div_data.day_data.next_to_up_unlock_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日下家返利给上家的金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日下家返利给上家的金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.next_to_up_back_money ? ($div_data.day_data.next_to_up_back_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日轮盘旋转次数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">次数</span>
                            <h5>今日轮盘旋转次数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.rotary_count ?? 0}</h1>
                                <small><a href="javascript:;">次</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日轮盘钻石奖励金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日轮盘钻石奖励金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.rotary_diamond_money ? ($div_data.day_data.rotary_diamond_money)/100 : 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------今日轮盘现金奖励金额------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>今日轮盘现金奖励金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$div_data.day_data.rotary_cash_money ?? 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>-->
            </div>

            <div id="app">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>充值统计</h5>
                                <!--<div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-xs btn-white" :class="{'active': active == 'thirtyday'}" v-on:click="getlist('thirtyday')">30天</button>
                                        <button type="button" class="btn btn-xs btn-white" :class="{'active': active == 'week'}" v-on:click="getlist('week')">周</button>
                                        <button type="button" class="btn btn-xs btn-white" :class="{'active': active == 'month'}" v-on:click="getlist('month')">月</button>
                                        <button type="button" class="btn btn-xs btn-white" :class="{'active': active == 'year'}" v-on:click="getlist('year')">年</button>
                                    </div>
                                </div>-->
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="flot-chart-content echarts" ref="order_echart" id="flot-dashboard-chart1"></div>
                                    </div>
                                    <div class="col-lg-3">
                                        <ul class="stat-list">
                                            <li>
                                                <h2 class="no-margins ">{{pre_cycleprice}}</h2>
                                                <small>{{precyclename}}充值金额</small>
                                            </li>
                                            <li>
                                                <h2 class="no-margins ">{{cycleprice}}</h2>
                                                <small>{{cyclename}}充值金额</small>
                                                <div class="stat-percent text-navy" v-if='cycleprice_is_plus ===1'>
                                                    {{cycleprice_percent}}%
                                                    <i  class="fa fa-level-up"></i>
                                                </div>
                                                <div class="stat-percent text-danger" v-else-if='cycleprice_is_plus === -1'>
                                                    {{cycleprice_percent}}%
                                                    <i class="fa fa-level-down"></i>
                                                </div>
                                                <div class="stat-percent" v-else>
                                                    {{cycleprice_percent}}%
                                                </div>
                                                <div class="progress progress-mini">
                                                    <div :style="{width:cycleprice_percent+'%'}" class="progress-bar box"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <h2 class="no-margins ">{{pre_cyclecount}}</h2>
                                                <small>{{precyclename}}充值笔数</small>
                                            </li>
                                            <li>
                                                <h2 class="no-margins">{{cyclecount}}</h2>
                                                <small>{{cyclename}}充值笔数</small>
                                                <div class="stat-percent text-navy" v-if='cyclecount_is_plus ===1'>
                                                    {{cyclecount_percent}}%
                                                    <i class="fa fa-level-up"></i>
                                                </div>
                                                <div class="stat-percent text-danger" v-else-if='cyclecount_is_plus === -1'>
                                                    {{cyclecount_percent}}%
                                                    <i  class="fa fa-level-down"></i>
                                                </div>
                                                <div class="stat-percent " v-else>
                                                    {{cyclecount_percent}}%
                                                </div>
                                                <div class="progress progress-mini">
                                                    <div :style="{width:cyclecount_percent+'%'}" class="progress-bar box"></div>
                                                </div>
                                            </li>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----------------活跃与注册用户统计------------------------->
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="flot-chart">
                                            <div class="flot-chart-content" ref="user_echart" id="flot-dashboard-chart2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----------------设备数统计------------------------->
                <!--<div class="row" >-->
                <!--    <div class="col-lg-12">-->
                <!--        <div class="ibox float-e-margins">-->
                <!--            <div class="ibox-title">-->
                <!--                <h5>活跃与注册设备数统计</h5>-->
                <!--            </div>-->
                <!--            <div class="ibox-content">-->
                <!--                <div class="row">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="flot-chart">-->
                <!--                            <div class="flot-chart-content" ref="user_regisechart" id="flot-dashboard-chart3"></div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
            <!--------------------------今日数据end---------------------------------->
        </div>

        <div class="layui-tab-item">
            <!--------------------------汇总数据---------------------------------->
            <div class="row">
                <!-------总注册人数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>总注册人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="1">
                            <div class="ibox-content">
                                <h1 class="no-margins" id="on_line">{$all_data.regist_count ?? 0}</h1>
                                <small>人</small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------总真金注册人数------------->
                <!--<div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>总真金注册人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="1">
                            <div class="ibox-content">
                                <h1 class="no-margins" id="on_line">{$all_data.regist_true_count ?? 0}</h1>
                                <small>人</small>
                            </div>
                        </a>
                    </div>
                </div>-->
                <!-------总充值人数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>总充值人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="1">
                            <div class="ibox-content">
                                <h1 class="no-margins" id="on_line">{$all_data.recharge_num ?? 0}</h1>
                                <small>人</small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------总充值金额------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>总充值金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$all_data.recharge_price ?? 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------总退款人数------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">人数</span>
                            <h5>总退款人数</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="1">
                            <div class="ibox-content">
                                <h1 class="no-margins" id="on_line">{$all_data.withdraw_num ?? 0}</h1>
                                <small>人</small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------总退款金额------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>总退款金额</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$all_data.withdraw_price ?? 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------总退款率------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>总退款率</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$all_data.all_withdraw_rate ?? 0}%</h1>
                                <small><a href="javascript:;">退款率</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------总充提差------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>总充提差</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$all_data.all_recharge_withdraw_dif ?? 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------总平台利润率------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">率</span>
                            <h5>总平台利润率</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$all_data.all_profit_rate ?? 0}%</h1>
                                <small><a href="javascript:;">利润率</a></small>
                            </div>
                        </a>
                    </div>
                </div>
                <!-------总平台利润------------->
                <div class="col-sm-3 ui-sortable">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">金额</span>
                            <h5>总平台利润</h5>
                        </div>
                        <a class="J_menuItem" href="javascript:;" data-index="5">
                            <div class="ibox-content">
                                <h1 class="no-margins">{$all_data.all_profit ?? 0}</h1>
                                <small><a href="javascript:;">卢比</a></small>
                            </div>
                        </a>
                    </div>
                </div>

                <!--------------------------汇总数据end---------------------------------->
            </div>
        </div>
    </div>
</div>

{/block}
{block name="script"}
<style scoped>
    .box{width:0px;}
</style>
<script type="text/javascript">
    var js_variable = '<?php echo $admininfo['account']; ?>';
    console.log(js_variable);
    // 检查 sessionStorage 中是否存在标记
    if (!sessionStorage.getItem(js_variable)) {
        // 设置 sessionStorage 标记
        sessionStorage.setItem(js_variable, 'true');
        location.reload(true);
    };

    //启动模块
    layui.use(['form', 'layer','laydate'],function() {

        var form = layui.form,
            laydate = layui.laydate,
            layer = layui.layer;
        form.on('select(enterprise_type)',function (data) {
            //监听到了下拉框选择的选项，传递过来
            // console.log(data);//在控制台输出信息
            var package_id = data.value;

            //再利用ajax将数据传到后端，来获取到对应下拉框选项而出现的值
            $.ajax({
                type:"post",
                url:"{:url('getchanel')}",
                data:{
                    'package_id' : package_id
                },
                success:function (d) {
                    if(d.code == 200){

                        var data = d.data.chanel;
                        //var div_data = d.data.div_data;
                        var tmp='<option value="">全部</option>';
                        for (var i in data){
                            tmp +='<option value="'+data[i].channel+'">'+data[i].cname+'</option>';
                        }
                        $("#enterprise_template").html(tmp);

                        //统计数据变更
                        location.reload();
                        //$("#on_line").html(div_data.on_line);
                        form.render();
                    }else {
                        layer.alert('失败');
                    }


                },error:function () {
                    layer.alert('请求失败');
                }
            });
        })


        form.on('select(enterprise_sharstatus)',function (data) {
            //监听到了下拉框选择的选项，传递过来
            // console.log(data);//在控制台输出信息
            var sharstatus = data.value;
            var package_id = $('#package').val();
            var chanel = $('#enterprise_template').val();
            //再利用ajax将数据传到后端，来获取到对应下拉框选项而出现的值
            $.ajax({
                type:"post",
                url:"{:url('setchanel')}",
                data:{
                    'sharstatus' : sharstatus,
                    'chanel' : chanel,
                    'package_id' : package_id,
                },
                success:function (d) {
                    if(d.code == 200){

                        //统计数据变更
                        location.reload();
                        form.render();
                    }else {
                        layer.alert('选择失败');
                    }


                },error:function () {
                    layer.alert('请求失败');
                }
            });
        })

        form.on('select(enterprise_template)',function (data) {
            //监听到了下拉框选择的选项，传递过来
            // console.log(data);//在控制台输出信息
            var chanel = data.value;
            var package_id = $('#package').val();

            //再利用ajax将数据传到后端，来获取到对应下拉框选项而出现的值
            $.ajax({
                type:"post",
                url:"{:url('setchanel')}",
                data:{
                    'chanel' : chanel,
                    'package_id' : package_id,
                },
                success:function (d) {
                    if(d.code == 200){

                        //下级渠道
                        var data = d.data.er_chanel;
                        //var div_data = d.data.div_data;
                        var tmp='<option value="">全部</option>';
                        for (var i in data){
                            tmp +='<option value="'+data[i].channel+'">'+data[i].cname+'</option>';
                        }
                        $("#enterprise_template").html(tmp);

                        //统计数据变更
                        location.reload();
                        form.render();
                    }else {
                        layer.alert('选择失败');
                    }


                },error:function () {
                    layer.alert('请求失败');
                }
            });
        })

        //下下级
        form.on('select(er_enterprise_template)',function (data) {
            //监听到了下拉框选择的选项，传递过来
            // console.log(data);//在控制台输出信息
            var er_chanel = data.value;
            var package_id = $('#package').val();
            var chanel = $('#chanel').val();

            //再利用ajax将数据传到后端，来获取到对应下拉框选项而出现的值
            $.ajax({
                type:"post",
                url:"{:url('setErchanel')}",
                data:{
                    'chanel' : chanel,
                    'er_chanel' : er_chanel,
                    'package_id' : package_id,
                },
                success:function (d) {
                    if(d.code == 200){

                        //统计数据变更
                        location.reload();
                        form.render();
                    }else {
                        layer.alert('选择失败');
                    }


                },error:function () {
                    layer.alert('请求失败');
                }
            });
        })
    });

    require(['vue','axios','layer'],function(Vue,axios,layer){
        new Vue({
            el:"#app",
            data:{
                option:{},
                myChart:{},
                active:'thirtyday',
                cyclename:'最近30天',
                precyclename:'上个30天',
                cyclecount:0,
                cycleprice:0,
                cyclecount_percent:0,
                cycleprice_percent:0,
                cyclecount_is_plus:0,
                cycleprice_is_plus:0,
                pre_cyclecount:0,
                pre_cycleprice:0
            },
            methods:{
                info:function () {
                    var that=this;
                    axios.get("{:Url('useractivechart')}").then((res)=>{
                        that.myChart.user_echart.setOption(that.userchartsetoption(res.data.data));
                    });
                    // axios.get("{:Url('userregischart')}").then((res)=>{
                    //     that.myChart.user_regisechart.setOption(that.userregischartsetoption(res.data.data));
                    // });
                },
                getlist:function (e) {
                    var that=this;
                    var cycle = e!=null ? e :'thirtyday';
                    axios.get("{:url('orderchart')}?cycle="+cycle).then((res)=>{
                        that.myChart.order_echart.clear();
                        that.myChart.order_echart.setOption(that.orderchartsetoption(res.data.data));
                        that.active = cycle;
                        switch (cycle){
                            case 'thirtyday':
                                that.cyclename = '最近30天';
                                that.precyclename = '上个30天';
                                break;
                            case 'week':
                                that.precyclename = '上周';
                                that.cyclename = '本周';
                                break;
                            case 'month':
                                that.precyclename = '上月';
                                that.cyclename = '本月';
                                break;
                            case 'year':
                                that.cyclename = '今年';
                                that.precyclename = '去年';
                                break;
                            default:
                                break;
                        }
                        var data=res.data.data;
                        if(data!=undefined) {
                            that.cyclecount = data.cycle.count.data;
                            that.cyclecount_percent = data.cycle.count.percent;
                            that.cyclecount_is_plus = data.cycle.count.is_plus;
                            that.cycleprice = data.cycle.price.data;
                            that.cycleprice_percent = data.cycle.price.percent;
                            that.cycleprice_is_plus = data.cycle.price.is_plus;
                            that.pre_cyclecount = data.pre_cycle.count.data;
                            that.pre_cycleprice = data.pre_cycle.price.data;
                        }
                    });
                },
                orderchartsetoption:function(data){
                    //console.log(data)
                    this.option = {
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                type: 'cross',
                                crossStyle: {
                                    color: '#999'
                                }
                            }
                        },
                        toolbox: {
                            feature: {
                                dataView: {show: true, readOnly: false},
                                magicType: {show: true, type: ['line', 'bar']},
                                restore: {show: false},
                                saveAsImage: {show: true}
                            }
                        },
                        legend: {
                            data:data.legend
                        },
                        grid: {
                            x: 70,
                            x2: 50,
                            y: 60,
                            y2: 50
                        },
                        xAxis: [
                            {
                                type: 'category',
                                data: data.xAxis,
                                axisPointer: {
                                    type: 'shadow'
                                },
                                axisLabel:{
                                    interval: 0,
                                    rotate:40
                                }


                            }
                        ],
                        yAxis:[{type : 'value'}],
//                            yAxis: [
//                                {
//                                    type: 'value',
//                                    name: '',
//                                    min: 0,
//                                    max: data.yAxis.maxprice,
////                                    interval: 0,
//                                    axisLabel: {
//                                        formatter: '{value} 卢比'
//                                    }
//                                },
//                                {
//                                    type: 'value',
//                                    name: '',
//                                    min: 0,
//                                    max: data.yAxis.maxnum,
//                                    interval: 5,
//                                    axisLabel: {
//                                        formatter: '{value} 个'
//                                    }
//                                }
//                            ],
                        series: data.series
                    };
                    return  this.option;
                },
                userchartsetoption:function(data){
                    this.option = {
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                type: 'cross',
                                crossStyle: {
                                    color: '#999'
                                }
                            }
                        },
                        toolbox: {
                            feature: {
                                dataView: {show: true, readOnly: false},
                                magicType: {show: true, type: ['line', 'bar']},
                                restore: {show: false},
                                saveAsImage: {show: false}
                            }
                        },
                        legend: {
                            data:data.legend
                        },
                        grid: {
                            x: 70,
                            x2: 50,
                            y: 60,
                            y2: 50
                        },
                        xAxis: [
                            {
                                type: 'category',
                                data: data.xAxis,
                                axisPointer: {
                                    type: 'shadow'
                                }
                            }
                        ],
                        yAxis:[{type : 'value'}],
//                        series: data.series
                        series: data.series

                    };
                    return  this.option;
                },
                userregischartsetoption:function(data){
                    this.option = {
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                type: 'cross',
                                crossStyle: {
                                    color: '#999'
                                }
                            }
                        },
                        toolbox: {
                            feature: {
                                dataView: {show: true, readOnly: false},
                                magicType: {show: true, type: ['line', 'bar']},
                                restore: {show: false},
                                saveAsImage: {show: false}
                            }
                        },
                        legend: {
                            data:data.legend
                        },
                        grid: {
                            x: 70,
                            x2: 50,
                            y: 60,
                            y2: 50
                        },
                        xAxis: [
                            {
                                type: 'category',
                                data: data.xAxis,
                                axisPointer: {
                                    type: 'shadow'
                                }
                            }
                        ],
                        yAxis:[{type : 'value'}],
//                        series: data.series
                        series: data.series

                    };
                    return  this.option;
                },
                setChart:function(name,myChartname){
                    this.myChart[myChartname] = echarts.init(name,'macarons');//初始化echart
                }
            },
            mounted:function () {
                const self = this;
                this.setChart(self.$refs.order_echart,'order_echart');//订单图表
                this.setChart(self.$refs.user_echart,'user_echart');//活跃用户图表
                // this.setChart(self.$refs.user_regisechart,'user_regisechart');//注册用户图表
                this.info();
                this.getlist();

            }
        });
    });

    //今日自研游戏利润点击弹窗
    function game_log() {
        $eb.createModalFrame('游戏统计','{:Url('game.GameStatistics/log')}');
    }

    //时间
    var brazilOffset = -11;
    var now = new Date();
    var brazilTime = new Date(now.getTime() + brazilOffset * 60 * 60 * 1000);
    var Year = brazilTime.getFullYear();
    var Month = (brazilTime.getMonth()+1).toString().length<2 ? '0'+(brazilTime.getMonth()+1) : brazilTime.getMonth()+1;
    var day = brazilTime.getDate().toString().length<2 ? '0'+brazilTime.getDate() : brazilTime.getDate();
    var hours = brazilTime.getHours().toString().length<2 ? '0'+brazilTime.getHours() : brazilTime.getHours();
    var min = brazilTime.getMinutes().toString().length<2 ? '0'+brazilTime.getMinutes() : brazilTime.getMinutes();
    var secon = brazilTime.getSeconds().toString().length<2 ? '0'+brazilTime.getSeconds() : brazilTime.getSeconds();
    $('#countdown').html(
        '时间(Brazil)：'+ Year +'-'+ Month +'-'+ day+' '+hours + ':' +min+':' + secon
    );

    function startCountdown() {
        // 印度时区的时间偏移量为-2.5小时
        var brazilOffset = -2.5;
        // 获取当前时间
        var now = new Date();
        // 将当前时间调整为印度时区的时间
        var brazilTime = new Date(now.getTime() + brazilOffset * 60 * 60 * 1000);
        // 更新倒计时元素的内容
        var Year = brazilTime.getFullYear();
        var Month = (brazilTime.getMonth()+1).toString().length<2 ? '0'+(brazilTime.getMonth()+1) : brazilTime.getMonth()+1;
        var day = brazilTime.getDate().toString().length<2 ? '0'+brazilTime.getDate() : brazilTime.getDate();
        var hours = brazilTime.getHours().toString().length<2 ? '0'+brazilTime.getHours() : brazilTime.getHours();
        var min = brazilTime.getMinutes().toString().length<2 ? '0'+brazilTime.getMinutes() : brazilTime.getMinutes();
        var secon = brazilTime.getSeconds().toString().length<2 ? '0'+brazilTime.getSeconds() : brazilTime.getSeconds();
        $('#countdown').html(
            '时间(India)：'+ Year +'-'+ Month +'-'+ day+' '+hours + ':' +min+':' + secon
        );
    }

    layui.use('layer', function() {
        // 每秒钟执行一次倒计时函数
        setInterval(startCountdown, 1000);
    });
</script>
<style>
    #countdown {
        font-weight: bold;
        color: black;
    }
    .time_text {
        text-align: right;
    }
    .url_text {
        text-align: right;
        margin-top: 20px;
    }
    #url_text {
        font-weight: bold;
        color: black;
    }
</style>
{/block}
