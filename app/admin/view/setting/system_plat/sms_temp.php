{extend name="public/container"}
{block name="content"}
<style>
    .logout{
        float: right;
        margin-right: 100px;
    }
    .logout span{
        margin-right: 20px;
    }
</style>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15"  id="app">
        <div class="layui-col-md12">
            <div class="layui-card">

                <div class="layui-card-header">
                    搜索条件
                </div>
                <div class="layui-card-body">
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">模板类型</label>
                                <div class="layui-input-block">
                                    <select name="temp_type">
                                        <option value="">全部</option>
                                        <option value="1">验证码</option>
                                        <option value="2">通知</option>
                                        <option value="3">推广</option>
                                    </select>
                                </div>
                            </div>
<!--                            <div class="layui-inline">-->
<!--                                <label class="layui-form-label">模板名称</label>-->
<!--                                <div class="layui-input-block">-->
<!--                                    <input type="text" name="title" class="layui-input" placeholder="请输入模板名称">-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="layui-inline">
                                <div class="layui-input-inline">
                                    <button class="layui-btn layui-btn-sm layui-btn-normal" lay-submit="search" lay-filter="search">
                                        <i class="layui-icon layui-icon-search"></i>搜索</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--产品列表-->
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header"><?php if($type == 'temps'){ echo '模板列表';}else{echo '申请记录';}?></div>
                <div class="layui-card-body">
                    <div class="layui-btn-container">
                        <?php if($type != 'apply'){?>
                        <button type="button" class="layui-btn layui-btn-sm" onclick="$eb.createModalFrame(this.innerText,'{:Url('create')}')">申请模板</button>
                        <a href="javascript:void(0);" onclick="$eb.createModalFrame('申请记录','{:Url('setting.systemPlat/sms_temp?type=apply')}',{w:1300,h:760})"><button type="button" class="layui-btn layui-btn-sm" >模板列表</button></a>
                        <?php } ?>
                    </div>
                    <table class="layui-hide" id="List" lay-filter="List"></table>
                    <script type="text/html" id="status">
                        {{# if(d.status == 1){ }}可用
                        {{#  }else if(d.status == 0){ }}待审核
                        {{#  }else if(d.status == 2){ }}禁用
                        {{#  }else{ }}
                        审核未通过<br>
                        {{ d.mark }}
                        {{#  }; }}
                    </script>
                    <script type="text/html" id="type">
                        {{#  if(d.temp_type == 1){ }}验证码
                        {{#  }else if(d.temp_type == 2){ }}通知
                        {{#  }else if(d.temp_type == 3){ }}推广
                        {{#  }; }}
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{__ADMIN_PATH}js/layuiList.js"></script>
{/block}
{block name="script"}
<script>
    var type = "<?php echo $type;?>";
    if(type == 'temps'){
        var url = "{:Url('get_sms_temps')}";
        layList.tableList('List',url,function (){
            return [
                {field: 'id', title: 'ID', sort: true,width:'6%',align:'center'},
                {field: 'temp_id', title: '模板ID',align:'center',width:'6%'},
                {field: 'title', title: '模板名称',align:'center',width:'12%'},
                {field: 'content', title: '模板内容',align:'center'},
                {field: 'type', title: '模板类型',templet:'#type',align:'center',width:'6%'},
                {field: 'status', title: '模板状态',templet:'#status',align:'center',width:'6%'},
            ];
        });
    }else{
        var url = "{:Url('get_sms_appls')}";
        layList.tableList('List',url,function (){
            return [
                {field: 'id', title: 'ID', sort: true,width:'6%',align:'center'},
                {field: 'title', title: '模板名称',align:'center',width:'12%'},
                {field: 'content', title: '模板内容',align:'center'},
                {field: 'type', title: '模板类型',templet:'#type',align:'center',width:'8%'},
                {field: 'status', title: '模板状态',templet:'#status',align:'center',width:'8%'},
                {field: 'add_time', title: '添加时间',align:'center',width:'15%'}
            ];
        });
    }
    //实例化form
    layList.form.render();
    //加载列表

    //查询
    layList.search('search',function(where){
        layList.reload(where);
    });
</script>
{/block}
