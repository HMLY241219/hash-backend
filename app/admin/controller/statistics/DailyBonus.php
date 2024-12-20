<?php

namespace app\admin\controller\statistics;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use think\facade\Session;

/**
 *  列表
 */
class DailyBonus extends AuthController
{

    public function index()
    {
        /*$level = getAdminLevel($this->adminInfo);

        $this->assign('adminInfo', $this->adminInfo);
        $this->assign('adminlevel', $level);*/
        $this->assign('adminInfo', $this->adminInfo);
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
        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数

        if ($tj_type === '1'){
            $data['data'] = Db::name('daily_bonus')
                ->field("min(date) as min_date,max(date) as max_date,sum(recharge_money) as recharge_money,sum(give_bonus) as give_bonus,sum(give_cash) as give_cash,
                sum(cash_water) as cash_water,sum(bonus_water) as bonus_water,sum(bonus_cash_transition) as bonus_cash_transition,sum(bonus_win) as bonus_win,
                GROUP_CONCAT(NULLIF(COALESCE(give_bonus_users,''),'')) as give_bonus_users,GROUP_CONCAT(NULLIF(COALESCE(give_cash_users,''),'')) as give_cash_users,
                GROUP_CONCAT(NULLIF(COALESCE(bonus_transition_users,''),'')) as bonus_transition_users,sum(bonus_losing) as bonus_losing,sum(balance_bonus) as balance_bonus")
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->order('date', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('daily_bonus')
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->count();

            if (!empty($data['data'])){

                foreach ($data['data'] as $dk=>$dv){
                    $data['data'][$dk]['date'] = $dv['min_date'].' - '.$dv['max_date'];

                    $data['data'][$dk]['cash_water_multiple'] = ($dv['recharge_money'] + $dv['give_cash']) > 0 ? bcdiv($dv['cash_water'],($dv['recharge_money'] + $dv['give_cash']),2) : 0;
                    $data['data'][$dk]['bonus_water_multiple'] = $dv['give_bonus'] > 0 ? bcdiv($dv['bonus_water'], $dv['give_bonus'],2) : 0;
                    $data['data'][$dk]['bonus_transition_bill'] = $dv['bonus_water'] > 0 ? bcdiv($dv['bonus_cash_transition'], $dv['bonus_water'],2)*100 : 0;

                    $data['data'][$dk]['give_bonus_num'] = 0;
                    if (!empty($dv['give_bonus_users'])){
                        $data['data'][$dk]['give_bonus_num'] = count(explode(',', $dv['give_bonus_users']));
                    }
                    $data['data'][$dk]['bonus_transition_num'] = 0;
                    if (!empty($dv['bonus_transition_users'])){
                        $data['data'][$dk]['bonus_transition_num'] = count(explode(',', $dv['bonus_transition_users']));
                    }

                    $data['data'][$dk]['recharge_money'] = bcdiv($dv['recharge_money'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['give_bonus'] = bcdiv($dv['give_bonus'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['bonus_win'] = bcdiv($dv['bonus_win'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['bonus_losing'] = bcdiv($dv['bonus_losing'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['balance_bonus'] = bcdiv($dv['balance_bonus'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['give_cash'] = bcdiv($dv['give_cash'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['cash_water'] = bcdiv($dv['cash_water'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['bonus_water'] = bcdiv($dv['bonus_water'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['bonus_cash_transition'] = bcdiv($dv['bonus_cash_transition'], $amount_reduction_multiple, 2);
                }
            }

        }else {//正常
            $data['data'] = Db::name('daily_bonus')
                ->field("date,sum(recharge_money) as recharge_money,sum(give_bonus) as give_bonus,sum(give_cash) as give_cash,sum(cash_water) as cash_water,
                sum(bonus_water) as bonus_water,sum(bonus_cash_transition) as bonus_cash_transition,sum(bonus_win) as bonus_win,
                GROUP_CONCAT(NULLIF(COALESCE(give_bonus_users,''),'')) as give_bonus_users,sum(bonus_losing) as bonus_losing,sum(balance_bonus) as balance_bonus,
                GROUP_CONCAT(NULLIF(COALESCE(give_cash_users,''),'')) as give_cash_users,GROUP_CONCAT(NULLIF(COALESCE(bonus_transition_users,''),'')) as bonus_transition_users")
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->group('date')
                ->order('date', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('daily_bonus')
                ->group('date')
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->count();
            if (!empty($data['data'])){
                foreach ($data['data'] as $dk=>$dv){

                    $data['data'][$dk]['cash_water_multiple'] = ($dv['recharge_money'] + $dv['give_cash']) > 0 ? bcdiv($dv['cash_water'],($dv['recharge_money'] + $dv['give_cash']),2) : 0;
                    $data['data'][$dk]['bonus_water_multiple'] = $dv['give_bonus'] > 0 ? bcdiv($dv['bonus_water'], $dv['give_bonus'],2) : 0;
                    $data['data'][$dk]['bonus_transition_bill'] = $dv['give_bonus'] > 0 ? bcmul(bcdiv($dv['bonus_cash_transition'], $dv['give_bonus'],4),100,2) : 0;
                    $data['data'][$dk]['bonus_pay_bill'] = $dv['recharge_money'] > 0 ? bcmul(bcdiv($dv['bonus_cash_transition'], $dv['recharge_money'],4),100,2) : 0;

                    $data['data'][$dk]['give_bonus_num'] = 0;
                    if (!empty($dv['give_bonus_users'])){
                        $data['data'][$dk]['give_bonus_num'] = count(explode(',', $dv['give_bonus_users']));
                    }
                    $data['data'][$dk]['bonus_transition_num'] = 0;
                    if (!empty($dv['bonus_transition_users'])){
                        $data['data'][$dk]['bonus_transition_num'] = count(explode(',', $dv['bonus_transition_users']));
                    }

                    $data['data'][$dk]['recharge_money'] = bcdiv($dv['recharge_money'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['give_bonus'] = bcdiv($dv['give_bonus'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['bonus_win'] = bcdiv($dv['bonus_win'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['bonus_losing'] = bcdiv($dv['bonus_losing'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['balance_bonus'] = bcdiv($dv['balance_bonus'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['give_cash'] = bcdiv($dv['give_cash'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['cash_water'] = bcdiv($dv['cash_water'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['bonus_water'] = bcdiv($dv['bonus_water'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['bonus_cash_transition'] = bcdiv($dv['bonus_cash_transition'], $amount_reduction_multiple, 2);
                }
            }
        }

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    public function userList(){
        return $this->fetch();
    }

    public function getUserinfoList(){
        $data = $this->request->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;

        $date = date('Y-m-d');
        $day = date('Ymd');

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

        $cash_bonus = Db::name('daily_bonus')
            ->where('date',$date)
            ->where($NewWhere)
            ->where($channel_where)
            ->field("GROUP_CONCAT(NULLIF(COALESCE(bet_users,''),'')) as bet_users")
            ->find();

        $unique_values = explode(',', $cash_bonus['bet_users']);
        $unique_values = array_unique($unique_values);
        if (empty($unique_values)){
            return json(['code' => 0, 'count' => 0, 'data' => []]);
        }

        $list = Db::name('user_day_'.date('Ymd'))
            ->field('uid,total_cash_water_score,total_bonus_water_score,cash_total_score,bonus_total_score')
            ->whereIn('uid',$unique_values)
            ->order('total_cash_water_score','desc')
            ->order('updatetime','desc')
            ->page($page, $limit)
            ->select()
            ->toArray();
        $count = Db::name('user_day_'.date('Ymd'))
            ->whereIn('uid',$unique_values)
            ->count();
        return json(['code' => 0, 'count' => $count, 'data' => $list]);

    }

    public function userList2(){
        return $this->fetch();
    }

    public function getUserinfoList2(){
        $data = $this->request->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;

        $date = date('Y-m-d');
        $day = date('Ymd');

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

        $cash_bonus = Db::name('daily_bonus')
            ->where('date',$date)
            ->where($NewWhere)
            ->where($channel_where)
            ->field("GROUP_CONCAT(NULLIF(COALESCE(bet_users,''),'')) as bet_users,GROUP_CONCAT(NULLIF(COALESCE(login_users,''),'')) as login_users")
            ->find();

        $unique_values = explode(',', $cash_bonus['bet_users']);
        $unique_values = array_unique($unique_values);

        $login_users = explode(',', $cash_bonus['login_users']);
        $login_users = array_unique($login_users);
        $not_bet_users = array_diff($login_users, $unique_values);

        if (empty($not_bet_users)){
            return json(['code' => 0, 'count' => 0, 'data' => []]);
        }

        $list = Db::name('userinfo')
            ->field('uid,total_pay_score,total_exchange')
            ->whereIn('uid',$not_bet_users)
            ->order('total_pay_score','desc')
            ->order('regist_time','desc')
            ->page($page, $limit)
            ->select()
            ->toArray();
        $count = Db::name('userinfo')
            ->whereIn('uid',$not_bet_users)
            ->count();
        return json(['code' => 0, 'count' => $count, 'data' => $list]);

    }


}
