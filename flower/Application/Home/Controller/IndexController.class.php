<?php

namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    private $size = '80';
    private $fields = array('goods_name'=>'请填写花卉名称','goods_standards'=>'请填写花卉规格','goods_number'=>'请填写销售数量','reality_price'=>'请填实际售价');

    public function index(){

        if (IS_POST){
            $data = I('post.');
            $check_result = $this->check_verify($data);
            if ($check_result['code'] == 201){
                echo json_encode($check_result);
                exit;
            }
//            $original_photo = array();
//            $thumb_photo = array();
//            foreach ($check_result['photos'] as $k=>$v){
//                $photos = explode('_',$v);
//                $original_photo[] = 'attachs/'.$photos[1];
//                $thumb_photo = 'attachs/'.$v;
//            }
//            unset($check_result['photos']);
//            $check_result['original_photo'] = serialize($original_photo);
//            $check_result['thumb_photo'] = serialize($thumb_photo);
            $time = date('Y-m-d H:i:s',time());
            $ideal_total_price = 0;
            $reality_total_price = 0;
            foreach ($check_result['goods_number'] as $k=>$v){
                $check_result['ideal_price'][$k] = $check_result['ideal_price'][$k]*100;
                $check_result['reality_price'][$k] = $check_result['reality_price'][$k]*100;
                $ideal_total_price += (int)$v * ((int)$check_result['ideal_price'][$k]);
                $reality_total_price += (int)$v * ((int)$check_result['reality_price'][$k]);
            }

            $order = array();
            $order['time'] = $time;
            $order['ideal_total_price'] = $ideal_total_price;
            $order['reality_total_price'] = $reality_total_price;
            $order['remark'] = $check_result['remark'];
            unset($check_result['remark']);

            $order_info = array();
            foreach ($check_result as $filed=>$value){
                foreach ($value as $k=>$v){
                    $order_info[$k][$filed] = $v;
                }
            }

            if ($order_id = M('order')->add($order)){
                foreach ($order_info as $key=>$array){
                    $order_info[$key]['order_id'] = $order_id;
                }
                if (M('order_info')->addAll($order_info)){
                    echo json_encode(array('code'=>200,'message'=>'提交成功'));
                    exit;
                }
            }
            echo json_encode(array('code'=>203,'message'=>'网络不稳定，刷新后再试'));
            exit;
        }else{
            $this->display();
        }
    }


    public function check_verify($data){
        $two_check = array('goods_number'=>'销售数量填写有误','reality_price'=>'实际售价填写有误','ideal_price'=>'应售价填写有误');
        foreach ($data as $field=>$val_array){
            foreach ($val_array as $k=>$v){
                if (!$v){
                    $message = $this->fields[$field];
                    return array('code'=>201,'message'=>$message);
                }
                if (in_array($field,array_keys($two_check))){
                    if ($v <=0 or !is_numeric($v)){
                        $message = $two_check[$field];
                        return array('code'=>201,'message'=>$message);
                    }
                }
            }

        }
        return $data;
    }


    public function upload(){
        if (!empty($_FILES)) {
            import("Org.Net.UploadFile");
            $upload = new \UploadFile();
            $upload->maxSize = 2048000;
            $upload->allowExts = array('jpg','jpeg','gif','png');
            $name = date('Y/m/d', NOW_TIME);
            $dir = BASE_PATH . '/attachs/' . $name . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $upload->savePath = $dir;
            $upload->thumb = true; //设置缩略图
            $upload->imageClassPath = "Org.Util.Image";
            $upload->thumbPrefix = $this->size."_"; //生成多张缩略图
            $upload->thumbMaxWidth = $this->size;
            $upload->thumbMaxHeight = $this->size;
            $upload->saveRule = 'uniqid'; //上传规则
            $upload->thumbRemoveOrigin = false; //删除原图
            if(!$upload->upload()){
                $this->error($upload->getErrorMsg());//获取失败信息
            } else {
                $info = $upload->getUploadFileInfo();//获取成功信息
                $return = array(
                    'url' => $name .'/'. $this->size.'_' . $info[0]['savename'],
                    'originalName' => $name.'/'. $info[0]['savename'],
                    'name' => $name .'/'.$this->size.'_' . $info[0]['savename'],
                    'state' => 'SUCCESS',
                    'size' => $info[0]['size'],
                    'type' => $info[0]['extension'],
                );
                echo $return['name'];
            }
//            echo 'http://'.$this->_server('HTTP_HOST').__ROOT__.'/upload/qq571031767/130_'.$info[0]['savename'];
        }else{
            echo 'error';
        }
    }
}