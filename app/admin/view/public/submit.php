// 监听提交事件
form.on('submit(submitBtn)', function(data){
// 获取表单数据
var formData = data.field;
console.log(formData,5555); // 输出表单数据
table.reload("table", {
page: {
curr: 1
},
where: formData,
scrollPos: 'fixed',
});
});

