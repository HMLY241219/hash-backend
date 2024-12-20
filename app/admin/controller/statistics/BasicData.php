<?php

namespace app\admin\controller\statistics;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use think\facade\Session;

/**
 *  基础数据列表
 */
class BasicData extends AuthController
{

    public function index()
    {
        /*$level = getAdminLevel($this->adminInfo);

        $this->assign('adminInfo', $this->adminInfo);
        $this->assign('adminlevel', $level);*/
        $adminInfo = $this->adminInfo;
        $is_export = Db::name('system_role')->where('id','=',$adminInfo->roles)->value('is_export');
        $defaultToolbar = $is_export == 1 ? ['print', 'exports'] : [];
        $this->assign('defaultToolbar', json_encode($defaultToolbar));
        $this->assign('adminInfo', $adminInfo);
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $tj_type = 0;
        if (isset($data['tj_type'])) {
            $tj_type = $data['tj_type'];
            unset($data['tj_type']);
        }
        //下级筛选
        $level_where = [];
        if (isset($data['channels']) && !empty($data['channels'])){
            $level_where = [['channel', 'in', $data['channels']]];
            unset($data['channels']);
        }

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 200;
        $data['date'] = isset($data['date']) ? $data['date'] : date('Y-m-d',strtotime('00:00:00 -30day')).' - '.date('Y-m-d');
        $where  = Model::getWhere2($data,'date');
        /*$chan_where = [];
        if (empty($this->sqlNewWhere)){
            $chan_where = ['channel'=>0,'package_id'=>0];
        }*/
        $NewWhere = [];
        if (!empty($this->sqlNewWhere)){
            $NewWhere = [$this->sqlNewWhere];
        }

        //平台与渠道
        $channel_where = [];
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$channel_where = [['channel', '<', 100000000]];
            } else {
                $channel_where = [['channel', '>=', 100000000]];
            }
        }

        if (empty($level_where) && empty($channel_where) && empty($NewWhere)){ //无选包等时
            $data['data'] = Db::name('day_data')
                ->field("sum(device_num) as device_num,sum(regist_num) as regist_num,sum(true_regist_num) as true_regist_num,sum(true_game_num) as true_game_num,
                sum(recharge_num) as recharge_num,sum(recharge_suc_num) as recharge_suc_num,sum(new_recharge_num) as new_recharge_num,
                sum(old_recharge_num) as old_recharge_num,sum(recharge_count) as recharge_count,sum(new_recharge_count) as new_recharge_count,
                sum(old_recharge_count) as old_recharge_count,sum(recharge_suc_count) as recharge_suc_count,sum(new_recharge_suc_count) as new_recharge_suc_count,
                sum(old_recharge_suc_count) as old_recharge_suc_count,sum(recharge_suc_rate) as recharge_suc_rate,sum(new_recharge_suc_rate) as new_recharge_suc_rate,
                sum(old_recharge_suc_rate) as old_recharge_suc_rate,sum(recharge_money) as recharge_money,sum(new_recharge_money) as new_recharge_money,
                sum(old_recharge_money) as old_recharge_money,sum(fee_money) as fee_money,sum(self_game_num) as self_game_num,sum(self_game_betting_money) as self_game_betting_money,
                sum(self_game_award_money) as self_game_award_money,sum(self_game_profit) as self_game_profit,
                sum(three_game_num) as three_game_num,sum(three_game_betting_money) as three_game_betting_money,sum(three_game_award_money) as three_game_award_money,
                sum(three_game_award_rate) as three_game_award_rate,sum(three_game_profit) as three_game_profit,sum(withdraw_num) as withdraw_num,sum(new_withdraw_num) as new_withdraw_num,
                sum(withdraw_count) as withdraw_count,sum(withdraw_auto_count) as withdraw_auto_count,sum(withdraw_review_count) as withdraw_review_count,
                sum(withdraw_suc_count) as withdraw_suc_count,sum(withdraw_money) as withdraw_money,sum(recharge_withdraw_dif) as recharge_withdraw_dif,
                sum(profit) as profit,sum(regist_award_money) as regist_award_money,sum(tpc_unlock_money) as tpc_unlock_money,sum(tpc_withdraw_money) as tpc_withdraw_money,
                sum(back_water_num) as back_water_num,sum(back_water_money) as back_water_money,sum(back_water_withdraw_balance) as back_water_withdraw_balance,
                sum(popularize_num) as popularize_num,sum(next_to_up_unlock_money) as next_to_up_unlock_money,sum(next_to_up_back_money) as next_to_up_back_money,
                sum(rotary_num) as rotary_num,sum(rotary_count) as rotary_count,sum(rotary_diamond_money) as rotary_diamond_money,sum(rotary_cash_money) as rotary_cash_money,
                sum(max_game_count) as max_game_count,sum(login_count) as login_count,sum(user_day_give) as user_day_give,sum(login_game_count) as login_game_count,
                sum(new_login_count) as new_login_count,sum(new_recharge_suc_num) as new_recharge_suc_num,sum(new_withdraw_money) as new_withdraw_money,
                sum(repurchase_num) as repurchase_num,sum(new_repurchase_num) as new_repurchase_num,sum(new_login_game_count) as new_login_game_count,
                sum(new_withdraw_suc_count) as new_withdraw_suc_count,sum(new_withdraw_count) as new_withdraw_count,sum(withdraw_fai_count) as withdraw_fai_count,
                sum(new_withdraw_fai_count) as new_withdraw_fai_count,sum(first_order_num) as first_order_num,GROUP_CONCAT(NULLIF(COALESCE(new_recharge_suc_users,''),'')) as new_recharge_suc_users,
                id,sum(withdraw_suc_num) as withdraw_suc_num,GROUP_CONCAT(NULLIF(COALESCE(old_recharge_suc_users,''),'')) as old_recharge_suc_users,
                GROUP_CONCAT(NULLIF(COALESCE(new_withdraw_users,''),'')) as new_withdraw_users,GROUP_CONCAT(NULLIF(COALESCE(old_withdraw_users,''),'')) as old_withdraw_users,
                sum(total_service_score) as total_service_score,sum(withdraw_fee_money) as withdraw_fee_money,date,user_type,
                sum(sms_click_num) as sms_click_num,sum(sms_start_num) as sms_start_num")
                ->where($where)
                ->where('package_id',0)
                ->where('channel',0)
                ->group('date')
                ->order('date','desc')
                ->page($page,$limit)
                ->select()
                ->toArray();
            //dd($data['data']);
            $data['count'] = Db::name('day_data')
                ->where($where)
                ->where('package_id',0)
                ->where('channel',0)
                ->group('date')
                ->count();
        }else {
            $data['data'] = Db::name('day_data')
                ->field("sum(device_num) as device_num,sum(regist_num) as regist_num,sum(true_regist_num) as true_regist_num,sum(true_game_num) as true_game_num,
                sum(recharge_num) as recharge_num,sum(recharge_suc_num) as recharge_suc_num,sum(new_recharge_num) as new_recharge_num,
                sum(old_recharge_num) as old_recharge_num,sum(recharge_count) as recharge_count,sum(new_recharge_count) as new_recharge_count,
                sum(old_recharge_count) as old_recharge_count,sum(recharge_suc_count) as recharge_suc_count,sum(new_recharge_suc_count) as new_recharge_suc_count,
                sum(old_recharge_suc_count) as old_recharge_suc_count,sum(recharge_suc_rate) as recharge_suc_rate,sum(new_recharge_suc_rate) as new_recharge_suc_rate,
                sum(old_recharge_suc_rate) as old_recharge_suc_rate,sum(recharge_money) as recharge_money,sum(new_recharge_money) as new_recharge_money,
                sum(old_recharge_money) as old_recharge_money,sum(fee_money) as fee_money,sum(self_game_num) as self_game_num,sum(self_game_betting_money) as self_game_betting_money,
                sum(self_game_award_money) as self_game_award_money,sum(self_game_profit) as self_game_profit,
                sum(three_game_num) as three_game_num,sum(three_game_betting_money) as three_game_betting_money,sum(three_game_award_money) as three_game_award_money,
                sum(three_game_award_rate) as three_game_award_rate,sum(three_game_profit) as three_game_profit,sum(withdraw_num) as withdraw_num,sum(new_withdraw_num) as new_withdraw_num,
                sum(withdraw_count) as withdraw_count,sum(withdraw_auto_count) as withdraw_auto_count,sum(withdraw_review_count) as withdraw_review_count,
                sum(withdraw_suc_count) as withdraw_suc_count,sum(withdraw_money) as withdraw_money,sum(recharge_withdraw_dif) as recharge_withdraw_dif,
                sum(profit) as profit,sum(regist_award_money) as regist_award_money,sum(tpc_unlock_money) as tpc_unlock_money,sum(tpc_withdraw_money) as tpc_withdraw_money,
                sum(back_water_num) as back_water_num,sum(back_water_money) as back_water_money,sum(back_water_withdraw_balance) as back_water_withdraw_balance,
                sum(popularize_num) as popularize_num,sum(next_to_up_unlock_money) as next_to_up_unlock_money,sum(next_to_up_back_money) as next_to_up_back_money,
                sum(rotary_num) as rotary_num,sum(rotary_count) as rotary_count,sum(rotary_diamond_money) as rotary_diamond_money,sum(rotary_cash_money) as rotary_cash_money,
                sum(max_game_count) as max_game_count,sum(login_count) as login_count,sum(user_day_give) as user_day_give,sum(login_game_count) as login_game_count,
                sum(new_login_count) as new_login_count,sum(new_recharge_suc_num) as new_recharge_suc_num,sum(new_withdraw_money) as new_withdraw_money,
                sum(repurchase_num) as repurchase_num,sum(new_repurchase_num) as new_repurchase_num,sum(new_login_game_count) as new_login_game_count,
                sum(new_withdraw_suc_count) as new_withdraw_suc_count,sum(new_withdraw_count) as new_withdraw_count,sum(withdraw_fai_count) as withdraw_fai_count,
                sum(new_withdraw_fai_count) as new_withdraw_fai_count,sum(first_order_num) as first_order_num,GROUP_CONCAT(NULLIF(COALESCE(new_recharge_suc_users,''),'')) as new_recharge_suc_users,
                id,sum(withdraw_suc_num) as withdraw_suc_num,GROUP_CONCAT(NULLIF(COALESCE(old_recharge_suc_users,''),'')) as old_recharge_suc_users,
                GROUP_CONCAT(NULLIF(COALESCE(new_withdraw_users,''),'')) as new_withdraw_users,GROUP_CONCAT(NULLIF(COALESCE(old_withdraw_users,''),'')) as old_withdraw_users,
                sum(total_service_score) as total_service_score,sum(withdraw_fee_money) as withdraw_fee_money,date,user_type,
                sum(sms_click_num) as sms_click_num,sum(sms_start_num) as sms_start_num")
                ->where($where)
                ->where($NewWhere)
                //->where($chan_where)
                ->where('package_id', '<>', 0)
                ->where('channel', '<>', 0)
                ->where($channel_where)
                ->where($level_where)
                ->group('date')
                ->order('date', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            //dd($data['data']);
            $data['count'] = Db::name('day_data')
                ->where($where)
                ->where($NewWhere)
                //->where($chan_where)
                ->where('package_id', '<>', 0)
                ->where('channel', '<>', 0)
                ->where($channel_where)
                ->where($level_where)
                ->group('date')
                ->count();
        }
        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数

        if (!empty($data['data'])){
            foreach ($data['data'] as $fk=>$fv){
                $data['data'][$fk]['self_game_award_rate'] = $fv['self_game_betting_money']>0 ? round(bcdiv($fv['self_game_award_money'],$fv['self_game_betting_money'],4)*100,2) : 0;

                $data['data'][$fk]['recharge_money'] = bcdiv($fv['recharge_money'], $amount_reduction_multiple, 2);
                $data['data'][$fk]['new_recharge_money'] = bcdiv($fv['new_recharge_money'], $amount_reduction_multiple, 2);
                $data['data'][$fk]['old_recharge_money'] = bcdiv($fv['old_recharge_money'], $amount_reduction_multiple, 2);
                $data['data'][$fk]['withdraw_money'] = bcdiv($fv['withdraw_money'], $amount_reduction_multiple, 2);
                $data['data'][$fk]['new_withdraw_money'] = bcdiv($fv['new_withdraw_money'], $amount_reduction_multiple, 2);
                $data['data'][$fk]['fee_money'] = bcdiv($fv['fee_money'], $amount_reduction_multiple, 2);
                $data['data'][$fk]['withdraw_fee_money'] = bcdiv($fv['withdraw_fee_money'], $amount_reduction_multiple, 2);
                $data['data'][$fk]['profit'] = bcdiv($fv['profit'], $amount_reduction_multiple, 2);
            }
        }
        //var_dump($data['data']);exit;
        //合计统计
        if ($tj_type == 1) {
            if (!empty($data['data'])) {
                $new_data = [[
                    'device_num' => 0,
                    'regist_num' => 0,
                    'true_regist_num' => 0,
                    'true_game_num' => 0,
                    'recharge_num' => 0,
                    'recharge_suc_num' => 0,
                    'new_recharge_num' => 0,
                    'old_recharge_num' => 0,
                    'recharge_count' => 0,
                    'new_recharge_count' => 0,
                    'old_recharge_count' => 0,
                    'recharge_suc_count' => 0,
                    'new_recharge_suc_count' => 0,
                    'old_recharge_suc_count' => 0,
                    //'recharge_suc_rate' => 0,
                    //'new_recharge_suc_rate' => 0,
                    //'old_recharge_suc_rate' => 0,
                    'recharge_money' => 0,
                    'new_recharge_money' => 0,
                    'old_recharge_money' => 0,
                    'fee_money' => 0,
                    'self_game_num' => 0,
                    'self_game_betting_money' => 0,
                    'self_game_award_money' => 0,
                    //'self_game_award_rate' => 0,
                    'self_game_profit' => 0,
                    'three_game_num' => 0,
                    'three_game_betting_money' => 0,
                    'three_game_award_money' => 0,
                    //'three_game_award_rate' => 0,
                    'three_game_profit' => 0,
                    'withdraw_num' => 0,
                    'new_withdraw_num' => 0,
                    'withdraw_count' => 0,
                    'withdraw_auto_count' => 0,
                    'withdraw_review_count' => 0,
                    'withdraw_suc_count' => 0,
                    'withdraw_money' => 0,
                    'recharge_withdraw_dif' => 0,
                    'profit' => 0,
                    'regist_award_money' => 0,
                    'tpc_unlock_money' => 0,
                    'tpc_withdraw_money' => 0,
                    'back_water_num' => 0,
                    'back_water_money' => 0,
                    'back_water_withdraw_balance' => 0,
                    'popularize_num' => 0,
                    'next_to_up_unlock_money' => 0,
                    'next_to_up_back_money' => 0,
                    'rotary_num' => 0,
                    'rotary_count' => 0,
                    'rotary_diamond_money' => 0,
                    'rotary_cash_money' => 0,
                    'max_game_count' => 0,
                    'login_count' => 0,
                    'user_day_give' => 0,
                    'login_game_count' => 0,
                    'new_login_count' => 0,
                    'new_recharge_suc_num' => 0,
                    'new_withdraw_money' => 0,
                    'date' => '',

                    'repurchase_num' => 0,
                    'new_repurchase_num' => 0,
                    'new_login_game_count' => 0,
                    'first_order_num' => 0,
                    'withdraw_fai_count' => 0,
                    'new_withdraw_fai_count' => 0,
                    'withdraw_suc_num' => 0,
                    'new_recharge_suc_users' => '',
                    'old_recharge_suc_users' => '',
                    'new_withdraw_users' => '',
                    'old_withdraw_users' => '',

                    'user_count' => 0,
                    'game_count' => 0,
                    'user_count_br' => 0,
                    'game_count_br' => 0,
                    'total_service_score' => 0,
                    'withdraw_fee_money' => 0,
                    'sms_click_num' => 0,
                    'sms_start_num' => 0,
                    'new_withdraw_suc_count' => 0,
                    'withdraw_suc_count' => 0,
                ]];
                foreach ($data['data'] as $dkey => $dvalue) {
                    $new_data[0]['device_num'] += $dvalue['device_num'];
                    $new_data[0]['regist_num'] += $dvalue['regist_num'];
                    $new_data[0]['true_regist_num'] += $dvalue['true_regist_num'];
                    $new_data[0]['true_game_num'] += $dvalue['true_game_num'];
                    $new_data[0]['recharge_num'] += $dvalue['recharge_num'];
                    $new_data[0]['recharge_suc_num'] += $dvalue['recharge_suc_num'];
                    $new_data[0]['new_recharge_num'] += $dvalue['new_recharge_num'];
                    $new_data[0]['old_recharge_num'] += $dvalue['old_recharge_num'];
                    $new_data[0]['recharge_count'] += $dvalue['recharge_count'];
                    $new_data[0]['new_recharge_count'] += $dvalue['new_recharge_count'];
                    $new_data[0]['old_recharge_count'] += $dvalue['old_recharge_count'];
                    $new_data[0]['recharge_suc_count'] += $dvalue['recharge_suc_count'];
                    $new_data[0]['new_recharge_suc_count'] += $dvalue['new_recharge_suc_count'];
                    $new_data[0]['old_recharge_suc_count'] += $dvalue['old_recharge_suc_count'];
                    $new_data[0]['recharge_money'] += $dvalue['recharge_money'];
                    $new_data[0]['new_recharge_money'] += $dvalue['new_recharge_money'];
                    $new_data[0]['old_recharge_money'] += $dvalue['old_recharge_money'];
                    $new_data[0]['fee_money'] += $dvalue['fee_money'];
                    $new_data[0]['self_game_num'] += $dvalue['self_game_num'];
                    $new_data[0]['self_game_betting_money'] += $dvalue['self_game_betting_money'];
                    $new_data[0]['self_game_award_money'] += $dvalue['self_game_award_money'];
                    $new_data[0]['self_game_profit'] += $dvalue['self_game_profit'];
                    $new_data[0]['three_game_num'] += $dvalue['three_game_num'];
                    $new_data[0]['three_game_betting_money'] += $dvalue['three_game_betting_money'];
                    $new_data[0]['three_game_award_money'] += $dvalue['three_game_award_money'];
                    $new_data[0]['three_game_profit'] += $dvalue['three_game_profit'];
                    $new_data[0]['withdraw_num'] += $dvalue['withdraw_num'];
                    $new_data[0]['new_withdraw_num'] += $dvalue['new_withdraw_num'];
                    $new_data[0]['withdraw_count'] += $dvalue['withdraw_count'];
                    $new_data[0]['withdraw_auto_count'] += $dvalue['withdraw_auto_count'];
                    $new_data[0]['withdraw_review_count'] += $dvalue['withdraw_review_count'];
                    $new_data[0]['withdraw_suc_count'] += $dvalue['withdraw_suc_count'];
                    $new_data[0]['new_withdraw_suc_count'] += $dvalue['new_withdraw_suc_count'];
                    $new_data[0]['withdraw_money'] += $dvalue['withdraw_money'];
                    $new_data[0]['recharge_withdraw_dif'] += $dvalue['recharge_withdraw_dif'];
                    $new_data[0]['profit'] += $dvalue['profit'];
                    $new_data[0]['regist_award_money'] += $dvalue['regist_award_money'];
                    $new_data[0]['tpc_unlock_money'] += $dvalue['tpc_unlock_money'];
                    $new_data[0]['tpc_withdraw_money'] += $dvalue['tpc_withdraw_money'];
                    $new_data[0]['back_water_num'] += $dvalue['back_water_num'];
                    $new_data[0]['back_water_money'] += $dvalue['back_water_money'];
                    $new_data[0]['back_water_withdraw_balance'] += $dvalue['back_water_withdraw_balance'];
                    $new_data[0]['popularize_num'] += $dvalue['popularize_num'];
                    $new_data[0]['next_to_up_unlock_money'] += $dvalue['next_to_up_unlock_money'];
                    $new_data[0]['next_to_up_back_money'] += $dvalue['next_to_up_back_money'];
                    $new_data[0]['rotary_num'] += $dvalue['rotary_num'];
                    $new_data[0]['rotary_count'] += $dvalue['rotary_count'];
                    $new_data[0]['rotary_diamond_money'] += $dvalue['rotary_diamond_money'];
                    $new_data[0]['rotary_cash_money'] += $dvalue['rotary_cash_money'];
                    $new_data[0]['max_game_count'] += $dvalue['max_game_count'];
                    $new_data[0]['login_count'] += $dvalue['login_count'];
                    $new_data[0]['user_day_give'] += $dvalue['user_day_give'];
                    $new_data[0]['login_game_count'] += $dvalue['login_game_count'];
                    $new_data[0]['new_login_count'] += $dvalue['new_login_count'];
                    $new_data[0]['new_recharge_suc_num'] += $dvalue['new_recharge_suc_num'];
                    $new_data[0]['new_withdraw_money'] += $dvalue['new_withdraw_money'];

                    $new_data[0]['repurchase_num'] += $dvalue['repurchase_num'];
                    $new_data[0]['new_repurchase_num'] += $dvalue['new_repurchase_num'];
                    $new_data[0]['new_login_game_count'] += $dvalue['new_login_game_count'];
                    $new_data[0]['first_order_num'] += $dvalue['first_order_num'];
                    $new_data[0]['withdraw_fai_count'] += $dvalue['withdraw_fai_count'];
                    $new_data[0]['new_withdraw_fai_count'] += $dvalue['new_withdraw_fai_count'];
                    $new_data[0]['withdraw_suc_num'] += $dvalue['withdraw_suc_num'];
                    if (!empty($dvalue['new_recharge_suc_users'])){
                        $new_data[0]['new_recharge_suc_users'] .= ','.$dvalue['new_recharge_suc_users'];
                    }
                    if (!empty($dvalue['old_recharge_suc_users'])){
                        $new_data[0]['old_recharge_suc_users'] .= ','.$dvalue['old_recharge_suc_users'];
                    }
                    if (!empty($dvalue['new_withdraw_users'])){
                        $new_data[0]['new_withdraw_users'] .= ','.$dvalue['new_withdraw_users'];
                    }
                    if (!empty($dvalue['old_withdraw_users'])){
                        $new_data[0]['old_withdraw_users'] .= ','.$dvalue['old_withdraw_users'];
                    }

                    //$new_data[0]['user_count'] += $dvalue['user_count'];
                    //$new_data[0]['game_count'] += $dvalue['game_count'];
                    //$new_data[0]['user_count_br'] += $dvalue['user_count_br'];
                    //$new_data[0]['game_count_br'] += $dvalue['game_count_br'];
                    $new_data[0]['total_service_score'] += $dvalue['total_service_score'];
                    $new_data[0]['withdraw_fee_money'] += $dvalue['withdraw_fee_money'];
                    $new_data[0]['sms_click_num'] += $dvalue['sms_click_num'];
                    $new_data[0]['sms_start_num'] += $dvalue['sms_start_num'];
                }
                $new_data[0]['date'] = $data['data'][$dkey]['date'].' - '.$data['data'][0]['date'];
                //充值提现人
                if (!empty($new_data[0]['new_recharge_suc_users'])) {
                    $new_data[0]['new_recharge_suc_users'] = substr($new_data[0]['new_recharge_suc_users'],1);
                }
                if (!empty($new_data[0]['old_recharge_suc_users'])) {
                    $new_data[0]['old_recharge_suc_users'] = substr($new_data[0]['old_recharge_suc_users'],1);
                }
                if (!empty($new_data[0]['new_withdraw_users'])) {
                    $new_data[0]['new_withdraw_users'] = substr($new_data[0]['new_withdraw_users'],1);
                }
                if (!empty($new_data[0]['old_withdraw_users'])) {
                    $new_data[0]['old_withdraw_users'] = substr($new_data[0]['old_withdraw_users'],1);
                }
                //返奖率
                $new_data[0]['self_game_award_rate'] = $new_data[0]['self_game_betting_money']>0 ? round(($new_data[0]['self_game_award_money']/$new_data[0]['self_game_betting_money'])*100,2) : 0;
                /*$new_data[0]['per_count'] = $new_data[0]['user_count']&&$new_data[0]['game_count'] ? round(bcdiv($new_data[0]['game_count'],$new_data[0]['user_count'],2),2) : 0;
                $new_data[0]['per_count_br'] = $new_data[0]['user_count_br']&&$new_data[0]['game_count_br'] ? round(bcdiv($new_data[0]['game_count_br'],$new_data[0]['user_count_br'],2),2) : 0;
                $new_data[0]['game_rate_br'] = $new_data[0]['per_count_br']&&$new_data[0]['per_count'] ? round(bcdiv($new_data[0]['per_count_br'],$new_data[0]['per_count'],4)*100,2) : 0;*/
            }

            $data['data'] = $new_data;
            $data['count'] = 1;
        }
        //var_dump($new_data);exit;

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }



    public function edit($id = 0){
        $active = Db::name('active')->where('id',$id)->find();
        if(!$active){
            Json::fail('参数错误!');
        }
        $f[] = Form::input('englishname', '活动名称',$active['englishname']);
        $f[] = Form::input('name', '活动中文名称',$active['name']);
        $f[] = Form::uploadImageOne('banner', '活动图片',url('widget.Image/file',['file'=>'banner']),$active['banner']);
        $f[] = Form::input('weight', '活动权重',$active['weight']);
        if($active['active_num_status'] == 1){
            $f[] = Form::input('active_num', '活动参与次数',$active['active_num']);
        }

        $f[] = Form::radio('is_exclusion', '活动是否互斥', $active['is_exclusion'])->options([['label' => '互斥', 'value' => 1], ['label' => '不互斥', 'value' => 2]]);
        $f[] = Form::input('minmoney', '活动最低存款金额(卢比分/充值金额>=)',$active['minmoney'])->placeholder('要求的最低存款金额');
        //根据活动的不同json配置，自动生成相应的配置页面
        $f = $this->config($f,$active['config']);

        $f[] = Form::textarea('remark', '说明',$active['remark']);
        $f[] = Form::radio('status', '状态', $active['status'])->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);

        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }




}
