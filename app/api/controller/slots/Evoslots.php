<?php
/**
 * 游戏
 */

namespace app\api\controller\slots;


use crmeb\basic\BaseController;

use curl\Curl;




class Evoslots extends BaseController {

    private static $herder = ["Content-Type: application/x-www-form-urlencoded"];

    public static function GetGame(){
        $url = config('evoslots.game_list_api').'/api/lobby/v1/'.config('evoslots.casinoKey').'/tablelist';

        $herder = ["Authorization: Basic ".base64_encode(config('evoslots.casinoKey').':'.config('evoslots.apiToken'))];

        $dataString = self::get($url,$herder);

        $data = json_decode($dataString,true);
        if(!isset($data['data']))return ['code' => 201,'msg' => $dataString];
        return ['code' => 200 ,'msg' => '成功','data' => $data['data']];
    }

    private static function get($url,$hereder = [])
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $hereder);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;

    }

}







