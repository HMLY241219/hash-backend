<!DOCTYPE html>
<html lang="zh-CN">
<head>
    {include file="public/frame_head" /}
    <title>{block name="title"}{/block}</title>
    {block name="head_top"}{/block}
    {include file="public/style" /}
    {block name="head"}{/block}
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
{block name="content"}{/block}
{block name="foot"}{/block}
<script>
    const openIframe = (title, url, width = 1000, height = 600) => {
        return layer.open({
            type: 2,
            area: [width + 'px', height + 'px'],
            title: title + '（点击空白区域快速关闭窗口）',
            fixed: false,
            maxmin: true,
            shade: 0.4,
            shadeClose: true,
            content: url,
            end: function () {
                location.reload()
            }
        });
    };
</script>
{block name="script"}{/block}
{include file="public/frame_footer" /}
</div>
</body>
</html>
