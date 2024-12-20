{extend name="public:layout" /}

{block name="title"}菜单列表{/block}
{block name="content"}
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">

            <form class="layui-form" lay-filter="forms" action="">
                <div class="layui-card">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="keyword" placeholder="ID/菜单名称">
                        </div>

                        <div class="layui-inline">
                            <select name="is_show" id="">
                                <option value="">菜单状态</option>
                                <option value="1" {eq name="params.is_show" value="1"}selected{/eq}>显示</option>
                                <option value="0" {eq name="params.is_show" value="0"}selected{/eq}>隐藏</option>
                            </select>
                        </div>

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
        <a class="layui-btn layui-btn-sm layui-btn-normal" href="{:url('')}">
            <i class="layui-icon layui-icon-home"></i> 回 到 首 页
        </a>

        <button class="layui-btn layui-btn-sm" onclick="openIframe(this.innerText,'{$addurl}')">
            <i class="layui-icon layui-icon-add-1"></i> 创 建 菜 单
        </button>
    </div>
</script>

<script type="text/html" id="action_bar">
    <a class="layui-btn layui-btn-xs" onclick="openIframe(this.innerText,'{:url('create')}?cid={{d.id}}')">创建子菜单</a>
    <a class="layui-btn layui-btn-xs layui-btn-warm" onclick="openIframe(this.innerText,'{:url('edit')}?id={{d.id}}')">编辑</a>
    <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
</script>

<script type="text/html" id="name">
    <a href="{:url('')}?pid={{d.id}}">{{d.menu_name}}</a>
</script>
<script type="text/html" id="state">
    {{# if(d.is_show==1){ }}
    <span class="layui-btn layui-btn-xs layui-btn-normal">显示</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-xs layui-btn-primary">隐藏</span>
    {{# } }}
</script>

<script>
    layui.use(['table', 'form', 'layer'], function () {
        var $ = layui.$, table = layui.table, form = layui.form, layer = layui.layer;

        //form.render(null, 'forms');

        table.render({
            elem: '#list',
            cols: [[
                {field: 'id', title: 'ID', width: 90, sort: true},
                {field: 'sort', title: '排序 (点击快速修改)', width: 200, sort: true, edit: 'text'},
                {field: 'pid', title: '父级菜单'},
                {field: 'menu_name', title: '菜单名称 (点击查看子菜单)', templet: '#name'},
                {field: 'module', title: '模块名'},
                {field: 'controller', title: '控制器名'},
                {field: 'action', title: '方法名'},
                {field: 'is_show', title: '状态', width: 80, templet: '#state'},
                {fixed: 'right', title: '操作', minWidth: 190, toolbar: '#action_bar'}
            ]],
            title: '列表',
            toolbar: '#toolbar',
            height: 'full-130',
            page: true,
            limit: 50,
            limits: [50,100],
            data: {$list|raw}
        });

        table.on("edit(list)", function (obj) {
            const field = obj.field, value = obj.value, id = obj.data.id;

            $.post("{:url('set_state')}", {id: id, name: field, value: parseInt(value)}, function (ret) {
                ret = JSON.parse(ret);

                layer.msg(ret.msg)

                table.reloadData('list', {scrollPos: 'fixed'});
            });
        });

        table.on("tool(list)", function (obj) {
            const data = obj.data, event = obj.event;

            if (event === 'del') {
                layer.confirm('此操作不可逆，确定删除该数据吗？', {btn: ['确定', '取消']},
                    function () {
                        $.post("{:url('delete')}", {id: data.id}, function (ret) {
                            ret = JSON.parse(ret);

                            if (ret.code === 200) {
                                layer.msg(ret.msg)
                                table.reloadData('list', {scrollPos: 'fixed'});
                            } else {
                                layer.alert(ret.msg, {icon: 5})
                            }
                        });
                });

                return false;
            }
        });

    });
</script>
{/block}