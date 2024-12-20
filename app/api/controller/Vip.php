<?php
namespace app\api\controller;

use think\facade\Config;
use think\facade\Db;
use think\facade\Log;
use crmeb\basic\BaseController;
use app\api\controller\ReturnJson;

class Vip extends BaseController {


    private $receiveHours = '06:00:00'; //每周领取第一天的反水的时间

    private $receiveDayNum = 5; //每周领取反水的有效天数

    /**
     * 获取VIP配置
     * @return null
     *
     */
    public function config(){
        $vip = Db::name('vip')->order('vip','desc')->select()->toArray();
        return ReturnJson::successFul(200,$vip);
    }


    /**
     * 获取用户返水首页
     * @return void
     */
    public function getUserBetrayalIndex(){
        $uid = input('uid');
        $userinfo = Db::name('userinfo')->field('vip,(total_cash_water_score + total_bonus_water_score) as total_water_score')->where('uid',$uid)->find(); //总Cash流水

        if($userinfo){
            $data = [
                'total_water_score' => $userinfo['total_water_score'] ?: 0,
                'vip' => $userinfo['vip'] ?: 0,
            ];
        }else{
            $data = [
                'total_water_score' => 0,
                'vip' => 0,
            ];
        }


        [$week_start,$week_end] = \dateTime\dateTime::startEndWeekTime(time());
        $data['settlement_start_date'] = date('Y-m-d H:i:s',$week_start); //本周结算的开始时间
        $data['settlement_end_date'] = date('Y-m-d H:i:s',$week_end); //本周结算的结束时间
        $data['receive_start_date'] = date('Y-m-d',$week_end + 1).' '.$this->receiveHours; //领取的开始时间
        $data['receive_end_date'] = date('Y-m-d H:i:s',($week_end + ($this->receiveDayNum * 86400)));//领取的结束时间

        [,$last_week_end] = \dateTime\dateTime::startEndWeekTime(strtotime(' -7 day'));
        $last_receive_start_date = strtotime( date('Y-m-d',$last_week_end + 1).' '.$this->receiveHours);//上周领取的开始时间
        $last_receive_end_date = ($last_week_end + ($this->receiveDayNum * 86400));//上周领取的结束时间

        //判断是否到领取的时间
        if(time() > $last_receive_end_date || time() < $last_receive_start_date){
            Db::name('betrayal_log')->where('uid',$uid)->update(['status' => 2]);
            $data['amount'] = -1;//-1代表问号
        }else{ //这里由于上周的数据是本周结算的，所有创建时间用本周的
            $amount = Db::name('betrayal_log')->where([['uid','=',$uid],['createtime','>=',$week_start],['createtime','<=',$week_end]])->value('amount');
            $data['amount'] = $amount ? (int)$amount : -1;
        }

        return ReturnJson::successFul(200,$data);

    }

    /**
     * 领取返水奖励
     * @return void
     */
    public function getRebatesAmount(){
        $uid = input('uid');
        [,$last_week_end] = \dateTime\dateTime::startEndWeekTime(strtotime(' -7 day'));
        $last_receive_start_date = strtotime( date('Y-m-d',$last_week_end + 1).' '.$this->receiveHours);//上周领取的开始时间
        $last_receive_end_date = ($last_week_end + ($this->receiveDayNum * 86400));//上周领取的结束时间
        //判断是否到领取的时间
        if(time() > $last_receive_end_date || time() < $last_receive_start_date) return ReturnJson::failFul(247);
        [$week_start,$week_end] = \dateTime\dateTime::startEndWeekTime(time());
        $betrayal_log = Db::name('betrayal_log')->field('amount,id')->where([['status','=',0],['uid','=',$uid],['createtime','>=',$week_start],['createtime','<=',$week_end]])->find();
        if(!$betrayal_log || $betrayal_log['amount'] <= 0) return ReturnJson::failFul(248);

        Db::startTrans();
        $res = Db::name('betrayal_log')->where('id',$betrayal_log['id'])->update(['status' => 1]);
        if(!$res){
            Db::rollback();
            return ReturnJson::failFul(249);
        }
        $res = \app\common\xsex\User::userEditCoin($uid,$betrayal_log['amount'],6,'用户:'.$uid.'返水奖励:'.bcdiv($betrayal_log['amount'],100,2),2);
        if(!$res){
            Db::rollback();
            return ReturnJson::failFul(249);
        }


        $res = \app\common\xsex\User::editUserTotalGiveScore($uid,$betrayal_log['amount']);
        if(!$res){
            Db::rollback();
            return ReturnJson::failFul(249);
        }
        Db::commit();

        return ReturnJson::failFul(200);
    }
}





