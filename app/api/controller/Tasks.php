<?php
namespace app\api\controller;


use app\admin\model\system\SystemConfig;
use think\facade\Db;
use think\facade\Log;
use crmeb\basic\BaseController;
use dateTime\dateTime;
use app\admin\controller\Model;

class Tasks extends BaseController {



    /**
     * 特殊包每日反水统计
     * @return void
     */
    public function specialDayCashBackaaa(){
        $date = date('Ymd');
        //获取已经执行到那一块的游戏ID
        $redis = new \Redis();
        $redis->connect(config('redis.ip'), 5502);
        $dayTimeID = $redis->hGet('DayCashBackId',20241012);
        dd($dayTimeID);
    }



    /**
     * 特殊包每日反水统计
     * @return void
     */
    public function specialDayCashBack(){
        $date = date('Ymd');
        //获取已经执行到那一块的游戏ID
        $redis = new \Redis();
        $redis->connect(config('redis.ip'), 5502);
        $dayTimeID = $redis->hGet('DayCashBackId',$date);
        $where = [];
        if($dayTimeID){
            $where[] = ['id','>',$dayTimeID];
        }else{ //检查昨日是否还没有执行完的数据，并删除昨日的数据
            $yesToday = date('Ymd',strtotime('-1 day'));
            $yesTodayTimeID = $redis->hGet('DayCashBackId',$yesToday);
            if($yesTodayTimeID)$this->DealWithDayCashBack([['id','>',$yesTodayTimeID]],$yesToday,$redis,2);
        }
        return $this->DealWithDayCashBack($where,$date,$redis);
    }

    /**
     * 批量处理特殊包每日反水统计
     * @param $yesTodayTimeIdWhere 查询的ID条件
     * @param $yesToday 对应数据表
     * @param $type 1 = 不删除redis数据 ， 2= 删除redis数据
     * @return void
     */
    private function DealWithDayCashBack($yesTodayTimeIdWhere,$yesToday,$redis,$type = 1){
        $SystemConfig = SystemConfig::getMore('special_package_ids,new_cash_back_type,new_day_jars_cashback_bili,new_day_cashback_not,new_day_cashback_hiddenbutton_bili'); //特殊包每日反水统计
        if(!$SystemConfig['special_package_ids'] || $SystemConfig['new_day_jars_cashback_bili'] <= 0)return '活动暂未开始';
        $where = []; //游戏类型 1=自研 ，2=三方 ， 3=全部
        if($SystemConfig['new_cash_back_type'] == 1){
            $where[] = ['terrace_name','=','zy'];
        }elseif ($SystemConfig['new_cash_back_type'] == 2){
            $where[] = ['terrace_name','<>','zy'];
        }

        $slots_log = Db::name('slots_log_'.$yesToday)
            ->field('cashTransferAmount,uid,id')
            ->where($yesTodayTimeIdWhere)
            ->where($where)
            ->where('cashTransferAmount','<',0)
            ->where('package_id','in',$SystemConfig['special_package_ids'])
            ->order('id','asc')
            ->select()
            ->toArray();
        if(!$slots_log)return '暂无反水记录';

        [$newSlotsLog,$max_slots_log_id,$userInfoCreatetime] = $this->getNewCashBackData($slots_log);
        $first_cash_data = []; //第一次反水用户
        foreach ($newSlotsLog as $uid => $cashTransferAmount){
            if($cashTransferAmount <= 0)continue;
            //实际返利金额
            $amount = bcmul((string)$cashTransferAmount,(string)$SystemConfig['new_day_jars_cashback_bili'],0);
            //处理暗扣
            if($SystemConfig['new_day_cashback_not'] > 0){
                $userCreatetime = $userInfoCreatetime[$uid] ?? 0;
                if($userCreatetime <= 0 || bcadd($userCreatetime,bcmul($SystemConfig['new_day_cashback_not'],86400,0),0) < time()){
                    $amount = bcmul((string)$amount,(string)$SystemConfig['new_day_cashback_hiddenbutton_bili'],0);
                }
            }
            if($amount <= 0)continue;
            $res = Db::name('new_day_cash_bask')->where('uid',$uid)->update([
                'sy_amount' => Db::raw('sy_amount + '.$amount),
                'all_amount' => Db::raw('all_amount + '.$amount)
            ]);
            if(!$res)$first_cash_data[] = [
                'uid' => $uid,
                'sy_amount' => $amount,
                'all_amount' => $amount,
            ];
        }
        if($first_cash_data)Db::name('new_day_cash_bask')->insertAll($first_cash_data);
        if($type == 2){
            $redis->hDel('DayCashBackId',$yesToday);
        }else{
            $redis->hSet('DayCashBackId',$yesToday,$max_slots_log_id);
        }
        return '成功';
    }

    /**
     * 整理新的游戏数据
     * @param $slots_log
     * @return array
     */
    private function getNewCashBackData($slots_log){
        $data = [];
        $max_slots_log_id = 0; //获取最大的ID
        $uidArray = [];
        foreach ($slots_log as $v){
            if(isset($data[$v['uid']])){
                $data[$v['uid']] = bcadd((string)abs($v['cashTransferAmount']),(string)$data[$v['uid']],0);

            }else{
                $data[$v['uid']] = abs($v['cashTransferAmount']);
                $uidArray[] = $v['uid'];
            }
            $max_slots_log_id = $v['id'];
        }
        $userInfoCreatetime = Db::name('userinfo')->where('uid','in',$uidArray)->column('regist_time','uid');
//        dd($userInfoCreatetime);
        return [$data,$max_slots_log_id,$userInfoCreatetime];
    }




    /**
     * 特殊包每周反水统计实时统计输赢
     * @return void
     */
    public function specialWeekCashBack(){
        $date = date('Ymd');
        //获取已经执行到那一块的游戏ID
        $redis = new \Redis();
        $redis->connect(config('redis.ip'), 5502);
        $dayTimeID = $redis->hGet('WeekCashBackId',$date);
        $where = [];
        if($dayTimeID){
            $where[] = ['id','>',$dayTimeID];
        }else{ //检查昨日是否还没有执行完的数据，并删除昨日的数据
            $yesToday = date('Ymd',strtotime('-1 day'));
            $yesTodayTimeID = $redis->hGet('WeekCashBackId',$yesToday);
            if($yesTodayTimeID)$this->DealWithWeekCashBack([['id','>',$yesTodayTimeID]],$yesToday,$redis,2);
        }
        return $this->DealWithWeekCashBack($where,$date,$redis);
    }



    private function DealWithWeekCashBack($yesTodayTimeIdWhere,$yesToday,$redis,$type = 1){
        $SystemConfig = SystemConfig::getMore('special_package_ids,new_week_cash_back_type'); //特殊包每日反水统计
        if(!$SystemConfig['special_package_ids'])return '活动暂未开始';
        $where = []; //游戏类型 1=自研 ，2=三方 ， 3=全部
        if($SystemConfig['new_week_cash_back_type'] == 1){
            $where[] = ['terrace_name','=','zy'];
        }elseif ($SystemConfig['new_week_cash_back_type'] == 2){
            $where[] = ['terrace_name','<>','zy'];
        }

        $slots_log = Db::name('slots_log_'.$yesToday)
            ->field('cashBetAmount,cashTransferAmount,uid,id')
            ->where($yesTodayTimeIdWhere)
            ->where($where)
            ->where('cashBetAmount','>',0)
            ->where('package_id','in',$SystemConfig['special_package_ids'])
            ->order('id','asc')
            ->select()
            ->toArray();
        if(!$slots_log)return '暂无反水记录';

        // 每周的开始时间
        $thisWeekMonday = date('Ymd',strtotime('Monday this week', time()));

        [$newSlotsLog,$max_slots_log_id,$userinfoVip] = $this->getNewWeekCashBackData($slots_log);

        $first_cash_data = []; //第一次反水用户
        foreach ($newSlotsLog as $uid => $value){
//            if($cashTransferAmount == 0)continue;
            $res = Db::name('new_week_cash_bask')->where(['uid' => $uid,'date' => $thisWeekMonday])->update([
                'cashTransferAmount' => Db::raw('cashTransferAmount + '.$value['cashTransferAmount']),
                'cashBetAmount' => Db::raw('cashBetAmount + '.$value['cashBetAmount']),
                'vip' => $userinfoVip[$uid] ?? 1,
            ]);
            if(!$res)$first_cash_data[] = [
                'uid' => $uid,
                'cashTransferAmount' => $value['cashTransferAmount'],
                'cashBetAmount' => $value['cashBetAmount'],
                'date' => $thisWeekMonday,
                'vip' => $userinfoVip[$uid] ?? 1,
            ];
        }
        if($first_cash_data)Db::name('new_week_cash_bask')->insertAll($first_cash_data);
        if($type == 2){
            $redis->hDel('WeekCashBackId',$yesToday);
        }else{
            $redis->hSet('WeekCashBackId',$yesToday,$max_slots_log_id);
        }
        return '成功';
    }

    /**
     * 整理周反水记录
     * @param $slots_log
     * @return array
     */
    private function getNewWeekCashBackData($slots_log){
        $data = [];
        $max_slots_log_id = 0; //获取最大的ID
        $uidArray = [];
        foreach ($slots_log as $v){
            if(isset($data[$v['uid']])){
                $data[$v['uid']] = [
                    'cashTransferAmount' => bcadd((string)$v['cashTransferAmount'],(string)$data[$v['uid']]['cashTransferAmount'],0),
                    'cashBetAmount' => bcadd((string)$v['cashBetAmount'],(string)$data[$v['uid']]['cashBetAmount'],0),
                ];
            }else{
                $data[$v['uid']] = [
                    'cashTransferAmount' => $v['cashTransferAmount'],
                    'cashBetAmount' => $v['cashBetAmount'],
                ];
                $uidArray[] = $v['uid'];
            }
            $max_slots_log_id = $v['id'];
        }
        $userinfoVip = Db::name('userinfo')->where('uid','in',$uidArray)->column('vip','uid');
        return [$data,$max_slots_log_id,$userinfoVip];
    }


    /**
     * 这里必须比上面的晚特殊包每周反水统计实时统计输赢
     * 最终统计上周的周反水数据
     * @return void
     */
    public function newWeekCashbackLog(){
        //获取上周的开始时间
        [$last_week_start,] = \dateTime\dateTime::startEndWeekTime(strtotime(' -7 day'));

        $new_week_cash_bask = Db::name('new_week_cash_bask')->where([['date','=',date('Ymd',$last_week_start)],['status','=',0]])->column('vip,cashBetAmount,cashTransferAmount','uid');
        if(!$new_week_cash_bask)return '暂无统计';
        //获取流水配置
        $new_week_cashback_config = Db::name('new_week_cashback_config')
            ->field('maxamount,bili,minwater,maxwater')
            ->select()
            ->toArray();
        if(!$new_week_cashback_config)return '活动暂为开始';
        //获取Vip配置
        $vipConfig = Db::name('vip')->column('new_week_min_amount','vip');
        if(!$vipConfig)return '活动暂为开始';

        $new_week_cashback_log_data = [];
        foreach ($new_week_cash_bask as $uid => $value){
            $cashTransferAmount = abs($value['cashTransferAmount']);
            if($cashTransferAmount <= 0 || $value['cashBetAmount'] <= 0)continue;
            //判断充值区间
            $bili = 0; //反水比例
            $maxAmount = 0; //最大的反水金额
            foreach ($new_week_cashback_config as $v){ //获取反水配置
                if($v['minwater'] <= $value['cashBetAmount'] && $v['maxwater'] >= $value['cashBetAmount']){
                    $bili = $v['bili'];
                    $maxAmount = $v['maxamount'];
                    break;
                }
            }
            if($bili <= 0)continue;
            $amount = (int)bcmul((string)$cashTransferAmount,(string)$bili,0);
            $reallyAmount = min(max($amount,(int)$vipConfig[$value['vip']] ?? 0),$maxAmount);
            $new_week_cashback_log_data[] = [
                'uid' => $uid,
                'vip' => $value['vip'],
                'amount' => $reallyAmount,
                'total_cash_water_score' => $value['cashBetAmount'],
                'cash_total_score' => $value['cashTransferAmount'],
                'betrayal_start_date' => date('Ymd',$last_week_start),
            ];
        }
        if($new_week_cashback_log_data)Db::name('new_week_cashback_log')->insertAll($new_week_cashback_log_data);

        Db::name('new_week_cash_bask')->where([['date','=',date('Ymd',$last_week_start)],['status','=',0]])->update(['status' => 1]);
        return '反水成功';
    }


    //老包定时任务



    /**
     * 自研CashBack 统计
     * @param  $type 1= 统计当日自研反水 ，2= 统计昨日自研反水
     * @return void
     */
    public function zyCashBack($type = 1){
        $date = $type == 1 ? date('Ymd') : date('Ymd',strtotime('-1 day'));

        //获取自研游戏Cash、Bonus 的最大值和比例
        $zy_system_config = SystemConfig::getMore('zy_cashbak_max_cash,zy_cashbak_max_bonus,zy_cashbak_cash_bili,zy_cashbak_bonus_bili,special_package_ids');
        if($zy_system_config['zy_cashbak_cash_bili'] <= 0 && $zy_system_config['zy_cashbak_bonus_bili'] <= 0)return '活动暂未开启';

        $zdyWhere = [];
        if($zy_system_config['special_package_ids'])$zdyWhere[] = ['package_id','not in',$zy_system_config['special_package_ids']];

        $zy_cashback_config = Db::name('zy_cashback_config')->select()->toArray();
        $slots_log = Db::name('slots_log_'.$date)->where($zdyWhere)->where([['cashTransferAmount','<',0],['terrace_name','=','zy']])->group('uid')->column('sum(cashBetAmount) as cashBetAmount','uid');
        if(!$slots_log)return '暂无自研反水记录';



        $installData = [];
        $uidArray = array_keys($slots_log);
        $userinfo = Db::name('userinfo')->where('uid','in',$uidArray)->column('total_pay_score','uid');
        foreach ($slots_log as $uid => $value){
            //判断是否存在用户，同时用户是否充值过
            if(!isset($userinfo[$uid]) || $userinfo[$uid] <= 0)continue;
            //判断充值区间
            $zs_cash_basis_value = 0; //自研Cash反水基础金额
            $zs_bonus_basis_value = 0; //自研Bonus反水基础金额
            foreach ($zy_cashback_config as $v){ //获取反水配置
                if($v['minmoney'] <= $userinfo[$uid] && $v['maxmoney'] >= $userinfo[$uid]){
                    $zs_cash_basis_value = $v['zs_cash'];
                    $zs_bonus_basis_value = $v['zs_bonus'];
                    break;
                }
            }

            //获取流水理论应该反水的金额
            $zs_cash_value = bcmul((string)$zy_system_config['zy_cashbak_cash_bili'],(string)$value,0);
            $zs_bonus_value = bcmul((string)$zy_system_config['zy_cashbak_bonus_bili'],(string)$value,0);

            //获取理论和基础金额选择一个金额
            $zs_cash = max($zs_cash_value,$zs_cash_basis_value);
            $zs_bonus = max($zs_bonus_value,$zs_bonus_basis_value);

            //获取用户实际领取金额
            $really_zs_cash = min($zs_cash,$zy_system_config['zy_cashbak_max_cash']);
            $really_zs_bonus = min($zs_bonus,$zy_system_config['zy_cashbak_max_bonus']);
            if($really_zs_cash < 0 && $really_zs_bonus < 0)continue;

            $betrayal_log_id = Db::name('new_betrayal_log')->where([['uid','=',$uid],['betrayal_start_date','=',$date],['type','=',1]])->value('id');
            if(!$betrayal_log_id){
                $installData[] = [
                    'uid' => $uid,
                    'total_cash_water_score' => $value,
                    'cash_amount' => $really_zs_cash,
                    'bonus_amount' => $really_zs_bonus,
                    'createtime' => time(),
                    'type' => 1,
                    'betrayal_start_date' => $date,
                ];
            }else{
                Db::name('new_betrayal_log')->where('id',$betrayal_log_id)->update([
                    'total_cash_water_score' => $value,
                    'cash_amount' => $really_zs_cash,
                    'bonus_amount' => $really_zs_bonus,
                ]);
            }
        }

        if($installData)Db::name('new_betrayal_log')->insertAll($installData);
        return '自研反水成功';
    }

    /**
     * 反水定时任务是只返水三方，还是三方和自研一起反水
     * @param $is_new 1= 是新的反水需求和定时任务 ，2=  老版本反水定时任务
     * @param $type 1= 统计当日反水 ，2= 统计自研反水
     * @return void
     */
    public function sfCashBackTasks($is_new = 0,$type = 1){
       $cashback_type = SystemConfig::getConfigValue('cashback_type'); // 1=三方 ，2=三方加自研
       if($cashback_type == 1 && $is_new == 1){
           return $this->sfCashBack($type);
       }elseif($cashback_type != 1 && !$is_new){
           return $this->vipBetrayal();
       }
        return '暂未开启活动';
    }


    /**
     * 三方CashBack 统计
     * @param  $type 1= 统计当日自研反水 ，2= 统计昨日自研反水
     * @return void
     */
    public function sfCashBack($type = 1){
        //按照配置表每周反水
        $date = $type == 1 ? date('Ymd') : date('Ymd',strtotime('-1 day'));

        $special_package_ids = SystemConfig::getConfigValue('special_package_ids');
        $zdyWhere = [];
        if($special_package_ids)$zdyWhere[] = ['package_id','not in',$special_package_ids];

        $old_slots_log = Db::name('slots_log_'.$date)
            ->field('sum(cashTransferAmount) as cashTransferAmount,sum(cashBetAmount) as cashBetAmount,uid')
            ->where($zdyWhere)
            ->where([[['terrace_name','<>','zy']]])->group('uid')->select()->toArray();
        if(!$old_slots_log)return '暂无三方反水记录';
        $slots_log = [];
        foreach ($old_slots_log as $val){
            if($val['cashTransferAmount'] <= 0){
                $slots_log[$val['uid']] = [
                    'cashTransferAmount' => $val['cashTransferAmount'],
                    'cashBetAmount' => $val['cashBetAmount'],
                ];
            }
        }
        if(!$slots_log)return '暂无三方反水记录';

        $cashbackConfig = Db::name('cashback_config')->select()->toArray();
        if(!$cashbackConfig)return '暂无更多配置';

        //获取返水金额类型: 1= Cash ,2 = Bonus
        $cashback_amonut_type = SystemConfig::getConfigValue('cashback_amonut_type');

        $installData = []; //反水数据
        foreach ($slots_log as $uid => $value){
            //获取反水配置
            $cashbackData = [];
            foreach ($cashbackConfig as $v){ //获取反水配置
                if($v['minwater'] <= $value['cashBetAmount'] && $v['maxwater'] >= $value['cashBetAmount']){
                    $cashbackData = $v;
                    break;
                }
            }
            if(!$cashbackData)continue;
            $total_score =bcsub('0', (string)$value['cashTransferAmount'],0); //总共输的金额
            $amount = bcmul((string)$cashbackData['bili'],$total_score,0); //实际反水的金额
            if($amount > $cashbackData['maxamount'])$amount = $cashbackData['maxamount'];

            if($cashback_amonut_type == 1){
                $really_sf_cash = $amount;
                $really_sf_bonus = 0;
            }else{
                $really_sf_cash = 0;
                $really_sf_bonus = $amount;
            }


            $betrayal_log_id = Db::name('new_betrayal_log')->where([['uid','=',$uid],['betrayal_start_date','=',$date],['type','=',2]])->value('id');
            if(!$betrayal_log_id){
                $installData[] = [
                    'uid' => $uid,
                    'total_cash_water_score' => $value['cashBetAmount'],
                    'cash_total_score' => $value['cashTransferAmount'],
                    'cash_amount' => $really_sf_cash,
                    'bonus_amount' => $really_sf_bonus,
                    'createtime' => time(),
                    'type' => 2,
                    'betrayal_start_date' => $date,
                ];
            }else{
                Db::name('new_betrayal_log')->where('id',$betrayal_log_id)->update([
                    'total_cash_water_score' =>  $value['cashBetAmount'],
                    'cash_amount' => $really_sf_cash,
                    'bonus_amount' => $really_sf_bonus,
                ]);
            }

        }
        if($installData)Db::name('new_betrayal_log')->insertAll($installData);

        return '三方游戏反水成功';
    }


    /**
     * vip反水
     * @return null
     *
     */
    public function vipBetrayal(){
        //按照配置表每周反水
        $time = date('Ymd',strtotime('-1 day'));

        $special_package_ids = SystemConfig::getConfigValue('special_package_ids');
        $zdyWhere = [];
        if($special_package_ids)$zdyWhere[] = ['package_id','not in',$special_package_ids];

        $list = Db::name('user_day_'.$time)
            ->field('uid,cash_total_score,vip,channel,package_id,total_cash_water_score')
            ->where([['cash_total_score','<',0],['vip','>',0]])
            ->where($zdyWhere)
            ->select()
            ->toArray();
        if(!$list)return '暂无数据返佣';
        $cashbackConfig = Db::name('cashback_config')->select()->toArray();
        if(!$cashbackConfig)return '暂无更多配置';
        $newList  = $this->getBetrayalUid($list);

        $betrayal_start_date = $time; //最开始结算的那天时间

        $betrayal_log = Db::name('betrayal_log')->where('betrayal_start_date',$betrayal_start_date)->find();
        if($betrayal_log)return '昨日奖励已统计';

        $betrayalUid = []; //反水数据
        foreach ($newList as $uid => $value){
            if($value['cash_total_score'] >= 0)continue;
            //获取反水配置
            $cashbackData = [];
            foreach ($cashbackConfig as $v){ //获取反水配置
                if($v['minwater'] <= $value['total_cash_water_score'] && $v['maxwater'] >= $value['total_cash_water_score']){
                    $cashbackData = $v;
                    break;
                }
            }
            if(!$cashbackData)continue;
            $total_score =bcsub('0', (string)$value['cash_total_score'],0); //总共输的金额
            $amount = bcmul((string)$cashbackData['bili'],$total_score,0); //实际反水的金额
            if($amount > $cashbackData['maxamount'])$amount = $cashbackData['maxamount'];
            $betrayalUid[] = [
                'amount' => $amount,
                'uid' => $uid,
                'total_cash_water_score' => $value['total_cash_water_score'],
                'cash_total_score' => $value['cash_total_score'], //用户上周结算输的金额
                'vip' => $value['vip'], //用户的上周结算VIP等级
                'betrayal_bili' => $cashbackData['bili'], //用户的上周结算的反水比例
                'package_id' => $value['package_id'],
                'channel' => $value['channel'],
                'createtime' => time(), //创建时间
                'betrayal_start_date' => $betrayal_start_date
            ];
        }
        if($betrayalUid)Db::name('betrayal_log')->insertAll($betrayalUid);

        return '成功';

    }

    /**
     * @return void 整理反水用户的数据
     */

    private function getBetrayalUid($list){
        $newList = [];
        foreach ($list as $v){
            if(isset($newList[$v['uid']])){
                $newList[$v['uid']]['cash_total_score'] += $v['cash_total_score'] ;
                $newList[$v['uid']]['total_cash_water_score'] += $v['total_cash_water_score'] ;//按照配置表每周反水
            }else{
                $newList[$v['uid']] = [
                    'cash_total_score' => $v['cash_total_score'],
                    'vip' => $v['vip'],
                    'channel' => $v['channel'],
                    'package_id' => $v['package_id'],
                    'total_cash_water_score' => $v['total_cash_water_score'],//按照配置表每周反水
                ];
            }
        }
        return $newList;
    }

    /**
     * 每日统计下级返佣数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function dayCommission(){
        //$date = date('Ymd',strtotime('-1 day'));
        $date = date('Ymd');
        $user_day = Db::name('user_day_' . $date)
            ->where('total_cash_water_score|total_bonus_water_score','>',0)
            ->field('uid,total_cash_water_score,total_bonus_water_score')
            ->select()->toArray();
        if(!$user_day) return json(['code' => 200,'msg' => '暂无需要返利的数据返利','data' => []]);

        $commissionlog_data = []; //返利记录
        $uidArray = []; //后期需要处理的每个返利用户加多少钱
        $bill_list = Db::name('commission_bill')->select()->toArray();

        foreach ($user_day as $v){
            //返利投注金额
            $commission_money = bcadd($v['total_cash_water_score'], $v['total_bonus_water_score'],0);
            if($commission_money <= 0)continue;

            $teamlevel = Db::name('teamlevel')->where('uid', $v['uid'])->where('level','>',0)->field('puid,level')->group('puid')->order('level','asc')->select()->toArray();
            if(!$teamlevel)continue;

            $yf_bili = 0; //以分的比例
            foreach ($teamlevel as $value){
                //团队流水
                $water = Db::name('user_water')->where('uid',$value['puid'])->find();
                if (!$water) continue;
                $team_water = bcadd($water['total_cash_water_score'], $water['total_bonus_water_score']);
                //返利比例
                $bill = 0;
                foreach ($bill_list as $kk=>$item) {
                    if ($item['total_amount'] > $team_water) {
                        $bill = bcdiv($bill_list[$kk-1]['bili'],10000,4);
                        break;
                    }
                }
                if($bill <= 0)continue;

                $user_bili = bcsub($bill, $yf_bili, 4);
                if($user_bili <= 0)break;//如果上级莫个用户没有分的了，那直接break，上面的肯定都没法分了
                //实际返利金额
                $really_money = bcmul($user_bili, $commission_money, 0);
                $commissionlog_data[] = [
                    'uid' => $value['puid'],
                    'char_uid' => $v['uid'],
                    'commission_money' => $commission_money,
                    'really_money' => $really_money,
                    'bili' => bcmul($user_bili,10000),
                    'level' => $value['level'],
                    'createtime' => time(),
                ];

                $uidArray[$value['puid']] = isset($uidArray[$value['puid']]) ? bcadd($uidArray[$value['puid']],$really_money,0) : $really_money;
                //处理已分的比例
                $yf_bili = bcadd($yf_bili,$user_bili,2);
            }
        }

        try {
            Db::startTrans();
            //返佣记录
            if($commissionlog_data)Db::name('commissionlog')->insertAll($commissionlog_data);
            //上级数据修改
            if($uidArray)foreach ($uidArray as $uid => $amount){
                Db::name('userinfo')->where('uid',$uid)->update([
                    'commission' => Db::raw('commission + '.$amount)
                ]);
                //User::userEditCoin($uid, $amount, 9, '下级返佣');
                //User::editUserTotalGiveScore($uid, $amount);
            }

            Db::commit();
            return json(['code' => 200,'msg' => '每日返佣成功','data' => []]);

        }catch (Exception $exception){
            Db::rollback();
            Log::record("错误文件===" . $exception->getFile() . '===错误行数===' . $exception->getLine() . '===错误信息===' . $exception->getMessage());
            return json(['code'=>201, 'mesg'=>'每日返佣失败']);
        }
    }


    /**
     * 实时计算每日用户获得返佣
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function realCommission(){
        //$date = date('Ymd',strtotime('-1 day'));
        $date = date('Ymd');
        $user_day = Db::name('user_day_' . $date)
            ->where('total_cash_water_score|total_bonus_water_score','>',0)
            ->field('uid,puid,total_cash_water_score,total_bonus_water_score')
            ->select()->toArray();
        if(!$user_day) return json(['code' => 200,'msg' => '暂无需要返利的数据返利（实时）','data' => []]);

        $uidArray = []; //后期需要处理的每个返利用户加多少钱
        $bill_list = Db::name('commission_bill')->select()->toArray();

        foreach ($user_day as $v){
            //返利投注金额
            $commission_money = bcadd($v['total_cash_water_score'], $v['total_bonus_water_score'],0);
            if($commission_money <= 0)continue;

            $teamlevel = Db::name('teamlevel')->where('uid', $v['uid'])->where('level','>',0)->field('puid,level')->group('puid')->order('level','asc')->select()->toArray();
            if(!$teamlevel)continue;

            $yf_bili = 0; //以分的比例
            foreach ($teamlevel as $value){
                //团队流水
                $water = Db::name('user_water')->where('uid',$value['puid'])->find();
                if (!$water) continue;
                $team_water = bcadd($water['total_cash_water_score'], $water['total_bonus_water_score']);
                //返利比例
                $bill = 0;
                $bill_level = 1;
                foreach ($bill_list as $kk=>$item) {
                    if ($item['total_amount'] > $team_water) {
                        $bill = bcdiv($bill_list[$kk-1]['bili'],10000,4);
                        $bill_level = $bill_list[$kk-1]['id'];
                        break;
                    }
                }
                if($bill <= 0)continue;

                $user_bili = bcsub($bill, $yf_bili, 4);
                if($user_bili <= 0)break;//如果上级莫个用户没有分的了，那直接break，上面的肯定都没法分了
                //实际返利金额
                $really_money = bcmul($user_bili, $commission_money, 0);

                $uidArray[$value['puid']]['really_money'] = isset($uidArray[$value['puid']]['really_money']) ? bcadd($uidArray[$value['puid']]['really_money'],$really_money,0) : $really_money;
                $uidArray[$value['puid']]['bill_level'] = $bill_level;
                //处理已分的比例
                $yf_bili = bcadd($yf_bili,$user_bili,2);
            }

            //计算投注
            if ($v['puid'] > 0) {
                $uidArray[$v['puid']]['bet'] = isset($uidArray[$v['puid']]['bet']) ? bcadd($uidArray[$v['puid']]['bet'], $commission_money, 0) : $commission_money;
                $uidArray[$v['puid']]['bet_num'] = isset($uidArray[$v['puid']]['bet_num']) ? bcadd($uidArray[$v['puid']]['bet_num'], 1, 0) : 1;
            }
        }

        //统计注册
        $day_teamlevel = Db::name('teamlevel')->where('level','>',0)->whereDay('createtime')->select()->toArray();
        if (!empty($day_teamlevel)){
            foreach ($day_teamlevel as $dtk=>$dtv){
                if (isset($uidArray[$dtv['puid']]['num'])){
                    $uidArray[$dtv['puid']]['num'] += 1;
                }else{
                    $uidArray[$dtv['puid']]['num'] = 1;
                }
            }
        }
        //dd($uidArray);

        try {
            Db::startTrans();

            //上级数据修改
            if($uidArray)foreach ($uidArray as $uid => $uav){
                $commission_day = Db::name('commission_day')->where('uid',$uid)->whereDay('date')->find();
                if (empty($commission_day)){
                    Db::name('commission_day')->insert([
                        'uid' => $uid,
                        'date' => date('Y-m-d'),
                        'commission' => isset($uav['really_money']) ? $uav['really_money'] : 0,
                        'bet' => isset($uav['bet']) ? $uav['bet'] : 0,
                        'bet_num' => isset($uav['bet_num']) ? $uav['bet_num'] : 0,
                        'bill_level' => isset($uav['bill_level']) ? $uav['bill_level'] : 0,
                        'num' => isset($uav['num']) ? $uav['num'] : 0,
                    ]);
                }else{
                    Db::name('commission_day')->where('id',$commission_day['id'])->update([
                        'commission' => isset($uav['really_money']) ? $uav['really_money'] : 0,
                        'bet' => isset($uav['bet']) ? $uav['bet'] : 0,
                        'bet_num' => isset($uav['bet_num']) ? $uav['bet_num'] : 0,
                        'bill_level' => isset($uav['bill_level']) ? $uav['bill_level'] : 0,
                        'num' => isset($uav['num']) ? $uav['num'] : 0,
                    ]);
                }
                //dd($commission_day);
            }

            Db::commit();
            return json(['code' => 200,'msg' => '每日返佣成功（实时）','data' => []]);

        }catch (Exception $exception){
            Db::rollback();
            Log::record("错误文件===" . $exception->getFile() . '===错误行数===' . $exception->getLine() . '===错误信息===' . $exception->getMessage());
            return json(['code'=>201, 'mesg'=>'每日返佣失败（实时）']);
        }
    }


    /**
     * 签到赠送、注册赠送、首充活动、破产活动、周卡、分享返利、免费转盘、客损活动、bonus转化cash金额等活动参与人数和赠送金额
     * @param $type 1= 定时任务 ， 2= 查询某天数据并返回
     * @param $where 自定义条件
     * @param $time 查询哪天的时间戳
     */
    public function gameSendCash($type = 1,$where = [],$time = ''){
        try {
            My::gameSendCash();
            return json(['code' => 200,'msg' => '统计成功','data' => []]);
        }catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error('gameSendCash==>'.$exception->getMessage());
            return json(['code' => 201,'msg' => '统计失败','data' => []]);
        }

    }

    /**
     *  定时删除一些数据
     */
    public function deleteData(){
        $time = strtotime('00:00:00 -9 day');
        Db::name('order')->where([['pay_status','=',0],['createtime','<=',$time],['paytype','<>','ser_pay']])->delete();
        Db::name('log')->where([['createtime','<=',$time]])->delete();
        return '完成';
    }



    /**
     * http://1.13.81.132:5009/api/Tasks/GenerateSqlTable
     * 生成数据表
     * @return void
     */
    public function GenerateSqlTable($date = ''){
        $date = $date ?: date('Y-m-d');
        $nextWeekStart = strtotime('next Monday', strtotime($date)); // 下周开始的天
        $nextWeekEnd = strtotime('next Sunday', $nextWeekStart); //下周结束的天
        $timeArray = dateTime::createDateRange($nextWeekStart,$nextWeekEnd,'Ymd');
        foreach ($timeArray as $v){
            Sql::getLoginTable($v);
            Sql::getRegistTable($v);
            Sql::getCoinTable($v);
            Sql::getBonusTable($v);
            Sql::getUserDayTable($v);
            Sql::getSlotsLogTable($v);
        }
        return '生成完成';

    }




    /**
     * 获取指定时间戳的当周的开始时间和结束时间
     * @param $time
     * @return array
     */
    public static function startEndWeekTime($time):array{
        $sdefaultDate = date("Y-m-d", $time);
        //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $w = date('w', strtotime($sdefaultDate));
        //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $week_start = strtotime("$sdefaultDate -" . ($w ? $w - 1 : 6) . ' days');
        //本周结束日期
        $week_end = strtotime(date('Y-m-d',$week_start)." +6 days") + 86399;

        return [$week_start,$week_end];
    }




    /**
     * @return void 用户、付费留存
     * @param $type 1=用户留存，2=付费留存-再付费 ,3=付费留存-再登录,4=成功付费留存
     * @param $start 开始的天数
     */
    public function statisticsRetained($type = 1,$start = 2){
        My::statisticsRetained($type,$start);
        return json(['code' => 200,'msg'=>'统计成功','data' => []]);
    }


    /**
     *每日定时统计
     * @param $type 1=用户留存，2=付费留存-再付费 ,3=付费留存-再登录,4=成功付费留存
     * @return void
     */
    public function dayStatisticsRetained($type = 1){
        My::statisticsRetained($type,1,strtotime('00:00:00'));
        return json(['code' => 200,'msg'=>'统计成功','data' => []]);
    }
}




