<?php

namespace app\admin\controller\statistics;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use app\admin\common\Retention;
/**
 *  活动赠送cash 统计
 */
class Gamesendcash extends AuthController
{

    private $table = 'statistics_gamesendcash';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page =  $data['page'] ?? 1;
        $limit =  $data['limit'] ?? 2000;
        $date = isset($data['date']) && $data['date'] ? $data['date'] : date('Y-m-d',strtotime('00:00:00 -7 day')) .' - '. date('Y-m-d');
        $tatisticsType = $data['tatisticsType'] ?? 1; //1=按活动统计,2=按天统计
        [$starttime,$endtime] = explode(' - ',$date);
        $list1 = []; //今天的数据
        if(($starttime == date('Y-m-d') || strtotime($endtime) + 86399 > strtotime('00:00:00')) && $page == 1){ //说明是今天的数据
            $gameSendCash = \app\api\controller\My::gameSendCash(2,$this->sqlWhere(),strtotime('00:00:00'));
            if($gameSendCash){
                foreach ($gameSendCash as $v){
                    if(isset($list1[$v['title']])){
                        $list1[$v['title']]['money'] =  $v['money'] + $list1[$v['title']]['money'];
                        $list1[$v['title']]['bonus'] =  $v['bonus'] + $list1[$v['title']]['bonus'];
                        $list1[$v['title']]['price'] =  $v['price'] + $list1[$v['title']]['price'];
                        $list1[$v['title']]['num'] =  $v['num'] + $list1[$v['title']]['num'];
                    }else{
                        $list1[$v['title']] = [
                            'time' => date('Y-m-d',$v['time']),
                            'title' => $v['title'],
                            'money' => $v['money'],
                            'bonus' => $v['bonus'],
                            'price' => $v['price'],
                            'num' => $v['num'],
                        ];
                    }
                }
                $list1 =  array_values($list1);
            }
        }

        if($tatisticsType == 2 && $list1){
            $listNew = [];
            foreach ($list1 as $val){
                $listNew['time'] = $val['time'];
                $listNew['title'] = '全部';
                $listNew['money'] = isset($listNew['money']) ? $listNew['money'] + $val['money'] : $val['money'];
                $listNew['bonus'] = isset($listNew['bonus']) ? $listNew['bonus'] + $val['bonus'] : $val['bonus'];
                $listNew['price'] = isset($listNew['price']) ? $listNew['price'] + $val['price'] : $val['price'];
                $listNew['num'] = isset($listNew['num']) ? $listNew['num'] + $val['num'] : $val['num'];
            }

            $list1 = [];
            $list1[] = $listNew;
        }

//        $list2 = Db::name($this->table)
//            ->field("FROM_UNIXTIME(time,'%Y-%m-%d') as time,sum(num) as num,sum(money) as money,sum(price) as price,title,sum(bonus) as bonus")
//            ->where([['time','>=',strtotime($starttime)],['time','<',strtotime($endtime) + 86400]])
//            ->where($this->sqlWhere())
//            ->group('time,title')
//            ->order('id','desc')
//            ->select()
//            ->toArray();
        $query = Db::name($this->table)
            ->where([['time','>=',strtotime($starttime)],['time','<',strtotime($endtime) + 86400]])
            ->where($this->sqlWhere());
        if($tatisticsType == 1){
            $query->field("FROM_UNIXTIME(time,'%Y-%m-%d') as time,sum(num) as num,sum(money) as money,sum(price) as price,title,sum(bonus) as bonus")
                ->group('time,title');
        }else{
            $query->field("FROM_UNIXTIME(time,'%Y-%m-%d') as time,sum(num) as num,sum(money) as money,sum(price) as price,'全部' as title,sum(bonus) as bonus")
                ->group('time');
        }
        $list2 = $query
            ->order('id','desc')
            ->select()
            ->toArray();
        $list = array_merge($list1,$list2);


        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数

        $zs_money = 0;
        $zs_bonus = 0;
        $all_price = 0;
        foreach ($list as &$value){
            $zs_money += $value['money'];
            $zs_bonus += $value['bonus'];
            $all_price += $value['price'];
            $value['money'] = bcdiv((string)$value['money'],$amount_reduction_multiple,2);
            $value['bonus'] = bcdiv((string)$value['bonus'],$amount_reduction_multiple,2);
            $value['price'] = bcdiv((string)$value['price'],$amount_reduction_multiple,2);
        }
        $zs_money = bcdiv((string)$zs_money,$amount_reduction_multiple,2);
        $zs_bonus = bcdiv((string)$zs_bonus,$amount_reduction_multiple,2);
        $all_price = bcdiv((string)$all_price,$amount_reduction_multiple,2);

        return json(['code' => 0, 'count' => count($list2) + count($list1), 'data' => $list,'zs_money' => $zs_money,'zs_bonus' => $zs_bonus,'all_price' => $all_price]);
    }


    public function userinfoList($title,$time){
        $this->assign('title',$title);
        $this->assign('time',$time);
        return $this->fetch();
    }


    public function getUserinfoList($title,$time,$tatistics_type = 1){

        $starttime = $time ? strtotime($time) : strtotime('00:00:00');
        $endtime = $starttime + 86400;


        $order_config = ['普通充值赠送' => 0];
        $reson_config = config('reason.zs_reason_tj');
        $active_type = ['破产活动' => 3, '客损活动'=> 4 , '预流失活动' => 5, '客损活动2'=> 6];
        $shop_config = ['首充商城' => 10];

        if(isset($reson_config[$title])){
            $coinData = [];
            if(Db::query("SHOW TABLES LIKE 'br_coin_".date('Ymd',$starttime)."'")){
                $coinData = Db::name('coin_'.date('Ymd',$starttime))
                    ->field('uid,0 as money,sum(num) as zs_money,0 as zs_bonus,COUNT(*) as count')
                    ->where($this->sqlWhere())
                    ->where('reason','=',$reson_config[$title])
                    ->where('num','>',0)
                    ->where('channel','>',0)
                    ->group('uid')
                    ->select()
                    ->toArray();
            }
            $tpcData = Db::name('bonus_'.date('Ymd',$starttime))
                ->field("uid,0 as money,0 as zs_money,sum(num) as zs_bonus,COUNT(*) as count")
                ->where([['channel','>',0],['num','>',0],['reason','=',$reson_config[$title]]])
                ->where($this->sqlWhere())
                ->group('uid')
                ->select()
                ->toArray();

            $oldList = array_merge($coinData,$tpcData);
            if(!$oldList){
                return json(['code' => 0, 'count' => 0, 'data' => []]);
            }

            $list = [];
            $uids = [];
            foreach ($oldList as $v){
                if(!in_array($v['uid'],$uids)){
                    $list[$v['uid']] = $v;
                    $uids[] = $v['uid'];
                }else{
                    $list[$v['uid']]['zs_money'] = bcadd($v['zs_money'],$list[$v['uid']]['zs_money'],0);
                    $list[$v['uid']]['zs_bonus'] = bcadd($v['zs_bonus'],$list[$v['uid']]['zs_bonus'],0);
                }

            }
            return json(['code' => 0, 'count' => count($list), 'data' => $this->getUserinfoListArray($list)]);
        }elseif (isset($order_config[$title])){
            $list = Db::name('order')
                ->field('uid,sum(price) as money,sum(zs_money) as zs_money,sum(zs_bonus) as zs_bonus,COUNT(*) as count')
                ->where([['finishtime','>=',$starttime],['finishtime','<',$endtime],['pay_status','=',1],['active_id','=',$order_config[$title]]])
                ->whereRaw('(zs_bonus + zs_money) > 0')
                ->where($this->sqlWhere())
                ->group('uid')
                ->select()
                ->toArray();
            return json(['code' => 0, 'count' => count($list), 'data' => $this->getUserinfoListArray($list)]);
        }elseif (isset($active_type[$title])){
            $list = Db::name('order_active_log')
                ->field("uid,sum(money) as money,sum(zs_money) as zs_money,sum(zs_bonus) as zs_bonus,COUNT(*) as count")
                ->where([['createtime','>=',$starttime],['createtime','<',$endtime],['type','=',$active_type[$title]]])
                ->where($this->sqlWhere())
                ->group('uid')
                ->order('createtime','desc')
                ->select()
                ->toArray();
            $count =  Db::name('order_active_log')
                ->where([['createtime','>=',$starttime],['createtime','<',$endtime],['type','=',$active_type[$title]]])
                ->where($this->sqlWhere())
                ->group('uid')
                ->order('createtime','desc')
                ->count();
            return json(['code' => 0, 'count' => $count, 'data' => $this->getUserinfoListArray($list)]);
        }elseif (isset($shop_config[$title])){
            $list = Db::name('shop_log')
                ->field('uid,sum(money) as money,sum(zs_money) as zs_money,sum(zs_bonus) as zs_bonus,COUNT(*) as count')
                ->where([['createtime','>=',$starttime],['createtime','<',$endtime],['type','=',$shop_config[$title]]])
                ->whereRaw('(zs_bonus + zs_money) > 0')
                ->where($this->sqlWhere())
                ->group('uid')
                ->select()
                ->toArray();
            return json(['code' => 0, 'count' => count($list), 'data' => $this->getUserinfoListArray($list)]);
        }



        return json(['code' => 0, 'count' => 0, 'data' => []]);
    }



    private function getUserinfoListArray($list){
        $amount_reduction_multiple = config('my.amount_reduction_multiple');
        foreach ($list as $k => &$v){
            $v['zs_money'] = bcdiv((string)$v['zs_money'],$amount_reduction_multiple,2);
            $v['zs_bonus'] = bcdiv((string)$v['zs_bonus'],$amount_reduction_multiple,2);
            $v['money'] = bcdiv((string)$v['money'],$amount_reduction_multiple,2);
        }
        return $list;
    }
}



