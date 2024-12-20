<?php
namespace app\api\controller;

use app\admin\model\system\SystemConfig;
use app\api\controller\Adjust;
use think\facade\Config;
use think\facade\Db;
use think\facade\Log;
use crmeb\basic\BaseController;
use \app\common\xsex\User;
class Order extends BaseController {

    private static $fbPointPackageID = [];

    /**
     * 订单列表
     */
    public function index(){
        $uid = input('uid');
        $packname   = base64_decode(input('packname'));
        $page = input('page') ?: 1;
        $limit = 10;
        $page = ($page - 1) * $limit;
        $order = Db::name('order')->field("id,FROM_UNIXTIME(createtime,'%m/%d %H:%i:%s') as createtime,pay_status,price")->where('uid','=',$uid)->order('createtime','desc')->page($page,$limit)->select()->toArray();
        foreach ($order as &$v){
            if($v['pay_status'] == 1){
                $v['pay_status'] = 'Successful';
                $v['color'] = config('data.color')['green'];
            }else{
                $v['pay_status'] = 'Processing';
                $v['color'] = config('data.color')['white'];
            }
        }
        return ReturnJson::successFul('success', $order, $packname);
    }

    /**
     * @return void 订单详情
     */
    public function view(){
        $packname   = base64_decode(input('packname'));
        $order_id = input('id');
        $order = Db::name('order')->field("FROM_UNIXTIME(createtime,'%m/%d %H:%i:%s') as createtime,pay_status,price,ordersn")->where('id','=',$order_id)->find();
        $list = config('data.orderview');
        foreach ($list as &$v){
            if(!$v['filed']){
                continue;
            }
            if($v['filed'] == 'pay_status'){
                switch ($order['pay_status']){
                    case 1:
                        $v['val'] = 'Successful';
                        $v['color'] = config('data.color')['green'];
                        break;
                    default:
                        $v['val'] = 'Processing';
                        $v['color'] = config('data.color')['white'];
                }
                continue;
            }elseif ($v['filed'] == 'price'){
                $v['val'] = '₹'.bcdiv($order[$v['filed']],100,2);
                continue;
            }

            $v['val'] = $order[$v['filed']];
        }
//        return json(['code' => 200 ,'msg'=>'','data' =>$list ]);
        return ReturnJson::successFul('success', $list, $packname);
    }

    /**
     * @return void 获取订单状态
     */
    public function getOrderStatus(){
        $uid = input('uid');
        $packname = base64_decode(input('packname'));
        $ordersn = input('ordersn');

        $order = Db::name('order')
            ->alias('a')
            ->field('b.id,a.pay_status')
            ->join('pay_type b','b.name = a.paytype')
            ->where(['a.uid' => $uid,'a.ordersn' => $ordersn])
            ->find();
        if(!$order || $order['pay_status'] == 1){
            return ReturnJson::successFul('success', ['status' => 1], $packname); //1代表正常，0代表有问题
        }

        $log = Db::name('log')->field('id')->where(['out_trade_no' => $ordersn,'type' => 1])->find();
        if($log){
            return ReturnJson::successFul('success', ['status' => 0,'pay_id' => $order['id']], $packname);
        }
        return ReturnJson::successFul('success', ['status' => 1], $packname);
    }

    /**
     * @return void 用户充值主页数据
     */
    public function principalSheetIndex(){

        $uid = input('uid') ?? 0;

        $userinfo = Db::name('userinfo')->field('total_pay_num,coin,total_pay_score,package_id')->where('uid',$uid)->find();
        if(!$userinfo){
            $userinfo['total_pay_num'] = 0;$userinfo['total_pay_score'] = 0;$userinfo['coin'] = 0;$userinfo['package_id'] = 0;
        }

        //快捷的提现金额
        [$data['defaultMoney'],] = $this->getMoneyConfig($userinfo['total_pay_num'],$userinfo['total_pay_score'],$userinfo['coin'],$uid,$userinfo['package_id']);

        $data['order_min_money'] = SystemConfig::getConfigValue("order_min_money"); //最低充值金额

        $pay_type_ids = Db::name('apppackage_config')->where('package_id',$userinfo['package_id'])->value('pay_type_ids');
        $where = $pay_type_ids ? [['id','in',$pay_type_ids]] : [];
        //获取平台提现列表
        $data['pay_type'] = Db::name('pay_type')
            ->field("id,englishname")
            ->where('status','=','1')
            ->where($where)
            ->order('weight','desc')
            ->select()
            ->toArray();




        return ReturnJson::successFul(200, $data);
    }

    /**
     * @param 订单支付
     */
    public function OrderPay(){
        return ReturnJson::successFul(200, 'https://www.baidu.com/');
        $uid = input('uid');
        $money   = input('money');  //充值金额已分为单位
        $pay_type_id   = input('pay_id');  //充值金额已分为单位
        $active_id = 0;

        $type = 0;

        $order_min_money = SystemConfig::getConfigValue("order_min_money");
        if($money < $order_min_money) return ReturnJson::failFul(228);  //抱歉，你的充值金额小于了最低充值金额



        $orderTime = $this->OrderStatusNum($uid);
        if($orderTime)return ReturnJson::failFul(230);//对不起！ 您目前有太多订单需要支付。 请稍等一会后再拉取订单

        $share_strlog = Db::name('share_strlog')
            ->alias('a')
            ->join('userinfo b','a.uid = b.uid')
            ->field('a.jiaemail,b.first_pay_score,a.phone,a.jiaphone,b.total_pay_num,b.total_pay_score,b.coin,b.package_id,b.channel,a.nickname,b.vip')
            ->where('a.uid',$uid)
            ->find();

        if(!$share_strlog) return ReturnJson::failFul(226);


        $phone = $share_strlog['phone'] ?: ($share_strlog['jiaphone'] ?: rand(7777777777,9999999999));

        $email = $share_strlog['jiaemail'];

        //活动赠送金额等
        $day = 1; // 活动赠送天数，没有就默认1
        $get_money = $money;  //用户得到的金额
        //要求的流水

        $current_money = 0;
        if($active_id || $type){
            $active_id = $this->getActiveId($active_id,$type,$share_strlog['first_pay_score']); //重新获取active_id ,这里可能传入的是type,需要获取活动id

            $active = Db::name('active')->where(['id' => $active_id,'status'=>1])->find();
            if(!$active){
                return ReturnJson::failFul("Sorry! Activity does not exist");
            }

            if($active['type'] == 1){ //破产活动
                $active_num = $this->sendPcGm($uid);
            }elseif($active['type'] == 2){ //每日活动
                $active_num = Active::everyUserActive($uid);
            }else{
                //判断是否超过活动次数
                $active_num = Db::name('active')
                    ->alias('a')
                    ->where('a.id',$active_id)
                    ->where('a.status','1')
                    ->where('a.active_num', '>', function ($query) use($uid,$active_id){
                        $query->name('active_log')->alias('b')->field('count(b.id)')->where('b.uid', $uid)->where('b.active_id', $active_id);
                    })
                    ->find();
            }

            if(!$active_num){
                return ReturnJson::failFul("Sorry! You have run out of activities");
            }

            [$money,$zs_bonus,$get_money,$zs_money,$day] = $this->activeValue($active);

            if($money < $active['money']){
                return ReturnJson::failFul("The amount is less than the minimum recharge amount of the activity");
            }

            $payTypeArray = $this->getPayType($pay_type_id,$money,$share_strlog['package_id'],$uid);
            if($payTypeArray['code'] != 200){
                return ReturnJson::failFul($payTypeArray['msg']);
            }
            $pay_type = $payTypeArray['data'];

        }else{
            $payTypeArray = $this->getPayType($pay_type_id, $money, $share_strlog['package_id'],$uid);
            if ($payTypeArray['code'] != 200) {
                return ReturnJson::failFul($payTypeArray['msg']);
            }
            $pay_type = $payTypeArray['data'];

            [$zs_bonus, $cash_bili,$shop_id] = $this->getBonus($money, $share_strlog['total_pay_num'],$share_strlog['total_pay_score'],$share_strlog['coin'],$uid,$share_strlog['package_id']);  //赠送的bonus
            [$zs_money, $current_money] = $this->getVipZs($money, $share_strlog['vip'], $current_money, $pay_type['send_bili'], $cash_bili);


        }


        $all_price = $share_strlog['total_pay_score'];

        //手续费
        $fee = 0;
        if($pay_type['fee_bili'] && $pay_type['fee_bili'] > 0){    //比例手续费
            $fee = bcmul($pay_type['fee_bili'],$money,0);
        }
        if($pay_type['fee_money'] && $pay_type['fee_money'] > 0){  //固定手续费
            $fee = bcadd($pay_type['fee_money'],$fee,0);
        }
        // 创建订单
        $createData = [
            "uid"           => $uid,
            "ordersn"  => \customlibrary\Common::doOrderSn(000),
            "paytype"       => $pay_type['name'],
            "zs_bonus"      => $zs_bonus,
            "zs_money"      => $zs_money,
            "money"      => bcadd($get_money,$zs_money,0),
            'get_money' => $get_money,
            'price'    => $money,
            'email'         => $email,
            'phone'        => $phone,
            'nickname'        => $phone,
            'createtime' => time(),
            'packname' => request()->packname,
            'active_id' => $active_id,
            'ip' =>  request()->ip(),
            'all_price' => $all_price,
            'fee_money' => $fee,
            'current_money' => $current_money,
            'package_id' => $share_strlog['package_id'],
            'channel' => $share_strlog['channel'],
            'shop_id' => $shop_id ?? 0,
        ];

        $order_id = Db::name('order')->insertGetId($createData);

        if(!$order_id) return ReturnJson::failFul(229);

        $apInfo = \pay\Pay::pay($pay_type['name'],$createData);

        if($apInfo['code'] != 200) return ReturnJson::failFul(231);//抱歉！三方支付订单拉取失败


        if($apInfo['data']['tradeodersn']){
            Db::name('order')->where('id' ,'=', $order_id)->update(['tradeodersn' => $apInfo['data']['tradeodersn'],'updatetime' => time()]);
        }



        return ReturnJson::successFul(200, $apInfo['data']['payurl']);

    }

    /**
     * 判断是否连续拉了多笔订单未支付限时
     * @param $uid
     * @return void
     */
    private function OrderStatusNum($uid){
        $num = 10; //连续拉多少笔订单未支付进入等待限制
        $time = 30; //限制时间默认30分钟之后才能再次拉去订单
        $order = Db::name('order')->field('pay_status,createtime')->where('createtime','>=',(time() - ($time * 60)))->where('uid',$uid)->order('createtime','desc')->limit(0,$num)->select()->toArray();
        if(count($order) < $num){
            return 0;  //表示可以拉取订单
        }
        foreach ($order as $v){
            if($v['pay_status'] == 1)return 0;  //有支付表示可以拉取订单
        }
        $lastOderTime = $order[0]['createtime'] ?? time(); //上一笔订单拉取时间
        if($lastOderTime + (60 * $time) > time()){
            return bcdiv(($lastOderTime + (60 * $time)) - time(),60,0); //返回还需要多少分钟才能拉取订单
        }
        return 0;
    }



    /**
     * @return void 获取后台金额配置
     * @param $pt_pay_count  支付次数
     * @param $total_pay_score  总充值支付金额
     * @param $coin  余额剩余
     * @param $terminal_type  用户来源终端 2= H5 ，1=APP
     */
    private function getMoneyConfig($pt_pay_count,$total_pay_score,$coin,$uid,$package_id){

        [$defaultMoney,$cash_money,$hot_config,$shop_id] = self::getRechargeConfig($pt_pay_count,$total_pay_score,$coin,$uid,$package_id);

        //快捷的提现金额
        $defaultMoney = explode(' ',$defaultMoney);
        $cash_money = $cash_money ? explode(' ',$cash_money) : [];
        $hot_config = $hot_config ? explode(' ',$hot_config) : [];
        $data = [];
        foreach ($defaultMoney as $key => $val){
            [$money,$bouns] = explode('|',$val);
            [,$cash_money_bili] = $cash_money ? explode('|',$cash_money[$key]) : ['0','0'];
            [,$hot_status] = $hot_config ? explode('|',$hot_config[$key]) : ['0','0'];
            $data[] = [
                'money'  => $money,
                'bonus'  => $bouns,
                'hot_status'  => $hot_status,
                'cash_bili' => $cash_money_bili,
            ];

        }
        return [$data,$shop_id];
    }

    /**
     * 获取充值金额与赠送Bonus 、Cash配置
     * @param $pt_pay_count  支付次数
     * @param $total_pay_score  总充值支付金额
     * @param $coin  余额剩余
     * @param $terminal_type  用户来源终端 2= H5 ，1=APP
     */
    private static function getRechargeConfig($pt_pay_count,$total_pay_score,$coin,$uid,$package_id){
//        $withdraw_money = \app\api\controller\Withdrawlog::getUserTotalExchangeMoney($uid);  //用户提现的金额，包含待审核和处理中
//
//        $customer_money = $total_pay_score - $withdraw_money - $coin; //客损金额  充值 - 提现 - 余额
//        $withdraw_bili = $total_pay_score > 0 ? bcdiv(bcadd($withdraw_money,$coin,0),$total_pay_score,2) : 0;  // （提现 + 余额）/ 充值
        $user_type = \app\api\controller\user\User::getUserType($uid); //获取用户类型
        $shop_id = 0;


        if(!$pt_pay_count){  //首充充值商城判断  只能参加一次
            $marketing_shop = Db::name('marketing_shop')->field('id,bonus_config,cash_config,hot_config')->where(['type'=>10,'user_type' => $user_type])->order('weight','desc')->find();
            if($marketing_shop){
                $defaultMoney = $marketing_shop['bonus_config'];
                $cash_money = $marketing_shop['cash_config'];
                $hot_config = $marketing_shop['hot_config'];
                $shop_id = $marketing_shop['id'];
            }
        }else{
            $marketing_shop = Db::name('marketing_shop')->field('bonus_config,cash_config,hot_config')->where([['type','=',0],['user_type','=',$user_type]])->order('weight','desc')->find();
            $defaultMoney = $marketing_shop['bonus_config'];
            $cash_money = $marketing_shop['cash_config'];
            $hot_config = $marketing_shop['hot_config'];
        }

        return [$defaultMoney,$cash_money,$hot_config,$shop_id];

        //获取用户是否点控的活动商场
//        $shop_type = Db::name('share_strlog')->where('uid',$uid)->value('shop_type');
//        if($shop_type){
//            $marketing_shop = Db::name('marketing_shop')->field('id,bonus_config,cash_config,hot_config')->where(['type'=>$shop_type,'user_type' => $user_type])->order('weight','desc')->find();
//            if($marketing_shop){
//                $defaultMoney = $marketing_shop['bonus_config'];
//                $cash_money = $marketing_shop['cash_config'];
//                $shop_id = $marketing_shop['id'];
//            }
//        }
//        elseif(!$pt_pay_count){  //首充充值商城判断  只能参加一次
//            $marketing_shop = Db::name('marketing_shop')->field('id,bonus_config,cash_config,hot_config')->where(['type'=>10,'user_type' => $user_type])->order('weight','desc')->find();
//            if($marketing_shop){
//                $defaultMoney = $marketing_shop['bonus_config'];
//                $cash_money = $marketing_shop['cash_config'];
//                $shop_id = $marketing_shop['id'];
//            }
//        }elseif ($total_pay_score  && !Db::name('shop_log')->field('id')->where([['uid','=',$uid],['type','=',7]])->find()){  //如果玩家有客损金额检查  ： 客损商城判断 //每个用户只能参与一次
//            $marketing_shop = Db::name('marketing_shop')->field('id,bonus_config,cash_config,hot_config')->where([['customer_money','<=',$customer_money],['withdraw_bili','>',$withdraw_bili],['type','=',7],['user_type','=',$user_type]])->order('customer_money','desc')->find();
//            if($marketing_shop){
//                $defaultMoney = $marketing_shop['bonus_config'];
//                $cash_money = $marketing_shop['cash_config'];
//                $shop_id = $marketing_shop['id'];
//
//            }
//        }



//        if(!isset($defaultMoney) &&  $total_pay_score && $withdraw_money <= 0 && !Db::name('shop_log')->field('id')->where([['uid','=',$uid],['type','=',6]])->find()){  //破产商场判断而且广告用户用户未提现可以一直参加，其它的只能参与一次
//            //每个用户只能参与一次
//            $marketing_shop = Db::name('marketing_shop')->field('id,bonus_config,cash_config,hot_config')->where([['type','=',6],['coin_money','>=',$coin],['user_type','=',$user_type]])->order('weight','desc')->find();
//            if($marketing_shop){
//
//                $defaultMoney = $marketing_shop['bonus_config'];
//                $cash_money = $marketing_shop['cash_config'];
//                $shop_id = $marketing_shop['id'];
//
//            }
//
//        }

//        //获取不同用户的商城配置
//        if(!isset($defaultMoney)){
//
//            $marketing_shop = Db::name('marketing_shop')->field('bonus_config,cash_config,hot_config')->where([['type','=',0],['user_type','=',$user_type]])->order('weight','desc')->find();
//            $defaultMoney = $marketing_shop['bonus_config'];
//            $cash_money = $marketing_shop['cash_config'];
//        }

//        return [$defaultMoney,$cash_money,$shop_id];
    }


    /**
     * 新的得到支付渠道
     * @param $pay_type_id 支付渠道id
     * @param $money 支付金额
     * @param  $package_id 包名
     * @return array
     */
    private function getPayType($pay_type_id,$money,$package_id,$uid){
        //如果客户端传入了支付通道，直接拿取使用
        if($pay_type_id){
            $pay_type = Db::name('pay_type')
                ->where([
                    ['minmoney','<=',$money],
                    ['maxmoney','>=',$money]
                ])
                ->where(['id' => $pay_type_id,'status' => 1])
                ->find();
            if(!$pay_type) return ['code' => 244,'msg' => 'Sorry! No recharge channel has been matched yet','data' => []];
            return ['code' => 200,'msg' => 'success','data' => ['fee_money'=>$pay_type['fee_money'],'fee_bili'=>$pay_type['fee_bili'],'send_bili'=>$pay_type['send_bili'],'name' => $pay_type['name']]];
        }


        $pay_type_ids = Db::name('apppackage_config')->where('package_id',$package_id)->value('pay_type_ids');

        $where = $pay_type_ids ? [['id','in',$pay_type_ids],['status','=',1]] : [['status','=',1]];


        $pay_type_Array = Db::name('pay_type')
            ->where([
                ['minmoney','<=',$money],
                ['maxmoney','>=',$money]
            ])
            ->where($where)
            ->order('weight','desc')
            ->select()->toArray();
        if(!$pay_type_Array) return ['code' => 227,'msg' => 'Sorry! No recharge channel has been matched yet','data' => []];

        $order = Db::name('order')->field('pay_status,paytype')->where('uid',$uid)->order('id','desc')->find();

        if(!$order){
            $pay_type = self::getFirstPay($pay_type_Array);
        }elseif ($order['pay_status'] == 1){
            $keyValue = 0;
            foreach ($pay_type_Array as $key => $v){
                if($v['name'] == $order['paytype']){
                    $keyValue = $key;
                    break;
                }
            }
            $pay_type = $pay_type_Array[$keyValue] ?? self::getFirstPay($pay_type_Array);
        }else{
            $keyValue = 0;
            foreach ($pay_type_Array as $key => $v){
                if($v['name'] == $order['paytype']){
                    $keyValue = $key + 1;
                    break;
                }
            }
            $pay_type = $pay_type_Array[$keyValue] ?? $pay_type_Array[0];
        }


        if(!$pay_type) return ['code' => 227,'msg' => 'Sorry! No recharge channel has been matched yet','data' => []];

        return ['code' => 200,'msg' => 'success','data' => ['fee_money'=>$pay_type['fee_money'],'fee_bili'=>$pay_type['fee_bili'],'send_bili'=>$pay_type['send_bili'],'name' => $pay_type['name']]];
    }

    /**
     * 按照权重随机一个通通道
     * @param $pay_type_Array  所有满足条件的支付通道
     * @return mixed
     */
    public static function getFirstPay($pay_type_Array){
        $keyValue = [];//将每个key生产对应的权重数量存入
        $total_num = 0;//计算总共权重的数量
        foreach ($pay_type_Array as $key => $value){
            for ($i = 0; $i < $value['weight']; $i++) {
                $keyValue[] = $key;
            }
            $total_num  = $total_num + $value['weight'];
        }

        $randNum = rand(0,$total_num - 1);//随机看出现那个支付渠道的索引
        return $pay_type_Array[$keyValue[$randNum]] ?? $pay_type_Array[0];
    }


    /**
     * 无限代每周数据统计
     * @param $uid  UID
     * @param $money  用户充值或者提现金额
     * @param $fee 手续费
     * @param $type 类型:1=修改充值，2=修改提现
     */
    public static function agentTeamWeeklog($uid,$money,$fee,$type = 1){
        $field = $type == 1 ? 'pay_price' : 'withdraw_price';
        [$start,$end] = \customlibrary\Common::getWeekStartEnd(time());

        $res = Db::name('agent_team_weeklog')
            ->where([['time' ,'>=', $start],['time','<',$end],['uid','=',$uid]])
            ->update([
                $field => Db::raw($field."+".$money),
                'fee' => Db::raw('fee + '.$fee),
                'updatetime' => time(),
            ]);
        if(!$res){
            Db::name('agent_team_weeklog')
                ->insert([
                    $field => $money,
                    'fee' => $fee,
                    'time' => $start,
                    'uid' => $uid,
                ]);
        }
    }



    /**
     * @param $money 充值金额 用户支付金额
     * @param $pt_pay_count 用户的普通充值次数
     * @param $total_pay_score 用户总充值金额
     * @param $coin 用户余额
     * @param $terminal_type 1=App端 ,2=H5端
     * @return void
     */
    private function getBonus($money,$pt_pay_count,$total_pay_score,$coin,$uid,$package_id){
        $bonus = 0;
        $cash_bili = 0;
        [$defaultConfig,$shop_id] = $this->getMoneyConfig($pt_pay_count,$total_pay_score,$coin,$uid,$package_id);
        foreach ($defaultConfig as $v){
            if($v['money'] == $money){
//                $bonus = $pt_pay_count == 0 ? bcmul(SystemConfig::getConfigValue("first_bonus_bili") ?: 0,$v['money'],0)  : bcmul($v['bonus'],$v['money'],0);
                $bonus =  bcmul($v['bonus'],$v['money'],0);
                $cash_bili = $v['cash_bili'];
                break;
            }
        }
        return [$bonus,$cash_bili,$shop_id];
    }

    /**
     * @return void 获取活动的值
     * @param $active 活动
     */
    private function activeValue($active){
        [$money,$bonus,$get_money,$zs_money,$day] = [$active['money'],$active['bonus'],$active['get_money'],$active['day_money'],1]; //$money = 活动支付金额 , $bonus = 活动赠送的bonus , $get_money = 到账金额 , $zs_money=活动赠送金额
//        if($active['day_status'] == 1){
//            $zs_money = bcadd(bcmul($zs_money,$active['day'],0),bcmul($active['last_day'],$active['last_money'],0),0);
//            $day = bcadd($active['day'],$active['last_day'],0);
//        }
        return [$money,$bonus,$get_money,$zs_money,$day];
    }

    /**
     * @param $active_id  活动id
     * @param $type 活动类型
     * @param $first_pay_score 首充金额
     * @return void
     */
    private function getActiveId($active_id,$type,$first_pay_score){
        $activeSelfScreening = Config::get('active.selfScreening');
        if(isset($activeSelfScreening[$type]) && $activeSelfScreening[$type] == 1){ //判断是否为自动筛选活动
            $active_id = Db::name('active')->where([['money','>',$first_pay_score],['status','=',1],['type','=',$type]])->order('money','asc')->value('id');
            if(!$active_id) $active_id = Db::name('active')->where([['status','=',1],['type','=',$type]])->order('money','desc')->value('id');
        }
        return $active_id;
    }

    /**
     * 普通充值赠送金额
     * @param $money 充值金额
     * @param $vip vip等级
     * @param $send_bili 渠道额外赠送比例
     * @param $cash_bili 如果赠送比例大于0
     * @param 要求的流水 vip等级
     * @return void
     */
    private function getVipZs($money,$vip,$current_money,$send_bili,$cash_bili){
        $zs_money = 0; //赠送金额
//        $Redis = new \Redis();
//        $Redis->connect(Config::get('redis.ip'),Config::get('port2.ip')); //6502
//        $exclusive_promtions = $Redis->hGet('vip_'.$vip,'exclusive_promtions');
//        $exclusive_bili = $Redis->hGet('vip_'.$vip,'exclusive_bili');
//        if($exclusive_promtions == 1 && $exclusive_bili > 0){
//            $zs_money = bcmul($exclusive_bili,$money,0);
////            $current_money = bcadd(bcmul(SystemConfig::getConfigValue("pay_flow_multiple"),$zs_money,0),$current_money,0);
//            $current_money = 0;
//        }

        if($send_bili > 0){ //如果存在额外赠送的金额
            $send_money = bcmul($send_bili,$money,0); //额外赠送的金额
            $zs_money = bcadd($send_money,$zs_money,0); //总赠送金额
//            $current_money = bcadd(bcmul(SystemConfig::getConfigValue("pay_flow_multiple"),$send_money,0),$current_money,0);
            $current_money = 0;
        }

        if($cash_bili > 0){  //如果赠送比例大于0
            $zs_money = bcadd($zs_money,bcmul($money,$cash_bili,0),0);
        }

        return [$zs_money,$current_money];
    }


    /**
     * 判断用户是否能参加本次活动
     * @param $uid
     * @param $shop_id
     * @param $shop_type 点控的商场充值活动
     * @return void
     */
    private static function getUserShopStatus($uid,$shop_id,$total_pay_score,$coin,$shop_type){
        $marketing_shop = Db::name('marketing_shop')->field('type,customer_money,withdraw_bili')->where('id',$shop_id)->find();
        if($shop_type && $shop_type == $marketing_shop['type']){
            Db::name('share_strlog')->where('uid',$uid)->update(['shop_type' => 0]);  //修改点控状态为0，表示本地已经参与了
            return ['',$marketing_shop['type']];
        }elseif($marketing_shop['type'] == 7){//	活动类型:6=新的破产活动,7=客损活动,10=首次充值
            $withdraw_money = \app\api\controller\Withdrawlog::getUserTotalExchangeMoney($uid);  //用户提现的金额，包含待审核和处理中

            $customer_money = $total_pay_score - $withdraw_money - $coin; //客损金额  充值 - 提现 - 余额
            $withdraw_bili = $total_pay_score > 0 ? bcdiv(bcadd($withdraw_money,$coin,0),$total_pay_score,2) : 0;  // （提现 + 余额）/ 充值

            //只能参与一次
            $day_status = Db::name('shop_log')->field('id')->where([['uid','=',$uid],['type','=',7]])->find();
            if($total_pay_score > 0 && $customer_money >= $marketing_shop['customer_money'] && $withdraw_bili <  $marketing_shop['withdraw_bili'] && !$day_status){
                // Db::name('share_strlog')->where('uid',$uid)->update([
                //     'is_bankruptcy_status' => 2
                // ]);
                return ['',$marketing_shop['type']];
            }
        }elseif ($marketing_shop['type'] == 6){
            $withdraw_money = \app\api\controller\Withdrawlog::getUserTotalExchangeMoney($uid);  //用户提现的金额，包含待审核和处理中

            //每个用户只能参与一次
            $pc_shop_log = Db::name('shop_log')->where([['uid','=',$uid],['type','=',6]])->value('id');
            if($pc_shop_log)return ['支付回调时不满足活动商场条件',$marketing_shop['type']];

            $res = Db::name('marketing_shop')->field('id')->where([['type','=',6],['coin_money','>=',$coin]])->order('weight','desc')->find();
            if(!$withdraw_money && $res){
                return ['',$marketing_shop['type']];
            }
        }elseif ($marketing_shop['type'] == 10 && $total_pay_score <= 0){
            return ['',$marketing_shop['type']];
        }else{
            return ['',0];
        }
        return ['支付回调时不满足活动商场条件',$marketing_shop['type']];
    }

    /**处理当日首充用户与当日付费统计
     * @param $uid 用户uid
     * @param $package_id 包id
     * @param $channel 渠道号
     * @param $user_type 用户等级
     * @param $price 支付金额
     * @param $af_status 是否是广告用户
     * @return void
     */
    public static function statisticsRetainedUser($uid,$package_id,$channel){

        //获取当日包和渠道下的首充用户
        $day_user = Db::name('statistics_retainedpaiduser')->where(['time'=> strtotime('00:00:00'), 'package_id' => $package_id, 'channel' => $channel])
            ->update([
                'uids' => Db::raw("concat(uids,',', '$uid')")
            ]);
        if(!$day_user){
            Db::name('statistics_retainedpaiduser')
                ->insert([
                    'time' => strtotime('00:00:00'),
                    'package_id' => $package_id,
                    'channel' => $channel,
                    'uids' => $uid,
                ]);
        }
        $list = ['statistics_retentionpaidlg'];
        foreach ($list as $v){
            $res = Db::name($v)->where(['time'=> strtotime('00:00:00'), 'package_id' => $package_id, 'channel' => $channel])
                ->update([
                    'num' => Db::raw('num + 1')
                ]);

            if(!$res){
                Db::name($v)
                    ->insert([
                        'time' => strtotime('00:00:00'),
                        'package_id' => $package_id,
                        'channel' => $channel,
                        'num' => 1,
                    ]);
            }
        }

    }

    /**
     * @param $uid 用户uid
     * @param $money 用户支付金额
     * @param $first_pay_score 首充金额
     * @param $package_id 包名
     * @param $channel 渠道
     * @return void
     */
    public static function puidCommission($uid,$money,$total_pay_num,$package_id,$channel){
        $user_team = Db::name('user_team')->field('puid,pstatus')->where('uid',$uid)->find();
        if(!$user_team['puid']) return;
        if($user_team['pstatus'] != 1){
            $device_count = Db::name('share_strlog')  //获取用户设备数量
            ->alias('a')
                ->field('a.uid')
                ->whereNotNull('a.device_id')
                ->where('a.device_id','<>','')
                ->whereRaw(
                    "a.device_id = (SELECT device_id FROM br_share_strlog b WHERE b.uid = $uid)"
                )->count();
            if($device_count > 1){
                return;
            }
            Db::name('user_team')->where('uid',$uid)->update(['pstatus' => 1]);  //修改下级用户的状态
        }
        $commission_log = [];
        $amount = 0;
        if($total_pay_num <= 0){ //首次充值赠送上级

            $first_commission_money = SystemConfig::getConfigValue('first_commission_money');//推广用户首充赠送金额(卢比分)
            $commission_log[] = [
                'uid' => $uid,
                'puid' => $user_team['puid'],
                'money' => $money,
                'amount' => $first_commission_money,
                'type' => 2,
                'createtime' => time(),
                'package_id' => $package_id,
                'channel' => $channel,
            ];
            $amount = bcadd($amount,$first_commission_money,0);


        }

        $order_commission_bili = SystemConfig::getConfigValue('order_commission_bili');//推广充值赠送比例
        if($order_commission_bili > 0){
            $send_amount = bcmul($order_commission_bili,$money,0);
            $amount = bcadd($amount,$send_amount,0);
            $commission_log[] = [
                'uid' => $uid,
                'puid' => $user_team['puid'],
                'money' => $money,
                'amount' => $send_amount,
                'type' => 1,
                'createtime' => time(),
                'package_id' => $package_id,
                'channel' => $channel,
            ];
        }

        if($commission_log){
            Db::name('user_commission_log')->insertAll($commission_log);
            Db::name('user_team')
                ->where('uid',$user_team['puid'])
                ->update([
                    'really_commission_money' => Db::raw('really_commission_money + '.$amount),
                    'really_commission_allmoney' => Db::raw('really_commission_allmoney + '.$amount),
                    'char_all_cash' => Db::raw('char_all_cash + '.$money),
                    'updatetime' => time()
                ]);
            //获取当日的上级用户分佣状态
            $res = Db::name('user_commission_gather')->where(['createtime'=> strtotime('00:00:00'), 'uid' => $user_team['puid']])
                ->update([
                    'char_all_cash' => Db::raw("char_all_cash + ".$money),
                    'amount' => Db::raw("amount + ".$amount)
                ]);
            if(!$res){
                Db::name('user_commission_gather')
                    ->insert([
                        'createtime' => strtotime('00:00:00'),
                        'commissiontime' => strtotime('00:00:00'),
                        'package_id' => $package_id,
                        'channel' => $channel,
                        'char_all_cash' => $money,
                        'amount' => $amount,
                        'uid' => $user_team['puid']
                    ]);
            }
        }

    }



    private static function getH5OrderCommissionList($puid,$uid,$price,$bili,$level = 1){
        $amount = bcmul($bili,$price,0);
        $h5_commission_log = [
            'uid' => $puid,
            'char_uid' => $uid,
            'level' => $level,
            'price' => $price,
            'bili' => $bili,
            'amount' => $amount,
            'type' => 3,
            'createtime' => time(),
            'time' => strtotime('00:00:00'),
        ];

        //赠送Bonus
        $phpExe = [
            'type' => 100,
            'uid' => $puid,
            'jsonstr' => json_encode(["msg_id"=>3,"uid"=>(int)$puid,"update_int64"=>(int)$amount,"exchange" => 0,"reason"=>44]),
            "description"=>"H5充值返利".bcdiv($amount,100,2)."Bonus.",
        ];

        //存储用户每周返佣金额
        \app\api\controller\commission\Popularize::setActiveRankingLog($puid,$amount);

        //处理H5返利记录统计
        self::h5UserCommission($puid,$price,$amount,$level);
        return [$h5_commission_log,$phpExe];
    }


    /**
     * H5返利记录统计
     * @param $uid  返利用户的UID
     * @param $price  支付金额
     * @param $amount  返利金额
     * @param $levle 等级 1级返利还是2级返利
     * @return void
     */
    private static function h5UserCommission($uid,$price,$amount,$level = 1){
        $field = $level == 1 ? 'my_cash_money' : 'char_cash_money';
        $field2 = $level == 1 ? 'my_cash_amount' : 'char_cash_amount';
        $res = Db::name('h5_user_commission')
            ->where('uid',$uid)
            ->update([
                $field => Db::raw($field .'+'. $price),
                $field2 => Db::raw($field2 .'+'. $amount),
            ]);
        if(!$res){
            $share_strlog = Db::name('share_strlog')->field('package_id,channel')->where('uid',$uid)->find();
            Db::name('h5_user_commission')
                ->replace()
                ->insert([
                    'uid' => $uid,
                    $field => $price,
                    $field2 => $amount,
                    'package_id' => $share_strlog['package_id'],
                    'channel' => $share_strlog['channel'],
                ]);
        }
    }



    /**
     * goopagopay 回调
     */
    public function goopagopayNotify() {
        $data = file_get_contents('php://input');
        Log::error('goopagopay充值:'.json_encode($data));
        $data = json_decode($data, true);
        $custOrderNo=$data['mchOrderNo'];
        $ordStatus= $data["status"];
        $reference= $data["reference"] ?? '';
        if(!$custOrderNo)return ;//订单信息错误
        if($ordStatus != 2){ //订单回调2表示成功其它的支付失败
            \customlibrary\Common::log($custOrderNo,json_encode($data),1);
            return 'SUCCESS';
        }
        $res = self::Orderhandle($custOrderNo,$reference);
        if($res['code'] == 200){
            return 'SUCCESS';
        }

        Log::error('goopagopay充值事务处理失败==='.$res['msg'].'==ordersn=='.$custOrderNo);

        return 200;
    }


    /**
     * cashpagpay 回调
     */
    public function cashpagpayNotify() {
        $data = file_get_contents('php://input');
        Log::error('cashpagpay充值:'.json_encode($data));
        $data = json_decode($data, true);
        $custOrderNo=$data['merchantOrderId'];
        $ordStatus= $data["status"];
        $reference = $data['accountcert'] ?? '';
        if(!$custOrderNo)return ;//订单信息错误
        if($ordStatus != 01){ //订单回调01表示成功其它的支付失败
            \customlibrary\Common::log($custOrderNo,json_encode($data),1);
            return 'success';
        }
        $res = self::Orderhandle($custOrderNo,$reference);
        if($res['code'] == 200){
            return 'success';
        }

        Log::error('cashpagpay充值事务处理失败==='.$res['msg'].'==ordersn=='.$custOrderNo);

        return 200;
    }


    /**
     * @return void 订单充值成功处理
     * @param $ordersn  订单号
     */
    public static function Orderhandle($ordersn,$reallyPayMoney = 0){

        $order = Db::name('order')->where('ordersn',$ordersn)->find();
        if(!$order){
            return ['code' => '201','msg' => '订单获取失败','data' => []];
        }
        if($order['pay_status'] == 1){
            return ['code' => '200','msg' => '支付成功','data' => []];
        }

        if($order['price'] > $reallyPayMoney){
            Log::error('支付金额不对小于实际支付金额直接返回-订单号:'.$ordersn);
            return ['code' => '200','msg' => '支付金额不对小于实际支付金额直接返回','data' => []];
        }

        $share_strlog = Db::name('share_strlog')
            ->alias('a')
            ->field('a.uid,a.gpsadid,a.adid,a.afid,a.device_id,a.appname,a.createtime,a.login_ip,a.phone,a.email,a.shop_type,b.puid,b.channel,b.package_id,b.vip,b.first_pay_score,
            b.total_pay_num,b.regist_time,b.total_pay_score,b.coin,a.af_status')
            ->join('userinfo b','a.uid = b.uid')
            ->where('a.uid',$order['uid'])
            ->find();

        $remark = '';
        $marketing_shop_type = 0;
        $activeStatus = 1;
//        if($order['active_id'] > 0){
//            $activeStatus = Active::getUserActiveStatus($order['uid'],$order['active_id']); //用户是否参与了活动 //用户是否参与了活动
//            $remark = $order['active_id'] > 0 && $activeStatus ? '已经参与了'.$activeStatus.'活动' : '';
//        }elseif ($order['shop_id'] > 0){
//            [$remark,$marketing_shop_type] = self::getUserShopStatus($order['uid'],$order['shop_id'],$share_strlog['total_pay_score'],$share_strlog['coin'],$share_strlog['shop_type']);
//        }

        if($order['shop_id'] > 0)[$remark,$marketing_shop_type] = self::getUserShopStatus($order['uid'],$order['shop_id'],$share_strlog['total_pay_score'],$share_strlog['coin'],$share_strlog['shop_type']);

        $res = Db::name('order')->where('id','=', $order['id'])->update(['finishtime' => time(),'pay_status' => 1,'remark' => $remark]);
        if(!$res){
            return ['code' => '202','msg' => '订单状态修改失败','data' => []];
        }


        Db::startTrans();

        //修改用户总充值金额，总赠送金额，总充值次数

        $table = 'user_day_'.date('Ymd');
        $res = Db::name($table)
            ->where('uid',$order['uid'])
            ->update([
                'total_pay_score' => Db::raw('total_pay_score + '.$order['price']),
                'total_pay_num' => Db::raw('total_pay_num + 1'),
                'updatetime' => time(),
            ]);



        if(!$res && $share_strlog){
            $user_day = [
                'uid' => $share_strlog['uid'],
                'puid' => $share_strlog['puid'],
                'total_pay_score' => $order['price'],
                'vip' => $share_strlog['vip'],
                'total_pay_num' => 1,
                'updatetime' => time(),
                'package_id' => $share_strlog['package_id'],
                'channel' => $share_strlog['channel'],
            ];
            $res = Db::name($table)->insert($user_day);
            if(!$res){
                Db::rollback();
                return ['code' => '202','msg' => '玩家每日记录表跟新失败','data' => []];
            }
        }



        $res = Db::name('userinfo')->where('uid',$order['uid'])
            ->update([
                'total_pay_num' => Db::raw('total_pay_num + 1'),
                'updatetime' => time(),
                'total_pay_score' =>Db::raw('total_pay_score + '.$order['price']),
            ]);
        if(!$res){
            Db::rollback();
            return ['code' => 201 ,'msg'=>'修改用户的总充值次数失败','data' => []];
        }

        //更新用户充值时间
        Db::name('share_strlog')->where('uid',$order['uid'])
            ->update([
                'last_pay_time' => time(),
                'last_pay_price' => $order['price'],
            ]);
        //网赚数据
//        $behavior_data = [
//            'recharge_money' => $order['price']
//        ];
        //\customlibrary\Common::payBehavior($share_strlog, $order['price']);

        $is_first_recharge = false; //是否是第一次充值
        //普通充值判断用户是否是首充
        if($share_strlog['first_pay_score'] <= 0){
            $is_first_recharge = true;
            $res = Db::name('userinfo')->where('uid',$order['uid'])->update(['first_pay_score'=>$order['price'],'first_pay_time' => time(),'updatetime'=>time()]);
            if(!$res){
                Db::rollback();
                return ['code' => '202','msg' => '添加余额报文失败','data' => []];
            }

            //修改是否是首充充值字段
            Db::name('order')->where('id','=', $order['id'])->update(['is_first' => 1]);

            //添加每日用户
            self::statisticsRetainedUser($share_strlog['uid'],$share_strlog['package_id'],$share_strlog['channel']);

            //网赚行为上报
            //\customlibrary\Common::setEarningBehavior(3, json_encode($behavior_data), $share_strlog['gpsadid'], $share_strlog['phone'], $share_strlog['device_id']);
        }



//        $bonus_mult = SystemConfig::getConfigValue('bonus_mult') ?: 0;
        $limitarray = [];
        //添加活动日志 与 处理增加用户余额
        if($order['active_id'] > 0 && !$activeStatus){
            $active = Db::name('active')->field('type,config,day_status,mult')->where('id',$order['active_id'])->find();

            $active_log = [
                'uid' => $order['uid'],
                'active_id' => $order['active_id'],
                'nickname' => $order['nickname'],
                'money' => $order['price'],
                'zs_money' => $order['zs_money'],
                'zs_bonus' => $order['zs_bonus'],
                'current_money' => $order['current_money'],
                'createtime' => time(),
                'type' => $active['type'],
                'package_id' => $share_strlog['package_id'],
                'channel' => $share_strlog['channel'],
            ];
            $active_log_id = Db::name('active_log')->insertGetId($active_log);
            if(!$active_log_id){
                Db::rollback();
                return ['code' => '202','msg' => '活动日志添加失败','data' => []];
            }

//            $exchange = $active['mult'] > 0 ? bcmul($active['mult'],$order['zs_money'],0) : bcmul($bonus_mult,$order['zs_money'],0);

            if($active['type'] == 5 || $active['type'] == 11){  //如果是每天需要领取的 单独的GM命令
                $limitarray[] = [
                    'type' => 100,
                    'uid' => $order['uid'],
                    'jsonstr' => json_encode(["msg_id"=>10,"uid"=>(int)$order['uid'],"pay"=>(int)$order['price'],'score'=>(int)$order["get_money"],"reason"=>(int)Config::get('my.active_reason')[$order['active_id']]]),
                    "description"=>"真金版,玩家".$order['uid']."充值".$order["price"]."卢比,到账".bcdiv($order["get_money"],100,2)."卢比"
                ];
            }else{ //直接赠送的

                //增加用户余额
                $limitarray[] = [
                    'type' => 100,
                    'uid' => $order['uid'],
                    'jsonstr' => json_encode(["msg_id"=>3,"uid"=>(int)$order['uid'],"update_int64"=>(int)$order['get_money'],"exchange" => 0,"reason"=>Config::get('my.active_reason')[$order['active_id']] ?? 1]),
                    "description"=>"真金版,玩家".$order['uid']."充值".$order["price"]."卢比,到账".bcdiv($order["get_money"],100,2)."卢比"
                ];

                if($order['zs_money'] > 0)
                    $limitarray[] = [
                        'type' => 100,
                        'uid' => $order['uid'],
                        'jsonstr' => json_encode(["msg_id"=>3,"uid"=>(int)$order['uid'],"exchange" => 0,"update_int64"=>(int)$order['zs_money'],"reason"=>14]),
                        "description"=>"真金版,玩家".$order['uid']."充值活动".$order['active_id']."赠送".$order["price"]."卢比,到赠送".bcdiv($order["zs_money"],100,2)."卢比"
                    ];
            }


            //赠送砖石
            if($order['zs_bonus'] > 0){
                $limitarray[] = [
                    'type' => 100,
                    'uid' => $order['uid'],
                    'jsonstr' => json_encode(["msg_id"=>5,"uid"=>(int)$order['uid'],"update_int64"=>(int)$order['zs_bonus'],"reason"=>Config::get('my.bonus_active_reason')[$order['active_id']] ?? 102]),
                    "description"=>"真金版,玩家".$order['uid']."充值赠送".$order["price"]."卢比,到赠送".bcdiv($order["zs_bonus"],100,2)."砖石"
                ];
            }

        }else{



            //增加用户余额
            $res = User::userEditCoin($order['uid'],$order['get_money'],1,'玩家:'.$order['uid']."充值".$order["price"]."到账".bcdiv($order["get_money"],100,2),2);
            if(!$res){
                Db::rollback();
                Log::error('uid:'.$order['uid'].'充值修改余额失败,订单号:'.$ordersn);
                return ['code' => '202','msg' => '充值修改余额失败','data' => []];
            }
            if(!$remark && $order['zs_money'] > 0){  //如果不是活动或者商城活动强转的 才赠送Cash
                $res = User::userEditCoin($order['uid'],$order['zs_money'],2,'玩家:'.$order['uid']."充值".$order["price"]."赠送".bcdiv($order["zs_money"],100,2),2);
                if(!$res){
                    Db::rollback();
                    Log::error('uid:'.$order['uid'].'充值赠送修改余额失败,订单号:'.$ordersn);
                    return ['code' => '202','msg' => '充值赠送余额失败','data' => []];
                }
            }


            //赠送砖石
            if(!$remark && $order['zs_bonus'] > 0){  //如果不是活动或者商城活动强转的 才赠送Bonus
                $res = User::userEditBonus($order['uid'],$order['zs_bonus'],2,'玩家:'.$order['uid']."充值:".$order["price"]."赠送:".bcdiv($order["zs_bonus"],100,2)."Bonus",2);
                if(!$res){
                    Db::rollback();
                    Log::error('uid:'.$order['uid'].'充值赠送Bonus失败,订单号:'.$ordersn);
                    return ['code' => '202','msg' => '充值赠送Bonus失败','data' => []];
                }
            }


            //普通充值检查是否是活动商场
            if($order['shop_id'] > 0 && !$remark && $marketing_shop_type){
                $shop_log = Db::name('shop_log')->insert([
                    'uid' => $order['uid'],
                    'shop_id' => $order['shop_id'],
                    'type' => $marketing_shop_type,
                    'money' => $order['price'],
                    'get_money' => $order['get_money'],
                    'zs_money' => $order['zs_money'],
                    'zs_bonus' => $order['zs_bonus'],
                    'package_id' => $share_strlog['package_id'],
                    'channel' => $share_strlog['channel'],
                    'createtime' => time(),
                ]);
                if(!$shop_log){
                    Db::rollback();
                    return ['code' => '202','msg' => '普通充值商场活动失败存储','data' => []];
                }
            }
        }

        //给上级分佣
//        self::puidCommission($order['uid'],$order['price'],$share_strlog['total_pay_num'],$share_strlog['package_id'],$share_strlog['channel']);
//        if($share_strlog['puid'] > 0){
//            $limitarray[] = [
//                'type' => 100,
//                'uid' => $order['uid'],
//                'jsonstr' => json_encode(["msg_id"=>13,"uid"=>(int)$share_strlog['puid'],"update_int64"=>(int)$order['price'],"reason"=>1]),
//                "description"=>"玩家".$order['uid']."充值赠送通知上级".$share_strlog['puid']
//            ];
//        }


        Db::commit();






        //统计无限代用户数据
//        if($share_strlog['is_agent_user'] == 1)self::agentTeamWeeklog($order['uid'],$order['price'],$order['fee_money']);

        if($share_strlog['adid'] && $share_strlog['gpsadid'])Adjust::adjustUploadEvent($share_strlog['appname'],$share_strlog['gpsadid'],$share_strlog['adid'],(float)bcdiv($order["price"],100,2),$is_first_recharge,$ordersn,$share_strlog);



        if ($share_strlog['afid'])Adjust::afUploadEvent($share_strlog['appname'],$share_strlog['gpsadid'],$share_strlog['afid'],(float)bcdiv($order["price"],100,2),$is_first_recharge,$ordersn,$share_strlog);


        if( in_array($order['package_id'],self::$fbPointPackageID)) Adjust::fbUploadEvent($share_strlog['appname'],(float)bcdiv($order["price"],100,2),$is_first_recharge,$ordersn,'',$order['uid']);


//        if(SystemConfig::getConfigValue('is_tg_send') == 1) {
//            //发送充值成功消息to Tg
//            \service\TelegramService::rechargeSuc($order);
//        }


        return ['code' => '200','msg' => '','data' => []];
    }
}