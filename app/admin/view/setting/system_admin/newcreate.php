{extend name="public:layui"}
{block name="content"}
<div class="layui-fluid" id="app">
    <div class="layui-col-md12">
        <div class="layui-card">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">管理员账号</label>
                    <div class="layui-input-inline">
                        <input type="text" name="account"  required  lay-verify="required" placeholder="请输入管理员账号" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">管理员账号必填用于登录</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">管理员密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="pwd" placeholder="请输入管理员密码" autocomplete="off" class="layui-input" lay-verify="required">
                    </div>
                    <!--<div class="layui-form-mid layui-word-aux">不填写密码则不修改</div>-->
                    <div class="layui-form-mid layui-word-aux">用于登录的密码</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">确认密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="conf_pwd" placeholder="请确认密码" autocomplete="off" class="layui-input" lay-verify="required">
                    </div>
                    <div class="layui-form-mid layui-word-aux">同上</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">管理员姓名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="real_name"  required  lay-verify="required" placeholder="请输入管理员姓名" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">管理员姓名必填</div>
                </div>

                {if condition ="($admin.type eq 0)"}
                <div class="layui-form-item">
                    <label class="layui-form-label">选择包名</label>
<!--                    <div class="layui-input-inline">-->
<!--                        <select name="package_id" lay-filter="package">-->
<!--                            {if condition ="($admin.package_id eq 0)"}-->
<!--                            <option value="0">全部</option>-->
<!--                            {/if}-->
<!---->
<!--                            {volist name='apppackage' id='val'}-->
<!--                            <option  value="{$val.id}" >{$val.bagname}</option>-->
<!--                            {/volist}-->
<!---->
<!--                        </select>-->
<!--                    </div>-->
                    <div id="packagecheckbox" class="layui-input-block">
                        {if condition ="($admin.package_id eq 0)"}
                        <input lay-filter="switchPackage" type="checkbox" name="package_ids[]" value="0" title="全部">
                        {/if}
                        {volist name='apppackage' id='val'}
                        <input lay-filter="switchPackage" type="checkbox" name="package_ids[]" value="{$val.id}" title="{$val.bagname}">
                        {/volist}
                    </div>
                    <div class="layui-form-mid layui-word-aux">注:如果全部和包同时选，就会查看全部包</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">选择渠道</label>
                    <div id="chanelcheckbox" class="layui-input-block">
                        {volist name='chanel' id='v'}
                        <input type="checkbox" name="channels[]" value="{$v.channel}" title="{$v.cname}">
                        {/volist}
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">身份类型</label>
                    <div class="layui-input-block">
                        <input type="radio" name="type" value="0" title="平台管理员" checked>
                        <input type="radio" name="type" value="1" title="渠道人员" >
                    </div>
                </div>
                {/if}
                <div class="layui-form-item">
                    <label class="layui-form-label">渠道名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="channel_name" placeholder="渠道名称" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">开通渠道人员时填</div>
                </div>
                {if condition ="($admin.type eq 0)"}
                <div class="layui-form-item">
                    <label class="layui-form-label">管理员身份</label>
                    <div class="layui-input-inline">
                        <select name="roles" lay-verify="required">
                            {volist name='roleslist' id='v'}
                            <option value="{$v.value}">{$v.label}</option>
                            {/volist}

                        </select>
                    </div>
                </div>
                {/if}

                <div class="layui-form-item">
                    <label class="layui-form-label">管理员状态</label>
                    <div class="layui-input-block">
                        <input type="radio" name="status" value="1" title="正常" checked>
                        <input type="radio" name="status" value="0" title="关闭" >
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
{/block}
{block name="script"}

<script>

    layui.use(['table','form','layer'], function () {
        var form = layui.form,table = layui.table,layer = layui.layer,laydate = layui.laydate;
        active = {
            reload: function () {
                console.log( form.val('form'),111111);
                form.render('checkbox'); // 重新渲染多选复选框组
                table.reload("table", {
                    page: {
                        curr: 1
                    },
                    where: form.val('form'),
                    scrollPos: 'fixed',
                });
            }
        };


        $(".table-reload .layui-btn").on("click", function () {
            const type = $(this).data("type");
            active[type] && active[type]();
        });

        var selectedValues = []; // 存储选中的值的数组

        form.on('checkbox(switchPackage)', function (data) {
            var value = data.value; // 获取当前复选框的值

            if (data.elem.checked) {
                // 复选框被选中时，将值添加到数组中
                selectedValues.push(value);
            } else {
                // 复选框被取消选中时，从数组中移除值
                var index = selectedValues.indexOf(value);
                if (index !== -1) {
                    selectedValues.splice(index, 1);
                }
            }

            $.post("{:url('getpackage')}",{
                package_ids:selectedValues,
            },function (res) {
                console.log(res)
                res = JSON.parse(res)
                console.log(res)
                if(res.code == 200){
                    let data = res.data
                    console.log(data,5555)
                    var tmp = '';
                    for (var i in data){
                        tmp +=`<input type="checkbox" name="channels[]" value="${data[i].channel}" title="${data[i].cname}" >`;
                    }
                    $("#chanelcheckbox").html(tmp);
                    form.render();
                }else {
                }
            })
            return false;
        });

        form.on('select(package)', function(data){
            console.log(data.value);
            $.post("{:url('getpackage')}",{
                package_id:data.value,
            },function (res) {

                res = JSON.parse(res)
                console.log(res)
                if(res.code == 200){
                    let data = res.data
                    var tmp = '';
                    for (var i in data){
                        tmp +=`<input type="checkbox" name="channels[]" value="${data[i].channel}" title="${data[i].cname}" >`;
                    }
                    $("#chanelcheckbox").html(tmp);
                    form.render();
                }else {
                }
            })
            return false;
        });




        form.on('submit(formDemo)', function(data){
            console.log(form.val())
            $.post("{:url('save')}",{
                data : form.val()
            },function (res) {
                res = JSON.parse(res)
                if(res.code == 200){
                    layer.msg('创建成功')
                    parent.$(".J_iframe:visible")[0].contentWindow.location.reload(); setTimeout(function(){parent.layer.close(parent.layer.getFrameIndex(window.name));},1000)

                }else {
                    layer.msg(res.msg)
                }

            })
            return false;
        });
    });


    new Vue({
        el: '#app',
        data: {
            aaa: 0,
        },
        created(){

        },
        methods: {

        },

    })
</script>
{/block}
