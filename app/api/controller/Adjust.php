<?php
namespace app\api\controller;

use think\facade\Db;
use crmeb\basic\BaseController;
use think\facade\Log;

class Adjust extends BaseController{


    /**
     * @return string 手动打点
     */
    public function manualManagement(){

        $apiToken = 'tyepydmaercw';
        $baseUrl = 'https://dash.adjust.com/api/v1/kpi';

// 定义请求参数
        $params = [
            'start_date' => '2023-01-01', // 起始日期
            'end_date' => '2023-01-31',   // 结束日期
            'kpis' => 'installs,clicks,revenue', // 关键指标
            'grouping' => 'source',       // 分组方式
        ];

// 构建查询字符串
        $queryString = http_build_query($params);

// 完整的请求 URL
        $url = $baseUrl . '?' . $queryString;



        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $apiToken
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
        } else {
            echo $response; // Print the API response
        }

        curl_close($curl);

        $data = json_decode($response, true);
        dd($data);



        exit();
        $uid = input('uid');
        $total_fee = input('total_fee');
        $packname = input('packname');
        $af_puchase = input('af_puchase');
        $afid = input('afid');
        $code=array(
            "appsflyer_id"=>$afid,
            //  "advertising_id"=>"d32657ea-cffc-434a-b3c9-e5f8813c19eb",
            "ip"=>"223.178.209.84",
            "customer_user_id"=>$uid,
            "app_version_name"=>"1.0",
            "eventTime"=>date("Y-m-d H:i:s"),
            "eventName"=>"af_purchase",
            "eventCurrency"=>"INR",
            "os"=>"14.5.1",
            "att"=>3,
            "eventValue"=> array(
                "af_revenue"=> $total_fee,
                "af_currency"=>"INR",
                "af_content_type"=> "wallets",
                "af_content_id"=>"15854",
                "af_quantity"=>"1"
            )
        );

        $header=array(
            "Content-Type: application/json",
            'authentication: '.$af_puchase,
        );
        $response=self::httpRequest1("https://api2.appsflyer.com/inappevent/".$packname,"POST",json_encode($code),$header,false);
        Log::error('response====='.$response);
        dd($response);
        return "success";

        $response=self::httpRequest1("https://s2s.adjust.com/event?s2s=1&event_token=1xw0ge&app_token=mvvyqvaiozk0&gps_adid=ae12b3a6-6322-45c1-89c0-954c438c1314&revenue=100&currency=INR&adid=921f9b5ee130c26946dae142c2ce0d6c","GET",array(),array("Content-Type: application/x-www-form-urlencoded"),true);
        Log::error('response1====='.$response);

        $response=self::httpRequest1("https://s2s.adjust.com/event?s2s=1&event_token=prx8xy&app_token=mvvyqvaiozk0&gps_adid=ae12b3a6-6322-45c1-89c0-954c438c1314&revenue=100&currency=INR&adid=921f9b5ee130c26946dae142c2ce0d6c","GET",array(),array("Content-Type: application/x-www-form-urlencoded"),true);
        Log::error('response2====='.$response);

        return "success";
    }


    /**
     *
     * @param $packname
     * @param $gps_adid
     * @param $adid 这里是adid
     * @param $totalfee
     * @param $is_first_recharge
     * @param $orderinfo
     * @param $shareinfo
     * @param $type 1 = 充值 ， 2= 注册
     * @return void
     */
    public static function adjustUploadEvent($packname, $gps_adid, $adid, $totalfee, $is_first_recharge, $ordersn, $share_strlog,$type = 1)
    {
        $array = [
            //2023-3-22 投放
            "com.exbwp.manmillionaire"=>"s5b93r744268",
        ];
        $event_array = [
            //2023-3-22 投放
            "com.exbwp.manmillionaire"=> ["first"=>"cumx65","nofirst"=>"x5qviz","all_first"=>"1l0za4","all_first_value"=>"tmuq19"],

        ];

        if(!isset($array[$packname])){  //直接返回
            return 1111;
        }

        if($type == 1){  //只打当天用户的点
            if ($is_first_recharge) {
                $response = self::httpRequest1("https://s2s.adjust.com/event?s2s=1&event_token=" . $event_array[$packname]["first"] . "&app_token=" . $array[$packname] . "&gps_adid=" . $gps_adid . "&revenue=" . $totalfee . "&currency=INR&adid=" . $adid, "GET", [], ["Content-Type: application/x-www-form-urlencoded"], false);
                Db::name("log")->insert(['out_trade_no' => 'Adjust打点首次付费回调'.$ordersn, 'type' => 5,'createtime' => time(), "log" => json_encode($response)]);
            } else {
                $response1 = self::httpRequest1("https://s2s.adjust.com/event?s2s=1&event_token=" . $event_array[$packname]["nofirst"] . "&app_token=" . $array[$packname] . "&gps_adid=" . $gps_adid . "&revenue=" . $totalfee . "&currency=INR&adid=" . $adid, "GET", [], ["Content-Type: application/x-www-form-urlencoded"], false);
                Db::name("log")->insert(['out_trade_no' => 'Adjust打点付费回调'.$ordersn, 'type' => 5,'createtime' => time(),"log" => json_encode($response1)]);

            }
        }elseif($type == 2){
            $response1 = self::httpRequest1("https://s2s.adjust.com/event?s2s=1&event_token=" . $event_array[$packname]["CompleteRegistration"] . "&app_token=" . $array[$packname] . "&gps_adid=" . $gps_adid . "&adid=" . $adid, "GET", [], ["Content-Type: application/x-www-form-urlencoded"], false);
            Db::name("log")->insert(['out_trade_no' => 'Adjust注册打点'.$packname, 'type' => 5,'createtime' => time(),"log" => json_encode($response1)]);
        }




    }




    /**
     * Fb打点
     * @return void
     * @param $type 类型: 1 = 支付点 ，2 = 注册点 , 3= 自定义事件名称
     * @param $fbEventName 事件名称
     *
     */
    public static function fbUploadEvent($packname, $totalfee, $is_first_recharge, $ordersn,$uid,$share_strlog = [],$type = 1,$fbEventName = ''){
        // 定义 Pixel ID 和 Access Token
        $fBConfig = [
            'com.win3377.Amzing' => [
                'accessToken' => 'EAAz6lcYgM40BOwyNcMzCaiYKrVT3resCzwcZBTk50Qo3yvi2GRQBDGT8fFEHTY09cOSsf4MMXjGldGkuj6UWd6G2752rv4ncmZA8QyLi9tghZAmQ9kVzNTqgAHkAqFwb4uUijkf5bBFRJGg6eGBmKrzVOTFFHEu7QqpqEh3cI8VWx7CBvzpZBI4azCopwxyRGQZDZD',
                'pixelId' => '513561564339738'
            ],
        ];
        if(!isset($fBConfig[$packname])) return;



        if($type == 2){
            $eventName = 'CompleteRegistration';
            $eventParams = [];
            $remark = 'FB注册打点'.$packname;
        }elseif ($type == 3){
            $eventName = $fbEventName;
            $eventParams = [];
            $remark = "FB".$eventName."打点".$packname;
        }else{
            $eventName = $is_first_recharge  ? 'Purchase' : 'AddPaymentInfo';
            $eventParams = [
                'currency' => 'INR',
                'value' => $totalfee,
                // 添加其他自定义参数
            ];
            $remark = 'FB'.$eventName.'打点付费回调'.$ordersn;
        }






// 构建请求 URL
        $url = 'https://graph.facebook.com/v13.0/' . $fBConfig[$packname]['pixelId'] . '/events';

// 构建请求数据
        $data = [
            'data' => [
                [
                    'event_name' => $eventName,
                    'event_time' => time(),
                    'user_data' => [
                        'client_ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                        'client_user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                        'fbc' => $fbc,
                        'fbp' => $fbp,
                    ],
                    'custom_data' => $eventParams,
                ],
            ],
        ];

// 发送请求
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' .  $fBConfig[$packname]['accessToken'],
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

// 处理响应
        if ($response) {
            Db::name("log")->insert(['out_trade_no' => $remark, 'type' => 5,'createtime' => time(),"log" => $response]);
            $responseData = json_decode($response, true);
            if (isset($responseData['events_received'])) {
                $eventCount = $responseData['events_received'];

//                Log::error('成功发送 ' . $eventCount . ' 个事件。');

            } else {
                Log::error('Fb发送事件失败');
            }
        } else {
            Log::error('Fb发送请求失败.');

        }
        return;
    }

    /**
     * CURL请求
     *
     * @param            $url        请求url地址
     * @param            $method     请求方法 get post
     * @param null       $postfields post数据数组
     * @param array      $headers    请求header信息
     * @param bool|false $debug      调试开启 默认false
     *
     * @return mixed
     */
    private static function httpRequest1($url, $method, $postfields = null, $headers = [], $debug = false)
    {
        $method = strtoupper($method);
        $ci = curl_init();
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
        $ssl = preg_match('/^https:\/\//i', $url) ? TRUE : FALSE;
        curl_setopt($ci, CURLOPT_URL, $url);
        if ($ssl) {
            curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
            curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
        }
        //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
        curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);
        /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
        $response = curl_exec($ci);
        $requestinfo = curl_getinfo($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        if ($debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);
            echo "=====info===== \r\n";
            print_r($requestinfo);
            echo "=====response=====\r\n";
            print_r($response);
        }
        curl_close($ci);
        return $response;
        //return array($http_code, $response,$requestinfo);
    }

    /** AF打点
     * @param $packname
     * @param $gps_adid
     * @param $adid 这里是afid
     * @param $totalfee
     * @param $is_first_recharge
     * @param $ordersn
     * @param $share_strlog
     * @param $type 1 = 支付 ，2 = 注册
     * @return void
     */
    public static function afUploadEvent($packname, $gps_adid, $adid, $totalfee, $is_first_recharge, $ordersn, $share_strlog,$type = 1){
        $array = [
            //2023-6-15投放
            "com.mzfasfk.lffutxovqmeaq"  => 'rxC9SU7YVKVyQRuDXfAiNU',
        ];
        if(!isset($array[$packname])){  //直接返回
            return 1111;
        }

        $header=array(
            "Content-Type: application/json",
            'authentication: '.$array[$packname],
        );

        //1 = 支付 , 2 = 注册
        if($type == 1){
            $eventValue = array(
                "af_revenue"=> $totalfee,
                "af_currency"=>"INR",
                "af_content_type"=> "wallets",
                "af_content_id"=>"15854",
                "af_quantity"=>"1"
            );
            $eventName = 'af_purchase';
        }else{
            $eventValue = [];
            $eventName = 'CompleteRegistration';
        }

        $code=array(
            "appsflyer_id"=>$adid,
            "ip"=>$share_strlog["login_ip"],
            "customer_user_id"=>$share_strlog['uid'],
            "app_version_name"=>"1.0",
            "eventTime"=>date("Y-m-d H:i:s"),
            "eventName"=>$eventName,
            "eventCurrency"=>"INR",
            "os"=>"14.5.1",
            "att"=>3,
            "eventValue"=> $eventValue,
        );
        $response = self::httpRequest1("https://api2.appsflyer.com/inappevent/".$packname,"POST",json_encode($code),$header,false);
        Db::name("log")->insert(['out_trade_no' => $type == 1 ? 'AF打点付费回调'.$ordersn : 'AF注册打点'.$packname, 'type' => 5,'createtime' => time(), "log" => json_encode($response)]);

    }




}
