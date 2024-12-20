<?php

namespace app\api\controller;

use service\TelegramService;
use think\facade\Config;
use think\facade\Db;
use think\facade\Log;

class Statistics
{

    /**
     * 每日数据统计任务
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function dayDataStatistics(){
        set_time_limit(0);
        ini_set('memory_limit','1024M');
        $day = date('Ymd');
        $date = date('Y-m-d');
        // $day = '20241008';
        // $date = '2024-10-08';
        $date_s = strtotime($date);
        $date_e = strtotime($date) + 86400;
        $time = time();
        $day_time = strtotime(date('Y-m-d 00:00:00'));//印度今日凌晨12点时间戳
        if (($time >= $day_time && $time < $day_time+120) || ($time >= $day_time+7200 && $time < $day_time+9000)){
            $date = date('Y-m-d',strtotime('-1 day'));
            $day = date('Ymd',strtotime('-1 day'));
            $date_s = strtotime($date);
            $date_e = strtotime($date) + 86400;
            $day_time = $date_s;
        }

        //注册
        //$regist = Db::name("regist_$day")->column('uid');//今日注册人
        $regist_list = Db::name('share_strlog')->whereDay('createtime',$date)->field('package_id,channel,uid,device_id,isgold')->select()->toArray();
        $regist = array_column($regist_list, 'uid');//今日注册人
        $true_regist_num = 0;//今日真金玩家注册人数
        $device_num = [];//今日设备数（去重）
        $true_regist_users = [];//真金注册玩家
        if (!empty($regist_list)){
            foreach ($regist_list as $relk=>$relv){
                if ($relv['isgold'] == 0){
                    $device_num[$relv['device_id']] = true;
                    $true_regist_num += 1;
                    $true_regist_users[$relv['uid']] = true;
                }
            }
        }
        $true_regist_ids = implode(',',array_keys($true_regist_users));

        //游戏人数
        $true_game_num = 0;
        $game_user_list = [];
        /*$game_user_list = Db::name("user_day_$day")
            ->alias('ud')
            ->field('ud.uid,ud.total_game_num,ud.channel,ud.package_id')
            //->join('share_strlog ss','ud.uid=ss.uid')
            //->whereDay('ss.createtime',$date)
            ->select()->toArray();
        if (!empty($game_user_list)){
            foreach ($game_user_list as $gulk=>$gulv){
                if ($gulv['isgold'] == 0 && $gulv['total_game_num']>0){
                    $true_game_num += 1;
                }
            }
        }*/

        //充值
        $order = Db::name('order')->whereDay('createtime',$date)->field('id,uid,price,fee_money,pay_status,active_id,zs_money,channel,package_id,is_first,paytype')->select()->toArray();
        $order_num = [];//充值人去重后数组
        $order_suc_num = [];//充值成功人去重后数组
        $suc_order = [];//充值成功的订单
        $new_user_order = [];//新用户订单
        $old_user_order = [];//老用户订单
        $recharge_money = 0;//今日充值金额（指的是充值成功的订单金额统计）
        $fee_money = 0;//今日充值渠道成本
        $new_user_num = [];//充值的新用户
        $new_recharge_suc_num = [];//今日新用户充值成功人数
        $old_user_num = [];//充值的老用户
        $new_suc_order = [];//充值成功的新用户订单
        $old_suc_order = [];//充值成功的老用户订单
        $new_recharge_money = 0;
        $old_recharge_money = 0;
        $day_active_money = 0;//今日充值活动赠送的金额
        $first_order_num = [];//今日首充人数
        $first_order_money = 0;//今日首充金额
        $first_order_give_money = 0;//今日首充赠送金额
        $new_first_order_num = [];//新用戶今日首充人数
        $new_first_order_money = 0;//新用戶今日首充金额
        $new_first_order_give_money = 0;//新用戶今日首充赠送金额
        $repurchase_num = [];//今日复购用户
        $new_repurchase_num = [];//新用戶今日复购用户
        $old_recharge_suc_num = [];//老用户充值成功人

        $pay_type = ['rr_pay','ser_pay','tm_pay','fun_pay','go_pay','eanishop_pay','waka_pay'];
        $pay_type_arr = [];
        foreach ($pay_type as $ptk=>$ptv){
            $pay_type_arr[$ptk]['name'] = $ptv;
            $pay_type_arr[$ptk]['count'] = 0;
            $pay_type_arr[$ptk]['suc_count'] = 0;
        }
        if (!empty($order)){
            foreach ($order as $ok=>$ov){
                $order_num[$ov['uid']] = true;
                if ($ov['pay_status'] == 1){
                    $suc_order[] = $ov;
                    $order_suc_num[$ov['uid']] = true;
                    $recharge_money += $ov['price'];
                    $fee_money += $ov['fee_money'];
                    if ($ov['is_first'] == 1){
                        $first_order_num[$ov['uid']] = true;
                        $first_order_money += $ov['price'];
                        $first_order_give_money += $ov['zs_money'];
                        if (in_array($ov['uid'], $regist)){
                            $new_first_order_num[$ov['uid']] = true;
                            $new_first_order_money += $ov['price'];
                            $new_first_order_give_money += $ov['zs_money'];
                        }
                    }else{
                        //首充当日充值
                        $first_order_users = array_keys($first_order_num);
                        if (in_array($ov['uid'], $first_order_users)){
                            $first_order_money += $ov['price'];
                            $first_order_give_money += $ov['zs_money'];
                            if (in_array($ov['uid'], $regist)){
                                $new_first_order_money += $ov['price'];
                                $new_first_order_give_money += $ov['zs_money'];
                            }
                        }
                    }

                }
                if (in_array($ov['uid'], $regist)){//新用户
                    $new_user_order[] = $ov;
                }else{
                    $old_user_order[] = $ov;
                }
                if ($ov['active_id'] > 0 && $ov['pay_status'] == 1){
                    $day_active_money += $ov['zs_money'];
                }

                //各支付渠道
                foreach ($pay_type_arr as $ptak=>$ptav){
                    if ($ptav['name'] == $ov['paytype']){
                        $pay_type_arr[$ptak]['count'] += 1;
                        if ($ov['pay_status'] == 1){
                            $pay_type_arr[$ptak]['suc_count'] += 1;
                        }
                    }
                }
            }

            foreach ($new_user_order as $nk=>$nv){
                $new_user_num[$nv['uid']] = true;
                if ($nv['pay_status'] == 1){
                    $new_recharge_suc_num[$nv['uid']] = true;
                    $new_suc_order[] = $nv;
                    $new_recharge_money += $nv['price'];
                }
            }

            foreach ($old_user_order as $ouk=>$ouv){
                $old_user_num[$ouv['uid']] = true;
                if ($ouv['pay_status'] == 1){
                    $old_suc_order[] = $ouv;
                    $old_recharge_money += $ouv['price'];
                    $old_recharge_suc_num[$ouv['uid']] = true;
                }
            }
            //$all_user_arr = array_keys($order_num);
            //$suc_user_arr = array_keys($order_suc_num);
            $repurchase_num = getRepetitionValue($suc_order, 'uid');
            $repurchase_num_arr = array_keys($repurchase_num);
            if (!empty($repurchase_num_arr)){
                foreach ($repurchase_num_arr as $rnak=>$rnav){
                    if (in_array($rnav, $regist)){
                        $new_repurchase_num[$rnav] = true;
                    }
                }
            }
        }
        $new_recharge_suc_users = implode(',',array_keys($new_recharge_suc_num));
        $old_recharge_suc_users = implode(',',array_keys($old_recharge_suc_num));
        //历史老用户充值人数（去重）
        $history_old_recharge_num = Db::name('order')->whereNotIn('uid',$regist)->where('createtime','<',$day_time)->group('uid')->count();
        //历史老用户充值成功人数（去重）
        $history_old_recharge_suc_num = Db::name('order')->whereNotIn('uid',$regist)->where('createtime','<',$day_time)->where('pay_status',1)->group('uid')->count();

        //自研手续费 税收
        $total_service_score = 0;//自研游戏总税收
        $game_type_arr = [1002,1003,1502,1503,1504,1505,1506,1507,1508,2001,1509,1510,1511,1512,1513,1514];
        $game_day_zy = Db::name('daily_game_indicators')->where('date',$date)->whereIn('game_type', $game_type_arr)->field('IFNULL(SUM(service_score),0) AS service_score')->find();
        if (!empty($game_day_zy)){
            $total_service_score = $game_day_zy['service_score'];
        }

        //自研、三方游戏投注
        $user_day = Db::name("user_day_$day")->alias('ud')->field('ud.puid,ud.uid,ud.cash_total_score,ud.total_cash_water_score,ud.total_give_score,
        ud.channel,ud.package_id,ud.total_bonus_water_score,ud.bonus_total_score,
        u.regist_time,u.total_pay_score,u.coin')
            ->join('userinfo u','ud.uid=u.uid')
            ->select()->toArray();
        $self_water_num = 0;//自研游戏投注人数
        $new_self_game_num = 0;//新用户自研游戏投注人数
        $outside_water_num = 0;//三方游戏投注人数
        $new_three_game_num = 0;//新用户三方游戏投注人数
        $total_water_score = 0;//自研游戏总投注
        $new_self_game_betting_money = 0;//新用户自研游戏总投注
        $total_outside_water_score = 0;//三方游戏总投注
        $new_three_game_betting_money = 0;//新用户三方游戏总投注
        $total_rebate_score = 0;//自研游戏返奖金额
        $new_total_rebate_score = 0;//新用户自研游戏返奖金额
        $total_outside_rebate_score = 0;//三方游戏返奖金额
        $new_total_outside_rebate_score = 0;//新用户三方游戏返奖金额
        $rebate_score_rate = 0;//自研游戏返奖率
        $outside_rebate_score_rate = 0;//三方游戏返奖率
        $self_profit = 0;//自研游戏利润（今日自研游戏投注金额-今日自研游戏返奖金额+今日税收）
        $outside_profit = 0;//三方游戏利润（今日三方游戏投注金额-今日三方游戏返奖金额）
        $user_day_give = 0;//用户当日赠送金额
        $new_user_day_give = 0;//新用户当日赠送金额
        //$next_to_up_back_money =0;//今日下家返利给上家的金额
        $all_water_score = 0;//有上级的用户总流水
        $profit_game_num = 0;//游戏盈利人数
        $new_profit_game_num = 0;//新用户游戏盈利人数
        $not_pay_betting_money = 0;//未付费用户投注金额
        $new_not_pay_betting_money = 0;//未付费新用户投注金额
        $not_pay_rebate_score = 0;//未付费用户返奖金额
        $new_not_pay_rebate_score = 0;//未付费新用户返奖金额
        $not_pay_service_score = 0;//未付费游戏税收
        $new_not_pay_service_score = 0;//未付费新用户游戏税收
        $new_not_pay_give_coin = 0;//未付费新用户消耗（赠送-余额）

        if (!empty($user_day)){
            foreach ($user_day as $udk=>$udv){
                if ($udv['total_cash_water_score'] > 0 || $udv['total_bonus_water_score'] > 0){
                    $self_water_num += 1;
                    if ($udv['regist_time'] > $day_time){
                        $new_self_game_num += 1;
                    }
                }
                /*if ($udv['total_outside_water_score'] > 0){
                    $outside_water_num += 1;
                    if ($udv['regist_time'] > $day_time){
                        $new_three_game_num += 1;
                    }
                }*/
                $total_water_score += ($udv['total_cash_water_score'] + $udv['total_bonus_water_score']);
                //$total_outside_water_score += $udv['total_outside_water_score'];
                if ($udv['regist_time'] > $day_time){
                    //$new_self_game_betting_money += $udv['total_water_score'];
                    //$new_three_game_betting_money += $udv['total_outside_water_score'];
                    //$new_total_rebate_score += $udv['total_rebate_score'];
                    //$new_total_outside_rebate_score += $udv['total_outside_rebate_score'];
                    $new_user_day_give += $udv['total_give_score'];
                }
                $total_rebate_score += ($udv['total_cash_water_score'] + $udv['cash_total_score'] + $udv['total_bonus_water_score'] + $udv['bonus_total_score']);
                //$total_outside_rebate_score += $udv['total_outside_rebate_score'];
                //$total_service_score += $udv['total_service_score'];
                if ($udv['total_give_score'] > 0){
                    $user_day_give += $udv['total_give_score'];
                }
                if ($udv['puid'] > 0){
                    //$all_water_score += $udv['total_water_score'] + $udv['total_outside_water_score'];
                }
                if (($udv['cash_total_score'] + $udv['bonus_total_score']) > 0){//盈利
                    $profit_game_num += 1;
                    if ($udv['regist_time'] > $day_time){
                        $new_profit_game_num += 1;
                    }
                }
                //未付费用户
                if ($udv['total_pay_score'] <= 0){
                    //$not_pay_betting_money += $udv['total_water_score'];
                    //$not_pay_rebate_score += $udv['total_rebate_score'];
                    //$not_pay_service_score += $udv['total_service_score'];
                    if ($udv['regist_time'] > $day_time){
                        //$new_not_pay_betting_money += $udv['total_water_score'];
                        //$new_not_pay_rebate_score += $udv['total_rebate_score'];
                        //$new_not_pay_service_score += $udv['total_service_score'];
                        $new_not_pay_give_coin += $udv['total_give_score'] - $udv['coin'];
                    }

                }
            }
            //$next_to_up_back_money = round($all_water_score * SystemConfig::getConfigValue('runwater_commission_bili') * SystemConfig::getConfigValue('wager_commission_bili'),2);

            $rebate_score_rate = $total_water_score ? round(bcdiv($total_rebate_score,$total_water_score,4)*100,2) : 0;
            $outside_rebate_score_rate = $total_outside_water_score ? round(bcdiv($total_outside_rebate_score,$total_outside_water_score,4)*100,2) : 0;
            $self_profit = $total_water_score - $total_rebate_score + $total_service_score;
            $outside_profit = $total_outside_water_score - $total_outside_rebate_score;
        }

        //提现
        $w_where = [['finishtime','>=', $date_s], ['finishtime','<',$date_e], ['a.status','<>',-1]];
//        $withdraw_log = Db::name("withdraw_log")->whereDay('createtime',$date)->where('auditdesc','<>',9)
//            ->whereOr(function($query) use ($w_where){$query->where($w_where)->where('auditdesc','<>',9);})->field('uid,money,status,auditdesc,channel,package_id,finishtime,withdraw_type,fee_money')->select()->toArray();
        $withdraw_log = Db::name("withdraw_log")
            ->alias('a')
            ->leftJoin('share_strlog b','a.uid=b.uid')
            ->where('a.status','<>',-1)
            ->whereDay('a.createtime',$date)
            ->whereOr(function($query) use ($w_where){$query->where($w_where);})
            ->field('a.uid,a.money,a.status,a.auditdesc,a.channel,a.package_id,a.finishtime,a.withdraw_type,a.fee_money,a.auditdesc,a.fee,
            b.last_pay_price')
            ->select()->toArray();
        //$ss = Db::name('')->getLastSql();
        //dd($withdraw_log);
        $withdraw_user = [];//去重后的提现用户
        $withdraw_auto_count = 0;//系统自动通过订单数
        $withdraw_review_count = 0;//待审核订单数
        $withdraw_suc_count = 0;//提现成功订单数
        $withdraw_suc_rate = 0;//提现成功率
        $withdraw_money = 0;//成功提现金额
        $recharge_withdraw_dif = 0;//充提差
        $withdraw_rate = 0;//退款率
        $new_withdraw_log = [];//新用户提现数据
        $new_withdraw_num = [];//新用户提现人数（去重）
        $new_withdraw_suc_count = 0;//新用户提现成功订单数
        $new_withdraw_money = 0;//新用户提现成功金额
        $first_order_arr = array_keys($first_order_num);//首充人id
        $first_order_wit_num = [];//首充退款人数
        $first_order_wit_money = 0;//首充退款金额
        $new_first_order_wit_num = [];//新用户首充退款人数
        $new_first_order_wit_money = 0;//新用户首充退款金额
        $withdraw_suc_num = [];
        $withdraw_review_money = 0;//提现待审核金额
        $withdraw_fai_count = 0;//提现失败数量
        $new_withdraw_fai_count = 0;//新用户提现失败数量
        $old_withdraw_log = [];//老用户提现数据
        $old_withdraw_num = [];
        $withdraw_fee_money = 0;//提现渠道成本
        $withdraw_money_red = 0;//网红普通退款金额
        $withdraw_money_red_return = 0;//网红返利退款金额
        $not_pay_withdraw_money = 0;//未付费用户退款金额
        $new_not_pay_withdraw_money = 0;//未付费新用户退款金额
        $not_pay_withdraw_num = [];//未付费退款用户人数
        $new_not_pay_withdraw_num = [];//未付费退款新用户人数

        $withdraw_type = ['rr_pay','ser_pay','tm_pay','eanishop_pay','fun_pay','waka_pay','go_pay'];
        $withdraw_type_arr = [];
        foreach ($withdraw_type as $wtk=>$wtv){
            $withdraw_type_arr[$wtk]['name'] = $wtv;
            $withdraw_type_arr[$wtk]['count'] = 0;
            $withdraw_type_arr[$wtk]['suc_count'] = 0;
        }

        if (!empty($withdraw_log)){
            foreach ($withdraw_log as $wlk=>$wlv){
                $finishdate = date('Y-m-d', $wlv['finishtime']);//完成时间
                if ($wlv['auditdesc'] != 7) {//不是网红
                    $withdraw_user[$wlv['uid']] = true;
                    if ($wlv['auditdesc'] == 0 && $wlv['status'] == 1) {
                        $withdraw_auto_count += 1;
                    }
                    if ($wlv['status'] == 3) {
                        $withdraw_review_count += 1;
                        $withdraw_review_money += $wlv['money'];
                    }

                    if ($wlv['status'] == 1) {
                        if ($finishdate == $date) {
                            $withdraw_suc_num[$wlv['uid']] = true;
                            $withdraw_suc_count += 1;
                            $withdraw_money += $wlv['money'];
                            $withdraw_fee_money += 600;//$wlv['fee'];
                            //未付费用户
                            if ($wlv['last_pay_price'] == 0){
                                $not_pay_withdraw_money += $wlv['money'];
                                $not_pay_withdraw_num[$wlv['uid']] = true;
                                if (in_array($wlv['uid'], $regist)){
                                    $new_not_pay_withdraw_money += $wlv['money'];
                                    $new_not_pay_withdraw_num[$wlv['uid']] = true;
                                }
                            }
                        }
                        if (in_array($wlv['uid'], $first_order_arr)) {
                            $first_order_wit_num[$wlv['uid']] = true;
                            $first_order_wit_money += $wlv['money'];
                            if (in_array($wlv['uid'], $regist)) {//新用户
                                $new_first_order_wit_num[$wlv['uid']] = true;
                                $new_first_order_wit_money += $wlv['money'];
                            }
                        }
                    }
                    if ($wlv['status'] == 2) {
                        if ($finishdate == $date) {
                            $withdraw_fai_count += 1;
                        }
                    }
                    if (in_array($wlv['uid'], $regist)) {//新用户
                        $new_withdraw_log[] = $wlv;
                        if ($wlv['status'] == 2) {
                            if ($finishdate == $date) {
                                $new_withdraw_fai_count += 1;
                            }
                        }
                    } else {
                        $old_withdraw_log[] = $wlv;
                    }

                    //各提现渠道
                    foreach ($withdraw_type_arr as $wtak => $wtav) {
                        if ($wtav['name'] == $wlv['withdraw_type']) {
                            if ($wlv['status'] == 2 && $finishdate == $date) {
                                $withdraw_type_arr[$wtak]['count'] += 1;
                            }
                            if ($wlv['status'] == 1) {
                                $withdraw_type_arr[$wtak]['suc_count'] += 1;
                                $withdraw_type_arr[$wtak]['count'] += 1;
                            }
                        }
                    }
                }

                //网红统计
                /*if ($wlv['is_red'] == 1 || $wlv['auditdesc'] == 9) {
                    if ($wlv['status'] == 1 && $finishdate == $date) {
                        if ($wlv['commission_type'] == 0) {
                            $withdraw_money_red += $wlv['money'];
                        }else{
                            $withdraw_money_red_return += $wlv['money'];
                        }
                    }
                }*/
            }
            $withdraw_suc_rate = ($withdraw_suc_count+$withdraw_fai_count)>0 ? round(bcdiv($withdraw_suc_count,$withdraw_suc_count+$withdraw_fai_count,4)*100,2) : 0;
            $withdraw_rate = $recharge_money ? round(bcdiv($withdraw_money,$recharge_money,4)*100,2) : 0;

            if (!empty($new_withdraw_log)){
                foreach ($new_withdraw_log as $newlk=>$newlv){
                    $finishdate = date('Y-m-d',$newlv['finishtime']);//完成时间
                    if ($newlv['status'] == 1){
                        if ($finishdate == $date) {
                            $new_withdraw_suc_count += 1;
                            $new_withdraw_money += $newlv['money'];
                            $new_withdraw_num[$newlv['uid']] = true;
                        }
                    }
                }
            }
            if (!empty($old_withdraw_log)){
                foreach ($old_withdraw_log as $owlk=>$owlv){
                    $finishdate = date('Y-m-d',$owlv['finishtime']);//完成时间
                    if ($owlv['status'] == 1) {
                        if ($finishdate == $date) {
                            $old_withdraw_num[$owlv['uid']] = true;
                        }
                    }
                }
            }
        }
        $recharge_withdraw_dif = $recharge_money - $withdraw_money;
        $new_withdraw_users = implode(',',array_keys($new_withdraw_num));
        $old_withdraw_users = implode(',',array_keys($old_withdraw_num));
        $not_pay_withdraw_userids = implode(',',array_keys($not_pay_withdraw_num));
        $new_not_pay_withdraw_userids = implode(',',array_keys($new_not_pay_withdraw_num));

        //玩家流水
        /*$coin = Db::name("coin_$day")->whereIn('reason',[9,10,11,20,15,22,18,23,21,30,34])->select()->toArray();
        $regist_award_money = 0;//今日平台注册赠送金额
        $tpc_unlock_money = 0;//今日TPC解锁金额 --------------------------------------待定！！！！----------------------------
        $tpc_withdraw_money = 0;//今日TPC提现到余额的数量
        $tpc_withdraw_num = [];//今日TPC提现到余额的人数
        $back_water_num = [];//今日返水人员 去重
        $back_water_money = 0;//今日返水金额
        $back_water_withdraw_balance = 0;//今日返水金额提现到余额的数量  --------------------------------------待定！！！！----------------------------
        $bind_phone_give_money = 0;//今日绑定手机号赠送金额&提现到余额的数量
        $bind_email_give_money = 0;//今日绑定邮箱赠送金额&提现到余额的数量
        $vip_open_give_money = 0;//今日用户VIP等级提升提现到余额的数量
        $daily_competition_give = 0;//今日竞赛提现到余额的数量
        $next_to_up_back_money = 0;//今日下家返利给上家的金额&提现到余额的数量
        $next_to_up_unlock_money = 0;//今日下家VIP等级提升给上家解锁的金额&提现到余额的数量
        $lose_cashback_money = 0;//输钱返现到余额的数量
        $lose_cashback_num = [];//输钱返现到余额的用户
        $lose_cashback_money_num = [];
        $lose_cashback_total_score = 0;//输钱返现到余额的总亏损
        $yesterday_lose_num = 0;//昨日应输钱需返现的人数
        $sign_in_num = [];//今日签到参与人数
        $sign_in_give_money = 0;//今日签到赠送金额
        if (!empty($coin)){
            foreach ($coin as $ck=>$cv){
                if ($cv['reason'] == 11){
                    $regist_award_money += $cv['num'];
                }
                if ($cv['reason'] == 10){
                    $tpc_withdraw_num[$cv['uid']] = true;
                    $tpc_withdraw_money += $cv['num'];
                }
                if ($cv['reason'] == 20){
                    $back_water_num[$cv['uid']] = true;
                    //$back_water_money += $cv['num'];
                    $back_water_withdraw_balance += $cv['num'];
                }
                if ($cv['reason'] == 9){
                    $bind_phone_give_money += $cv['num'];
                }
                if ($cv['reason'] == 15){
                    $bind_email_give_money += $cv['num'];
                }
                if ($cv['reason'] == 22){
                    $vip_open_give_money += $cv['num'];
                }
                if ($cv['reason'] == 18){
                    $daily_competition_give += $cv['num'];
                }
                if ($cv['reason'] == 23){
                    $next_to_up_back_money += $cv['num'];
                }
                if ($cv['reason'] == 21){
                    $next_to_up_unlock_money += $cv['num'];
                }
                if ($cv['reason'] == 30){
                    $lose_cashback_num[$cv['uid']] = true;
                    $lose_cashback_money += $cv['num'];
                    $lose_cashback_money_num[] = $cv['num'];
                }
                if ($cv['reason'] == 34){
                    $sign_in_num[$cv['uid']] = true;
                    $sign_in_give_money += $cv['num'];
                }

            }
        }
        if (!empty($lose_cashback_num) && !empty($lose_cashback_money_num)){
            $lose_cashback_users = array_keys($lose_cashback_num);
            $lose_cashback_total_score = Db::name('cashback_log')->whereIn('uid',$lose_cashback_users)->whereIn('money',$lose_cashback_money_num)->sum('total_score');
        }
        $cashback_log = Db::name('cashback_log')->whereDay('createtime',$date)->select()->toArray();
        if (!empty($cashback_log)){
            foreach ($cashback_log as $calk=>$calv){
                $yesterday_lose_num += 1;
            }
        }*/

        //vip等级提示金额
        $vip_contribute = [];
        /*$next_to_up_unlock_money = 0;//今日下家VIP等级提升给上家解锁的金额
        $vip_contribute = Db::name("vip_contribute")->whereDay('time_stamp')->select()->toArray();
        if (!empty($vip_contribute)){
            foreach ($vip_contribute as $vck=>$vcv){
                $next_to_up_unlock_money += $vcv['coins'];
            }
        }*/

        //推广
        $popularize_num = 0;//今日推广人数
        $popularize_valid_num = [];//今日有效推广人数
        $popularize_valid_money = 0;//今日推广首次充值赠送金额
        $popularize_valid_order_money = 0;//今日推广充值赠送金额
        $user_team = Db::name("user_team")->whereDay('createtime',$date)->field('puid,package_id,channel')->select()->toArray();
        if (!empty($user_team)){
            foreach ($user_team as $utk=>$utv){
                if ($utv['puid'] > 0){
                    $popularize_num += 1;
                }
            }
        }
        /*$user_commission_log = Db::name('user_commission_log')->whereDay('createtime',$date)->select()->toArray();
        if (!empty($user_commission_log)){
            foreach ($user_commission_log as $uclk=>$uclv){
                if ($uclv['type'] == 2){
                    $popularize_valid_num[$uclv['uid']] = true;
                    $popularize_valid_money += $uclv['amount'];
                }elseif ($uclv['type'] == 1){
                    $popularize_valid_order_money += $uclv['amount'];
                }
            }
        }*/

        //轮盘
        //$rotary = Db::name('rotary')->whereDay('time_stamp')->where('channel','<>',-1)->select()->toArray();
        //var_dump($rotary);exit;
        /*$rotary_num = [];//今日轮盘参与的人 去重
        $rotary_count = 0;//今日轮盘旋转次数
        $rotary_diamond_money = 0;//今日轮盘钻石奖励金额
        $rotary_cash_money = 0;//今日轮盘现金奖励金额

        $rotary = Db::name('coin_'.$day)->whereIn('reason',[36])->select()->toArray();
        if (!empty($rotary)){
            foreach ($rotary as $rk=>$rv){
                if ($rv['reason'] == 36){
                    $rotary_num[$rv['uid']] = true;
                    $rotary_count += 1;
                    $rotary_cash_money += $rv['num'];
                }
            }
        }
        $rotary_tpc = Db::name('tpc')->whereDay('time_stamp',$date)->whereIn('reason',[36])->select()->toArray();
        if (!empty($rotary_tpc)){
            foreach ($rotary_tpc as $tk=>$tv){
                if ($tv['reason'] == 36){
                    $rotary_diamond_money += $tv['score'];
                }
            }
        }*/

        //在线人数
        $redis = new \Redis();
//        $redis->connect(Config::get('redis.ip'), 6511);
        $redis->connect(Config::get('redis.ip'), 5511);
        $online_user = $redis->sMembers('online_user');
        $max_game_count  = 0;//今日最高同时游戏人数
        $userinfo = [];
        if (!empty($online_user)) {
            $userinfo = Db::name('userinfo')->whereIn('uid', $online_user)->field('package_id,channel')->select()->toArray();
            if (!empty($userinfo)){
                $max_game_count += count($userinfo);
            }
        }

        //今日登录人数
        $login_count = 0;//今日登录人数
        $logintable_name = "login_".str_replace("-","",$date);
        $isloginTable = Db::query('SHOW TABLES LIKE '."'lzmj_".$logintable_name."'");
        $login_user = [];
        $login_device = [];//活跃设备
        if($isloginTable){
            $login_user = Db::name($logintable_name)->alias('a')->leftJoin('share_strlog b','a.uid=b.uid')
                ->field('a.uid,a.package_id,a.channel,b.device_id,b.isgold')->where('b.isgold',0)->select()->toArray();
            $login_count += count($login_user);
            if (!empty($login_user)){
                foreach ($login_user as $louk=>$louv){
                    $login_device[$louv['device_id']] = true;
                }
            }
        }

        //登录同时玩游戏人数
        $login_game_count = 0;
        $login_game_user = [];
        $login_user_ids = [];
        $new_login_game_count = 0;
        $login_game_users = [];
        $new_login_game_users = [];
        $old_login_game_users = [];
        if (!empty($login_user)){
            $login_user_ids = array_column($login_user,'uid');
            $daytable_name = "user_day_".str_replace("-","",$date);
            $isdayTable = Db::query('SHOW TABLES LIKE '."'lzmj_".$daytable_name."'");
            if ($isdayTable) {
                $login_game_user = Db::name($daytable_name)
                    ->alias('a')
                    //->join('share_strlog ss','a.uid=ss.uid')
                    ->field('a.uid,a.channel,a.package_id,a.total_game_num')
                    //->whereIn('a.uid',$login_user_ids)
                    ->where('total_game_num','>',0)
                    //->cursor();
                    ->select()->toArray();
                if (!empty($login_game_user)){
                    foreach ($login_game_user as $lguk=>$lguv){
                        if ($lguv['total_game_num']>0){//$lguv['isgold'] &&
                            $login_game_count += 1;
                            $login_game_users[$lguv['uid']] = true;
                            if (in_array($lguv['uid'],$regist)){
                                $new_login_game_count += 1;
                                $new_login_game_users[$lguv['uid']] = true;
                            }else{
                                $old_login_game_users[$lguv['uid']] = true;
                            }
                        }
                    }
                }
            }
        }
        $login_game_userids = implode(',',array_keys($login_game_users));
        $new_login_game_userids = implode(',',array_keys($new_login_game_users));
        $lod_login_game_userids = implode(',',array_keys($old_login_game_users));

        //登录的新用户
        $new_login_count = 0;
        $new_login_user = [];
        $new_login_device = [];
        /*if (!empty($login_user)){
            $new_login_user = Db::name('share_strlog')->field('uid,channel,package_id,device_id')
                ->whereDay('createtime',$date)
                ->whereIn('uid',$login_user_ids)->select()->toArray();
            if (!empty($new_login_user)){
                $new_login_count = count($new_login_user);
                foreach ($new_login_user as $nlouk=>$nlouv){
                    $new_login_device[$nlouv['device_id']] = true;
                }
            }
        }*/

        //SystemConfig::getConfigValue()
        $day_data = Db::name("day_data")->where('date',$date)->where('package_id',0)->where('channel',0)->field('max_game_count,id')->find();
        //$last_online_count = $day_data['online_count'] ? $day_data['online_count'] : $max_game_count;
        $online_count = $max_game_count;
        if (!empty($day_data)){
            if ($max_game_count <= $day_data['max_game_count']){
                $max_game_count = $day_data['max_game_count'];
            }
        }
        $updata = [
            'regist_num' => count($regist),
            'device_num' => count($device_num),
            'true_regist_num' => $true_regist_num,
            'true_game_num' => $true_game_num,
            'recharge_num' => count($order_num),
            'recharge_suc_num' => count($order_suc_num),
            'new_recharge_num' => count($new_user_num),//
            'new_recharge_suc_num' => count($new_recharge_suc_num),//
            'old_recharge_num' => count($old_user_num),//
            'recharge_count' => count($order),
            'new_recharge_count' => count($new_user_order),
            'old_recharge_count' => count($old_user_order),
            'recharge_suc_count' => count($suc_order),
            'new_recharge_suc_count' => count($new_suc_order),
            'old_recharge_suc_count' => count($old_suc_order),
            'recharge_suc_rate' => count($order) ? round(bcdiv(count($suc_order),count($order),4)*100,2) : 0,//今日充值订单成功率
            'new_recharge_suc_rate' => count($new_user_order) ? round(bcdiv(count($new_suc_order),count($new_user_order),4)*100,2) : 0,//今日新用户充值订单成功率
            'old_recharge_suc_rate' => count($old_user_order) ? round(bcdiv(count($old_suc_order),count($old_user_order),4)*100,2) : 0,//今日老用户充值订单成功率
            'recharge_money' => $recharge_money,
            'new_recharge_money' => $new_recharge_money,
            'old_recharge_money' => $old_recharge_money,
            'fee_money' => $fee_money,
            'history_old_recharge_num' => $history_old_recharge_num,
            'history_old_recharge_suc_num' => $history_old_recharge_suc_num,
            'true_regist_ids' => $true_regist_ids,
            'new_recharge_suc_users' => $new_recharge_suc_users,
            'old_recharge_suc_users' => $old_recharge_suc_users,
            'new_withdraw_users' => $new_withdraw_users,
            'old_withdraw_users' => $old_withdraw_users,

            'self_game_num' => $self_water_num,
            'new_self_game_num' => $new_self_game_num,
            'self_game_betting_money' => $total_water_score,
            'new_self_game_betting_money' => $new_self_game_betting_money,
            'self_game_award_money' => $total_rebate_score,
            'new_total_rebate_score' => $new_total_rebate_score,
            'self_game_award_rate' => $rebate_score_rate,
            'self_game_profit' => $self_profit,
            'total_service_score' => $total_service_score,
            'three_game_num' => $outside_water_num,
            'new_three_game_num' => $new_three_game_num,
            'three_game_betting_money' => $total_outside_water_score,
            'new_three_game_betting_money' => $new_three_game_betting_money,
            'three_game_award_money' => $total_outside_rebate_score,
            'new_total_outside_rebate_score' => $new_total_outside_rebate_score,
            'three_game_award_rate' => $outside_rebate_score_rate,
            'three_game_profit' => $outside_profit,
            'profit_game_num' => $profit_game_num,
            'new_profit_game_num' => $new_profit_game_num,

            'withdraw_num' => count($withdraw_user),
            'new_withdraw_num' => count($new_withdraw_num),
            'withdraw_count' => count($withdraw_log),
            'new_withdraw_count' => count($new_withdraw_log),
            'withdraw_auto_count' => $withdraw_auto_count,
            'withdraw_review_count' => $withdraw_review_count,
            'withdraw_review_money' => $withdraw_review_money,
            'withdraw_suc_count' => $withdraw_suc_count,
            'new_withdraw_suc_count' => $new_withdraw_suc_count,
            'withdraw_suc_rate' => $withdraw_suc_rate,
            'withdraw_money' => $withdraw_money,
            'new_withdraw_money' => $new_withdraw_money,
            'recharge_withdraw_dif' => $recharge_withdraw_dif,
            'withdraw_rate' => $withdraw_rate,
            'withdraw_suc_num' => count($withdraw_suc_num),
            'withdraw_fai_count' => $withdraw_fai_count,
            'new_withdraw_fai_count' => $new_withdraw_fai_count,

            'profit_rate' => $recharge_money ? round(bcdiv($recharge_withdraw_dif,$recharge_money,4)*100,2) : 0,
            //'profit' => $self_profit + $outside_profit - $regist_award_money - $rotary_cash_money - $back_water_money - $next_to_up_unlock_money - $next_to_up_back_money - $tpc_withdraw_money - $day_active_money,
            //'profit' => $self_profit + $outside_profit - $rotary_cash_money - $back_water_money - $next_to_up_unlock_money - $next_to_up_back_money - $tpc_withdraw_money - $user_day_give - $fee_money,
            //'profit' => $self_profit + $outside_profit - $user_day_give - $fee_money,
            'profit' => $recharge_money - $withdraw_money - $fee_money - $withdraw_fee_money,
            /*'regist_award_money' => $regist_award_money,
            'tpc_unlock_money' => $tpc_unlock_money,
            'tpc_withdraw_money' => $tpc_withdraw_money,
            'tpc_withdraw_num' => count($tpc_withdraw_num),
            'back_water_num' => count($back_water_num),
            'back_water_money' => $back_water_money,
            'back_water_withdraw_balance' => $back_water_withdraw_balance,*/
            'popularize_num' => $popularize_num,

            'max_game_count' => $max_game_count,
            'login_count' => $login_count,
            'login_device' => count($login_device),
            'new_login_device' => count($new_login_device),
            'user_day_give' => $user_day_give,
            'login_game_count' => $login_game_count,
            'new_login_count' => $new_login_count,
            //'bind_email_num' => $bind_email_num,
            'new_login_game_count' => $new_login_game_count,

            'first_order_num' => count($first_order_num),
            'first_order_money' => $first_order_money,
            'first_order_give_money' => $first_order_give_money,
            'new_first_order_num' => count($new_first_order_num),
            'new_first_order_money' => $new_first_order_money,
            'new_first_order_give_money' => $new_first_order_give_money,
            'first_order_wit_num' => count($first_order_wit_num),
            'first_order_wit_money' => $first_order_wit_money,
            'new_first_order_wit_num' => count($new_first_order_wit_num),
            'new_first_order_wit_money' => $new_first_order_wit_money,
            'repurchase_num' => count($repurchase_num),
            'new_repurchase_num' => count($new_repurchase_num),

            'pay_type' => json_encode($pay_type_arr),
            'withdraw_type' => json_encode($withdraw_type_arr),
            'withdraw_fee_money' => $withdraw_fee_money,
            'withdraw_money_red' => $withdraw_money_red,
            'withdraw_money_red_return' => $withdraw_money_red_return,
            'not_pay_betting_money' => $not_pay_betting_money,
            'new_not_pay_betting_money' => $new_not_pay_betting_money,
            'not_pay_rebate_score' => $not_pay_rebate_score,
            'new_not_pay_rebate_score' => $new_not_pay_rebate_score,
            'login_game_userids' => $login_game_userids,
            'new_login_game_userids' => $new_login_game_userids,
            'lod_login_game_userids' => $lod_login_game_userids,
            'not_pay_withdraw_money' => $not_pay_withdraw_money,
            'new_not_pay_withdraw_money' => $new_not_pay_withdraw_money,
            'not_pay_withdraw_userids' => $not_pay_withdraw_userids,
            'new_not_pay_withdraw_userids' => $new_not_pay_withdraw_userids,
            'not_pay_withdraw_num' => count($not_pay_withdraw_num),
            'new_not_pay_withdraw_num' => count($new_not_pay_withdraw_num),
            'not_pay_service_score' => $not_pay_service_score,
            'new_not_pay_service_score' => $new_not_pay_service_score,
            'new_not_pay_give_coin' => $new_not_pay_give_coin,
            //'last_online_count' => $last_online_count,
            'online_count' => $online_count,
            'new_user_day_give' => $new_user_day_give,
        ];

        try {
            if (!empty($day_data)){
                //Db::name("day_data")->where('date',$date)->update($updata);
                Db::name("day_data")->where('id',$day_data['id'])->update($updata);
            }else{
                $updata['date'] = $date;
                Db::name("day_data")->insert($updata);
            }
            unset($updata);

            //分渠道统计
            $this->channelDataSet($regist_list,$order, $user_day, $withdraw_log, $vip_contribute, $login_user, $game_user_list, $login_game_user, $new_login_user,$user_team,$userinfo);
            //Log::error('统计suc==>$self_profit：'.$self_profit.'; $outside_profit: '.$outside_profit.'; $regist_award_money: '.$regist_award_money.'; $rotary_cash_money: '.$rotary_cash_money.'; $back_water_money: '.$back_water_money.'; $next_to_up_unlock_money: '.$next_to_up_unlock_money.'; $next_to_up_back_money: '.$next_to_up_back_money.'; $tpc_withdraw_money: '.$tpc_withdraw_money.'; $day_active_money: '.$day_active_money);
            //Log::error('统计suc==>$self_profit：'.$self_profit.'; $outside_profit: '.$outside_profit.'; $rotary_cash_money: '.$rotary_cash_money.'; $back_water_money: '.$back_water_money.'; $next_to_up_unlock_money: '.$next_to_up_unlock_money.'; $next_to_up_back_money: '.$next_to_up_back_money.'; $tpc_withdraw_money: '.$tpc_withdraw_money.'; $user_day_give: '.$user_day_give.'; $fee_money: '.$fee_money);
            return json(['code' => 200,'msg'=>'统计完成','data' => []]);
        }catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error('dayDataStatistics fail==>'.$exception->getMessage());
        }
    }


    public function channelDataSet($regist_list=[], $order=[], $user_day=[], $withdraw_log=[], $vip_contribute=[], $login_user=[], $game_user_list=[], $login_game_user=[], $new_login_user=[],$user_team=[],$userinfo=[]){
        $day = date('Ymd');
        $date = date('Y-m-d');
        // $day = '20241008';
        // $date = '2024-10-08';
        $day_time = strtotime(date('Y-m-d 00:00:00'));//印度今日凌晨12点时间戳
        $time = time();
        if (($time >= $day_time && $time < $day_time+120) || ($time >= $day_time+7200 && $time < $day_time+9000)){
            $date = date('Y-m-d',strtotime('-1 day'));
            $day = date('Ymd',strtotime('-1 day'));
            $day_time = strtotime($date);
        }
        //$regist_list = Db::name("regist_$day")->select()->toArray();//今日注册人
        //$regist_list = Db::name('share_strlog')->whereDay('createtime')->select()->toArray();//今日注册人
        $regist = [];
        if (!empty($regist_list)) {
            $regist = array_column($regist_list, 'uid');
        }

        try {
            $all_channel = Db::name('chanel')->field('channel,package_id')->select()->toArray();
            if (!empty($all_channel)) {
                $updata = [];
                foreach ($all_channel as $chank => $chanv) {
                    $cid = $chanv['channel'];
                    $package_id = $chanv['package_id'];

                    //*****************开始计算****************
                    //$package_id = 0;
                    //注册
                    $regist_num = 0;
                    $true_regist_num = 0;//今日真金玩家注册人数
                    $device_num = [];//今日设备数（去重）
                    $true_regist_users = [];//真金注册玩家
                    if (!empty($regist_list)) {
                        foreach ($regist_list as $nrelk => $nrelv) {
                            if ($nrelv['channel'] == $cid) {
                                //$package_id = $nrelv['package_id'];
                                $regist_num += 1;
                                if ($nrelv['isgold'] == 0) {
                                    $device_num[$nrelv['device_id']] = true;
                                    $true_regist_num += 1;
                                    $true_regist_users[$nrelv['uid']] = true;
                                }
                            }
                        }
                    }
                    $true_regist_ids = implode(',', array_keys($true_regist_users));

                    //游戏人数
                    $true_game_num = 0;
                    if (!empty($game_user_list)) {
                        foreach ($game_user_list as $ngulk => $ngulv) {
                            if ($ngulv['channel'] == $cid) {
                                //$package_id = $nrelv['package_id'];
                                if ($ngulv['isgold'] == 0 && ($ngulv['total_game_num'] > 0)) {
                                    $true_game_num += 1;
                                }
                            }
                        }
                    }

                    //充值
                    $order_num = [];//充值人去重后数组
                    $order_suc_num = [];//充值成功人去重后数组
                    $suc_order = [];//充值成功的订单
                    $new_user_order = [];//新用户订单
                    $old_user_order = [];//老用户订单
                    $recharge_money = 0;//今日充值金额（指的是充值成功的订单金额统计）
                    $fee_money = 0;//今日充值渠道成本
                    $new_user_num = [];//充值的新用户
                    $new_recharge_suc_num = [];//今日新用户充值成功人数
                    $old_user_num = [];//充值的老用户
                    $new_suc_order = [];//充值成功的新用户订单
                    $old_suc_order = [];//充值成功的老用户订单
                    $new_recharge_money = 0;
                    $old_recharge_money = 0;
                    $day_active_money = 0;//今日充值活动赠送的金额
                    $recharge_count = 0;//今日充值订单数
                    $first_order_num = [];//今日首充人数
                    $first_order_money = 0;//今日首充金额
                    $first_order_give_money = 0;//今日首充赠送金额
                    $new_first_order_num = [];//新用戶今日首充人数
                    $new_first_order_money = 0;//新用戶今日首充金额
                    $new_first_order_give_money = 0;//新用戶今日首充赠送金额
                    $repurchase_num = [];//今日复购用户
                    $new_repurchase_num = [];//新用戶今日复购用户
                    $old_recharge_suc_num = [];//老用户充值成功人

                    $pay_type = ['rr_pay', 'ser_pay', 'tm_pay', 'fun_pay', 'go_pay', 'eanishop_pay', 'waka_pay'];
                    $pay_type_arr = [];
                    foreach ($pay_type as $nptk => $nptv) {
                        $pay_type_arr[$nptk]['name'] = $nptv;
                        $pay_type_arr[$nptk]['count'] = 0;
                        $pay_type_arr[$nptk]['suc_count'] = 0;
                    }
                    if (!empty($order)) {
                        foreach ($order as $ok => $nov) {
                            if ($nov['channel'] == $cid) {
                                //$package_id = $nov['package_id'];
                                $order_num[$nov['uid']] = true;
                                if ($nov['pay_status'] == 1) {
                                    $suc_order[] = $nov;
                                    $order_suc_num[$nov['uid']] = true;
                                    $recharge_money += $nov['price'];
                                    $fee_money += $nov['fee_money'];
                                    if ($nov['is_first'] == 1) {
                                        $first_order_num[$nov['uid']] = true;
                                        $first_order_money += $nov['price'];
                                        $first_order_give_money += $nov['zs_money'];
                                        if (in_array($nov['uid'], $regist)) {
                                            $new_first_order_num[$nov['uid']] = true;
                                            $new_first_order_money += $nov['price'];
                                            $new_first_order_give_money += $nov['zs_money'];
                                        }
                                    }else{
                                        //首充当日充值
                                        $first_order_users = array_keys($first_order_num);
                                        if (in_array($nov['uid'], $first_order_users)){
                                            $first_order_money += $nov['price'];
                                            $first_order_give_money += $nov['zs_money'];
                                            if (in_array($nov['uid'], $regist)){
                                                $new_first_order_money += $nov['price'];
                                                $new_first_order_give_money += $nov['zs_money'];
                                            }
                                        }
                                    }
                                }
                                if (in_array($nov['uid'], $regist)) {//新用户
                                    $new_user_order[] = $nov;
                                } else {
                                    $old_user_order[] = $nov;
                                }
                                if ($nov['active_id'] > 0 && $nov['pay_status'] == 1) {
                                    $day_active_money += $nov['zs_money'];
                                }

                                $recharge_count += 1;

                                //各支付渠道
                                foreach ($pay_type_arr as $nptak => $nptav) {
                                    if ($nptav['name'] == $nov['paytype']) {
                                        $pay_type_arr[$nptak]['count'] += 1;
                                        if ($nov['pay_status'] == 1) {
                                            $pay_type_arr[$nptak]['suc_count'] += 1;
                                        }
                                    }
                                }
                            }
                        }
                        if (!empty($new_user_order)) {
                            foreach ($new_user_order as $nk => $nnv) {
                                $new_user_num[$nnv['uid']] = true;
                                if ($nnv['pay_status'] == 1) {
                                    $new_recharge_suc_num[$nnv['uid']] = true;
                                    $new_suc_order[] = $nnv;
                                    $new_recharge_money += $nnv['price'];
                                }
                            }
                        }
                        if (!empty($old_user_order)) {
                            foreach ($old_user_order as $ouk => $nouv) {
                                $old_user_num[$nouv['uid']] = true;
                                if ($nouv['pay_status'] == 1) {
                                    $old_suc_order[] = $nouv;
                                    $old_recharge_money += $nouv['price'];
                                    $old_recharge_suc_num[$nouv['uid']] = true;
                                }
                            }
                        }
                        //$all_user_arr = array_keys($order_num);
                        //$suc_user_arr = array_keys($order_suc_num);
                        $repurchase_num = getRepetitionValue($suc_order, 'uid');
                        $repurchase_num_arr = array_keys($repurchase_num);
                        if (!empty($repurchase_num_arr)) {
                            foreach ($repurchase_num_arr as $nrnak => $nrnav) {
                                if (in_array($nrnav, $regist)) {
                                    $new_repurchase_num[$nrnav] = true;
                                }
                            }
                        }
                    }
                    $new_recharge_suc_users = implode(',', array_keys($new_recharge_suc_num));
                    $old_recharge_suc_users = implode(',', array_keys($old_recharge_suc_num));
                    //历史老用户充值人数（去重）
                    /*$history_old_recharge_num = Db::name('order')->where('channel', $cid)->whereNotIn('uid', $regist)
                        ->where('createtime', '<', $day_time)->group('uid')->count();
                    //历史老用户充值成功人数（去重）
                    $history_old_recharge_suc_num = Db::name('order')->where('channel', $cid)->whereNotIn('uid', $regist)
                        ->where('createtime', '<', $day_time)->where('pay_status', 1)->group('uid')->count();*/
                    $history_old_recharge_num = 0;
                    //历史老用户充值成功人数（去重）
                    $history_old_recharge_suc_num = 0;

                    //自研、三方游戏投注
                    $self_water_num = 0;//自研游戏投注人数
                    $new_self_game_num = 0;//新用户自研游戏投注人数
                    $outside_water_num = 0;//三方游戏投注人数
                    $new_three_game_num = 0;//新用户三方游戏投注人数
                    $total_water_score = 0;//自研游戏总投注
                    $new_self_game_betting_money = 0;//新用户自研游戏总投注
                    $total_outside_water_score = 0;//三方游戏总投注
                    $new_three_game_betting_money = 0;//新用户三方游戏总投注
                    $total_rebate_score = 0;//自研游戏返奖金额
                    $new_total_rebate_score = 0;//新用户自研游戏返奖金额
                    $total_outside_rebate_score = 0;//三方游戏返奖金额
                    $new_total_outside_rebate_score = 0;//新用户三方游戏返奖金额
                    $rebate_score_rate = 0;//自研游戏返奖率
                    $outside_rebate_score_rate = 0;//三方游戏返奖率
                    $total_service_score = 0;//自研游戏总税收
                    $self_profit = 0;//自研游戏利润（今日自研游戏投注金额-今日自研游戏返奖金额+今日税收）
                    $outside_profit = 0;//三方游戏利润（今日三方游戏投注金额-今日三方游戏返奖金额）
                    $user_day_give = 0;//用户当日赠送金额
                    $new_user_day_give = 0;//新用户当日赠送金额
                    //$next_to_up_back_money =0;//今日下家返利给上家的金额
                    $all_water_score = 0;//有上级的用户总流水
                    $profit_game_num = 0;//游戏盈利人数
                    $new_profit_game_num = 0;//新用户游戏盈利人数
                    $not_pay_betting_money = 0;//未付费用户投注金额
                    $new_not_pay_betting_money = 0;//未付费新用户投注金额
                    $not_pay_rebate_score = 0;//未付费用户返奖金额
                    $new_not_pay_rebate_score = 0;//未付费新用户返奖金额
                    $not_pay_service_score = 0;//未付费游戏税收
                    $new_not_pay_service_score = 0;//未付费新用户游戏税收
                    $new_not_pay_give_coin = 0;//未付费新用户消耗（赠送-余额）
                    if (!empty($user_day)) {
                        foreach ($user_day as $udk => $nudv) {
                            if ($nudv['channel'] == $cid) {
                                //$package_id = $nudv['package_id'];
                                if ($nudv['total_cash_water_score'] > 0 || $nudv['total_bonus_water_score'] > 0) {
                                    $self_water_num += 1;
                                    if ($nudv['regist_time'] > $day_time) {
                                        $new_self_game_num += 1;
                                    }
                                }
                                /*if ($nudv['total_outside_water_score'] > 0) {
                                    $outside_water_num += 1;
                                    if ($nudv['regist_time'] > $day_time){
                                        $new_three_game_num += 1;
                                    }
                                }*/
                                $total_water_score += ($nudv['total_cash_water_score'] + $nudv['total_bonus_water_score']);
                                //$total_outside_water_score += $nudv['total_outside_water_score'];
                                if ($nudv['regist_time'] > $day_time) {
                                    //$new_self_game_betting_money += $nudv['total_water_score'];
                                    //$new_three_game_betting_money += $nudv['total_outside_water_score'];
                                    //$new_total_rebate_score += $nudv['total_rebate_score'];
                                    //$new_total_outside_rebate_score += $nudv['total_outside_rebate_score'];
                                    $new_user_day_give += $nudv['total_give_score'];
                                }
                                $total_rebate_score += ($nudv['total_cash_water_score'] + $nudv['cash_total_score'] + $nudv['total_bonus_water_score'] + $nudv['bonus_total_score']);
                                //$total_outside_rebate_score += $nudv['total_outside_rebate_score'];
                                //$total_service_score += $nudv['total_service_score'];
                                if ($nudv['total_give_score'] > 0) {
                                    $user_day_give += $nudv['total_give_score'];
                                }
                                if ($nudv['puid'] > 0) {
                                    //$all_water_score += $nudv['total_water_score'] + $nudv['total_outside_water_score'];
                                }
                                if (($nudv['cash_total_score'] + $nudv['bonus_total_score']) > 0) {//盈利
                                    $profit_game_num += 1;
                                    if ($nudv['regist_time'] > $day_time) {
                                        $new_profit_game_num += 1;
                                    }
                                }

                                //未付费用户
                                if ($nudv['total_pay_score'] <= 0) {
                                    //$not_pay_betting_money += $nudv['total_water_score'];
                                    //$not_pay_rebate_score += $nudv['total_rebate_score'];
                                    //$not_pay_service_score += $nudv['total_service_score'];
                                    if ($nudv['regist_time'] > $day_time) {
                                        //$new_not_pay_betting_money += $nudv['total_water_score'];
                                        //$new_not_pay_rebate_score += $nudv['total_rebate_score'];
                                        //$new_not_pay_service_score += $nudv['total_service_score'];
                                        $new_not_pay_give_coin += $nudv['total_give_score'] - $nudv['coin'];
                                    }
                                }
                            }
                        }
                        //$next_to_up_back_money = round($all_water_score * SystemConfig::getConfigValue('runwater_commission_bili') * SystemConfig::getConfigValue('wager_commission_bili'),2);

                        $rebate_score_rate = $total_water_score ? round(bcdiv($total_rebate_score, $total_water_score, 4) * 100, 2) : 0;
                        $outside_rebate_score_rate = $total_outside_water_score ? round(bcdiv($total_outside_rebate_score, $total_outside_water_score, 4) * 100, 2) : 0;
                        $self_profit = $total_water_score - $total_rebate_score + $total_service_score;
                        $outside_profit = $total_outside_water_score - $total_outside_rebate_score;
                    }

                    //提现
                    $withdraw_user = [];//去重后的提现用户
                    $withdraw_auto_count = 0;//系统自动通过订单数
                    $withdraw_review_count = 0;//待审核订单数
                    $withdraw_suc_count = 0;//提现成功订单数
                    $withdraw_suc_rate = 0;//提现成功率
                    $withdraw_money = 0;//成功提现金额
                    $recharge_withdraw_dif = 0;//充提差
                    $withdraw_rate = 0;//退款率
                    $new_withdraw_log = [];//新用户提现数据
                    $new_withdraw_num = [];//新用户提现人数（去重）
                    $new_withdraw_suc_count = 0;//新用户提现成功订单数
                    $new_withdraw_money = 0;//新用户提现成功金额
                    $withdraw_log_count = 0;//提现订单总数
                    $first_order_arr = array_keys($first_order_num);//首充人id
                    $first_order_wit_num = [];//首充退款人数
                    $first_order_wit_money = 0;//首充退款金额
                    $new_first_order_wit_num = [];//新用户首充退款人数
                    $new_first_order_wit_money = 0;//新用户首充退款金额
                    $withdraw_suc_num = [];
                    $withdraw_review_money = 0;//提现待审核金额
                    $withdraw_fai_count = 0;//提现失败数量
                    $new_withdraw_fai_count = 0;//新用户提现失败数量
                    $old_withdraw_log = [];//老用户提现数据
                    $old_withdraw_num = [];
                    $withdraw_fee_money = 0;//提现渠道成本
                    $withdraw_money_red = 0;//网红普通退款金额
                    $withdraw_money_red_return = 0;//网红返利退款金额
                    $not_pay_withdraw_money = 0;//未付费用户退款金额
                    $new_not_pay_withdraw_money = 0;//未付费新用户退款金额
                    $not_pay_withdraw_num = [];//未付费退款用户人数
                    $new_not_pay_withdraw_num = [];//未付费退款新用户人数

                    $withdraw_type = ['rr_pay', 'ser_pay', 'tm_pay', 'eanishop_pay', 'fun_pay', 'waka_pay', 'go_pay'];
                    $withdraw_type_arr = [];
                    foreach ($withdraw_type as $nwtk => $nwtv) {
                        $withdraw_type_arr[$nwtk]['name'] = $nwtv;
                        $withdraw_type_arr[$nwtk]['count'] = 0;
                        $withdraw_type_arr[$nwtk]['suc_count'] = 0;
                    }
                    if (!empty($withdraw_log)) {
                        foreach ($withdraw_log as $wlk => $nwlv) {
                            if ($nwlv['channel'] == $cid) {
                                $finishdate = date('Y-m-d', $nwlv['finishtime']);//完成时间
                                if ($nwlv['auditdesc'] != 9) {//不是网红
                                    $withdraw_log_count += 1;
                                    //$package_id = $nwlv['package_id'];
                                    $withdraw_user[$nwlv['uid']] = true;
                                    if ($nwlv['auditdesc'] == 0 && $nwlv['status'] == 1) {
                                        $withdraw_auto_count += 1;
                                    }
                                    if ($nwlv['status'] == 3) {
                                        $withdraw_review_count += 1;
                                        $withdraw_review_money = 0;//提现待审核金额
                                    }

                                    if ($nwlv['status'] == 1) {
                                        if ($finishdate == $date) {
                                            $withdraw_suc_num[$nwlv['uid']] = true;
                                            $withdraw_suc_count += 1;
                                            $withdraw_money += $nwlv['money'];
                                            $withdraw_fee_money += 600;//$nwlv['fee'];
                                            //未付费用户
                                            if ($nwlv['last_pay_price'] == 0) {
                                                $not_pay_withdraw_money += $nwlv['money'];
                                                $not_pay_withdraw_num[$nwlv['uid']] = true;
                                                if (in_array($nwlv['uid'], $regist)) {
                                                    $new_not_pay_withdraw_money += $nwlv['money'];
                                                    $new_not_pay_withdraw_num[$nwlv['uid']] = true;
                                                }
                                            }
                                        }
                                        if (in_array($nwlv['uid'], $first_order_arr)) {
                                            $first_order_wit_num[$nwlv['uid']] = true;
                                            $first_order_wit_money += $nwlv['money'];
                                            if (in_array($nwlv['uid'], $regist)) {//新用户
                                                $new_first_order_wit_num[$nwlv['uid']] = true;
                                                $new_first_order_wit_money += $nwlv['money'];
                                            }
                                        }
                                    }
                                    if ($nwlv['status'] == 2) {
                                        if ($finishdate == $date) {
                                            $withdraw_fai_count += 1;
                                        }
                                    }
                                    if (in_array($nwlv['uid'], $regist)) {//新用户
                                        $new_withdraw_log[] = $nwlv;
                                        if ($nwlv['status'] == 2) {
                                            if ($finishdate == $date) {
                                                $new_withdraw_fai_count += 1;
                                            }
                                        }
                                    } else {
                                        $old_withdraw_log[] = $nwlv;
                                    }

                                    //各提现渠道
                                    foreach ($withdraw_type_arr as $nwtak => $nwtav) {
                                        if ($nwtav['name'] == $nwlv['withdraw_type']) {
                                            if ($nwlv['status'] == 2 && $finishdate == $date) {
                                                $withdraw_type_arr[$nwtak]['count'] += 1;
                                            }
                                            if ($nwlv['status'] == 1) {
                                                $withdraw_type_arr[$nwtak]['suc_count'] += 1;
                                                $withdraw_type_arr[$nwtak]['count'] += 1;
                                            }
                                        }
                                    }
                                }

                                //网红统计
                                /*if ($nwlv['is_red'] == 1 || $nwlv['auditdesc'] == 9) {
                                    if ($nwlv['status'] == 1 && $finishdate == $date) {
                                        if ($nwlv['commission_type'] == 0) {
                                            $withdraw_money_red += $nwlv['money'];
                                        }else{
                                            $withdraw_money_red_return += $nwlv['money'];
                                        }
                                    }
                                }*/
                            }
                        }
                        $withdraw_suc_rate = ($withdraw_suc_count + $withdraw_fai_count) > 0 ? round(bcdiv($withdraw_suc_count, $withdraw_suc_count + $withdraw_fai_count, 4) * 100, 2) : 0;
                        $withdraw_rate = $recharge_money ? round(bcdiv($withdraw_money, $recharge_money, 4) * 100, 2) : 0;

                        if (!empty($new_withdraw_log)) {
                            foreach ($new_withdraw_log as $nnewlk => $nnewlv) {
                                $finishdate = date('Y-m-d', $nnewlv['finishtime']);//完成时间
                                if ($nnewlv['status'] == 1) {
                                    if ($finishdate == $date) {
                                        $new_withdraw_suc_count += 1;
                                        $new_withdraw_money += $nnewlv['money'];
                                        $new_withdraw_num[$nnewlv['uid']] = true;
                                    }
                                }
                            }
                        }
                        if (!empty($old_withdraw_log)) {
                            foreach ($old_withdraw_log as $nowlk => $nowlv) {
                                $finishdate = date('Y-m-d', $nowlv['finishtime']);//完成时间
                                if ($nowlv['status'] == 1) {
                                    if ($finishdate == $date) {
                                        $old_withdraw_num[$nowlv['uid']] = true;
                                    }
                                }
                            }
                        }
                    }
                    $recharge_withdraw_dif = $recharge_money - $withdraw_money;
                    $new_withdraw_users = implode(',', array_keys($new_withdraw_num));
                    $old_withdraw_users = implode(',', array_keys($old_withdraw_num));
                    $not_pay_withdraw_userids = implode(',', array_keys($not_pay_withdraw_num));
                    $new_not_pay_withdraw_userids = implode(',', array_keys($new_not_pay_withdraw_num));

                    //玩家流水
                    /*$regist_award_money = 0;//今日平台注册赠送金额
                    $tpc_unlock_money = 0;//今日TPC解锁金额 --------------------------------------待定！！！！----------------------------
                    $tpc_withdraw_money = 0;//今日TPC提现到余额的数量
                    $tpc_withdraw_num = [];//今日TPC提现到余额的人数
                    $back_water_num = [];//今日返水人员 去重
                    $back_water_money = 0;//今日返水金额
                    $back_water_withdraw_balance = 0;//今日返水金额提现到余额的数量  --------------------------------------待定！！！！----------------------------
                    $bind_phone_give_money = 0;//今日绑定手机号赠送金额&提现到余额的数量
                    $bind_email_give_money = 0;//今日绑定邮箱赠送金额&提现到余额的数量
                    $vip_open_give_money = 0;//今日用户VIP等级提升提现到余额的数量
                    $daily_competition_give = 0;//今日竞赛提现到余额的数量
                    $next_to_up_back_money = 0;//今日下家返利给上家的金额&提现到余额的数量
                    $next_to_up_unlock_money = 0;//今日下家VIP等级提升给上家解锁的金额&提现到余额的数量
                    $lose_cashback_money = 0;//输钱返现到余额的数量
                    $lose_cashback_num = [];//输钱返现到余额的用户
                    $lose_cashback_money_num = [];
                    $lose_cashback_total_score = 0;//输钱返现到余额的总亏损
                    $yesterday_lose_num = 0;//昨日应输钱需返现的人数
                    $sign_in_num = [];//今日签到参与人数
                    $sign_in_give_money = 0;//今日签到赠送金额
                    if (!empty($coin)){
                        foreach ($coin as $ck=>$ncv){
                            if ($ncv['channel'] == $cid) {
                                //$package_id = $ncv['package_id'];
                                if ($ncv['reason'] == 11) {
                                    $regist_award_money += $ncv['num'];
                                }
                                if ($ncv['reason'] == 10) {
                                    $tpc_withdraw_num[$ncv['uid']] = true;
                                    $tpc_withdraw_money += $ncv['num'];
                                }
                                if ($ncv['reason'] == 20) {
                                    $back_water_num[$ncv['uid']] = true;
                                    //$back_water_money += $ncv['num'];
                                    $back_water_withdraw_balance += $ncv['num'];
                                }
                                if ($ncv['reason'] == 9){
                                    $bind_phone_give_money += $ncv['num'];
                                }
                                if ($ncv['reason'] == 15){
                                    $bind_email_give_money += $ncv['num'];
                                }
                                if ($ncv['reason'] == 22){
                                    $vip_open_give_money += $ncv['num'];
                                }
                                if ($ncv['reason'] == 18){
                                    $daily_competition_give += $ncv['num'];
                                }
                                if ($ncv['reason'] == 23){
                                    $next_to_up_back_money += $ncv['num'];
                                }
                                if ($ncv['reason'] == 21){
                                    $next_to_up_unlock_money += $ncv['num'];
                                }
                                if ($ncv['reason'] == 30){
                                    $lose_cashback_num[$ncv['uid']] = true;
                                    $lose_cashback_money += $ncv['num'];
                                    $lose_cashback_money_num[] = $ncv['num'];
                                }
                                if ($ncv['reason'] == 34){
                                    $sign_in_num[$ncv['uid']] = true;
                                    $sign_in_give_money += $ncv['num'];
                                }
                            }
                        }
                    }
                    if (!empty($lose_cashback_num) && !empty($lose_cashback_money_num)){
                        $lose_cashback_users = array_keys($lose_cashback_num);
                        $lose_cashback_total_score = Db::name('cashback_log')->whereIn('uid',$lose_cashback_users)->whereIn('money',$lose_cashback_money_num)->sum('total_score');
                    }
                    if (!empty($cashback_log)){
                        foreach ($cashback_log as $ncalk=>$ncalv){
                            if ($ncalv['channel'] == $cid) {
                                $yesterday_lose_num += 1;
                            }
                        }
                    }*/

                    //vip等级提示金额
                    /*$next_to_up_unlock_money = 0;//今日下家VIP等级提升给上家解锁的金额
                    if (!empty($vip_contribute)){
                        foreach ($vip_contribute as $vck=>$nvcv){
                            if ($nvcv['channel'] == $cid) {
                                //$package_id = $nvcv['package_id'];
                                $next_to_up_unlock_money += $nvcv['coins'];
                            }
                        }
                    }*/

                    //推广
                    $popularize_num = 0;//今日推广人数
                    $popularize_valid_num = [];//今日有效推广人数
                    $popularize_valid_money = 0;//今日推广首次充值赠送金额
                    $popularize_valid_order_money = 0;//今日推广充值赠送金额
                    if (!empty($user_team)) {
                        foreach ($user_team as $utk => $nutv) {
                            if ($nutv['channel'] == $cid) {
                                //$package_id = $nutv['package_id'];
                                if ($nutv['puid'] > 0) {
                                    $popularize_num += 1;
                                }
                            }
                        }
                    }
                    /*if (!empty($user_commission_log)){
                        foreach ($user_commission_log as $nuclk=>$nuclv){
                            if ($nuclv['channel'] == $cid) {
                                $popularize_valid_num[$nuclv['uid']] = true;
                                if ($nuclv['type'] == 2) {
                                    $popularize_valid_money += $nuclv['amount'];
                                } elseif ($nuclv['type'] == 1) {
                                    $popularize_valid_order_money += $nuclv['amount'];
                                }
                            }
                        }
                    }

                    //轮盘
                    $rotary_num = [];//今日轮盘参与的人 去重
                    $rotary_count = 0;//今日轮盘旋转次数
                    $rotary_diamond_money = 0;//今日轮盘钻石奖励金额
                    $rotary_cash_money = 0;//今日轮盘现金奖励金额
                    if (!empty($rotary)){
                        foreach ($rotary as $nrk=>$nrv){
                            if ($nrv['channel'] == $cid) {
                                if ($nrv['reason'] == 36) {
                                    $rotary_num[$nrv['uid']] = true;
                                    $rotary_count += 1;
                                    $rotary_cash_money += $nrv['num'];
                                }
                            }
                        }
                    }
                    if (!empty($rotary_tpc)){
                        foreach ($rotary_tpc as $ntk=>$ntv){
                            if ($ntv['channel'] == $cid) {
                                if ($ntv['reason'] == 36) {
                                    $rotary_diamond_money += $ntv['score'];
                                }
                            }
                        }
                    }*/

                    //在线人数
                    $max_game_count = 0;//今日最高同时游戏人数
                    if (!empty($userinfo)) {
                        foreach ($userinfo as $nuik => $nuiv) {
                            if ($nuiv['channel'] == $cid) {
                                //$package_id = $nuiv['package_id'];
                                $max_game_count += 1;
                            }
                        }
                    }

                    //今日登录人数
                    $login_count = 0;//今日登录人数
                    $login_device = [];
                    if (!empty($login_user)) {
                        foreach ($login_user as $nluk => $nluv) {
                            if ($nluv['channel'] == $cid) {
                                //$package_id = $nluv['package_id'];
                                $login_count += 1;
                                $login_device[$nluv['device_id']] = true;
                            }
                        }
                    }

                    //登录同时玩游戏人数
                    $login_game_count = 0;
                    $new_login_game_count = 0;
                    $login_game_users = [];
                    $new_login_game_users = [];
                    $old_login_game_users = [];
                    if (!empty($login_game_user)) {
                        foreach ($login_game_user as $nlguk => $nlguv) {
                            if ($nlguv['channel'] == $cid) {
                                //$package_id = $nlguv['package_id'];
                                if ($nlguv['total_game_num'] > 0) {
                                    $login_game_count += 1;
                                    $login_game_users[$nlguv['uid']] = true;
                                    if (in_array($nlguv['uid'], $regist)) {
                                        $new_login_game_count += 1;
                                        $new_login_game_users[$nlguv['uid']] = true;
                                    } else {
                                        $old_login_game_users[$nlguv['uid']] = true;
                                    }
                                }
                            }
                        }
                    }
                    $login_game_userids = implode(',', array_keys($login_game_users));
                    $new_login_game_userids = implode(',', array_keys($new_login_game_users));
                    $lod_login_game_userids = implode(',', array_keys($old_login_game_users));

                    //登录的新用户
                    $new_login_count = 0;
                    $new_login_device = [];
                    if (!empty($new_login_user)) {
                        foreach ($new_login_user as $nnluk => $nnluv) {
                            if ($nnluv['channel'] == $cid) {
                                //$package_id = $nnluv['package_id'];
                                $new_login_count += 1;
                                $new_login_device[$nnluv['device_id']] = true;
                            }
                        }
                    }

                    //绑定邮箱人
                    /*$bind_email_num = 0;
                    if (!empty($user_email)){
                        foreach ($user_email as $nuek=>$nuev){
                            if ($nuev['channel'] == $cid){
                                $bind_email_num += 1;
                            }
                        }
                    }

                    //活动数据
                    $new_active_num = [];
                    $new_active_recharge_money = 0;
                    $new_active_give_money = 0;
                    $bankruptcy_active_num = [];
                    $bankruptcy_active_recharge_money = 0;
                    $bankruptcy_active_give_money = 0;
                    $deposit_active_num = [];
                    $deposit_active_recharge_money = 0;
                    $deposit_active_give_money = 0;
                    $daily_active_num = [];
                    $daily_active_recharge_money = 0;
                    $daily_active_give_money = 0;
                    $refill_card_num = [];//今日充值卡参与人数
                    $refill_card_money = 0;//今日充值卡充值金额
                    $refill_card_give_money = 0;
                    if (!empty($active_log)){
                        foreach ($active_log as $nalk=>$nalv){
                            if ($nalv['channel'] == $cid) {
                                switch ($nalv['type']) {
                                    case 6:
                                        $bankruptcy_active_num[$nalv['uid']] = true;
                                        $bankruptcy_active_recharge_money += $nalv['money'];
                                        $bankruptcy_active_give_money += $nalv['zs_money'];
                                        break;
                                    case 2:
                                        $daily_active_num[$nalv['uid']] = true;
                                        $daily_active_recharge_money += $nalv['money'];
                                        $daily_active_give_money += $nalv['zs_money'];
                                        break;
                                    case 3:
                                        $deposit_active_num[$nalv['uid']] = true;
                                        $deposit_active_recharge_money += $nalv['money'];
                                        $deposit_active_give_money += $nalv['zs_money'];
                                        break;
                                    case 5:
                                        $refill_card_num[$nalv['uid']] = true;
                                        $refill_card_money += $nalv['money'];
                                        $refill_card_give_money += $nalv['zs_money'];
                                        break;
                                    default:
                                        break;
                                }
                            }
                        }
                    }

                    //vip
                    $vip1_num = 0;
                    $vip1_open = 0;
                    $vip2_num = 0;
                    $vip2_open = 0;
                    $vip3_num = 0;
                    $vip3_open = 0;
                    $vip4_num = 0;
                    $vip4_open = 0;
                    $vip5_num = 0;
                    $vip5_open = 0;
                    $vip6_num = 0;
                    $vip6_open = 0;
                    $vip7_num = 0;
                    $vip7_open = 0;
                    $vip8_num = 0;
                    $vip8_open = 0;
                    $vip9_num = 0;
                    $vip9_open = 0;
                    $vip10_num = 0;
                    $vip10_open = 0;
                    if (!empty($strlog_user)){
                        foreach ($strlog_user as $nsuk=>$nsuv){
                            if ($nsuv['channel'] == $cid) {
                                if ($nsuv['vip'] <= 10) {
                                    ${'vip' . $nsuv['vip'] . '_num'} += 1;
                                    if ($nsuv['vip'] != $nsuv['yesterday_vip']) {
                                        ${'vip' . $nsuv['vip'] . '_open'} += 1;
                                    }
                                }
                            }
                        }
                    }*/

                    $cid_day_data = Db::name("day_data")->where('date', $date)->where('channel', $cid)->find();
                    //$last_online_count = $cid_day_data['online_count'] ? $cid_day_data['online_count'] : $max_game_count;
                    $online_count = $max_game_count;
                    //var_dump($cid_day_data);exit;
                    if (!empty($cid_day_data)) {
                        if ($max_game_count < $cid_day_data['max_game_count']) {
                            $max_game_count = $cid_day_data['max_game_count'];
                        }
                    }

                    $updata[] = [
                        'regist_num' => $regist_num,
                        'device_num' => count($device_num),
                        'true_regist_num' => $true_regist_num,
                        'true_game_num' => $true_game_num,
                        'recharge_num' => count($order_num),
                        'recharge_suc_num' => count($order_suc_num),
                        'new_recharge_num' => count($new_user_num),//
                        'new_recharge_suc_num' => count($new_recharge_suc_num),//
                        'old_recharge_num' => count($old_user_num),//
                        'recharge_count' => $recharge_count,
                        'new_recharge_count' => count($new_user_order),
                        'old_recharge_count' => count($old_user_order),
                        'recharge_suc_count' => count($suc_order),
                        'new_recharge_suc_count' => count($new_suc_order),
                        'old_recharge_suc_count' => count($old_suc_order),
                        'recharge_suc_rate' => $recharge_count ? round(bcdiv(count($suc_order), $recharge_count, 4) * 100, 2) : 0,//今日充值订单成功率
                        'new_recharge_suc_rate' => count($new_user_order) ? round(bcdiv(count($new_suc_order), count($new_user_order), 4) * 100, 2) : 0,//今日新用户充值订单成功率
                        'old_recharge_suc_rate' => count($old_user_order) ? round(bcdiv(count($old_suc_order), count($old_user_order), 4) * 100, 2) : 0,//今日老用户充值订单成功率
                        'recharge_money' => $recharge_money,
                        'new_recharge_money' => $new_recharge_money,
                        'old_recharge_money' => $old_recharge_money,
                        'fee_money' => $fee_money,
                        'history_old_recharge_num' => $history_old_recharge_num,
                        'history_old_recharge_suc_num' => $history_old_recharge_suc_num,
                        'true_regist_ids' => $true_regist_ids,
                        'new_recharge_suc_users' => $new_recharge_suc_users,
                        'old_recharge_suc_users' => $old_recharge_suc_users,
                        'new_withdraw_users' => $new_withdraw_users,
                        'old_withdraw_users' => $old_withdraw_users,

                        'self_game_num' => $self_water_num,
                        'new_self_game_num' => $new_self_game_num,
                        'self_game_betting_money' => $total_water_score,
                        'new_self_game_betting_money' => $new_self_game_betting_money,
                        'self_game_award_money' => $total_rebate_score,
                        'new_total_rebate_score' => $new_total_rebate_score,
                        'self_game_award_rate' => $rebate_score_rate,
                        'self_game_profit' => $self_profit,
                        'total_service_score' => $total_service_score,
                        'three_game_num' => $outside_water_num,
                        'new_three_game_num' => $new_three_game_num,
                        'three_game_betting_money' => $total_outside_water_score,
                        'new_three_game_betting_money' => $new_three_game_betting_money,
                        'three_game_award_money' => $total_outside_rebate_score,
                        'new_total_outside_rebate_score' => $new_total_outside_rebate_score,
                        'three_game_award_rate' => $outside_rebate_score_rate,
                        'three_game_profit' => $outside_profit,
                        'profit_game_num' => $profit_game_num,
                        'new_profit_game_num' => $new_profit_game_num,

                        'withdraw_num' => count($withdraw_user),
                        'new_withdraw_num' => count($new_withdraw_num),
                        'withdraw_count' => $withdraw_log_count,
                        'new_withdraw_count' => count($new_withdraw_log),
                        'withdraw_auto_count' => $withdraw_auto_count,
                        'withdraw_review_count' => $withdraw_review_count,
                        'withdraw_review_money' => $withdraw_review_money,
                        'withdraw_suc_count' => $withdraw_suc_count,
                        'new_withdraw_suc_count' => $new_withdraw_suc_count,
                        'withdraw_suc_rate' => $withdraw_suc_rate,
                        'withdraw_money' => $withdraw_money,
                        'new_withdraw_money' => $new_withdraw_money,
                        'recharge_withdraw_dif' => $recharge_withdraw_dif,
                        'withdraw_rate' => $withdraw_rate,
                        'withdraw_suc_num' => count($withdraw_suc_num),
                        'withdraw_fai_count' => $withdraw_fai_count,
                        'new_withdraw_fai_count' => $new_withdraw_fai_count,

                        'profit_rate' => $recharge_money ? round(bcdiv($recharge_withdraw_dif, $recharge_money, 4) * 100, 2) : 0,

                        'profit' => $recharge_money - $withdraw_money - $fee_money - $withdraw_fee_money,

                        'popularize_num' => $popularize_num,

                        'max_game_count' => $max_game_count,
                        'login_count' => $login_count,
                        'login_device' => count($login_device),
                        'new_login_device' => count($new_login_device),
                        'user_day_give' => $user_day_give,
                        'login_game_count' => $login_game_count,
                        'new_login_count' => $new_login_count,
                        //'bind_email_num' => $bind_email_num,
                        'new_login_game_count' => $new_login_game_count,

                        'first_order_num' => count($first_order_num),
                        'first_order_money' => $first_order_money,
                        'first_order_give_money' => $first_order_give_money,
                        'new_first_order_num' => count($new_first_order_num),
                        'new_first_order_money' => $new_first_order_money,
                        'new_first_order_give_money' => $new_first_order_give_money,
                        'first_order_wit_num' => count($first_order_wit_num),
                        'first_order_wit_money' => $first_order_wit_money,
                        'new_first_order_wit_num' => count($new_first_order_wit_num),
                        'new_first_order_wit_money' => $new_first_order_wit_money,
                        'repurchase_num' => count($repurchase_num),
                        'new_repurchase_num' => count($new_repurchase_num),

                        'pay_type' => json_encode($pay_type_arr),
                        'withdraw_type' => json_encode($withdraw_type_arr),
                        'withdraw_fee_money' => $withdraw_fee_money,
                        'withdraw_money_red' => $withdraw_money_red,
                        'withdraw_money_red_return' => $withdraw_money_red_return,
                        'not_pay_betting_money' => $not_pay_betting_money,
                        'new_not_pay_betting_money' => $new_not_pay_betting_money,
                        'not_pay_rebate_score' => $not_pay_rebate_score,
                        'new_not_pay_rebate_score' => $new_not_pay_rebate_score,
                        'login_game_userids' => $login_game_userids,
                        'new_login_game_userids' => $new_login_game_userids,
                        'lod_login_game_userids' => $lod_login_game_userids,
                        'not_pay_withdraw_money' => $not_pay_withdraw_money,
                        'new_not_pay_withdraw_money' => $new_not_pay_withdraw_money,
                        'not_pay_withdraw_userids' => $not_pay_withdraw_userids,
                        'new_not_pay_withdraw_userids' => $new_not_pay_withdraw_userids,
                        'not_pay_withdraw_num' => count($not_pay_withdraw_num),
                        'new_not_pay_withdraw_num' => count($new_not_pay_withdraw_num),
                        'not_pay_service_score' => $not_pay_service_score,
                        'new_not_pay_service_score' => $new_not_pay_service_score,
                        'new_not_pay_give_coin' => $new_not_pay_give_coin,
                        //'last_online_count' => $last_online_count,
                        'online_count' => $online_count,
                        'new_user_day_give' => $new_user_day_give,
                        'new_total_recharge' => $cid_day_data['new_total_recharge'] ?? 0,
                        'new_total_recharge_users' => $cid_day_data['new_total_recharge_users'] ?? '',
                        'new_total_withdraw' => $cid_day_data['new_total_withdraw'] ?? 0,
                        'new_total_withdraw_users' => $cid_day_data['new_total_withdraw_users'] ?? '',
                        'new_total_recharge_fee' => $cid_day_data['new_total_recharge_fee'] ?? 0,
                        'new_total_withdraw_count' => $cid_day_data['new_total_withdraw_count'] ?? 0,

                        'package_id' => $package_id,
                        'date' => $date,
                        'channel' => $cid,
                    ];

                    /*if (!empty($cid_day_data)) {
                        Db::name("day_data")->where('date', $date)->where('channel', $cid)->update($updata);
                    } else {
                        $updata['date'] = $date;
                        $updata['channel'] = $cid;
                        $updata['package_id'] = $package_id;
                        Db::name("day_data")->insert($updata);
                    }*/
                }

                if (!empty($updata)) {
                    Db::name('day_data')->where('date', $date)->where('package_id', '<>', 0)->where('channel', '<>', 0)->delete();
                    if(count($updata) > 500){
                        $new_data = array_chunk($updata, 500);
                        foreach ($new_data as $newv){
                            Db::name("day_data")->insertAll($newv);
                        }
                    }
                    //Db::name("day_data")->insertAll($updata);
                }
            }
        }catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error('channelDataSet fail==>'.$exception->getMessage());
        }
        return true;
    }


    /**
     * 游戏数据统计
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getGameTable(){
//        $date = date('Ymd',strtotime("-1 day"));
//        $time = time();
//        $day_date = date('Y-m-d',strtotime("-1 day"));
        $date = date('Ymd');
        $time = time()  ;
        $day_date = date('Y-m-d');
        //$date = 20240706
        //$day_date = '2024-07-06';
        $day_time = strtotime(date('Y-m-d 00:00:00'));//印度今日凌晨12点时间戳
        if ($time >= $day_time && $time < $day_time+120 || ($time >= $day_time+25200 && $time < $day_time+27000)){
            $date = date('Ymd',strtotime('-1 day'));
            $day_date = date('Y-m-d',strtotime('-1 day'));
        }

        $recordstable_name = "game_records_".str_replace("-","",$date);
        $isrecordsTable = Db::query('SHOW TABLES LIKE '."'lzmj_".$recordstable_name."'");
        $game_records = [];
        if($isrecordsTable){
            $game_records = Db::table('lzmj_'.$recordstable_name)
                ->group('game_type,table_level')
                ->field('game_type,table_level,IFNULL(sum(coin_change),0) as coin_change,IFNULL(sum(service_score),0) as service_score,
                IFNULL(sum(bet_score),0) as bet_score,IFNULL(sum(final_score + add_bet_15),0) as final_score,count(id) as game_count')
                ->where('is_android',0)
                ->distinct()
                ->select()->toArray();
            $game_records_user = Db::table('lzmj_'.$recordstable_name)
                ->alias('a')
                ->leftJoin('userinfo b','a.uid=b.uid')
                ->group('a.game_type,a.uid,a.table_level')
                ->field('a.game_type,a.table_level,a.uid,IFNULL(sum(a.coin_change),0) as coin_change,IFNULL(sum(a.service_score),0) as service_score,
                IFNULL(sum(a.bet_score),0) as bet_score,IFNULL(sum(a.final_score + add_bet_15),0) as final_score,
                b.total_pay_score')
                ->where('a.is_android',0)
                ->select()->toArray();

            /*$game_count = Db::name('game_table_'.$date)
                ->group('game_type')
                ->field('game_type,count(*) as game_count,IFNULL(sum(user_num),0) as user_count')
                ->where('service_score','<>',0)
                ->select()->toArray();*/
            $ai_game_arr = [1001,1002,1003];
            $ai_game_records = Db::table('lzmj_'.$recordstable_name)
                ->group('game_type,table_level')
                ->field('game_type,table_level,IFNULL(sum(coin_change),0) as ai_coin_change,IFNULL(sum(bet_score),0) as ai_bet_score,
                IFNULL(sum(final_score),0) as ai_final_score')
                ->where('is_android',1)
                ->whereIn('game_type',$ai_game_arr)
                ->select()->toArray();
            //var_dump($game_records_user);exit;
            if (!empty($game_records)){
                foreach ($game_records as $grk=>$grv){
                    //$game_records[$grk]['game_count'] = 0;
                    $game_records[$grk]['user_count'] = 0;
                    $game_records[$grk]['ai_bet_score'] = 0;
                    $game_records[$grk]['ai_coin_change'] = 0;
                    $game_records[$grk]['ai_final_score'] = 0;
                    $game_records[$grk]['user_ids'] = [];
                    $game_records[$grk]['pay_user_ids'] = [];
                    $game_records[$grk]['no_user_ids'] = [];
                    $game_records[$grk]['pay_bet_score'] = 0;
                    $game_records[$grk]['no_bet_score'] = 0;
                    $game_records[$grk]['pay_coin_change'] = 0;
                    $game_records[$grk]['no_coin_change'] = 0;
                    /*if (!empty($game_count)){
                        foreach ($game_count as $gck=>$gcv){
                            if ($grv['game_type'] == $gcv['game_type']){
                                $game_records[$grk]['game_count'] = $gcv['game_count'];
                                //$game_records[$grk]['user_count'] = $gcv['user_count'];
                            }
                        }
                    }*/
                    if (!empty($game_records_user)){
                        foreach ($game_records_user as $gruk=>$gtuv){
                            if ($grv['game_type'] == $gtuv['game_type'] && $grv['table_level'] == $gtuv['table_level']){
                                $game_records[$grk]['user_count'] += 1;
                                $game_records[$grk]['user_ids'][$gtuv['uid']] = true;
                                if ($gtuv['total_pay_score'] > 0){
                                    $game_records[$grk]['pay_user_ids'][$gtuv['uid']] = true;
                                    $game_records[$grk]['pay_bet_score'] += $gtuv['bet_score'];
                                    $game_records[$grk]['pay_coin_change'] += $gtuv['coin_change'];
                                }else{
                                    $game_records[$grk]['no_user_ids'][$gtuv['uid']] = true;
                                    $game_records[$grk]['no_bet_score'] += $gtuv['bet_score'];
                                    $game_records[$grk]['no_coin_change'] += $gtuv['coin_change'];
                                }
                            }
                        }
                    }
                    if (!empty($ai_game_records) && in_array($grv['game_type'],$ai_game_arr)){
                        foreach ($ai_game_records as $agrk=>$agrv){
                            if ($grv['game_type'] == $agrv['game_type'] && $grv['table_level'] == $agrv['table_level']) {
                                $game_records[$grk]['ai_bet_score'] = $agrv['ai_bet_score'];
                                $game_records[$grk]['ai_coin_change'] = $agrv['ai_coin_change'];
                                $game_records[$grk]['ai_final_score'] = $agrv['ai_final_score'];
                            }
                        }
                    }
                }
            }




            $slots_name = "slots_log_".$date;
            $slotsTable = Db::query('SHOW TABLES LIKE '."'br_".$slots_name."'");
            if($slotsTable){
                $slotsConfig = ['pg' => 1, 'pp' => 2, 'td' => 3, 'eg' => 4, 'cq9' => 5, 'sbs' => 6, 'sbo' => 7, 'zy' => 8, 'jl' => 9, 'we' => 10, 'ezugi' => 11, 'jdb' => 12, 'evo' => 13, 'spr' => 14,'bg' => 15,'joker' => 16,'turbo' => 17,'avi'=>18];
                $slots_log = Db::name($slots_name)
                    ->field('count(*) as count,sum(cashBetAmount) as cashBetAmount,sum(bonusBetAmount) as bonusBetAmount,sum(cashWinAmount) as cashWinAmount,
                    sum(bonusWinAmount) as bonusWinAmount,terrace_name,uid')
                    ->where('is_settlement',1)
                    ->whereNotNull('terrace_name')
                    ->group('terrace_name,uid')
                    //->select()->toArray();
                    ->cursor();

                $slotsData = [];
                foreach ($slots_log as $v){
                    if(isset($slotsData[$v['terrace_name']])){
                        $slotsData[$v['terrace_name']]['user_count'] = $slotsData[$v['terrace_name']]['user_count'] + 1;
                        $slotsData[$v['terrace_name']]['game_count'] = $slotsData[$v['terrace_name']]['game_count'] + $v['count'];
                        $slotsData[$v['terrace_name']]['bet_score'] = $slotsData[$v['terrace_name']]['bet_score'] + $v['cashBetAmount'] + $v['bonusBetAmount'];
                        $slotsData[$v['terrace_name']]['winAmount'] = $slotsData[$v['terrace_name']]['winAmount'] + $v['cashWinAmount'] + $v['bonusWinAmount'];
                        $slotsData[$v['terrace_name']]['user_ids'][$v['uid']] = true;
                    }else{
                        $slotsData[$v['terrace_name']]['user_count'] =  1;
                        $slotsData[$v['terrace_name']]['game_count'] = $v['count'];
                        $slotsData[$v['terrace_name']]['bet_score'] = $v['cashBetAmount'] + $v['bonusBetAmount'];
                        $slotsData[$v['terrace_name']]['winAmount'] = $v['cashWinAmount'] + $v['bonusWinAmount'];
                        $slotsData[$v['terrace_name']]['user_ids'][$v['uid']] = true;
                    }
                }


                foreach ($slotsData as $key => $item){
                    $game_records[$key]['game_type'] = $slotsConfig[$key];
                    $game_records[$key]['user_count'] = $item['user_count'];
                    $game_records[$key]['game_count'] = $item['game_count'];
                    $game_records[$key]['bet_score'] = $item['bet_score'];
                    $game_records[$key]['coin_change'] = $item['winAmount'];
                    $game_records[$key]['service_score'] = 0;
                    $game_records[$key]['ai_coin_change'] = 0;
                    $game_records[$key]['ai_final_score'] = 0;
                    $game_records[$key]['ai_bet_score'] = 0;
                    $game_records[$key]['final_score'] = bcsub($item['winAmount'],$item['bet_score'],0);
                    $game_records[$key]['user_ids'] = $item['user_ids'];
                    $game_records[$key]['pay_user_ids'] = [];
                    $game_records[$key]['no_user_ids'] = [];
                    $game_records[$key]['table_level'] = 1;
                    $game_records[$key]['pay_bet_score'] = 0;
                    $game_records[$key]['pay_coin_change'] = 0;
                    $game_records[$key]['no_bet_score'] = 0;
                    $game_records[$key]['no_coin_change'] = 0;
                }

            }

            //dd($game_records);

            try {
                if (!empty($game_records)){
                    foreach ($game_records as $igrk=>$igrv){
                        $user_ids = implode(',',array_keys($igrv['user_ids']));
                        $pay_user_ids = implode(',',array_keys($igrv['pay_user_ids']));
                        $no_user_ids = implode(',',array_keys($igrv['no_user_ids']));
                        $datas = [
                            'update_time' => $time,
                            'user_count' => $igrv['user_count'],
                            'game_count' => $igrv['game_count'],
                            'service_score' => $igrv['service_score'],
                            'bet_score' => $igrv['bet_score'],
                            'ai_bet_score' => $igrv['ai_bet_score'],
                            'coin_change' => $igrv['coin_change'],
                            'ai_coin_change' => $igrv['ai_coin_change'],
                            'final_score' => $igrv['final_score'],
                            'ai_final_score' => $igrv['ai_final_score'],
                            'user_ids' => $user_ids,
                            'pay_user_ids' => $pay_user_ids,
                            'no_user_ids' => $no_user_ids,
                            'pay_bet_score' => $igrv['pay_bet_score'],
                            'pay_coin_change' => $igrv['pay_coin_change'],
                            'no_bet_score' => $igrv['no_bet_score'],
                            'no_coin_change' => $igrv['no_coin_change'],
                        ];

                        $day_game = Db::name('daily_game_indicators')->where('date',$day_date)
                            ->where('game_type',$igrv['game_type'])
                            ->where('table_level',$igrv['table_level'])
                            ->find();
                        if (!empty($day_game)){
                            $datas['game_type'] = $igrv['game_type'];
                            $datas['table_level'] = $igrv['table_level'];
                            Db::name('daily_game_indicators')->where('id',$day_game['id'])->update($datas);
                        }else{
                            $datas['date'] = $day_date;
                            $datas['game_type'] = $igrv['game_type'];
                            $datas['table_level'] = $igrv['table_level'];
                            Db::name('daily_game_indicators')->insert($datas);
                        }

                    }
                }

                return json(['code' => 200,'msg'=>'游戏统计完成','data' => []]);
            }catch (\Exception $exception){
                echo $exception->getMessage();
                Log::error('getGameTable fail==>'.$exception->getMessage());
                return json(['code' => 201,'msg'=>'游戏统计失败','data' => []]);
            }
        }
    }

    /**
     * 三方游戏人数前10游戏统计
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function gameTop()
    {
        set_time_limit(0);
        ini_set('memory_limit','1024M');
        $date = date('Ymd',strtotime("-1 day"));
        $time = time();
        $day_date = date('Y-m-d',strtotime("-1 day"));
        //$day_date = date('Y-m-d');
        /*$day_time = strtotime(date('Y-m-d 00:00:00'));//印度今日凌晨12点时间戳
        if ($time >= $day_time && $time < $day_time+120){
            $date = date('Ymd',strtotime('-1 day'));
            $day_date = date('Y-m-d',strtotime('-1 day'));
        }*/

        $slots_name = "slots_log_".$date;
        $slotsTable = Db::query('SHOW TABLES LIKE '."'br_".$slots_name."'");
        if($slotsTable){
            $slots_log = Db::name($slots_name)
                ->where('is_settlement',1)
                ->where('terrace_name','<>','zy')
                ->field('terrace_name,slotsgameid,englishname,COUNT(*) AS game_count,sum(cashBetAmount) as cashBetAmount,
                sum(bonusBetAmount) as bonusBetAmount,sum(cashWinAmount) as cashWinAmount,sum(bonusWinAmount) as bonusWinAmount,COUNT(DISTINCT uid) AS user_count,GROUP_CONCAT(DISTINCT uid) as user_ids')//
                ->group('slotsgameid,terrace_name')
                ->order('user_count','desc')
                ->order('cashBetAmount','desc')
                // ->select()->toArray();
                ->cursor();
// dd($slots_log);
                /*$slots_log = Db::name($slots_name)
                ->where('is_settlement',1)
                ->where('terrace_name','<>','zy')
                ->field('terrace_name,slotsgameid,englishname,COUNT(*) AS game_count,sum(cashBetAmount) as cashBetAmount,
                sum(bonusBetAmount) as bonusBetAmount,sum(cashWinAmount) as cashWinAmount,sum(bonusWinAmount) as bonusWinAmount')//,GROUP_CONCAT(DISTINCT uid) as user_ids  COUNT(DISTINCT uid) AS user_count,
                ->group('slotsgameid,terrace_name')
                ->order('user_count','desc')
                ->order('cashBetAmount','desc')
                ->chunk(1000, function($logs) {
                    foreach ($logs as $log) {
                        dd($log);
                        return false;
                    }
                });
                dd(1233);*/

            $slotsData = [];
            if (!empty($slots_log)) {
                foreach ($slots_log as $v) {
                    if (isset($slotsData[$v['terrace_name']])) {
                        if (count($slotsData[$v['terrace_name']]) <= 10) {
                            $slotsData[$v['terrace_name']][] = $v;
                        }
                    } else {
                        $slotsData[$v['terrace_name']][] = $v;
                    }
                }
//dd($slotsData);
                $indata = [];
                foreach ($slotsData as $v2){
                    foreach ($v2 as $v22) {
                        $indata[] = [
                            'date' => $day_date,
                            'update_time' => $time,
                            'terrace_name' => $v22['terrace_name'],
                            'englishname' => $v22['englishname'],
                            'slotsgameid' => $v22['slotsgameid'],
                            'user_count' => $v22['user_count'],
                            'user_ids' => $v22['user_ids'],
                            'game_count' => $v22['game_count'],
                            'service_score' => 0,
                            'bet_score' => $v22['cashBetAmount'] + $v22['bonusBetAmount'],
                            'coin_change' => $v22['cashWinAmount'] + $v22['bonusWinAmount'],
                            'final_score' => ($v22['cashWinAmount'] + $v22['bonusWinAmount']) - ($v22['cashBetAmount'] + $v22['bonusBetAmount']),
                        ];
                    }
                }
            }

        }

        try {
            if (!empty($indata)){
                Db::startTrans();

                Db::name('daily_game_top')->where('date',$day_date)->delete();

                $res = Db::name('daily_game_top')->insertAll($indata);
                if (!$res){
                    Db::rollback();
                    Log::error('gameTop fail==>插入失败');
                    return json(['code' => 200,'msg'=>'统计失败','data' => []]);
                }

                Db::commit();

                return json(['code' => 200,'msg'=>'游戏统计完成','data' => []]);
            }else{
                return json(['code' => 200,'msg'=>'无数据','data' => []]);
            }

        }catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error('gameTop fail==>'.$exception->getMessage());
            return json(['code' => 201,'msg'=>'游戏统计失败','data' => []]);
        }

    }

    /**
     * 发送每日统计数据到TG群
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function dayDataSend(){
        $day = date('Ymd');
        $time = time();
        $day_time = strtotime(date('Y-m-d 00:00:00'));//印度今日凌晨12点时间戳
        if ($time > $day_time && $time < $day_time+600){
            $date = date('Y-m-d',strtotime('-1 day'));
            $day = date('Ymd',strtotime('-1 day'));
        }else{
            $date = date('Y-m-d');
        }

        $share_register_zs = 0;
        $share_pay_zs = 0;
        $rotary_num = [];
        $rotary_count = 0;
        $rotary_bonus_money = 0;
        $rotary_cash_money = 0;
        $card_give_cash = 0;
        $card_give_bonus = 0;
        $month_card_give_cash = 0;
        $month_card_give_bonus = 0;
        //coin
        $coin = Db::name('coin_'.$day)->whereIn('reason',[44,45,52,50,58,57])->select()->toArray();
        if (!empty($coin)){
            foreach ($coin as $key=>$value){
                if ($value['reason'] == 44){
                    $share_register_zs += $value['num'];
                }elseif ($value['reason'] == 45){
                    $share_pay_zs += $value['num'];
                }elseif ($value['reason'] == 52){
                    $rotary_num[$value['uid']] = true;
                    $rotary_count += 1;
                    $rotary_cash_money += $value['num'];
                }elseif (in_array($value['reason'],[50,58])){
                    $card_give_cash += $value['num'];
                }elseif ($value['reason'] == 57){
                    $month_card_give_cash += $value['num'];
                }
            }
        }


        //充值赠送
        $order_give_bonus = 0;
        $order_give_cash = 0;
        $order = Db::name('order')->whereDay('createtime',$date)->where('pay_status',1)->where('active_id',0)->select()->toArray();
        if (!empty($order)){
            foreach ($order as $ork=>$orv){
                $order_give_bonus += $orv['zs_bonus'];
                $order_give_cash += $orv['zs_money'];
            }
        }

        //商城
        $new_num_shop = [];
        $new_money_shop = 0;
        $new_give_cash_shop = 0;
        $new_give_bonus_shop = 0;
        $bankruptcy_num_shop = [];
        $bankruptcy_money_shop = 0;
        $bankruptcy_give_cash_shop = 0;
        $bankruptcy_give_bonus_shop = 0;
        $deposit_num_shop = [];
        $deposit_money_shop = 0;
        $deposit_give_cash_shop = 0;
        $deposit_give_bonus_shop = 0;
        $shop_log = Db::name('shop_log')->alias('a')->whereDay('a.createtime',$date)->whereIn('type',[6,7,10])
            ->field('a.type,a.money,a.zs_money,a.uid,a.zs_bonus as bonus')->select()->toArray();
        if (!empty($shop_log)){
            foreach ($shop_log as $slk=>$slv){
                if ($slv['type'] == 6){
                    $bankruptcy_num_shop[$slv['uid']] = true;
                    $bankruptcy_money_shop += $slv['money'];
                    $bankruptcy_give_cash_shop += $slv['zs_money'];
                    $bankruptcy_give_bonus_shop += $slv['bonus'];
                }elseif ($slv['type'] == 7){
                    $deposit_num_shop[$slv['uid']] = true;
                    $deposit_money_shop += $slv['money'];
                    $deposit_give_cash_shop += $slv['zs_money'];
                    $deposit_give_bonus_shop += $slv['bonus'];
                }elseif ($slv['type'] == 10){
                    $new_num_shop[$slv['uid']] = true;
                    $new_money_shop += $slv['money'];
                    $new_give_cash_shop += $slv['zs_money'];
                    $new_give_bonus_shop += $slv['bonus'];
                }
            }
        }

        $day_data = Db::name('day_data')->where('date',$date)->where('channel',0)->where('package_id',0)->find();

        $whereIn = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
        $day_gamedata = Db::name('daily_game_indicators')
            ->field("sum(user_count) as user_count,sum(game_count) as game_count,sum(service_score) as service_score,sum(income) as income,
        sum(bet_score) as bet_score,sum(ai_bet_score) as ai_bet_score,sum(coin_change) as coin_change,sum(ai_coin_change) as ai_coin_change,
        sum(final_score) as final_score,sum(ai_final_score) as ai_final_score,GROUP_CONCAT(NULLIF(COALESCE(pay_user_ids,''),'')) as pay_user_ids,
        GROUP_CONCAT(NULLIF(COALESCE(user_ids,''),'')) as user_ids")
            ->whereIn('game_type',$whereIn)
            ->where('date',$date)
            ->find();
        $user_ids = explode(',',$day_gamedata['user_ids']);
        $user_ids = array_unique($user_ids);
        $user_count = count($user_ids);
        unset($user_ids);

        $day_game_service_score = Db::name('daily_game_indicators')
            ->field("sum(service_score) as service_score")
            ->whereNotIn('game_type',$whereIn)
            ->where('date',$date)
            ->find();
        $self_game_profit = $day_gamedata['bet_score'] - $day_gamedata['coin_change'] + $day_game_service_score['service_score'];

        if (!empty($day_data)){
            $text = '注册人数：'.$day_data['regist_num'].'人
注册游戏率：'.($day_data['true_regist_num'] ? round(bcdiv($day_data['true_game_num'],$day_data['true_regist_num'],4)*100,2) : 0).'%
充值人数：'.$day_data['recharge_num'].'人
充值成功人数：'.$day_data['recharge_suc_num'].'人
退款人数：'.$day_data['withdraw_suc_num'].'人
充值成功订单数：'.$day_data['recharge_suc_count'].'笔
充值订单成功率：'.$day_data['recharge_suc_rate'].'%
新充值人数：'.$day_data['new_recharge_num'].'人
新充值成功人数：'.$day_data['new_recharge_suc_num'].'人
新退款人数：'.$day_data['new_withdraw_num'].'人
新充值成功订单数：'.$day_data['new_recharge_suc_count'].'笔
新充值订单成功率：'.$day_data['new_recharge_suc_rate'].'%
老充值人数：'.$day_data['old_recharge_num'].'人
老充值成功人数：'.($day_data['recharge_suc_num']-$day_data['new_recharge_suc_num']).'人
老退款人数：'.($day_data['withdraw_num']-$day_data['new_withdraw_num']).'人

总充值：'.($day_data['recharge_money']/100).'卢比
新充值：'.($day_data['new_recharge_money']/100).'卢比
老充值：'.($day_data['old_recharge_money']/100).'卢比
退款金额：'.($day_data['withdraw_money']/100).'卢比
新用户退款金额：'.($day_data['new_withdraw_money']/100).'卢比
老用户退款金额：'.(($day_data['withdraw_money']-$day_data['new_withdraw_money'])/100).'卢比
充提差：'.($day_data['recharge_withdraw_dif']/100).'卢比
退款率：'.$day_data['withdraw_rate'].'%
渠道成本：'.(($day_data['fee_money']+$day_data['withdraw_fee_money'])/100).'卢比
毛利：'.($day_data['profit']/100).'卢比
毛利率：'.($day_data['recharge_money'] ? round(bcdiv($day_data['profit'],$day_data['recharge_money'],4)*100,2) : 0).'%
退款订单成功率：'.$day_data['withdraw_suc_rate'].'%
退款未审核金额：'.($day_data['withdraw_review_money']/100).'卢比
退款未审核订单数：'.$day_data['withdraw_review_count'].'笔

游戏投注人数：'.$user_count.'人
投注金额：'.($day_gamedata['bet_score']/100).'卢比
返奖金额：'.($day_gamedata['coin_change']/100).'卢比
返奖率：'.($day_gamedata['bet_score'] > 0 ? bcdiv($day_gamedata['coin_change'],$day_gamedata['bet_score'],4)*100 : 0).'%
游戏利润：'.($self_game_profit/100).'卢比
税收：'.($day_game_service_score['service_score']/100).'卢比

推广人数：'.$day_data['popularize_num'].'人
充值赠送bonus：'.($order_give_bonus/100).'卢比
充值赠送cash：'.($order_give_cash/100).'卢比

参与首充商城人数：'.count($new_num_shop).'人
首充商城充值金额：'.($new_money_shop/100).'卢比
首充商城赠送bonus：'.($new_give_bonus_shop/100).'卢比
首充商城赠送cash：'.($new_give_cash_shop/100).'卢比';

            /*有效推广人数：'.$day_data['popularize_valid_num'].'人
推广注册赠送金额：'.($share_register_zs/100).'卢比
推广充值赠送金额：'.($share_pay_zs/100).'卢比
            游戏投注人数：'.$day_data['self_game_num'].'人
投注金额：'.($day_data['self_game_betting_money']/100).'卢比
返奖金额：'.($day_data['self_game_award_money']/100).'卢比
返奖率：'.$day_data['self_game_award_rate'].'%
游戏利润：'.($day_data['self_game_profit']/100).'卢比
税收：'.($day_data['total_service_score']/100).'卢比
            */

            try {
                //TelegramService::send(-915404148,$text);
                TelegramService::send(-1002190552719,$text);
                return json(['code' => 200,'msg'=>'发送完成','data' => []]);
            }catch (\Exception $exception){
                echo $exception->getMessage();
                Log::error('dayDataSend fail==>'.$exception->getMessage());
                return json(['code' => 201,'msg'=>'发送失败','data' => []]);
            }
        }
        //var_dump($day_data);exit;
    }


    /**
     * 待审核发生群
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function withdrawAudit()
    {
        $list = Db::name('withdraw_log')->where('status',3)->where('is_statistics',0)->select()->toArray();
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                TelegramService::withdrawRisk($v);

                Db::name('withdraw_log')->where('id',$v['id'])->update(['is_statistics'=>1]);
            }
            return json(['code' => 200,'msg'=>'发送完成','data' => []]);
        }
    }

    /**
     * 提现失败发群
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function withdrawFai()
    {
        $list = Db::name('withdraw_log')
            ->alias('a')
            ->leftJoin('withdraw_logcenter b','a.id = b.withdraw_id')
            ->where('status',2)->where('is_statistics','<>',2)->select()->toArray();
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                TelegramService::withdrawFail($v, json_decode($v['log_error'],true));

                Db::name('withdraw_log')->where('id',$v['id'])->update(['is_statistics'=>2]);
            }
            return json(['code' => 200,'msg'=>'发送完成','data' => []]);
        }
    }

    /**
     * 支付成功率发群
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function orderSucRate(){
        $text = getPayData();
        $text2 = getWithData();
        //var_dump($text);exit;
        try {
            //TelegramService::send(-915404148,$text);
            TelegramService::send(-1002246328061,$text);
            TelegramService::send(-1002246328061,$text2);
        }catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error('dayDataSend fail==>'.$exception->getMessage());
        }
        return json(['code' => 200,'msg'=>'支付订单统计发送完成','data' => []]);
    }

    /**
     * 支付成功率发群2
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function orderSucRateNew(){
        $text = getPayData(10);
        $text2 = getWithData(10);
        //var_dump($text);exit;
        try {
            //TelegramService::send(-915404148,$text);
            TelegramService::send(-1002475841763,$text);
            TelegramService::send(-1002475841763,$text2);
        }catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error('dayDataSend fail==>'.$exception->getMessage());
        }
        return json(['code' => 200,'msg'=>'支付订单统计发送完成','data' => []]);
    }


    /**
     * 清空redis在线人数
     * @return \think\response\Json
     * @throws \RedisException
     */
    public function delOnlineUser(){
        $redis = new \Redis();
        $redis->connect(Config::get('redis.ip'), 5511);
        //$online_user = $redis->sMembers('online_user');
        $online_user = $redis->del('online_user');
        if ($online_user) {
            return json(['code' => 200, 'msg' => '清除在线用户成功', 'data' => []]);
        }else{
            return json(['code' => 200, 'msg' => '没清除在线用户', 'data' => []]);
        }
    }

    public function rechargeSuc()
    {
//        $redis = new \Redis();
//        $redis->connect(Config::get('redis.ip'), 5502);
        //$time = $redis->get('order_send_time');
        //$time = $time ?: 0;
        $time = time()-120;

        $list = Db::name('order')
            ->where('pay_status',1)->where('createtime','>',$time)->select()->toArray();

        if (!empty($list)) {
            foreach ($list as $k => $v) {
                TelegramService::rechargeSuc($v);
            }
            //$redis->set('order_send_time',time());
            return json(['code' => 200,'msg'=>'发送完成','data' => []]);
        }
    }

    public function orderMoneyStatistics()
    {
        $day = date('Ymd');
        $date = date('Y-m-d');
        //$day = '20240628';
        //$date = '2024-06-28';
        $date_s = strtotime($date);
        $date_e = strtotime($date) + 86400;
        $time = time();
        $day_time = strtotime(date('Y-m-d 00:00:00'));//印度今日凌晨12点时间戳
        if (($time >= $day_time && $time < $day_time+120) || ($time >= $day_time+25200 && $time < $day_time+27000)){
            $date = date('Y-m-d',strtotime('-1 day'));
            $day = date('Ymd',strtotime('-1 day'));
            $date_s = strtotime($date);
            $date_e = strtotime($date) + 86400;
            $day_time = $date_s;
        }

        $data = [];
        $order = Db::name('order')->where('pay_status',1)->whereDay('createtime',$date)->select()->toArray();
        if (!empty($order)) {
            foreach ($order as $k => $v) {
                if (isset($data[$v['package_id'].$v['channel']])){
                    $data[$v['package_id'].$v['channel']]['all_money'] += $v['price'];
                    $data[$v['package_id'].$v['channel']]['all_count'] += 1;

                }else{
                    $data[$v['package_id'].$v['channel']] = [
                        'date' => $date,
                        'package_id' => $v['package_id'],
                        'channel' => $v['channel'],
                        'all_money' => $v['price'],
                        'all_count' => 1,
                        'm100' => 0,
                        'm300' => 0,
                        'm500' => 0,
                        'm1000' => 0,
                        'm3000' => 0,
                        'm5000' => 0,
                        'm10000' => 0,
                        'm20000' => 0,
                        'm49999' => 0,
                        'c100' => 0,
                        'c300' => 0,
                        'c500' => 0,
                        'c1000' => 0,
                        'c3000' => 0,
                        'c5000' => 0,
                        'c10000' => 0,
                        'c20000' => 0,
                        'c49999' => 0,
                    ];
                }
                switch ($v['price']){
                    case 10000:
                        $data[$v['package_id'].$v['channel']]['m100'] += $v['price'];
                        $data[$v['package_id'].$v['channel']]['c100'] += 1;
                        break;
                    case 30000:
                        $data[$v['package_id'].$v['channel']]['m300'] += $v['price'];
                        $data[$v['package_id'].$v['channel']]['c300'] += 1;
                        break;
                    case 50000:
                        $data[$v['package_id'].$v['channel']]['m500'] += $v['price'];
                        $data[$v['package_id'].$v['channel']]['c500'] += 1;
                        break;
                    case 100000:
                        $data[$v['package_id'].$v['channel']]['m1000'] += $v['price'];
                        $data[$v['package_id'].$v['channel']]['c1000'] += 1;
                        break;
                    case 300000:
                        $data[$v['package_id'].$v['channel']]['m3000'] += $v['price'];
                        $data[$v['package_id'].$v['channel']]['c3000'] += 1;
                        break;
                    case 500000:
                        $data[$v['package_id'].$v['channel']]['m5000'] += $v['price'];
                        $data[$v['package_id'].$v['channel']]['c5000'] += 1;
                        break;
                    case 1000000:
                        $data[$v['package_id'].$v['channel']]['m10000'] += $v['price'];
                        $data[$v['package_id'].$v['channel']]['c10000'] += 1;
                        break;
                    case 2000000:
                        $data[$v['package_id'].$v['channel']]['m20000'] += $v['price'];
                        $data[$v['package_id'].$v['channel']]['c20000'] += 1;
                        break;
                    case 4999900:
                        $data[$v['package_id'].$v['channel']]['m49999'] += $v['price'];
                        $data[$v['package_id'].$v['channel']]['c49999'] += 1;
                        break;
                    default:
                        break;
                }

            }
        }

        if (!empty($data)) {
            foreach ($data as $dk => $dv) {
                $day_order = Db::name('day_order')->where('date',$date)->where(['package_id'=>$dv['package_id'],'channel'=>$dv['channel']])->find();
                if ($day_order) {
                    Db::name('day_order')->where('id',$day_order['id'])->update($dv);
                }else{
                    Db::name('day_order')->insert($dv);
                }
            }

            return json(['code' => 200, 'msg' => '统计成功', 'data' => []]);
        }else{
            return json(['code' => 200, 'msg' => '无数据', 'data' => []]);
        }

    }

    /**
     * bonus转化赠送统计
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function bonusCash()
    {
        ini_set('memory_limit','512M');
        $day = date('Ymd');
        $date = date('Y-m-d');
        // $day = '20240811';
        // $date = '2024-08-11';
        $date_s = strtotime($date);
        $date_e = strtotime($date) + 86400;
        $time = time();
        $day_time = strtotime(date('Y-m-d 00:00:00'));//印度今日凌晨12点时间戳
        if (($time >= $day_time && $time < $day_time+120) || ($time >= $day_time+25200 && $time < $day_time+27000)){
            $date = date('Y-m-d',strtotime('-1 day'));
            $day = date('Ymd',strtotime('-1 day'));
            $date_s = strtotime($date);
            $date_e = strtotime($date) + 86400;
            $day_time = $date_s;
        }

        $data = [];
        $order = Db::name('order')->where('pay_status',1)->whereDay('createtime',$date)
            ->field('package_id,channel,price')
            ->select()->toArray();

        if (!empty($order)) {
            foreach ($order as $ordk => $ordv) {
                if (isset($data[$ordv['package_id'].$ordv['channel']])){
                    $data[$ordv['package_id'].$ordv['channel']]['recharge_money'] += $ordv['price'];

                }else{
                    $data[$ordv['package_id'].$ordv['channel']]['recharge_money'] = $ordv['price'];
                    $data[$ordv['package_id'].$ordv['channel']]['package_id'] = $ordv['package_id'];
                    $data[$ordv['package_id'].$ordv['channel']]['channel'] = $ordv['channel'];
                }
            }
        }

        $zs_reason = Config::get('reason.zs_reason');
        $zs_reason = array_keys($zs_reason);
        $bonus = Db::name('bonus_'.$day)->whereIn('reason',$zs_reason)->field('package_id,channel,num,uid')->cursor();
        if (!empty($bonus)) {
            foreach ($bonus as $bok => $bov) {
                if (isset($data[$bov['package_id'].$bov['channel']]['give_bonus'])){
                    $data[$bov['package_id'].$bov['channel']]['give_bonus'] += $bov['num'];

                }else{
                    $data[$bov['package_id'].$bov['channel']]['give_bonus'] = $bov['num'];
                    $data[$bov['package_id'].$bov['channel']]['package_id'] = $bov['package_id'];
                    $data[$bov['package_id'].$bov['channel']]['channel'] = $bov['channel'];
                }
                $data[$bov['package_id'].$bov['channel']]['give_bonus_users'][] = $bov['uid'];
            }
        }

        $bonus_win = Db::name('bonus_'.$day)->where('reason',3)->field('package_id,channel,num,uid')->cursor();
        if (!empty($bonus_win)) {
            foreach ($bonus_win as $bwk => $bwv) {
                if ($bwv['num'] > 0) {
                    if (isset($data[$bwv['package_id'] . $bwv['channel']]['bonus_win'])) {
                        $data[$bwv['package_id'] . $bwv['channel']]['bonus_win'] += $bwv['num'];

                    } else {
                        $data[$bwv['package_id'] . $bwv['channel']]['bonus_win'] = $bwv['num'];
                        $data[$bwv['package_id'] . $bwv['channel']]['package_id'] = $bwv['package_id'];
                        $data[$bwv['package_id'] . $bwv['channel']]['channel'] = $bwv['channel'];

                    }
                }

                if ($bwv['num'] < 0) {
                    if (isset($data[$bwv['package_id'] . $bwv['channel']]['bonus_losing'])) {
                        $data[$bwv['package_id'] . $bwv['channel']]['bonus_losing'] += $bwv['num'];

                    } else {
                        $data[$bwv['package_id'] . $bwv['channel']]['bonus_losing'] = $bwv['num'];
                        $data[$bwv['package_id'] . $bwv['channel']]['package_id'] = $bwv['package_id'];
                        $data[$bwv['package_id'] . $bwv['channel']]['channel'] = $bwv['channel'];

                    }
                }


            }
        }

        $cash = Db::name('coin_'.$day)->whereIn('reason',$zs_reason)->field('package_id,channel,num,uid')->cursor();
        if (!empty($cash)) {
            foreach ($cash as $ck => $cv) {
                if (isset($data[$cv['package_id'].$cv['channel']]['give_cash'])){
                    $data[$cv['package_id'].$cv['channel']]['give_cash'] += $cv['num'];

                }else{
                    $data[$cv['package_id'].$cv['channel']]['give_cash'] = $cv['num'];
                    $data[$cv['package_id'].$cv['channel']]['package_id'] = $cv['package_id'];
                    $data[$cv['package_id'].$cv['channel']]['channel'] = $cv['channel'];
                }
                $data[$cv['package_id'].$cv['channel']]['give_cash_users'][] = $cv['uid'];
            }
        }

        $user_day = Db::name('user_day_'.$day)->select()->toArray();
        if (!empty($user_day)) {
            foreach ($user_day as $udk => $udv) {
                if (isset($data[$udv['package_id'].$udv['channel']]['cash_water'])){
                    $data[$udv['package_id'].$udv['channel']]['cash_water'] += $udv['total_cash_water_score'];
                    $data[$udv['package_id'].$udv['channel']]['bonus_water'] += $udv['total_bonus_water_score'];

                    if ($udv['total_cash_water_score'] > 0 || $udv['total_bonus_water_score'] > 0) {
                        if (!empty($data[$udv['package_id'] . $udv['channel']]['bet_users'])) {
                            $data[$udv['package_id'] . $udv['channel']]['bet_users'] .= ','.$udv['uid'];
                        } else {
                            $data[$udv['package_id'] . $udv['channel']]['bet_users'] = $udv['uid'];
                        }
                    }

                }else{
                    $data[$udv['package_id'].$udv['channel']]['cash_water'] = $udv['total_cash_water_score'];
                    $data[$udv['package_id'].$udv['channel']]['bonus_water'] = $udv['total_bonus_water_score'];
                    $data[$udv['package_id'].$udv['channel']]['package_id'] = $udv['package_id'];
                    $data[$udv['package_id'].$udv['channel']]['channel'] = $udv['channel'];

                    if ($udv['total_cash_water_score'] > 0 || $udv['total_bonus_water_score'] > 0) {
                        $data[$udv['package_id'] . $udv['channel']]['bet_users'] = $udv['uid'];
                    }
                }

            }
        }

        $login = Db::name('login_'.$day)->select()->toArray();
        if (!empty($login)){
            foreach ($login as $lk=>$lv){
                if (isset($data[$lv['package_id'].$lv['channel']]['login_users']) && !empty($data[$lv['package_id'] . $lv['channel']]['login_users'])){
                    $data[$lv['package_id'] . $lv['channel']]['login_users'] .= ','.$lv['uid'];
                }else{
                    $data[$lv['package_id'].$lv['channel']]['login_users'] = $lv['uid'];
                    $data[$lv['package_id'].$lv['channel']]['package_id'] = $lv['package_id'];
                    $data[$lv['package_id'].$lv['channel']]['channel'] = $lv['channel'];
                }
            }
        }

        $bonus_cash = Db::name('coin_'.$day)->where('reason',10)->field('package_id,channel,num,uid')->cursor();
        if (!empty($bonus_cash)) {
            foreach ($bonus_cash as $cbk => $cbv) {
                if (isset($data[$cbv['package_id'].$cbv['channel']]['bonus_cash_transition'])){
                    $data[$cbv['package_id'].$cbv['channel']]['bonus_cash_transition'] += $cbv['num'];
                }else{
                    $data[$cbv['package_id'].$cbv['channel']]['bonus_cash_transition'] = $cbv['num'];
                    $data[$cbv['package_id'].$cbv['channel']]['package_id'] = $cbv['package_id'];
                    $data[$cbv['package_id'].$cbv['channel']]['channel'] = $cbv['channel'];
                }
                $data[$cbv['package_id'].$cbv['channel']]['bonus_transition_users'][] = $cbv['uid'];
            }
        }

        if (!empty($data)){
            foreach ($data as $dk => &$dv) {
                if (isset($dv['give_bonus_users']) && !empty($dv['give_bonus_users'])) {
                    $give_bonus_users = array_unique($dv['give_bonus_users']);
                    $dv['give_bonus_users'] = implode(',', $give_bonus_users);

                    $dv['balance_bonus'] = Db::name('userinfo')->whereIn('uid',$dv['give_bonus_users'])->SUM('bonus');
                }
                if (isset($dv['give_cash_users']) && !empty($dv['give_cash_users'])) {
                    $give_cash_users = array_unique($dv['give_cash_users']);
                    $dv['give_cash_users'] = implode(',', $give_cash_users);
                }
                if (isset($dv['bonus_transition_users']) && !empty($dv['bonus_transition_users'])) {
                    $bonus_transition_users = array_unique($dv['bonus_transition_users']);
                    $dv['bonus_transition_users'] = implode(',', $bonus_transition_users);
                }

                $dv['date'] = $date;
                $recharge_money = isset($dv['recharge_money']) ? $dv['recharge_money'] : 0;
                $give_cash = isset($dv['give_cash']) ? $dv['give_cash'] : 0;
                $give_bonus = isset($dv['give_bonus']) ? $dv['give_bonus'] : 0;
                $cash_water = isset($dv['cash_water']) ? $dv['cash_water'] : 0;
                $bonus_water = isset($dv['bonus_water']) ? $dv['bonus_water'] : 0;
                $bonus_cash_transition = isset($dv['bonus_cash_transition']) ? $dv['bonus_cash_transition'] : 0;

                $dv['cash_water_multiple'] = ($recharge_money + $give_cash) > 0 ? bcdiv($cash_water,($recharge_money + $give_cash),2) : 0;
                $dv['bonus_water_multiple'] = $give_bonus > 0 ? bcdiv($bonus_water, $give_bonus, 2) : 0;
                $dv['bonus_transition_bill'] = $give_bonus > 0 ? bcmul(bcdiv($bonus_cash_transition, $give_bonus, 4),100,2) : 0;

                $daily_bonus = Db::name('daily_bonus')->where('date',$date)->where(['package_id'=>$dv['package_id'],'channel'=>$dv['channel']])->find();
                if ($daily_bonus) {
                    Db::name('daily_bonus')->where('id',$daily_bonus['id'])->update($dv);
                }else{
                    Db::name('daily_bonus')->insert($dv);
                }
            }

            return json(['code' => 200, 'msg' => '统计成功', 'data' => []]);
        }else{
            return json(['code' => 200, 'msg' => '无数据', 'data' => []]);
        }

    }


    /**
     * 新用户首充时间统计
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function orderFirstTime()
    {
        $day = date('Ymd');
        $date = date('Y-m-d');
        //$day = '20240628';
        //$date = '2024-06-28';
        $date_s = strtotime($date);
        $date_e = strtotime($date) + 86400;
        $time = time();
        $day_time = strtotime(date('Y-m-d 00:00:00'));//印度今日凌晨12点时间戳
        if ($time >= $day_time && $time < $day_time+120){
            $date = date('Y-m-d',strtotime('-1 day'));
            $day = date('Ymd',strtotime('-1 day'));
            $date_s = strtotime($date);
            $date_e = strtotime($date) + 86400;
            $day_time = $date_s;
        }

        $data = [];
        $order = Db::name('order')
            ->alias('a')
            ->leftJoin('userinfo b','a.uid=b.uid')
            ->where('pay_status',1)
            ->where('is_first',1)
            ->whereDay('regist_time',$date)
            ->field('a.price,a.finishtime,a.package_id,a.channel,b.regist_time')
            ->select()->toArray();
        if (!empty($order)) {
            foreach ($order as $k => $v) {
                if (isset($data[$v['package_id'].$v['channel']])){
                    $data[$v['package_id'].$v['channel']]['all_money'] += $v['price'];
                    $data[$v['package_id'].$v['channel']]['all_num'] += 1;

                }else{
                    $data[$v['package_id'].$v['channel']] = [
                        'date' => $date,
                        'package_id' => $v['package_id'],
                        'channel' => $v['channel'],
                        'all_money' => $v['price'],
                        'all_num' => 1,
                        'n10' => 0,
                        'n20' => 0,
                        'n30' => 0,
                        'n60' => 0,
                        'n120' => 0,
                        'n720' => 0,
                        'n1440' => 0,
                    ];
                }

                $use_time = bcdiv($v['finishtime'] - $v['regist_time'], 60, 2);//分钟
                if ($use_time <= 10){
                    $data[$v['package_id'].$v['channel']]['n10'] += 1;
                }elseif (10 < $use_time && $use_time <= 20){
                    $data[$v['package_id'].$v['channel']]['n20'] += 1;
                }elseif (20 < $use_time && $use_time <= 30){
                    $data[$v['package_id'].$v['channel']]['n30'] += 1;
                }elseif (30 < $use_time && $use_time <= 60){
                    $data[$v['package_id'].$v['channel']]['n60'] += 1;
                }elseif (60 < $use_time && $use_time <= 120){
                    $data[$v['package_id'].$v['channel']]['n120'] += 1;
                }elseif (120 < $use_time && $use_time <= 720){
                    $data[$v['package_id'].$v['channel']]['n720'] += 1;
                }elseif (720 < $use_time && $use_time <= 1440){
                    $data[$v['package_id'].$v['channel']]['n1440'] += 1;
                }

            }
        }

        if (!empty($data)) {
            foreach ($data as $dk => $dv) {
                $day_order = Db::name('day_first')->where('date',$date)->where(['package_id'=>$dv['package_id'],'channel'=>$dv['channel']])->find();
                if ($day_order) {
                    Db::name('day_first')->where('id',$day_order['id'])->update($dv);
                }else{
                    Db::name('day_first')->insert($dv);
                }
            }

            return json(['code' => 200, 'msg' => '统计成功', 'data' => []]);
        }else{
            return json(['code' => 200, 'msg' => '无数据', 'data' => []]);
        }

    }


    /**
     * 统计每日注册人的累计充值退款
     * @return \think\response\Json
     */
    public function setDayData()
    {
        set_time_limit(0);
        ini_set('memory_limit','512M');
        $data_list = Db::name('day_data')
            ->where('date','>','2024-09-15')
            ->where('true_regist_num', '>', 0)
            ->where('package_id', '<>', 0)
            ->where('channel', '<>', 0)
            ->field('true_regist_ids,id')
            ->cursor();
            //->select()->toArray();
        //dd($data_list);

        try {
            if (!empty($data_list)) {
                foreach ($data_list as $k => $v) {
                    $order = Db::name('order')
                        ->whereIn('uid', $v['true_regist_ids'])
                        ->where('pay_status', 1)
                        ->field("IFNULL(SUM(price),0) AS price,IFNULL(SUM(fee_money),0) AS fee_money,GROUP_CONCAT(DISTINCT NULLIF(COALESCE(uid,''),'')) as users")
                        ->find();

                    $withdraw = Db::name('withdraw_log')
                        ->whereIn('uid', $v['true_regist_ids'])
                        ->where('status', 1)
                        ->field("IFNULL(SUM(money),0) AS money,count(*) as new_total_withdraw_count,GROUP_CONCAT(DISTINCT NULLIF(COALESCE(uid,''),'')) as users")
                        ->find();

                    $data = [
                        'new_total_recharge' => $order['price'],
                        'new_total_recharge_users' => $order['users'] ?? '',
                        'new_total_withdraw' => $withdraw['money'],
                        'new_total_withdraw_users' => $withdraw['users'] ?? '',
                        'new_total_recharge_fee' => $order['fee_money'],
                        'new_total_withdraw_count' => $withdraw['new_total_withdraw_count'],
                    ];
                    Db::name('day_data')
                        ->where('id', $v['id'])
                        ->update($data);

                }

                return json(['code' => 200,'msg'=>'每日数据完成','data' => []]);
            }else{
                return json(['code' => 200,'msg'=>'无数据','data' => []]);
            }

        }catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error('setDayData fail==>'.$exception->getMessage());
            return json(['code' => 201,'msg'=>'每日数据失败','data' => []]);
        }

    }

}