<?php

namespace app\api\controller\active;


use app\api\controller\SqlModel;
use think\facade\Db;
use think\facade\Log;
use crmeb\basic\BaseController;
use app\api\controller\ReturnJson;


/**
 * 红包雨
 */
class RedEnvelopes extends BaseController
{



    /**
     * 获取用户红包雨参与状态
     * @return null
     */
    public function redEnvelopesStatus(){
        $uid = input('uid');
        $date = date('His');
        $userinfo = Db::name('userinfo')->field('total_pay_score')->where('uid',$uid)->find();
        if(!$userinfo || $userinfo['total_pay_score'] <= 0){
            //不能参与的话返回下次参与时间
            $date = $this->getMinRedEnvelopesTime($date);
            return ReturnJson::successFul(200,['status' => 0,'date' => $date],2);
        }
        $red_envelopes_time_id = $this->getLeftEnvelopsStatus($date);
        if($red_envelopes_time_id){
            $red_envelopes_log = Db::name('red_envelopes_log')  //判断今日该活动是否已经参与了
                ->field('id')
                ->where([
                    ['uid','=',$uid],
                    ['red_envelopes_time_id','=',$red_envelopes_time_id],
                    ['createtime','>=',strtotime("00:00:00")]
                ])
                ->find();
            if(!$red_envelopes_log)return ReturnJson::successFul(200,['status' => 1]); //表示能参与
        }
        //不能参与的话返回下次参与时间
        $date = $this->getMinRedEnvelopesTime($date);
        return ReturnJson::successFul(200,['status' => 0,'date' => $date]);
    }


    /**
     * 领取红包雨
     * @return void
     */
    public function receiveRedEnvelopes(){
        $uid = input('uid');
        $date = date('His');
        $userinfo = Db::name('userinfo')->field('total_pay_score,channel,package_id')->where('uid',$uid)->find();
        if(!$userinfo || $userinfo['total_pay_score'] <= 0)return ReturnJson::successFul(250);//抱歉!充值用户才能参与该活动

        //判断是否改时间能有理论上的活动可以参与
        $red_envelopes_time_id = $this->getLeftEnvelopsStatus($date);
        if(!$red_envelopes_time_id)return ReturnJson::failFul(252); //抱歉!本次活动您已参与!请不要重复参与哦!

        //判断用户今天是否已经参与了该活动
        $red_envelopes_log = Db::name('red_envelopes_log')  //判断今日该活动是否已经参与了
            ->field('id')
            ->where([
                ['uid','=',$uid],
                ['red_envelopes_time_id','=',$red_envelopes_time_id],
                ['createtime','>=',strtotime("00:00:00")]
            ])
            ->find();
        if($red_envelopes_log)return ReturnJson::failFul(251); //抱歉!本次活动您已参与!请不要重复参与哦!

        //获取本次翻的ID和金额和剩余数量
        [$red_envelopes_id,$money,$num] = $this->getEnvelopesMoney();

        Db::startTrans();

        if($num > 0){
            $res = Db::name('red_envelopes')->where('id',$red_envelopes_id)->update(['num' => Db::raw('num - 1')]);
            if(!$res){
                Db::rollback();
                return ReturnJson::failFul(249); //奖励领取失败
            }
        }

        $res = Db::name('red_envelopes_log')->insert([
            'red_envelopes_time_id' => $red_envelopes_time_id,
            'uid' => $uid,
            'money' => $money,
            'createtime' => time(),
        ]);
        if(!$res){
            Db::rollback();
            Log::error('UID:'.$uid.'反水记录red_envelopes_log存储失败');
            return ReturnJson::failFul(249); //奖励领取失败
        }

        if($money > 0){
            $res = \app\common\xsex\User::userEditCoin($uid,$money,8,'用户:'.$uid.'钱包雨获取'.bcdiv($money,100,2),2);
            if(!$res){
                Db::rollback();
                Log::error('UID:'.$uid.'反水活动用户余额修改失败!');
                return ReturnJson::failFul(249); //奖励领取失败
            }

            $res = \app\common\xsex\User::editUserTotalGiveScore($uid,$money);
            if(!$res){
                Db::rollback();
                return ReturnJson::failFul(249);
            }
        }
        Db::commit();
        return ReturnJson::successFul(200,$money);
    }




    /**
     *
     * 获取下次最近的签到时间
     * @return void
     * @param  $date 本次的His格式时间
     */
    private function getMinRedEnvelopesTime($date){
        $date = date('His');
        //下次的开始时间要大于本次
        $red_envelopes_time = Db::name('red_envelopes_time')
            ->field('day,type,startdate')
            ->where([['startdate','>',$date],['status','=',1]])
            ->order('startdate','asc')
            ->select()
            ->toArray();
        if(!$red_envelopes_time)$red_envelopes_time = Db::name('red_envelopes_time') //如果今日领完了，就从明天开始
            ->field('day,type,startdate')
            ->where([['status','=',1]])
            ->order('startdate','asc')
            ->select()
            ->toArray();
        //type 类型:1=每天,2=每周,3=每月
        $date = 0;
        foreach ($red_envelopes_time as $v){
            if($v['type'] == 1){
                $date = $v['startdate'];
                break;
            }elseif ($v['type'] == 2){
                $statusArray = explode('、',$v['day']); //判断今天是否在这里面
                $day = date('w'); //获取今日是周几
                $day = $day == 0 ? 7 : $day; //0代表周日
                if(in_array($day,$statusArray)){
                    $date = $v['startdate'];
                    break;
                }
            }else{
                $statusArray = explode('、',$v['day']); //判断今天是否在这里面
                $day = date('d'); //获取今天是哪一天
                $day = substr($day,0,1) == '0' ? substr($day,1,1) : $day;//这里1-9返回会多个0，这里需要删除
                if(in_array($day,$statusArray)){
                    $date = $v['startdate'];
                    break;
                }
            }
        }
        if($date)return substr($date,0,2).':'.substr($date,2,2);
        return $date;
    }

    /**
     * 获取本次理论上是否有红包雨活动能参与
     * @return int
     * @param  $date 本次的His格式时间
     */
    private function getLeftEnvelopsStatus($date){

        $red_envelopes_time = Db::name('red_envelopes_time')
            ->field('id,type,day')
            ->where([['startdate','<=',$date],['enddate','>=',$date],['status','=',1]])
            ->order('type','asc')
            ->column('day,id','type');
        if(!$red_envelopes_time)return 0;
        //type 类型:1=每天,2=每周,3=每月 .
        if(isset($red_envelopes_time[1]))return $red_envelopes_time[1]['id'] ?? 0; //如果存在是每天的直接返回

        foreach ($red_envelopes_time as $key => $value){
            $statusArray = explode('、',$value['day']); //判断今天是否在这里面
            if($key == 2){  //每周
                $day = date('w'); //获取今日是周几
                $day = $day == 0 ? 7 : $day; //0代表周日
            }else{ //每月
                $day = date('d'); //获取今天是哪一天
                $day = substr($day,0,1) == '0' ? substr($day,1,1) : $day; //这里1-9返回会多个0，这里需要删除
            }
            if(in_array($day,$statusArray))return $value['id']; //直接返回ID
        }
        return 0;
    }

    /**
     * 获取本次红包雨的金额
     * @return array
     */
    private function getEnvelopesMoney(){
        $random = mt_rand() / mt_getrandmax(); // 获取本次的概率
        $red_envelopes = Db::name('red_envelopes')
            ->field('money,probability,id,num')
            ->where('num','-99')
            ->whereOr('num','>',0)
            ->order('probability','asc')
            ->select()
            ->toArray();
        if(!$red_envelopes)return [0,0,0];
        foreach ($red_envelopes as $v){
            if($random <= $v['probability'])return [$v['id'],$v['money'],$v['num']];
        }
        return [0,0,0];
    }

}
