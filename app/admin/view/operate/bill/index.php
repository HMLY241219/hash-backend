{extend name="public:layout" /}

{block name="title"}列表{/block}
{block name="content"}
<div class="layui-fluid">
    <div class="layui-col-md12">
        <div class="layui-card">

            <form class="layui-form" lay-filter="forms" onsubmit="return false;">
                <div class="layui-card">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="id" autocomplete="off" placeholder="等级">
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
        <!--<button class="layui-btn layui-btn-sm" onclick="openIframe(this.innerText,`{:url('create')}`)">
            <i class="layui-icon layui-icon-add-1"></i> 创 建
        </button>-->

        <button class="layui-btn layui-btn-sm layui-btn-normal" lay-event="refresh">
            <i class="layui-icon layui-icon-refresh-3"></i> 刷 新
        </button>
    </div>
</script>

<script type="text/html" id="action_bar">
    <!--<a class="layui-btn layui-btn-xs" lay-event="detail">详情</a>-->
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">编辑</a>
    <!--<a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>-->
</script>
<script type="text/html" id="type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue">官方账号</span>
    {{# }else if(d.type == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-green">官方社交账号</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red">官方联系方式</span>
    {{# }; }}
</script>

<script type="text/html" id="state">
    <input type="checkbox" name="status" lay-skin="switch" value="{{d.id}}" lay-filter="is_show" lay-text="开启|禁用"
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
                {field: 'id', title: '返佣等级', width: 110},
                {field: 'total_amount', title: '累计投注金额',templet(d){return d.total_amount/100}},
                {field: 'bili', title: '返利比例，万分比'},
                {fixed: 'right', title: '操作', width: 170, toolbar: '#action_bar'}
            ]],
            title: '列表',
            toolbar: '#toolbar',
            height: 'full-130',
            page: true,
            limit: 100,
            limits: [100, 200, 500]
        });

        {include file="public:layui-reload" /}

        form.on("switch(is_show)", function (obj) {
            let data = obj, status = 0;

            if(data.elem.checked){
                status =1;
            }

            $.post("{:url('is_show')}",{
                id:data.value,
                status :status
            },function (res) {
                res = JSON.parse(res)
                if(res.code == 200){
                    layer.msg('修改成功');
                    table.reloadData("table");
                }else {
                    layer.msg('修改失败');
                }
            })

        });

        //点击图片放大
        $(document).on('click', '.image',function(){
            layer.photos({
                photos: {
                    "title": "", //相册标题
                    "id": 123, //相册id
                    "start": 0, //初始显示的图片序号，默认0
                    "data": [   //相册包含的图片，数组格式
                        {
                            "alt": "图片名",
                            "pid": 666, //图片id
                            "src": $(this).attr ("src"), //原图地址
                            "thumb": "" //缩略图地址
                        }
                    ]
                }
                ,anim: 0 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
            })

        });
    });
</script>
{/block}