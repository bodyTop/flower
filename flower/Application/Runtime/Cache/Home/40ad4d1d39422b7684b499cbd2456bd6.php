<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" Content="text/html;charset=utf8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>财务录入系统</title>
    <link rel="stylesheet" type="text/css" href="/~mac/flower/Public/css/bootstrap.css"/>

    <script src="/~mac/flower/Public/js/jquery.min.js"></script>
    <script src="/~mac/flower/Public/js/layer.js"></script>
    <script src="/~mac/flower/Public/js/bootstrap.js"></script>
</head>
<style>
    #entering {
        width: 15rem;
        height: 58px;
        position: absolute;
        margin: auto;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    .file_dom {
        position: relative;
        display: inline-block;
        background: #D0EEFF;
        border: 1px solid #99D3F5;
        border-radius: 4px;
        padding: 4px 12px;
        overflow: hidden;
        color: #1E88C7;
        text-decoration: none;
        text-indent: 0;
        line-height: 20px;
    }
    .file_dom input[type=file] {
        position: absolute;
        font-size: 100px;
        right: 0;
        top: 0;
        opacity: 0;
    }
    .file_dom:hover {
        background: #AADFFD;
        border-color: #78C3F3;
        color: #004974;
        text-decoration: none;
    }
    form .info_box .col-xs-6{
        padding-left: 0;
    }
</style>
<body>
<button id="entering" type="button" class="btn btn-primary btn-lg " data-toggle="modal" data-target="#myModal">录入销售信息
</button>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">录入销售信息</h4>
            </div>
            <div class="modal-body" style="overflow: hidden">
                <form id="reset" action="<?php echo U('Index/index');?>" method="post">
                    <div class="form-group info_box" style="overflow: hidden">
                        <div class="col-xs-6 pull-left">
                            <label for="exampleInputEmail1">花卉名称</label>
                            <input type="text" class="form-control" name="goods_name[]" placeholder="花卉名称" maxlength="40">
                        </div>
                        <div class="col-xs-6 pull-left">
                            <label for="exampleInputEmail1">花卉规格</label>
                            <input type="text" class="form-control" name="goods_standards[]" maxlength="5">
                        </div>
                        <div class="col-xs-6 pull-left">
                            <label for="exampleInputEmail1">花卉数量</label>
                            <input type="text" class="form-control" name="goods_number[]" pattern="[0-9]*" value="1" maxlength="4">
                        </div>
                        <div class="col-xs-6 pull-left">
                            <label for="exampleInputEmail1">应售价</label>
                            <input type="text" class="form-control" name="ideal_price[]" pattern="[0-9]*">
                        </div>
                        <div class="col-xs-6 pull-left form-group">
                            <label for="exampleInputEmail1">实际售价</label>
                            <input type="text" class="form-control" name="reality_price[]" pattern="[0-9]*">
                        </div>
                        <div class="col-xs-6 pull-left form-group">
                            <label for="exampleInputEmail1">&nbsp;&nbsp;</label>
                            <button type="button" onclick="del($(this))" class="del form-control btn-danger">删除</button>
                        </div>
                        <hr align=center width=100% style="margin: 0;border-top: 1px solid #000; size: 2px;">
                    </div>
                    <div class="col-xs-12 form-group pull-left" style="padding-left: 0">
                        <label for="exampleInputEmail1">备注说明</label>
                        <input type="text" class="form-control" name="remark" >
                    </div>
                    <div class="col-xs-12 pull-left" style="padding-left: 0px">
                        <button type="button" id="add" class="form-control btn-success">添加一行</button>
                    </div>
                    <!--
                    <div class="form-group">
                        <div class="file_dom "><input type="file"  id="fileToUpload" name="fileToUpload" >图片上传</div>
                        <div class="file_dom "><input type="file" accept="image/*" id="imgToUpload" name="imgToUpload" capture="camera">图片拍摄</div>
                        <div class="Upload-img" style="overflow: hidden">
                            <div class="btn-block loading" style="display:none;"><img src=""></div>
                        </div>
                    </div>
                    <script type="text/javascript" src="/~mac/flower/Public/js/ajaxfileupload.js"></script>
                    <script>
                        function ajaxupload(id) {
                            $.ajaxFileUpload({
                                url: "<?php echo U('Home/Index/upload');?>",
                                type: 'post',
                                fileElementId: id,
                                dataType: 'text',
                                secureuri: false, //一般设置为false
                                success: function (data, status) {
                                    $(".loading").show();
                                    // var str = '<div class="list-img"  style="float: left;margin-right: 10px;margin-bottom: 10px" id="uploadImg"><img src="/~mac/flower/attachs/' + data.url + '"><input type="hidden" name="photos[]" value="' + data.originalName+'@'+data.name + '" /></div>';
                                    var str = '<div class="list-img"  style="float: left;margin: 10px" id="uploadImg"><img src="/~mac/flower/attachs/' + data + '"><input type="hidden" name="photos[]" value="' + data+ '" /></div>';
                                    $(".loading").before(str);
                                    $(".loading").hide();
                                    $("#"+id).unbind('change');
                                    $("#"+id).change(function () {
                                        ajaxupload(id);
                                    });
                                }
                            });
                        }
                        $(document).ready(function () {
                            $("#fileToUpload").change(function () {
                                var id = $(this).attr('id');
                                ajaxupload(id);
                            });
                            $(document).on("click", ".photo img", function () {
                                $(this).parent().remove();
                            });
                        });
                        $(document).ready(function () {
                            $("#imgToUpload").change(function () {
                                var id = $(this).attr('id');
                                ajaxupload(id);
                            });
                            $(document).on("click", ".photo img", function () {
                                $(this).parent().remove();
                            });
                        });
                    </script>
                    -->

                </form>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>-->
                <button type="button" id="submit" class="btn btn-primary">提交</button>
            </div>
        </div>
    </div>
</div>

</body>
<script>

    //删除当前行
    function del(needle){
        layer.open({
            content: '您确定要删除嘛？'
            ,btn: ['删除', '返回']
            ,yes: function(index){
                var del_element = needle.parents('.info_box');
                var element_num = del_element.siblings().length;
                if (element_num == 1){
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