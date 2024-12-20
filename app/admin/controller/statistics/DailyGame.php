<?php

namespace app\admin\controller\statistics;
use app\admin\controller\AuthController;
use app\admin\model\games\GameRecords;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  游戏数据列表
 */
class DailyGame extends AuthController
{
    const VALUE = '360M';

    public function index()
    {
        $game_name_type = config('game.gamename');
        $this->assign('game_name_type', $game_name_type);
        return $this->fetch();
    }


    public function getlist(){
        ini_set('memory_limit', self::VALUE);
        set_time_limit(0);
        $data =  request()->param();
        $tj_type = 0;
        if (isset($data['tj_type'])) {
            $tj_type = $data['tj_type'];
            unset($data['tj_type']);
        }

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $where  = Model::getWhere2($data,'date');
        //$where[] = ['game_type','<>',1002];
        $whereIn = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
        if (isset($data['game/type']) && !empty($data['game/type'])) {
            $whereIn = [$data['game/type']];
        }

        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数
        if ($tj_type === '0'){
            $data['data'] = Db::name('daily_game_indicators')
                ->field("date,game_type,table_level,update_time,GROUP_CONCAT(NULLIF(COALESCE(user_ids,''),'')) as user_ids,
            sum(user_count) as user_count,sum(game_count) as game_count,sum(service_score) as service_score,sum(income) as income,
        sum(bet_score) as bet_score,sum(ai_bet_score) as ai_bet_score,sum(coin_change) as coin_change,sum(ai_coin_change) as ai_coin_change,
        sum(final_score) as final_score,sum(ai_final_score) as ai_final_score,GROUP_CONCAT(NULLIF(COALESCE(pay_user_ids,''),'')) as pay_user_ids,
        GROUP_CONCAT(NULLIF(COALESCE(no_user_ids,''),'')) as no_user_ids,sum(pay_bet_score) as pay_bet_score,
        sum(pay_coin_change) as pay_coin_change,sum(no_bet_score) as no_bet_score,sum(no_coin_change) as no_coin_change")
                ->where($where)
                ->whereIn('game_type',$whereIn)
                ->group('date')
                ->order('date', 'desc')
                ->order('bet_score', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('daily_game_indicators')
                ->group('date')
                ->where($where)
                ->whereIn('game_type',$whereIn)
                ->count();
            if (!empty($data['data'])){
                foreach ($data['data'] as $dk=>$dv){
                    $data['data'][$dk]['game_type'] = 111;
                    $data['data'][$dk]['table_level'] = 111;
                    $data['data'][$dk]['user_count'] = 0;
                    if (!empty($dv['user_ids'])) {
                        $user_arr = explode(',', $dv['user_ids']);
                        $user_arr = array_unique($user_arr);
                        $data['data'][$dk]['user_count'] = count($user_arr);
                    }
                    $data['data'][$dk]['pay_user_count'] = 0;
                    if (!empty($dv['pay_user_ids'])) {
                        $pay_user_arr = explode(',', $dv['pay_user_ids']);
                        $pay_user_arr = array_unique($pay_user_arr);
                        $data['data'][$dk]['pay_user_count'] = count($pay_user_arr);
                    }
                    $data['data'][$dk]['no_user_count'] = 0;
                    if (!empty($dv['no_user_ids'])) {
                        $no_user_arr = explode(',', $dv['no_user_ids']);
                        $no_user_arr = array_unique($no_user_arr);
                        $data['data'][$dk]['no_user_count'] = count($no_user_arr);
                    }
                    if ($dv['game_type'] == 1002 || $dv['game_type'] == 1003){
                        $user_ids = Db::name('userinfo')->whereIn('uid',$dv['user_ids'])->where('total_pay_score','>',0)->column('uid');
                        $user_ids = implode(",",$user_ids);
                        $data['data'][$dk]['user_md5'] =  base64_encode($user_ids);
                    }else {
                        $data['data'][$dk]['user_md5'] = base64_encode($dv['user_ids']);
                    }

                    $data['data'][$dk]['bet_score'] = bcdiv($dv['bet_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['coin_change'] = bcdiv($dv['coin_change'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['service_score'] = bcdiv($dv['service_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['final_score'] = bcdiv($dv['final_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_bet_score'] = bcdiv($dv['ai_bet_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_coin_change'] = bcdiv($dv['ai_coin_change'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_final_score'] = bcdiv($dv['ai_final_score'], $amount_reduction_multiple, 2);
                }
            }

        }elseif ($tj_type == 1){
            $data['data'] = Db::name('daily_game_indicators')
                ->field("min(date) as min_date,max(date) as max_date,game_type,table_level,update_time,GROUP_CONCAT(NULLIF(COALESCE(user_ids,''),'')) as user_ids,
            sum(user_count) as user_count,sum(game_count) as game_count,sum(service_score) as service_score,sum(income) as income,
        sum(bet_score) as bet_score,sum(ai_bet_score) as ai_bet_score,sum(coin_change) as coin_change,sum(ai_coin_change) as ai_coin_change,
        sum(final_score) as final_score,sum(ai_final_score) as ai_final_score,GROUP_CONCAT(NULLIF(COALESCE(pay_user_ids,''),'')) as pay_user_ids,
        GROUP_CONCAT(NULLIF(COALESCE(no_user_ids,''),'')) as no_user_ids,sum(pay_bet_score) as pay_bet_score,
        sum(pay_coin_change) as pay_coin_change,sum(no_bet_score) as no_bet_score,sum(no_coin_change) as no_coin_change")
                ->where($where)
                ->whereIn('game_type',$whereIn)
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('daily_game_indicators')
                ->where($where)
                ->whereIn('game_type',$whereIn)
                ->count();
            if (!empty($data['data'])){
                foreach ($data['data'] as $dk=>$dv){
                    $data['data'][$dk]['game_type'] = 111;
                    $data['data'][$dk]['table_level'] = 111;
                    $data['data'][$dk]['user_count'] = 0;
                    if (!empty($dv['user_ids'])) {
                        $user_arr = explode(',', $dv['user_ids']);
                        $user_arr = array_unique($user_arr);
                        $data['data'][$dk]['user_count'] = count($user_arr);
                    }
                    $data['data'][$dk]['pay_user_count'] = 0;
                    if (!empty($dv['pay_user_ids'])) {
                        $pay_user_arr = explode(',', $dv['pay_user_ids']);
                        $pay_user_arr = array_unique($pay_user_arr);
                        $data['data'][$dk]['pay_user_count'] = count($pay_user_arr);
                    }
                    $data['data'][$dk]['no_user_count'] = 0;
                    if (!empty($dv['no_user_ids'])) {
                        $no_user_arr = explode(',', $dv['no_user_ids']);
                        $no_user_arr = array_unique($no_user_arr);
                        $data['data'][$dk]['no_user_count'] = count($no_user_arr);
                    }
                    if ($dv['game_type'] == 1002 || $dv['game_type'] == 1003){
                        $user_ids = Db::name('userinfo')->whereIn('uid',$dv['user_ids'])->where('total_pay_score','>',0)->column('uid');
                        $user_ids = implode(",",$user_ids);
                        $data['data'][$dk]['user_md5'] =  base64_encode($user_ids);
                    }else {
                        $data['data'][$dk]['user_md5'] = base64_encode($dv['user_ids']);
                    }
                    $data['data'][$dk]['date'] = $dv['min_date'].' - '.$dv['max_date'];

                    $data['data'][$dk]['bet_score'] = bcdiv($dv['bet_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['coin_change'] = bcdiv($dv['coin_change'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['service_score'] = bcdiv($dv['service_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['final_score'] = bcdiv($dv['final_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_bet_score'] = bcdiv($dv['ai_bet_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_coin_change'] = bcdiv($dv['ai_coin_change'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_final_score'] = bcdiv($dv['ai_final_score'], $amount_reduction_multiple, 2);
                }
            }

        }elseif ($tj_type == 2){
            $data['data'] = Db::name('daily_game_indicators')
                ->field("min(date) as min_date,max(date) as max_date,game_type,table_level,update_time,GROUP_CONCAT(NULLIF(COALESCE(user_ids,''),'')) as user_ids,
            sum(user_count) as user_count,sum(game_count) as game_count,sum(service_score) as service_score,sum(income) as income,
        sum(bet_score) as bet_score,sum(ai_bet_score) as ai_bet_score,sum(coin_change) as coin_change,sum(ai_coin_change) as ai_coin_change,
        sum(final_score) as final_score,sum(ai_final_score) as ai_final_score,GROUP_CONCAT(NULLIF(COALESCE(pay_user_ids,''),'')) as pay_user_ids,
        GROUP_CONCAT(NULLIF(COALESCE(no_user_ids,''),'')) as no_user_ids,sum(pay_bet_score) as pay_bet_score,
        sum(pay_coin_change) as pay_coin_change,sum(no_bet_score) as no_bet_score,sum(no_coin_change) as no_coin_change")
                ->where($where)
                //->whereIn('game_type',$whereIn)
                ->group('game_type')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('daily_game_indicators')
                ->where($where)
                //->whereIn('game_type',$whereIn)
                ->group('game_type')
                ->count();
            if (!empty($data['data'])){
                foreach ($data['data'] as $dk=>$dv){
                    //$data['data'][$dk]['game_type'] = 111;
                    if (in_array($dv['game_type'],[1001,1002,1003]) && empty($data['table/level'])){
                        $data['data'][$dk]['table_level'] = 999;
                    }
                    $data['data'][$dk]['user_count'] = 0;
                    if (!empty($dv['user_ids'])) {
                        $user_arr = explode(',', $dv['user_ids']);
                        $user_arr = array_unique($user_arr);
                        $data['data'][$dk]['user_count'] = count($user_arr);
                    }
                    $data['data'][$dk]['pay_user_count'] = 0;
                    if (!empty($dv['pay_user_ids'])) {
                        $pay_user_arr = explode(',', $dv['pay_user_ids']);
                        $pay_user_arr = array_unique($pay_user_arr);
                        $data['data'][$dk]['pay_user_count'] = count($pay_user_arr);
                    }
                    $data['data'][$dk]['no_user_count'] = 0;
                    if (!empty($dv['no_user_ids'])) {
                        $no_user_arr = explode(',', $dv['no_user_ids']);
                        $no_user_arr = array_unique($no_user_arr);
                        $data['data'][$dk]['no_user_count'] = count($no_user_arr);
                    }
                    if ($dv['game_type'] == 1002 || $dv['game_type'] == 1003){
                        $user_ids = Db::name('userinfo')->whereIn('uid',$dv['user_ids'])->where('total_pay_score','>',0)->column('uid');
                        $user_ids = implode(",",$user_ids);
                        $data['data'][$dk]['user_md5'] =  base64_encode($user_ids);
                    }else {
                        $data['data'][$dk]['user_md5'] = base64_encode($dv['user_ids']);
                    }
                    $data['data'][$dk]['date'] = $dv['min_date'].' - '.$dv['max_date'];

                    $data['data'][$dk]['bet_score'] = bcdiv($dv['bet_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['coin_change'] = bcdiv($dv['coin_change'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['service_score'] = bcdiv($dv['service_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['final_score'] = bcdiv($dv['final_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_bet_score'] = bcdiv($dv['ai_bet_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_coin_change'] = bcdiv($dv['ai_coin_change'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_final_score'] = bcdiv($dv['ai_final_score'], $amount_reduction_multiple, 2);
                }
            }

        }else {//正常
            $data['data'] = Db::name('daily_game_indicators')
                ->field("date,game_type,table_level,update_time,GROUP_CONCAT(NULLIF(COALESCE(user_ids,''),'')) as user_ids,
            sum(user_count) as user_count,sum(game_count) as game_count,sum(service_score) as service_score,sum(income) as income,
        sum(bet_score) as bet_score,sum(ai_bet_score) as ai_bet_score,sum(coin_change) as coin_change,sum(ai_coin_change) as ai_coin_change,
        sum(final_score) as final_score,sum(ai_final_score) as ai_final_score,GROUP_CONCAT(NULLIF(COALESCE(pay_user_ids,''),'')) as pay_user_ids,
        GROUP_CONCAT(NULLIF(COALESCE(no_user_ids,''),'')) as no_user_ids,sum(pay_bet_score) as pay_bet_score,
        sum(pay_coin_change) as pay_coin_change,sum(no_bet_score) as no_bet_score,sum(no_coin_change) as no_coin_change")
                ->where($where)
                ->group('date,game_type')
                ->order('date', 'desc')
                ->order('bet_score', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('daily_game_indicators')
                ->group('date,game_type')
                ->where($where)
                ->count();
            if (!empty($data['data'])){
                foreach ($data['data'] as $dk=>$dv){
                    if (in_array($dv['game_type'],[1001,1002,1003]) && empty($data['table/level'])){
                        $data['data'][$dk]['table_level'] = 999;
                    }
                    $data['data'][$dk]['user_count'] = 0;
                    if (!empty($dv['user_ids'])) {
                        $user_arr = explode(',', $dv['user_ids']);
                        $user_arr = array_unique($user_arr);
                        $data['data'][$dk]['user_count'] = count($user_arr);
                    }
                    $data['data'][$dk]['pay_user_count'] = 0;
                    if (!empty($dv['pay_user_ids'])) {
                        $pay_user_arr = explode(',', $dv['pay_user_ids']);
                        $pay_user_arr = array_unique($pay_user_arr);
                        $data['data'][$dk]['pay_user_count'] = count($pay_user_arr);
                    }
                    $data['data'][$dk]['no_user_count'] = 0;
                    if (!empty($dv['no_user_ids'])) {
                        $no_user_arr = explode(',', $dv['no_user_ids']);
                        $no_user_arr = array_unique($no_user_arr);
                        $data['data'][$dk]['no_user_count'] = count($no_user_arr);
                    }
                    if ($dv['game_type'] == 1002 || $dv['game_type'] == 1003){
                        $user_ids = Db::name('userinfo')->whereIn('uid',$dv['user_ids'])->where('total_pay_score','>',0)->column('uid');
                        $user_ids = implode(",",$user_ids);
                        $data['data'][$dk]['user_md5'] =  base64_encode($user_ids);
                    }else {
                        $data['data'][$dk]['user_md5'] = base64_encode($dv['user_ids']);
                    }

                    $data['data'][$dk]['bet_score'] = bcdiv($dv['bet_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['coin_change'] = bcdiv($dv['coin_change'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['service_score'] = bcdiv($dv['service_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['final_score'] = bcdiv($dv['final_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_bet_score'] = bcdiv($dv['ai_bet_score'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_coin_change'] = bcdiv($dv['ai_coin_change'], $amount_reduction_multiple, 2);
                    $data['data'][$dk]['ai_final_score'] = bcdiv($dv['ai_final_score'], $amount_reduction_multiple, 2);

                    //计算付费人
                    /*if (in_array($dv['game_type'],[1001,1002,2001]) && !empty($dv['user_ids'])){
                        $pay_user_ids = Db::name('userinfo')->whereIn('uid',$dv['user_ids'])->where('total_pay_score','>',0)->column('uid');
                        $no_user_ids = array_diff($user_arr,$pay_user_ids);
                        $data['data'][$dk]['pay_user_count'] = count($pay_user_ids);
                        $data['data'][$dk]['no_user_count'] = count($no_user_ids);

                        $pay_param = [];
                        $pay_param['uids'] = $user_arr;
                        $pay_param['date'] = $dv['date'].' - '.$dv['date'];
                        $pay_param['game_type'] = $dv['game_type'];
                        //$pay_param['table_level'] = $dv['table_level'];
                        if (isset($data['game/type']) && isset($data['table/level'])){
                            if (!empty($data['date'])) {
                                $pay_param['date'] = $data['date'];
                            }else{
                                $pay_param['date'] = $dv['date'].' - '.$dv['date'];
                            }
                            if (!empty($data['game/type'])) {
                                $pay_param['game_type'] = $data['game/type'];
                            }
                            if (!empty($data['table/level'])) {
                                $pay_param['table_level'] = $data['table/level'];
                            }
                        }
    //                    $pay_field = "sum(bet_score) as bet_score,sum(coin_change) as coin_change";
                        $pay_field = "bet_score,coin_change,uid";
                        $pay_game_records = (new GameRecords)->getDataByMultiDay2($pay_param,$pay_field);
                        $data['data'][$dk]['pay_bet_score'] = 0;
                        $data['data'][$dk]['pay_coin_change'] = 0;
                        $data['data'][$dk]['no_bet_score'] = 0;
                        $data['data'][$dk]['no_coin_change'] = 0;
                        if (!empty($pay_game_records)){
                            foreach ($pay_game_records as $pk=>$pv){
                                if (in_array($pv['uid'],$pay_user_ids)) {
                                    $data['data'][$dk]['pay_bet_score'] += $pv['bet_score'] ? $pv['bet_score'] : 0;
                                    $data['data'][$dk]['pay_coin_change'] += $pv['coin_change'] ? $pv['coin_change'] : 0;
                                }
                                if (in_array($pv['uid'],$no_user_ids)) {
                                    $data['data'][$dk]['no_bet_score'] += $pv['bet_score'] ? $pv['bet_score'] : 0;
                                    $data['data'][$dk]['no_coin_change'] += $pv['coin_change'] ? $pv['coin_change'] : 0;
                                }
                            }
                        }
                        $pay_game_records = null;
                        //$data['data'][$dk]['pay_bet_score'] = $pay_game_records['bet_score'];
                        //dd($pay_game_records);
                    }*/
                }
            }
        }

        /*$new_data = [];
        if ($tj_type == 12) {
            if (!empty($data['data'])) {
                $new_data = [[
                    'user_count' => 0,
                    'game_count' => 0,
                    'service_score' => 0,
                    'income' => 0,
                    'bet_score' => 0,
                    'ai_bet_score' => 0,
                    'coin_change' => 0,
                    'ai_coin_change' => 0,
                    'final_score' => 0,
                    'ai_final_score' => 0,
                    'user_ids' => '',

                    'pay_user_count' => 0,
                    'no_user_count' => 0,
                    'pay_bet_score' => 0,
                    'pay_coin_change' => 0,
                    'no_bet_score' => 0,
                    'no_coin_change' => 0,
                ]];
                foreach ($data['data'] as $dkey => $dvalue) {
                    //$new_data[0]['user_count'] += $dvalue['user_count'];
                    $new_data[0]['game_count'] += $dvalue['game_count'];
                    $new_data[0]['service_score'] += $dvalue['service_score'];
                    $new_data[0]['income'] += $dvalue['income'];
                    $new_data[0]['bet_score'] += $dvalue['bet_score'];
                    $new_data[0]['ai_bet_score'] += $dvalue['ai_bet_score'];
                    $new_data[0]['coin_change'] += $dvalue['coin_change'];
                    $new_data[0]['ai_coin_change'] += $dvalue['ai_coin_change'];
                    $new_data[0]['final_score'] += $dvalue['final_score'];
                    $new_data[0]['ai_final_score'] += $dvalue['ai_final_score'];
                    $new_data[0]['table_level'] = $dvalue['table_level'];
                    if (!empty($dvalue['user_ids'])){
                        $new_data[0]['user_ids'] .= ','.$dvalue['user_ids'];
                    }

                    $new_data[0]['pay_user_count'] += $dvalue['pay_user_count'];
                    $new_data[0]['no_user_count'] += $dvalue['no_user_count'];
                    $new_data[0]['pay_bet_score'] += $dvalue['pay_bet_score'];
                    $new_data[0]['pay_coin_change'] += $dvalue['pay_coin_change'];
                    $new_data[0]['no_bet_score'] += $dvalue['no_bet_score'];
                    $new_data[0]['no_coin_change'] += $dvalue['no_coin_change'];
                }
                $new_data[0]['user_ids'] = trim($new_data[0]['user_ids'],",");
                $new_data[0]['date'] = $data['data'][$dkey]['date'].' - '.$data['data'][0]['date'];
                $new_data[0]['game_type'] = isset($data['game/type']) ? $data['game/type'] : '';

                $new_data[0]['user_md5'] = base64_encode($new_data[0]['user_ids']);
                $user_arr = explode(',',$new_data[0]['user_ids']);
                $user_arr = array_unique($user_arr);
                $new_data[0]['user_count'] = count($user_arr);
                //$new_data[0]['table_level'] = isset($data['table/level']) ? $data['table/level'] : 999;
                //$new_data[0]['recharge_suc_rate'] = $new_data[0]['recharge_count']>0 ? round(($new_data[0]['recharge_suc_count']/$new_data[0]['recharge_count'])*100,2) : '0.00';
            }

            $data['data'] = $new_data;
            $data['count'] = 1;

        }*/

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


    public function getLevel($game_type){
        $level = [];
        if ($game_type == 1001) {
            $level = [
                '51' => 'RM双人0.1块场',
                '52' => 'RM双人0.3块场',
                '53' => 'RM双人1块场',
                '54' => 'RM双人2.5块场',
                '55' => 'RM双人5块场',
                '56' => 'RM双人10块场',
                '57' => 'RM双人20块场',
                '58' => 'RM双人50块场',
            ];
        }elseif ($game_type == 1002){
            $level = [
                '1' => 'TP(0.1块场)',
                '2' => 'TP(0.3块场)',
                '3' => 'TP(1块场)',
                '4' => 'TP(5块场)',
                '5' => 'TP(10块场)',
                '6' => 'TP(20块场)',
                '7' => 'TP(50块场)',
            ];
        }elseif ($game_type == 1003){
            $level = [
                '1' => 'TP(0.1块场)',
                '2' => 'TP(0.3块场)',
                '3' => 'TP(1块场)',
                '4' => 'TP(5块场)',
                '5' => 'TP(10块场)',
                '6' => 'TP(50块场)',
                //'7' => 'TP(50块场)',
            ];
        }
        return json($level);
    }

    public function userList2($users){
        $this->assign('users',$users);
        return $this->fetch();
    }
    public function userList(){
        $data = $this->request->param();
        $users = $data['users'];
        $this->assign('users',$users);
        return $this->fetch();
    }

    public function getUserinfoList(){
        $data = $this->request->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;

        $users = $data['users'] ? $data['users'] : '';
        $users = base64_decode($users);
        $users_arr = explode(",",$users);
        $users_arr = array_unique($users_arr);
        if(!empty($users)){
            $list = Db::name('userinfo')
                ->field('uid,total_pay_score,total_exchange,cash_total_score,bonus_total_score')
                ->whereIn('uid',$users_arr)
                ->order('total_pay_score','desc')
                ->order('regist_time','desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $count = Db::name('userinfo')
                ->whereIn('uid',$users_arr)
                ->count();
            return json(['code' => 0, 'count' => $count, 'data' => $list]);
        }
        return json(['code' => 0, 'count' => 0, 'data' => []]);
    }

}
