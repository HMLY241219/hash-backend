<?php

namespace app\admin\controller\statistics;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use think\facade\Session;

/**
 *  每日投放数据列表
 */
class DailyDelivery extends AuthController
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
        $limit = $data['limit'] ?: 30;
        $data['date'] = isset($data['date']) ? $data['date'] : date('Y-m-d',strtotime('00:00:00 -30day')).' - '.date('Y-m-d');
        $where  = Model::getWhere2($data,'date');
        /*$chan_where = [];
        if (empty($this->sqlNewWhere)){
            $chan_where = ['channel'=>0,'package_id'=>0];
        }*/
        $NewWhere = [];
        if (!empty($this->sqlNewWhere)){
            if ($this->adminId != 40) {
                $NewWhere = [$this->sqlNewWhere];
            }
        }

        //平台与渠道
        $channel_where = [];
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$channel_where = [['channel', '<', 100000000]];
            } else {
                if ($this->adminId != 40) {
                    $channel_where = [['channel', '>=', 100000000]];
                }
            }
        }

        Db::query('SET GLOBAL group_concat_max_len = 1024000');
        Db::query('SET SESSION group_concat_max_len = 1024000');
        if (empty($level_where) && empty($channel_where) && empty($NewWhere)) {
            $data['data'] = Db::name('day_data')
                ->field("sum(device_num) as device_num,sum(regist_num) as regist_num,sum(true_regist_num) as true_regist_num,sum(true_game_num) as true_game_num,
                sum(recharge_num) as recharge_num,sum(recharge_suc_num) as recharge_suc_num,sum(new_recharge_num) as new_recharge_num,
                sum(old_recharge_num) as old_recharge_num,sum(recharge_count) as recharge_count,sum(new_recharge_count) as new_recharge_count,
                sum(old_recharge_count) as old_recharge_count,sum(recharge_suc_count) as recharge_suc_count,sum(new_recharge_suc_count) as new_recharge_suc_count,
                sum(old_recharge_suc_count) as old_recharge_suc_count,sum(recharge_suc_rate) as recharge_suc_rate,sum(new_recharge_suc_rate) as new_recharge_suc_rate,
                sum(old_recharge_suc_rate) as old_recharge_suc_rate,sum(recharge_money) as recharge_money,sum(new_recharge_money) as new_recharge_money,
                sum(old_recharge_money) as old_recharge_money,sum(fee_money) as fee_money,sum(self_game_num) as self_game_num,sum(self_game_betting_money) as self_game_betting_money,
                sum(self_game_award_money) as self_game_award_money,sum(self_game_award_rate) as self_game_award_rate,sum(self_game_profit) as self_game_profit,
                sum(three_game_num) as three_game_num,sum(three_game_betting_money) as three_game_betting_money,sum(three_game_award_money) as three_game_award_money,
                sum(three_game_award_rate) as three_game_award_rate,sum(three_game_profit) as three_game_profit,sum(withdraw_num) as withdraw_num,sum(new_withdraw_num) as new_withdraw_num,
                sum(withdraw_count) as withdraw_count,sum(withdraw_auto_count) as withdraw_auto_count,sum(withdraw_review_count) as withdraw_review_count,
                sum(withdraw_suc_count) as withdraw_suc_count,sum(withdraw_money) as withdraw_money,sum(recharge_withdraw_dif) as recharge_withdraw_dif,
                sum(profit) as profit,sum(regist_award_money) as regist_award_money,sum(tpc_unlock_money) as tpc_unlock_money,sum(tpc_withdraw_money) as tpc_withdraw_money,
                sum(back_water_num) as back_water_num,sum(back_water_money) as back_water_money,sum(back_water_withdraw_balance) as back_water_withdraw_balance,
                sum(popularize_num) as popularize_num,sum(next_to_up_unlock_money) as next_to_up_unlock_money,sum(next_to_up_back_money) as next_to_up_back_money,
                sum(rotary_num) as rotary_num,sum(rotary_count) as rotary_count,sum(rotary_diamond_money) as rotary_diamond_money,sum(rotary_cash_money) as rotary_cash_money,
                sum(max_game_count) as max_game_count,sum(login_count) as login_count,sum(user_day_give) as user_day_give,sum(login_game_count) as login_game_count,
                sum(new_login_count) as new_login_count,sum(new_recharge_suc_num) as new_recharge_suc_num,sum(new_withdraw_money) as new_withdraw_money,date,
                sum(repurchase_num) as repurchase_num,sum(new_repurchase_num) as new_repurchase_num,sum(new_login_game_count) as new_login_game_count,
                sum(first_order_num) as first_order_num,GROUP_CONCAT(NULLIF(COALESCE(true_regist_ids,''),'')) as true_regist_ids,sum(first_order_money) as first_order_money,
                sum(new_first_order_money) as new_first_order_money,sum(new_total_recharge) as new_total_recharge,sum(new_total_withdraw) as new_total_withdraw,
                GROUP_CONCAT(NULLIF(COALESCE(new_total_recharge_users,''),'')) as new_total_recharge_users,
                GROUP_CONCAT(NULLIF(COALESCE(new_total_withdraw_users,''),'')) as new_total_withdraw_users,sum(new_total_recharge_fee) as new_total_recharge_fee,
                sum(new_total_withdraw_count) as new_total_withdraw_count")
                ->where($where)
                ->where('package_id',0)
                ->where('channel',0)
                ->group('date')
                ->order('date','desc')
                ->page($page,$limit)
                ->select()
                ->toArray();
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
                sum(self_game_award_money) as self_game_award_money,sum(self_game_award_rate) as self_game_award_rate,sum(self_game_profit) as self_game_profit,
                sum(three_game_num) as three_game_num,sum(three_game_betting_money) as three_game_betting_money,sum(three_game_award_money) as three_game_award_money,
                sum(three_game_award_rate) as three_game_award_rate,sum(three_game_profit) as three_game_profit,sum(withdraw_num) as withdraw_num,sum(new_withdraw_num) as new_withdraw_num,
                sum(withdraw_count) as withdraw_count,sum(withdraw_auto_count) as withdraw_auto_count,sum(withdraw_review_count) as withdraw_review_count,
                sum(withdraw_suc_count) as withdraw_suc_count,sum(withdraw_money) as withdraw_money,sum(recharge_withdraw_dif) as recharge_withdraw_dif,
                sum(profit) as profit,sum(regist_award_money) as regist_award_money,sum(tpc_unlock_money) as tpc_unlock_money,sum(tpc_withdraw_money) as tpc_withdraw_money,
                sum(back_water_num) as back_water_num,sum(back_water_money) as back_water_money,sum(back_water_withdraw_balance) as back_water_withdraw_balance,
                sum(popularize_num) as popularize_num,sum(next_to_up_unlock_money) as next_to_up_unlock_money,sum(next_to_up_back_money) as next_to_up_back_money,
                sum(rotary_num) as rotary_num,sum(rotary_count) as rotary_count,sum(rotary_diamond_money) as rotary_diamond_money,sum(rotary_cash_money) as rotary_cash_money,
                sum(max_game_count) as max_game_count,sum(login_count) as login_count,sum(user_day_give) as user_day_give,sum(login_game_count) as login_game_count,
                sum(new_login_count) as new_login_count,sum(new_recharge_suc_num) as new_recharge_suc_num,sum(new_withdraw_money) as new_withdraw_money,date,
                sum(repurchase_num) as repurchase_num,sum(new_repurchase_num) as new_repurchase_num,sum(new_login_game_count) as new_login_game_count,
                sum(first_order_num) as first_order_num,GROUP_CONCAT(NULLIF(COALESCE(true_regist_ids,''),'')) as true_regist_ids,sum(first_order_money) as first_order_money,
                sum(new_first_order_money) as new_first_order_money,sum(new_total_recharge) as new_total_recharge,sum(new_total_withdraw) as new_total_withdraw,
                GROUP_CONCAT(NULLIF(COALESCE(new_total_recharge_users,''),'')) as new_total_recharge_users,
                GROUP_CONCAT(NULLIF(COALESCE(new_total_withdraw_users,''),'')) as new_total_withdraw_users,sum(new_total_recharge_fee) as new_total_recharge_fee,
                sum(new_total_withdraw_count) as new_total_withdraw_count")
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
        /*$last_names = array_column($data['data'],'date');
        array_multisort($last_names,SORT_ASC,$data['data']);*/

        if (!empty($data['data'])){
            foreach ($data['data'] as $key=>$value){
                $all_recharge_money = 0;
                $all_recharge_num = 0;
                $all_login_count = 0;
                $all_true_regist_num = 0;
                $all_withdraw_money = 0;
                $all_withdraw_num = 0;

                if (!empty($value['true_regist_ids'])){
                    $uids_arr = explode(',',$value['true_regist_ids']);
                    $uids = array_flip($uids_arr);
                    $uids = array_keys($uids);
                    $all_true_regist_num = count($uids);
                    //$all_recharge_money = Db::name('order')->where('pay_status',1)->whereIn('uid',$uids)->field('sum(price) as price,sum(fee_money) as fee_money')->find();
                    //$all_recharge_num = Db::name('order')->where('pay_status',1)->whereIn('uid',$uids)->group('uid')->count('uid');
                    //$all_withdraw_money = Db::name('withdraw_log')->where('status',1)->whereIn('uid',$uids)->field('sum(money) as money,count(*) as count')->find();
                    //$all_withdraw_num = Db::name('withdraw_log')->where('status',1)->whereIn('uid',$uids)->group('uid')->count('uid');
                }
                /*$data['data'][$key]['all_recharge_money'] = isset($all_recharge_money['price']) ? bcdiv($all_recharge_money['price'], $amount_reduction_multiple, 2) : 0;
                $data['data'][$key]['all_recharge_suc_num'] = $all_recharge_num;
                //$data['data'][$key]['all_login_count'] = $all_login_count;
                $data['data'][$key]['all_true_regist_num'] = $all_true_regist_num;
                $data['data'][$key]['all_withdraw_money'] = isset($all_withdraw_money['money']) ? bcdiv($all_withdraw_money['money'], $amount_reduction_multiple, 2) : 0;
                $data['data'][$key]['all_withdraw_num'] = $all_withdraw_num;
                $data['data'][$key]['all_fee'] = bcadd((isset($all_recharge_money['fee_money']) ? bcdiv($all_recharge_money['fee_money'], $amount_reduction_multiple, 2) : 0) , ((isset($all_withdraw_money['count']) ? $all_withdraw_money['count'] : 0) * 0.071) , 2);*/

                $data['data'][$key]['all_recharge_money'] = bcdiv($value['new_total_recharge'], $amount_reduction_multiple, 2);
                $data['data'][$key]['all_recharge_suc_num'] = !empty($value['new_total_recharge_users']) ? count(explode(',',$value['new_total_recharge_users'])) : 0;
                //$data['data'][$key]['all_login_count'] = $all_login_count;
                $data['data'][$key]['all_true_regist_num'] = $all_true_regist_num;
                $data['data'][$key]['all_withdraw_money'] = bcdiv($value['new_total_withdraw'], $amount_reduction_multiple, 2);
                $data['data'][$key]['all_withdraw_num'] = !empty($value['new_total_withdraw_users']) ? count(explode(',',$value['new_total_withdraw_users'])) : 0;
                $data['data'][$key]['all_fee'] = bcdiv(bcadd($value['new_total_recharge_fee'], $value['new_total_withdraw_count']*6), $amount_reduction_multiple,2);

                //老数据处理
                if (strtotime($value['date']) < 1726338600){
                    $data['data'][$key]['all_recharge_money'] = 0;
                    $data['data'][$key]['all_recharge_suc_num'] = 0;
                    //$data['data'][$key]['all_login_count'] = $all_login_count;
                    $data['data'][$key]['all_true_regist_num'] = $all_true_regist_num;
                    $data['data'][$key]['all_withdraw_money'] = 0;
                    $data['data'][$key]['all_withdraw_num'] = 0;
                    $data['data'][$key]['all_fee'] = 0;
                }

                $data['data'][$key]['new_recharge_money'] = bcdiv($value['new_recharge_money'], $amount_reduction_multiple, 2);
                $data['data'][$key]['first_order_money'] = bcdiv($value['first_order_money'], $amount_reduction_multiple, 2);
                $data['data'][$key]['new_withdraw_money'] = bcdiv($value['new_withdraw_money'], $amount_reduction_multiple, 2);
                $data['data'][$key]['new_withdraw_money'] = bcdiv($value['new_withdraw_money'], $amount_reduction_multiple, 2);
            }
        }
        //排序
        /*$last_names = array_column($data['data'],'date');
        array_multisort($last_names,SORT_DESC,$data['data']);*/
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
                    'all_recharge_money' => 0,
                    'all_recharge_suc_num' => 0,
                    'all_true_regist_num' => 0,
                    'all_withdraw_money' => 0,
                    'all_withdraw_num' => 0,
                    'first_order_money' => 0,
                    'all_fee' => 0,
                    'new_first_order_money' => 0,
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
                    $new_data[0]['all_recharge_money'] += $dvalue['all_recharge_money'];
                    $new_data[0]['all_recharge_suc_num'] += $dvalue['all_recharge_suc_num'];
                    $new_data[0]['all_true_regist_num'] += $dvalue['all_true_regist_num'];
                    $new_data[0]['all_withdraw_money'] += $dvalue['all_withdraw_money'];
                    $new_data[0]['all_withdraw_num'] += $dvalue['all_withdraw_num'];
                    $new_data[0]['first_order_money'] += $dvalue['first_order_money'];
                    $new_data[0]['all_fee'] += $dvalue['all_fee'];
                    $new_data[0]['new_first_order_money'] += $dvalue['new_first_order_money'];
                }
                $new_data[0]['date'] = $data['data'][$dkey]['date'].' - '.$data['data'][0]['date'];
                $new_data[0]['all_recharge_money'] = round($new_data[0]['all_recharge_money'],2);
                $new_data[0]['first_order_money'] = round($new_data[0]['first_order_money'],2);
                $new_data[0]['new_withdraw_money'] = round($new_data[0]['new_withdraw_money'],2);
                //$new_data[0]['recharge_suc_rate'] = $new_data[0]['recharge_count']>0 ? round(($new_data[0]['recharge_suc_count']/$new_data[0]['recharge_count'])*100,2) : '0.00';
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
