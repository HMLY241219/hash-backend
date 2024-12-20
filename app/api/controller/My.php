<?php
namespace app\api\controller;
use app\admin\model\system\SystemConfig;

use customlibrary\Common;
use think\facade\Db;
use crmeb\basic\BaseController;
use think\facade\Log;


class My extends BaseController{

    /**
     * @return void 获取用户设备、手机、邮箱、关联银行账户姓名、关联银行卡账户
     */
    public static function getUidinformation($uid){
        $share_strlog = Db::name('share_strlog')->field('phone,email,login_ip')->where('uid',$uid)->find();
        if(!$share_strlog){
            return ['code' => 201,'msg' => '用户不存在','data' => []];
        }
        $data = [];
        if($share_strlog['phone']){
            $data['phone']= $share_strlog['phone'];
        }
        if($share_strlog['email']){
            $data['email']= $share_strlog['email'];
        }

        if($share_strlog['login_ip']){
            $data['ip']= $share_strlog['login_ip'];
        }
        $user_withinfo = Db::name('user_withinfo')->field('account,type')->where('uid',$uid)->select()->toArray();
        if($user_withinfo){
            $typeCofig = config('my.withdrawType');
            foreach ($user_withinfo as $value){
                $data[$typeCofig[$value['type']]] = $value['account'];
            }
        }

        return ['code' => 200,'msg' => '成功','data' => $data];
    }


    /**
     * @return void 获取用户的关联用户
     * @param $uid 用户的uid
     */
    public static function glUid($uid){


        $share_strlog = Db::name('share_strlog')->field('phone,email,ip')->where('uid',$uid)->find();
        $where = '';
        if($share_strlog['phone']){
            $where .= "phone = '".$share_strlog['phone']."'";
        }

        if($share_strlog['email']){
            $where .= $where ? " OR email = '".$share_strlog['email']."'" : "email = '".$share_strlog['email']."'";
        }



        if($share_strlog['ip']){
            $where .= $where ? " OR ip = '".$share_strlog['ip']."'" : "ip = '".$share_strlog['ip']."'";
        }

        $share_strlog_array = [];
        if($where){
            $share_strlog_array = Db::name('share_strlog')->field('uid')->whereRaw($where)->group('uid')->select()->toArray();
        }
        $user_withinfo = Db::name('user_withinfo')->field('account')->where('uid',$uid)->select()->toArray();

        $user_withinfo_array = [];
        if($user_withinfo){
            $user_withinfo_where = '';
            $count = 0;
            foreach ($user_withinfo as $v){
                $user_withinfo_where .= $count == 0 ? "account = '".$v['account']."'" : " OR account = '".$v['account']."'";
                $count ++ ;
            }
            $user_withinfo_array = Db::name('user_withinfo')->field('uid')->whereRaw($user_withinfo_where)->group('uid')->select()->toArray();
        }

        $data = array_merge($share_strlog_array,$user_withinfo_array);
        $uid_array = [];
        foreach ($data as $l){
            $uid_array[] = $l['uid'];
        }
        $uid_array = array_unique($uid_array); //去重
        $index = array_search($uid, $uid_array); //返回自己uid的索引
        if ($index !== false) { // 如果找到了
            unset($uid_array[$index]); // 删除该元素
        }
        return $uid_array;
    }


    /**
     * @return void 获取用户的关联用户按照设备、手机、邮箱、关联银行账户姓名、关联银行卡账户
     * @param $uid 用户的uid
     */
    public static function glTypeUid($uid){

        $share_strlog = Db::name('share_strlog')->field('phone,email,ip,device_id')->where('uid',$uid)->find();

        $phoneUid = []; //关联的电话
        if($share_strlog['phone']) $phoneUid = Db::name('share_strlog')->where([['uid','<>',$uid],['phone','=',$share_strlog['phone']]])->column('uid');



        $emailUid = []; //关联的邮箱
        if($share_strlog['email']) $emailUid = Db::name('share_strlog')->field('uid')->where([['uid','<>',$uid],['email','=',$share_strlog['email']]])->column('uid');





        $ipUid = []; //关联的IP
        if($share_strlog['ip']) $ipUid = Db::name('share_strlog')->field('uid')->where([['uid','<>',$uid],['ip','=',$share_strlog['ip']]])->column('uid');


        $user_withinfo = Db::name('user_withinfo')->field('account,type')->where('uid',$uid)->select()->toArray();
        $bankaccountUid = []; //关联的银行账号
        $upiUid = []; //关联的银行账号
        if($user_withinfo){
            $typeCofig = [1 => 'bankaccountWhere',2 => 'upiWhere'];
            $bankaccountWhere = [];
            $upiWhere = [];
            foreach ($user_withinfo as $val){
                $flied = $typeCofig[$val['type']] ?? '';
                if($flied)array_push($$flied,(string)$val['account']);
            }

            $bankaccountWhere = array_unique($bankaccountWhere); //去重
            $upiWhere = array_unique($upiWhere); //去重

            if($bankaccountWhere)$bankaccountUid = Db::name('user_withinfo')->where('uid','<>',$uid)->whereIn('account',$bankaccountWhere)->group('uid')->column('uid');
            if($upiWhere)$upiUid = Db::name('user_withinfo')->where('uid','<>',$uid)->whereIn('account',$upiWhere)->group('uid')->column('uid');
        }
        return [$phoneUid,$emailUid,$ipUid,$bankaccountUid,$upiUid];

//     巴西
//        $deviceUid = [];
//        if($share_strlog['device_id'] && $share_strlog['device_id'] != '00000000000000000000000000000000')$deviceUid = Db::name('share_strlog')->field('uid')->where([['uid','<>',$uid],['device_id','=',$share_strlog['device_id']]])->column('uid');
//
//
//        //用户的CPF数组
//        $userCpfArray = Db::name('user_withinfo')->where('type','in','1')->where('uid',$uid)->column('account');
//        $cpfUid = [];
//
//
//        if($userCpfArray) $cpfUid = Db::name('user_withinfo')->field('uid')->where([['uid','<>',$uid],['account','in',$userCpfArray],['type','=',1]])->group('uid')->column('uid');



//        return [$phoneUid,$emailUid,$deviceUid,$ipUid,$cpfUid];
    }



    private static function getGlInfo(){

    }
    public static function headerdomain(){
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Headers:Accept,Referer,Host,Keep-Alive,User-Agent,X-Requested-With,Cache-Control,Content-Type,Cookie,token');
        header('Access-Control-Allow-Credentials:true');
        header('Access-Control-Allow-Methods:GET,POST,OPTIONS,PUT,DELETE');
        header('Access-Control-Max-Age:1728000');
        header('Content-Type:text/plain charset=UTF-8');
    }

    /**
     * @return void 用户、付费留存
     * @param $type 1=用户留存，2=付费留存-再付费 ,3=付费留存-再登录,4=成功付费留存
     * @param $start 开始的天数
     * @param $strtotime 查询表的时间戳
     */
    public static function statisticsRetained($type = 1,$start = 2,$strtotime = ''){
        $day_array15 = Common::getStartTimes(30,1,$start);  //获取近14日的时间戳

        $day45 = strtotime('00:00:00 -45 day');
        switch ($type){
            case 1:
                $fun = 'setStatisticsRetained';
                break;
            case 2:
                $fun = 'statisticsRetentionPaid';
                break;
            case 3:
                $fun = 'setStatisticsRetainedLg';
                break;
            default:
                $fun = 'setStatisticsRetainedWithLg';
        }
        foreach ($day_array15 as $k => $v){
            self::$fun($k+2,$v,$strtotime);
        }

        self::$fun(45,$day45,$strtotime);
    }

    /**
     * 用户留存数据
     * @param $fieldnum 修改的字段数字
     * @param $time 数据表time的时间
     * @param $strtotime 查询表的时间戳
     * @return void
     */
    public static function setStatisticsRetained($fieldnum,$time,$strtotime = ''){
        $strtotime = $strtotime ?: strtotime('-1 day');
        $field = 'day'.$fieldnum;
        $statistics_retaineduser = Db::name('statistics_retaineduser')->field('uids,package_id,channel')->where(['time' => $time])->select()->toArray();
        if(!$statistics_retaineduser){
            return ['code'=>201,'msg' => '暂无数据','data' =>[]];
        }
        $table = 'login_'.date('Ymd',$strtotime);
        $sql = "SHOW TABLES LIKE 'br_".$table."'";
        if(!Db::query($sql)){
            return ['code'=>201,'msg' => '数据表不存在','data' =>[]];
        }
        foreach ($statistics_retaineduser as $v){  //获取每日不同包不同渠道的用户

            $count = Db::name($table)->where('uid','in',$v['uids'])->count();

            if($count > 0){
                Db::name('statistics_retained')->where(['time'=> $time, 'package_id' => $v['package_id'], 'channel' => $v['channel']])
                    ->update([
                        $field => $count
                    ]);
            }
        }
    }



    /**
     * 付费留存-再付费数据
     * @param $fieldnum 修改的字段数字
     * @param $time 数据表time的时间
     * @return void
     */
    public static function statisticsRetentionPaid($fieldnum,$time,$strtotime = ''){
        $strtotime = $strtotime ?: strtotime('-1 day');
        $field = 'day'.$fieldnum;
        $statistics_retainedpaiduser = Db::name('statistics_retainedpaiduser')->field('uids,package_id,channel')->where(['time' => $time])->select()->toArray();
        if(!$statistics_retainedpaiduser){
            return ['code'=>201,'msg' => '暂无数据','data' =>[]];
        }
        $table = 'user_day_'.date('Ymd',$strtotime);
        $sql = "SHOW TABLES LIKE 'br_".$table."'";
        if(!Db::query($sql)){
            return ['code'=>201,'msg' => '数据表不存在','data' =>[]];
        }
        foreach ($statistics_retainedpaiduser as $v){  //获取每日不同包不同渠道的用户

            $count = Db::name($table)->where([['uid','in',$v['uids']],['total_pay_score','>',0]])->count();
            if($count > 0){

                Db::name('statistics_retentionpaid')->where(['time'=> $time, 'package_id' => $v['package_id'], 'channel' => $v['channel']])
                    ->update([
                        $field => $count,
                    ]);
            }
        }



//        $strtotime = $strtotime ?: strtotime('-1 day');
//        $field = 'day'.$fieldnum;
//        $payMoneyField = 'paymoney'.$fieldnum;
//        $statistics_retainedpaiduser = Db::name('statistics_retainedpaiduser')->field('uids,package_id,channel')->where(['time' => $time])->select()->toArray();
//        if(!$statistics_retainedpaiduser){
//            return ['code'=>201,'msg' => '暂无数据','data' =>[]];
//        }
//        $table = 'user_day_'.date('Ymd',$strtotime);
//        $sql = "SHOW TABLES LIKE 'br_".$table."'";
//        if(!Db::query($sql)){
//            return ['code'=>201,'msg' => '数据表不存在','data' =>[]];
//        }
//        foreach ($statistics_retainedpaiduser as $v){  //获取每日不同包不同渠道的用户
//
//            $day_table = Db::name($table)->field('total_pay_score')->where([['uid','in',$v['uids']],['total_pay_score','>',0]])->select()->toArray();
//
//            if($day_table){
//                $count = 0;
//                $paymoney = 0;
//                foreach ($day_table as $val){
//                    $count = $count + 1;
//                    $paymoney = bcadd($val['total_pay_score'],$paymoney,0);
//                }
//                Db::name('statistics_retentionpaid')->where(['time'=> $time, 'package_id' => $v['package_id'], 'channel' => $v['channel']])
//                    ->update([
//                        $field => $count,
//                        $payMoneyField => $paymoney,
//                    ]);
//            }
//        }
    }



    /**
     * 付费留存-再登录数据
     * @param $fieldnum 修改的字段数字
     * @param $time 数据表time的时间
     * @param $strtotime 查询表的时间戳
     * @return void
     */
    public static function setStatisticsRetainedLg($fieldnum,$time,$strtotime = ''){
        $strtotime = $strtotime ?: strtotime('-1 day');
        $field = 'day'.$fieldnum;
        $statistics_retainedpaiduser = Db::name('statistics_retainedpaiduser')->field('uids,package_id,channel')->where(['time' => $time])->select()->toArray();
        if(!$statistics_retainedpaiduser){
            return ['code'=>201,'msg' => '暂无数据','data' =>[]];
        }
        $table = 'login_'.date('Ymd',$strtotime);
        $sql = "SHOW TABLES LIKE 'br_".$table."'";
        if(!Db::query($sql)){
            return ['code'=>201,'msg' => '数据表不存在','data' =>[]];
        }
        foreach ($statistics_retainedpaiduser as $v){  //获取每日不同包不同渠道的用户

            $count = Db::name($table)->where('uid','in',$v['uids'])->count();

            if($count > 0){
                Db::name('statistics_retentionpaidlg')->where(['time'=> $time, 'package_id' => $v['package_id'], 'channel' => $v['channel']])
                    ->update([
                        $field => $count
                    ]);
            }
        }
    }




    /**
     * 成功付费留存-再登录数据
     * @param $fieldnum 修改的字段数字
     * @param $time 数据表time的时间
     * @param $strtotime 查询表的时间戳
     * @return void
     */
    public static function setStatisticsRetainedWithLg($fieldnum,$time,$strtotime = ''){
        $strtotime = $strtotime ?: strtotime('-1 day');
        $field = 'day'.$fieldnum;
        $statistics_retainedpaiduser = Db::name('statistics_retainedwith')->field('uids,package_id,channel')->where(['time' => $time])->select()->toArray();
        if(!$statistics_retainedpaiduser){
            return ['code'=>201,'msg' => '暂无数据','data' =>[]];
        }
        $table = 'login_'.date('Ymd',$strtotime);
        $sql = "SHOW TABLES LIKE 'br_".$table."'";
        if(!Db::query($sql)){
            return ['code'=>201,'msg' => '数据表不存在','data' =>[]];
        }
        foreach ($statistics_retainedpaiduser as $v){  //获取每日不同包不同渠道的用户

            $count = Db::name($table)->where('uid','in',$v['uids'])->count();

            if($count > 0){
                Db::name('statistics_retainedwithlg')->where(['time'=> $time, 'package_id' => $v['package_id'], 'channel' => $v['channel']])
                    ->update([
                        $field => $count
                    ]);
            }
        }
    }

    /**
     * @return void 监控定时任务执行时间与次数
     * @param $fun_name 方法名
     * @param $id  $id > 0 修改 ， $id <= 0 添加
     *
     */
    public static function setFunGetTime($fun_name,$id = 0){
        if($id > 0){
            Db::name('fun_gettime')
                ->where('id',$id)
                ->update([
                    'time' => Db::raw(time().' - createtime')
                ]);
            return 0;
        }
        return Db::name('fun_gettime')->insertGetId([
            'fun_name' => $fun_name,
            'createtime' => time(),
        ]);

    }



    /**
     * 签到赠送、注册赠送、首充活动、破产活动、周卡、分享返利、免费转盘、客损活动、bonus转化cash金额等活动参与人数和赠送金额
     * @param $type 1= 定时任务 ， 2= 查询某天数据并返回
     * @param $where 自定义条件
     * @param $time 查询哪天的时间戳
     */
    public static function gameSendCash($type = 1,$where = [],$time = ''){
        $starttime = $time ?: strtotime('00:00:00 -1 day');
        $endtime = $starttime + 86400;

        $reson_config = config('reason.tj_zs_reason');
        $reson = array_keys($reson_config);
        $coinData = [];
        if(Db::query("SHOW TABLES LIKE 'br_coin_".date('Ymd',$starttime)."'")){
            $coin = Db::name('coin_'.date('Ymd',$starttime))->field('uid,sum(num) as num,reason,package_id,channel')->where($where)->where('reason','in',$reson)->where('num','>',0)->where('channel','>',0)->group('reason,uid')->select()->toArray();
            if($coin){
                foreach ($coin as $value){
                    if(isset($coinData[$value['reason'].$value['package_id'].$value['channel']])){
                        $coinData[$value['reason'].$value['package_id'].$value['channel']]['money'] = $coinData[$value['reason'].$value['package_id'].$value['channel']]['money'] + $value['num'];
                        $coinData[$value['reason'].$value['package_id'].$value['channel']]['num'] = $coinData[$value['reason'].$value['package_id'].$value['channel']]['num'] + 1;
                    }else{
                        $coinData[$value['reason'].$value['package_id'].$value['channel']] = [
                            'time' => $starttime,
                            'title' => $reson_config[$value['reason']],
                            'money' => $value['num'],
                            'bonus' => 0,
                            'price' => 0,
                            'package_id' => $value['package_id'],
                            'channel' => $value['channel'],
                            'num' => 1,
                        ];
                    }
                }

            }
        }



        $bonus = Db::name('bonus_'.date('Ymd',$starttime))->field('uid,sum(num) as num,reason,package_id,channel')->where($where)->where('reason','in',$reson)->where('num','>',0)->where('channel','>',0)->group('reason,uid')->select()->toArray();
        $bonusData = [];
        if($bonus){
            foreach ($bonus as $bonusValue){
                if($coinData && isset($coinData[$bonusValue['reason'].$bonusValue['package_id'].$bonusValue['channel']])){
                    $coinData[$bonusValue['reason'].$bonusValue['package_id'].$bonusValue['channel']]['bonus'] = $coinData[$bonusValue['reason'].$bonusValue['package_id'].$bonusValue['channel']]['bonus'] + $bonusValue['num'];
                } elseif(isset($bonusData[$bonusValue['reason'].$bonusValue['package_id'].$bonusValue['channel']])){
                    $bonusData[$bonusValue['reason'].$bonusValue['package_id'].$bonusValue['channel']]['bonus'] = $bonusData[$bonusValue['reason'].$bonusValue['package_id'].$bonusValue['channel']]['bonus'] + $bonusValue['num'];
                    $bonusData[$bonusValue['reason'].$bonusValue['package_id'].$bonusValue['channel']]['num'] = $bonusData[$bonusValue['reason'].$bonusValue['package_id'].$bonusValue['channel']]['num'] + 1;
                }else{
                    $bonusData[$bonusValue['reason'].$bonusValue['package_id'].$bonusValue['channel']] = [
                        'time' => $starttime,
                        'title' => $reson_config[$bonusValue['reason']],
                        'money' => 0,
                        'bonus' => $bonusValue['num'],
                        'price' => 0,
                        'package_id' => $bonusValue['package_id'],
                        'channel' => $bonusValue['channel'],
                        'num' => 1,
                    ];
                }

            }
        }

        $order_config = [0 => '普通充值赠送'];
        $order_config_array = [0];
        $order = Db::name('order')
            ->field('active_id,sum(zs_money) as zs_money,sum(zs_bonus) as zs_bonus,sum(price) as price,package_id,channel')
            ->where([['finishtime','>=',$starttime],['finishtime','<',$endtime],['pay_status','=',1],['active_id','in',$order_config_array],['shop_id','=',0]])
            ->whereRaw('(zs_bonus + zs_money) > 0')
            ->where($where)->group('uid')
            ->select()
            ->toArray();
        $orderData = [];
        if($order){
            foreach ($order as $orderVal){
                if(isset($orderData[$orderVal['active_id'].$orderVal['package_id'].$orderVal['channel']])){
                    $orderData[$orderVal['active_id'].$orderVal['package_id'].$orderVal['channel']]['money'] = $orderData[$orderVal['active_id'].$orderVal['package_id'].$orderVal['channel']]['money'] + $orderVal['zs_money'];
                    $orderData[$orderVal['active_id'].$orderVal['package_id'].$orderVal['channel']]['bonus'] = $orderData[$orderVal['active_id'].$orderVal['package_id'].$orderVal['channel']]['bonus'] + $orderVal['zs_bonus'];
                    $orderData[$orderVal['active_id'].$orderVal['package_id'].$orderVal['channel']]['price'] = $orderData[$orderVal['active_id'].$orderVal['package_id'].$orderVal['channel']]['price'] + $orderVal['price'];
                    $orderData[$orderVal['active_id'].$orderVal['package_id'].$orderVal['channel']]['num'] = $orderData[$orderVal['active_id'].$orderVal['package_id'].$orderVal['channel']]['num'] + 1;
                }else{
                    $orderData[$orderVal['active_id'].$orderVal['package_id'].$orderVal['channel']] = [
                        'time' => $starttime,
                        'title' => $order_config[$orderVal['active_id']],
                        'money' => $orderVal['zs_money'],
                        'bonus' =>$orderVal['zs_bonus'],
                        'price' =>$orderVal['price'],
                        'package_id' => $orderVal['package_id'],
                        'channel' => $orderVal['channel'],
                        'num' => 1,
                    ];
                }
            }


        }


        $shop_config = [10 => '首充商城'];
        $shop_config_array = [10];

        $shop = Db::name('shop_log')
            ->field('type,sum(zs_money) as zs_money,sum(zs_bonus) as zs_bonus,sum(money) as price,package_id,channel')
            ->where([['createtime','>=',$starttime],['createtime','<',$endtime],['type','in',$shop_config_array]])
            ->whereRaw('(zs_bonus + zs_money) > 0')
            ->where($where)
            ->group('type,uid')
            ->select()
            ->toArray();
        $shopData = [];
        if($shop){
            foreach ($shop as $shopVal){
                if(isset($shopData[$shopVal['type'].$shopVal['package_id'].$shopVal['channel']])){
                    $shopData[$shopVal['type'].$shopVal['package_id'].$shopVal['channel']]['money'] = $shopData[$shopVal['type'].$shopVal['package_id'].$shopVal['channel']]['money'] + $shopVal['zs_money'];
                    $shopData[$shopVal['type'].$shopVal['package_id'].$shopVal['channel']]['bonus'] = $shopData[$shopVal['type'].$shopVal['package_id'].$shopVal['channel']]['bonus'] + $shopVal['zs_bonus'];
                    $shopData[$shopVal['type'].$shopVal['package_id'].$shopVal['channel']]['price'] = $shopData[$shopVal['type'].$shopVal['package_id'].$shopVal['channel']]['price'] + $shopVal['price'];
                    $shopData[$shopVal['type'].$shopVal['package_id'].$shopVal['channel']]['num'] = $shopData[$shopVal['type'].$shopVal['package_id'].$shopVal['channel']]['num'] + 1;
                }else{
                    $shopData[$shopVal['type'].$shopVal['package_id'].$shopVal['channel']] = [
                        'time' => $starttime,
                        'title' => $shop_config[$shopVal['type']],
                        'money' => $shopVal['zs_money'],
                        'bonus' =>$shopVal['zs_bonus'],
                        'price' =>$shopVal['price'],
                        'package_id' => $shopVal['package_id'],
                        'channel' => $shopVal['channel'],
                        'num' => 1,
                    ];
                }
            }


        }




        $active_type = [3 => '破产活动',4 => '客损活动' , 5 => '预流失活动',6 =>'客损活动2', 7 => '存钱罐'];
        $active_type_array = [3,4,5,6];
        $active_log = Db::name('order_active_log')->field('type,sum(zs_money) as zs_money,sum(zs_bonus) as zs_bonus,sum(money) as price,package_id,channel')->where([['createtime','>=',$starttime],['createtime','<',$endtime],['type','in',$active_type_array]])->where($where)->group('type,package_id,channel')->select()->toArray();
        $active_log_data = [];
        if($active_log){
            foreach ($active_log as $v){
                //这里的数据不多，就直接循环查询就是了
                $userCount = Db::name('order_active_log')
                    ->where([
                        ['createtime', '>=', $starttime],
                        ['createtime', '<', $endtime],
                        ['type', '=',$v['type']],
                        ['package_id', '=',$v['package_id']],
                        ['channel', '=',$v['channel']],
                    ])
                    ->group('uid')
                    ->count();

                $active_log_data[] = [
                    'time' => $starttime,
                    'title' => $active_type[$v['type']],
                    'money' => $v['zs_money'],
                    'bonus' => $v['zs_bonus'],
                    'price' => $v['price'],
                    'package_id' => $v['package_id'],
                    'channel' => $v['channel'],
                    'num' => $userCount,
                ];
            }
        }


        $statistics_gamesendcash = array_merge($coinData,$bonusData,$orderData,$shopData,$active_log_data);
        if($type == 1){
            Db::name('statistics_gamesendcash')->insertAll($statistics_gamesendcash);
            return json(['code' => 200,'msg' => '统计成功','data' => []]);
        }
        return $statistics_gamesendcash;
    }


}

