<?php
namespace app\common\xsex;


use app\api\controller\SqlModel;
use think\facade\Db;
use think\facade\Log;

class User
{

    /**
     * 用户Coin变化
     * @param $uid
     * @param $num  变化金额 ： 加钱就是正数，减少就是负数
     * @param $reason  变化原因
     * @param $content  内容
     * @param $type  1 = 只改钱 ， 2 =修改需求流水
     * @return void
     */
    public static function userEditCoin($uid,$num,$reason,$content = '',$type = 1){
        if(!$num)return 1;

        $userinfo = Db::name('userinfo')->field('coin,package_id,channel')->where('uid',$uid)->find();
        if(!$userinfo)return 1;

        Db::startTrans();

        if($type == 2){
            $res = Db::name('userinfo')->where('uid',$uid)->update([
                'coin' => Db::raw('coin + '.$num),
                'need_cash_score_water' => Db::raw('need_cash_score_water + '.bcmul($num,config('my.cash_water_multiple'),0)),
            ]);
        }else{
            $res = Db::name('userinfo')->where('uid',$uid)->update(['coin' => Db::raw('coin + '.$num)]);
        }

        if(!$res){
            Db::rollback();
            return 0;
        }
        $res = Db::name('coin_'.date('Ymd'))
            ->insert([
                'uid' => $uid,
                'num' => $num,
                'total' => bcadd($userinfo['coin'],$num,0),
                'reason' => $reason,
                'type' => $num > 0 ? 1 : 0,
                'content' => $content,
                'channel' => $userinfo['channel'],
                'package_id' => $userinfo['package_id'],
                'createtime' => time(),
            ]);
        if(!$res){
            Db::rollback();
            return 0;
        }
        Db::commit();
        return 1;
    }



    /**
     * 用户Bonus变化
     * @param $uid
     * @param $num  变化金额 ： 加钱就是正数，减少就是负数
     * @param $reason  变化原因
     * @param $content  内容
     * @param $type  1 = 只改钱 ， 2 =修改需求流水 , 3 = 转换用户全部bonus，将需求和有效流水清0
     * @return void
     */
    public static function userEditBonus($uid,$num,$reason,$content = '',$type = 1){
        if(!$num)return 1;
        $userinfo = Db::name('userinfo')->field('bonus,get_bonus,package_id,channel')->where('uid',$uid)->find();
        if(!$userinfo)return 1;
        Db::startTrans();
        if($type == 2){
            $res = Db::name('userinfo')->where('uid',$uid)->update([
                'bonus' => Db::raw('bonus + '.$num),
                'get_bonus' => $num > 0 ? Db::raw('get_bonus + '.$num) : $userinfo['get_bonus'],
                'need_bonus_score_water' => Db::raw('need_bonus_score_water + '.bcmul($num,config('my.bonus_water_multiple'),0)),
                'need_water_bonus' => Db::raw('need_water_bonus + '.$num),
            ]);
        }elseif($type == 3){
            $res = Db::name('userinfo')->where('uid',$uid)->update([
                'bonus' => 0,
                'need_bonus_score_water' => 0,
                'need_water_bonus' => 0,
                'now_bonus_score_water' => 0,
            ]);
        }else{
            $res = Db::name('userinfo')->where('uid',$uid)->update(['bonus' => Db::raw('bonus + '.$num),'get_bonus' => $num > 0 ? Db::raw('get_bonus + '.$num) : $userinfo['get_bonus']]);
        }

        if(!$res){
            Db::rollback();
            return 0;
        }
        $res = Db::name('bonus_'.date('Ymd'))
            ->insert([
                'uid' => $uid,
                'num' => $num,
                'total' => bcadd($userinfo['bonus'],$num,0),
                'reason' => $reason,
                'type' => $num > 0 ? 1 : 0,
                'content' => $content,
                'channel' => $userinfo['channel'],
                'package_id' => $userinfo['package_id'],
                'createtime' => time(),
            ]);
        if(!$res){
            Db::rollback();
            return 0;
        }
        Db::commit();
        return 1;
    }

    /**
     * @return void
     * @param  $uid 用户UID
     * @param  $total_give_score 赠送金额
     */
    public static function editUserTotalGiveScore($uid,$total_give_score){
        Db::startTrans();
        $res = Db::name('userinfo')->where('uid',$uid)->update(['total_give_score' => Db::raw('total_give_score+'.$total_give_score)]);
        if(!$res){
            Db::rollback();
            Log::error('UID:'.$uid.'用户总赠送修改失败!');
            return 0;
        }

        $user_day = [
            'uid' => $uid.'|up',
            'total_give_score' =>  $total_give_score.'|raw-+',
        ];
        $user_day = new SqlModel($user_day);
        $res = $user_day->userDayDealWith();
        if(!$res){
            Db::rollback();
            Log::error('UID:'.$uid.'用户每天赠送统计失败!');
            return 0;
        }
        Db::commit();
        return 1 ;
    }
}



