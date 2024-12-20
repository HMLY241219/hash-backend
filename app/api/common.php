<?php

use pay\Balance;
use think\facade\Db;
use think\facade\Log;

function getRepetitionValue($arr, $key)
{
    $arr = array_count_values(array_column($arr, $key));
    return array_filter($arr, function ($value) {
        if ($value > 1) {
            return $value;
        }
    });
}


/**
 *用户token生成
 * @param  $uid 用户UID
 * @return void
 */
function setToken($uid)
{
    return md5($uid.time());
}

/**
 * 获取各个支付渠道实时信息
 * @param $min
 * @return string
 * @throws \think\db\exception\DataNotFoundException
 * @throws \think\db\exception\DbException
 * @throws \think\db\exception\ModelNotFoundException
 */
function getPayData($min=5){
    $pay_type = ['rr_pay','x_pay','ser_pay','tm_pay','joy_pay','z_pay','waka_pay','ab_pay','fun_pay','go_pay','eanishop_pay','hr24_pay','lets_pay','letstwo_pay','dragon_pay','ant_pay','ff_pay','cow_pay','newfun_pay','lq_pay','wdd_pay','timi_pay','threeq_pay','show_pay','tata_pay','pay_pay','g_pay','tmtwo_pay','yh_pay','allin1_pay','make_pay','best_pay','zip_pay','upi_pay','q_pay','allin1two_pay','vendoo_pay','unive_pay','no_pay','ms_pay','decent_pay','fly_pay','kk_pay','tk_pay','kktwo_pay','newai_pay','rupeelink_pay','sertwo_pay','global_pay','a777_pay','one_pay'];//'win_pay','well_pay','qart_pay',eanishop_pay
    $pay_type = Db::name('pay_type')->whereIn('name',$pay_type)->where('status',1)->column('name');
    $text = "/*最近$min min支付订单统计*/\r\n";
    foreach ($pay_type as $value) {
        $order = Db::name('order')->whereTime('createtime', "-$min minutes")->where('paytype',$value)->select()->toArray();
        $pay_name = $value;
        if ($value == 'rr_pay'){
            $pay_name = 'al_pay';
        }
        $pay_all_num = 0;//总订单数
        $pay_suc_num = 0;//成功订单数
        $pay_all_money = 0;//总订单金额
        $pay_suc_money = 0;//成功订单金额
        $pay_suc_time = 0;//成功总到账时长
        $pay_aver_time = 0;//成功平均到账时长
        $pay_overtime_num = 0;//超时订单数
        if (!empty($order)){
            foreach ($order as $ok=>$ov){
                $pay_all_num += 1;
                $pay_all_money += $ov['price']/100;
                if ($ov['pay_status'] == 1){
                    $pay_suc_num += 1;
                    $pay_suc_money += $ov['price']/100;
                    if ($ov['finishtime'] > 0) {
                        $over_time = $ov['finishtime'] - $ov['createtime'];
                        $pay_suc_time += $over_time;
                        if ($over_time > 100){
                            $pay_overtime_num += 1;
                        }
                    }
                }
            }
        }
        $pay_suc_rate_num = $pay_all_num>0 ? round(bcdiv($pay_suc_num,$pay_all_num,4)*100,2) : 0;//订单成功率
        $pay_suc_rate_money = $pay_all_money>0 ? round(bcdiv($pay_suc_money,$pay_all_money,4)*100,2) : 0;//金额成功率
        $pay_aver_time = $pay_suc_num>0 ? round(bcdiv($pay_suc_time,$pay_suc_num,4),2) : 0;//平均到账时间
        $pay_overtime_rate = $pay_suc_num>0 ? round(bcdiv($pay_overtime_num,$pay_suc_num,4)*100,2) : 0;//超时率

        try {
            if ($value != 'eanishop_pay') { //$value != 'z_pay' && $value != 'waka_pay' &&
                $balance = Balance::pay($value);
            }
        }catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error('getPayData fail==>'.$exception->getMessage());
        }

        $balance = isset($balance['balance']) ? $balance['balance'] : '';

        $text .= "$pay_name
成功率：".$pay_suc_rate_num."%（".$pay_suc_num.'/'.$pay_all_num.'）
金额：'.$pay_suc_rate_money.'%（'.$pay_suc_money.'/'.$pay_all_money.'）
平均到账时长：'.$pay_aver_time.'秒
订单超时率：'.$pay_overtime_rate."%（".$pay_overtime_num."/".$pay_suc_num.'）
商户余额：'.$balance."
\r\n";
    }
    return $text;
}

function getWithData($min=5){
    $pay_type = ['rr_pay','x_pay','ser_pay','tm_pay','joy_pay','z_pay','waka_pay','ab_pay','fun_pay','go_pay','eanishop_pay','hr24_pay','lets_pay','letstwo_pay','dragon_pay','ant_pay','ff_pay','cow_pay','newfun_pay','lq_pay','wdd_pay','timi_pay','threeq_pay','show_pay','tata_pay','pay_pay','g_pay','tmtwo_pay','yh_pay','allin1_pay','make_pay','best_pay','zip_pay','upi_pay','q_pay','allin1two_pay','vendoo_pay','unive_pay','no_pay','ms_pay','decent_pay','fly_pay','kk_pay','tk_pay','kktwo_pay','newai_pay','rupeelink_pay','sertwo_pay','global_pay','a777_pay','one_pay'];//'win_pay','well_pay','qart_pay',eanishop_pay
    $pay_type = Db::name('withdraw_type')->whereIn('name',$pay_type)->where('status',1)->column('name');
    $text = "/*最近$min min退款订单统计*/\r\n";
    foreach ($pay_type as $value) {
        $order = Db::name('withdraw_log')->whereTime('createtime', "-$min minutes")->where('withdraw_type',$value)->select()->toArray();
        $pay_name = $value;
        if ($value == 'rr_pay'){
            $pay_name = 'al_pay';
        }
        $pay_all_num = 0;//总订单数
        $pay_suc_num = 0;//成功订单数
        $pay_all_money = 0;//总订单金额
        $pay_suc_money = 0;//成功订单金额
        $pay_suc_time = 0;//成功总到账时长
        $pay_aver_time = 0;//成功平均到账时长
        $pay_overtime_num = 0;//超时订单数
        if (!empty($order)){
            foreach ($order as $ok=>$ov){

                if ($ov['status'] == 1){//成功
                    $pay_all_num += 1;
                    $pay_all_money += $ov['money']/100;

                    $pay_suc_num += 1;
                    $pay_suc_money += $ov['money']/100;
                    if ($ov['finishtime'] > 0) {
                        $over_time = $ov['finishtime'] - $ov['createtime'];
                        $pay_suc_time += $over_time;
                        if ($over_time > 100){
                            $pay_overtime_num += 1;
                        }
                    }

                }elseif ($ov['status'] == 2){//失败
                    $pay_all_num += 1;
                    $pay_all_money += $ov['money']/100;
                }
            }
        }
        $pay_suc_rate_num = $pay_all_num>0 ? round(bcdiv($pay_suc_num,$pay_all_num,4)*100,2) : 0;//订单成功率
        $pay_suc_rate_money = $pay_all_money>0 ? round(bcdiv($pay_suc_money,$pay_all_money,4)*100,2) : 0;//金额成功率
        $pay_aver_time = $pay_suc_num>0 ? round(bcdiv($pay_suc_time,$pay_suc_num,4),2) : 0;//平均到账时间
        $pay_overtime_rate = $pay_suc_num>0 ? round(bcdiv($pay_overtime_num,$pay_suc_num,4)*100,2) : 0;//超时率

        if ($value != 'eanishop_pay') { //$value != 'z_pay' && $value != 'waka_pay' &&
            $balance = Balance::pay($value);
        }
        $balance = isset($balance['balance']) ? $balance['balance'] : '';

        $text .= "$pay_name
成功率：".$pay_suc_rate_num."%（".$pay_suc_num.'/'.$pay_all_num.'）
金额：'.$pay_suc_rate_money.'%（'.$pay_suc_money.'/'.$pay_all_money.'）
平均到账时长：'.$pay_aver_time.'秒
订单超时率：'.$pay_overtime_rate."%（".$pay_overtime_num."/".$pay_suc_num.'）
商户余额：'.$balance."
\r\n";
    }
    return $text;
}
