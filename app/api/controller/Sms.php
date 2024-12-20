<?php
namespace app\api\controller;

use customlibrary\Common;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use think\facade\Config;
use think\facade\Db;
use crmeb\basic\BaseController;
use think\facade\Log;

class Sms extends BaseController {

    /**
     * 发送验证码
     * @return void
     */
    public function code(){

        $phone = input('phone');
        $randnum = mt_rand(1000,9999);

        //检查手机号是否正确
        if (!Common::PregMatch($phone,'phone'))return ReturnJson::failFul(206);

        $result  = self::onbukaSendCode($phone, $randnum);

        if($result)
        {
            self::savecode($phone,$randnum);
            return ReturnJson::successFul();
        }else{

            return ReturnJson::failFul(215);
        }
    }



    /**
     * @param $phone 电话
     * @param $randnum 验证码
     * @return void
     * @throws \RedisException
     */
    public static function savecode($phone,$randnum){
        $redis = new \Redis();
        $redis->connect(config('redis.ip'), config('redis.port0'));
        $redis->hSet("PHONE_ACCOUNT_CODE", $phone, $randnum);
    }

    /**
     * 效验验证码是否正确
     * @return
     */
    public function effectivenessCode(){
        $phone = input('phone');
        $code = input('code');
        $redis = new \Redis();
        $redis->connect(config('redis.ip'), config('redis.port0'));
        $redisCode = $redis->hGet("PHONE_ACCOUNT_CODE", $phone);
        if($redisCode != $code)return ReturnJson::failFul(209);
        return ReturnJson::successFul();
    }


    public function getcode(){

        $phone = input('phone');

        $redis = new \Redis();
        $redis->connect('172.31.36.176', 5501);
        $code = $redis->hGet("PHONE_ACCOUNT_CODE", $phone);
        return $code;
    }

    /**
     * 发送短信
     * @param $phone 电话
     * @param $type 类型
     * @param $data 自定义数据
     * @return array|void
     */
    public static function sendSms($phone,$type,$data){
        $content = Config::get('my.smsContentConfig')[$type] ?? '';
        if(!$content){
            return ['code' => 201,'msg' => 'system error','data' => []];
        }
        $smsContent = self::getContent($content['content'],$type,'',$data);

        self::onbukaSendCode($phone,$smsContent,'h1NOo5eg');
    }



    /**
     * @return bool 天哄一短信
     */
    public static function onbukaSendCode($phone,$content,$appId = "Btv7LMEW"){
        return true;
        header('content-type:text/html;charset=utf8');

        $apiKey = "NTKyaG0g";
        $apiSecret = "y2wzGNtL";

        $url = "https://api.itniotech.com/sms/sendSms";

        $timeStamp = time();
        $sign = md5($apiKey.$apiSecret.$timeStamp);

        $dataArr['appId'] = $appId;
        $dataArr['numbers'] = '55'.$phone;
        $dataArr['content'] = $content;
        $dataArr['senderId'] = '';


        $data = json_encode($dataArr);
        $headers = array('Content-Type:application/json;charset=UTF-8',"Sign:$sign","Timestamp:$timeStamp","Api-Key:$apiKey");

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 600);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS , $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//       {"status":"0","reason":"success","success":"1","fail":"0","array":[{"msgId":"2304252117461165117","number":"918066778800","orderId":null}]}
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output,true);
        if(!isset($data['status']) || $data['status'] != 0){
            \customlibrary\Common::log(0,$output,6);
            return false;
        }
        return true;
        var_dump($output);
    }


    /**
     * 群发
     * @param $phone  以逗号分隔，最多1000
     * @param $downurl 下载地址
     * @return true
     */
    public static function bulkSending($phones,$downurl){

        header('content-type:text/html;charset=utf8');

        $appId = "h1NOo5eg";
        $apiKey = "mw2aq65hHx7bmUNVg6ZBEZQT7G61iCaw";
        $apiSecret = "NWn5fBIfl2tGQX3l8f4jePkSlyVAPL9f";

        $url = "https://api.itniotech.com/sms/sendSms";

        $timeStamp = time();
        $sign = md5($apiKey.$apiSecret.$timeStamp);

        $dataArr['appId'] = $appId;
        $dataArr['numbers'] = implode(',',$phones);
//        $dataArr['content'] = "We will Send Rs 76,535 cash & win iphone 15 in your gaming wallet. Cpn- Just recharge and get it. Know more:$downurl";
        $dataArr['content'] = "[3377win]Play and win! Enjoy special top-up activities, millions of bonuses are waiting for you to win! Learn more:$downurl";
        $dataArr['senderId'] = "722222";


        $data = json_encode($dataArr);
        $headers = array('Content-Type:application/json;charset=UTF-8',"Sign:$sign","Timestamp:$timeStamp","Api-Key:$apiKey");

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 600);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS , $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//       {"status":"0","reason":"success","success":"1","fail":"0","array":[{"msgId":"2304252117461165117","number":"918066778800","orderId":null}]}
        $output = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($output,true);

        if(!isset($data['status']) || $data['status'] != 0){
            Log::error('群发失败:'.$output);
            \customlibrary\Common::log(0,$output,6);
            return false;
        }
        return true;
        var_dump($output);
    }


    /**
     * 发送多个用户邮箱
     * @param $senddata  发送邮件数据 [['email' => '2404331152@qq.com','nickname' => '仇浩宇'],['email' => '546278987@qq.com','nickname' => '杨宇平']]
     * @param $type string  $type firstcharge = 首充邮箱发送   emailcode = '邮箱验证码'
     * @return bool
     * @throws \Exception
     */


    public static function allSendEmali($senddata = [],$content = '', string $type = 'firstcharge'){

        if(!$senddata){
            // $senddata =[['email' => '2404331152@qq.com','nickname' => '仇浩宇'],['email' => '546278987@qq.com','nickname' => '杨宇平']];
            return ['code' => 200,'msg' => 'success','data' => []];
        }
        $content = "[3377win]Play and win! Enjoy special top-up activities, millions of bonuses are waiting for you to win! Learn more:$content";

        $mail = new PHPMailer(true);
        $config_email = Config::get('my.email');
        try {
            //配置SMTP服务器信息
            $mail->isSMTP();
            //$mail->isHTML(true);
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Host = $config_email['smtp'];
            $mail->SMTPAuth = true;
            //$mail->SMTPSecure = 'tls';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;//'ssl';
            $mail->Port = $config_email['smtpport'];
            $mail->Username = $config_email['setUsername'];
            $mail->Password = $config_email['setPassword'];
            //$url = root_path().'/public/h5/sms/sms.html';
            foreach ($senddata as $v){
                /*$html = file_get_contents($url);
                $html = str_replace("{nickname}", $v['nickname'], $html);
                $content = Config::get('my.emailContentConfig')[$type] ?? '';
                if(!$content){
                    return ['code' => 201,'msg' => 'system error','data' => []];
                }
                $htmlcontent = self::getContent($content['content'],$type,$v['email']);
                $html = str_replace("{content}", $htmlcontent, $html);
                $html = str_replace("{code}",  '', $html);*/
                //配置邮件信息
                $mail->setFrom($config_email['setfrom'], $config_email['setfromname']);
                //$mail->addAddress($v['email'], $v['nickname']);
                $mail->addAddress($v, 'Mr');
                //$mail->Subject =$content['subject'];
                $mail->Subject = 'Withdrawal Notice';
                //$mail->Body = $html;
                $mail->Body = $content;
                $mail->ContentType = 'text/html';
                //发送邮件
                $mail->send();
                // 重置邮件内容
                $mail->ClearAddresses();
                $mail->Subject = '';
                $mail->Body = '';
            }


            //return ['code' => 200,'msg' => 'success','data' => []];
            return true;
        } catch (\Exception $exception) {
            Log::error('邮件 fail==>'.$exception->getMessage());
            //return ['code' => 201,'msg' => 'error','data' => []];
            return  false;
        }
    }


}
