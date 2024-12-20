<?php

namespace crmeb\services;

use app\api\controller\SqlModel;
use think\facade\Db;
use think\facade\Log;
use app\common\xsex\User;

/**
 *  Mq事务处理
 */
class MqDealWith
{
    /**
     * 三方游戏投付处理
     * @return void
     * @param  $data 三方游戏记录数据
     */
    public static function SlotsLogDealWith($data){
        if(!$data)return 1;
        $data = is_array($data) ? $data : json_decode($data,true);


        //检查是否已经消费了
        $is_consume = Db::name('slots_log_'.date('Ymd'))->field('betId')->where('betId',$data['betId'])->where('is_consume',1)->find();
        if($is_consume)return 1;


        $userinfo = Db::name('userinfo')
            ->field('vip,bonus,(total_cash_water_score + total_bonus_water_score) as total_water_score,need_bonus_score_water,now_bonus_score_water')
            ->where('uid',$data['uid'])
            ->find();
        if(!$userinfo)return 1;

        Db::startTrans();
        //处理VIP升级
        $vip = $userinfo['vip'];
        if(bcadd($data['cashBetAmount'],$data['bonusBetAmount'],0) > 0)$vip = self::vipLevelUpgrade($userinfo['vip'],$userinfo['total_water_score'],bcadd($data['cashBetAmount'],$data['bonusBetAmount'],0));


        //user_day表处理
        $user_day = new SqlModel(self::getSlotsUserDay($data,$vip));
        $res = $user_day->userDayDealWith();
        if(!$res){
            Db::rollback();
            Log::error('UID:'.$data['uid'].'三方游戏-betId:'.$data['betId'].'-user_day表数据处理失败');
            return 0;
        }


        //修改用户流水
        $res = self::editUserWater($data,$vip);
        if(!$res){
            Db::rollback();
            Log::error('UID:'.$data['uid'].'三方游戏-betId:'.$data['betId'].'-用户总流水处理失败');
            return 0;
        }

        //增加上级总流水
        if(bcadd($data['cashBetAmount'],$data['bonusBetAmount'],0) > 0){
            $res = self::setTopLevelWater($data);
            if (!$res){
                Db::rollback();
                Log::error('UID:'.$data['uid'].'三方游戏-betId:'.$data['betId'].'-上级团队总流水添加失败');
                return 0;
            }

            //处理是否将Bonus转换为Cash
            if($data['need_bonus_score_water'] > 0 && bcadd($data['bonusBetAmount'],$userinfo['now_bonus_score_water'],0) > $data['need_bonus_score_water']){
                $res = self::convertBonusToCash($data['uid'],$data['bonus']);
                if (!$res){
                    Db::rollback();
                    return 0;
                }
            }

        }

        Db::commit();
        //修改记录消费状态，这里就不需要加事务了
        Db::name('slots_log_'.date('Ymd'))->where('betId',$data['betId'])->update(['is_consume' => 1]);

        return 1;
    }


    /**
     * 计算本次Vip的等级
     * @param $oldVip
     * @param $total_water_score
     * @param $now_water_score
     * @return int
     */
    private static function vipLevelUpgrade($oldVip,$total_water_score,$now_water_score){
        $oldVip = $oldVip ?: 0;
        $vip = Db::name('vip')->where('need_water','<=',bcadd($total_water_score,$now_water_score,0))->order('vip','desc')->value('vip');
        return $vip ?: $oldVip;
    }

    /**
     * 处理Slots数据时,返回user_day表数据
     * @param array $data
     * @param  $vip vip等级
     * @return string[]
     */
    private static function getSlotsUserDay(array $data,$vip){
        return [
            'uid' => $data['uid'].'|up',
            'puid' => $data['puid'].'|up',
            'vip' => $vip.'|up',
            'channel' => $data['channel'].'|up',
            'package_id' => $data['package_id'].'|up',
            'cash_total_score' => $data['cashTransferAmount'].'|raw-+',
            'bonus_total_score' => $data['bonusTransferAmount'].'|raw-+',
            'total_cash_water_score' => $data['cashBetAmount'].'|raw-+',
            'total_bonus_water_score' => $data['bonusBetAmount'].'|raw-+',
            'total_game_num' => '1|raw-+',
        ];
    }


    /**
     * 处理用户流水，输赢，游戏次数等
     * @param $data  三方游戏记录
     * @param $vip vip等级
     * @return
     */
    private static function editUserWater($data,$vip){
        return Db::name('userinfo')->where('uid',$data['uid'])->update([
            'vip' => $vip,
            'now_cash_score_water' => Db::raw('now_cash_score_water + '.$data['cashBetAmount']),
            'now_bonus_score_water' => Db::raw('now_bonus_score_water + '.$data['bonusBetAmount']),
            'total_cash_water_score' => Db::raw('total_cash_water_score + '.$data['cashBetAmount']),
            'total_bonus_water_score' => Db::raw('total_bonus_water_score + '.$data['bonusBetAmount']),
            'total_game_num' => Db::raw('total_game_num + 1'),
            'cash_total_score' => Db::raw('cash_total_score + '.$data['cashTransferAmount']),
            'bonus_total_score' => Db::raw('bonus_total_score + '.$data['bonusTransferAmount']),
        ]);
    }


    /**
     * 增加上级的团队总流水
     * @param $data
     * @return int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private static function setTopLevelWater($data){
        $teamlevel = Db::name('teamlevel')->where('uid', $data['uid'])->where('level','>',0)->select()->toArray();
        $res = 1;
        if (!empty($teamlevel)){
            foreach ($teamlevel as $tv){
                if ($tv['puid'] > 0) {
                    $user_water = Db::name('user_water')->field('uid')->where('uid', $tv['puid'])->find();
                    if($user_water){
                        $res = Db::name('user_water')->where('uid', $tv['puid'])->update([
                            'total_cash_water_score' => Db::raw('total_cash_water_score + ' . $data['cashBetAmount']),
                            'total_bonus_water_score' => Db::raw('total_bonus_water_score + ' . $data['bonusBetAmount']),
                        ]);
                        continue;
                    }
                    $res = Db::name('user_water')->insert([
                            'uid' => $tv['puid'],
                            'total_cash_water_score' => $data['cashBetAmount'],
                            'total_bonus_water_score' => $data['bonusBetAmount'],
                        ]);
                }
            }
        }

        return $res;
    }

    /**
     * Cash转换为Bonus
     * @param $uid  用户UID
     * @param $bonus  用户bonus
     * @return void
     */
    private static function convertBonusToCash($uid,$bonus){
        $res = User::userEditBonus($uid,bcsub(0,$bonus,0),10,'用户-UID:'.$uid.'Bonus转换为Cash扣除Bonus'.bcdiv($bonus,100,2),3);
        if(!$res){
            Log::error('用户-UID:'.$uid.'Bonus转换为Cash扣除Bonus'.bcdiv($bonus,100,2).'失败');
            return 0;
        }
        $res = User::userEditCoin($uid,$bonus,10,'用户-UID:'.$uid.'Bonus转换为Cash增加Cash'.bcdiv($bonus,100,2));
        if(!$res){
            Log::error('用户-UID:'.$uid.'Bonus转换为Cash增加Cash'.bcdiv($bonus,100,2).'失败');
            return 0;
        }
        return 1;
    }
}
