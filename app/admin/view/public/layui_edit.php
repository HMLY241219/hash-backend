table.on('edit', function (obj) {
console.log(obj, 3333);
var value = obj.value //得到修改后的值
, id = obj.data.id //得到所在行所有键值
, field = obj.field; //得到字段
$.post("{:url('layuiedit')}", {
field: field,
value: value,
id : id,
}, function (res) {
res = JSON.parse(res)
if (res.code == 200) {
layer.msg('修改成功');
table.reloadData("table");
} else {
layer.msg('修改失败');
}
})
});
