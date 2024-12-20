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

class Jlslots extends BaseController {

    /**
     * 游戏厂商 验证账号
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function userAuth(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'reqId' => 'require',
            'token' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("验证账号接口数据验证失败===>".$validate->getError());
            return json(['errorCode'=>5, 'message'=>'Missing parameters']);
        }

        $userinfo = Db::name('user_token')
            ->alias('a')
            ->leftJoin('userinfo b','a.uid=b.uid')
            ->where('a.token',$param['token'])
            ->field('a.uid,IFNULL(b.coin,0) AS coin,IFNULL(b.bonus,0) AS bonus')
            ->find();
        //dd($userinfo);
        if (empty($userinfo)){
            Log::record("验证账号token无效");
            return json(['errorCode'=>4, 'message'=>'Token expired']);
        }
        //bonus不带入
        $userinfo['bonus'] = config('slots.is_carry_bonus') == 1 ? $userinfo['bonus'] : 0;

        $data = [
            'errorCode' => 0,
            'message' => 'Success',
            'username' => (string)$userinfo['uid'],
            'currency' => Config::get('jlslots.currency'),
//            'balance' => ($userinfo['coin'] + $userinfo['bonus'])/100,
            'balance' =>  (float)bcdiv($userinfo['coin'] + $userinfo['bonus'], 100, 2),
        ];

        return json($data);
    }

    public function userBet(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'reqId' => 'require',
            'token' => 'require',
            'currency' => 'require',
            'game' => 'require',
            'round' => 'require',
            'wagersTime' => 'require',
            'betAmount' => 'require',
            'winloseAmount' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("注单接口数据验证失败===>".$validate->getError());
            return json(['errorCode'=>3, 'message'=>'Missing parameters']);
        }

        $userinfo = Db::name('user_token')
            ->alias('a')
            ->leftJoin('userinfo b','a.uid=b.uid')
            ->where('a.token',$param['token'])
            ->field('a.uid,b.puid,IFNULL(b.coin,0) AS coin,IFNULL(b.bonus,0) AS bonus,b.channel,b.package_id')
            ->find();
        //dd($userinfo);
        if (empty($userinfo)){
            Log::record("注单token无效");
            return json(['errorCode'=>4, 'message'=>'Token expired']);
        }
        //bonus不带入
        $userinfo['bonus'] = config('slots.is_carry_bonus') == 1 ? $userinfo['bonus'] : 0;

        //验证注单是否已承认
        $pre = 'br_';
        $table = 'slots_log_' . date('Ymd');
        $res = Db::query("SHOW TABLES LIKE '$pre$table'");
        if (!$res){
            Log::record("注单记录表不存在");
            return json(['errorCode'=>5, 'message'=>'Other error']);
        }
        $old_balance = bcdiv($userinfo['coin'] + $userinfo['bonus'], 100,2);

        $data = [
            'username' => (string)$userinfo['uid'],
            'currency' => Config::get('jlslots.currency'),
            'balance' =>  (float)$old_balance,
        ];

        $log = Db::name($table)->where('betId',$param['round'])->find();
        //已承认
        if (!empty($log) && $log['transaction_id'] != ''){
            $data['errorCode'] = 1;
            $data['message'] = 'Already accepted';
            $data['txId'] =  (int)$log['transaction_id'];
            return json($data);
        }

        //检查余额是否充足
        if ($old_balance < $param['betAmount']){
            $data['errorCode'] = 2;
            $data['message'] = 'Not enough balance';
            return json($data);
        }

        $game_info = Db::name('slots_terrace')->alias('a')
            ->leftJoin('slots_game b','a.id=b.terrace_id')
            ->where('a.type','td')
            ->where('b.slotsgameid',$param['game'])
            ->field('a.name,a.type,
            b.englishname,b.id as slots_game_id')
            ->find();

        $ordersn = \customlibrary\Common::doOrderSn(333);
        try {
            Db::startTrans();

            //下注记录
            if (!empty($log)) {
                Db::name($table)->where('betId',$param['round'])->update(['transaction_id'=>$ordersn]);
                $game_log = $log;
            } else {
                $game_log = [
                    'betId' => $param['round'],
                    'parentBetId' => $param['round'],
                    'uid' => $userinfo['uid'],
                    'puid' => $userinfo['puid'],
                    'terrace_name' => $game_info['name'],
                    'slotsgameid' => $param['game'],
                    'game_id' => $game_info['slots_game_id'],
                    'englishname' => $game_info['englishname'],
                    /*'cashBetAmount' => bcmul($cash_bet, 100, 2),
                    'bonusBetAmount' => bcmul($bouns_bet, 100, 2),
                    'cashWinAmount' => bcmul($cash_winloseAmount, 100, 2),
                    'bonusWinAmount' => bcmul($bouns_winloseAmount, 100, 2),
                    'cashTransferAmount' => bcmul($cash_transferAmount, 100, 2),
                    'bonusTransferAmount' => bcmul($bouns_transferAmount, 100, 2),*/
                    'transaction_id' => $ordersn,
                    'package_id' => $userinfo['package_id'],
                    'channel' => $userinfo['channel'],
                    'betEndTime' => $param['wagersTime'],
                    'createtime' => time(),
                ];
                //Db::name($table)->insert($game_log);
            }

            //资金变化
            //$res = slotsCommon::userFundChange($userinfo['uid'], $game_log['cashTransferAmount'], $game_log['bonusTransferAmount'], $new_cash*100, $new_bouns*100, $userinfo['channel'], $userinfo['package_id']);
            $balance = slotsCommon::slotsLog($game_log, $userinfo['coin'], $userinfo['bonus'], $param['betAmount']*100, $param['winloseAmount']*100);
            if ($balance['code'] != 200){
                Log::error('uid:'.$userinfo['uid'].'slotsLog三方游戏记录存储失败');
                Db::rollback();
                return json(['errorCode'=>5, 'message'=>'Other error']);
            }
            Db::commit();

            //发送消息队列
            /*if ($res) {
                $amqpDetail = config('rabbitmq.slots_queue');
                MqProducer::pushMessage($game_log, $amqpDetail);
            }*/

            //回复
            $data = [
                'errorCode' => 0,
                'message' => 'Success',
                'username' => (string)$userinfo['uid'],
                'currency' => Config::get('jlslots.currency'),
                'balance' =>  (float)bcdiv($balance['data'], 100, 2),
                'txId' =>  (int)$ordersn,
            ];

            return json($data);

        }catch (Exception $exception){
            Db::rollback();
            Log::record("错误文件===" . $exception->getFile() . '===错误行数===' . $exception->getLine() . '===错误信息===' . $exception->getMessage());
            return json(['errorCode'=>5, 'message'=>'Other error']);
        }

    }

    /**
     * 取消注单
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function cancelBet(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'reqId' => 'require',
            'currency' => 'require',
            'game' => 'require',
            'round' => 'require',
            'betAmount' => 'require',
            'winloseAmount' => 'require',
            'userId' => 'require',
            'token' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("注单接口数据验证失败===>".$validate->getError());
            return json(['errorCode'=>3, 'message'=>'Missing parameters']);
        }


        $userinfo = Db::name('user_token')
            ->alias('a')
            ->leftJoin('userinfo b','a.uid=b.uid')
            ->where('a.token',$param['token'])
            ->field('a.uid,IFNULL(b.coin,0) AS coin,IFNULL(b.bonus,0) AS bonus,b.channel,b.package_id')
            ->find();
        //dd($userinfo);
        if (empty($userinfo)){
            Log::record("取消注单token无效");
            return json(['errorCode'=>3, 'message'=>'Invalid parameter']);
        }
        //bonus不带入
        $userinfo['bonus'] = config('slots.is_carry_bonus') == 1 ? $userinfo['bonus'] : 0;

        $pre = 'br_';
        $table = 'slots_log_' . date('Ymd');
        $res = Db::query("SHOW TABLES LIKE '$pre$table'");
        if (!$res){
            Log::record("注单记录表不存在");
            return json(['errorCode'=>5, 'message'=>'Other error']);
        }

        $log = Db::name($table)->where('betId',$param['round'])->find();
        if (empty($log)){
            Log::record("取消注单 ，注单不存在");
            return json(['errorCode'=>2, 'message'=>'Round not found']);
        }else{
            Log::record("取消注单 ，注单已成立");
            return json(['errorCode'=>6, 'message'=>'Already accepted and cannot be canceled']);
        }

    }




    /******************************转账模式*******************************/

    private static $herder = [
        'Content-Type: application/x-www-form-urlencoded',
    ];

    public static function GetGame(){


        $url = Config::get('jlslots.api_url').'/GetGameList';
        $data = [
            'AgentId' => Config::get('jlslots.AgentId'),
        ];
        $data['Key'] = self::getKey($data);
        $res = self::senPostCurl($url,$data);

        if(!$res || $res['ErrorCode'] !== 0){
            return ['code' => 201,'msg' => $res['Message'] ,'data' =>[]];
        }

        return ['code' => 200,'msg' => $res['Message'] ,'data' =>$res['Data']];
    }


    /**
     * 创建玩家
     * @param $uid  玩家uid
     * @return bool|string
     */
    public static function playerCreated($uid){

        $url = Config::get('jlslots.api_url').'/CreateMember';
        $data = [
            'Account' => $uid,
            'AgentId' => Config::get('jlslots.AgentId'),
        ];

        $data['Key'] = self::getKey($data);

        $res = self::senPostCurl($url,$data);

        if(!$res || ($res['ErrorCode'] !== 0 && $res['ErrorCode'] !== 101)){
            return ['code' => 201,'msg' => '' ,'data' =>[]];
        }
        return ['code' => 200,'msg' => $res['Message'] ,'data' =>[]];

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






