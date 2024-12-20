<?php
namespace customlibrary;

use app\api\controller\Vip;
use curl\Curl;
use service\NewjsonService;
use think\facade\Config;
use think\facade\Db;
use think\facade\Log;

class Common{

    /**生成订单号
     * @param $type
     * @return string
     */
    public static function doOrderSn($type)
    {
        return date('YmdHis') . $type . substr(microtime(), 2, 3) . sprintf('%02d', rand(0, 99));
    }


    /**
     * @return void生成二维码
     * $urlstr 二维码内容
     * $catalogue 本地存储的目录
     */
    public static function create_qrcode($urlstr,$catalogue = 'qrcode'){

//        $urlstr = config('site.qrcode_url').'?p_userid='.$user_id; //二维码存入内容
        Vendor('phpqrcode.phpqrcode');	//引入phpqrcode
        //生成二维码图片
        $errorCorrectionLevel = 'L';	//容错级别
        $matrixPointSize = 5;			//生成图片大小
        $img = mt_rand(0,9999).uniqid().mt_rand(0,9999).mt_rand(0,9999).'.png';
        $file_path = $catalogue.'/'.date('Ymd').'/';
        $path= ROOT_PATH .'public/uploads/'.$file_path;
        if(!file_exists($path)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($path,0777,true);
        }
        $filename = $path.$img;
        \QRcode::png($urlstr,$filename , $errorCorrectionLevel, $matrixPointSize, 2);
        $QR = $filename;				//已经生成的原始二维码图片文件
        $QR = imagecreatefromstring(file_get_contents($QR));
        //保存图片,销毁图形，释放内存
        if (!file_exists($filename)) {
            imagepng($QR, $filename);
            imagedestroy($QR);
        } else {
            imagedestroy($QR);
        }

        return '/uploads/'.$file_path.$img;

    }


    /** RSA签名
     * @param $str v3签名字符串
     * @param $key 商户私钥 apiclient_key.pem 路径
     * @return array
     */
    public static function RsaEncrypt($str,$key){

        $myfile  = fopen($key, "r");
        $key = fread($myfile,filesize($key));
        if(!$key){
            return ['code'=>201,'msg'=>'密钥不存在'];
        }
        openssl_sign($str, $data, $key, 'sha256WithRSAEncryption');
        $data = base64_encode($data);
        fclose($myfile);
        return ['code'=>200,'msg'=>'成功','data'=>$data];
    }


    /**
     * @param $arr 微信v2支付解析xml格式
     * @return string
     */
    public static function arrayToXml($arr) {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }


    /**
     * @param $arr 微信v3支付解析支付数据
     * @return string
     */
    public static function wechartDecrypt($arr){

        $post_data = json_decode($arr,true);
        if($post_data['summary'] == '支付成功'){
            $nonceStr = $post_data['resource']['nonce'];
            $associatedData = $post_data['resource']['associated_data'];
            $ciphertext = $post_data['resource']['ciphertext'];
            $ciphertext = base64_decode($ciphertext);
            if (strlen($ciphertext) <= 12) {
                return ['code'=>201,'msg'=>'支付信息错误'];
            }
            //解密
            $key = config('site.xcx_key3');//商户平台设置的api v3 密码
            $str = sodium_crypto_aead_aes256gcm_decrypt($ciphertext, $associatedData, $nonceStr, $key);
            $str =  json_decode($str, true);
            return ['code'=>'200','msg'=>'成功','data'=>$str];
        }else{
            return ['code'=>'201','msg'=>'支付失败'];
        }


    }


    /**微信公众号 OPENTM201743389 消息模板
     * @param $keyword1 订单号
     * @param $keyword2 订单概要
     * @param $keyword3 所属会员
     * @param $keyword4 会员手机
     * @param $keyword5 配送地址
     * @param $remark 备注
     * @return void
     */
    public static function deliver_goods_content($keyword1,$keyword2,$keyword3,$keyword4,$keyword5,$remark){

        $content = [
            'first' => [
                'value' => '平台来新单啦!请尽快发货',
                'color' => '#173177',
            ],
            'keyword1' => [
                'value' => $keyword1,
                'color' => '#173177',
            ],
            'keyword2' => [
                'value' => $keyword2,
                'color' => '#173177',
            ],
            'keyword3' => [
                'value' => $keyword3,
                'color' => '#173177',
            ],
            'keyword4' => [
                'value' => $keyword4,
                'color' => '#173177',
            ],
            'keyword5' => [
                'value' => $keyword5,
                'color' => '#173177',
            ],
            'remark' => [
                'value' => $remark,
                'color' => '#173177',
            ],
        ];

        return $content;
    }



    /**
     * 将pdf文件转化为多张png图片
     * @param string $pdf  pdf所在路径 （/www/pdf/abc.pdf pdf所在的绝对路径）
     * @param string $path 新生成图片所在路径 (/www/pngs/)
     *
     * @return array|bool
     */
    public static function pdf2png($pdf)
    {

        $path = ROOT_PATH . 'public/uploads/wrodpng/';

        $im = new \Imagick();
        $im->setResolution(120, 120); //设置分辨率 值越大分辨率越高
        $im->setCompressionQuality(100);
        $im->readImage($pdf);
        $count = count($im); //word文档数量
        foreach ($im as $k => $v) {
            $v->setImageFormat('png');
//            //如果所有word的图片就用下面注释的代码
//            $fileName = $path . md5($k . time()) . '.png';
//            if ($v->writeImage($fileName) == true) {
//                $return[] = $fileName;
//            }
            $name = md5($k . time()) . '.png';
            $fileName = $path . $name;
            if ($v->writeImage($fileName) == true) {
                $data['image'] = '/uploads/wrodpng/'.$name;
                break;
            }
        }
        $data['count'] = $count;
        return $data;
    }



    /**
     * 将pdf转化为单一png图片
     * @param string $pdf  pdf所在路径 （/www/pdf/abc.pdf pdf所在的绝对路径）
     * @param string $path 新生成图片所在路径 (/www/pngs/)
     *
     * @throws Exception
     */
    public static function pdf2png2($pdf)
    {

        $path = ROOT_PATH . 'public/uploads/wrodpng/';


        try {
            $im = new \Imagick();
            $im->setCompressionQuality(100);
            $im->setResolution(120, 120);//设置分辨率 值越大分辨率越高

            $im->readImage($pdf);

            $canvas = new \Imagick();
            $imgNum = $im->getNumberImages();
            //$canvas->setResolution(120, 120);
            foreach ($im as $k => $sub) {
                $sub->setImageFormat('png');
                //$sub->setResolution(120, 120);
                $sub->stripImage();
                $sub->trimImage(0);
                $width  = $sub->getImageWidth() + 10;
                $height = $sub->getImageHeight() + 10;
                if ($k + 1 == $imgNum) {
                    $height += 10;
                } //最后添加10的height
                $canvas->newImage($width, $height, new \ImagickPixel('white'));
                $canvas->compositeImage($sub, \Imagick::COMPOSITE_DEFAULT, 5, 5);
            }

            $canvas->resetIterator();
            $name = microtime(true) . '.png';
            $canvas->appendImages(true)->writeImage($path .$name );
            $url =  '/uploads/wrodpng/'.$name;
            return ['code'=>200,'msg'=>'成功','data'=>$url];
        } catch (Exception $e) {
            return ['code'=>201,'msg'=>$e,'data'=>[]];
//            throw $e;
        }
    }


    /**
     * enRSA2 RSA加密这是RSA加密一定要记住
     *  $private_key 支付宝应用私钥，通过密钥生成工具生成
     * @param String $data
     * @return String
     */
    public static function enRSA2($data,$private_key)
    {

//        $myfile  = fopen($private_key, "r");
//        $private_key = fread($myfile,filesize($private_key));
//        if(!$private_key){
//            return ['code'=>201,'msg'=>'密钥不存在'];
//        }
        $str = chunk_split(trim($private_key), 64, "\n");
        $key = "-----BEGIN RSA PRIVATE KEY-----\n$str-----END RSA PRIVATE KEY-----\n";
        // $key = file_get_contents(storage_path('rsa_private_key.pem')); 为文件时这样引入
        $signature = '';
        $signature = openssl_sign($data, $signature, $key, OPENSSL_ALGO_SHA256)?base64_encode($signature):NULL;
        return $signature;
    }


    /**
     * myHttpBuildQuery
     * 之所以不用 自带函数 `http_build_query`
     * 是因为格式化的时间带有  ‘:’  会被转换成十六进制 utf-8 码
     *
     * @param Array
     * @return String
     */
    public static function myHttpBuildQuery($dataArr)
    {
        ksort($dataArr);
        $signStr = '';
        foreach ($dataArr as $key => $val) {
            if (empty($signStr)) {
                $signStr = $key.'='.$val;
            } else {
                $signStr .= '&'.$key.'='.$val;
            }
        }
        return $signStr;
    }

    /**
     * @param $time 获取最近的7天日期
     */
    public static function get7day($time = '', $format='Y-m-d'){
        $time = $time != '' ? $time : time();
        //组合数据
        $date = [];
        for ($i=0; $i<=6; $i++){
            $date[$i] = date($format ,strtotime( '+' . ($i-6) .' days', $time));
        }
        return $date;
    }


    /**
     * @param $mydate 获取年龄 2019-10-12
     */
    public static function age($mydate){
        $birth=$mydate;
        list($by,$bm,$bd)=explode('-',$birth);
        $cm=date('n');
        $cd=date('j');
        $age=date('Y')-$by-1;
        if ($cm>$bm || $cm==$bm && $cd>=$bd) $age++;
        return $age;

    }

    /**
     * @param $url //判断地址是否为绝对路径，并拼接地址
     * @return mixed|string
     */
    public static function domain_name_path($url){

        $preg = "/^http(s)?:\\/\\/.+/";
        if(!preg_match($preg,$url)){
            return Config::get('redis.domain').$url;
        }else{
            return $url;
        }
    }



    /**  存入日志
     * [myselfLog 自定义日功能]
     * @param  [type] $title        [备注]
     * @param  [type] $log_content [内容]
     * @param  string $logname       [保存文件名称]
     * @return [type]              [description]
     */
    public static function mylog($title, $log_content, string $logname = "") {
        $max_size = 300000;//字节
        if ($logname == "") {
            $log_filename = RUNTIME_PATH . '/tlogs/' . date('Ym-d') . ".log";
        } else {
            $log_filename = RUNTIME_PATH . '/tlogs/' . $logname . ".log";
        }

        if (file_exists($log_filename) && (abs(filesize($log_filename)) > $max_size)) {
            rename($log_filename, dirname($log_filename) . DS . date('Ym-d-His') . $logname . ".log");
        }

        $t = microtime(true);
        $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
        $d = new \DateTime (date('Y-m-d H:i:s.' . $micro, $t));
        if(is_array($log_content)){
            $log_content = JSONReturn($log_content);
        }
        file_put_contents($log_filename, '   ' . $d->format('Y-m-d H:i:s u') . " title：" . $title . "\r\n" . $log_content . "\r\n------------------------ --------------------------\r\n", FILE_APPEND);
    }


    /**
     *  $person_age_min 最小年龄
     *  $person_age_max 最大年龄
     * @return string 根据输入年龄计算最早和最晚的出生年月
     */
    public static function Age_calculation_birthday($person_age_min = '',$person_age_max = ''){

        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $max_birth = '';
        $min_birth = '';
// 用户输入了最小年龄和最大年龄
        if(isset($person_age_min) && isset($person_age_max)){

            $min = min($person_age_min, $person_age_max);
            $max = max($person_age_min, $person_age_max);
            # 计算最大年龄的最早出生日期
            $max_year = $year - $max - 1;
            $max_birth = date('Y-m-d', strtotime("+1 day", strtotime($max_year.'-'.$month.'-'.$day)));
            # 计算最小年龄的最后出生日期
            $min_year = $year-$min;
            $min_birth = $min_year.'-'.$month.'-'.$day;
        }elseif(isset($person_age_min)  && !isset($person_age_max)){ //用户只输入了最小年龄

            # 计算最大年龄的最早出生日期
            $max_year = $year - $person_age_min - 1;
            $max_birth = date('Y-m-d', strtotime("+1 day", strtotime($max_year.'-'.$month.'-'.$day)));
            # 计算最小年龄的最后出生日期
            $min_year = $year-$person_age_min;
            $min_birth = $min_year.'-'.$month.'-'.$day;
        }elseif(!isset($person_age_min)  && isset($person_age_max)) { // 用户只输入了最大年龄

            # 计算最大年龄的最早出生日期
            $max_year = $year - $person_age_max - 1;
            $max_birth = date('Y-m-d', strtotime("+1 day", strtotime($max_year.'-'.$month.'-'.$day)));
            # 计算最小年龄的最后出生日期
            $min_year = $year-$person_age_min;
            $min_birth = $min_year.'-'.$month.'-'.$day;
        }

        return ['min_birth' => $min_birth , 'max_birth' =>$max_birth]; //年龄越小时间戳越大
//        return $min_birth.' ==== '.$max_birth;
//        if(!empty($min_birth) && !empty($max_birth)){
//            // sql语句
//            $sql = "select * from user where birth between $max_birth and $min_birth";
//
//        }

    }


    /**
     * 将图片转为base64图片
     * @param $img 图片地址
     * @param $imgHtmlCode
     */
    public static function imgBase64Encode($img = '', $imgHtmlCode = true)
    {
        //如果是本地文件
        if(strpos($img,'http') === false && !file_exists($img)){
            return $img;
        }
        //获取文件内容
        $file_content = file_get_contents($img);
        if($file_content === false){
            return $img;
        }
        $imageInfo = getimagesize($img);
        $prefiex = '';
        if($imgHtmlCode){
            $prefiex = 'data:' . $imageInfo['mime'] . ';base64,';
        }
        $base64 = $prefiex.chunk_split(base64_encode($file_content));
        return $base64;
    }


    public static function base64qrcode($urlstr,$catalogue = 'qrcode'){
        $url = self::create_qrcode($urlstr,$catalogue);

        $image = self::base64EncodeImage(ROOT_PATH . 'public'.$url);

        $file = ROOT_PATH . 'public'.$url;
        $res = unlink ($file);

        return $image;
    }


    public static function base64EncodeImage ($image_file) {

//        $file = "encode.jpg";
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }



    /**	获取指定时间后几个月的今天
     * @param $date 开始时间 '2018-1-30 15:54:20'
     * @param $number  后面几个月 '6'
     * @param $type  'ymdhis' =  'Y-m-d H:i:s' ,  'ymd' = ‘Y-m-d’
     * @return string
     */

    public static function getNextMonthDays($date,$number,$type = 'ymdhis'){
        $firstday = date('Y-m-01', strtotime($date));
        $lastday = strtotime("$firstday +".($number + 1)." month -1 day");
        $day_lastday = date('d', $lastday); //获取下个月份的最后一天
//        $day_benlastday = date('d', strtotime("$firstday +1 month -1 day")); //获取本月份的最后一天
        //获取当天日期
        $Same_day = date('d', strtotime($date));

        //判断当天是否是最后一天   或 下月最后一天 等于 本月的最后一天
        if($Same_day > $day_lastday){
            $day = $day_lastday;

        }else{
            $day = $Same_day;

        }
        if($type == 'ymdhis'){
            $day = date('Y',$lastday).'-'.date('m',$lastday).'-'.$day.' '.date('H:i:s',strtotime($date));
        }else{
            $day = date('Y',$lastday).'-'.date('m',$lastday).'-'.$day;
        }

        return $day;

    }

    /**
     * @return void 正则表达式
     * $str 效验的字符串
     * $type 类型 'phone' => 判断是否是电话号码 ， 'image' => 判断是否是图片
     *
     */
    public static function PregMatch($str,$type){
        switch ($type){
            case 'phone':
                $status =  preg_match("/^\d{2}9\d{8}$/u", $str);
                break;
            case 'image':
                $status = preg_match('/.*(\.png|\.jpg|\.jpeg|\.gif)$/', $str);
                break;
            case 'idcard':
                $status = preg_match('/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/i', $str);
                break;
            case 'email':
                $status = preg_match("/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i", $str);
                break;
            case 'ifsc' :
                $status = preg_match("/^[A-Za-z]{4}0[A-Z0-9a-z]{6}$/", $str);
                break;
            case 'cpf' :
                $status = preg_match("/^\d{11}$/", $str);
                break;
            case 'cnpj' :
                $status = preg_match("/^\d{14}$/", $str);
                break;
            case 'chinese' ://检查中文
                $status = preg_match("/[\x{4e00}-\x{9fa5}]/u", $str);
                break;
            default:
                $status = false;
        }
        return $status;
    }

    /**
     * 计算2个时间相差的,天数，时分秒， 倒计时时间
     * @param $starttime 开始时间时间戳
     * @param $endtime 结束时间时间戳
     * @return void
     */
    public static function CountDown($starttime,$endtime){
        if($starttime >= $endtime){
            $maxtime = $starttime;
            $mintime = $endtime;
        }else{
            $maxtime = $endtime;
            $mintime = $starttime;
        }

        $activity['day'] = floor(($maxtime-$mintime)/86400);

        $activity['hour'] = floor(($maxtime-$mintime)%86400/3600);

        $activity['minute'] = floor(($maxtime-$mintime)%86400%3600/60);

        $activity['second'] = floor(($maxtime-$mintime)%86400%3600%60);

        return $activity;
    }


    /**阿拉伯数字转中文大写金额
     * @param $num 金额
     * @return string
     */
    public static function NumToCNMoney($num){

        $c1 = "零壹贰叁肆伍陆柒捌玖";
        $c2 = "分角元拾佰仟万拾佰仟亿";
        $num = round($num, 2);
        $num = $num * 100;
        if (strlen($num) > 16) {
            return "数据太长，没有这么大的钱吧，检查下";
        }
        $i = 0;
        $c = "";
        while (1) {
            if ($i == 0) {
                $n = substr($num, strlen($num) - 1, 1);
            } else {
                $n = $num % 10;
            }
            $p1 = substr($c1, 3 * $n, 3);
            $p2 = substr($c2, 3 * $i, 3);
            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
                $c = $p1 . $p2 . $c;
            } else {
                $c = $p1 . $c;
            }
            $i = $i + 1;
            $num = $num / 10;
            $num = (int)$num;
            if ($num == 0) {
                break;
            }
        }
        $j = 0;
        $slen = strlen($c);
        while ($j < $slen) {
            $m = substr($c, $j, 6);
            if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
                $left = substr($c, 0, $j);
                $right = substr($c, $j + 3);
                $c = $left . $right;
                $j = $j - 3;
                $slen = $slen - 3;
            }
            $j = $j + 3;
        }

        if (substr($c, strlen($c) - 3, 3) == '零') {
            $c = substr($c, 0, strlen($c) - 3);
        }
        if (empty($c)) {
            return "零元";
        } else {
            return $c;
        }

    }

    /** 判断当前时间是否在每天的某一时间区域内
     * @param $startdate  9:00
     * @param $enddate 18:00
     * @return int
     */
    public static function get_curr_time_section($startdate,$enddate){
        $checkDayStr = date('Y-m-d ',time());
        $timeBegin1 = strtotime($checkDayStr.$startdate.":00");
        $timeEnd1 = strtotime($checkDayStr.$enddate.":00");

        $curr_time = time();

        if($curr_time >= $timeBegin1 && $curr_time <= $timeEnd1)
        {
            return true;
        }

        return false;

    }

    /**
     * @param array $from  起点坐标(经纬度) [lat,lng][纬度,经度]
     * @param array $to 终点坐标(经纬度) [lat,lng][纬度,经度]
     * @return void
     */
    public static function distance(array $from ,array $to){
        sort($from);
        sort($to);
        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $distance = $EARTH_RADIUS*2*asin(sqrt(pow(sin( ($from[0]*pi()/180-$to[0]*pi()/180)/2),2)+cos($from[0]*pi()/180)*cos($to[0]*pi()/180)* pow(sin( ($from[1]*pi()/180-$to[1]*pi()/180)/2),2)))*1000;
        $km = true; // 是否以km为单位
        if($km){
            $distance = $distance / 1000;
        }

        return round($distance, 2);
    }


    /**
     * 商品多规格方法一
     * @param array $attr_group  例:[['title'=>'颜色','values'=>'白色,红色']]
     * @param integer $index 第几轮
     * @param integer $row 第几行
     * @param array $keys
     * @param array $attrs
     * @return array
     */

    public static function setAttr(array $attr_group, int $index = 0, array $keys = [], array $attrs = [])
    {

        static $row = 0;

        if ($index == 0) {
            foreach($attr_group as $i) {
                $keys[] = 0;

            }
        }

        if (isset($attr_group[$index])) {
//            $attr_values = explode(',', $attr_group[$index]['values']);
            $attr_values = $attr_group[$index]['values'];

            foreach($attr_values as $key => $attr_value) {
                $keys[$index] = $key;
                if ($index + 1 == count($attr_group)) {

                    dump($keys);

                    foreach($keys as $i => $item) {
//                        $attrs[$row][$attr_group[$i]['title']] = explode(',', $attr_group[$i]['values'])[$item];
                        $attrs[$row][$attr_group[$i]['title']] =  $attr_group[$i]['values'][$item];
                    }
//                    $attrs[$row]['price'] = '0';
                    $row++;
                } else {

                    $attrs = self::setAttr($attr_group, $index + 1, $keys, $attrs);
                }
            }
        }

        return $attrs;
    }

    /**商品多规格方法二
     * @param array $$arr 商品多规格 [['黑','白','红','绿'],['大','小'],['A','B','C','D']];
     * @return array
     *
     */
    public static function asetAttr(array $arr)
    {

        $book = [];
        foreach ($arr as $i => $v){
            for ($j = 0 ; $j <= count($v) - 1 ; $j ++) {
                $book[$i][$j] = 0;
            }
        }

        $res = [];
        $pos = 0;
        function dfs($arr,$step,&$res,$book,&$pos){
            if($step == count($arr)) { # 输出中间路径
                $pos = $pos + 1;
                for($i = 0; $i < count($book); $i++){
                    for($j = 0; $j < count($book[$i]); $j++){
                        if($book[$i][$j] == 1) $res[$pos][] = $arr[$i][$j];
                    }
                }
                return;
            }
            for($i = 0; $i < count($arr[$step]); $i++){
                if($book[$step][$i] == 0){
                    $book[$step][$i] = 1; # 标记走过
                    dfs($arr,$step + 1, $res,$book,$pos);
                    $book[$step][$i] = 0; # 标记回溯
                }
            }
        }
        dfs($arr,0,$res,$book,$pos);

        return $res;
    }

    /**商品多规格方法三
     * @param array $sku 商品多规格 例:[['title'=>'颜色','values'=>'白色,红色']]
     * @return array
     */
    public static function setSku(array $sku){
        $temp = [];
        for ( $i = 0; $i < count($sku); $i++) {
            $temp_p = [];
            for ($v = 0; $v < count($sku[$i]['values']); $v++) {
                if (count($temp) == 0) {
                    array_push($temp_p,$sku[$i]['values'][$v]);
                } else {
                    for ($t = 0; $t < count($temp); $t++) {
                        array_push($temp_p,$temp[$t] . ',' . $sku[$i]['values'][$v]);
                    }
                }
            }
            $temp = $temp_p;
        }
        return $temp;
    }

    /**上传图片，文件
     * @param $dirname  目录名
     * @param $suffixname   后缀名
     * @return \think\response\Json
     */
    public static function file($FILES,$dirname,$suffixname){
        $filepath = ROOT_PATH.'/public/uploads/'.$dirname.'/';
        $name = self::doOrderSn(789);
        $tmp = isset($FILES['file']['tmp_name']) ? $FILES['file']['tmp_name'] : '';
        if(!$tmp){
            return json(['code' => 201 , 'code' => 'error','data' => []]);
        }
        if(move_uploaded_file($tmp,$filepath.$name.$suffixname)){
            return json(['code' => 200 , 'msg' => 'success','data' => '/public/uploads/'.$dirname.'/'.$name.$suffixname]);
        }else{
            return json(['code' => 201 , 'msg' => 'error','data' => []]);
        }
    }


    /**
     * 返回开始时间和结束时间的所有天数
     * Returns every date between two dates as an array
     * @param string $startDate the start of the date range  2022-12-12
     * @param string $endDate the end of the date range   2023-02-16
     * @param string $format DateTime format, default is Y-m-d
     * @return array returns every date between $startDate and $endDate, formatted as "Y-m-d"
     */
    public static function createDateRange($startDate, $endDate, $format = "Y-m-d")
    {

        $startDate = is_numeric($startDate) ? date('Y-m-d',$startDate) : $startDate;
        $endDate = is_numeric($endDate) ? date('Y-m-d',$endDate) : $endDate;
        $begin = new \DateTime($startDate);
        $end = new \DateTime(date('Y-m-d',strtotime($endDate .' +1 day')));

        $interval = new \DateInterval('P1D'); // 1 Day

        $dateRange = new \DatePeriod($begin, $interval, $end);

        $range = [];

        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }

        return $range;
    }

    /**
     * @return mixed 获取IP
     */
    public static function getip()
    {

        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] as $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }

    /**
     * 过滤掉emoji表情
     * @param $str
     * @return array|string|string[]|null
     */
    public static function filterEmoji($str)
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);
        return $str;
    }


    /**
     * 对签名的数组进行排序，最后追加上key，在md5加密
     * @param $params  签名数组
     * @param $serpaykey key
     * @return string
     */
    public static function quan_sign4($params,$serpaykey){
        ksort($params);
        $string = [];
        foreach ($params as $key => $value) {
            if ($key == 'sign') continue;
            $string[] = $key . '=' . $value;
        }
        $sign = (implode('&', $string)) . '&key=' . $serpaykey;

        return strtolower(md5($sign));
    }


    /**
     * ASCII 码从小到大排序 「&key=」，再拼接您的商户密钥 再md5 转为大写
     * @param $params
     * @param $paykey
     * @return void
     */
    public static function asciiKeyStrtoupperSign($params,$paykey,$keyname = 'key'){
        ksort($params);
        $string = [];
        foreach ($params as $key => $value) {
            if ($key == 'sign') continue;
            $string[] = $key . '=' . $value;
        }
        $sign = (implode('&', $string)) . "&$keyname=" . $paykey;

        return strtoupper(md5($sign));
    }

    /**
     * 对签名的数组进行排序，最后追加上key，在md5加密
     * @param $params  签名数组
     * @param $serpaykey key
     * @return string
     */
    public static function curry_sign($params,$serpaykey){
        ksort($params);
        $string = [];
        foreach ($params as $key => $value) {
            if ($key == 'sign') continue;
            $string[] = $key . '=' . $value;
        }
        $sign = (implode('&', $string)) . $serpaykey;

        return strtolower(md5($sign));
    }

    /**
     * CURL请求
     *
     * @param            $url        请求url地址
     * @param            $method     请求方法 get post
     * @param null       $postfields post数据数组
     * @param array      $headers 请求header信息
     * @param bool|false $debug 调试开启 默认false
     *
     * @return mixed
     */
    public static function  httpRequest($url, $method, $postfields = null, $headers = [], $debug = false) {
        $method = strtoupper($method);
        $ci     = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
        curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        switch ($method) {
            case "POST":
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
                }
                break;
            default:
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
                break;
        }
        $ssl = preg_match('/^https:\/\//i', $url) ? true : false;
        curl_setopt($ci, CURLOPT_URL, $url);
        if ($ssl) {
            curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts
            curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false); // 不从证书中检查SSL加密算法是否存在
        }
        //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
        curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);
        /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
        $response    = curl_exec($ci);
        $requestinfo = curl_getinfo($ci);
        $http_code   = curl_getinfo($ci, CURLINFO_HTTP_CODE);
//        if ($debug) {
//            echo "=====post data======\r\n";
//            var_dump($postfields);
//            echo "=====info===== \r\n";
//            print_r($requestinfo);
//            echo "=====response=====\r\n";
//            print_r($response);
//        }
        curl_close($ci);

        return $response;
        //return array($http_code, $response,$requestinfo);
    }



    /**
     * 返回分页数据表的后缀，以及page和limit
     * @param $page 当前第几页
     * @param $limit 分页的数量
     * @param $DBData ['20230315' => 10 ,'20230316' => 20]  分表的后缀加上条数
     * @return array
     */
    public static function pageSelectDBData($page,$limit,$DBData){


        $retData = [];
        $pushIdx = 0;
        $breaked = false;
        $endIdx = $page * $limit;
        $startIdx = ($page - 1) * $limit;

        foreach ($DBData as $k => $v){
            for ($j=0;$j<$v;$j++){
                $pushIdx += 1;
                if($pushIdx >= $startIdx && $pushIdx < $endIdx){
                    array_push($retData,[$k,$j]);
                }
                if($pushIdx > $endIdx){
                    $breaked = true;
                    break;
                }
            }
            if($breaked){
                break;
            }
        }
        $statusarray= [];
        $tablearray = [];

        foreach ($retData as $value){
            if(in_array($value[0],$statusarray)){
                $tablearray[$value[0]]['limit'] += 1;
            }else{
                $tablearray[$value[0]]['page'] = $value[1];
                $tablearray[$value[0]]['limit'] = 1;
                array_push($statusarray,$value[0]);
            }
        }

        return $tablearray;
    }


    /**
     * curl 验证的时候用
     * @param $url
     * @return bool|string
     */
    public static function http_request($url)
    {
        $ch = curl_init();

        //随机生成IP // 百度Spider
        $ip = rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);

        $timeout = 15;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);

        //伪造百度 蜘蛛IP
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-FORWARDED-FOR:' . $ip . '', 'CLIENT-IP:' . $ip . '']);
        //伪造百度 蜘蛛头部
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Baiduspider/2.0; +https://www.baidu.com/search/spider.html)");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取的信息以文件流的形式返回
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    /**
     * @param $time 时间戳
     * @return false|string 获取上个月的今天
     */
    public static function preMonthDay($time)
    {
        $preMonth = mktime(0, 0, 0,
            date("n", $time), 0, date("Y", $time)); //上个月最后一天的时间戳

        $preMonthMaxDay =  date("t", $preMonth);  //上个月的最大天数

        //如果当前月的最大天数大于上个月的最大天数，则以上个月的最大天数为准 比如3月31的上个月今天就是2月28或29
        if ($preMonthMaxDay < date("j", $time)) {
            return date("Y-m-d", $preMonth);
        }

        return date(date("Y-m", $preMonth) . "-d", $time);
    }

    /**
     * https://ip-api.com/docs 文档
     * 通过ip获取地址
     * @param $ip IP地址
     * @return mixed|string
     */
    public static function get_ip_addr($ip)
    {
        $url = 'http://ip-api.com/php/' . $ip . '?lang=zh-CN';

        $res = self::http_request($url);

        $res = unserialize($res);
        if(!$res){
            return '';
        }
        $city = ($res['status'] == 'success')
            ? $res['country'] . '/' . $res['regionName'] . '/' . $res['city']
            : $res['message'];


        return $city;
    }

    /** 第三方储存log
     * @param $ordersn 订单号
     * @param $response  第三方返回参数
     * @param $type  类型:1=充值,2=客户端提现,3=pg,4=后台提现,5=打点,6=短信,7=推广返利提现,8=回调退款失败
     * @return void
     */
    public static function log($ordersn,$response,$type){

        $res=  Db::name('log')->insert(['out_trade_no'=> $ordersn,'log' => json_encode($response),'type'=>$type,'createtime' => time()]);
        if($type == 2 || $type == 4 || $type == 8){
            $withdraw_log = Db::name('withdraw_log')->field('id,uid,money')->where('ordersn',$ordersn)->find();
            Db::name('withdraw_log')->where('ordersn',$ordersn)->update(['status' => 2,'finishtime' => time()]);
            //将三方错误日志，存储到第三张表中,是查询速度快一点
            Db::name('withdraw_logcenter')->where('withdraw_id',$withdraw_log['id'])->update([
                'log_error' => json_encode($response),
            ]);
            //增加用户余额
            \app\common\xsex\User::userEditCoin($withdraw_log['uid'],$withdraw_log['money'],5, "玩家系统处理提现失败" . $withdraw_log['uid'] . "退还提现金额" . bcdiv($withdraw_log['money'],100,2));

        }elseif ($type == 7){
            $withdraw_log = Db::name('withdraw_log')->field('id,uid,money')->where('ordersn',$ordersn)->find();
            //修改订单状态
            Db::name('withdraw_log')->where('ordersn',$ordersn)->update(['status' => 2,'finishtime' => time()]);
            //将三方错误日志，存储到第三张表中,是查询速度快一点
            Db::name('withdraw_logcenter')->where('withdraw_id',$withdraw_log['id'])->update([
                'log_error' => json_encode($response),
            ]);
            //返回推广提现额度
            \app\api\controller\commission\Popularize::setCashCommission($withdraw_log['uid'],$withdraw_log['money'],3);
        }
    }

    /**
     * @param $dirname 目录名
     * @return array|\think\response\Json 上传图片
     */
    public static function uplode($dirname){
        $FILES = $_FILES;

        $path= root_path().'public/uploads/'.$dirname;

        if(!file_exists($path)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($path,0777,true);
        }
        $name = \customlibrary\Common::doOrderSn(789);

        $tmp = isset($FILES['file']['tmp_name']) ? $FILES['file']['tmp_name'] : '';
        if(!$tmp){
            return json(['code' => 201 , 'code' => 'error','data' => []]);
        }
        $file_path = '/uploads/'.$dirname.'/'.$name.'.png';
        if(move_uploaded_file($tmp,$path.'/'.$name.'.png')){
            return ['code' => 200,'msg' => '成功','data' => $file_path];
        }else{
            return ['code' => 201,'msg' => '失败','data' => []];
        }
    }



    /**百度翻译https://api.fanyi.baidu.com/doc/21
     * @param $query  翻译的英文内容
     * @return mixed
     */
    public static function translate($query){
//        $appid = 20230515001678294; //appid
//        $key = 'yN5zpLtS31paGS5ybRoI';  //key
//        $salt = time();  //随机字符串
//        $sign = strtolower(md5($appid.$query.$salt.$key)); //签名
//        $urlquery = urlencode($query);
//        $url = "https://fanyi-api.baidu.com/api/trans/vip/translate?q=$urlquery&from=en&to=zh&appid=$appid&salt=$salt&sign=$sign";
//        $data = file_get_contents($url);
//        $data = json_decode($data,true);
//        if(isset($data['trans_result'])){
//            return $data['trans_result'][0]['dst'];
//        }

//        //测试环境
//        $url = "https://inrtakeoff.3377win.com/api/Text/setPayUserWT?content=".urlencode($query);
//        $res = file_get_contents($url);
        //正式环境
        $key = 'AIzaSyCLZu1Sb7h34I-4Uk1fcwhdDG2gvSYHHAk';
        $url = 'https://translation.googleapis.com/language/translate/v2?key='.$key;
        $headers = array();
        $headers[]='Content-Type: application/json';
        $data = [
            'q'=>$query,
            'source'=>'en',
            'target'=>'zh-CN',
            'format'=>'text',
            'model'=>''
        ];

        $res = Curl::post($url,$data,$headers);
        $info = json_decode($res,true);
        try {
            if(!isset($info['data']['translations'][0]['translatedText'])){
                Log::error('谷歌翻译失败:'.$res);
                return '';
            }
            return $info['data']['translations'][0]['translatedText'];
        }catch (\Exception $e){
            Log::error('谷歌翻译代码bug:'.$e->getMessage());
            Log::error('谷歌翻译失败2:'.$res);
        }

        return '';
    }



    /**
     * 返回指定天数的开始日期
     * @param $days 天数
     * @param $type 类型:1=时间戳 2=日期
     * @param $start 开始的天数  0从今天开始 1表示从昨天开始，2表示从前天开始
     * @return array
     */
    public static function getStartTimes($days,$type = 1,$start = 0){
        $startTimes = array();
        $now = time();
        if($type == 1){
            for ($i = $start; $i < $days; $i++) {
                $startTimes[] = strtotime(date('Y-m-d 00:00:00', $now - 86400 * $i));
            }
        }else{
            for ($i = $start; $i < $days; $i++) {
                $startTimes[] = date('Y-m-d 00:00:00', $now - 86400 * $i);
            }
        }

        return $startTimes;
    }



    /**
     * 对签名的数组进行排序，最后追加上key，在md5加密 转为大写
     * @param $params  签名数组
     * @param $serpaykey key
     * @return string
     */
    public static function ascii_big_sign($params,$serpaykey){
        ksort($params);
        $string = [];
        foreach ($params as $key => $value) {
            if ($key == 'sign') continue;
            $string[] = $key . '=' . $value;
        }
        $sign = (implode('&', $string)) . '&key=' . $serpaykey;

        return strtoupper(md5($sign));
    }



    /**
     * 对签名的数组进行排序，最后追加上key，不需要&key，在md5加密
     * @param $params  签名数组
     * @param $secretKey 私钥
     * @return string
     */
    public static function asciiSignNotKey($params,$secretKey){
        ksort($params);
        $string = [];
        foreach ($params as $key => $value) {
            if ($key == 'sign') continue;
            $string[] = $key . '=' . $value;
        }
        $sign = (implode('&', $string)) . $secretKey;

        return md5($sign);
    }


    /**
     * 根据经纬度获取城邦
     * @param $lng 经度
     * @param $lat 纬度
     * @return mixed|string
     */
    public static function getCityState($lng,$lat){

        $key = 'c578fa5aebcb4ef4adb21521e93c2919';
        $url = "https://api.opencagedata.com/geocode/v1/json?q=$lat+{$lng}&key=$key&language=zh-CN";
        $res = Curl::get($url);
        $result = json_decode($res, true);

        if (isset($result['status']['code']) && $result['status']['code'] == 200) {
            return $result['results'][0]['components']['state'] ?? ''; // 输出：米佐拉姆邦
        } else {
            return '';
        }
    }

    /**将一个数据按照分页来处理
     * @param $page 页数
     * @param $limit  每页多少条数据
     * @param $totalData  原数据
     * @return array
     */
    public static function getData($page,$limit,$totalData){

        // 计算总页数
        $totalPages = ceil(count($totalData) / $limit);
        // 根据页数和限制数量计算起始索引
        $startIndex = ($page - 1) * $limit;


        // 判断页数是否超出范围
        if ($page > $totalPages) {
            $result = []; // 返回空数组
        } else {
            // 根据起始索引和限制数量获取分页数据
            $result = array_slice($totalData, $startIndex, $limit);
        }

        return $result;

    }

    /**
     * 解析三方返回的错误日志
     * @param $error 三方提现错误信息
     * @return void
     */
    public static function getTripartiteErrorInfo($error){
        $error_response = json_decode($error,true);
        if (isset($error_response['error'])){
            $error_parm = $error_response['error'];
        }elseif (isset($error_response['message'])){
            $error_parm = $error_response['message'];
        }elseif (isset($error_response['casDesc'])){
            $error_parm = $error_response['casDesc'];
        }elseif (isset($error_response['errMsg'])){
            $error_parm = $error_response['errMsg'];
        }elseif (isset($error_response['data']['errMsg'])){
            $error_parm = $error_response['data']['errMsg'];
        }elseif (isset($error_response['msg'])){
            $error_parm = $error_response['msg'];
        }else{
            $error_parm = '';
        }
        return $error_parm;
    }
}
