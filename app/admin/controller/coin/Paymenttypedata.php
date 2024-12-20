<?php

namespace app\admin\controller\coin;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use app\admin\common\Retention;
/**
 *  支付渠道方式统计 统计
 */
class Paymenttypedata extends AuthController
{

    private $table = 'statistics_gamesendcash';

    public function index()
    {
        $pay_type = Db::name('pay_type')->field('id,englishname')->order('ht_weight','desc')->select()->toArray();
        $this->assign('pay_type',$pay_type);
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $pay_type_id = $data['pay_type_id'] ?? '';
        $where = [];
        $date = isset($data['date']) && $data['date'] ? $data['date'] : date('Y-m-d') .' - '. date('Y-m-d');
        [$starttime,$endtime] = explode(' - ',$date);
        $starttime = str_replace('-', '', $starttime);
        $endtime = str_replace('-', '', $endtime);
        if($pay_type_id)$where = [['pay_type_id','=',$pay_type_id]];
        $order_payment = Db::name('order_payment')
            ->field('sum(user_num) as user_num,sum(order_num) as order_num,sum(success_num) as success_num,sum(all_price) as all_price,pay_type_id,payment_type_id')
            ->where([['date','>=',$starttime],['date','<=',$endtime]])
            ->where($where)
            ->group('payment_type_id,pay_type_id')
            ->select()
            ->toArray();
        if(!$order_payment) return json(['code' => 0, 'count' => 0, 'data' => []]);

        $order_payment_data = $this->getData($order_payment);

        $pay_type = Db::name('pay_type')->field('id,englishname,payment_ids')->order('ht_weight','desc')->select()->toArray();
        $payment_type = Db::name('payment_type')->column('name','id');
        $list = [];
        foreach ($pay_type as $v){
            $payment_types = explode(',',$v['payment_ids']);
            foreach ($payment_types as $payment_type_id){
                $key = $payment_type_id.'-'.$v['id'];
                if(isset($order_payment_data[$key])){
                    $list[] = [
                        'payment_type_name' => $payment_type[$payment_type_id] ?? '',
                        'pay_type_name' => $v['englishname'],
                        'user_num' => $order_payment_data[$key]['user_num'],
                        'order_num' => $order_payment_data[$key]['order_num'],
                        'success_num' => $order_payment_data[$key]['success_num'],
                        'all_price' => $order_payment_data[$key]['all_price'],
                        'success_bili' => $order_payment_data[$key]['success_bili'],
                    ];
                }
            }
        }

        return json(['code' => 0, 'count' => count($list), 'data' => $list]);
    }


    private function getData($order_payment){
        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数
        $data = [];
        foreach ($order_payment as $v){
            $data[$v['payment_type_id'].'-'.$v['pay_type_id']] = [
                'user_num' => $v['user_num'],
                'order_num' => $v['order_num'],
                'success_num' => $v['success_num'],
                'all_price' => bcdiv((string)$v['all_price'],$amount_reduction_multiple,2),
                'success_bili' =>  $v['success_num'] > 0 ? bcmul(bcdiv((string)$v['success_num'],(string)$v['order_num'],4),'100',2).'%' : '0.00%',
            ];
        }
        return $data;
    }

}




