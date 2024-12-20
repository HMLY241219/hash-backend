<?php
/**
 * 游戏
 */

namespace app\api\controller\slots;


use think\facade\Db;
use think\facade\Log;
use curl\Curl;
use customlibrary\Common;
use app\api\controller\slots\Common as SlotsCommon;
use think\facade\Config;
use think\facade\Validate;
use think\response\Json;


class Ppslots {

    private static $herder = [
        'Content-Type: application/x-www-form-urlencoded',
    ];
//单一钱包

    /**
     * 用户切换游戏场景时请求
     * @return false|string
     */
   public function authenticate(){
       $param = request()->param();

       $validate = Validate::rule([
           'token' => 'require',
           'providerId' => 'require',
           'gameId' => 'require',
       ]);

       if (!$validate->check($param)) {
           Log::error("PP缺少参数:".$validate->getError());
           return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
       }

       if($param['providerId'] != config('ppsoft.Name')){
           Log::error('PP商户验证失败:三方-providerId:'.$param['providerId'].'我方-providerId:'.config('ppsoft.Name'));
           return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
       }

       $user_token = Db::name('user_token')->field('uid')->where('uid',$param['token'])->find();
       if(!$user_token){
           Log::error('PP用户验证失败:三方-token:'.$param['token']);
           return json(['error' => 2,'description' => 'Player not found or is logged out. Should be returned in the response on any request sent by Pragmatic Play if the player can’t be found or is logged out at Casino Operator’s side.']);
       }

       $res = SlotsCommon::setUserMoney($user_token['uid']);
       if($res['code'] != 200){
           Log::error('PP用户获取失败:用户-UID:'.$user_token['uid'].'未找到用户');
           return json(['error' => 2,'description' => 'Player not found or is logged out. Should be returned in the response on any request sent by Pragmatic Play if the player can’t be found or is logged out at Casino Operator’s side.']);
       }

       $data = [
           'userId' => $user_token['uid'],
           'currency' =>config('ppslots.currency'),
           'cash' => bcdiv($res['data'],100,2),
           'bonus' => 0,
           'error' => 0,
           'description' => 'Success',
       ];
       return json($data);

   }


    /**
     * 获取用户余额
     * @return false|string
     */
    public function  balance(){
        $providerId = input('providerId');
        $userId = input('userId');
        //检查供应商是不是自己平台
        if($providerId != config('ppsoft.Name')){
            Log::error('PP商户验证失败:三方-providerId:'.$providerId.'我方-providerId:'.config('ppsoft.Name'));
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }

        $res = SlotsCommon::setUserMoney($userId);
        if($res['code'] != 200){
            Log::error('PP玩家-UID:'.$userId.'不存在');
            return json(['error' => 2,'description' => 'Player not found or is logged out. Should be returned in the response on any request sent by Pragmatic Play if the player can’t be found or is logged out at Casino Operator’s side.']);
        };

        $data = [
            'error' => 0,
            'description' => 'Success',
            'currency' =>config('ppslots.currency'),
            'cash' => bcdiv($res['data'],100,2),
            'bonus' => 0
        ];
        return json($data);
    }



    /**
     * 投付
     * @return false|string
     */
    public function bet(){

        $param = request()->param();

        $validate = Validate::rule([
            'userId' => 'require',
            'gameId' => 'require',
            'roundId' => 'require',
            'amount' => 'require',
            'reference' => 'require',
            'providerId' => 'require',
            'timestamp' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::error("PP缺少参数:".$validate->getError());
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }
        //检查供应商是不是自己平台
        if($param['providerId'] != config('ppsoft.Name')){
            Log::error('PP商户验证失败:三方-providerId:'.$param['providerId'].'我方-providerId:'. config('ppsoft.Name'));
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }

        $userinfo = SlotsCommon::getUserInfo($param['userId']);
        if(!$userinfo){
            Log::error('PP玩家-UID:'.$param['userId'].'不存在');
            return json(['error' => 2,'description' => 'Player not found or is logged out. Should be returned in the response on any request sent by Pragmatic Play if the player can’t be found or is logged out at Casino Operator’s side.']);
        }


        $res = SlotsCommon::setUserMoney($param['userId']);
        if($res['code'] != 200){
            Log::error('PP玩家-UID:'.$param['userId'].'不存在');
            return json(['error' => 2,'description' => 'Player not found or is logged out. Should be returned in the response on any request sent by Pragmatic Play if the player can’t be found or is logged out at Casino Operator’s side.']);
        }
        $money = bcdiv($res['data'],100,2);

        //效验订单是否已经使用过
        $slots_log = Db::name('slots_log_'.date('Ymd'))->field('betId')->where('transaction_id',$param['providerId'])->find();
        if($slots_log){
            Log::error('PP该笔订单已经通知过-transaction_id:'.$param['providerId']);
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }


        $slots_game = Db::name('slots_game')->field('id,englishname')->where(['slotsgameid' => $param['gameId']])->find();

        $slotsData = [
            'betId' => $param['roundId'],
            'parentBetId' => $param['roundId'],
            'uid' => $param['userId'],
            'puid' => $userinfo['puid'],
            'slotsgameid' => $param['gameId'],
            'englishname' => $slots_game['englishname'],
            'game_id' => $slots_game['id'],
            'terrace_name' => 'PP',
            'transaction_id' => $param['providerId'],
            'betTime' => mb_substr($param['timestamp'],0,-3),
            'channel' => $userinfo['channel'],
            'package_id' => $userinfo['package_id'],
            'createtime' => time(),
            'is_settlement' => 0,
        ];

        Db::name('slots_log_'.date('Ymd'))->insert($slotsData);



        $data = [
            'transactionId' => $param['providerId'],
            'currency' =>config('ppslots.currency'),
            'cash' => $money,
            'bonus' => 0,
            'usedPromo' => 0,
            'error' => 0,
            'description' => 'Success'
        ];
        return json($data);

    }


    /**
     * 普通结算
     * @return void
     */
    public function  result(){
        $param = request()->param();

        $validate = Validate::rule([
            'userId' => 'require',
            'gameId' => 'require',
            'roundId' => 'require',
            'amount' => 'require',
            'reference' => 'require',
            'providerId' => 'require',
            'timestamp' => 'require',
            'roundDetails' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::error("PP缺少参数:".$validate->getError());
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }

        //检查供应商是不是自己平台
        if($param['providerId'] != config('ppsoft.Name')){
            Log::error('PP商户验证失败:三方-providerId:'.$param['providerId'].'我方-providerId:'. config('ppsoft.Name'));
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }


        $userinfo = SlotsCommon::getUserInfo($param['userId']);
        if(!$userinfo){
            Log::error('PP数据库userinfo不存在用户-UID:'.$param['userId']);
            return json(['error' => 2,'description' => 'Player not found or is logged out. Should be returned in the response on any request sent by Pragmatic Play if the player can’t be found or is logged out at Casino Operator’s side.']);
        }


        $slots_log = Db::name('slots_log_'.date('Ymd'))->where('betId',$param['roundId'])->find();
        if(!$slots_log || $slots_log['is_settlement']){
            $money = bcdiv(bcadd($userinfo['coin'],$userinfo['bonus'],0),100,2);
            $data = [
                'transactionId' => $param['providerId'],
                'currency' =>config('ppslots.currency'),
                'cash' => $money,
                'bonus' => 0,
                'error' => 0,
                'description' => 'Success'
            ];
            return json($data);
        }

        $RoundDetails = $this->getRoundDetails($param['roundDetails'],['totalBet','totalWin']);

        $res = SlotsCommon::slotsLog($slots_log,$userinfo['coin'],$userinfo['bonus'],bcmul($RoundDetails['totalBet'],100,0),bcmul($RoundDetails['totalWin'],100,0),2);
        if($res['code'] != 200){
            Log::error('PP事务处理失败-UID:'.$param['userId'].'三方游戏-betId:'.$slots_log['betId']);
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }

        $data = [
            'transactionId' => $param['providerId'],
            'currency' =>config('ppslots.currency'),
            'cash' => bcdiv($res['data'],100,2),
            'bonus' => 0,
            'error' => 0,
            'description' => 'Success'
        ];
        return json($data);
    }


    /**
     * 返还
     * @return void
     */
    public function refund(){
        $data = [
            'transactionId' => rand(1000000,9999999).time(),
            'error' => 0,
            'description' => 'Success'
        ];
        return json($data);
        $param = request()->param();

        $validate = Validate::rule([
            'userId' => 'require',
            'reference' => 'require',
            'providerId' => 'require',
            'amount' => 'require', //要退还的金额
            'roundId' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::error("PP缺少参数:".$validate->getError());
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }

        //检查供应商是不是自己平台
        if($param['providerId'] != config('ppsoft.Name')){
            Log::error('PP商户验证失败:三方-providerId:'.$param['providerId'].'我方-providerId:'. config('ppsoft.Name'));
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }



        //效验订单是否已经使用过
        $slots_log = Db::name('slots_log_'.date('Ymd'))->where('betId',$param['roundId'])->find();
        if(!$slots_log || $slots_log['is_settlement'] != 1){
            $data = [
                'transactionId' => $param['reference'],
                'error' => 0,
                'description' => 'Success'
            ];
            return json($data);
        }

        SlotsCommon::setRefundSlotsLog($slots_log,bcmul($param['money'],100,0));
    }


    /**
     * 返还
     * @return json
     */
    public function bonusWin(){
        $uid = input('uid');
        $res = SlotsCommon::setUserMoney($uid);
        if($res['code'] != 200){
            Log::error('PP玩家-UID:'.$uid.'不存在');
            return json(['error' => 2,'description' => 'Player not found or is logged out. Should be returned in the response on any request sent by Pragmatic Play if the player can’t be found or is logged out at Casino Operator’s side.']);
        };
        $data = [
            'transactionId' => rand(1000000,9999999).time(),
            'currency' =>config('ppslots.currency'),
            'cash' => bcdiv($res['data'],100,2),
            'bonus' => 0,
            'error' => 0,
            'description' => 'Success'
        ];
        return json($data);
    }


    /**
     * jackpotwin 累计奖池中奖
     * @return void
     */
    public function jackpotWin(){
        $uid = input('uid');
        $res = SlotsCommon::setUserMoney($uid);
        if($res['code'] != 200){
            Log::error('PP玩家-UID:'.$uid.'不存在');
            return json(['error' => 2,'description' => 'Player not found or is logged out. Should be returned in the response on any request sent by Pragmatic Play if the player can’t be found or is logged out at Casino Operator’s side.']);
        };
        $data = [
            'transactionId' => rand(1000000,9999999).time(),
            'currency' =>config('ppslots.currency'),
            'cash' => bcdiv($res['data'],100,2),
            'bonus' => 0,
            'error' => 0,
            'description' => 'Success'
        ];
        return json($data);
    }

    /**
     * 锦标赛派彩
     * @return void
     */
    public function promoWin(){
        $uid = input('uid');
        $res = SlotsCommon::setUserMoney($uid);
        if($res['code'] != 200){
            Log::error('PP玩家-UID:'.$uid.'不存在');
            return json(['error' => 2,'description' => 'Player not found or is logged out. Should be returned in the response on any request sent by Pragmatic Play if the player can’t be found or is logged out at Casino Operator’s side.']);
        };
        $data = [
            'transactionId' => rand(1000000,9999999).time(),
            'currency' =>config('ppslots.currency'),
            'cash' => bcdiv($res['data'],100,2),
            'bonus' => 0,
            'error' => 0,
            'description' => 'Success'
        ];
        return json($data);
    }


    /**
     * 结束游戏回合
     * @return void
     */
    public function endRound(){
        $param = request()->param();

        $validate = Validate::rule([
            'userId' => 'require',
            'roundId' => 'require',
            'providerId' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::error("PP缺少参数:".$validate->getError());
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }

        //检查供应商是不是自己平台
        if($param['providerId'] != config('ppsoft.Name')){
            Log::error('PP商户验证失败:三方-providerId:'.$param['providerId'].'我方-providerId:'. config('ppsoft.Name'));
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }


        $res = SlotsCommon::setUserMoney($param['userId']);
        if($res['code'] != 200){
            Log::error('PP玩家-UID:'.$param['userId'].'不存在');
            return json(['error' => 2,'description' => 'Player not found or is logged out. Should be returned in the response on any request sent by Pragmatic Play if the player can’t be found or is logged out at Casino Operator’s side.']);
        }


        $SlotsLog = SlotsCommon::SlotsLogView($param['roundId']);
        if($SlotsLog && !$SlotsLog['is_settlement']){
            Log::error('PP玩家-UID:'.$param['userId'].'不存在');
            return json(['error' => 130,'description' => 'Internal server error on EndRoundprocessing. Casino Operator will return this  error  code  if  their  system  has  internal  problem  and  cannot process the EndRoundrequest, and Operator logic requiresa retry of the request.']);
        }
        $data = [
            'cash' => bcdiv($res['data'],100,2),
            'bonus' => 0,
            'error' => 0,
            'description' => 'Success'
        ];
        return json($data);

    }


    /**
     * 玩家需要调整的余额金额
     * 只在真人游戏使用
     * @return void
     */
    public function adjustment(){
        $param = request()->param();

        $validate = Validate::rule([
            'userId' => 'require',
            'roundId' => 'require',
            'amount' => 'require', //需要调整的钱
            'validBetAmount' => 'require', //需要调整的钱
        ]);
        if (!$validate->check($param)) {
            Log::error("PP缺少参数:".$validate->getError());
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }

        //检查供应商是不是自己平台
        if($param['providerId'] != config('ppsoft.Name')){
            Log::error('PP商户验证失败:三方-providerId:'.$param['providerId'].'我方-providerId:'. config('ppsoft.Name'));
            return json(['error' => 4,'description' => 'Player authentication failed due to invalid, not found or expired token.']);
        }

    }


    /**
     * 解析PP roundDetails
     * @param $roundDetails
     * @param $filedArray array 需要那些字段
     * @return void
     */
    private function getRoundDetails($roundDetails,array $filedArray){
        $roundDetailsArray = explode(',',$roundDetails);
        $data = [];
        foreach ($roundDetailsArray as $v){
            $detailsArray = explode(':',$v);
            $filed = $detailsArray[0];
            $value = $detailsArray[1] ?? '';
            if(in_array($filed,$filedArray))$data[$filed] = $value;
        }
        return $data;
    }

//下面转入转出获取为转账钱包

    public static function GetGame(){


        $url = Config::get('ppslots.api_url').'/IntegrationService/v3/http/CasinoGameAPI/getCasinoGames';
        $data = [
            'secureLogin' => Config::get('ppslots.Name'),
            'options' => 'GetFrbDetails,GetLines,GetDataTypes,GetFeatures'
        ];
        $data['hash'] = self::getHash($data);

        return Curl::post($url,$data,self::$herder,[],2);

    }


    /**
     * @return void 充值
     * @param  $ordersn 订单号
     * @param  $amount 充值金额 正数代表充值，负数代表提现
     *  @param  $player 玩家的在uid
     */
    public static function Cash($ordersn,$amount,$uid){
        $amount = bcdiv($amount,100,2);
        $url  = Config::get('ppslots.api_url').'/IntegrationService/v3/http/CasinoGameAPI/balance/transfer/';
        $body = [
            'secureLogin' => Config::get('ppslots.Name'),
            'externalPlayerId' => $uid,
            'externalTransactionId' => $ordersn,
            'amount' => $amount,
        ];
        $body['hash'] = self::getHash($body);

        $data = self::senPostCurl($url,$body);
        if($amount > 0){
            Log::error('PP==Cash====uid===='.$uid.'======res==='.json_encode($data));
        }else{
            Log::error('PP==Transaction====uid===='.$uid.'======res==='.json_encode($data));
        }

        if(!isset($data['transactionId']) || !isset($data['error']) || $data['error'] !== '0'){//充值获取转出失败
            Log::error('PP==Transaction====uid===='.$uid.'======res==='.json_encode($body)).'====url==='.$url;
            if($amount > 0) Db::name('exec_php')->insert([
                "type"=>100,'uid' => $uid,
                "jsonstr"=>json_encode(array("msg_id"=>3,"uid"=>(int)$uid,"update_int64"=>(int)bcmul(100,$amount,0),"reason"=>19)),
                "description"=>"Pp游戏充值失败回退".bcdiv($amount,100,2)."雷亚尔."
            ]);
            Common::log('Ppslots充值单号'.$ordersn.'金额'.$amount.'uid'.$uid,json_encode($data),3);
            return ['code' => 201,'msg' => $data['description'] ?? '' ,'data' =>$data ];
        }

        return ['code' => 200,'msg' => $data['description'] ,'data' =>$data['transactionId']];

    }



    /**
     * 转出所有余额
     *
     * @param  $ordersn 订单号
     *  @param  $uid 玩家的uid
     * @return array
     */
    public static function transferAllOut($ordersn,$uid) {

        $res = self::getPlayerWallet($uid);

        if($res['code'] != 200){
            return ['code' => 201,'msg' => $res['msg'],'data' => $res['data']];
        }
        if($res['data'] <= 0){
            return ['code' => 200,'msg' => '','data' => ['money' => 0]];
        }
        $money = bcsub(0,bcmul($res['data'],100,2),2);
        $res1 =  self::Cash($ordersn,$money,$uid);
        if($res1['code'] != 200){
            return ['code' => 201,'msg' => $res1['msg'],'data' => $res1['data']];
        }

        return ['code' => 200,'msg' => '','data' => ['transactionId' => $res1['data'],'money' => $res['data']]];
    }

    /**
     * 创建玩家
     * @param $nickname  玩家昵称
     * @param $player_name  玩家uid
     * @param $trace_id trace_id
     * @return bool|string
     */
    public static function playerCreated($uid){

        $url  = Config::get('ppslots.api_url').'/IntegrationService/v3/http/CasinoGameAPI/player/account/create/';
        $body = [
            'secureLogin' => Config::get('ppslots.Name'),
            'externalPlayerId' => $uid,
            'currency' => Config::get('ppslots.currency'),
        ];

        $body['hash'] = self::getHash($body);
        $data = self::senPostCurl($url,$body);
        if(!isset($data['playerId']) || !isset($data['error']) || $data['error'] !== '0'){
            Common::log('Ppslots创建玩家'.$uid,json_encode($data),3);
            return ['code' => 201,'msg' => $data['description'] ?? '' ,'data' =>$data ];
        }

        return ['code' => 200,'msg' => $data['description'] ,'data' =>$data['playerId']];

    }



    /**
     * 获取玩家第三方游戏余额
     * @param $player_name  玩家uid
     * @return bool|string
     */
    public static function getPlayerWallet($uid){

        $url  = Config::get('ppslots.api_url').'/IntegrationService/v3/http/CasinoGameAPI/balance/current/';
        $body = [
            'secureLogin' => Config::get('ppslots.Name'),
            'externalPlayerId' => $uid,
        ];

        $body['hash'] = self::getHash($body);
        $data = self::senPostCurl($url,$body);

        if(!isset($data['balance']) || !isset($data['error']) || $data['error'] !== '0'){
            Log::error('PP==getPlayerWallet====uid===='.$uid.'======res==='.json_encode($body).'===url==='.$url);
            Common::log('Ppslots获取玩家余额'.$uid,json_encode($data),3);
            return ['code' => 201,'msg' => $data['description'] ?? '' ,'data' =>$data ];
        }

        return ['code' => 200,'msg' => $data['description'] ,'data' =>$data['balance']];

    }

    /**
     * 获取游戏启动url
     * @param $uid  用户的uid
     * @param $gameid  游戏的id
     * @return array
     */
    public static function getGameUrl($uid,$gameid){
        //单一钱包启动
        $user_token = Db::name('user_token')->field('token')->where('uid',$uid)->find();
        if(!$user_token){
            Log::error('用户获取PP游戏链接时-uid:'.$uid.'获取token失败');
            return ['code' => 201,'msg' => '用户获取PP游戏链接时-uid:'.$uid.'获取token失败' ,'data' =>[] ];
        }
        $url  = Config::get('ppslots.api_url').'/IntegrationService/v3/http/CasinoGameAPI/game/url/';
        $body = [
            'secureLogin' => Config::get('ppslots.Name'),
            'symbol' => $gameid,
            'language' => Config::get('ppslots.language'),
            'token' => $user_token['token'],
            'externalPlayerId' => $uid,
            'currency' => Config::get('ppslots.currency'),
            'rcCloseUrl' => '',//指向运营商网站页面的链接，如果玩家选择关闭游戏，他们将被重定向到该页面。
            'lobbyUrl' => '',//用于返回娱乐场运营商网站上的大厅页面的URL。此链接用于移动版游戏中的返回大厅（主页）按钮
            'cashierUrl' => '',//当玩家没有资金时，用于在娱乐场运营商网站上打开收银台的URL
        ];
        $body['hash'] = self::getHash($body);

        $data = self::senPostCurl($url,$body);

        if(!isset($data['GameURL']) || !isset($data['error']) || $data['error'] !== '0'){
            Log::error('用户获取PP游戏链接时-uid:'.$uid.'获取游戏启动链接失败');
            return ['code' => 201,'msg' => 'Ppslots玩家获取游戏链接' ,'data' =>[] ];
        }
        return ['code' => 200,'msg' => 'success' ,'data' =>$data['GameURL']];

        //转账模式启动
        $url  = Config::get('ppslots.api_url').'/IntegrationService/v3/http/CasinoGameAPI/game/start/';
        $body = [
            'secureLogin' => Config::get('ppslots.Name'),
            'externalPlayerId' => $uid,
            'gameId' => $gameid,
            'language' => Config::get('ppslots.language'),
            'lobbyURL' => 'https://closewebview/',
        ];

        $body['hash'] = self::getHash($body);

        $data = self::senPostCurl($url,$body);

        if(!isset($data['gameURL']) || !isset($data['error']) || $data['error'] !== '0'){
            Common::log('Ppslots玩家获取游戏链接'.$uid,json_encode($data),3);
            return ['code' => 201,'msg' => $data['description'] ?? '' ,'data' =>$data ];
        }

        return ['code' => 200,'msg' => $data['description'] ,'data' =>$data['gameURL']];
    }

    /**
     * 获取游戏历史记录
     * @param $timepoint 拉取开始时间
     * @param $dataType 产品组合类 RNG 视频老虎机、经典老虎机等 ,LC 真人娱乐场产品组合,VSB 虚拟体育博彩产品组合,BNG 宾果 产品
     * @return bool|string
     */
    public static function getHistory($timepoint,$dataType = 'RNG') {

        $url  = Config::get('ppslots.api_url').'/IntegrationService/v3/DataFeeds/gamerounds/finished/';
        $body = [
            'login' => Config::get('ppslots.Name'),
            'password' => Config::get('ppslots.SecretKey'),
            'timepoint' => $timepoint,
            'dataType' => $dataType,
            'options' => 'addBalance',
        ];

        $data = self::senGetCurl($url,$body);

        if(!$data || $data == 'null'){
            return [];
        }
        $data = explode("\n",$data);

        $timepointSrting = explode('=',$data[0])[1] ?? 0;
        if(!$timepointSrting){
            return [];
        }
        if(count($data) <= 2){ //表示只有时间和数据格式
            return ['timepoint' => $timepointSrting,'data' => []];
        }
        $timezone = new \DateTimeZone('GMT');

        $list = [];
        for ($i= 2;$i < count($data); $i++){
            if($data[$i]){
                $valueArray = explode(',',$data[$i]);
                $startDate = $valueArray[5] ?? 0;
                $endDate =$valueArray[6] ?? 0;

                $startDateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $startDate, $timezone);
                $endDateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $endDate, $timezone);
                $startDateObj->setTimezone(new \DateTimeZone('Asia/Shanghai')); // 设置为中国时区
                $endDateObj->setTimezone(new \DateTimeZone('Asia/Shanghai')); // 设置为中国时区
//                $startDateObj->setTimezone(new \DateTimeZone('America/Sao_Paulo')); // 设置为巴西时区
//                $endDateObj->setTimezone(new \DateTimeZone('America/Sao_Paulo')); // 设置为巴西时区
                $startDateLocal = $startDateObj->format('Y-m-d H:i:s');
                $endDateLocal = $endDateObj->format('Y-m-d H:i:s');
                $list[] = [
                    'playerID' => $valueArray[0] ?? 0,     //三方的用户id
                    'extPlayerID' => $valueArray[1] ?? 0,  //我们平台用户uid
                    'gameID' => $valueArray[2] ?? 0,    //游戏id
                    'playSessionID' => $valueArray[3] ?? 0,   //子账单
                    'parentSessionID' => $valueArray[4] ?? 0,  //母账单
                    'startDate' => strtotime($startDateLocal),   //开始时间
                    'endDate' =>  strtotime($endDateLocal),    //结束时间
                    'status' => $valueArray[7] ?? 0,    //游戏状态 ： C = 已完成 , I = 未完成
                    'type' => $valueArray[8] ?? 0,    //游戏类型 ： R = 游戏回合 , F = 免费旋转在游戏回合中触发
                    'bet' => $valueArray[9] ?? 0,     //投注金额
                    'win' => $valueArray[10] ?? 0,    //结算金额
                    'currency' => $valueArray[11] ?? 0,  //交易货币
                    'jackpot' => $valueArray[12] ?? 0,    //累积奖金赢得的数量
                    'balance' => $valueArray[13] ?? 0,    //这把打完的余额
                ];
            }
        }


        return ['timepoint' => $timepointSrting,'data' => $list];

    }

    /**
     * @param $body 请求体
     * @return string 获取hash
     */
    private static function getHash($body){
        return Common::asciiSignNotKey($body,Config::get('ppslots.SecretKey'));
    }

    /** 发送Curl
     * @param $url
     * @param $body
     * @return mixed
     */
    private static function senPostCurl($url,$body)
    {
        $dataString = Curl::post($url, $body, self::$herder, [], 2);
        Log::error('dataString==='.$dataString);
        return json_decode($dataString, true);

    }

    /** 发送Curl
     * @param $url
     * @param $body
     * @return mixed
     */
    private static function senGetCurl($url,$body){
        return  Curl::get($url,$body);  //false

    }

}





