<?php
/**
 * 三方游戏公共方法
 */

namespace app\api\controller\slots;

use crmeb\services\MqProducer;
use think\facade\Config;
use think\facade\Db;
use think\facade\Log;
use app\common\xsex\User;


class Common {


    /**
     * 扣除用户余额。返回用户的Cash和Bonus总和
     * @param $uid
     * @return void
     */
    public static function setUserMoney($uid){
        //用户不存在
        $userinfo = Db::name('userinfo')->field('coin,bonus')->where('uid',$uid)->find();
        if(!$userinfo)return ['code' => 201,'msg' => '用户不存在','data' => []];

        $money = config('slots.is_carry_bonus') == 1 ? $userinfo['coin'] + $userinfo['bonus'] : $userinfo['coin'];

        if($money <= 0)return ['code' => 200,'msg' => '成功!余额为0','data' => 0];

//        Db::startTrans();
//
//        if($userinfo['coin'] > 0){
//            $res = User::userEditCoin($uid,bcsub(0,$userinfo['coin'],0),3,'玩家:'.$uid.'转入Cash-Slots带入:'.bcdiv($userinfo['coin'],100,2));
//            if(!$res){
//                Db::rollback();
//                return ['code' => 200,'msg' => '扣款Cash失败!余额为0','data' => 0];
//            }
//        }
//
//
//        if($userinfo['bonus'] > 0){
//            $res = User::userEditCoin($uid,bcsub(0,$userinfo['bonus'],0),3,'玩家:'.$uid.'转入Bonus-Slots带入:'.bcdiv($userinfo['bonus'],100,2));
//            if(!$res){
//                Db::rollback();
//                return ['code' => 200,'msg' => '扣出Bonus失败!余额为0','data' => 0];
//            }
//        }
//
//        Db::commit();
        return ['code' => 200,'msg' => '成功','data' => $money];
    }


    /**
     * 计算本次的Bonus和Cash输赢情况
     *
     *
     * @param $coin (分)
     * @param $bet_amount  下注金额(分)
     * @param $win_amount  结算金额(分)
     * @return void
     */
    private static function winningAndLosingStatus($coin,$bet_amount,$win_amount){
        //Cash下注金额,Bonus下注金额,Cash结算金额,Bonus结算金额,Cash实际输赢金额,Bonus实际输赢金额
        $cashBetAmount = 0;$bonusBetAmount = 0;$cashWinAmount = 0;$bonusWinAmount = 0;$cashTransferAmount = 0;$bonusTransferAmount = 0;
        //如果是子账单,有Cash余额就算Cash,没有Cash就算Bonus
        if($bet_amount <= 0){
            if($coin > 0){
                $cashBetAmount = $bet_amount;$cashWinAmount = $win_amount;$cashTransferAmount = bcsub($win_amount,$bet_amount,0);
            }else{
                $bonusBetAmount = $bet_amount;$bonusWinAmount = $win_amount;$bonusTransferAmount = bcsub($win_amount,$bet_amount,0);
            }
        }else{//如果是正常的母账单
            if($coin >= $bet_amount){ //如果coin大于下注金额
                $cashBetAmount = $bet_amount;$cashWinAmount = $win_amount;$cashTransferAmount = bcsub($win_amount,$bet_amount,0);
            }elseif ($coin > 0){//这里是coin和Bonus同时下注
                //求出比例
                $coin_bili = bcdiv($coin,$bet_amount,2);
                $cashBetAmount = $coin;
                $bonusBetAmount = bcsub($bet_amount,$coin,0);
                $cashWinAmount = bcmul($win_amount,$coin_bili,0);
                $bonusWinAmount = bcsub($win_amount,$cashWinAmount,0);
                $cashTransferAmount = bcsub($cashWinAmount,$cashBetAmount,0);
                $bonusTransferAmount = bcsub($bonusWinAmount,$bonusBetAmount,0);
            }else{ //只用Bonus下注
                $bonusBetAmount = $bet_amount;$bonusWinAmount = $win_amount;$bonusTransferAmount = bcsub($win_amount,$bet_amount,0);
            }
        }

        return [$cashBetAmount,$bonusBetAmount,$cashWinAmount,$bonusWinAmount,$cashTransferAmount,$bonusTransferAmount];

    }

    /**
     * 处理三方游戏数据
     * @param $data 存储slots_log数据表的数据
     * @param $coin (分)
     * @param $bonus (分)
     * @param $bet_amount 下注金额(分)
     * @param $win_amount 结算金额(分)
     * @param $type  1=添加游戏记录，2=修改游戏记录
     * @return void
     */
    public static function slotsLog($data,$coin,$bonus,$bet_amount,$win_amount,$type = 1){
        [$data['cashBetAmount'],$data['bonusBetAmount'],$data['cashWinAmount'],$data['bonusWinAmount'],$data['cashTransferAmount'],$data['bonusTransferAmount']] = self::winningAndLosingStatus($coin,$bet_amount,$win_amount);
        Db::startTrans();

        if($type == 1){
            $res = Db::name('slots_log_'.date('Ymd'))->insert($data);
            if(!$res){
                Log::error('uid:'.$data['uid'].'三方游戏记录表存储失败');
                Db::rollback();
                return ['code' => 201,'msg' => '三方游戏记录表存储失败'];
            }
        }else{
            $res = Db::name('slots_log_'.date('Ymd'))->where('betId',$data['betId'])->update(self::getUpdateSlotsData($data));
            if(!$res){
                Log::error('uid:'.$data['uid'].'三方游戏记录表修改失败-betId:'.$data['betId']);
                Db::rollback();
                return ['code' => 201,'msg' => '三方游戏记录表修改失败'];
            }
        }



        $res = self::userFundChange($data['uid'],$data['cashTransferAmount'],$data['bonusTransferAmount'],bcadd($coin,$data['cashTransferAmount'],0),bcadd($bonus,$data['bonusTransferAmount'],0),$data['channel'],$data['package_id']);
        if(!$res){
            Log::error('uid:'.$data['uid'].'三方游戏余额修改失败-Cash输赢:'.$data['cashTransferAmount'].'-Bonus输赢:'.$data['bonusTransferAmount']);
            Db::rollback();
            return ['code' => 201,'msg' => '三方游戏余额修改失败'];
        }
        Db::commit();

        //其它事务队列里面操作
        MqProducer::pushMessage($data,config('rabbitmq.slots_queue'));

        return ['code' => 200,'msg' => '成功','data' => bcadd(bcadd($coin,$bonus,0),bcsub($win_amount,$bet_amount,0),0)];
    }

    /**
     * 处理slots退款的订单
     * @param $slotsLog
     * @return void
     */
    public static function setRefundSlotsLog($slotsLog,$money){
        $refund_cash_amount = bcmul($money,bcdiv($slotsLog['cashBetAmount'],bcadd($slotsLog['cashBetAmount'],$slotsLog['bonusBetAmount'],0),2),0);
        $refund_bonus_amount = bcmul($money,bcdiv($slotsLog['bonusBetAmount'],bcadd($slotsLog['cashBetAmount'],$slotsLog['bonusBetAmount'],0),2),0);
        Db::startTrans();
        $userinfo = Db::name('userinfo')->field('coin,bonus')->where('uid',$slotsLog['uid'])->find();
        $res = self::userFundChange($slotsLog['uid'],$refund_cash_amount,$refund_bonus_amount,bcadd($userinfo['coin'],$refund_cash_amount,0),bcadd($userinfo['bonus'],$refund_bonus_amount,0),$slotsLog['channel'],$slotsLog['package_id']);
        if(!$res){
            Log::error('uid:'.$slotsLog['uid'].'三方游戏余额修改失败-Cash退还:'.$refund_cash_amount.'-Bonus退还:'.$refund_bonus_amount);
            Db::rollback();
            return ['code' => 201,'msg' => '三方游戏余额修改失败'];
        }
        $updateData = [
            'is_settlement' => 2,
            'cashRefundAmount' => $refund_cash_amount,
            'bonusRefundAmount' => $refund_bonus_amount,
        ];
        $res = self::updateSlotsLog($slotsLog['betId'],$updateData);
        if(!$res){
            Log::error('uid:'.$slotsLog['uid'].'三方游戏退还历史记录修改失败-betId:'.$slotsLog['betId']);
            Db::rollback();
            return ['code' => 201,'msg' => '三方游戏余额修改失败'];
        }

        Db::commit();

    }

    /**
     * 获取用户信息
     * @param $uid
     * @return array

     */
    public static function getUserInfo($uid){
        $userinfo = Db::name('userinfo')->field('puid,channel,package_id,coin,bonus')->where('uid',$uid)->find();
        if(!$userinfo)return [];
        //如果要带Bonus进入,就把这句话注释了
        $userinfo['bonus'] = config('slots.is_carry_bonus') == 1 ? $userinfo['bonus'] : 0;
        return $userinfo;
    }


    /**
     * 获取Slots下注修改数据
     * @param $data
     * @return array
     */
    private static function getUpdateSlotsData(array $data){
        return [
            'is_settlement' => 1,
            'betEndTime' => time(),
            'cashBetAmount' => $data['cashBetAmount'],
            'bonusBetAmount' => $data['bonusBetAmount'],
            'cashWinAmount' => $data['cashWinAmount'],
            'bonusWinAmount' => $data['bonusWinAmount'],
            'cashTransferAmount' => $data['cashTransferAmount'],
            'bonusTransferAmount' => $data['bonusTransferAmount'],
        ];
    }


    /**
     *  查询SlotsLog 数据表
     *   @param 日期
     */
    public static function SlotsLogView($betId){
        $slots_log = Db::name('slots_log_'.date('Ymd'))->where('betId',$betId)->find();
        if(!$slots_log)$slots_log = Db::name('slots_log_'.date('Ymd',strtotime( '-1 day')))->where('betId',$betId)->find();
        return $slots_log;
    }




    /**
     * 修改SlotsLog 数据表
     * @param $date 日期
     * @param $updateData 修改的数据
     * @return void
     */
    public static function updateSlotsLog($betId,$updateData){
        $res = Db::name('slots_log_'.date('Ymd'))->where('betId',$betId)->update($updateData);
        if(!$res)Db::name('slots_log_'.date('Ymd',strtotime( '-1 day')))->where('betId',$betId)->update($updateData);
        return $res;
    }

    /**
     * 资金变化
     * @param $uid 用户id
     * @param $cash_transferAmount 变化cash金额
     * @param $bouns_transferAmount 变化bouns金额
     * @param $new_cash 变化后cash金额
     * @param $new_bouns 变化后bouns金额
     * @param $channel 渠道号
     * @param $package_id 包id
     * @return void
     * @throws \think\db\exception\DbException
     */
    private static function userFundChange($uid, $cash_transferAmount, $bouns_transferAmount,$new_cash, $new_bouns, $channel, $package_id){
        if($cash_transferAmount == 0 && $bouns_transferAmount == 0)return true;
        $res = Db::name('userinfo')->where('uid', $uid)->update(['coin'=>$new_cash, 'bonus'=>$new_bouns]);

        if ($cash_transferAmount != 0) {
            $cash_data = [
                'uid' => $uid,
                'num' => $cash_transferAmount,
                'total' => $new_cash,
                'reason' => 3,
                'type' => $cash_transferAmount < 0 ? 0 : 1,
                'content' => '玩家:' . $uid . '玩三方游戏，资金变化' . $cash_transferAmount,
                'channel' => $channel,
                'package_id' => $package_id,
                'createtime' => time(),
            ];
            Db::name('coin_' . date('Ymd'))->insert($cash_data);
        }

        if ($bouns_transferAmount != 0) {
            $bouns_data = [
                'uid' => $uid,
                'num' => $bouns_transferAmount,
                'total' => $new_bouns,
                'reason' => 3,
                'type' => $bouns_transferAmount < 0 ? 0 : 1,
                'content' => '玩家:' . $uid . '玩三方游戏，资金变化' . $bouns_transferAmount,
                'channel' => $channel,
                'package_id' => $package_id,
                'createtime' => time(),
            ];
            Db::name('bouns_' . date('Ymd'))->insert($bouns_data);
        }
        if ($res){
            return true;
        }else{
            return false;
        }
    }
}





