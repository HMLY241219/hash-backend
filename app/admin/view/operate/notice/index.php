{extend name="public:layout" /}

{block name="title"}列表{/block}
{block name="content"}
<div class="layui-fluid">
    <div class="layui-col-md12">

        <div class="layui-card">
            <div class="layui-tab layui-tab-brief" lay-filter="tab">
                <?php
                $href = [
                    //'邮件列表'   => url('game.email/index'),
                    '公告列表'   => url('operate.notice/index'),
                    //'跑马灯列表' => url('game.broadcast/index')
                ];
                $url  = request()->url(true);
                ?>
                <ul class="layui-tab-title">
                    {foreach($href as $k => $vo)}
                    <li>
                        <a href="{$vo}" class="layui-btn {$vo==$url?'':'layui-btn-primary'}">{$k}</a>
                    </li>
                    {/foreach}
                </ul>
            </div>
        </div>

        <div class="layui-card">
            <!--<form class="layui-form" lay-filter="forms" onsubmit="return false;">
                <div class="layui-card">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="uid" autocomplete="off" placeholder="玩家ID">
                        </div>

                        <div class="layui-inline">
                            <input class="layui-input" name="operator" autocomplete="off" placeholder="更新人">
                        </div>

                        {include file="public:layui-search" /}
                    </div>
                </div>
            </form>-->

            <div class="layui-card-body">
                <table class="layui-hide" id="list" lay-filter="list"></table>
            </div>
        </div>

    </div>
</div>
{/block}

{block name="script"}
<script type="text/html" id="toolbar">
    <div class="layui-btn-container">
        <!--<button class="layui-btn layui-btn-sm" onclick="openIframe(this.innerText,`{:url('create')}`)">
            <i class="layui-icon layui-icon-add-1"></i> 创 建
        </button>-->
        <span class="layui-btn " onclick="$eb.createModalFrame(this.innerText,`{:url('add')}`)" >添加</span>

        <!--<button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="refresh">
            <i class="layui-icon layui-icon-refresh-3"></i> 刷 新
        </button>-->
    </div>
</script>

<script type="text/html" id="action_bar">
    <!--<a class="layui-btn layui-btn-xs" lay-event="detail">详情</a>-->
    <!--<a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="copy">复制</a>-->
<!--    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">编辑</a>-->
    <span class="layui-btn layui-btn-xs layui-btn-warm" onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>

<script type="text/html" id="state">
    <input type="checkbox" name="status" lay-skin="switch" value="{{d.id}}" lay-filter="is_show" lay-text="开启|关闭"
           {{ d.status==1?'checked':'' }}>
</script>

<script>
    layui.config({
        base: '{__LAYUI__}/module/'
    }).extend({
        echarts: 'echarts'
    }).use(['table', 'form', 'layer', 'echarts', 'upload'], function () {
        var table = layui.table, form = layui.form, $ = layui.$, upload = layui.upload, laydate = layui.laydate;

        //laydate.render({elem: '#date', range: '~', max: 0, calendar: true});
        //form.render(null, 'form');

        table.render({
            elem: '#list',
            url: `{:url('get_list')}`,
            cols: [[
                {field: 'id', title: 'ID', width: 80, sort: true},
                {field: 'title', title: '公告标题'},
                {field: 'content', title: '公告内容'},
                // {field: 'bonus', title: '金币奖励', width: 105, sort: true},
                // {field: 'dates', title: '显示时间', width: 310, templet: function (d) {return `${d.start} ~ ${d.end}`}},
                {field: 'status', title: '状态', width: 100, templet: '#state'},
                {field: 'operator', title: '更新人', width: 100},
                {field: 'update_time', title: '更新时间', width: 160, sort: true},
                {fixed: 'right', title: '操作', width: 180, toolbar: '#action_bar'}
            ]],
            title: '列表',
            toolbar: '#toolbar',
            height: 'full-160',
            page: true,
            limit: 100,
            limits: [100, 200, 500]
        });

        {include file="public:layui-reload" /}

    });
</script>
{/block}