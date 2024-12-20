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

class Jdbslots extends BaseController {

    public function jdbHttp(Request $request)
    {
        $parm = $request->all();
        $url = $parm['url'];
        $res = self::senGetCurl($url, []);

        return json_encode($res);
    }


    /******************************转账模式*******************************/

    private static $herder = [
        //'Content-Type: application/x-www-form-urlencoded',
        'Content-Type: application/json',
    ];

    public static function GetGame(){
        $url = Config::get('jdbslots.api_url');
        $dc = Config::get('jdbslots.Dc');
        $iv = Config::get('jdbslots.Iv');
        $key = Config::get('jdbslots.Key');
        $parent = Config::get('jdbslots.parent');
        $lang = Config::get('jdbslots.language');

        $data = [
            'action' => 49,
            'ts' => round(microtime(true) * 1000),
            'parent' => $parent,
            'lang' => $lang
        ];
        $encryptData = self::encrypt(json_encode($data), $key, $iv);
        $url_data = [
            'dc' => $dc,
            'x' => $encryptData
        ];

        $res = self::senPostCurl($url,$url_data);

        if(!$res || $res['status'] !== '0000'){
            return ['code' => 201,'msg' => $res['err_text'] ,'data' =>[]];
        }

        return ['code' => 200,'msg' => '' ,'data' =>$res['data']];
    }





    /**
     * 获取游戏启动url
     * @param $uid  用户的uid
     * @param $gameid  游戏的id
     * @return array
     */
    public static function getGameUrl($uid,$gameid){
        $token = Db::name('user_token')->where('uid',$uid)->value('token');
        if (empty($token)){
            return ['code' => 201,'msg' => 'fel' ,'data' =>''];
        }

        $url = Config::get('jlslots.api_url').'/singleWallet/Login';
        $data = [
            'Token' => $token,
            'GameId' => $gameid,
            'Lang' => Config::get('jlslots.language'),
            'AgentId' => Config::get('jlslots.AgentId'),
        ];


        $data['Key'] = self::getKey($data);
        $gameUrl =  Curl::getUrl($url,$data,[]);
        $gameUrl = $gameUrl.'&HomeUrl=https://closewebview/';

        return ['code' => 200,'msg' => 'success' ,'data' =>$gameUrl];

    }

    /**
     * @return void  将用户踢下线
     *  @param $uid  用户的uid
     */
    public static function KickMember($uid){
        $url = Config::get('jlslots.api_url').'/KickMember';
        $data = [
            'Account' => $uid,
            'AgentId' => Config::get('jlslots.AgentId'),
        ];

        $data['Key'] = self::getKey($data);
        self::senPostCurl($url,$data);//这里不用判断用户是否真被提下线了，直接掉转出接口
    }


    public static function encrypt($data, $key, $iv)
    {
        $data = self::padString($data);
        $encrypted = openssl_encrypt($data, 'AES-128-CBC', $key, OPENSSL_NO_PADDING, $iv);
        $encrypted = base64_encode($encrypted);
        $encrypted = str_replace(array('+','/','=') , array('-','_','') , $encrypted);
        return $encrypted;
    }

    private static function padString($source)
    {
        $paddingChar = ' ';
        $size = 16;
        $x = strlen($source) % $size;
        $padLength = $size - $x;
        for ($i = 0;$i < $padLength;$i++)
        {
            $source .= $paddingChar;
        }
        return $source;
    }


    /**
     * Key = {6 个任意字符} + MD5(所有请求参数串 + KeyG) + {6 个任意字符}
     * @param $body 请求体
     * @return string 获取hash
     */
    private static function getKey($body){
        $querystring = self::getQueryString($body);
        $KeyG = self::KeyG();

        return self::reallyKey($querystring,$KeyG);

    }

    /**
     * 生成44位的key
     * @param $querystring querystring 字符串
     * @param $KeyG KeyG字符串
     * @return string
     */
    private static function reallyKey($querystring,$KeyG,$count = 1){
        $key = rand(111111,999999).md5($querystring.$KeyG).rand(111111,999999);
        if(strlen($key) != 44 && $count <= 3){  //请求3次，如果3次都不行的话，就直接返回
            $count = $count + 1;
            self::reallyKey($querystring,$KeyG,$count);
        }
        return $key;
    }

    /**
     * @return void 获取keyg字符串
     *
     */
    private static function KeyG(){
        return md5(self::getDateTimeNow().Config::get('jlslots.AgentId').Config::get('jlslots.AgentKey'));
    }


    /**
     * DateTime.Now = 当下 UTC-4 时间, 格式為 yyMMd
     *  年: 公元年分末两位
     月: 两位数, 1~9 前面須补 0
     日: 一位数或两位数, 1~9 前面请不要补 0
     * 例如：2018/2/7 => 18027（7 号是 7 不是 07）
    2018/2/18 => 180218
     * @return string
     */
    private static function getDateTimeNow() {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $now->modify('-4 hours');

        $year = $now->format('y');
        $month = $now->format('m');
        $day = $now->format('j');
        // 格式化月份和日期
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $day = strval($day);

        if ($day[0] === '0') {
            $day = substr($day, 1);
        }

        return $year . $month . $day;
    }


    /**
     * 依照 API 参数列表，按顺序以 key1=value1&key2=value2 格式串起：所有 API 的请求参数字符串最后都要加上 AgentId=xxx
     * 例如Test1&GameId=101&Lang=zh-CN&AgentId=10081
     * 获取getQueryString 数据
     * @param $body 请求的数据
     * @return string
     */
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
        $dataString =  Curl::get($url,$body,$urlencodeData);
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






