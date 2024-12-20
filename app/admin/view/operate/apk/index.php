{extend name="public:layout" /}

{block name="title"}APK列表{/block}
{block name="content"}
<div class="layui-fluid">
    <div class="layui-col-md12">

        <div class="layui-card">
            <form class="layui-form" lay-filter="forms" onsubmit="return false;">
                <div class="layui-card">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="file_name" autocomplete="off" placeholder="文件名">
                        </div>
                        <!--<div class="layui-inline">
                            <input class="layui-input" name="pkg_name" autocomplete="off" placeholder="包名">
                        </div>-->

                        {include file="public:layui-search" /}
                    </div>
                </div>
            </form>

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
        <button type="button" class="layui-btn layui-btn-sm" id="uploader">
            <i class="layui-icon layui-icon-upload-drag"></i> APK 上传
        </button>

        <button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="refresh">
            <i class="layui-icon layui-icon-refresh-3"></i> 刷 新
        </button>
    </div>
</script>

<script type="text/html" id="action_bar">
    <a class="layui-btn layui-btn-xs layui-btn-normal" href="{{d.file_url}}" target="_blank">下载</a>
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>

<script>
    layui.use(['table', 'form', 'layer', 'upload'], function () {
        var $ = layui.$, table = layui.table, form = layui.form, layer = layui.layer, upload = layui.upload, laydate = layui.laydate;

        //laydate.render({elem: '#date', range: '~', max: 0, calendar: true});
        //form.render(null, 'form');

        $(function () {
            upload.render({
                elem: '#uploader',
                url: `{:url('uploads')}`,
                accept: 'file',
                exts: 'apk',
                before: function () {
                    layer.msg('APK文件上传中', {time: 120 * 1000, icon: 16});
                },
                done: function (res) {
                    if (res.code === 200) {
                        layer.msg(res.msg, {time: 2000, icon: 1});
                        table.reloadData('list');
                    } else {
                        layer.alert(res.msg)
                    }
                    layer.closeAll('loading');
                }
            });
        });

        table.render({
            elem: '#list',
            url: `{:url('get_list')}`,
            cols: [[
                {field: 'id', title: 'ID', width: 80, sort: true},
                {field: 'file_name', title: '文件名'},
                {field: 'file_url', title: '文件URL'},
                {field: 'pkg_name', title: '包名', minWidth: 160},
                {field: 'app_version', title: '版本号', width: 80},
                {
                    field: 'is_forced_update', title: '是否强制更新', width: 200,
                    templet: function (d) {
                        const list = ['否', '是'];
                        return list[d.is_forced_update];
                    }
                },
                /*{
                    field: 'min_sdk_level', title: 'Min Sdk Platform / Level', width: 185, templet: function (d) {
                        return d.min_sdk_platform + ' / ' + d.min_sdk_level
                    }
                },*/
                //{field: 'min_sdk_platform', title: 'Min Sdk Platform'},
                /*{
                    field: 'target_sdk_level', title: 'Target Sdk Platform / Level', width: 200, templet: function (d) {
                        return d.target_sdk_platform + ' / ' + d.target_sdk_level
                    }
                },*/
                /*{
                    field: 'pkg_type', title: '包类型', width: 94,
                    templet: function (d) {
                        const list = ['广告包', '分享包'];
                        return list[d.pkg_type];
                    }
                },*/
                //{field: 'target_sdk_platform', title: 'Target Sdk Platform'},
                {field: 'operator', title: '上传者', width: 94},
                {field: 'create_time', title: '上传时间', width: 160, sort: true},
                {fixed: 'right', title: '操作', width: 220, toolbar: '#action_bar'}
            ]],
            title: 'APK列表',
            toolbar: '#toolbar',
            height: 'full-130',
            page: true,
            limit: 100,
            limits: [100, 200, 500]
        });

        {include file="public:layui-reload" /}

    });
</script>
{/block}