<?php
/**
 * 游戏
 */

namespace app\api\controller\slots;

use think\facade\Config;
use think\facade\Db;
use think\facade\Log;
use think\facade\Validate;


class Pgslots {

    //单一钱包
    /**
     * 获取用户钱包
     * @return void
     */
    public function Get(){
        $operator_token = input('operator_token');
        $secret_key     = input('secret_key');
        $session        = input('operator_player_session');
        $player_name = input('player_name');

        //检查供应商是不是自己平台
        if($operator_token != config('pgsoft.OperatorToken') || $secret_key != config('pgsoft.SecretKey')){
            return json(['error' =>['code' => '1034','message' => 'Invalid request'] ,'data' => null]);
        }
        //效验UID与三方的UID是否一致
        $uid = self::getUserUid($session);
        if($uid != $player_name) return json(['error' =>['code' => '3005','message' => 'Invalid request'] ,'data' => null]);

        $res = Common::setUserMoney($uid);
        if($res['code'] != 200) return json(['error' =>['code' => '3005','message' => 'Invalid request'] ,'data' => null]);


        $data = [
            'currency_code' => config('pgslots.currency'),
            'balance' => bcdiv($res['data'],100,2),
            'updated_time' => time().'000',
        ];
        return json(['error' =>null,'data' =>$data]);
    }

    /**
     * @return void
     */
    public function TransferInOut(){


        $param = request()->param();

        $validate = Validate::rule([
            'operator_token' => 'require',
            'secret_key' => 'require',
            'operator_player_session' => 'require',
            'is_validate_bet' => 'require',
            'is_adjustment' => 'require',
            'player_name' => 'require',
            'currency_code' => 'require',
            'bet_amount' => 'require',
            'transaction_id' => 'require',
            'betId' => 'require',
            'parent_bet_id' => 'require',
            'gameId' => 'require',
            'win_amount' => 'require',
            'transfer_amount' => 'require',
            'create_time' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::error("缺少参数:".$validate->getError());
            return json(['error' =>['code' => '1034','message' => 'Invalid request'] ,'data' => null]);
        }



        //检查供应商是不是自己平台
        if($param['operator_token'] != config('pgsoft.OperatorToken') || $param['secret_key'] != config('pgsoft.SecretKey')){
            Log::error('商家信息验证失败-operator_token:'.$param['operator_token'].'-secret_key:'.$param['secret_key']);
            return json(['error' =>['code' => '1034','message' => 'Invalid request'] ,'data' => null]);
        }

        //效验UID与三方的UID是否一致
        $uid = self::getUserUid($param['operator_player_session']);
        if($param['is_validate_bet'] === false && $param['is_adjustment'] === false && $uid != $param['player_name']){
            Log::error('效验UID等数据不对-is_validate_bet:'.$param['is_validate_bet'].'-is_adjustment:'.$param['is_adjustment'].'-实际UID:'.$uid.'三方传入UID:'.$param['player_name']);
            return json(['error' =>['code' => '1034','message' => 'Invalid request'] ,'data' => null]);
        }


        //效验货币是否正确
        if(config('pgslots.currency') != $param['currency_code']){
            Log::error('货币效验失败-currency_code:'.$param['currency_code']);
            return json(['error' =>['code' => '1034','message' => 'Invalid request'] ,'data' => null]);
        }

        $userinfo = Common::getUserInfo($param['player_name']);
        if(!$userinfo){
            Log::error('数据库userinfo不存在用户-UID:'.$param['player_name']);
            return json(['error' =>['code' => '1034','message' => 'Invalid request'] ,'data' => null]);
        }

        //效验下注金额是否足够
        $money = bcadd($userinfo['coin'],$userinfo['bonus'],0);
        if($money  < bcmul($param['bet_amount'],100,0)){
            Log::error('本次下注余额不足-实际余额:'.bcdiv($money,100,2).'-用户下注金额:'.$param['bet_amount']);
            return json(['error' =>['code' => '3202','message' => 'Invalid request'] ,'data' => null]);
        }



        //效验订单是否已经使用过
        $slots_log = Db::name('slots_log_'.date('Ymd'))->field('betId')->where('transaction_id',$param['transaction_id'])->find();
        if($slots_log){
            Log::error('该笔订单已经通知过-transaction_id:'.$param['transaction_id']);
            return json(['error' =>null ,'data' => ['currency_code' => config('pgslots.currency'),'balance_amount' => bcdiv($money,100,2),'updated_time' => time().'000']]);
        }

        $slots_game = Db::name('slots_game')->field('id,englishname')->where(['slotsgameid' => $param['gameId']])->find();



        $slotsData = [
            'betId' => $param['betId'],
            'parentBetId' => $param['parent_bet_id'],
            'uid' => $param['player_name'],
            'puid' => $userinfo['puid'],
            'slotsgameid' => $param['gameId'],
            'englishname' => $slots_game['englishname'],
            'game_id' => $slots_game['id'],
            'terrace_name' => 'PG',
            'transaction_id' => $param['transaction_id'],
            'betTime' => mb_substr($param['create_time'],0,-3),
            'channel' => $userinfo['channel'],
            'package_id' => $userinfo['package_id'],
            'createtime' => time(),
        ];

        $res = Common::slotsLog($slotsData,$userinfo['coin'],$userinfo['bonus'],bcmul($param['bet_amount'],100,0),bcmul($param['win_amount'],100,0));
        if($res['code'] != 200)return json(['error' =>['code' => '1034','message' => 'Invalid request'] ,'data' => null]);

        $data = [
            'currency_code' => config('pgslots.currency'),
            'balance' => bcdiv($res['data'],100,2),
            'updated_time' => time().'000',
        ];
        return json(['error' =>null,'data' =>$data]);
    }


    /**
     * 令牌验证 以及充值
     *  接口文档对应位置：5.2.4.1 充值
     *
     * @url api/pgsoft.Verify/VerifySession
     */
    public function VerifySession() {


        $operator_token = input('operator_token');
        $secret_key     = input('secret_key');
        $session        = input('operator_player_session');

        //检查供应商是不是自己平台
        if($operator_token != config('pgsoft.OperatorToken') || $secret_key != config('pgsoft.SecretKey')){
            return json(['error' =>['code' => '1034','message' => 'Invalid request'] ,'data' => null]);
        }

        //效验是否有UID
        $uid = self::getUserUid($session);
        if(!$uid) return json(['error' =>['code' => '1034','message' => 'Invalid request'] ,'data' => null]);

        $pgsoft = [
            'player_name' => $uid,
            'nickname' => $uid,
            'currency' => config('pgslots.currency')
        ];

        $dataJson = json(['error' =>null ,'data' => $pgsoft]);
        echo $dataJson;
        exit();
    }


    //转账钱包

    public static function GetGame(){

        $url = Config::get('pgslots.api_url').'/Game/v2/Get?trace_id='.self::guid();;
        $body = [
            'operator_token' => Config::get('pgslots.OperatorToken'),
            'secret_key' => Config::get('pgslots.SecretKey'),
            'currency' => Config::get('pgslots.currency'),
            'language' => 'en-us',
            'status' => 1,
        ];
        $header = [];

        // post请求
        $postHttp = self::http_post($url,$body,[],'GetGame');

        return $postHttp;

    }

    /**
     * @return void 充值
     * @param  $ordersn 订单号
     * @param  $amount 充值金额
     *  @param  $player_name 玩家的uid
     */
    public static function Cash($ordersn,$amount,$player_name){
        $amount = bcdiv($amount,100,2);
        $url  = Config::get('pgslots.api_url').'/Cash/v3/TransferIn?trace_id='.self::guid();
        $body = [
            'operator_token' => Config::get('pgslots.OperatorToken'),
            'secret_key' => Config::get('pgslots.SecretKey'),
            'currency' => Config::get('pgslots.currency'),
            'player_name'        => $player_name,
            'amount'             => $amount,
            'transfer_reference' => $ordersn,
        ];
        $header = [];

        // post请求
        $postHttp = self::http_post($url,$body,[],'Cash');
        return $postHttp;
    }



    /**
     * 转出所有余额
     *
     * @param  $ordersn 订单号
     *  @param  $player_name 玩家的uid
     * @return array
     */
    public static function transferAllOut($ordersn,$player_name) {

        $url  = Config::get('pgslots.api_url') . '/Cash/v3/TransferAllOut?trace_id=' .self::guid();
        $body = [
            'operator_token' => Config::get('pgslots.OperatorToken'),
            'secret_key' => Config::get('pgslots.SecretKey'),
            'currency' => Config::get('pgslots.currency'),
            'player_name'        => (string) $player_name,
            'transfer_reference' => $ordersn,
        ];

        // 签名头数据
        // $header = SignService::headerData($body);
        $header = [];

        // post请求
        $postHttp = self::http_post($url,$body,[],1,10);
        return $postHttp;

    }

    /**
     * 创建玩家
     * @param $nickname  玩家昵称
     * @param $player_name  玩家uid
     * @param $trace_id trace_id
     * @return bool|string
     */
    public static function playerCreated($nickname,$player_name,$trace_id){

        $url  = Config::get('pgslots.api_url').'/v3/Player/Create?trace_id='.$trace_id;
        $body = [
            'operator_token' => Config::get('pgslots.OperatorToken'),
            'secret_key' => Config::get('pgslots.SecretKey'),
            'currency' => Config::get('pgslots.currency'),
            'player_name'  => (string) $player_name,
            'nickname' => $nickname,
        ];

        // 签名头数据

        $header = [];

        // post请求
        $postHttp = self::http_post($url,$body,[]);

        return $postHttp;
    }

    /**
     * 获取玩家第三方游戏状态
     * @param $player_name  玩家uid
     * @return bool|string
     */
    public static function getPlayersOnlineStatus($player_name){

        $url  = Config::get('pgslots.api_url').'/Player/v3/GetPlayersOnlineStatus?trace_id='.self::guid();
        $body = [
            'operator_token' => Config::get('pgslots.OperatorToken'),
            'secret_key' => Config::get('pgslots.SecretKey'),
            'player_names' => $player_name,
        ];

        // 签名头数据

        $header = [];

        // post请求
        $postHttp = self::http_post($url,$body,[]);
        return $postHttp;
    }


    /**
     * 获取玩家第三方游戏余额
     * @param $player_name  玩家uid
     * @return bool|string
     */
    public static function getPlayerWallet($player_name){

        $url  = Config::get('pgslots.api_url').'/Cash/v3/GetPlayerWallet?trace_id='.self::guid();
        $body = [
            'operator_token' => Config::get('pgslots.OperatorToken'),
            'secret_key' => Config::get('pgslots.SecretKey'),
            'player_name' => $player_name,
        ];

        // 签名头数据

        $header = [];

        // post请求
        $postHttp = self::http_post($url,$body,[]);

        return $postHttp;
    }

    /**
     * @param $count 获取条数 1500 - 5000
     * @param $row_version   row_version 第三方的row_version 首次填写1
     * @return bool|string
     */
    public static function getHistory($count,$row_version) {

        $url  = Config::get('pgslots.history_url').'/Bet/v4/GetHistory?trace_id='.self::guid();

        $body = [
            'operator_token' => Config::get('pgslots.OperatorToken'),
            'secret_key' => Config::get('pgslots.SecretKey'),
            'count' =>(int)$count,
            'bet_type'  => 1,
            'row_version' => (int)$row_version,
        ];

        // 签名头数据
        // $header = SignService::headerData($body);
        $header = [];

        // post请求
        $postHttp = self::http_post($url,$body,[]);

        return $postHttp;

    }



    /**
     * 获取游戏启动url
     * @param $gameid  游戏的id
     * @param $TraceID  用户的TraceID
     * @return array
     */
    public static function getGameUrl($gameid){
        $TraceID  = self::getUserTraceId() ?: self::guid();
        $domain =  str_replace('/external','',Config::get('pgslots.api_url'));
        $url  = $domain.'/external-game-launcher/api/v1/GetLaunchURLHTML?trace_id='.self::guid();
        $body = [
            'operator_token' => Config::get('pgslots.OperatorToken'),
            'path' =>"/$gameid/index.html",
            'extra_args' =>"btt=1&ops=$TraceID&l=pt&f=closewebview",
            'url_type'  => 'game-entry',
            'client_ip' => request()->ip(),
        ];
        // post请求
        $postHttp = self::http_post($url,$body,[],2);
        return $postHttp;
    }


    /**
     * 存储用户的TraceId
     * @param $uid
     * @param $trace_id
     * @return void
     */
    public static function setUserTraceId($uid,$trace_id){
        $Redis = new \Redis();
        $Redis->connect('redis.ip','redis.port0');
        //把UID和TraceId互相绑定
        $Redis->hSet('PgTraceId',$uid,$trace_id);
        $Redis->hSet('PgUid',$trace_id,$uid);
    }

    /**
     * 获取用户的TraceId
     * @param $uid 用户UID
     * @return void
     */
    public static function getUserTraceId($uid){
        $Redis = new \Redis();
        $Redis->connect('redis.ip','redis.port0');
        return $Redis->hGet('PgTraceId',$uid);
    }


    /**
     * 通过TraceId获取用户的Uid
     * @param $TraceId  TraceId
     * @return void
     */
    public static function getUserUid($TraceId){
        $Redis = new \Redis();
        $Redis->connect('redis.ip','redis.port0');
        return $Redis->hGet('PgUid',$TraceId);
    }

    public static function http_post($url, $data, $header = [],$type =1,$timeout = 60)
    {

        $data = http_build_query($data, '', '&');

        if($type == 2){
            $headerData = ["Content-Type: application/x-www-form-urlencoded"];
        }else{
            $headerData = ["Content-Type: application/x-www-form-urlencoded;charset='utf-8'"];
        }


        if (!empty($header)) {
            $headerData = array_merge($headerData, $header);
        }

        // 启动一个CURL会话
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查。https请求不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POST, 1); // Post提交的数据包
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerData); //模拟的header头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

        $output = curl_exec($curl);

        curl_close($curl);


        return $output;
    }

    public static function guid() {
        mt_srand((double) microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid   = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);

        return $uuid;
    }


}




