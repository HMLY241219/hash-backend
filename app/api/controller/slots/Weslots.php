<?php
/**
 * 游戏
 */

namespace app\api\controller\slots;


use crmeb\basic\BaseController;
use think\facade\Db;
use think\facade\Log;
use curl\Curl;
use customlibrary\Common;



class Weslots extends BaseController {

    private static $herder = ["Content-Type: application/x-www-form-urlencoded"];

    public static function GetGame(){
        $url = config('weslots.api_url').'/game/gamelist';
        $herder = self::$herder;
        $body = [
            'operatorID' => config('weslots.operatorID'),
            'requestTime' => (int)time(),
            'gamecategory' => 'Live',
        ];
        $herder[] = 'signature: '.self::sign($body);
        $dataString = Curl::post($url,$body,$herder,[],2);
        $data = json_decode($dataString,true);
        if(!isset($data['data']))return ['code' => 201,'msg' => $dataString];
        return ['code' => 200 ,'msg' => '成功','data' => $data['data']];
    }

    private static function sign($body){
        ksort($body);
        return md5(config('weslots.appSecret').implode('',$body));
    }

}







