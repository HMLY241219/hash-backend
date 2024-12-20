<?php

namespace crmeb\repositories;


use app\admin\model\sms\SmsRecord;
use crmeb\services\HttpService;
use crmeb\services\sms\Sms;
use think\facade\Log;

/**
 * 短信发送
 * Class ShortLetterRepositories
 * @package crmeb\repositories
 */
class ShortLetterRepositories
{
    /**
     * 发送短信
     * @param $switch 发送开关
     * @param $phone 手机号码
     * @param array $data 模板替换内容
     * @param string $template 模板编号
     * @param string $logMsg 错误日志记录
     * @return bool|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function send($switch, $phone, array $data, string $template, $logMsg = '')
    {
        if ($switch && $phone) {
            $formData = array(
                "appId" => "Btv7LMEW",
                "numbers" => '55'.$phone,
                "content"=>urlencode("GoCard: login code : ".$data['code'])
            );
            $time=time();
            $sign=md5("NTKyaG0gy2wzGNtL".$time);
            $send_header = array(
                "Content-Type: application/json;charset=UTF-8",
                "Timestamp:".$time,
                "sign:".$sign,
                "Api-Key:NTKyaG0g"
            );
            $res=HttpService::httpRequest("https://api.onbuka.com/v3/sendSms", "POST",json_encode($formData),$send_header,false);
            $res=json_decode($res,true);
            if (!isset($res['status']) || $res['status'] != 0) {
                $errorSmg = 'send error';
                //Log::info($logMsg ?? $errorSmg.'返回信息==>'.json_encode($res));
                Log::info($errorSmg.'返回信息==>'.json_encode($res));
                return $errorSmg;
            } else {
                SmsRecord::sendRecord($phone, urlencode("GoCard: login code : ".$data['code']), $data['code'], $res['array'][0]['msgId']);
            }
            return true;
        } else {
            return false;
        }
    }
}