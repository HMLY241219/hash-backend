<?php
namespace app\api\controller;

use app\admin\controller\Common;
use app\api\controller\ReturnJson;
use app\Request;
use think\facade\Config;
use think\facade\Db;
use think\facade\Log;
use crmeb\basic\BaseController;
use curl\Curl;
use think\facade\Validate;

class OrderWithdraw extends BaseController {

    /**
     * 各支付渠道数据统计
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function payChannel()
    {
        $s_time = strtotime('00:00:00') - 86400;
        $e_time = strtotime('23:59:59') - 86400;

        $pay_arr = ['tm_pay','eanishop_pay','ser_pay','go_pay','show_pay','pay_pay','ant_pay','cow_pay'];
        $pay_type = Db::name('pay_type')
            //->whereIn('name',$pay_arr)
            ->order('weight','desc')
            ->order('id','desc')
            ->field('name,englishname,fee_bili,createtime')
            ->select()->toArray();

        $data = [];
        if (!empty($pay_type)) {
            foreach ($pay_type as $k => $v) {
                $data[$v['name']] = [
                    'createtime' => $v['createtime']>0 ? $v['createtime'] : 0,
                    'currency' => 'INR',
                    'name' => $v['name'],
                    'englishname' => $v['englishname'],
                    'fee_bili' => $v['fee_bili'],
                    'recharge_count' => 0,
                    'recharge_count_yes' => 0,
                    'recharge_suc_count' => 0,
                    'recharge_suc_count_yes' => 0,
                    'recharge_money' => 0,
                    'recharge_money_yes' => 0,
                    'all_time' => 0,
                    'yes_time' => 0,
                ];

                Db::name('order')
                    ->where('paytype', $v['name'])
                    ->chunk(1000, function ($orders) use (&$data, $v, $s_time, $e_time) {
                        foreach ($orders as $order) {
                            //if ($v['name'] == 'ser_pay') dd($data);
                            //
                            $data[$v['name']]['recharge_count'] += 1;
                            if ($order['createtime'] >= $s_time && $order['createtime'] <= $e_time) {
                                $data[$v['name']]['recharge_count_yes'] += 1;
                            }
                            if ($order['pay_status'] == 1) {
                                $data[$v['name']]['recharge_money'] += $order['price'];
                                $data[$v['name']]['all_time'] += ($order['finishtime'] - $order['createtime']);
                                $data[$v['name']]['recharge_suc_count'] += 1;
                                if ($order['finishtime'] >= $s_time && $order['finishtime'] <= $e_time) {
                                    $data[$v['name']]['recharge_suc_count_yes'] += 1;
                                    $data[$v['name']]['recharge_money_yes'] += $order['price'];
                                    $data[$v['name']]['yes_time'] += ($order['finishtime'] - $order['createtime']);
                                }
                            }
                        }
                    });

            }


        }

        try {
            Db::startTrans();
            if (!empty($data)){
                Db::name('paytype_st')->where(1)->delete();

                $res = Db::name('paytype_st')->insertAll($data);
                if (!$res){
                    Db::rollback();
                    Log::error('支付统计 fail==>插入失败');
                    return json(['code' => 200,'msg'=>'统计失败','data' => []]);
                }
            }

            Db::commit();
            return json(['code' => 200,'msg'=>'支付统计完成','data' => []]);

        }catch (\Exception $exception){
            Db::rollback();
            echo $exception->getMessage();
            Log::error('dayTopBet fail==>'.$exception->getMessage());
            return json(['code' => 201,'msg'=>'支付统计失败','data' => []]);
        }
    }

    /**
     * 每日订单渠道统计
     * @return void
     */
    public function dayPayChannel()
    {
        $date = date('Y-m-d', strtotime("-1 day"));
        $date_s = strtotime($date);
        $date_e = strtotime($date) + 86400;
        $data = [];
        Db::name('order')
            ->whereDay('createtime',$date)
            ->chunk(1000, function ($orders) use (&$data, $date_s) {
                foreach ($orders as $order) {
                    if (isset($data[$order['paytype']])){
                        $data[$order['paytype']]['recharge_count'] += 1;
                        if ($order['pay_status'] == 1) {
                            $data[$order['paytype']]['recharge_suc_count'] += 1;
                            $data[$order['paytype']]['recharge_money'] += $order['price'];
                        }

                    }else{
                        $data[$order['paytype']]['time'] = $date_s;
                        $data[$order['paytype']]['paytype'] = $order['paytype'];
                        $data[$order['paytype']]['recharge_count'] = 0;
                        $data[$order['paytype']]['recharge_suc_count'] = 0;
                        $data[$order['paytype']]['recharge_money'] = 0;
                        $data[$order['paytype']]['with_count'] = 0;
                        $data[$order['paytype']]['with_suc_count'] = 0;
                        $data[$order['paytype']]['with_fail_count'] = 0;
                        $data[$order['paytype']]['with_money'] = 0;
                    }

                }
            });

        //$w_where = [['finishtime','>=', $date_s], ['finishtime','<',$date_e], ['status','<>',-1]];
        /*Db::name('withdraw_log')
            ->whereDay('createtime',$date)
            ->whereOr('finishtime','between time',[$date_s,$date_e])
            //->whereOr(function($query) use ($w_where){$query->where($w_where);})
            ->chunk(1000, function ($withs) use (&$data, $date_s) {
                //dd($withs);
                foreach ($withs as $with) {
                    if (isset($data[$with['withdraw_type']])){
                        $data[$with['withdraw_type']]['with_count'] += 1;
                        if ($with['status'] == 1) {
                            $data[$with['withdraw_type']]['with_suc_count'] += 1;
                            $data[$with['withdraw_type']]['with_money'] += $with['money'];
                        }
                        if ($with['status'] == 2) {
                            $data[$with['withdraw_type']]['with_fail_count'] += 1;
                        }

                    }else{

                        $data[$with['withdraw_type']]['time'] = $date_s;
                        $data[$with['withdraw_type']]['paytype'] = $with['withdraw_type'];
                        $data[$with['withdraw_type']]['recharge_count'] = 0;
                        $data[$with['withdraw_type']]['recharge_suc_count'] = 0;
                        $data[$with['withdraw_type']]['recharge_money'] = 0;
                        $data[$with['withdraw_type']]['with_count'] = 0;
                        $data[$with['withdraw_type']]['with_suc_count'] = 0;
                        $data[$with['withdraw_type']]['with_fail_count'] = 0;
                        $data[$with['withdraw_type']]['with_money'] = 0;
                    }

                }
            });*/
        $withs = Db::name('withdraw_log')
            ->whereDay('createtime',$date)
            ->whereOr('finishtime','between time',[$date_s,$date_e])
            ->select()->toArray();
        foreach ($withs as $with) {
            if (isset($data[$with['withdraw_type']])){
                $data[$with['withdraw_type']]['with_count'] += 1;
                if ($with['finishtime'] >= $date_s && $with['finishtime'] < $date_e) {
                    if ($with['status'] == 1) {
                        $data[$with['withdraw_type']]['with_suc_count'] += 1;
                        $data[$with['withdraw_type']]['with_money'] += $with['money'];
                    }
                    if ($with['status'] == 2) {
                        $data[$with['withdraw_type']]['with_fail_count'] += 1;
                    }
                }

            }else{

                $data[$with['withdraw_type']]['time'] = $date_s;
                $data[$with['withdraw_type']]['paytype'] = $with['withdraw_type'];
                $data[$with['withdraw_type']]['recharge_count'] = 0;
                $data[$with['withdraw_type']]['recharge_suc_count'] = 0;
                $data[$with['withdraw_type']]['recharge_money'] = 0;
                $data[$with['withdraw_type']]['with_count'] = 0;
                $data[$with['withdraw_type']]['with_suc_count'] = 0;
                $data[$with['withdraw_type']]['with_fail_count'] = 0;
                $data[$with['withdraw_type']]['with_money'] = 0;
            }

        }
//dd($data);
        try {
            Db::startTrans();
            if (!empty($data)){
                //Db::name('paytype_st')->where(1)->delete();

                $res = Db::name('paytype_day')->insertAll($data);
                if (!$res){
                    Db::rollback();
                    Log::error('支付统计 fail==>插入失败');
                    return json(['code' => 200,'msg'=>'统计失败','data' => []]);
                }
            }

            Db::commit();
            return json(['code' => 200,'msg'=>'支付统计完成','data' => []]);

        }catch (\Exception $exception){
            Db::rollback();
            echo $exception->getMessage();
            Log::error('dayPayChannel fail==>'.$exception->getMessage());
            return json(['code' => 201,'msg'=>'支付统计失败','data' => []]);
        }
    }


    public function withGet()
    {
        $list = Db::name('withdraw_log')
            ->where('createtime','>',strtotime(date('2024-08-14')))
            ->where("status",1)
            ->where("auditdesc",'<>',7)
            ->field("FROM_UNIXTIME(finishtime,'%m-%d') as day,IFNULL((floor(sum(money))/100),0) as price")
            ->group("FROM_UNIXTIME(finishtime, '%Y%m%d')")
            ->select()->toArray();
        dd($list);
    }

}



