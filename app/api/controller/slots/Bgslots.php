<?php
/**
 * 游戏
 */

namespace app\api\controller\slots;


use app\api\controller\ReturnJson;
use app\Request;
use crmeb\basic\BaseController;
use crmeb\services\HttpService;
use crmeb\services\MqProducer;
use think\facade\Db;
use think\facade\Log;
use curl\Curl;
use customlibrary\Common;
use think\facade\Config;
use think\facade\Validate;
use app\api\controller\slots\Common as slotsCommon;

class Bgslots extends BaseController {

    private static $herder = [
        //'Content-Type: application/x-www-form-urlencoded',
        'Content-Type: application/json',
    ];

    public function bgHttp(Request $request)
    {
        $parm = $request->all();
        Log::error('bgHttp==>'.json_encode($parm, JSON_UNESCAPED_SLASHES));
        Log::error('bgHttp==>data'.$parm['data']);
        $url = $parm['url'];
        $data = json_decode($parm['data'],true);
        Log::error('bgHttp==>$data222'.json_encode($data, JSON_UNESCAPED_SLASHES));

        self::$herder[] = 'X-REQUEST-SIGN:'.$parm['sign'];
        $res = self::senPostCurl($url, $data);
//        $res = HttpService::postRequest($url, $data, self::$herder);
        Log::error('bgHttp res==>'.$res);
        //Log::error('bgHttp res==>'.json_encode($res));

        return json_encode($res);
//        return $res;
    }


    public function getGameUrl(Request $request)
    {
        $parm = $request->all();
        Log::error('$parm res==>'.json_encode($parm));

        //$userinfo = Db::name('userinfo')->where(['uid'=>$parm['uid']])->find();

//        $old_balance = bcadd((string)$userinfo['coin'],(string)$userinfo['bonus']);
        $old_balance = $parm['old_balance'];
        $gameid = $parm['gameid'];

        $config = Config::get('bgslots');

        $url = $config['api_url'].'/sessions';

        $body = [
            'casino_id' => $config['CASINO_ID'],
            'game' => $gameid,
            'currency' => $config['currency'],
            'locale' => $config['language'],
            'ip' => Common::getIp(),
            'client_type' => 'mobile',
            'balance' => (float)$old_balance,
            'urls' => [
                'return_url' => 'http://124.221.1.74/'
            ],
            'user' => [
                'id' => $parm['uid']
            ]
        ];

        //self::$herder['X-REQUEST-SIGN'] = hash_hmac('sha256', json_encode($body), $config['AUTH_TOKEN']);
        self::$herder[] = 'X-REQUEST-SIGN: '.hash_hmac('sha256', json_encode($body), $config['AUTH_TOKEN']);

        $res = self::senPostCurl($url, $body);
        return json_encode($res, JSON_UNESCAPED_SLASHES);

    }


    /******************************转账模式*******************************/

    public static function GetGame(){
        $url = Config::get('bgslots.api_url').'/gamelist';

//        $res = self::senGetCurl($url,[]);
        $res = HttpService::getRequest($url);
        $res = json_decode($res, true);

        if(!isset($res['data'])){
            return ['code' => 201,'msg' => '无数据' ,'data' =>[]];
        }

        return ['code' => 200,'msg' => '' ,'data' =>$res['data']];
    }

    /** 发送Curl
     * @param $url
     * @param $body
     * @return mixed
     */
    private static function senPostCurl($url,$body)
    {
        Log::error('$herder res==>'.json_encode(self::$herder));
        $dataString = Curl::post($url, $body, self::$herder, [], 1);
        Log::error('$dataString res==>'.$dataString);

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
}






