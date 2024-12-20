

    table.on("toolbar(list)", function (obj) {
        const event = obj.event;

        if (event === 'refresh') {
            table.reload('list');

            return false;
        }
    });

    table.on("tool(list)", function (obj) {
        const data = obj.data, event = obj.event;

        if (event === 'detail') {
            openIframe('详 情', `{:url('details')}?id=${data.id}`);

            return false;
        }
        else if (event === 'edit') {
            openIframe('编 辑', `{:url('update')}?id=${data.id}`);

            return false;
        }
        else if (event === 'copy') {
            openIframe('复 制', `{:url('copy')}?id=${data.id}`);

            return false;
        }
        else if (event === 'del') {
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
                },
                function () {
                    //table.reloadData('list');
                    layer.msg('该操作已取消！');
                });

            return false;
        }
    });

    form.on("switch(is_show)", function (obj) {
        let id = this.value,
            name = this.name,
            value = 0;

        if (obj.elem.checked) {
            value = 1;
        }

        $.post("{:url('set_state')}", {id: id, name: name, value: value}, function (ret) {
            ret = JSON.parse(ret);

            layer.msg(ret.msg)

            table.reloadData('list', {scrollPos: 'fixed'});
        });
    });

    table.on("edit(list)", function (obj) {
        const field = obj.field,   //得到字段
              value = obj.value,   //得到修改后的值
              id    = obj.data.id; //得到所在行所有键值

        $.post("{:url('set_state')}", {id: id, name: field, value: parseInt(value)}, function (ret) {
            ret = JSON.parse(ret);

            layer.msg(ret.msg)

            table.reloadData('list', {scrollPos: 'fixed'});
        });
    });

    active = {
        reload: function () {
            table.reloadData('list', {
                page: {curr: 1},
                where: form.val('forms'),
                scrollPos: 'fixed'
            });
        }
    };

    $(document).on("click", "#reload", function () {
        const type = $(this).data("type");
        active[type] && active[type]();
    });

