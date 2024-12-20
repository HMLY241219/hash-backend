<?php

namespace app\admin\controller;

use app\admin\model\games\UserDay;
use app\admin\model\order\Orders;
use FormBuilder\Json;
use pay\Balance;
use think\facade\Db;
use think\facade\Config;
use app\admin\model\order\StoreOrder as StoreOrderModel;//订单
use app\admin\model\system\{SystemConfig, SystemMenus, SystemRole};
use app\admin\model\user\{Chanel, User, UserExtract as UserExtractModel, User as UserModel, WithdrawLog};
use app\admin\model\store\{StoreProduct, StoreProductReply as StoreProductReplyModel, StoreProduct as ProductModel};
use think\facade\Session;
/**
 * 首页控制器
 * Class Index
 * @package app\admin\controller
 *
 */
class Index extends AuthController
{

    public function index()
    {
        //dd(222);
        //获取当前登录后台的管理员信息
        $admin = $this->adminInfo->toArray();
        $roles = explode(',', $admin['roles']);

        //$site_logo = SystemConfig::getOneConfig('menu_name', 'site_logo')->toArray();

        $this->assign([
            'site_name' => SystemConfig::getOne('site_name'),
            'menu_list' => SystemMenus::menuList(),
            'role_name' => SystemRole::where('id', $roles[0])->value('role_name'),

            //'site_logo' => json_decode($site_logo['value'], true),
            //'new_order_audio_link' => sys_config('new_order_audio_link'),
            //'workermanPort'        => Config::get('workerman.admin.port'),
        ]);

        return $this->fetch();
    }

    //后台首页内容
    public function main()
    {
        //dd(111);
        ini_set('memory_limit','512M');

        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数
        $general_data_reduction_times = config('my.general_data_reduction_times'); //后台人数,订单,游戏次数缩小倍数
        $adminId = $this->adminId;
        $system_admin = Db::name('system_admin')->field('package_id,channel,channels')->where('id',$adminId)->find();
        if(!$system_admin){
            echo "用户不正确";
            exit();
        }
//        $status =  !$system_admin['package_id'] ? true : false ;
        $status =  true;

        //是否包含分享数据:1=是，2=否
        if(!Session::get('sharstatus') || !Session::get('chanel')){
            Session::set('sharstatus',2);
        }

        $er_chanel_model = new Chanel();

        if(!$system_admin['package_id']){
            $packname = Db::name('apppackage')->field('id,bagname,appname,remark1')->where('status',1)->select()->toArray();
            Session::get('package_id') || Session::get('package_id') === 0 ? true : Session::set('package_id', 0);
            Session::get('chanel') || Session::get('chanel') === 0  ? true :Session::set('chanel', 0);//默认全部渠道

            $chanel = Session::get('package_id') ? Db::name('chanel')->field('channel,cname')->where([['package_id' ,'=', Session::get('package_id')],['pchannel','=',0]])->select()->toArray() : [];

            //下级渠道展示
            if (Session::get('chanel_z')) {
                $er_arr = [];
                $er_chanel_model->getAllSubordinates3(Session::get('chanel_z'), $er_arr);
                $er_chanel = $er_arr;
            }else{
                $er_chanel = [];
            }
        }else{
            $packname = Db::name('apppackage')->field('id,bagname,appname,remark1')->where('id','in',$system_admin['package_id'])->select()->toArray();

            Session::get('package_id') ? true : Session::set('package_id', $system_admin['package_id']);
            if ($this->adminInfo['type'] == 0) {
                $chanelid = !$system_admin['channels'] ? 0 : $this->chanels($system_admin['channels'], Session::get('package_id'));

                Session::get('chanel') || Session::get('chanel') === 0 ? true : Session::set('chanel', $chanelid);;//默认全部渠道

                $where = $system_admin['channels'] ? [['channel', 'in', $system_admin['channels']]] : [];

                $chanel = strpos(Session::get('package_id'), ',') !== false ? [] : Db::name('chanel')->field('channel,cname')->where([['package_id', '=', Session::get('package_id')],['pchannel','=',0]])->where($where)->select()->toArray();
            }else{
                $chanelid = !$system_admin['channels'] ? 0 : $this->chanels($system_admin['channels'], Session::get('package_id'));

                Session::get('chanel') || Session::get('chanel') === 0 ? true : Session::set('chanel', $chanelid);;//默认全部渠道

                $where = $system_admin['channels'] ? [['channel', 'in', $system_admin['channels']]] : [];

                $chanel = strpos(Session::get('package_id'), ',') !== false ? [] : Db::name('chanel')->field('channel,cname')->where([['package_id', '=', Session::get('package_id')],['pchannel','=',0]])->where($where)->select()->toArray();

                /*$chanelid = !$system_admin['channels'] ? 0 : explode(",",$system_admin['channels']);

                Session::get('chanel') || Session::get('chanel') === 0 ? true : Session::set('chanel', $chanelid);;//默认全部渠道

                $where = $system_admin['channels'] ? [['channel', 'in', $system_admin['channels']]] : [];

                $chanel = Db::name('chanel')->field('channel,cname')->where($where)->select()->toArray();*/
            }
            //下级渠道展示
            if (Session::get('chanel_z')) {
                $er_arr = [];
                $er_chanel_model->getAllSubordinates3(Session::get('chanel_z'), $er_arr);
                $er_chanel = $er_arr;
            }else{
                $er_chanel = [];
            }
        }


        //统计数据
        $package_id = Session::get('package_id');
        $chanel_cid = Session::get('chanel');
        if($chanel_cid){
            $this->sqlwhere = [['a.channel' ,'in', $chanel_cid]];
            $this->sqlNewWhere = ['channel','in',$chanel_cid];
        }elseif ($package_id){
            $this->sqlwhere = [['a.package_id' ,'in', $package_id]];
            $this->sqlNewWhere = ['package_id','in',$package_id];
        }

        //正式环境
        $div_data = [];
        /*$online_num  = 0;
        $redis = new \Redis();
        $redis->connect(Config::get('redis.ip'), 5511);
        $online_user = $redis->sMembers('online_user');*/
        //测试环境
        $online_user = [];
        $online_num = 0;
        if (!empty($online_user)) {
            $userinfo = Db::name('share_strlog')->whereIn('uid', $online_user)->field('isgold,package_id,channel')->select()->toArray();
            if (!empty($userinfo)){
                foreach ($userinfo as $uk=>$uv){
                    if ($uv['isgold'] == 0) {
                        if ($chanel_cid) {
                            if ($chanel_cid == $uv['channel']) {
                                $online_num++;
                            }
                        } elseif ($package_id) {
                            if ($package_id == $uv['package_id']) {
                                $online_num++;
                            }
                        } else {
                            $online_num++;
                        }
                    }
                }
            }
        }
        $div_data['on_line'] = bcdiv($online_num,$general_data_reduction_times,2);  //当前自研在线人数

        //今日注册
        $chan_where = [];
        if (!empty($this->sqlNewWhere)){
            $chan_where = [$this->sqlNewWhere];
        }
        /*$join_where = [];
        if ($chanel_cid){
            $join_where['a.channel'] = $chanel_cid;
        }elseif ($package_id){
            $join_where['a.package_id'] = $package_id;
        }*/
        $day_date = date('Ymd');
        $registable_name = "regist_".str_replace("-","",$day_date);
        $isregisTable = Db::query('SHOW TABLES LIKE '."'lzmj_".$registable_name."'");
        if($isregisTable){
            //表存在
            $div_data["regist_count"]=Db::name($registable_name)->where($chan_where)->count();
        }else{
            $div_data["regist_count"]=0;
        }
        //真金
        $true_user_num = 0;
        /*$device = [];
        $true_user = Db::name('regist_'.$day_date)->alias('a')->join('share_strlog ss','a.uid=ss.uid')->where($this->sqlwhere)->where('ss.isgold',0)->select()->toArray();

        if (!empty($true_user)){
            foreach ($true_user as $tuk=>$tuv){
                $true_user_num += 1;
                $device[$tuv['device_id']] = true;
            }
        }*/
        //dd(11);
        $div_data['true_regist_count'] = $true_user_num;
        $div_data['gold_regist_count'] = $div_data["regist_count"] - $true_user_num;
        //$div_data['device_num'] = count($device);
        //登录真金人数
        $login_true = Db::name('login_'.$day_date)->alias('a')->join('share_strlog ss','a.uid=ss.uid')->where($this->sqlwhere)->where('ss.isgold',0)->count();
        $div_data['login_true'] = $login_true;
        //活动
        $active_log = Db::name('active_log')
            ->whereDay('createtime')->sum('zs_money');
        $div_data['day_active_zs'] = $active_log;

        //平台与渠道
        //平台与渠道
        $channel_where = [];
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$channel_where = [['channel', '<', 100000000]];
            } else {
                $channel_where = [['channel', '>=', 100000000]];
            }
        }

        $date = date('Y-m-d');
        if ($chanel_cid){
            $day_data = Db::name('day_data')->where('date',$date)->whereIn('channel', $chanel_cid)
                ->field('sum(regist_num) as regist_num,sum(true_regist_num) as true_regist_num,sum(true_game_num) as true_game_num,
                sum(recharge_num) as recharge_num,sum(recharge_suc_num) as recharge_suc_num,sum(new_recharge_num) as new_recharge_num,
                sum(old_recharge_num) as old_recharge_num,sum(recharge_count) as recharge_count,sum(new_recharge_count) as new_recharge_count,
                sum(old_recharge_count) as old_recharge_count,sum(recharge_suc_count) as recharge_suc_count,sum(new_recharge_suc_count) as new_recharge_suc_count,
                sum(old_recharge_suc_count) as old_recharge_suc_count,sum(recharge_suc_rate) as recharge_suc_rate,sum(new_recharge_suc_rate) as new_recharge_suc_rate,
                sum(old_recharge_suc_rate) as old_recharge_suc_rate,sum(recharge_money) as recharge_money,sum(new_recharge_money) as new_recharge_money,
                sum(old_recharge_money) as old_recharge_money,sum(fee_money) as fee_money,sum(self_game_num) as self_game_num,sum(self_game_betting_money) as self_game_betting_money,
                sum(self_game_award_money) as self_game_award_money,sum(self_game_award_rate) as self_game_award_rate,sum(self_game_profit) as self_game_profit,
                sum(three_game_num) as three_game_num,sum(three_game_betting_money) as three_game_betting_money,sum(three_game_award_money) as three_game_award_money,
                sum(three_game_award_rate) as three_game_award_rate,sum(three_game_profit) as three_game_profit,sum(withdraw_num) as withdraw_num,
                sum(withdraw_count) as withdraw_count,sum(withdraw_auto_count) as withdraw_auto_count,sum(withdraw_review_count) as withdraw_review_count,
                sum(withdraw_suc_count) as withdraw_suc_count,sum(withdraw_money) as withdraw_money,sum(recharge_withdraw_dif) as recharge_withdraw_dif,
                sum(profit) as profit,sum(regist_award_money) as regist_award_money,sum(tpc_unlock_money) as tpc_unlock_money,sum(tpc_withdraw_money) as tpc_withdraw_money,
                sum(back_water_num) as back_water_num,sum(back_water_money) as back_water_money,sum(back_water_withdraw_balance) as back_water_withdraw_balance,
                sum(popularize_num) as popularize_num,sum(next_to_up_unlock_money) as next_to_up_unlock_money,sum(next_to_up_back_money) as next_to_up_back_money,
                sum(rotary_num) as rotary_num,sum(rotary_count) as rotary_count,sum(rotary_diamond_money) as rotary_diamond_money,sum(rotary_cash_money) as rotary_cash_money,
                sum(max_game_count) as max_game_count,sum(login_count) as login_count,sum(user_day_give) as user_day_give,sum(login_game_count) as login_game_count,
                sum(new_login_count) as new_login_count,sum(new_withdraw_money) as new_withdraw_money,sum(new_recharge_suc_num) as new_recharge_suc_num,
                sum(new_withdraw_num) as new_withdraw_num,sum(withdraw_suc_num) as withdraw_suc_num,sum(withdraw_fee_money) as withdraw_fee_money,
                sum(withdraw_fai_count) as withdraw_fai_count,sum(total_service_score) as total_service_score')
                ->find();
        }elseif ($package_id){
            $day_data = Db::name('day_data')->where('date',$date)->where('package_id', $package_id)->where($channel_where)
                ->field('sum(regist_num) as regist_num,sum(true_regist_num) as true_regist_num,sum(true_game_num) as true_game_num,
                sum(recharge_num) as recharge_num,sum(recharge_suc_num) as recharge_suc_num,sum(new_recharge_num) as new_recharge_num,
                sum(old_recharge_num) as old_recharge_num,sum(recharge_count) as recharge_count,sum(new_recharge_count) as new_recharge_count,
                sum(old_recharge_count) as old_recharge_count,sum(recharge_suc_count) as recharge_suc_count,sum(new_recharge_suc_count) as new_recharge_suc_count,
                sum(old_recharge_suc_count) as old_recharge_suc_count,sum(recharge_suc_rate) as recharge_suc_rate,sum(new_recharge_suc_rate) as new_recharge_suc_rate,
                sum(old_recharge_suc_rate) as old_recharge_suc_rate,sum(recharge_money) as recharge_money,sum(new_recharge_money) as new_recharge_money,
                sum(old_recharge_money) as old_recharge_money,sum(fee_money) as fee_money,sum(self_game_num) as self_game_num,sum(self_game_betting_money) as self_game_betting_money,
                sum(self_game_award_money) as self_game_award_money,sum(self_game_award_rate) as self_game_award_rate,sum(self_game_profit) as self_game_profit,
                sum(three_game_num) as three_game_num,sum(three_game_betting_money) as three_game_betting_money,sum(three_game_award_money) as three_game_award_money,
                sum(three_game_award_rate) as three_game_award_rate,sum(three_game_profit) as three_game_profit,sum(withdraw_num) as withdraw_num,
                sum(withdraw_count) as withdraw_count,sum(withdraw_auto_count) as withdraw_auto_count,sum(withdraw_review_count) as withdraw_review_count,
                sum(withdraw_suc_count) as withdraw_suc_count,sum(withdraw_money) as withdraw_money,sum(recharge_withdraw_dif) as recharge_withdraw_dif,
                sum(profit) as profit,sum(regist_award_money) as regist_award_money,sum(tpc_unlock_money) as tpc_unlock_money,sum(tpc_withdraw_money) as tpc_withdraw_money,
                sum(back_water_num) as back_water_num,sum(back_water_money) as back_water_money,sum(back_water_withdraw_balance) as back_water_withdraw_balance,
                sum(popularize_num) as popularize_num,sum(next_to_up_unlock_money) as next_to_up_unlock_money,sum(next_to_up_back_money) as next_to_up_back_money,
                sum(rotary_num) as rotary_num,sum(rotary_count) as rotary_count,sum(rotary_diamond_money) as rotary_diamond_money,sum(rotary_cash_money) as rotary_cash_money,
                sum(max_game_count) as max_game_count,sum(login_count) as login_count,sum(user_day_give) as user_day_give,sum(login_game_count) as login_game_count,
                sum(new_login_count) as new_login_count,sum(new_withdraw_money) as new_withdraw_money,sum(new_recharge_suc_num) as new_recharge_suc_num,
                sum(new_withdraw_num) as new_withdraw_num,sum(withdraw_suc_num) as withdraw_suc_num,sum(withdraw_fee_money) as withdraw_fee_money,
                sum(withdraw_fai_count) as withdraw_fai_count,sum(total_service_score) as total_service_score')
                ->find();
        }else{
            //$day_data = Db::name('day_data')->where('date',$date)->where('package_id', 0)->where('channel', 0)->find();
            $day_data = Db::name('day_data')
                ->where('date',$date)
                ->where('package_id', 0)
                ->where('channel', 0)
                //->where('package_id', '<>',0)
                //->where('channel', '<>',0)
                //->where($channel_where)
                ->field('sum(regist_num) as regist_num,sum(true_regist_num) as true_regist_num,sum(true_game_num) as true_game_num,
                sum(recharge_num) as recharge_num,sum(recharge_suc_num) as recharge_suc_num,sum(new_recharge_num) as new_recharge_num,
                sum(old_recharge_num) as old_recharge_num,sum(recharge_count) as recharge_count,sum(new_recharge_count) as new_recharge_count,
                sum(old_recharge_count) as old_recharge_count,sum(recharge_suc_count) as recharge_suc_count,sum(new_recharge_suc_count) as new_recharge_suc_count,
                sum(old_recharge_suc_count) as old_recharge_suc_count,sum(recharge_suc_rate) as recharge_suc_rate,sum(new_recharge_suc_rate) as new_recharge_suc_rate,
                sum(old_recharge_suc_rate) as old_recharge_suc_rate,sum(recharge_money) as recharge_money,sum(new_recharge_money) as new_recharge_money,
                sum(old_recharge_money) as old_recharge_money,sum(fee_money) as fee_money,sum(self_game_num) as self_game_num,sum(self_game_betting_money) as self_game_betting_money,
                sum(self_game_award_money) as self_game_award_money,sum(self_game_award_rate) as self_game_award_rate,sum(self_game_profit) as self_game_profit,
                sum(three_game_num) as three_game_num,sum(three_game_betting_money) as three_game_betting_money,sum(three_game_award_money) as three_game_award_money,
                sum(three_game_award_rate) as three_game_award_rate,sum(three_game_profit) as three_game_profit,sum(withdraw_num) as withdraw_num,
                sum(withdraw_count) as withdraw_count,sum(withdraw_auto_count) as withdraw_auto_count,sum(withdraw_review_count) as withdraw_review_count,
                sum(withdraw_suc_count) as withdraw_suc_count,sum(withdraw_money) as withdraw_money,sum(recharge_withdraw_dif) as recharge_withdraw_dif,
                sum(profit) as profit,sum(regist_award_money) as regist_award_money,sum(tpc_unlock_money) as tpc_unlock_money,sum(tpc_withdraw_money) as tpc_withdraw_money,
                sum(back_water_num) as back_water_num,sum(back_water_money) as back_water_money,sum(back_water_withdraw_balance) as back_water_withdraw_balance,
                sum(popularize_num) as popularize_num,sum(next_to_up_unlock_money) as next_to_up_unlock_money,sum(next_to_up_back_money) as next_to_up_back_money,
                sum(rotary_num) as rotary_num,sum(rotary_count) as rotary_count,sum(rotary_diamond_money) as rotary_diamond_money,sum(rotary_cash_money) as rotary_cash_money,
                sum(max_game_count) as max_game_count,sum(login_count) as login_count,sum(user_day_give) as user_day_give,sum(login_game_count) as login_game_count,
                sum(new_login_count) as new_login_count,sum(new_withdraw_money) as new_withdraw_money,sum(new_recharge_suc_num) as new_recharge_suc_num,
                sum(new_withdraw_num) as new_withdraw_num,sum(withdraw_suc_num) as withdraw_suc_num,sum(withdraw_fee_money) as withdraw_fee_money,
                sum(withdraw_fai_count) as withdraw_fai_count,sum(total_service_score) as total_service_score')
                ->find();
        }



        if (!empty($day_data)){

            $day_data['all_withdraw_rate'] = $day_data['recharge_money']>0 ? round(bcdiv($day_data['withdraw_money'],$day_data['recharge_money'],4)*100) : 0;
            $day_data['new_withdraw_rate'] = $day_data['new_recharge_money']>0 ? round(bcdiv($day_data['new_withdraw_money'],$day_data['new_recharge_money'],4)*100) : 0;
            $day_data['old_withdraw_rate'] = ($day_data['recharge_money']-$day_data['new_recharge_money'])>0 ? round(bcdiv(($day_data['withdraw_money']-$day_data['new_withdraw_money']),($day_data['recharge_money']-$day_data['new_recharge_money']),4)*100) : 0;
            $day_data['withdraw_suc_rate'] = ($day_data['withdraw_suc_count'] + $day_data['withdraw_fai_count'])>0 ? round(bcdiv($day_data['withdraw_suc_count'],($day_data['withdraw_suc_count']+$day_data['withdraw_fai_count']),4)*100,2) : 0;
            $day_data['max_game_count'] = bcdiv($day_data['max_game_count'],$general_data_reduction_times,2); //最高自研同时游戏人数
            $day_data['login_count'] = bcdiv($day_data['login_count'],$general_data_reduction_times,2); //登录用户
            $day_data['true_regist_num'] = bcdiv($day_data['true_regist_num'],$general_data_reduction_times,2); //新注册用户
            $day_data['recharge_count'] = bcdiv($day_data['recharge_count'],$general_data_reduction_times,2); //充值订单数
            $day_data['recharge_suc_count'] = bcdiv($day_data['recharge_suc_count'],$general_data_reduction_times,2); //成功订单数
            $day_data['recharge_suc_num'] = bcdiv($day_data['recharge_suc_num'],$general_data_reduction_times,2); //总充值人数
            $day_data['new_recharge_suc_num'] = bcdiv($day_data['new_recharge_suc_num'],$general_data_reduction_times,2); //新充值人数
            $day_data['old_recharge_suc_num'] = $day_data['recharge_suc_num'] - $day_data['new_recharge_suc_num'];  //老充值人数
            $day_data['recharge_money'] =  bcdiv($day_data['recharge_money'],$amount_reduction_multiple,2); //充值金额
            $day_data['new_recharge_money'] =  bcdiv($day_data['new_recharge_money'],$amount_reduction_multiple,2); //新充值金额
            $day_data['old_recharge_money'] =  bcdiv($day_data['old_recharge_money'],$amount_reduction_multiple,2); //老用户充值金额
            $day_data['withdraw_money'] =  bcdiv($day_data['withdraw_money'],$amount_reduction_multiple,2); //退款金额
            $day_data['new_withdraw_money'] =  bcdiv($day_data['new_withdraw_money'],$amount_reduction_multiple,2); //新用户退款金额
            $day_data['old_withdraw_money'] =  bcsub($day_data['withdraw_money'],$day_data['new_withdraw_money'],2); //退款金额
            $day_data['withdraw_suc_num'] =  bcdiv($day_data['withdraw_suc_num'],$general_data_reduction_times,2); //总退款人数
            $day_data['new_withdraw_num'] =  bcdiv($day_data['new_withdraw_num'],$general_data_reduction_times,2); //新退款人数
            $day_data['old_withdraw_suc_num'] = $day_data['withdraw_suc_num'] - $day_data['new_withdraw_num']; //老退款人数
            $day_data['fee_money'] = bcdiv(($day_data['fee_money'] + $day_data['withdraw_fee_money']),$amount_reduction_multiple,2); //通道手续费
            $day_data['withdraw_auto_count'] = bcdiv($day_data['withdraw_auto_count'] ,$general_data_reduction_times,2); //退款系统自动通过订单数
            $day_data['withdraw_suc_count'] = bcdiv($day_data['withdraw_suc_count'] ,$general_data_reduction_times,2); //退款成功订单数
            $day_data['self_game_num'] = bcdiv($day_data['self_game_num'] ,$general_data_reduction_times,2);//游戏投注人数
            $day_data['profit'] = bcdiv($day_data['profit'] ,$amount_reduction_multiple,2);//平台毛利
        }
        $div_data['day_data'] = $day_data;
        $div_data['trues'] = 1;

        $cash_bonus = Db::name('daily_bonus')
            ->where('date',$date)
            ->where($chan_where)
            ->where($channel_where)
            ->field("GROUP_CONCAT(NULLIF(COALESCE(bet_users,''),'')) as bet_users,GROUP_CONCAT(NULLIF(COALESCE(login_users,''),'')) as login_users")
            ->find();
        $unique_values = explode(',', $cash_bonus['bet_users']);
        $unique_values = array_unique($unique_values);
        $cash_bonus_data = [];
        $cash_bonus_data['bet_num'] = bcdiv(count($unique_values), $general_data_reduction_times, 2);

        $login_users = explode(',', $cash_bonus['login_users']);
        $login_users = array_unique($login_users);
        $not_bet_users = array_diff($login_users, $unique_values);
        $cash_bonus_data['not_bet_num'] = bcdiv(count($not_bet_users), $general_data_reduction_times, 2);


        //汇总数据
        $all_data = [];
        $chan_where = [];
        if (!empty($this->sqlNewWhere)){
            $chan_where = [$this->sqlNewWhere];
        }
        $regist_count = Db::name('share_strlog')->where($chan_where)->where($channel_where)->count();//总注册人数
        $regist_true_count = Db::name('share_strlog')->where($chan_where)->where('isgold',0)->where($channel_where)->count();//总真金注册人数
        $recharge_num = Db::name('order')->where($chan_where)->where('pay_status',1)->where($channel_where)->group('uid')->count();//总充值人数
        $recharge_price = Db::name('order')->where($chan_where)->where('pay_status',1)->where($channel_where)->field('IFNULL(floor(sum(price)),0) as price')->find();//总充值金额
        $withdraw_num = Db::name('withdraw_log')->where($chan_where)->where('status',1)->where($channel_where)->group('uid')->count();//总提现人数
        $withdraw_price = Db::name('withdraw_log')->where($chan_where)->where('status',1)->where($channel_where)->field('IFNULL(floor(sum(money)),0) as money')->find();//总提现金额
        $recharge_price['price'] = bcdiv($recharge_price['price'],$amount_reduction_multiple,2);
        $withdraw_price['money'] = bcdiv($withdraw_price['money'],$amount_reduction_multiple,2);
        $all_withdraw_rate = $recharge_price['price'] > 0  ? round(bcdiv($withdraw_price['money'],$recharge_price['price'],4)*100,2) : 0;//总提现率
        $all_recharge_withdraw_dif = $recharge_price['price'] - $withdraw_price['money'];//总充提差
        $all_profit_rate = $recharge_price['price'] > 0 ? round(bcdiv($all_recharge_withdraw_dif,$recharge_price['price'],4)*100,2) : 0;//总平台利润率
        $day_sum_where = ['package_id'=>0,'channel'=>0];
        if (!empty($chan_where)){
            $day_sum_where = $chan_where;
        }
        $user_day_sum = Db::name('day_data')
//            ->where($day_sum_where)
            ->where($chan_where)
            ->where('package_id','<>',0)
            ->where('channel','<>',0)
            ->where($channel_where)
            ->field('IFNULL(floor(sum(self_game_profit)/100),0) as self_game_profit,IFNULL(floor(sum(three_game_profit)),0) as three_game_profit,
            IFNULL(floor(sum(user_day_give)),0) as user_day_give,IFNULL(floor(sum(fee_money)),0) as fee_money,IFNULL(floor(sum(withdraw_fee_money)),0) as withdraw_fee_money')
            ->find();
        $user_day_sum['three_game_profit'] = bcdiv($user_day_sum['three_game_profit'],$amount_reduction_multiple,2);
        $user_day_sum['user_day_give'] = bcdiv($user_day_sum['user_day_give'],$amount_reduction_multiple,2);
        $user_day_sum['fee_money'] = bcdiv($user_day_sum['fee_money'],$amount_reduction_multiple,2);
        $user_day_sum['withdraw_fee_money'] = bcdiv($user_day_sum['withdraw_fee_money'],$amount_reduction_multiple,2);
        $all_data['regist_count'] = bcdiv($regist_count,$general_data_reduction_times,2);
        $all_data['regist_true_count'] = $regist_true_count;
        $all_data['recharge_num'] = bcdiv($recharge_num,$general_data_reduction_times,2);
        $all_data['recharge_price'] = $recharge_price['price'];
        $all_data['withdraw_num'] = bcdiv($withdraw_num,$general_data_reduction_times,2);
        $all_data['withdraw_price'] = $withdraw_price['money'];
        $all_data['all_withdraw_rate'] = $all_withdraw_rate;
        $all_data['all_recharge_withdraw_dif'] = $all_recharge_withdraw_dif;
        $all_data['all_profit_rate'] = $all_profit_rate;
        //$all_data['all_profit'] = $user_day_sum['self_game_profit'] + $user_day_sum['three_game_profit'] - $user_day_sum['user_day_give'] - $user_day_sum['fee_money'];
        $all_data['all_profit'] = $recharge_price['price'] - $withdraw_price['money'] - $user_day_sum['fee_money'] - $user_day_sum['withdraw_fee_money'];

        $this->assign('package_id',strpos(Session::get('package_id'), ',') !== false ? 0 : Session::get('package_id'));
        $this->assign('chanels',Session::get('chanel'));
        $this->assign('er_chanels',Session::get('er_chanel'));
        $this->assign('sharstatus',Session::get('sharstatus'));

        $this->assign('packname',$packname);
        $this->assign('status',$status);
        $this->assign('chanel',$chanel);
        $this->assign('div_data',$div_data);
        $this->assign('all_data',$all_data);
        $this->assign('cash_bonus_data',$cash_bonus_data);
        $this->assign('admin_type',$this->adminInfo['type']);
        $this->assign('admininfo',$this->adminInfo);
        $this->assign('er_chanel',$er_chanel ?? []);
        return $this->fetch();
    }


    public function getchanel(){
        $package_id = $this->request->post('package_id');
        $adminId = $this->adminId;
        $system_admin = Db::name('system_admin')->field('package_id,channels')->where('id',$adminId)->find();

        Session::set('chanel_z', 0);
        if(!$system_admin['package_id']){
            !$package_id ? Session::set('package_id', 0) : Session::set('package_id', $package_id);
            Session::set('chanel', 0);  //默认全部渠道
            $chanel = Db::name('chanel')->field('channel,cname')->where([['package_id' ,'=', $package_id],['pchannel','=',0]])->select()->toArray();
        }elseif(!$package_id){ //如果管理员有对应的包，同时没有传包id，则先显示所有渠道数据，没有渠道就显示包的数据
            $chanel = [];
            if($system_admin['channels']){
                Session::set('chanel', $system_admin['channels']);
                Session::set('package_id', 0);
            }else{
                Session::set('package_id', $system_admin['package_id']);
                Session::set('chanel', 0);
            }

        }elseif($package_id == $system_admin['package_id']){
            $chanel = $this->getPackageChannels($package_id,$system_admin['channels']);
        }elseif($system_admin['package_id']){
            $package_ids = explode(',',$system_admin['package_id']);
            if(!in_array($package_id,$package_ids)){
                return json(['code' => 201 , 'msg' => '信息获取失败','data' => []]);
            }
            $chanel = $this->getPackageChannels($package_id,$system_admin['channels']);
        }else{
            return json(['code' => 201 , 'msg' => '信息获取失败','data' => []]);
        }
        $data['chanel'] = $chanel;
        //统计
        /*$tj = [
            'on_line' => 2,
        ];
        $data['div_data'] = $tj;*/

        return json(['code' => 200 , 'msg' => '成功','data' => $data]);
    }

    /**
     * 获取包的渠道
     * @param $package_id
     * @param $system_admin_channels
     */
    private function getPackageChannels($package_id,$system_admin_channels){
        Session::set('package_id', $package_id);
        if ($this->adminInfo['type'] == 1){
            $chanelid = explode(",",$system_admin_channels);
            Session::set('chanel', $chanelid);
            $where = $system_admin_channels ? [['channel','in',$system_admin_channels]] : [];

            $chanel = Db::name('chanel')->field('channel,cname')->where($where)->where('pchannel','=',0)->select()->toArray();
        }else {
            $chanelid = !$system_admin_channels ? 0 : $this->chanels($system_admin_channels, $package_id);
            Session::set('chanel', $chanelid ?: 0);
            $where = $chanelid ? [['channel','in',$chanelid]] : [];
            $chanel = Db::name('chanel')->field('channel,cname')->where([['package_id' ,'=', $package_id],['pchannel','=',0]])->where($where)->select()->toArray();
        }
        return $chanel;
    }

    public function setchanel(){
        $chanel = $this->request->post('chanel');
        $package_id = $this->request->post('package_id');
        $sharstatus = $this->request->post('sharstatus');
        $chanel = $chanel ?: 0;
        $package_id = $package_id ?: 0;
        if($sharstatus) Session::set('sharstatus', $sharstatus);
        $adminId = $this->adminId;
        $system_admin = Db::name('system_admin')->field('package_id,channels')->where(['id' => $adminId])->find();

        $PackageChannels = explode(',',$system_admin['package_id']);
        $er_chanel_model = new Chanel();
        $er_chanel = [];
        if(!$system_admin['package_id'] && $chanel){  //选择全部的时候
            Session::set('chanel_z',$chanel);
            //下级渠道
            $er_chanel_model->getAllSubordinates3($chanel, $er_chanel);

            if ($chanel == '100000000'){
                $chanel = Db::name('system_admin')->where('channel', $chanel)->value('channels');  //allen主渠道
            }else {
                $charcid = Db::name('chanel')->where('pchannel', $chanel)->value('channel');  //子集的cid
                if ($charcid && Session::get('sharstatus') == 1) { //如果需要查看一级分享用户
                    $chanel .= ',' . $charcid;
                }
            }
            Session::set('chanel', $chanel);

        }elseif($chanel && ($system_admin['package_id'] == $package_id || in_array($package_id,$PackageChannels))){  //当渠道选择号
            Session::set('chanel_z',$chanel);
            //下级渠道
            $er_chanel_model->getAllSubordinates3($chanel, $er_chanel);

            $channelsarr = explode(',',$system_admin['channels']);
            if($system_admin['channels'] && !in_array($chanel,$channelsarr)){
                return json(['code' => 200 , 'msg' => '设置失败','data' => []]);
            }
            if ($this->adminInfo['type'] == 0) {
                $charcid = Db::name('chanel')->where('pchannel', $chanel)->value('channel');  //子集的cid
                if ($charcid && Session::get('sharstatus') == 1) {
                    $chanel .= ',' . $charcid;
                }
            }else{
                //$charcid = Db::name('chanel')->where('pchannel', $chanel)->column('channel');  //子集的cid
                //$charcid = implode(",",$charcid);
                /*if (!empty($charcid)) {
                    $chanel .= ',' . $charcid;
                }*/
                $chanel = Db::name('system_admin')->where('channel', $chanel)->value('channels');
            }
            //dd($chanel);
            Session::set('chanel', $chanel);
        }elseif(!$system_admin['package_id'] && $package_id && !$chanel){
            Session::set('package_id', $package_id);
            Session::set('chanel', 0);
            Session::set('chanel_z',0);
        }elseif ($package_id && !$chanel){
            Session::set('chanel_z',0);
            Session::set('package_id', $package_id);

            $chanelid = !$system_admin['channels'] ? 0 : $this->chanels($system_admin['channels'], $package_id);
//            if ($this->adminInfo['type'] == 1){
//                $chanelid = explode(",",$system_admin['channels']);
//            }else {
//                $chanelid = !$system_admin['channels'] ? 0 : $this->chanels($system_admin['channels'], $package_id);
//            }

            Session::set('chanel', $chanelid);
        }elseif ($package_id && $chanel){ //如果有包有渠道，
            $chanelid = explode(",",$system_admin['channels']);
            if(in_array($chanel,$chanelid)){
                Session::set('chanel', $chanel);
                Session::set('chanel_z',$chanel);
            }
        }
        $data['er_chanel'] = $er_chanel;
        return json(['code' => 200 , 'msg' => '成功','data' => $data]);
    }

    public function setErchanel(){
        $chanel = $this->request->post('chanel');
        $er_chanel = $this->request->post('er_chanel');
        $package_id = $this->request->post('package_id');
        $sharstatus = $this->request->post('sharstatus');
        if($sharstatus) Session::set('sharstatus', $sharstatus);
        $adminId = $this->adminId;
        $system_admin = Db::name('system_admin')->field('package_id,channels')->where(['id' => $adminId])->find();

        Session::set('er_chanel', $er_chanel);
        Session::set('chanel', $er_chanel);
        $data['er_chanel'] = $er_chanel;
        return json(['code' => 200 , 'msg' => '成功','data' => $data]);
    }

    /**
     * @return void 获取管理员的莫个包名的全部能查看的渠道
     */
    private function chanels($channels,$package_id){

        if(Session::get('sharstatus') == 2){  //等于不包含分享数据
            $chanel_array = Db::name('chanel')->field('channel')
                ->where([['channel','in',$channels],['package_id' ,'in', $package_id]])
                ->select()
                ->toArray();
        }else{  //包含分享一级数据
            $chanel_array = Db::name('chanel')->field('channel')
                ->where([['channel','in',$channels],['package_id' ,'in', $package_id]])
                ->whereOr(function ($query) use($channels){
                    $query->where([['pchannel','in',$channels]]);
                })
                ->select()
                ->toArray();
        }

        $chanelid = array_map('array_shift', $chanel_array);
        return $chanelid;
    }

    /**
     * 用户图表
     */
    public function userchart()
    {
//        header('Content-type:text/json');
//
//        $starday = date('Y-m-d', strtotime('-30 day'));
//        $yesterday = date('Y-m-d');
//
//        $user_list = UserModel::where('add_time', 'between time', [$starday, $yesterday])
//            ->field("FROM_UNIXTIME(add_time,'%m-%e') as day,count(*) as count")
//            ->group("FROM_UNIXTIME(add_time, '%Y%m%e')")
//            ->order('add_time asc')
//            ->select()->toArray();
//        $chartdata = [];
//        $data = [];
//        $chartdata['legend'] = ['用户数'];//分类
//        $chartdata['yAxis']['maxnum'] = 0;//最大值数量
//        $chartdata['xAxis'] = [date('m-d')];//X轴值
//        $chartdata['series'] = [0];//分类1值
//        if (!empty($user_list)) {
//            foreach ($user_list as $k => $v) {
//                $data['day'][] = $v['day'];
//                $data['count'][] = $v['count'];
//                if ($chartdata['yAxis']['maxnum'] < $v['count'])
//                    $chartdata['yAxis']['maxnum'] = $v['count'];
//            }
//            $chartdata['xAxis'] = $data['day'];//X轴值
//            $chartdata['series'] = $data['count'];//分类1值
//        }
        return app('json')->success('ok', []);
    }

    /**
     * 待办事统计
     * @param int $newTime
     * @return false|string
     */
    public function Jnotice($newTime = 30)
    {
//        header('Content-type:text/json');
//        $data = [];
//        $data['ordernum'] = StoreOrderModel::statusByWhere(1)->count();//待发货
//        $replenishment_num = sys_config('store_stock') > 0 ? sys_config('store_stock') : 2;//库存预警界限
//        $data['inventory'] = ProductModel::where('stock', '<=', $replenishment_num)->where('is_show', 1)->where('is_del', 0)->count();//库存
//        $data['commentnum'] = StoreProductReplyModel::where('is_reply', 0)->count();//评论
//        $data['reflectnum'] = UserExtractModel::where('status', 0)->count();;//提现
//        $data['msgcount'] = intval($data['ordernum']) + intval($data['inventory']) + intval($data['commentnum']) + intval($data['reflectnum']);
//        //新订单提醒
//        $data['newOrderId'] = StoreOrderModel::statusByWhere(1)->where('is_remind', 0)->column('order_id', 'id');
//        if (count($data['newOrderId'])) StoreOrderModel::where('order_id', 'in', $data['newOrderId'])->update(['is_remind' => 1]);
        return app('json')->success('ok', []);
    }

    /**
     * 订单图表
     */
    public function orderchart(){
        header('Content-type:text/json');
        $cycle = $this->request->param('cycle')?:'week';//默认30天
        $datalist = [];
        $chan_where = [];
        if (!empty($this->sqlNewWhere)){
            $chan_where = [$this->sqlNewWhere];
        }

        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数
        $general_data_reduction_times = config('my.general_data_reduction_times'); //后台人数,订单,游戏次数缩小倍数

        //平台与渠道
        $channel_where = [];
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$channel_where = [['channel', '<', 100000000]];
            } else {
                $channel_where = [['channel', '>=', 100000000]];
            }
        }

        switch ($cycle){
            case 'thirtyday':
                $datebefor = date('Y-m-d',strtotime('-30 day'));
                $dateafter = date('Y-m-d',strtotime('+1 day'));
                //上期
                $pre_datebefor = date('Y-m-d',strtotime('-60 day'));
                $pre_dateafter = date('Y-m-d',strtotime('-30 day'));
                for($i=-30;$i < 1;$i++){
                    $datalist[date('m-d',strtotime($i.' day'))] = date('m-d',strtotime($i.' day'));
                }

                $order_list = Db::name('order')->where('createtime','between time',[$datebefor,$dateafter])
                    ->field("FROM_UNIXTIME(createtime,'%m-%d') as day,count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->group("FROM_UNIXTIME(createtime, '%Y%m%d')")
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->order('createtime asc')
                    ->select()->toArray();
                //var_dump($order_list);exit;
                $w_where = [['finishtime','>=', strtotime($datebefor)], ['finishtime','<',strtotime($dateafter)]];
                $order_list1 = Db::name('withdraw_log')->where('createtime','between time',[$datebefor,$dateafter])
                    ->field("FROM_UNIXTIME(finishtime,'%m-%d') as day,count(*) as count,IFNULL(floor(sum(money)),0) as price")
                    ->group("FROM_UNIXTIME(finishtime, '%Y%m%d')")
                    ->where("status",1)
                    ->where("auditdesc",'<>',7)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->whereOr(function($query) use ($w_where,$chan_where,$channel_where){$query->where($w_where)->where("status",1)->where("auditdesc",'<>',9)->where($chan_where)->where($channel_where);})
                    ->order('createtime asc')
                    ->select()->toArray();
//                 var_dump($order_list);
//                var_dump($order_list1);exit;
                foreach ($order_list as $key => &$value){
                    // $num=AgentSendlog::where("DATE_FORMAT(timestamp,'%m-%d')='".$order_list[$key]['day']."'")->sum('num');
                    // $num=0;
                    // $order_list[$key]['price']=bcadd($order_list[$key]['price'],bcdiv($num,100,2),2);
                    $value['price'] = bcdiv($value['price'],$amount_reduction_multiple,2);
                    $order_list[$key]['count']=0;
                    foreach ($order_list1 as &$value1)
                    {
                        //$value1['price'] =  bcdiv($value1['price'],$amount_reduction_multiple,2);
                        if($value1['day']==$order_list[$key]['day']){
                            $order_list[$key]['count'] = bcdiv($value1['price'],$amount_reduction_multiple,2);
                            break;
                        }
                    }
                }
                //var_dump($order_list);exit;
                if(empty($order_list)) return json(['code' => 201 , 'msg' => '无数据','data' => []]);
                foreach ($order_list as $k=>&$v){
                    $order_list[$v['day']] = $v;
                }
                $cycle_list = [];
                foreach ($datalist as $dk=>$dd){
                    if(!empty($order_list[$dd])){
                        $cycle_list[$dd] = $order_list[$dd];
                    }else{
                        $cycle_list[$dd] = ['count'=>0,'day'=>$dd,'price'=>''];
                    }
                }
                $chartdata = [];
                $data = [];//临时
                $chartdata['yAxis']['maxnum'] = 0;//最大值数量
                $chartdata['yAxis']['maxprice'] = 0;//最大值金额
                foreach ($cycle_list as $k=>$v){
                    $data['day'][] = $v['day'];
                    $data['count'][] = $v['count'];
                    $data['price'][] = round($v['price'],2);
                    if($chartdata['yAxis']['maxnum'] < $v['count'])
                        $chartdata['yAxis']['maxnum'] = $v['count'];//日最大订单数
                    if($chartdata['yAxis']['maxprice'] < $v['price'])
                        $chartdata['yAxis']['maxprice'] = $v['price'];//日最大金额
                }
                $chartdata['legend'] = ['充值金额','提现金额'];//分类
                $chartdata['xAxis'] = $data['day'];//X轴值
                //,'itemStyle'=>$series
                $series= ['normal'=>['label'=>['show'=>true,'position'=>'top']]];
                $chartdata['series'][] = ['name'=>$chartdata['legend'][0],'type'=>'bar','itemStyle'=>$series,'data'=>$data['price']];//分类1值
                $chartdata['series'][] = ['name'=>$chartdata['legend'][1],'type'=>'bar','itemStyle'=>$series,'data'=>$data['count']];//分类2值
                //统计总数上期
                $pre_total = Db::name('order')->where('createtime','between time',[$pre_datebefor,$pre_dateafter])
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->field("count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->find();
                // foreach ($pre_total as $key => $value){
                //     $num=AgentSendlog::where("DATE_FORMAT(timestamp,'%m-%d')='".$pre_total[$key]['day']."'")->sum('num');
                //     $pre_total[$key]['price']=bcadd($pre_total[$key]['price'],bcdiv($num,100,2),2);
                // }
                if($pre_total){
                    $pre_total['price'] = bcdiv($pre_total['price'],$amount_reduction_multiple,2);
                    $chartdata['pre_cycle']['count'] = [
                        'data' => $pre_total['count']? : 0
                    ];
                    $chartdata['pre_cycle']['price'] = [
                        'data' => $pre_total['price'] ?: 0,
                    ];
                }
                //统计总数
                $total = Db::name('order')->where('createtime','between time',[$datebefor,$dateafter])
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->field("count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->find();
                if($total){
                    $total['price'] = bcdiv($total['price'],$amount_reduction_multiple,2);
                    $cha_count = intval($pre_total['count']) - intval($total['count']);
                    $pre_total['count'] = $pre_total['count']==0 ? 1 : $pre_total['count'];
                    $chartdata['cycle']['count'] = [
                        'data' => $total['count']? : 0,
                        'percent' => round((abs($cha_count)/intval($pre_total['count'])*100),2),
                        'is_plus' => $cha_count > 0 ? -1 : ($cha_count == 0 ? 0 : 1)
                    ];
                    $cha_price = round($pre_total['price'],2) - round($total['price'],2);
                    $pre_total['price'] = $pre_total['price']==0 ? 1 : $pre_total['price'];
                    $chartdata['cycle']['price'] = [
                        'data' => $total['price']? : 0,
                        'percent' => round(abs($cha_price)/$pre_total['price']*100,2),
                        'is_plus' => $cha_price > 0 ? -1 : ($cha_price == 0 ? 0 : 1)
                    ];
                }
                //return Json::succ('ok',$chartdata);
                return json(['code' => 200 , 'msg' => 'ok','data' => $chartdata]);
                break;
            case 'week':
                $weekarray=array(['周日'],['周一'],['周二'],['周三'],['周四'],['周五'],['周六']);
                //$datebefor = date('Y-m-d',strtotime('-1 monday'));
                $now = time();
                $time = $now - 86400 * (date('N', $now) - 1);
                $monday_date = $time - 7 *86400;
                $datebefor = date("Y-m-d",$monday_date);
                $dateafter = date('Y-m-d',strtotime('-1 week Sunday'));
                $order_list = Db::name('order')->where('createtime','between time',[$datebefor,$dateafter])
                    ->field("FROM_UNIXTIME(createtime,'%w') as day,count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->group("FROM_UNIXTIME(createtime, '%Y%m%e')")
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->order('createtime asc')
                    ->select()->toArray();
                // foreach ($order_list as $key => $value){
                //     $num=AgentSendlog::where('timestamp','between time',[$datebefor,$dateafter])->where("DATE_FORMAT(timestamp,'%w')='".$order_list[$key]['day']."'")->sum('num');
                //     $order_list[$key]['price']=bcadd($order_list[$key]['price'],bcdiv($num,100,2),2);
                // }
                //数据查询重新处理
                $new_order_list = [];
                foreach ($order_list as $k=>$v){
                    $v['price'] = bcdiv($v['price'],$amount_reduction_multiple,2);
                    $new_order_list[$v['day']] = $v;
                }
                $now_datebefor = date('Y-m-d', (time() - ((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));
                $now_dateafter = date('Y-m-d',strtotime("+1 day"));
                $now_order_list = Db::name('order')->where('createtime','between time',[$now_datebefor,$now_dateafter])
                    ->field("FROM_UNIXTIME(createtime,'%w') as day,count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->group("FROM_UNIXTIME(createtime, '%Y%m%e')")
                    ->where("pay_status", 1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->order('createtime asc')
                    ->select()->toArray();
                // foreach ($now_order_list as $key => $value){
                //     $num=AgentSendlog::where("DATE_FORMAT(timestamp,'%w')='".$now_order_list[$key]['day']."'")->sum('num');
                //     $now_order_list[$key]['price']=bcadd($now_order_list[$key]['price'],bcdiv($num,100,2),2);
                // }
                //数据查询重新处理 key 变为当前值
                $new_now_order_list = [];
                foreach ($now_order_list as $k=>$v){
                    $v['price'] = bcdiv($v['price'],$amount_reduction_multiple,2);
                    $new_now_order_list[$v['day']] = $v;
                }
                foreach ($weekarray as $dk=>$dd){
                    if(!empty($new_order_list[$dk])){
                        $weekarray[$dk]['pre'] = $new_order_list[$dk];
                    }else{
                        $weekarray[$dk]['pre'] = ['count'=>0,'day'=>$weekarray[$dk][0],'price'=>'0'];
                    }
                    if(!empty($new_now_order_list[$dk])){
                        $weekarray[$dk]['now'] = $new_now_order_list[$dk];
                    }else{
                        $weekarray[$dk]['now'] = ['count'=>0,'day'=>$weekarray[$dk][0],'price'=>'0'];
                    }
                }
                $chartdata = [];
                $data = [];//临时
                $chartdata['yAxis']['maxnum'] = 0;//最大值数量
                $chartdata['yAxis']['maxprice'] = 0;//最大值金额
                foreach ($weekarray as $k=>$v){
                    $data['day'][] = $v[0];
                    $data['pre']['count'][] = $v['pre']['count'];
                    $data['pre']['price'][] = round($v['pre']['price'],2);
                    $data['now']['count'][] = $v['now']['count'];
                    $data['now']['price'][] = round($v['now']['price'],2);
                    if($chartdata['yAxis']['maxnum'] < $v['pre']['count'] || $chartdata['yAxis']['maxnum'] < $v['now']['count']){
                        $chartdata['yAxis']['maxnum'] = $v['pre']['count']>$v['now']['count']?$v['pre']['count']:$v['now']['count'];//日最大订单数
                    }
                    if($chartdata['yAxis']['maxprice'] < $v['pre']['price'] || $chartdata['yAxis']['maxprice'] < $v['now']['price']){
                        $chartdata['yAxis']['maxprice'] = $v['pre']['price']>$v['now']['price']?$v['pre']['price']:$v['now']['price'];//日最大金额
                    }
                }
                $chartdata['legend'] = ['上周充值金额','本周充值金额','上周充值笔数','本周充值笔数'];//分类
                $chartdata['xAxis'] = $data['day'];//X轴值
                //,'itemStyle'=>$series
                $series= ['normal'=>['label'=>['show'=>true,'position'=>'top']]];
                $chartdata['series'][] = ['name'=>$chartdata['legend'][0],'type'=>'bar','itemStyle'=>$series,'data'=>$data['pre']['price']];//分类1值
                $chartdata['series'][] = ['name'=>$chartdata['legend'][1],'type'=>'bar','itemStyle'=>$series,'data'=>$data['now']['price']];//分类1值
                $chartdata['series'][] = ['name'=>$chartdata['legend'][2],'type'=>'line','itemStyle'=>$series,'data'=>$data['pre']['count']];//分类2值
                $chartdata['series'][] = ['name'=>$chartdata['legend'][3],'type'=>'line','itemStyle'=>$series,'data'=>$data['now']['count']];//分类2值

                //统计总数上期
                $pre_total = Db::name('order')->where('createtime','between time',[$datebefor,$dateafter])
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->field("count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->find();
                // foreach ($pre_total as $key => $value){
                //     $num=AgentSendlog::where('timestamp','between time',[$datebefor,$dateafter])->where("DATE_FORMAT(timestamp,'%m-%d')='".$pre_total[$key]['day']."'")->sum('num');
                //     $pre_total[$key]['price']=bcadd($pre_total[$key]['price'],bcdiv($num,100,2),2);
                // }
                if($pre_total){
                    $pre_total['price'] = bcdiv($pre_total['price'],$amount_reduction_multiple,2);
                    $chartdata['pre_cycle']['count'] = [
                        'data' => $pre_total['count']? : 0
                    ];
                    $chartdata['pre_cycle']['price'] = [
                        'data' => $pre_total['price']? : 0
                    ];
                }
                //统计总数
                $total = Db::name('order')->where('createtime','between time',[$now_datebefor,$now_dateafter])
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->field("count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->find();
                if($total){
                    $total['price'] = bcdiv($total['price'],$amount_reduction_multiple,2);
                    $cha_count = intval($pre_total['count']) - intval($total['count']);
                    $pre_total['count'] = $pre_total['count']==0 ? 1 : $pre_total['count'];
                    $chartdata['cycle']['count'] = [
                        'data' => $total['count']? : 0,
                        'percent' => round((abs($cha_count)/intval($pre_total['count'])*100),2),
                        'is_plus' => $cha_count > 0 ? -1 : ($cha_count == 0 ? 0 : 1)
                    ];
                    $cha_price = round($pre_total['price'],2) - round($total['price'],2);
                    $pre_total['price'] = $pre_total['price']==0 ? 1 : $pre_total['price'];
                    $chartdata['cycle']['price'] = [
                        'data' => $total['price']? : 0,
                        'percent' => round(abs($cha_price)/$pre_total['price']*100,2),
                        'is_plus' => $cha_price > 0 ? -1 : ($cha_price == 0 ? 0 : 1)
                    ];
                }
                return json(['code' => 200 , 'msg' => 'ok','data' => $chartdata]);
                break;
            case 'month':
                $weekarray=array('01'=>['1'],'02'=>['2'],'03'=>['3'],'04'=>['4'],'05'=>['5'],'06'=>['6'],'07'=>['7'],'08'=>['8'],'09'=>['9'],'10'=>['10'],'11'=>['11'],'12'=>['12'],'13'=>['13'],'14'=>['14'],'15'=>['15'],'16'=>['16'],'17'=>['17'],'18'=>['18'],'19'=>['19'],'20'=>['20'],'21'=>['21'],'22'=>['22'],'23'=>['23'],'24'=>['24'],'25'=>['25'],'26'=>['26'],'27'=>['27'],'28'=>['28'],'29'=>['29'],'30'=>['30'],'31'=>['31']);

                $datebefor = date('Y-m-01',strtotime('-1 month'));
                $dateafter = date('Y-m-d',strtotime(date('Y-m-01')));
                $order_list = Db::name('order')->where('createtime','between time',[$datebefor,$dateafter])
                    ->field("FROM_UNIXTIME(createtime,'%d') as day,count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->group("FROM_UNIXTIME(createtime, '%Y%m%e')")
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->order('createtime asc')
                    ->select()->toArray();
                // foreach ($order_list as $key => $value){
                //     $num=AgentSendlog::where('timestamp','between time',[$datebefor,$dateafter])->where("DATE_FORMAT(timestamp,'%d')='".$order_list[$key]['day']."'")->sum('num');
                //     $order_list[$key]['price']=bcadd($order_list[$key]['price'],bcdiv($num,100,2),2);
                // }
                //数据查询重新处理
                $new_order_list = [];
                foreach ($order_list as $k=>$v){
                    $v['price'] = bcdiv($v['price'],$amount_reduction_multiple,2);
                    $new_order_list[$v['day']] = $v;
                }
                $now_datebefor = date('Y-m-01');
                $now_dateafter = date('Y-m-d',strtotime("+1 day"));
                $now_order_list = Db::name('order')->where('createtime','between time',[$now_datebefor,$now_dateafter])
                    ->field("FROM_UNIXTIME(createtime,'%d') as day,count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->group("FROM_UNIXTIME(createtime, '%Y%m%e')")
                    ->where("pay_status", 1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->order('createtime asc')
                    ->select()->toArray();
                // foreach ($now_order_list as $key => $value){
                //     $num=AgentSendlog::where('timestamp','between time',[$now_datebefor,$now_dateafter])->where("DATE_FORMAT(timestamp,'%d')='".$now_order_list[$key]['day']."'")->sum('num');
                //     $now_order_list[$key]['price']=bcadd($now_order_list[$key]['price'],bcdiv($num,100,2),2);
                // }
                //数据查询重新处理 key 变为当前值
                $new_now_order_list = [];
                foreach ($now_order_list as $k=>$v){
                    $v['price'] = bcdiv($v['price'],$amount_reduction_multiple,2);
                    $new_now_order_list[$v['day']] = $v;
                }
                foreach ($weekarray as $dk=>$dd){
                    if(!empty($new_order_list[$dk])){
                        $weekarray[$dk]['pre'] = $new_order_list[$dk];
                    }else{
                        $weekarray[$dk]['pre'] = ['count'=>0,'day'=>$weekarray[$dk][0],'price'=>'0'];
                    }
                    if(!empty($new_now_order_list[$dk])){
                        $weekarray[$dk]['now'] = $new_now_order_list[$dk];
                    }else{
                        $weekarray[$dk]['now'] = ['count'=>0,'day'=>$weekarray[$dk][0],'price'=>'0'];
                    }
                }
                $chartdata = [];
                $data = [];//临时
                $chartdata['yAxis']['maxnum'] = 0;//最大值数量
                $chartdata['yAxis']['maxprice'] = 0;//最大值金额
                foreach ($weekarray as $k=>$v){
                    $data['day'][] = $v[0];
                    $data['pre']['count'][] = $v['pre']['count'];
                    $data['pre']['price'][] = round($v['pre']['price'],2);
                    $data['now']['count'][] = $v['now']['count'];
                    $data['now']['price'][] = round($v['now']['price'],2);
                    if($chartdata['yAxis']['maxnum'] < $v['pre']['count'] || $chartdata['yAxis']['maxnum'] < $v['now']['count']){
                        $chartdata['yAxis']['maxnum'] = $v['pre']['count']>$v['now']['count']?$v['pre']['count']:$v['now']['count'];//日最大订单数
                    }
                    if($chartdata['yAxis']['maxprice'] < $v['pre']['price'] || $chartdata['yAxis']['maxprice'] < $v['now']['price']){
                        $chartdata['yAxis']['maxprice'] = $v['pre']['price']>$v['now']['price']?$v['pre']['price']:$v['now']['price'];//日最大金额
                    }

                }
                $chartdata['legend'] = ['上月充值金额','本月充值金额','上月充值笔数','本月充值笔数'];//分类
                $chartdata['xAxis'] = $data['day'];//X轴值
                //,'itemStyle'=>$series
                $series= ['normal'=>['label'=>['show'=>true,'position'=>'top']]];
                $chartdata['series'][] = ['name'=>$chartdata['legend'][0],'type'=>'bar','itemStyle'=>$series,'data'=>$data['pre']['price']];//分类1值
                $chartdata['series'][] = ['name'=>$chartdata['legend'][1],'type'=>'bar','itemStyle'=>$series,'data'=>$data['now']['price']];//分类1值
                $chartdata['series'][] = ['name'=>$chartdata['legend'][2],'type'=>'line','itemStyle'=>$series,'data'=>$data['pre']['count']];//分类2值
                $chartdata['series'][] = ['name'=>$chartdata['legend'][3],'type'=>'line','itemStyle'=>$series,'data'=>$data['now']['count']];//分类2值

                //统计总数上期
                $pre_total = Db::name('order')->where('createtime','between time',[$datebefor,$dateafter])
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->field("count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->find();
                // foreach ($pre_total as $key => $value){
                //     $num=AgentSendlog::where('timestamp','between time',[$datebefor,$dateafter])->where("DATE_FORMAT(timestamp,'%d')='".$pre_total[$key]['day']."'")->sum('num');
                //     $pre_total[$key]['price']=bcadd($now_order_list[$key]['price'],bcdiv($num,100,2),2);
                // }
                if($pre_total){
                    $pre_total['price'] = bcdiv($pre_total['price'],$amount_reduction_multiple,2);
                    $chartdata['pre_cycle']['count'] = [
                        'data' => $pre_total['count']? : 0
                    ];
                    $chartdata['pre_cycle']['price'] = [
                        'data' => $pre_total['price']? : 0
                    ];
                }
                //统计总数
                $total = Db::name('order')->where('createtime','between time',[$now_datebefor,$now_dateafter])
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->field("count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->find();
                if($total){
                    $total['price'] = bcdiv($total['price'],$amount_reduction_multiple,2);
                    $cha_count = intval($pre_total['count']) - intval($total['count']);
                    $pre_total['count'] = $pre_total['count']==0 ? 1 : $pre_total['count'];
                    $chartdata['cycle']['count'] = [
                        'data' => $total['count']? : 0,
                        'percent' => round((abs($cha_count)/intval($pre_total['count'])*100),2),
                        'is_plus' => $cha_count > 0 ? -1 : ($cha_count == 0 ? 0 : 1)
                    ];
                    $cha_price = round($pre_total['price'],2) - round($total['price'],2);
                    $pre_total['price'] = $pre_total['price']==0 ? 1 : $pre_total['price'];
                    $chartdata['cycle']['price'] = [
                        'data' => $total['price']? : 0,
                        'percent' => round(abs($cha_price)/$pre_total['price']*100,2),
                        'is_plus' => $cha_price > 0 ? -1 : ($cha_price == 0 ? 0 : 1)
                    ];
                }
                return json(['code' => 200 , 'msg' => 'ok','data' => $chartdata]);
                break;
            case 'year':
                $weekarray=array('01'=>['一月'],'02'=>['二月'],'03'=>['三月'],'04'=>['四月'],'05'=>['五月'],'06'=>['六月'],'07'=>['七月'],'08'=>['八月'],'09'=>['九月'],'10'=>['十月'],'11'=>['十一月'],'12'=>['十二月']);
                $datebefor = date('Y-01-01',strtotime('-1 year'));
                $dateafter = date('Y-12-31',strtotime('-1 year'));
                $order_list = Db::name('order')->where('createtime','between time',[$datebefor,$dateafter])
                    ->field("FROM_UNIXTIME(createtime,'%m') as day,count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->group("FROM_UNIXTIME(createtime, '%Y%m')")
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->order('createtime asc')
                    ->select()->toArray();
                //数据查询重新处理
                $new_order_list = [];
                foreach ($order_list as $k=>$v){
                    $v['price'] = bcdiv($v['price'],$amount_reduction_multiple,2);
                    $new_order_list[$v['day']] = $v;
                }
                $now_datebefor = date('Y-01-01');
                $now_dateafter = date('Y-m-d');
                $now_order_list = Db::name('order')->where('createtime','between time',[$now_datebefor,$now_dateafter])
                    ->field("FROM_UNIXTIME(createtime,'%m') as day,count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->group("FROM_UNIXTIME(createtime, '%Y%m')")
                    ->where("pay_status",1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->order('createtime asc')
                    ->select()->toArray();
                // foreach ($now_order_list as $key => $value){
                //     $num=AgentSendlog::where("DATE_FORMAT(timestamp,'%m-%d')='".$now_order_list[$key]['day']."'")->sum('num');
                //     $now_order_list[$key]['price']=bcadd($now_order_list[$key]['price'],bcdiv($num,100,2),2);
                // }
                //数据查询重新处理 key 变为当前值
                $new_now_order_list = [];
                foreach ($now_order_list as $k=>$v){
                    $v['price'] = bcdiv($v['price'],$amount_reduction_multiple,2);
                    $new_now_order_list[$v['day']] = $v;
                }
                foreach ($weekarray as $dk=>$dd){
                    if(!empty($new_order_list[$dk])){
                        $weekarray[$dk]['pre'] = $new_order_list[$dk];
                    }else{
                        $weekarray[$dk]['pre'] = ['count'=>0,'day'=>$weekarray[$dk][0],'price'=>'0'];
                    }
                    if(!empty($new_now_order_list[$dk])){
                        $weekarray[$dk]['now'] = $new_now_order_list[$dk];
                    }else{
                        $weekarray[$dk]['now'] = ['count'=>0,'day'=>$weekarray[$dk][0],'price'=>'0'];
                    }
                }
                $chartdata = [];
                $data = [];//临时
                $chartdata['yAxis']['maxnum'] = 0;//最大值数量
                $chartdata['yAxis']['maxprice'] = 0;//最大值金额
                foreach ($weekarray as $k=>$v){
                    $data['day'][] = $v[0];
                    $data['pre']['count'][] = $v['pre']['count'];
                    $data['pre']['price'][] = round($v['pre']['price'],2);
                    $data['now']['count'][] = $v['now']['count'];
                    $data['now']['price'][] = round($v['now']['price'],2);
                    if($chartdata['yAxis']['maxnum'] < $v['pre']['count'] || $chartdata['yAxis']['maxnum'] < $v['now']['count']){
                        $chartdata['yAxis']['maxnum'] = $v['pre']['count']>$v['now']['count']?$v['pre']['count']:$v['now']['count'];//日最大订单数
                    }
                    if($chartdata['yAxis']['maxprice'] < $v['pre']['price'] || $chartdata['yAxis']['maxprice'] < $v['now']['price']){
                        $chartdata['yAxis']['maxprice'] = $v['pre']['price']>$v['now']['price']?$v['pre']['price']:$v['now']['price'];//日最大金额
                    }
                }
                $chartdata['legend'] = ['去年充值金额','今年充值金额','去年充值笔数','今年充值笔数'];//分类
                $chartdata['xAxis'] = $data['day'];//X轴值
                //,'itemStyle'=>$series
                $series= ['normal'=>['label'=>['show'=>true,'position'=>'top']]];
                $chartdata['series'][] = ['name'=>$chartdata['legend'][0],'type'=>'bar','itemStyle'=>$series,'data'=>$data['pre']['price']];//分类1值
                $chartdata['series'][] = ['name'=>$chartdata['legend'][1],'type'=>'bar','itemStyle'=>$series,'data'=>$data['now']['price']];//分类1值
                $chartdata['series'][] = ['name'=>$chartdata['legend'][2],'type'=>'line','itemStyle'=>$series,'data'=>$data['pre']['count']];//分类2值
                $chartdata['series'][] = ['name'=>$chartdata['legend'][3],'type'=>'line','itemStyle'=>$series,'data'=>$data['now']['count']];//分类2值

                //统计总数上期
                $pre_total = Db::name('order')->where('createtime','between time',[$datebefor,$dateafter])
                    ->where("pay_status", 1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->field("count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->find();
                // foreach ($pre_total as $key => $value){
                //     $num=AgentSendlog::where("DATE_FORMAT(timestamp,'%m-%d')='".$pre_total[$key]['day']."'")->sum('num');
                //     $pre_total[$key]['price']=bcadd($pre_total[$key]['price'],bcdiv($num,100,2),2);
                // }
                if($pre_total){
                    $pre_total['price'] = bcdiv($pre_total['price'],$amount_reduction_multiple,2);
                    $chartdata['pre_cycle']['count'] = [
                        'data' => $pre_total['count']? : 0
                    ];
                    $chartdata['pre_cycle']['price'] = [
                        'data' => $pre_total['price']? : 0
                    ];
                }
                //统计总数
                $total = Db::name('order')->where('createtime','between time',[$now_datebefor,$now_dateafter])
                    ->where("pay_status", 1)
                    ->where($chan_where)
                    ->where($channel_where)
                    ->field("count(*) as count,IFNULL(floor(sum(price)),0) as price")
                    ->find();
                if($total){
                    $total['price'] = bcdiv($total['price'],$amount_reduction_multiple,2);
                    $cha_count = intval($pre_total['count']) - intval($total['count']);
                    $pre_total['count'] = $pre_total['count']==0 ? 1 : $pre_total['count'];
                    $chartdata['cycle']['count'] = [
                        'data' => $total['count']? : 0,
                        'percent' => round((abs($cha_count)/intval($pre_total['count'])*100),2),
                        'is_plus' => $cha_count > 0 ? -1 : ($cha_count == 0 ? 0 : 1)
                    ];
                    $cha_price = round($pre_total['price'],2) - round($total['price'],2);
                    $pre_total['price'] = $pre_total['price']==0 ? 1 : $pre_total['price'];
                    $chartdata['cycle']['price'] = [
                        'data' => $total['price']? : 0,
                        'percent' => round(abs($cha_price)/$pre_total['price']*100,2),
                        'is_plus' => $cha_price > 0 ? -1 : ($cha_price == 0 ? 0 : 1)
                    ];
                }
                return json(['code' => 200 , 'msg' => 'ok','data' => $chartdata]);
                break;
            default:
                break;
        }
    }


    /**
     * 活跃用户图表
     */
    public function useractivechart(){
        header('Content-type:text/json');
        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数
        $general_data_reduction_times = config('my.general_data_reduction_times'); //后台人数,订单,游戏次数缩小倍数
        $chan_where = [];
        if (!empty($this->sqlNewWhere)){
            $chan_where = [$this->sqlNewWhere];
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

        $starday = date('Y-m-d',strtotime('-30 day'));
        $yesterday = date('Y-m-d');
        $timearray=$this->getDateFromRange($starday,$yesterday);
        $active_array=array();
        foreach ($timearray as $key => $value){
//            $user_list = UserModel::where('add_time','between time',[$starday,$yesterday])
//                ->field("FROM_UNIXTIME(add_time,'%m-%e') as day,count(*) as count")
//                ->group("FROM_UNIXTIME(add_time, '%Y%m%e')")
//                ->order('add_time asc')
//                ->select()->toArray();
            $logintable_name = "login_".str_replace("-","",$value);
            $isloginTable = Db::query('SHOW TABLES LIKE '."'br_".$logintable_name."'");
            if($isloginTable){
                //表存在
                $daycount["day"]=$value;
                $daycount["count"]=Db::name($logintable_name)->where($chan_where)->where('channel','<>',0)->distinct("uid")->count();
                $registable_name = "regist_".str_replace("-","",$value);
                $isregisTable = Db::query('SHOW TABLES LIKE '."'br_".$registable_name."'");
                if($isregisTable){
                    //表存在
                    $daycount["price"]=Db::name($registable_name)->where($chan_where)->where($channel_where)->count();
                    $daycount['true_num'] = Db::name($registable_name)->where($chan_where)->where('channel','<>',0)->where($channel_where)->count();
                }else{
                    $daycount["price"]=0;
                    $daycount["true_num"]=0;
                }
                array_push($active_array,$daycount);
            }else{
                $daycount["day"]=$value;
                $daycount["count"]=0;
                $daycount["price"]=0;
                $daycount["true_num"]=0;
                array_push($active_array,$daycount);
            }
        }
        $chartdata = [];
        $data = [];
        $chartdata['legend'] = ['活跃用户','注册用户','真金注册'];//分类
        $chartdata['yAxis']['maxnum'] = 0;//最大值数量
        if(empty($active_array))return json(['code' => 201 , 'msg' => '无数据','data' => []]);
        foreach ($active_array as $k=>$v){
            $v['count'] = bcdiv($v['count'],$general_data_reduction_times,2);
            $v['price'] = bcdiv($v['price'],$general_data_reduction_times,2);
            $v['true_num'] = bcdiv($v['true_num'],$general_data_reduction_times,2);
            $data['day'][] = $v['day'];
            $data['count'][] = $v['count'];
            $data['price'][] = $v['price'];
            $data['true_num'][] = $v['true_num'];
            if($chartdata['yAxis']['maxnum'] < $v['count'])
                $chartdata['yAxis']['maxnum'] = $v['count'];
            if($chartdata['yAxis']['maxnum'] < $v['price'])
                $chartdata['yAxis']['maxnum'] = $v['price'];
            if($chartdata['yAxis']['maxnum'] < $v['true_num'])
                $chartdata['yAxis']['maxnum'] = $v['true_num'];
        }
        $chartdata['xAxis'] = $data['day'];//X轴值
        $series= ['normal'=>['label'=>['show'=>true,'position'=>'top']]];
        $chartdata['series'][] = ['name'=>$chartdata['legend'][0],'type'=>'bar','itemStyle'=>$series,'data'=>$data['count']];//分类1值
        $chartdata['series'][] = ['name'=>$chartdata['legend'][1],'type'=>'bar','itemStyle'=>$series,'data'=>$data['price']];//分类2值
        $chartdata['series'][] = ['name'=>$chartdata['legend'][2],'type'=>'bar','itemStyle'=>$series,'data'=>$data['true_num']];//分类3值

        return json(['code' => 200 , 'msg' => 'ok','data' => $chartdata]);
    }

    /**
     * 获取指定日期段内每一天的日期
     * @param Date $startdate 开始日期
     * @param Date $enddate 结束日期
     * @return Array
     */
    public static function getDateFromRange($startdate, $enddate)
    {
        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);
        // 计算日期段内有多少天
        $days = ($etimestamp - $stimestamp) / 86400 + 1;
        // 保存每天日期
        $date = array();
        for ($i = 0; $i < $days; $i++) {
            $date[] = date('Y-m-d', $stimestamp + (86400 * $i));
        }
        return $date;
    }

    public function orderDayData(){
        $chan_where = [];
        if (!empty($this->sqlNewWhere)){
            $chan_where = [$this->sqlNewWhere];
        }
        $datearr = getHalfDate();
        dd($datearr);


    }

    /**
     * 获取告警数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function messageGet()
    {
        //提现
        $withdraw_count = Db::name('withdraw_log')
            ->alias('a')
            ->join('withdraw_logcenter b ','b.withdraw_id = a.id')
            ->where('a.status',3)
            ->where('a.black_status',0)
            ->where('a.idle_order',0)
            ->count();

        //支付
        $is_suc_kiki = 0;
        $pay_all_num = Db::name('order')->whereDay('createtime')->count();
        $pay_suc_num = Db::name('order')->whereDay('createtime')->where('pay_status',1)->count();
        $pay_suc_rate_num = $pay_all_num>0 ? round(bcdiv($pay_suc_num,$pay_all_num,4)*100,2) : 0;//订单成功率
        if ($pay_suc_rate_num < 30){
            $is_suc_kiki = 1;
        }

        $list = [
            [
                'text' => '退款待审核',
                'count' => $withdraw_count,
                'url' => "/admin/coin.Withdrawlog/index?is_mess=1"
            ],
            [
                'text' => '支付成功率过低',
                'count' => $is_suc_kiki,
                'url' => "/admin/coin.Order/index"
            ]
        ];

        //商户余额
        $min_balance = 50000;
        $pay_type = ['rr_pay','x_pay','ser_pay','tm_pay','joy_pay','z_pay','waka_pay','ab_pay','fun_pay','go_pay'];//'win_pay','well_pay','qart_pay',
        $pay_type = Db::name('withdraw_type')->whereIn('name',$pay_type)->where('status',1)->select()->toArray();
        $balance_count = 0;
        if (!empty($pay_type)){
            foreach ($pay_type as $ptk=>$ptv){
                $balance = Balance::pay($ptv['name']);
                $balance = isset($balance['balance']) ? $balance['balance'] : '';
                $balance = (float)$balance;
                if ($balance > 0 && $balance < $min_balance){
                    $list[] = [
                        'text' => $ptv['name'].'商户余额过低，余额：'.$balance,
                        'count' => 1,
                        'url' => "/admin/coin.Withdraw/index",
                    ];
                    $balance_count += 1;
                }
            }
        }

        $data = [
            'list' => $list,
            'count' => $withdraw_count + $is_suc_kiki + $balance_count
        ];
        return json($data);
    }
}


