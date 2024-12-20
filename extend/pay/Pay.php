<?php
namespace pay;

use curl\Curl;

class Pay{




    //goopago_pay
    private static $goopagopay_url        = "http://47.88.18.111:13020/api/unified/collection/create";                 //测试下单地址
//    private static $goopagopay_url        = "https://pay.goopago.com/api/unified/collection/create";                 //正式下单地址
    private static $goopagopay_merNo = 20000070;      //测试商户号
//    private static $goopagopay_merNo = 20000286;    //正式商户号

    private static $goopagopay_notifyUrl  = "http://1.13.81.132:5009/api/Order/goopagopayNotify";  //回调地址
//    private static $goopagopay_notifyUrl  = "https://777bet.homes/api/Order/goopagopayNotify";  //回调地址
    private static $goopagopay_Key        = "DGM3OFOLWS8DPPEEWEV73O0KP3WLOYL1XAVRIIEKAWWHUJ2I099ASVUS7V3DG0UFM14I8HTZR1YOQHOFJ0JX98J3PUCVXDSB5XCRBME9MXHBYF8MQN0L7DLDHGCK2KSZ";  //测试key
//    private static $goopagopay_Key        = "NYXPTHXZPOQZSROQWS4QBCBWGCGMZ3FY2VANJSIPJXFD1TAOQJRH6ELO2TVFU4KQGQ6EGW3ZGDLESIBWFIROP05XR6FFPDBG8RGFQILPMLOSH30RIBEOX4HP6A63V6PW";  //正式key



    //cashpag_pay
    private static $cashpagpay_url        = "https://pix.cashpag.com/open-api/pay/payment";                 //下单地址
    private static $cashpagpay_appid = 715114350368;      //appid
    private static $cashpagpay_notifyUrl  = "http://1.13.81.132:5009/api/Order/cashpagpayNotify";  //回调地址
    private static $cashpagpay_Key        = "skf8ab2ew801wiqr9vvhakcp2y4nvq9dnc";  //key




    private static $header = array(
        "Content-Type: application/x-www-form-urlencoded",
    );

    private static $zr_header = array(
        "Content-Type: application/json",
    );


    private static $email = 'green777@gmail.com';
    /**
     * @return void 统一支付渠道
     * @param $paytype 支付渠道
     * @param $createData 创建订单信息
     */
    public static function pay($paytype,$createData){
        self::$email = self::getEmail();
        $res = self::$paytype($createData);
        return $res;
    }


    /**
     * goopago_pay
     *
     * @param $createData 创建订单信息

     *
     * @return array
     */
    public static function goopago_pay($createData) {
        $data = [
            'mchId' => self::$goopagopay_merNo,
            'nonceStr' => (string)time(), //随机字符串
            'mchOrderNo' => $createData['ordersn'],
            'notifyUrl' => self::$goopagopay_notifyUrl,
            'amount' => (int)$createData['price'],
            'body' => 'pay',
            'email' => $createData['email'] ?: self::$email,
            'payType' => 140,
            'idNumber' => $createData['usercpf'],
        ];
        $data['sign'] = \customlibrary\Common::ascii_big_sign($data,self::$goopagopay_Key);
        self::$zr_header[] = 'tmId: br_auto';

        $response = Curl::post(self::$goopagopay_url,$data,self::$zr_header);

        $response = json_decode($response, true);

        if (isset($response['resCode'])&&$response['resCode'] == "SUCCESS") {
            $paydata = self::getPayData($response['orderId'],$response['url']);
            return ['code' => 200 , 'msg' => '' , 'data' => $paydata];
        }

        \customlibrary\Common::log($createData['ordersn'],$response,1);

        return ['code' => 201 , 'msg' => '' , 'data' => []];
    }


    /**
     * cashpag_pay
     *
     * @param $createData 创建订单信息
     *
     * @return array
     */
    public static function cashpag_pay($createData) {
        $data = [
            'amount' => (int)$createData['price'],
            'merchantOrderId' => $createData['ordersn'],
            'notifyUrl' => self::$cashpagpay_notifyUrl,
        ];

        self::$zr_header[] = 'Authorization: Basic '.base64_encode(self::$cashpagpay_appid.':'.self::$cashpagpay_Key);

        $response = Curl::post(self::$cashpagpay_url,$data,self::$zr_header);

        $response = json_decode($response, true);

        if (isset($response['code'])&&$response['code'] == "200") {
            $paydata = self::getPayData($response['orderId'],$response['payUrl']);
            return ['code' => 200 , 'msg' => '' , 'data' => $paydata];
        }

        \customlibrary\Common::log($createData['ordersn'],$response,1);

        return ['code' => 201 , 'msg' => '' , 'data' => []];
    }

    /**
     * 随机生产几位字母
     * @param $length
     * @return string
     */
    private static function generateRandomString($uid= '',$length = 6){

        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString.$uid;

    }

    /**
     * 给充值用户随机生产email
     * @param $length
     * @return string
     */
    private static function getEmail(){
        $num = rand(1,2);
        $shuff = $num == 1 ? '@gmail.com' : '@outlook.com';
        $RandomString = self::generateRandomString(rand(1000,9999),6);
        return $RandomString.$shuff;
    }

    /**
     * 得到支付数据
     * @param $tradeodersn 三方订单号
     * @param $payurl 三方h5支付链接
     * @param $appPayUrl 三方APP支付链接
     * @return void
     */
    private static function getPayData($tradeodersn,$payurl,$appPayUrl = ''){
        return ['tradeodersn' => $tradeodersn,'payurl'=>$payurl,'appPayUrl' => $appPayUrl];
    }

}