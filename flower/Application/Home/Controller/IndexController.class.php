<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    private $size = '130';

    public function index(){

        if (IS_POST){
            $data = $_POST;
            $check_result = $this->check_verify($data);
            if ($check_result['code'] == 201){
                echo json_encode($check_result);
                exit;
            }
            $original_photo = array();
            $thumb_photo = array();
            foreach ($check_result['photos'] as $k=>$v){
                $photos = explode('@',$v);
                $original_photo[] = $photos[0];
                $thumb_photo[] = $photos[1];
            }
            unset($check_result['photos']);
            $time = date('Y-m-d H:i:s',time());
            $ideal_total_price = $check_result['goods_number'] * ($check_result['ideal_price']*100);
            $reality_total_price = $check_result['goods_number'] * ($check_result['reality_price']*100);
            $check_result['original_photo'] = serialize($original_photo);
            $check_result['thumb_photo'] = serialize($thumb_photo);
            $check_result['time'] = $time;
            $check_result['ideal_total_price'] = $ideal_total_price;
            $check_result['reality_total_price'] = $reality_total_price;
            if (M('order')->add($check_result)){
                echo json_encode(array('code'=>200,'message'=>'提交成功'));
                exit;
            }else{
                echo json_encode(array('code'=>203,'message'=>'网络不稳定，刷新后再试'));
                exit;
            }
        }else{
            $this->display();
        }
    }


    public function check_verify($data){
        if (!$data['goods_name']){
            $message = '请填写花卉名称';
            return array('code'=>201,'message'=>$message);
        }
        if (!$data['goods_standards']){
            $message = '请填写花卉规格';
            return array('code'=>201,'message'=>$message);
        }
        if (!$data['goods_number']){
            $message = '请填写销售数量';
            return array('code'=>201,'message'=>$message);
        }
        if (!$data['reality_price']){
            $message = '请填实际售价';
            return array('code'=>201,'message'=>$message);
        }
        if ($data['goods_number']<=0 or !is_numeric($data['goods_number'])){
            $message = '销售数量填写有误';
            return array('code'=>201,'message'=>$message);
        }
        if ($data['reality_price']<=0 or !is_numeric($data['reality_price'])){
            $message = '实际售价填写有误';
            return array('code'=>201,'message'=>$message);
        }
        if ($data['ideal_price'] and ($data['reality_price']<=0 or !is_numeric($data['reality_price']))){
            $message = '应售价填写有误';
            return array('code'=>201,'message'=>$message);
        }
        return $data;
    }


    public function upload(){
        if (!empty($_FILES)) {
            import("ORG.NET.UploadFile");
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
            $upload->imageClassPath = "ORG.Util.Image";
            $upload->thumbPrefix = $this->size."_"; //生成多张缩略图
            $upload->thumbMaxWidth = $this->size;
            $upload->thumbMaxHeight = $this->size;
            $upload->saveRule = uniqid; //上传规则
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
                echo json_encode($return);
            }
//            echo 'http://'.$this->_server('HTTP_HOST').__ROOT__.'/upload/qq571031767/130_'.$info[0]['savename'];
        }else{
            echo 'error';
        }
    }
}