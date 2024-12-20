<?php

namespace app\admin\controller\coin;
use app\admin\controller\AuthController;
use app\admin\model\games\GameRecords;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  游戏数据列表
 */
class DailyPayType extends AuthController
{
    const VALUE = '360M';

    public function index()
    {
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
        $where  = Model::getWhere($data,'time');

            $data['data'] = Db::name('paytype_day')
                /*->field("date,terrace_name,englishname,update_time,GROUP_CONCAT(NULLIF(COALESCE(user_ids,''),'')) as user_ids,
            sum(user_count) as user_count,sum(game_count) as game_count,sum(service_score) as service_score,sum(income) as income,
        sum(bet_score) as bet_score,sum(ai_bet_score) as ai_bet_score,sum(coin_change) as coin_change,sum(ai_coin_change) as ai_coin_change,
        sum(final_score) as final_score,sum(ai_final_score) as ai_final_score,GROUP_CONCAT(NULLIF(COALESCE(pay_user_ids,''),'')) as pay_user_ids,
        GROUP_CONCAT(NULLIF(COALESCE(no_user_ids,''),'')) as no_user_ids,sum(pay_bet_score) as pay_bet_score,
        sum(pay_coin_change) as pay_coin_change,sum(no_bet_score) as no_bet_score,sum(no_coin_change) as no_coin_change")*/
                ->where($where)
                ->order('time', 'desc')
                ->order('id', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('paytype_day')
                ->where($where)
                ->count();
            if (!empty($data['data'])){
                $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数

                foreach ($data['data'] as $dk=>$dv){
                    $data['data'][$dk]['time'] = date('Y-m-d', $dv['time']);
                    $data['data'][$dk]['recharge_money'] = bcdiv($dv['recharge_money'],$amount_reduction_multiple,2);
                    $data['data'][$dk]['with_money'] = bcdiv($dv['with_money'],$amount_reduction_multiple,2);
                    $data['data'][$dk]['recharge_rate'] = $dv['recharge_count'] > 0 ? (bcdiv($dv['recharge_suc_count'], $dv['recharge_count'],4)*100).'%' : 0;
                    $data['data'][$dk]['with_rate'] = ($dv['with_fail_count'] + $dv['with_suc_count']) > 0 ? (bcdiv($dv['with_suc_count'], ($dv['with_fail_count'] + $dv['with_suc_count']),4)*100).'%' : 0;
                }
            }


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
