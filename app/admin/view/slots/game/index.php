{extend name="public/layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="table-reload">
                <div class="layui-card layui-form" lay-filter="form">
                    <div class="layui-card-body layui-row layui-col-space10">

                        <div class="layui-inline">
                            <input class="layui-input" name="a_name|a_englishname@like"  autocomplete="off" placeholder="Slots游戏名称">
                        </div>




                        <div class="layui-inline">
                            <select name="a_type" id="">
                                <option value="">请选择游戏类型</option>
                                <option value="1">Slots</option>
                                <option value="2">真人</option>
                                <option value="3">转盘</option>
                                <option value="4">区块链</option>
                                <option value="5">彩票</option>
                                <option value="6">街机</option>
                                <option value="7">捕鱼</option>
                                <option value="8">体育</option>
                                <option value="9">牌桌</option>
                            </select>
                        </div>



                        <div class="layui-inline">
                            <select name="terrace/id" id="">
                                <option value="">请选择游戏厂商</option>
                                {volist name="slots_terrace" id="v"}
                                <option value="{$v.id}" >{$v.name}</option>
                                {/volist}

                            </select>
                        </div>


                        <div class="layui-inline">
                            <select name="hot" id="">
                                <option value="">是否热门</option>
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <select name="recommend" id="">
                                <option value="">是否推荐</option>
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                        </div>
                        <div class="layui-inline">
                            <select name="maintain/status" id="">
                                <option value="">游戏维护状态</option>
                                <option value="0">维护中</option>
                                <option value="1">上线</option>
                            </select>
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="submitBtn" data-type="reload">搜索</button>
                            {volist name="slots_terrace" id="v"}
                            <button data-firm="{$v.type}" class="layui-btn" data-type="pgslots">拉取{$v.name}游戏数据</button>
                            {/volist}

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
    {volist name="slots_terrace" id="v"}
    <span class="layui-btn " data-id='{$v.id}'  lay-event="maintain_status">{$v.maintain_status == 1 ? $v.name." 维护" : $v.name." 上线"}</span>
    {/volist}
    <span id="leading" class="layui-btn layui-btn-normal layui-icon layui-icon-upload-drag"   lay-event="daoru"> 导入</span>
</script>
<script type="text/html" id="recommend">
    {{# if(d.recommend == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue" style="color: #c85e7c">是</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red" style="color: #A5C25C">否</span>
    {{# }; }}
</script>
<script type="text/html" id="free">
    {{# if(d.free == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue" style="color: #c85e7c">是</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red" style="color: #A5C25C">否</span>
    {{# }; }}
</script>
<script type="text/html" id="hot">
    {{# if(d.hot == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue" style="color: #c85e7c">是</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red" style="color: #A5C25C">否</span>
    {{# }; }}
</script>
<script type="text/html" id="maintain_status">
    {{# if(d.maintain_status == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue" style="color: #c85e7c">正常</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red" style="color: #A5C25C">维护中</span>
    {{# }; }}
</script>
<script type="text/html" id="free">
    {{# if(d.free == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue" style="color: #c85e7c">是</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-red" style="color: #A5C25C">否</span>
    {{# }; }}
</script>
<script type="text/html" id="type">
    {{# if(d.type == 1){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-blue" style="color: #7F007F">Slots</span>
    {{# }else if(d.type == 2){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-normal" style="color: #FFA00A">真人</span>
    {{# }else if(d.type == 3){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-normal" style="color: #a6e1ec">转盘</span>
    {{# }else if(d.type == 4){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-normal" style="color: #5A5CAD">区块链</span>
    {{# }else if(d.type == 5){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-normal" style="color: #df2806">彩票</span>
    {{# }else if(d.type == 6){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-normal" style="color: #a6e1ec">街机</span>
    {{# }else if(d.type == 7){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-normal" style="color: #cdab53">捕鱼</span>
    {{# }else if(d.type == 8){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-normal" style="color: #aa00bb">体育</span>
    {{# }else if(d.type == 9){ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-normal" style="color: #cc8500">牌桌</span>
    {{# }else{ }}
    <span class="layui-btn layui-btn-primary layui-btn-xs layui-border-orange" style="color: #b084eb">未知</span>
    {{# }; }}
</script>



<script type="text/html" id="status">
    <input  type="checkbox" name="status"  lay-skin="switch"  value="{{d.id}}" lay-filter="is_show"  lay-text="开启|关闭" {{ d.status==1?'checked':'' }}>
</script>

<script type="text/html" id="act">
    <span class="layui-btn layui-btn-xs " onclick="$eb.createModalFrame(this.innerText,`{:url('edit')}?id={{d.id}}`)">编辑</span>
</script>
<script>
    $(function () {

        $(".layui-table-tool-self .layui-inline:last-child").attr("id","sss");
    });

    layui.use(['table','form','layer','laydate','upload'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate,upload = layui.upload;
        laydate.render({
            elem: '#date'
        });
        laydate.render({
            elem: '#date1'
        });
        var limit = 30;
        table.render({
            elem: '#table'
            ,defaultToolbar: [ 'print', 'exports']
            ,url: "{:url('getlist')}"
            ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
            ,method:'post'
            ,toolbar: '#toolbar'
            ,totalRow: true // 开启合计行
            ,height: 'full-130'
            ,page : true
            ,cols: [[
                {field: 'id', title: 'ID', minWidth: 88,align: 'center',fixed:'left'},
                {field: 'englishname', title: 'Slots游戏名称', align: 'center',minWidth: 200,fixed:'left'},
                // {field: 'name', title: 'Slots游戏名称', align: 'center',minWidth: 150},
                {field: 'image', title: '图片', align: 'center',minWidth: 120,templet(d){
                        return  '<img class="image" src='+d.image+' style="width:50px;height:50px">'
                    }},
                {field: 'image2', title: '正方形图片', align: 'center',minWidth: 120,templet(d){
                        return  '<img class="image" src='+d.image2+' style="width:50px;height:50px">'
                    }},
                {field: 'terrace_name',title: '游戏厂商', align: 'center', minWidth: 100 },
                {field: 'status', title: '状态', align: 'center', minWidth: 80,templet:"#status"},
                {field: 'maintain_status', title: '是否维护', align: 'center', minWidth: 80,templet:"#maintain_status"},

                {field: 'weight', title: '权重', align: 'center', minWidth: 80,sort: true},
                {field: 'min_money', title: '最低进入金额', align: 'center', minWidth: 80,templet(d){
                    return  `${(d.min_money/100).toFixed(2)}`
                    }},
                {field: 'love_num', title: '喜欢的人数', align: 'center', minWidth: 120,sort: true},

                {field: 'type', title: '游戏类型', align: 'center', minWidth: 80,templet : '#type'},


                {field: 'hot', title: '热门', align: 'center', minWidth: 80,templet : '#hot'},
                {field: 'recommend', title: '推荐', align: 'center', minWidth: 80,templet : '#recommend'},
                {field: 'free', title: '试玩', align: 'center', minWidth: 80,templet : '#free'},
                {fixed: 'right', title: '操作', align: 'center', width: 130, toolbar: '#act'}
            ]]
            ,limit: limit //每页默认显示的数量
            ,limits: [30,50,100,500] //每页默认显示的数量
        });

        //头部工具事件
        table.on('toolbar(table)', function (obj) {

            let event = obj.event;
            if (event === 'maintain_status') {

                $.post("{:url('maintainstatus')}",{
                    id: $(this).data("id"),
                },function (res) {
                    res = JSON.parse(res)
                    if(res.code == 200){
                        layer.msg('修改成功');
                        location.reload();
                    }else {
                        layer.msg('修改失败');
                    }
                })
            }else if (event ==='leading'){


            }
        });

        upload.render({
            elem: '#leading'
            ,url: "{:url('upload')}"
            ,exts: 'xls|xlsx' //只允许上传excel文件
            ,done: function(res, index, upload){ //上传后的回调
                if(res.code == 200){
                    layer.msg(res.msg);
                    table.reload("table");
                }else {
                    layer.msg(res.msg);
                }
            }
            //,accept: 'file' //允许上传的文件类型
            //,size: 50 //最大允许上传的文件大小
            //,……
        })


        active = {
            pgslots(firm = ''){

                var loading = layer.load(2, {
                    // shade: [0.8, '#fff'],
                    content:'正在获取，请耐心等待......',
                    success: function (layerContentStyle) { // 设置loading样式
                        layerContentStyle.find('.layui-layer-content').css({
                            'padding-left': '45px',
                            'text-align': 'left',
                            'width': '175px',
                            'line-height':'30px'
                        });
                    }
                });

                $.post("{:url('getSlotsList')}",{
                    type:firm,
                },function (res) {
                    layer.close(loading); // 关闭loading
                    res = JSON.parse(res)
                    if(res.code == 200){
                        layer.msg('获取成功');
                        table.reload("table");
                    }else {
                        layer.msg(res.msg);
                    }
                })
            }
        };

        $(".table-reload .layui-btn").on("click", function () {
            const type = $(this).data("type"),firm = $(this).data("firm");
            active[type] && active[type](firm);
        });

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


        {include file="public:submit" /}

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

