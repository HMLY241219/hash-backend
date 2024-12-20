<div class="layui-inline">
    <input type="checkbox" name="like" lay-skin="primary" value="1" title="模糊查询">
</div>
<div class="layui-inline">
    <button class="layui-btn layui-btn-normal" id="reload" data-type="reload">
        <i class="layui-icon layui-icon-search"></i> 搜 索
    </button>
</div>
<div class="layui-inline">
    <!--<button class="layui-btn layui-btn-primary" type="reset" id="reset">
        <i class="layui-icon layui-icon-refresh"></i> 重 置
    </button>-->
    <button id="reset_new" type="button" class="layui-btn layui-btn-primary" onclick="$(form)[0].reset()">重置</button>
</div>