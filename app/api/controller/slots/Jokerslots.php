<?php
/**
 * 游戏
 */

namespace app\api\controller\slots;


use crmeb\basic\BaseController;

use curl\Curl;




class Jokerslots extends BaseController {

    private static $herder = ["Content-Type: application/json"];

    public static function GetGame(){
        $url = config('jokerslots.api_url').'/list-games';
        $body = [
            'AppID' => config('jokerslots.appId'),
            'Timestamp' => (int)round(microtime(true) * 1000),
        ];


        $body['Hash'] = self::getHash($body);

        $dataString = Curl::post($url,$body,self::$herder);

        $data = json_decode($dataString,true);

        if(!isset($data['ListGames']))return ['code' => 201,'msg' => $dataString];
        return ['code' => 200 ,'msg' => '成功','data' => $data['ListGames']];
    }

    private static function getHash($body)
    {

        $array = array_filter($body);
        $array = array_change_key_case($array, CASE_LOWER);
        ksort($array);

        $rawData = '';
        foreach ($array as $Key => $Value)
            $rawData .=  $Key . '=' . $Value . '&' ;

        $rawData = substr($rawData,0, -1);
        $rawData .= config('jokerslots.appSecret');

        return md5($rawData);

    }

}








