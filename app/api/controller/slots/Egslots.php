<?php
/**
 * 游戏
 */

namespace app\api\controller\slots;


use app\api\controller\ReturnJson;
use app\Request;
use crmeb\basic\BaseController;
use crmeb\services\MqProducer;
use think\facade\Db;
use think\facade\Log;
use curl\Curl;
use customlibrary\Common;
use think\facade\Config;
use think\facade\Validate;
use app\api\controller\slots\Common as slotsCommon;

class Egslots extends BaseController {



    private static $herder = [
        'Content-Type: application/x-www-form-urlencoded',
    ];

    public static function GetGame(){


        $url = Config::get('egslots.api_url').'/777bet/games';
        $data = [
            'AgentName' => Config::get('egslots.Agent'),
        ];
        $data['Hash'] = self::getKey($data,'get');
        $res = self::senGetCurl($url,$data);

        if(!$res || isset($res['ErrorCode'])){
            return ['code' => 201,'msg' => $res['Message'] ,'data' =>[]];
        }

        return ['code' => 200,'msg' => 'ok' ,'data' =>$res['Data']];
    }


    /**
     * body数据
     * @param $body
     * @return string hmac-sha256数据
     */
    private static function getKey($body,$type){
        if ($type == 'get'){
            $body = self::getQueryString($body);
        }else {
            $body = json_encode($body);
        }
        $key = Config::get('egslots.Hash_key');
        $hash = hash_hmac('sha256', $body, $key);
        return $hash;
    }

    private static function getQueryString($body){
        $string = [];
        foreach ($body as $key => $value) {
            if ($key == 'sign') continue;
            $string[] = $key . '=' . $value;
        }
        return implode('&', $string);

    }

    /** 发送Curl
     * @param $url
     * @param $body
     * @return mixed
     */
    private static function senPostCurl($url,$body)
    {
        $dataString = Curl::post($url, $body, self::$herder, [], 2);

        return json_decode($dataString, true);

    }

    /** 发送Curl
     * @param $url
     * @param $body
     * @return mixed
     */
    private static function senGetCurl($url,$body,$urlencodeData = []){
        //$dataString =  Curl::get($url,$body,$urlencodeData);
        $url = Curl::getUrl($url,$body);
        //dd($url);
        $dataString =  Common::httpRequest($url, 'GET');
        return json_decode($dataString, true);

    }

    /**格式: YYYY-MM-DDThh:mm:ss, 例如
    2021-01-01T03:00:00。请用 GMT-4 时区的时间。
     * @param $time 时间戳
     * @return false|string
     */
    private static function getUtc4tDate($time){

        return gmdate('Y-m-d\TH:i:s', $time - (4 * 3600)); // 转换为GMT-4时区的时间

    }

    /**
     * 将游戏数据时区转为巴西或者中国时区
     * @param $date
     * @return void
     * @throws \Exception
     */
    public static function getTime($date){
        $datetime = new \DateTime($date, new \DateTimeZone('UTC')); // 创建DateTime对象，并设置时区为UTC

//        // 转换为巴西时间
//        $brazilTimezone = new \DateTimeZone('America/Sao_Paulo'); // 巴西时区
//        $datetime->setTimezone($brazilTimezone); // 设置时区为巴西时区
//        $Time = $datetime->format('y-m-d H:i:s'); // 格式化为yy-mm-dd hh:ii:ss

        // 转换为中国时间
        $chinaTimezone = new \DateTimeZone('Asia/Shanghai'); // 中国时区
        $datetime->setTimezone($chinaTimezone); // 设置时区为中国时区
        $Time = $datetime->format('y-m-d H:i:s'); // 格式化为yy-mm-dd hh:ii:ss

        return strtotime($Time);
    }
}






