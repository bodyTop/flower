<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" Content="text/html;charset=utf8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>财务录入系统</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css"/>

    <script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/layui/layui.all.js"></script>
    <script src="/Public/js/bootstrap.js"></script>
</head>
<body>

<table >
    <tr>
        <tb></tb>
    </tr>
</table>
</body>
<script>


    $(function () {

        $("#submit").click(function () {    // 提交按钮触发事件
            var tourl = $("form").attr("action");    // 获取 表单的 提交地址
            // 序列化 表单数据 后提交 ，太简洁了
            $('#myModal').modal('hide')
            $.post(tourl, $("form").serialize(), function (data) {
                if (data.code == 200){
                    layer.open({
                        content: data.message
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                    // $('#uploadImg').remove()
                    $('#reset')[0].reset();
                    $('#reset .info_box').eq(0).nextAll('.info_box').remove();
                }else{
                    layer.open({
                        content: data.message
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                }
            },'json');
        });
    });
</script>

</html>