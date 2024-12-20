<?php
namespace pay;

use app\admin\model\system\SystemConfig;
use service\TelegramService;
use think\facade\Db;
use curl\Curl;



class Withdraw{




    //goopago_pay
    private static $goopagopay_url        = "http://47.88.18.111:13020/api/unified/agentpay/apply";                 //测试下单地址
//    private static $goopagopay_url        = "https://pay.goopago.com/api/unified/agentpay/apply";                 //正式下单地址
    private static $goopagopay_merNo = 20000070;      //测试商户号
//    private static $goopagopay_merNo = 20000286;    //正式商户号
//
    private static $goopagopay_notifyUrl  = "http://118.195.240.11:5002/api/Withdrawlog/goopagopayNotify";  //测试回调地址
//    private static $goopagopay_notifyUrl  = "https://777bet.homes/api/Withdrawlog/goopagopayNotify";  //正式回调地址
    private static $goopagopay_Key        = "DGM3OFOLWS8DPPEEWEV73O0KP3WLOYL1XAVRIIEKAWWHUJ2I099ASVUS7V3DG0UFM14I8HTZR1YOQHOFJ0JX98J3PUCVXDSB5XCRBME9MXHBYF8MQN0L7DLDHGCK2KSZ";  //测试key
//    private static $goopagopay_Key        = "NYXPTHXZPOQZSROQWS4QBCBWGCGMZ3FY2VANJSIPJXFD1TAOQJRH6ELO2TVFU4KQGQ6EGW3ZGDLESIBWFIROP05XR6FFPDBG8RGFQILPMLOSH30RIBEOX4HP6A63V6PW";  //正式key



    //cashpag_pay
    private static $cashpagpay_url        = "https://pix.cashpag.com/open-api/pay/transfer_fast";                 //下单地址
    private static $cashpagpay_appid = 715114350368;      //appid
    private static $cashpagpay_notifyUrl  = "http://118.195.240.11:5002/api/Order/cashpagpayNotify";  //回调地址
    private static $cashpagpay_Key        = "skf8ab2ew801wiqr9vvhakcp2y4nvq9dnc";  //key




    private static $header = array(
        "Content-Type: application/x-www-form-urlencoded",
    );

    private static $zr_header = array(
        "Content-Type: application/json",
    );


    /**
     * @return void 统一提现接口
     * @param $paytype 提现渠道
     * @param $withdrawdata 创建提现订单信息
     */
    public static function withdraw($withdrawdata,$paytype,$type){

        $res = self::$paytype($withdrawdata,$type);
        return $res;
    }


    /**
     * goopago_pay
     * @param $withdrawlog 用户提现数据
     * @return array
     */
    public static function goopago_pay($withdrawlog,$type) {
        //数据库中 类型:1=CPF,2=CNPJ,3=EMAIL,4=PHONE,5=EVP
        $accountType = [1 => 1, 2=> 2 , 3 => 3, 4 => 4 , 5=> 5];  //数据库提现账户类型 与 四方账户类型对应

        $data = [
            'mchId' => self::$goopagopay_merNo,
            'nonceStr' => (string)time(), //随机字符串
            'mchOrderNo' => $withdrawlog['ordersn'],
            'notifyUrl' => self::$goopagopay_notifyUrl,
            'amount' => (int)$withdrawlog['really_money'],
            'accountNo' => $withdrawlog['type'] == 4 ?  '+55'.$withdrawlog['bankaccount'] : $withdrawlog['bankaccount'],  //如果是手机号的话，提现信息需要+55
            'accountType' => $accountType[$withdrawlog['type']],
            'remark' => 'withdraw',
//            'idNumber' => $withdrawlog['cpf'],
        ];
        $data['sign'] = \customlibrary\Common::ascii_big_sign($data,self::$goopagopay_Key);
        self::$zr_header[] = 'tmId: br_auto';

        $response = Curl::post(self::$goopagopay_url,$data,self::$zr_header);
        $response = json_decode($response, true);


        if (isset($response['resCode']) && $response['resCode'] == "SUCCESS"  && isset($response['status']) && $response['status'] != 3) {
            return ['code' => 200 , 'msg' => '' , 'data' => $response['orderId']];
        }

        \customlibrary\Common::log($withdrawlog['ordersn'],$response,$type);
        $msg = self::sendWithdrawFail($withdrawlog,$response); //通知群并返回错误信息


        return ['code' => 201 , 'msg' => $msg , 'data' => []];

    }


    /**
     * cashpag_pay
     * @param $withdrawlog 用户提现数据
     * @return array
     */
    public static function cashpag_pay($withdrawlog,$type) {
        //数据库中 类型:1=CPF,2=CNPJ,3=EMAIL,4=PHONE,5=EVP
        $accountType = [1 => 'CPF', 2=> 'CNPJ' , 3 => 'EMAIL', 4 => 'PHONE' , 5=> 'RANDOM'];  //数据库提现账户类型 与 四方账户类型对应

        $data = [
            'amount' => (int)$withdrawlog['really_money'],
            'merchantOrderId' => $withdrawlog['ordersn'],
            'notifyUrl' => self::$cashpagpay_notifyUrl,
            'customerName' => self::generateRandomString(),
            'customerCert' => $withdrawlog['cpf'],
            'accountNum' => $withdrawlog['type'] == 4 ?  '+55'.$withdrawlog['bankaccount'] : $withdrawlog['bankaccount'],  //如果是手机号的话，提现信息需要+55
            'accountType' => $accountType[$withdrawlog['type']],

        ];
        self::$zr_header[] = 'Authorization: Basic '.base64_encode(self::$cashpagpay_appid.':'.self::$cashpagpay_Key);

        $response = Curl::post(self::$cashpagpay_url,$data,self::$zr_header);
        $response = json_decode($response, true);


        if (isset($response['code']) && $response['code'] == "200") {
            return ['code' => 200 , 'msg' => '' , 'data' => $response['orderId']];
        }

        \customlibrary\Common::log($withdrawlog['ordersn'],$response,$type);
        $msg = self::sendWithdrawFail($withdrawlog,$response); //通知群并返回错误信息


        return ['code' => 201 , 'msg' => $msg , 'data' => []];

    }

    private static function sendWithdrawFail($withdrawlog,$response){
        $msg = '';
        if(SystemConfig::getConfigValue('is_tg_send') == 1) {
            //发送提现失败消息to Tg
            $msg = \service\TelegramService::withdrawFail($withdrawlog, $response);
        }
        return $msg;
    }


    /**
     * 随机生产几位字母
     * @param $length
     * @return string
     */
    private static function generateRandomString($uid = '',$length = 6){

        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString.$uid;

    }
}