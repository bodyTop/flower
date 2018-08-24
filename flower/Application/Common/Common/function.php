<?php

function p($var)
{
    echo '<pre style="background: #ddd;border-radius: 5px;padding: 10px">';
    if(is_bool($var))
    {
        var_dump($var);
    }elseif(is_null($var))
    {
        var_dump($var);
    }else{
        print_r($var);
    }
    echo '</pre>';
}

/**
 * 是否为手机
 * @return boolean
 */
function is_mobile() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = array("240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi",
        "android", "anywhereyougo.com", "applewebkit/525", "applewebkit/532", "asus", "audio",
        "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu",
        "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ",
        "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi",
        "htc", "huawei", "hutchison", "inno", "ipad", "ipaq", "iphone", "ipod", "jbrowser", "kddi",
        "kgt", "kwc", "lenovo", "lg ", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo",
        "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-",
        "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia",
        "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-",
        "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo",
        "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank",
        "sony", "spice", "sprint", "spv", "symbian", "tablet", "talkabout", "tcl-", "teleca", "telit",
        "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin",
        "vk-", "voda", "voxtel", "vx", "wap", "wellco", "wig browser", "wii", "windows ce",
        "wireless", "xda", "xde", "zte");
    $is_mobile = false;
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
}


function is_app(){
     //return true;
     return strpos($_SERVER['HTTP_USER_AGENT'], 'BaoCmsApp');
}

function is_android(){
    //return true;
     return strpos($_SERVER['HTTP_USER_AGENT'], 'BaoCmsAppAndroid');
}





//时间格式化
function formatt($time) {

    $t = NOW_TIME - $time;
    $mon = (int) ($t / (86400 * 30));
    if ($mon >= 1) {
        return '一个月前';
    }
    $day = (int) ($t / 86400);
    if ($day >= 1) {
        return $day . '天前';
    }
    $h = (int) ($t / 3600);
    if ($h >= 1) {
        return $h . '小时前';
    }
    $min = (int) ($t / 60);
    if ($min >= 1) {
        return $min . '分前';
    }
    return '刚刚';
}

/*
 * 经度纬度 转换成距离
 * $lat1 $lng1 是 数据的经度纬度
 * $lat2,$lng2 是获取定位的经度纬度
 */

function rad($d) {
    return $d * 3.1415926535898 / 180.0;
}

function getDistanceNone($lat1, $lng1, $lat2, $lng2) {
    $EARTH_RADIUS = 6378.137;
    $radLat1 = rad($lat1);
    //echo $radLat1;  
    $radLat2 = rad($lat2);
    $a = $radLat1 - $radLat2;
    $b = rad($lng1) - rad($lng2);
    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
    $s = $s * $EARTH_RADIUS;
    $s = round($s * 10000);
    return $s;
}

/**
 * 功能：计算经纬度之间的距离
 * @param unknown $lat1
 * @param unknown $lng1
 * @param unknown $lat2
 * @param unknown $lng2
 */
function getDistance($lat1, $lng1, $lat2, $lng2)
{
    $s = getDistanceNone($lat1, $lng1, $lat2, $lng2);
    $s = $s / 10000;
    if ($s < 1)
    {
        $s = round($s * 1000);
        $s.='m';
    } else {
        $s = round($s, 2);
        $s.='km';
    }
    return $s;
}

//空白区域插件

/**
 * 判断一个字符串是否是一个Email地址
 *
 * @param string $string
 * @return boolean
 */
function isEmail($string) {
    return (boolean) preg_match('/^[a-z0-9.\-_]{2,64}@[a-z0-9]{2,32}(\.[a-z0-9]{2,5})+$/i', $string);
}


/**
 * 判断输入的字符串是否是一个合法的电话号码（仅限中国大陆）
 *
 * @param string $string
 * @return boolean
 */
function isPhone($string) {
    if (preg_match('/^[0,4]\d{2,3}-\d{7,8}$/', $string))
        return true;
    return false;
}

/**
 * 判断输入的字符串是否是一个合法的手机号(仅限中国大陆)
 *
 * @param string $string
 * @return boolean
 */
function isMobile($string)
{
   
    if (preg_match('/^[1]+[3,4,5,7,8]+\d{9}$/', $string))
        return true;
    return false;
    //return ctype_digit($string) && (11 == strlen($string)) && ($string[0] == 1);
}

/**
 * 判断输入的字符串是否是一个合法的QQ
 *
 * @param string $string
 * @return boolean
 */
function isQQ($string) {
    if (ctype_digit($string)) {
        $len = strlen($string);
        if ($len < 5 || $len > 13)
            return false;
        return true;
    }
    return isEmail($string);
}

/**
 *
 * @param string $fileName
 * @return boolean
 */
function isImage($fileName) {
    $ext = explode('.', $fileName);
    $ext_seg_num = count($ext);
    if ($ext_seg_num <= 1)
        return false;

    $ext = strtolower($ext[$ext_seg_num - 1]);
    return in_array($ext, array('jpeg', 'jpg', 'png', 'gif'));
}
function isImage_array($fileName) {
    if (is_array($fileName)){
       
        foreach ($fileName as $k=>$v){
            $ext = explode('.', $v);
            $ext_seg_num = count($ext);
            if ($ext_seg_num <= 1)
                return false;
            $ext = strtolower($ext[$ext_seg_num - 1]);
            return in_array($ext, array('jpeg', 'jpg', 'png', 'gif'));
        }
    }
  
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = false) {
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice . '...' : $slice;
}


/**
 * 在数据列表中搜索
 * @access public
 * @param array $list 数据列表
 * @param mixed $condition 查询条件
 * 支持 array('name'=>$value) 或者 name=$value
 * @return array
 */
function list_search($list, $condition) {
    if (is_string($condition))
        parse_str($condition, $condition);
    // 返回的结果集合
    $resultSet = array();
    foreach ($list as $key => $data) {
        $find = false;
        foreach ($condition as $field => $value) {
            if (isset($data[$field])) {
                if (0 === strpos($value, '/')) {
                    $find = preg_match($value, $data[$field]);
                } elseif ($data[$field] == $value) {
                    $find = true;
                }
            }
        }
        if ($find)
            $resultSet[] = &$list[$key];
    }
    return $resultSet;
}




//给图片加绝对路径
/**
 * 
 * @param unknown $data  所有数据
 * @param unknown $string  要加上绝对路径的字段
 */
function imgurl($data,$string){
    $list = array();
    if (!empty($data))
    {
        if (!empty($string)){
            //一维数组
            if (count($data)==count($data,COUNT_RECURSIVE))
            {
                $data[$string] = HTTP.$data[$string];
                $list = $data;
            }
            else{
                //多维数组
                foreach ($data as $k=>$v){
                    $v[$string] = HTTP.$v[$string];
                    $list[] = $v;
                }
            }
        }else{
            // 单数组添加http   如果图片本身就带有服务器地址则不添加
            foreach ($data as $k=>$v){
                $bh = stristr($v,HTTP);
                $v = $bh==''?HTTP.$v:$bh;
                $list[] = $v;
            }
        }
    }
    return $list;
}


function object2array(&$object) {
    $object =  json_decode( json_encode( $object),true);
    return  $object;
}

function string_arr($array){
    foreach ($array as $k=>$v){
        if (!is_array($v)){
            $array[$k] = $v.'';
        }
    }
    return $array;
}


/****
 * 去掉一个数组中的重复元素
 * @param unknown $array
 */
function a_array_unique($array)
{
    $out = array();
    foreach ($array as $key=>$value)
    {
        if (!in_array($value, $out))
        {
            $out[$key] = $value;
        }
    }
    return $out;
}



/**
 * 取HTML里面img的图片路径，如果是本地图片返回当前url,如果是网络图片，则照常返回，格式为array
 */


/**
 * 给图片数组加服务器路径
 */
function img_array($data){
    $result = array();
    if ($data){
        foreach ($data as $k=>$v){
            $result[$k] = HTTP.$v;
        }        
    }
    return $result;
}

