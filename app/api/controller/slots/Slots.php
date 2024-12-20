<?php
/**
 * 游戏
 */

namespace app\api\controller\slots;


use app\api\controller\ReturnJson;
use app\api\controller\slots\Pgslots;
use app\api\controller\slots\Ppslots;
use app\api\controller\slots\Tdslots;
use crmeb\basic\BaseController;
use think\facade\Config;
use think\facade\Db;
use think\facade\Log;


class Slots extends BaseController {


    /**
     * 用户Cash和Bonus流水记录
     * @return void
     */
    public function SlotsLog(){
        $uid = input('uid');
        $page = input('page') ?? 1; //当前页数
        $table = 'br_slots_log_';
        $field = "FROM_UNIXTIME(betEndTime,'%d/%m/%Y %H:%i') as betEndTime,englishname,(cashTransferAmount + bonusBetAmount) as BetAmount,(cashTransferAmount + bonusTransferAmount) as TransferAmount";
        $where = [['uid','=',$uid]];
        $dateArray = \dateTime\dateTime::createDateRange(strtotime('-30 day'),time(),'Ymd');
        $dayDescArray = array_reverse($dateArray);
        $list = \app\admin\controller\Model::SubTableQueryPage($dayDescArray,$table,$field,$where,'betEndTime',$page);

        return ReturnJson::successFul(200,$list);
    }


    /**
     * @param  $type 游戏厂商类型 pp td
     * @param  $game_id 游戏id
     * @return void 获取免费游戏url
     */
    private function getFreeGameUrl($type,$game_id){
        if($type == 'pp'){
            return vsprintf(config('ppsoft.fee_entry_address'),[$game_id]);
        }elseif ($type == 'td'){
            return vsprintf(config('tdsoft.fee_entry_address'),[$game_id,Config::get('tdsoft.language')]);
        }
        return '';
    }

    /**
     * @return void 创建3方游戏玩家
     */
    public function createPayer(){
        $uid = $this->request->post('uid');
//        $this->getPgPaerID($uid); //获取Pg用户唯一标识
        $this->getPpPaerID($uid);  //创建pp游戏玩家
        $this->getTdPaerID($uid);  //创建Td游戏玩家
        return ReturnJson::successFul(200);
    }

    /**
     * @return void 得到游戏的url
     */
    public function getGameUrl(){
        $uid = $this->request->post('uid');
        $id = $this->request->post('id');  //游戏id

        $slots_game = Db::name('slots_game')
            ->alias('a')
            ->field("b.type,a.slotsgameid")
            ->join('slots_terrace b','b.id = a.terrace_id')
            ->where(['a.status' => '1','a.maintain_status' => 1,'a.id' => $id])
            ->find();
        if($slots_game['type'] == 'pg'){
            $this->getPgPaerID($uid);
            //运营商后端的响应需要传入以下标头（headers），以防止响应被存储在缓存中：
            header('Cache-Control: no-cache, no-store, must-revalidate');

            //测试服
            $url = 'https://cg.teenpatticlub.shop/api/Cepgbx/getGameUrl';
            $geturlData = [
                'gameid' => $slots_game['slotsgameid'],
            ];
            $data['GameUrl'] = Pgslots::http_post($url,$geturlData,[]);
            $data['type'] = 1;
            //正式服
//            $GameUrl = Pgslots::getGameUrl($slots_game['slotsgameid']);

//            $GameUrl = config('redis.domain').'/api/slots.Slots/runGame?htmlContent='.base64_encode(urlencode($oldGameUrl));

        }elseif ($slots_game['type'] == 'pp'){
            $this->getPpPaerID($uid);
            $res = Ppslots::getGameUrl($uid,$slots_game['slotsgameid']);
            if($res['code'] != 200) return ReturnJson::failFul(224);

            $data['GameUrl'] = $res['data'];
            $data['type'] = 1;
        }elseif ($slots_game['type'] == 'td'){
            $this->getTdPaerID($uid);
            $res = Tdslots::getGameUrl($uid,$slots_game['slotsgameid']);
            if($res['code'] != 200) return ReturnJson::failFul(224);
            $data['GameUrl'] = $res['data'];
            $data['type'] = 1;

        }else{
            return ReturnJson::failFul(225);
        }
        $data['freeUrl'] = $this->getFreeGameUrl($slots_game['type'],$slots_game['slotsgameid']);
        // dd($GameUrl);
        // return json(['code' => 200 ,'msg' => 'success','data' => $GameUrl]);
        return ReturnJson::successFul(200,$data);
    }


    /**
     * pg需要直接访问网页
     * @param $htmlContent 网页
     * @return void
     */
    public function runGame($htmlContent){
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: text/html');
//        dd(urldecode(base64_decode($htmlContent)));
        echo urldecode(base64_decode($htmlContent));
    }

    /**
     * 充值
     * @param $type 商家类型  pp , pg
     * @return void
     */
    public function Cash(){
        $uid = input('uid');
        $type = input('type');  // 商家类型  pp , pg
//        Log::error('uid:'.$uid.'type:'.$type);

        if($type != 'pp' && $type != 'pg' && $type != 'td'){
            return;
        }

        $redis = new \Redis();
        $redis->connect(config('redis.ip'),config('redis.port1'));
        $oldType = $redis->hGet('slotsType',$uid);  //获取上一次充值的游戏商
        $redis->hSet('slotsType',$uid,$type); //检测是否进入三判断用户进入的是哪个三方
        $this->CashStartTrans($uid,$type,$oldType);
    }






    /**
     * @return void 转出用户金额
     */
    public function transferAllOut(){
        $uid  = input('uid');
        $redis = new \Redis();
        $redis->connect(Config::get('redis.ip'), Config::get('redis.port1')); //6501
        $type = $redis->hGet('slotsType',$uid); //获取上次用户进三方游戏的类型
        $this->Transfer($uid,$type,1,$redis);
        return ReturnJson::successFul();
    }


    /**
     * @param $uid 用户uid
     * @param $type 游戏类型
     * @param $status  状态： 1 = 转出余额时需要删除redis，2=充值时检测到跟之前不一样，不需要删除redis的值
     * @param $redis
     */
    public function Transfer($uid,$type,$status,$redis = ''){

        if(!$type){
            return ['code' => 200,'msg'=> '','data' => []];
        }

        if($type == 'pg'){
            $pgslots_player = Db::name('pgslots_player')->where('uid',$uid)->find(); //如果用户还没有的话就不用查看，
        }elseif ($type == 'pp'){
            $pgslots_player = Db::name('ppslots_player')->where('uid',$uid)->find(); //如果用户还没有的话就不用查看，
        } elseif($type == 'td'){
            $pgslots_player = Db::name('tdslots_player')->where('uid',$uid)->find(); //如果用户还没有的话就不用查看，
        }else{
            return ;
        }

        if(!$pgslots_player){
            return ['code' => 200,'msg'=> '','data' => []];
        }


        //转出
        $ordersn = \customlibrary\Common::doOrderSn(555);

        if($type == 'pg'){
            $res = $this->PgTransfer($ordersn,$uid);
        }elseif($type == 'pp'){
            $res = Ppslots::transferAllOut($ordersn,$uid);
        }elseif($type == 'td'){
            $res = Tdslots::transferAllOut($ordersn,$uid);
        }else{
            return;
        }


        if($res['code'] == 200){
            if($status === 1)$redis->hDel('slotsType',$uid); //删除判断信息
            if($res['data']['money'] > 0){
                $amount = bcmul($res['data']['money'],100,0);

                $slots_cash = [
                    'uid' => $uid,
                    'order_no' => $ordersn,
                    'terrace_name' => $type,
                    'recharge_amount' => 0,
                    'transaction_id' => $res['data']['transactionId'],
                    'before' => $amount,
                    'amount' => $amount,
                    'after' => 0,
                    'createtime' => time(),
                    'type' => 2
                ];
                Db::name('slots_cash')->insert($slots_cash);

                $res = \app\common\xsex\User::userEditCoin($uid,$amount,3,'玩家:'.$uid.'转出Slots余额:'.bcdiv($amount,100,2));
//                if(!$res) return ['code' => 223,'msg'=>'用户扣除余额失败','data' => []];


                return ['code' => 200,'msg'=> '','data' => []];

            }
        }
    }



    /**
     * @return void 获取Pg历史记录 定时任务
     */
    public function getPgHistory($count = 0){
        $row_version = Db::name('row_version')->where('terrace','pg')->where('type','RNG')->order('id','desc')->find();
        if(!$row_version){
            $row_version_data = [
                'row_version' => 1,
                'terrace' => 'pg',
                'type' => 'RNG',
            ];
            $row_version_id = Db::name('row_version')->insertGetId($row_version_data);
            if(!$row_version_id){
                echo '201=set error1';
                exit();
            }
            $row_version_time = 1;
        }else{
            $row_version_time = $row_version['row_version'];
            $row_version_id = $row_version['id'];
        }


        $data = [
            'count' => 2000,  //获取条数范围1500-5000
            'row_version' => $row_version_time,  //首次为1，之后的话就得到她之前返回的值
        ];

        //测试服
        $url = 'https://cg.teenpatticlub.shop/api/Cepgbx/getHistory';
        $getHistory = Pgslots::http_post($url,$data,[]);

        //正式服
//        $getHistory = Pgslots::getHistory($data['count'],$data['row_version']);

        $getHistorydata = isset(json_decode($getHistory,true)['data']) ?  json_decode($getHistory,true)['data'] : '';
        if(!$getHistorydata){
            if($count <= 3){
                $count += 1;
                $this->getPgHistory($count);
                exit();
            }
            echo '201=数据获取失败';
            exit();
        }
        $end = end($getHistorydata); //获取数组中的最后一个值
        //存储数据

        if(count($getHistorydata) <= 0){
            echo '200=数据无需跟改';

            exit();
        }
        $page_id = Db::name('slots_terrace')->where('type','=','pg')->value('id'); //获取pc的id
        $slots_game = Db::name('slots_game')->where(['terrace_id' => $page_id])->column('englishname,id','slotsgameid');

        if($row_version_time != 1){ //第一条数据重复如果不为1
            unset($getHistorydata[0]);
        }
        if(count($getHistorydata) <= 0){
            echo '200=数据无需跟改';

            exit();
        }
        $list = [];  //游戏日志
        $user_day = [];
        $parent_winAmount = []; //每个母账单的总和
        $parent_status = []; //每个母账单的总和

        foreach ($getHistorydata as $v){
            $listchar = [
                'betId' => $v['betId'],
                'parentBetId' => $v['parentBetId'],
                'uid' => $v['playerName'],
                'slotsgameid' => $v['gameId'],
                'englishname' => $slots_game[$v['gameId']]['englishname'],
                'game_id' => $slots_game[$v['gameId']]['id'],
                'betAmount' => bcmul($v['betAmount'],100,0),
                'winAmount' => bcmul($v['winAmount'],100,0),
                'balanceAfter' => bcmul($v['balanceAfter'],100,0),
                'lottery_multiplier' => $v['betAmount'] == 0 ? '' : ($v['winAmount'] > 0 ? bcdiv($v['winAmount'], $v['betAmount'], 2) : 0),
                'status' => $v['handsStatus'] == 1 ? '-1' : ($v['handsStatus'] == 2 ? '1' : '-2'),
                'type' => $v['betId'] == $v['parentBetId'] ? '1' : '2',
                'betTime' => mb_substr($v['betTime'],0,-3),
                'betEndTime' => mb_substr($v['betEndTime'],0,-3),
                'createtime' => time(),
                'terrace_name' => 'PG',
            ];
            $this->setShuju($listchar,$list,$user_day,$parent_winAmount,$parent_status);
        }

        $res = $this->saveHistoryData($list,$user_day,$parent_winAmount,$parent_status,$row_version_id,$end['rowVersion']);
        if($res['code'] != 200){
            echo '201='.$res['msg'];
            exit();
        };

        if(count($getHistorydata) >= $data['count']){ //如果本次数据没有获取完,就再次请求数据
            $this->getPgHistory(0);

            exit();
        }
        echo '200=成功';

        exit();
    }

    /**
     * @return void 获取Pp历史记录 定时任务
     * @param $dataType 产品组合类 RNG 视频老虎机、经典老虎机等 ,LC 真人娱乐场产品组合,VSB 虚拟体育博彩产品组合,BNG 宾果 产品
     */
    public function getPpHistory($dataType = 'RNG',$count = 0){

        $row_version = Db::name('row_version')->where('terrace','pp')->where('type',$dataType)->order('id','desc')->find();

        if(!$row_version){
            $localDateTime = '2023-07-31 23:50:00'; // 巴西本地时间
            $timezone = new \DateTimeZone('America/Sao_Paulo'); // 设置本地时区为 'Asia/Shanghai'
            $datetime = new \DateTime($localDateTime, $timezone); // 创建一个 DateTime 对象，设置时间为本地时间
            $datetime->setTimezone(new \DateTimeZone('GMT')); // 将时区设置为 GMT0
            $gmt_timestamp = $datetime->getTimestamp(); // 获取 GMT0 时间戳
            $row_version_data = [
                'row_version' => $gmt_timestamp.'000',
                'type' => $dataType,
                'terrace' => 'pp',
            ];
            $row_version_id = Db::name('row_version')->insertGetId($row_version_data);
            if(!$row_version_id){
                echo '201=set error1';
                exit();
            }
            $row_version_time = $gmt_timestamp.'000';
        }else{
            $row_version_time = $row_version['row_version'];
            $row_version_id = $row_version['id'];
        }

        $getHistory = Ppslots::getHistory($row_version_time,$dataType);
        if(!$getHistory || $getHistory == 'null'){
            if($count <= 3){
                $count += 1;
                $this->getPpHistory($dataType,$count);

                exit();
            }
            echo '201=数据获取失败';

            exit();
        }
        $getHistorydata = $getHistory['data'];
        if(!$getHistorydata){
            Db::name('row_version')->where('id',$row_version_id)->update(['row_version' => $getHistory['timepoint'],'updatetime'=>time()]);
            echo '200=暂无数据修改';
            exit();
        }

        $page_id = Db::name('slots_terrace')->where('type','=','pp')->value('id'); //获取pc的id
        $slots_game = Db::name('slots_game')->where(['terrace_id' => $page_id])->column('englishname,id','slotsgameid');

        $list = [];  //游戏日志
        $user_day = [];
        $parent_winAmount = []; //每个母账单的总和
        $parent_status = []; //每个母账单的总和
        foreach ($getHistorydata as $v){
            $listchar = [
                'betId' => $v['playSessionID'],
                'parentBetId' => $v['parentSessionID'] == 'null' || !$v['parentSessionID'] ? $v['playSessionID'] : $v['parentSessionID'],
                'uid' => $v['extPlayerID'],
                'slotsgameid' => $v['gameID'],
                'englishname' => $slots_game[$v['gameID']]['englishname'],
                'game_id' => $slots_game[$v['gameID']]['id'],
                'betAmount' => bcmul($v['bet'],100,0),
                'winAmount' => bcmul($v['win'],100,0),
                'balanceAfter' => bcmul($v['balance'],100,0),
                'lottery_multiplier' => $v['bet'] == 0 ? '' : ($v['win'] > 0 ? bcdiv($v['win'], $v['bet'], 2) : 0),
                'status' => $v['status'] == 'C' ? 1 : -1,
                'type' => $v['parentSessionID'] == 'null' || !$v['parentSessionID'] ? '1' : '2',
                'betTime' => $v['startDate'],
                'betEndTime' => $v['endDate'],
                'createtime' => time(),
                'terrace_name' => 'PP',
            ];
            $this->setShuju($listchar,$list,$user_day,$parent_winAmount,$parent_status);

        }

        $res = $this->saveHistoryData($list,$user_day,$parent_winAmount,$parent_status,$row_version_id,$getHistory['timepoint']);
        if($res['code'] != 200){
            echo '201='.$res['msg'];

            exit();
        }

        echo '200=成功';

        exit();
    }



    /**
     * @return void 获取Td历史记录 定时任务
     * @param $dataType 产品组合类 RNG Slots等  ，''
     * @param $row_version_time 请求的开始时间
     */
    public function getTdHistory($dataType = 'RNG' ,$page = 1,$count = 0,$row_version_time = ''){

        $row_version = Db::name('row_version')->where('terrace','td')->where('type',$dataType)->order('id','desc')->find();
        if(!$row_version){
            $localDateTime = '2023-09-20 15:00:00'; // 开始时间
            $row_version_data = [
                'row_version' => strtotime($localDateTime),
                'type' => $dataType,
                'terrace' => 'td',
            ];
            $row_version_id = Db::name('row_version')->insertGetId($row_version_data);
            if(!$row_version_id){
                echo '201=set error1';
                exit();
            }
            $row_version_time = strtotime($localDateTime);
        }else{
            $row_version_time = $row_version_time ?: $row_version['row_version']; //如果page = 1 时 用数据库的数据，大于一页时用第一页的时间
            $row_version_id = $row_version['id'];
        }

        $getHistory = Tdslots::getHistory($row_version_time,$page,$dataType);
        if(!$getHistory){
            if($count <= 3){
                $count += 1;
                $this->getTdHistory($dataType,$page,$count,$row_version_time);
                exit();
            }
            echo '201=数据获取失败';
            exit();
        }
        $getHistorydata = $getHistory['gameList'];
        if(!$getHistorydata){
            Db::name('row_version')->where('id',$row_version_id)->update(['row_version' => $getHistory['timepoint'],'updatetime'=>time()]);
            echo '200=暂无数据修改';
            exit();
        }

        $page_id = Db::name('slots_terrace')->where('type','=','td')->value('id'); //获取td的id
        $slots_game = Db::name('slots_game')->where(['terrace_id' => $page_id])->column('englishname,id','slotsgameid');

        $list = [];  //游戏日志
        $user_day = [];
        $parent_winAmount = []; //每个母账单的总和
        $parent_status = []; //每个母账单的总和
        foreach ($getHistorydata as $v){
            $listchar = [
                'betId' => $v['WagersId'],
                'parentBetId' => $v['WagersId'],
                'uid' => $v['Account'],
                'slotsgameid' => $v['GameId'],
                'englishname' => $slots_game[$v['GameId']]['englishname'],
                'game_id' => $slots_game[$v['GameId']]['id'],
                'betAmount' => bcmul(bcsub(0,$v['BetAmount'],2),100,0),
                'winAmount' => bcmul($v['PayoffAmount'],100,0),
                'balanceAfter' => 0,
                'lottery_multiplier' => $v['BetAmount'] == 0 ? '' : ($v['PayoffAmount'] > 0 ? bcdiv($v['PayoffAmount'], bcsub(0,$v['BetAmount'],2), 2) : 0),
                'status' =>  1,
                'type' =>  '1',
                'betTime' => Tdslots::getTime($v['WagersTime']),
                'betEndTime' => Tdslots::getTime($v['PayoffTime']),
                'createtime' => time(),
                'terrace_name' => 'TD',
            ];

            $this->setShuju($listchar,$list,$user_day,$parent_winAmount,$parent_status);

        }

        $res = $this->saveHistoryData($list,$user_day,$parent_winAmount,$parent_status,$row_version_id,$getHistory['timepoint']);
        if($res['code'] != 200){
            echo '201='.$res['msg'];
            exit();
        }

        if($getHistory['pageList']['CurrentPage'] < $getHistory['pageList']['TotalPages']){ //如果当前页数小于了总页数,继续请求
            $page = $page + 1;
            $this->getTdHistory($dataType,$page,$count,$row_version_time);

            exit();
        }

        echo '200=成功';
        exit();
    }


    /**
     * 获取用的PgTraceID 同时创建第三方用户
     * @param $uid
     * @param $nackname
     * @return void
     */
    public function getPgPaerID($uid){
        $pgslots_player = Db::name('pgslots_player')->where('uid',$uid)->find();

        if(!$pgslots_player){
            $trace_id = Pgslots::guid();
            Pgslots::setUserTraceId($uid,$trace_id);

            //测试服
            $data = [
                'player_name' => (string)$uid,
                'nickname' => (string)$uid,
                'guid' => $trace_id
            ];
            $url = 'https://cg.teenpatticlub.shop/api/Cepgbx/playerCreated';
            $playerCreate = Pgslots::http_post($url,$data,[]);

            //正式服
//            $playerCreate = Pgslots::playerCreated($nickname,$uid,$trace_id);

            $playerCreatedata = isset(json_decode($playerCreate,true)['data']) ?  json_decode($playerCreate,true)['data'] : '';
            $playerCreateerror = isset(json_decode($playerCreate,true)['error']) ?  json_decode($playerCreate,true)['error'] : '';

            if(!$playerCreatedata || $playerCreatedata['action_result'] != 1 || !in_array([1305,1315],$playerCreateerror['code'])){
                return 0;
            }
            $pgslots_player_data = [
                'uid' => $uid,
                'createtime' => time(),
            ];
            Db::name('pgslots_player')->replace()->insert($pgslots_player_data);

        }
        return 1;

    }

    /**
     * 创建用户的Pp三方用户uid
     * @param $uid
     * @return void
     */
    private function getPpPaerID($uid){
        $ppslots_player = Db::name('ppslots_player')->where('uid',$uid)->find();
        if(!$ppslots_player){
            $res = Ppslots::playerCreated($uid);
            if($res['code'] == 200){
                Db::name('ppslots_player')->replace()->insert([
                    'uid' => $uid,
                    'createtime' => time(),
                ]);
            }
        }
    }


    /**
     * 创建用户的Td三方用户uid
     * @param $uid
     * @return void
     */
    private function getTdPaerID($uid){
        $ppslots_player = Db::name('tdslots_player')->where('uid',$uid)->find();
        if(!$ppslots_player){
            $res = Tdslots::playerCreated($uid);
            if($res['code'] == 200){
                Db::name('tdslots_player')->replace()->insert([
                    'uid' => $uid,
                    'createtime' => time(),
                ]);
            }
        }
    }

    /** PG玩家转出
     * @param $ordersn 订单号
     * @param $uid uid
     * @return array
     */
    private function PgTransfer($ordersn,$uid){

        $redis = new \Redis();
        $redis->connect(Config::get('redis.ip'),Config::get('redis.port2')); //6502
        $redis->hSet('transfer_uids',$uid,1);

        //测试服
        $data = [
            'ordersn' => $ordersn,
            'player_name' => $uid,
        ];
        $url = 'https://cg.teenpatticlub.shop/api/Cepgbx/transferAllOut';
        $transferAllOut = Pgslots::http_post($url,$data,[]);


        //正式服
//        $transferAllOut = Pgslots::transferAllOut($ordersn,$uid);

        $transferAllOutdata = isset(json_decode($transferAllOut,true)['data']) ?  json_decode($transferAllOut,true)['data'] : '';
        if(!isset($transferAllOutdata['transactionId'])){
            if(strpos($transferAllOut,'Gateway Timeout') !== false || strpos($transferAllOut,'upstream request timeout') !== false || $transferAllOut === false) Db::name('timeout_slots')->insert([
                'ordersn' => $ordersn,
                'uid' => $uid
            ]);

            $redis->hDel('transfer_uids', $uid);

            \customlibrary\Common::log('Pgslots提现单号失败'.$ordersn.'===uid:'.$uid,$transferAllOut,3);
            return ['code' => 201,'msg' => '','data' => []];
        }
        $redis->hDel('transfer_uids', $uid);
        if($transferAllOutdata['balanceAmountBefore'] == 0){
            return ['code' => 200,'msg' => '','data' => ['money' => 0]];
        }
        return ['code' => 200,'msg' => '','data' => ['money' => $transferAllOutdata['balanceAmountBefore'],'transactionId' => $transferAllOutdata['transactionId']]];
    }


    /**
     * 充值
     * @param $uid 用户uid
     * @param $type 商家类型
     * @return void
     */
    private function CashStartTrans($uid,$type = 'pp',$oldType = ''){
        $ordersn = \customlibrary\Common::doOrderSn(666);
        $usericon = Db::name('userinfo')->where('uid',$uid)->value('coin');

        if($usericon <= 0 ){
            return ['code' => 200,'msg'=>'','data' => []];
        }

        //先扣取用户余额
        $res = \app\common\xsex\User::userEditCoin($uid,bcsub(0,$usericon,0),3,'玩家:'.$uid.'转入Slots带入:'.bcdiv($usericon,100,2));
        if(!$res) return ['code' => 223,'msg'=>'用户扣除余额失败','data' => []];

        if($type == 'pg'){
            //测试服
            $data = [
                'player_name' => $uid,
                'amount' => $usericon,
                'ordersn' => $ordersn,
            ];
            $url = 'https://cg.teenpatticlub.shop/api/Cepgbx/Cash';
            $Cash = Pgslots::http_post($url,$data,[]);

            //正式服
//            $Cash = Pgslots::Cash($ordersn,$usericon,$uid);

            $Cashdata = isset(json_decode($Cash,true)['data']) ?  json_decode($Cash,true)['data'] : '';
            if(!isset($Cashdata['transactionId'])){
                if(strpos($Cash,'Gateway Timeout') === false && strpos($Cash,'upstream request timeout') === false){ //如果没有请求超时的情况下，给用户退还充值金额
                    \app\common\xsex\User::userEditCoin($uid,$usericon,3,'玩家:'.$uid.'Pg游戏充值失败回退:'.bcdiv($usericon,100,2));

                    Log::error('Pgslots充值单号失败---uid:'.$uid.'订单号:'.$ordersn.'充值金额:'.$Cash);

                    \customlibrary\Common::log('Pgslots充值单号失败'.$ordersn.'====uid:'.$uid,$Cash,3);
                    return ['code' => 201,'msg'=>'Pgslots充值单号失败','data' => []];
                }
                Log::error('Pgslots充值订单请求超时---uid:'.$uid.'订单号:'.$ordersn.'充值金额:'.$Cash);

                \customlibrary\Common::log('Pgslots充值订单请求超时'.'====uid:'.$uid.$ordersn,$Cash,3);
                return ['code' => 201,'msg'=>'Pgslots充值订单请求超时','data' => []];
            }
            $Cashdata['balanceAmountBefore'] = bcmul($Cashdata['balanceAmountBefore'],100,0);
            $Cashdata['amount'] = bcmul($Cashdata['amount'],100,0);
            $Cashdata['balanceAmount'] = bcmul($Cashdata['balanceAmount'],100,0);
        }elseif ($type == 'pp'){
            $Cash = Ppslots::Cash($ordersn,$usericon,$uid);
            if($Cash['code'] != 200){
                return ['code' => 201,'msg' => '三方游戏充值失败','data' => []];
            }
            $Cashdata = [
                'transactionId' => $Cash['data'],
                'balanceAmountBefore' => 0,
                'amount' => $usericon,
                'balanceAmount' => $usericon,
            ];
        }elseif ($type == 'td'){
            $Cash = Tdslots::Cash($ordersn,$usericon,$uid);
            if($Cash['code'] != 200){
                return ['code' => 201,'msg' => '三方游戏充值失败','data' => []];
            }
            $Cashdata = [
                'transactionId' => $Cash['data']['TransactionId'],
                'balanceAmountBefore' => bcmul($Cash['data']['CoinBefore'],100,0),
                'amount' => $usericon,
                'balanceAmount' => bcmul($Cash['data']['CoinAfter'],100,0),
            ];
        }else{
            \app\common\xsex\User::userEditCoin($uid,$usericon,3,'玩家:'.$uid.'Pg游戏充值失败回退:'.bcdiv($usericon,100,2));
            return ['code' => 201,'msg' => '游戏类型错误','data' => []];
        }

        $slots_cash = [
            'uid' => $uid,
            'order_no' => $ordersn,
            'terrace_name' => $type,
            'recharge_amount' => $usericon,
            'transaction_id' => $Cashdata['transactionId'],
            'before' => $Cashdata['balanceAmountBefore'],
            'amount' => $Cashdata['amount'],
            'after' => $Cashdata['balanceAmount'],
            'createtime' => time(),
        ];

        Db::name('slots_cash')->insert($slots_cash);

        if($oldType && $oldType != $type){
            $this->Transfer($uid,$oldType,2);
        }
        return ['code' => 200,'msg' => 'success','data' => []];

    }
    private function setShuju($listchar,&$list,&$user_day,&$parent_winAmount,&$parent_status){
        if(!isset($puid[$listchar['uid']])){
            $puid_id = Db::name('user_team')->where('uid',$listchar['uid'])->value('puid');
            if($puid_id){
                $puid[$listchar['uid']] = $puid_id; //获取父级id
            }else{
                $puid[$listchar['uid']] = 0;
            }
        }


        $listchar['puid'] = $puid[$listchar['uid']];
        $listchar['profit'] = bcsub($listchar['winAmount'],$listchar['betAmount'],0);
        $list[] = $listchar;

        //第三方流水
        $user_day[$listchar['uid']]['total_outside_water_score'] = isset($user_day[$listchar['uid']]['total_outside_water_score']) ? bcadd($listchar['betAmount'],$user_day[$listchar['uid']]['total_outside_water_score'],0) : $listchar['betAmount'];
        //第三方总游戏次数
        if($listchar['type'] == 1){
            $user_day[$listchar['uid']]['total_outside_game_num'] = isset($user_day[$listchar['uid']]['total_outside_game_num']) ? bcadd(1,$user_day[$listchar['uid']]['total_outside_game_num'],0) : 1;
        }else{
            $user_day[$listchar['uid']]['total_outside_game_num'] = $user_day[$listchar['uid']]['total_outside_game_num'] ?? 0;
        }

        //统计玩家的package_id 和 channel
        if(!isset($user_day[$listchar['uid']]['package_id']) || !isset($user_day[$listchar['uid']]['channel'])){
            $userinfo = Db::name('userinfo')->field('package_id,channel')->where('uid',$listchar['uid'])->find();
            $user_day[$listchar['uid']]['channel'] = $userinfo['channel'];
            $user_day[$listchar['uid']]['package_id'] = $userinfo['package_id'];
        }

        //计算玩家总输赢
        $total_outside_score = bcsub($listchar['winAmount'],$listchar['betAmount'],0);
        $user_day[$listchar['uid']]['total_outside_score'] = isset($user_day[$listchar['uid']]['total_outside_score']) ? bcadd($total_outside_score ,$user_day[$listchar['uid']]['total_outside_score'],0) : $total_outside_score;
        //总利润
        $user_day[$listchar['uid']]['total_profit'] = isset($user_day[$listchar['uid']]['total_profit']) && $total_outside_score > 0 ? bcadd($total_outside_score ,$user_day[$listchar['uid']]['total_profit'],0) : ($user_day[$listchar['uid']]['total_profit'] ?? 0);

        //计算玩家返奖金额
        $user_day[$listchar['uid']]['total_outside_rebate_score'] = isset($user_day[$listchar['uid']]['total_outside_rebate_score']) ? bcadd($listchar['winAmount'] ,$user_day[$listchar['uid']]['total_outside_rebate_score'],0) : $listchar['winAmount'];

        //计算每个母账单的总和
        $parent_winAmount[$listchar['parentBetId']] = isset($parent_winAmount[$listchar['parentBetId']]) ? bcadd($parent_winAmount[$listchar['parentBetId']],$listchar['winAmount'],0) : $listchar['winAmount'];

        $parent_status[$listchar['parentBetId']] = (isset($parent_status[$listchar['parentBetId']]) && $parent_status[$listchar['parentBetId']] == 1) ? 1 :($listchar['status'] == 1 ? 1 : $listchar['status']);
    }


    private function saveHistoryData($list,$user_day,$parent_winAmount,$parent_status,$row_version_id,$rowVersion_time){
        foreach ($list as &$ll){  //修改母账单的 allwinAmount,allpayout,allprofit
            if(isset($parent_status[$ll['betId']])){  //说明数据中有母账单
                $ll['status'] = $parent_status[$ll['betId']];  //将状态变为统计的状态
                $ll['allwinAmount'] = $parent_winAmount[$ll['betId']];  //给总金额赋值
                $ll['allpayout'] = bcsub($parent_winAmount[$ll['betId']],$ll['betAmount'],0); //母账单总子账单的结算金额加起来 - 投注金额
                $ll['allprofit'] = $ll['betAmount'] == 0 ? $parent_winAmount[$ll['betId']] : bcdiv($parent_winAmount[$ll['betId']],$ll['betAmount'],2);  //所有子账单加自己的结算金额/投注金额
                unset($parent_status[$ll['betId']]);
            }else{
                $ll['allwinAmount'] = 0;
                $ll['allpayout'] = 0;
                $ll['allprofit'] = 0;
            }
            $ll['channel'] = $user_day[$ll['uid']]['channel'] ?? 0;
            $ll['package_id'] = $user_day[$ll['uid']]['package_id'] ?? 0;
        }

        Pgslots::getLogTable();//创建今日游戏日志表

        Db::startTrans();
        $table = 'slots_log_' . date('Ymd');
        $res = Db::name($table)->replace()->insertAll($list); //这里不用加入事务
        if(!$res){
            Db::rollback();
            return json(['code' => 201,'msg' => '游戏数据加入失败']);
        }

        if(count($parent_status) > 0){  //这里说明母账单没得在本次轮循中
            foreach ($parent_status as $key => $so){
                $slots_log = Db::name($table)->field('betId,allwinAmount,betAmount')->where('betId',$key)->find(); //查看今天的数据是否有母账单
                $table1 = $table;  //
                if(!$slots_log){  //如果今天的数据表没得，就在昨天的去找查看有没
                    $table1 = 'slots_log_' . date('Ymd',strtotime('-1 day'));
                    $sql = "SHOW TABLES LIKE 'br_".$table1."'";
                    if(!Db::query($sql)){
                        continue;
                    }
                    $slots_log = Db::name($table1)->field('betId,allwinAmount,betAmount')->where('betId',$key)->find(); //查看昨天的数据是否有母账单
                    if(!$slots_log){
                        continue;
                    }
                }

                $all_pg = [
                    'status' => $so,
                    'allwinAmount' => bcadd($slots_log['allwinAmount'],$parent_winAmount[$key],0),
                    'updatetime' => time(),
                ];
                $all_pg['allpayout'] = bcsub($all_pg['allwinAmount'],$slots_log['betAmount'],0); //母账单总子账单的结算金额加起来 - 投注金额
                $all_pg['allprofit'] = $slots_log['betAmount'] == 0 ? $all_pg['allwinAmount'] : bcdiv($all_pg['allwinAmount'],$slots_log['betAmount'],2);  //所有子账单加自己的结算金额/投注金额
                $res = Db::name($table1)->where('betId',$key)->update($all_pg);
                if(!$res){
                    Db::rollback();
                    return json(['code' => 201,'msg' => '之前的母账单跟新失败']);
                }
            }
        }

        $userphpexec_data = []; //发送gm命令,跟新用户总流水，总次数，总输赢
        //统计用户每日数据
        foreach ($user_day as $kk => $vv){
            $table1 = 'user_day_'.date('Ymd');
            $res = Db::name($table1)
                ->where('uid',$kk)
                ->update([
                    'total_outside_water_score' => Db::raw('total_outside_water_score + '.$vv['total_outside_water_score']),
                    'total_outside_game_num' => Db::raw('total_outside_game_num + '.$vv['total_outside_game_num']),
                    'total_outside_score' => Db::raw('total_outside_score + '.$vv['total_outside_score']),
                    'total_outside_rebate_score' => Db::raw('total_outside_rebate_score + '.$vv['total_outside_rebate_score']),
                    'update_num' => Db::raw('update_num + 1'),
                    'updatetime' => time(),
                ]);
            if(!$res){
                $share_strlog = Db::name('userinfo')->field('uid,bind_uid,vip')->where('uid',$kk)->find();
                if(!$share_strlog){
                    continue;
                }

                $user_day = [
                    'uid' => $share_strlog['uid'],
                    'channel' => $vv['channel'],
                    'bind_uid' => $share_strlog['bind_uid'],
                    'vip' => $share_strlog['vip'],
                    'total_outside_water_score' => $vv['total_outside_water_score'],
                    'total_outside_game_num' => $vv['total_outside_game_num'],
                    'total_outside_score' => $vv['total_outside_score'],
                    'total_outside_rebate_score' => $vv['total_outside_rebate_score'],
                    'update_num' => 1,
                    'package_id' => $vv['package_id'],
                    'updatetime' => time(),
                ];
                $res = Db::name($table1)->insert($user_day);
                if(!$res){
                    Db::rollback();
                    return json(['code' => 201,'msg' => 'userday存储失败']);
                }
            }
            $slots_profit_bili = SystemConfig::getConfigValue('slots_profit_bili') ?? 0;
            $total_profit = bcmul($vv['total_profit'],$slots_profit_bili,0);


            //检测清空打码量是否超过20分钟,如果超过20分钟不发流水
            $water_time_stamp = Db::name('water')->where([['uid','=',$kk],['operate','=',2]])->order('time_stamp','desc')->value('time_stamp');
            $waterStatus = 1;
            if($water_time_stamp && ($water_time_stamp + 1200) > time())$waterStatus = 0;

            //发送gm命令,跟新用户总流水，总次数，总输赢
            $jsonphp = json_encode(['msg_id' => 8,'uid'=>(int)$kk,'update_int64' => $waterStatus ? (int)$vv['total_outside_water_score'] : 0 ,'game_num' =>(int)$vv['total_outside_game_num'],'score' =>(int)$vv['total_outside_score'],'win_score' =>(int)$total_profit,'reason' => 19]);
            $userphpexec_data[] = [
                'type' => 100,
                'uid' => $kk,
                'jsonstr' => $jsonphp,
                'description' =>  '三方流水日志'.bcdiv($vv['total_outside_water_score'],100,2).'雷亚尔',
            ];

        }

        //把本次数据的最后一次请求时间设为开始时间
        $res = Db::name('row_version')->where('id',$row_version_id)->update(['row_version' => $rowVersion_time,'updatetime'=>time()]);
        if(!$res){
            Db::rollback();
            return ['code' => 201,'msg' => '请求时间修改失败'];
        }

        $res = Db::name('exec_php')->insertAll($userphpexec_data);
        if(!$res){
            Db::rollback();
            return ['code' => 201,'msg' => 'gm命令存储失败'];
        }




        Db::commit();
        return ['code' => 200,'msg' => '存储成功','data' => []];
    }
}




