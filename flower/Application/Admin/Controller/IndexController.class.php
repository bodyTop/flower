<?php
namespace Admin\Controller;
class IndexController extends CommonController
{
    public function index()
    {
        $order = M('order')->where(array('is_status'=>1))->order('time desc')->select();
        $order = M('order_info')->where(array('is_status'=>1))->order('time desc')->select();

    }

}