<?php
namespace app\api\controller;
use app\common\xsex\User;
use think\facade\Config;
use think\facade\Db;
use crmeb\basic\BaseController;
use app\admin\model\system\SystemConfig;
use think\facade\Log;
/**
 *  用户提现
 */
class Withdrawlog extends BaseController{

    /**
     * @return void condition 页面
     */
    public function effecOrRequirWager(){
        $uid = input('uid');
        $packname = base64_decode(input('packname'));
        $type = input('type') ?? 1;   //类型:1 = pteffective,2 = sfeffective,3 = requierd
        $date = input('date') ? date('Ymd',input('date')) : date('Ymd');


        $page = input('page') ?? 1;
        $limit = 20;
        $page = ($page - 1) * $limit;
        $emptytime = input('timeStamp') ?? 0;  //上次清空时间
        if($type == 1){
            $table = 'game_records_'.$date;
            $sql = "SHOW TABLES LIKE 'br_".$table."'";
            $res = Db::query($sql);
            if(!$res){
                return ReturnJson::successFul('', [], $packname);
            }
            $water = Db::name($table)
                ->field('time_stamp,game_type,bet_score')
                ->where([['time_stamp','>',$emptytime],['bet_score','>',0]])
                ->where('uid',$uid)
                ->order('time_stamp','desc')
                ->page($page,$limit)
                ->select()
                ->toArray();

        }elseif ($type == 2){
            $table = 'slots_log_'.$date;
            $sql = "SHOW TABLES LIKE 'br_".$table."'";
            $res = Db::query($sql);
            if(!$res){
                return ReturnJson::successFul('', [], $packname);
            }
            $water = Db::name($table)
                ->field('betTime,englishname,betAmount')
                ->where('uid',$uid)
                ->where([['betTime','>',$emptytime],['betAmount','>',0]])
                ->order('betTime','desc')
                ->page($page,$limit)
                ->select()
                ->toArray();
        }else{
            $water = Db::name('water')
                ->field("coins,reason,give_score,operate,time_stamp,water")
                ->where('uid',$uid)
                ->where('reason','<>',103)
                ->where('operate','<>',2)
                ->where('time_stamp','>',$emptytime)
                ->order('time_stamp','desc')
                ->page($page,$limit)
                ->select()
                ->toArray();
            $water_conifg = Config::get('my.water');
            if($water){
                foreach ($water as &$v){
                    $v['multiple'] = bcdiv($v['water'],bcadd($v['coins'],$v['give_score'],0),0);
                    $v['reason'] = $water_conifg[$v['reason']] ?? '';
                }
            }
        }
//        return json(['code' => 200,'msg' => '成功','data' => $water]);
        return ReturnJson::successFul('', $water, $packname);
    }

    /**
     * @return void 提现历史记录
     */
    public function list(){
        $uid = input('uid');
        $page = input('page') ?? 1;
        $limit = 20;

        $withdraw_log = Db::name('withdraw_log')->field("FROM_UNIXTIME(createtime,'%Y/%m/%d %H:%i') as createtime,status,money")->where('uid','=',$uid)->order('createtime','desc')->page($page,$limit)->select()->toArray();

//        return json(['code' => 200 ,'msg'=>'','data' =>$withdraw_log ]);
        return ReturnJson::successFul(200, $withdraw_log,2);
    }

    /**
     * @return void 提现详情
     */
    public function view(){
        $uid = input('uid');
        $packname = base64_decode(input('packname'));
        $id = input('id');

        $withdraw_log = Db::name('withdraw_log')->field("bankaccount,FROM_UNIXTIME(createtime,'%m/%d %H:%i:%s') as createtime,status,ordersn,fee_money,money,really_money,type")->where([['uid','=',$uid],['id','=',$id]])->find();
        $list = config('data.withdrawlogview');

        foreach ($list as &$v){
            if($v['filed'] == 'status'){
                switch ($withdraw_log['status']){
                    case 1:
                        $v['val'] = 'Bem-sucedido';
                        $v['color'] = config('data.color')['green'];
                        break;
                    case -1:
                    case 2:
                        $v['val'] = 'Fracassada';
                        $v['color'] = config('data.color')['white'];
                        break;
                    default:
                        $v['val'] = 'Em processamento';
                        $v['color'] = config('data.color')['yellow'];
                }
                continue;
            }elseif ($v['filed'] == 'type'){ //	类型:1=CPF,2=CNPJ,3=EMAIL,4=PHONE,5=EVP
                if($withdraw_log['type'] == 1){
                    $v['val'] = 'CPF';
                }elseif ($withdraw_log['type'] == 2){
                    $v['val'] = 'CNPJ';
                }elseif ($withdraw_log['type'] == 3){
                    $v['val'] = 'EMAIL';
                }else{
                    $v['val'] = $withdraw_log['type'] == 4 ? 'PHONE' : 'EVP';
                }
                continue;
            }elseif ($v['filed'] == 'money' || $v['filed'] == 'fee_money' || $v['filed'] == 'really_money'){
                $v['val'] = 'R$'.str_replace(".", ",", bcdiv($withdraw_log[$v['filed']],100,2));
                continue;
            }

            $v['val'] = $withdraw_log[$v['filed']];
        }

//        return json(['code' => 200 ,'msg'=>'','data' =>$list ]);
        return ReturnJson::successFul('', $list, $packname);
    }

    /**
     * @return void 用户提现页面
     */
    public function index(){

        $uid = input('uid');

        $data = Db::name('userinfo')
            ->field('now_cash_score_water,need_cash_score_water,now_bonus_score_water,need_bonus_score_water,coin,bonus,need_water_bonus')
            ->where('uid',$uid)
            ->find();

        if(!$data)return ReturnJson::failFul(226);

        $withConfig = SystemConfig::getMore("with_min_money,with_max_money"); //退款最小金额
        $data['with_min_money'] = $withConfig['with_min_money'];  //系统最小退款金额
        $data['with_max_money'] = $withConfig['with_max_money'];  //系统最大退款金额
        $data['bonus_water_multiple'] = config('my.bonus_water_multiple');  //系统最大退款金额


        //获取用户提现的信息
        $data['user_withinfo'] = Db::name('user_withinfo')->where([['uid','=',$uid]])->column('account');

        //获取平台提现列表
        $data['withdraw_type'] = Db::name('withdraw_type')->field('id,englishname')->where('status','=','1')->order('weight','desc')->select()->toArray();

//        return json(['code' => 200,'msg' => '成功','data' => $data]);

        return ReturnJson::successFul(200, $data);
    }

    /**
     * 获取提现渠道
     * @param $money  用户提现金额
     * @param $withdraw_id_type_id  提现通道ID
     * @param $package_id  包名ID
     * @param $uid  用户UID
     */
    public function getWithdrawType($money,$withdraw_id_type_id,$package_id,$uid){
        //如果客户端传入了支付通道，直接拿取使用
        if($withdraw_id_type_id){
            $withdraw_type = Db::name('withdraw_type')
                ->where([
                    ['minmoney','<=',$money],
                    ['maxmoney','>=',$money]
                ])
                ->where(['id' => $withdraw_id_type_id,'status' => 1])
                ->find();
            if(!$withdraw_type) return ['code' => 244,'msg' => 'Sorry! No recharge channel has been matched yet','data' => []];
            return ['code' => 200,'msg' => 'success','data' => $withdraw_type];
        }
        $withdraw_type_ids = Db::name('apppackage_config')->where('package_id',$package_id)->value('withdraw_type_ids');

        $where = $withdraw_type_ids ? [['id','in',$withdraw_type_ids]] : [];

        $withdraw_type = Db::name('withdraw_type')
            ->field("id,name,IF(".self::getFreeStatus().",0,`fee_bili`) as fee_bili,IF(".self::getFreeStatus().",0,`fee_money`) as fee_money,weight")
            ->where([
                ['status' ,'=', '1'],
                ['minmoney','<=',$money],
                ['maxmoney','>=',$money]
            ])
            ->where($where)
            ->order('weight','desc')
            ->select()
            ->toArray();
        if(!$withdraw_type ) return ReturnJson::failFul(243,"Sorry! No refund channel has been matched yet!");

        if($uid){
            $withdraw_log = Db::name('withdraw_log')->field('status,withdraw_type')->where('uid',$uid)->order('id','desc')->find();
            if($withdraw_log && $withdraw_log['status'] == 2){
                $keyValue = 0;
                foreach ($withdraw_type as $key => $v){
                    if($v['name'] == $withdraw_log['withdraw_type']){
                        $keyValue = $key + 1;
                        break;
                    }
                }
                $withdraw_type = $withdraw_type[$keyValue] ?? $withdraw_type[0];
            }elseif ($withdraw_log && $withdraw_log['status'] == 1){
                $keyValue = 0;
                foreach ($withdraw_type as $key => $v){
                    if($v['name'] == $withdraw_log['withdraw_type']){
                        $keyValue = $key;
                        break;
                    }
                }
                $withdraw_type = $withdraw_type[$keyValue] ?? \app\api\controller\Order::getFirstPay($withdraw_type);
            }else{
                $withdraw_type = \app\api\controller\Order::getFirstPay($withdraw_type);
            }
        }else{
            $withdraw_type = \app\api\controller\Order::getFirstPay($withdraw_type);
        }



        return ['code' => 200,'msg' => 'success','data' => $withdraw_type];
    }

    /**
     * @return void 用户提现
     */
    public function add(){

        $uid = request()->uid;
        $money = input('money');  //用户提现金额已分为单位
        $account = input('account'); //提现信息
        $type = input('type') ?? 1; //1=Cash ,2=Bonus
        $withdraw_type_id   = input('withdraw_id_type_id');  //提现类型ID
        //获取需求流水和有效流水的字段
        [$now_score_water_field,$need_score_water_field] = $this->getWaterField($type);
        //平台退款手续费
        $pt_fee_momey = bcmul(SystemConfig::getConfigValue('withdraw_fee_bili'),$money,0);

        $really_money = bcadd($money ,$pt_fee_momey,0); //用户真实扣除的金额

        $userinfo = Db::name('userinfo')
            ->field("coin,bonus,(cash_total_score + bonus_total_score) as total_score,total_pay_score,total_give_score,total_exchange,package_id,channel,$now_score_water_field,$need_score_water_field")
            ->where('uid','=',$uid)
            ->find();

        if($userinfo['total_pay_score'] <= 0) return ReturnJson::failFul(239);

        if(!$money || !$account)return ReturnJson::failFul(219);

        //可用余额是否满足
        if($userinfo[$type == 1 ? 'coin' : 'bonus'] < $really_money) return ReturnJson::failFul(240);


        //抱歉!您当前的有效流水不足
        if($userinfo[$need_score_water_field] < 0 || $userinfo[$now_score_water_field] < $userinfo[$need_score_water_field])return ReturnJson::failFul(241);




        $with_min_money = SystemConfig::getConfigValue("with_min_money");
        if($with_min_money > $money) return ReturnJson::failFul(242);//抱歉!提现小于了最低提现金额

        $with_max_money = SystemConfig::getConfigValue("with_max_money");
        if($with_max_money < $money) return ReturnJson::failFul(253);//抱歉!提现大于了最高提现金额

        //用户每日提现次数
//        $Redis = new \Redis();
//        $Redis->connect(Config::get('redis.ip'),6502);
//        $withdraw_num = $Redis->hGet('vip_'.$userinfo['vip'],'withdraw_num');





        //用户提现平台判断
        $res = $this->getWithdrawType($money,$withdraw_type_id,$userinfo['package_id'],$uid);
        if($res['code'] != 200)return ReturnJson::failFul($res['code']);
        $withdraw_type = $res['data'];
        //用户提现信息判断
        $user_withinfo = $this->treatWithinfo($uid,$account);

        //获取用户今日退款的金额
        $user_withdraw_log = Db::name('withdraw_log')->field('money')->where([['uid','=',$uid],['status','not in',[-1,2]],['createtime','>=',strtotime('00:00:00')]])->select()->toArray();


        $day_with_moeny = 0;//用户今日提现金额
        $day_withdraw_num = 0;//用户今日提现次数
        if($user_withdraw_log)foreach ($user_withdraw_log as $val){
            $day_withdraw_num = $day_withdraw_num + 1;
            $day_with_moeny = bcadd($day_with_moeny,$val['money'],0);
        }


        //风控处理 ：auditdesc = 分控状态  ,user_withdraw_bili 用户提现率
        $withdraw_log_money = Db::name('withdraw_log')->where([['uid','=',$uid],['status','in',[0,3]]])->sum('money');

        $new_total_exchange = bcadd($userinfo['total_exchange'],$withdraw_log_money,0);

//        $cpf_withdraw_log = Db::name('withdraw_log')->field('id')->where(['cpf' => $user_withinfo['cpf'],'package_id' => $userinfo['package_id'],'status' => 1])->where('uid','<>',$uid)->find();

        [$auditdesc,$user_withdraw_bili,$firstmoney,$lastmoney] = $this->subControl($money,$day_with_moeny,$userinfo['coin'],$userinfo['total_pay_score'],$userinfo['total_give_score'],$new_total_exchange,$userinfo['total_score'],$day_withdraw_num);

        //手续费
        $fee = 0;

        if($withdraw_type['fee_bili'] && $withdraw_type['fee_bili'] > 0){  //比例手续费
            $fee = bcmul($withdraw_type['fee_bili'],$money,0);
        }
        if($withdraw_type['fee_money'] && $withdraw_type['fee_money'] > 0){ //固定手续费
            $fee = bcadd($withdraw_type['fee_money'],$fee,0);
        }



        //扣除用户余额
        $res = User::userEditCoin($uid,$really_money,4,'玩家:'.$uid."退款扣除:".bcdiv($really_money,100,2));
        if(!$res){
            Log::error('uid:'.$uid.'退款修改余额失败');
            return ReturnJson::failFul(245);
        }



        $data = [
            'uid' => $uid,
            'withdraw_type' => $withdraw_type['name'],
            'before_money' => $userinfo['coin'],  //用户之前的余额
            'ordersn' => \customlibrary\Common::doOrderSn(000),
            'fee_money' => $pt_fee_momey,  //平台手续费(分为单位)
            'fee' => $fee,  //三方手续费
            'money' => $money, //提现金额
            'really_money' => $money, //实际到账金额
            'bankaccount' => $user_withinfo['account'],
            'createtime' => time(),
            'packname' => request()->packname,
            'ip' => request()->ip(),
            'type' => $user_withinfo['type'],
            'package_id' => $userinfo['package_id'],
            'channel' => $userinfo['channel'],
            'auditdesc' => $auditdesc,
            'control' => $firstmoney.','.$lastmoney,
            'status' =>  $auditdesc == 0 ? 0 : 3,
            'cpf' =>  $user_withinfo['cpf'],
        ];


        $withdraw_log_id = Db::name('withdraw_log')->insertGetId($data);
        if(!$withdraw_log_id) return ReturnJson::failFul(246);


        //处理提现中间表
        $res = $this->withdrawLogCenter($withdraw_log_id,$userinfo['total_pay_score'],$userinfo['total_exchange'],$user_withdraw_bili,$userinfo[$now_score_water_field],$userinfo[$need_score_water_field],$uid,$userinfo['coin']);

        if(!$res) return ReturnJson::failFul(246);



        if($auditdesc != 0){
            if(SystemConfig::getConfigValue('is_tg_send') == 1) {
                //风控订单发送审核信息
                \service\TelegramService::withdrawRisk($data);
            }

            return ReturnJson::successFul();
        }

        $apInfo = \pay\Withdraw::withdraw($data,$data['withdraw_type'],2);
        if($apInfo['code'] != 200) return ReturnJson::failFul(246);


        $res = Db::name('withdraw_log')->where('id','=',$withdraw_log_id)->update(['platform_id'=> $apInfo['data'],'updatetime' => time()]);

        if(!$res) return ReturnJson::failFul(246);



//        return json(['code' => 200 ,'msg'=>'success','data' =>[] ]);
        return ReturnJson::successFul();
    }

    /**
     * 风控处理
     * @param $money 用户的提现金额
     * @param $day_with_moeny 今日提现金额
     * @param $coin 用户余额
     * @param $total_pay_score 	总充值金额
     * @param $total_give_score 总赠送余额
     * @param $total_exchange 总提现余额
     * @param $total_score 总输赢
     * @param $day_withdraw_num 今日退款次数
     * @return void
     */
    private function subControl($money,$day_with_moeny,$coin,$total_pay_score,$total_give_score,$total_exchange,$total_score,$day_withdraw_num){


        $firstmoney = bcadd($coin,$total_exchange,0); //用户余额 + 用户提现成功的金额 + 用户提现处理中的金额

        $lastmoney = bcadd(bcadd($total_pay_score,$total_give_score,0),$total_score,0); //总充值金额 + 总赠送金额 + 总输赢

        $user_withdraw_bili = $total_pay_score == 0 ? 0 : bcdiv($total_exchange,$total_pay_score,2); //总提现提现比例


        $withdraw_max_coin = SystemConfig::getConfigValue('withdraw_max_coin'); //玩家风控当笔最高提现金额(雷亚尔分)
        $withdraw_max_daycoin = SystemConfig::getConfigValue('withdraw_max_daycoin'); //玩家当日最高提现金额
        $customer_loss = SystemConfig::getConfigValue('customer_loss'); //玩家客损金额
        $withdraw_max_daynum = SystemConfig::getConfigValue('withdraw_max_daynum'); //玩家当日最大提现次数

        $user_customer_loss = $total_pay_score  - $firstmoney; //客损金额

        if ($withdraw_max_coin > 0 && $money >  $withdraw_max_coin){//单笔提现金额超过配置
            $auditdesc = 1;
        }elseif ($withdraw_max_daycoin > 0 && $withdraw_max_daycoin < $day_with_moeny){//当日提现金额超过配置
            $auditdesc = 3;
        }elseif ($withdraw_max_daynum > 0 && $withdraw_max_daynum < $day_withdraw_num){//一天内退款超过次数
            $auditdesc = 2;
        }elseif ($user_customer_loss < $customer_loss){//客损金额小于了配置
            $auditdesc = 4;
        }else{
            $auditdesc = 0;  //风控状态:0=正常提现,1=当笔最高提现超过配置,2=一天内退款超过次数,3=一天内累计退款超额,4=客损金额小于了配置
        }

        return [$auditdesc,$user_withdraw_bili,$firstmoney,$lastmoney];

    }

    /**
     * @param $withdraw_log_id  提现id
     * @param $ordersn  提现订单号
     * @param $total_pay_score  总充值金额
     * @param $total_exchange 总提现金额
     * @param $user_withdraw_bili 用户总提现率
     * @param $now_score_water 用户现在的流水
     * @param $need_score_water 用户需要的流水
     * @param $uid 用户uid
     * @param $now_withdraw_money 用户当前可提现金额
     * @return void
     */
    private function withdrawLogCenter($withdraw_log_id,$total_pay_score,$total_exchange,$user_withdraw_bili,$now_score_water,$need_score_water,$uid,$now_withdraw_money){

        [$phoneUid,$emailUid,$deviceUid,$ipUid,$cpfUid] = \app\api\controller\My::glTypeUid($uid);
        $allgluid = array_merge($phoneUid,$emailUid,$deviceUid,$ipUid,$cpfUid);
        $glUid = array_unique($allgluid); //去重
        $gl_user = 0;
        $gl_order = 0;
        $gl_withdraw = 0;
        $gl_refund_bili = 0;
        if(count($glUid) > 0){
            $gl_user = count($glUid); //关联用户数量
            $gl_order = Db::name('userinfo')->where([['uid','in',$glUid]])->sum('total_pay_score'); //关联用户充值金额
            $gl_withdraw = Db::name('userinfo')->where([['uid','in',$glUid]])->sum('total_exchange'); //关联用户提现金额
            $gl_refund_bili = $gl_order == 0 ? 0 : bcdiv($gl_withdraw,$gl_order,2); //关联用户提现率
        }

        $data = [
            'withdraw_id' => $withdraw_log_id,
            'order_coin' => $total_pay_score,
            'withdraw_coin' => $total_exchange,
            'withdraw_bili' => $user_withdraw_bili,
            'gl_user' => $gl_user,
            'gl_order' => $gl_order,
            'gl_withdraw' => $gl_withdraw,
            'gl_refund_bili' => $gl_refund_bili,
            'gl_device' => count($deviceUid),
            'gl_phone' => count($phoneUid),
            'gl_email' => count($emailUid),
            'gl_cpf' => count($cpfUid),
            'gl_ip' => count($ipUid),
            'now_total_water' => $now_score_water,
            'now_need_water' => $need_score_water,
            'now_withdraw_money' => $now_withdraw_money,
        ];

        $res = Db::name('withdraw_logcenter')->insert($data);
        if(!$res){
            return false;
        }
        return true;
    }

    /**
     * 获取有效流水和需求流水字段
     * @param $type 1 = CASH ,2=BONUS
     * @return void
     *
     */
    private function getWaterField($type = 1){
        return $type == 1 ? ['now_cash_score_water','need_cash_score_water'] : ['now_bonus_score_water','need_bonus_score_water'];
    }


    /**
     * 用户提现处理
     * @param $uid 用户UID
     * @param $account 提现信息
     * @return void
     */
    private function treatWithinfo($uid,$account){
        $user_withinfo = Db::name('user_withinfo')->where(['uid' => $uid,'account' => $account])->find();
        if(!$user_withinfo){
            $user_withinfo = [
                'uid' => $uid,
                'account' => $account,
                'type' => 1,
                'cpf' => $account,
                'packname' => request()->packname,
                'createtime' => time(),
            ];
            $user_withinfo_id = Db::name('user_withinfo')->insertGetId($user_withinfo);
            $user_withinfo['id'] = $user_withinfo_id;
        }
        return $user_withinfo;

    }

    /**
     * @return void 判断今日手续费是否免费
     */
    private static function getFreeStatus(){
        $zhouji = date('w') == 0 ? 7 : date('w');//获取今天是周几

        $withdrawal_fee_waived = explode("|",SystemConfig::getConfigValue('withdrawal_fee_waived'));
        $freeStatus = 0;
        if($withdrawal_fee_waived && in_array($zhouji,$withdrawal_fee_waived)){
            $freeStatus = 1;
        }
        return $freeStatus;
    }

    /**
     * 获取用户提现金额
     * @param $uid uid
     * @return int
     * @return void
     */
    public static function getUserTotalExchangeMoney($uid){
        return Db::name('withdraw_log')->where([['uid','=',$uid],['status','in',[0,3,1]]])->sum('money');
    }

    /**
     * goopagopay提现回调
     * @return false|string|void
     */
    public function goopagopayNotify() {
        $data = file_get_contents("php://input");  //Content-Type: application/json; charset=utf-8
        Log::error('goopagopay提现:'.$data);
        $data=json_decode($data,true);
        $ordersn =$data['mchOrderNo'];
        $status = $data["status"] == 2 ? 1 : 2;  // 1 成功 2 失败
        if(!$ordersn)return '获取提现回调参数错误';//订单信息错误
        $res = $this->Withdrawhandle($ordersn,$status,$data);

        if($res['code'] == 200){
            return "SUCCESS";
        }
        Db::name('log')->insert(['out_trade_no'=> $ordersn,'log' => '平台事务处理失败-'.$res['msg'],'type'=>2,'createtime' => time()]);

        //发送提现失败消息to Tg
        //\service\TelegramService::withdrawFail($ordersn,$data);
    }


    /**
     * cashpag_pay提现回调
     * @return false|string|void
     */
    public function cashpagpayNotify() {
        $data = file_get_contents("php://input");  //Content-Type: application/json; charset=utf-8
        Log::error('cashpag_pay提现:'.$data);
        $data=json_decode($data,true);
        $ordersn =$data['merchantOrderId'];
        if($data["status"] == 00 || $data["status"] == 99){
            Db::name('log')->insert(['out_trade_no'=> $ordersn,'log' => json_encode($data).'cashpag_pay提现订单处理中','type'=>2,'createtime' => time()]);
            return 'success';
        }
        $status = $data["status"] == 01 ? 1 : 2;  // 1 成功 2 失败
        if(!$ordersn)return '获取提现回调参数错误';//订单信息错误
        $res = $this->Withdrawhandle($ordersn,$status,$data);

        if($res['code'] == 200){
            return 'success';
        }
        Db::name('log')->insert(['out_trade_no'=> $ordersn,'log' => '平台事务处理失败-'.$res['msg'],'type'=>2,'createtime' => time()]);

        //发送提现失败消息to Tg
        //\service\TelegramService::withdrawFail($ordersn,$data);
    }


    /**
     * 提现统一处理
     * @param $ordersn 订单号
     * @param $status 提现状态:1=成功,2=失败
     * @param $data 第三方数据
     * @return void
     */
    public function Withdrawhandle($ordersn,$status,$data){

        $withdraw_log = Db::name('withdraw_log')->where('ordersn',$ordersn)->find();
        if(!$withdraw_log){
            return ['code' => 201 ,'msg'=>'','data' => []];
        }

        if($withdraw_log['status'] == 1 || $withdraw_log['status'] == -1 || $withdraw_log['status'] == 2){
            return ['code' => 200 ,'msg'=>'','data' => []];
        }


        //发送邮件与短信
//        $userInfoEP = Db::name('share_strlog')->field('phone,email')->where('uid',$withdraw_log['uid'])->find();


        if($status == 1){ //成功
            $res = Db::name('withdraw_log')->where('ordersn',$ordersn)->update(['finishtime' => time(),'status' => 1]);

            if(!$res){
                return ['code' => 201 ,'msg'=>'提现状态修改失败1','data' => []];
            }

            $share_strlog = Db::name('userinfo')->field('uid,puid,channel,package_id,vip')->where('uid',$withdraw_log['uid'])->find();

            Db::startTrans();

            $user_day =  [
                'uid' => $withdraw_log['uid'].'|up',
                'puid' => $share_strlog['puid'].'|up',
                'vip' => $share_strlog['vip'].'|up',
                'channel' => $share_strlog['channel'].'|up',
                'package_id' => $share_strlog['package_id'].'|up',
                'total_exchange' => $data['total_exchange'].'|raw-+',
                'total_exchange_num' => '1|raw-+',
            ];

            //user_day表处理
            $user_day = new SqlModel($user_day);
            $res = $user_day->userDayDealWith();
            if(!$res){
                Db::rollback();
                return ['code' => 201 ,'msg'=>'user_day数据表处理失败','data' => []];
            }


            $res = Db::name('userinfo')->where('uid',$withdraw_log['uid'])
                ->update([
                    'total_exchange' => Db::raw('total_exchange + '.$withdraw_log['money']),
                    'total_exchange_num' => Db::raw('total_exchange_num + 1'),
                    'updatetime' => time(),
                    'bonus' => 0,
                    'need_bonus_score_water' => 0,
                    'need_water_bonus' => 0,
                    'now_bonus_score_water' => 0,
                ]);
            if(!$res){
                Db::rollback();
                return ['code' => 201 ,'msg'=>'修改用户的总提现金额失败','data' => []];
            }

            //发送邮件
//            $email = $userInfoEP['email'] ?: $withdraw_log['email'];
//            if($email) Sms::sendEmali($email,'','withdrawlog',$withdraw_log['backname'],[$withdraw_log['money'],$withdraw_log['bankaccount'],$ordersn]);

//            $phone = $userInfoEP['phone'] ?: $withdraw_log['phone'];
//            if($phone) Sms::sendSms($phone,'withdrawlog',[$withdraw_log['money'],'',$ordersn]);



        }else{ //失败
            //修改订单状态
            $res = Db::name('withdraw_log')->where('ordersn',$ordersn)->update(['finishtime' => time(),'status' => 2]);
            if(!$res){
                return ['code' => 201 ,'msg'=>'提现状态修改失败2','data' => []];
            }

            Db::startTrans();

            Db::name('log')->insert(['out_trade_no'=> $ordersn,'log' => json_encode($data),'type'=>8,'createtime' => time()]);

            //返回用户的提现金额  退款的reason
            \app\common\xsex\User::userEditCoin($withdraw_log['uid'],$withdraw_log['money'],5, "玩家三方回调" . $withdraw_log['uid'] . "退还提现金额" . bcdiv($withdraw_log['money'],100,2));

        }

        Db::commit();
        if(SystemConfig::getConfigValue('is_tg_send') == 1) {
            //发送提现成功消息to Tg
            $status == 1 ? \service\TelegramService::withdrawSuc($withdraw_log) : \service\TelegramService::withdrawFail($withdraw_log, $data);
        }

        return ['code' => 200 ,'msg'=>'','data' => []];
    }

}
