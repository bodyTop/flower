<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" Content="text/html;charset=utf8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>财务录入系统</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/bootstrap.css"/>

    <script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/layer.js"></script>
    <script src="/Public/js/bootstrap.js"></script>
</head>
<body>


sdfsdf
</body>
<script>

    //删除当前行
    function del(needle){
        layer.open({
            content: '您确定要删除嘛？'
            ,btn: ['删除', '返回']
            ,yes: function(index){
                var del_element = needle.parents('.info_box');
                var element_num = del_element.siblings('.info_box').length;
                if (element_num == 0){
                    layer.open({
                        content: '最少保留一条信息'
                        ,skin: 'msg'
                        ,time: 2 //2秒后自动关闭
                    });
                }else{
                    del_element.remove();
                }
                layer.close(index);
            }
        });
    }
    $(function () {
        //模太框的弹出
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
        //添加输入行
        $('#add').click(function () {
            var box = '<div class="form-group info_box" style="overflow: hidden">'+ $('.info_box').html() +'</div>'
            $('.info_box:last').after(box)
        });

        //提交
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