<?php

namespace app\admin\controller\coin;
use app\admin\controller\AuthController;
use app\admin\model\games\GameRecords;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  列表
 */
class AllPayType extends AuthController
{
    const VALUE = '360M';

    public function index()
    {
        $pay_type = Db::name('pay_type')->order('weight','desc')->column('name,id');
        $this->assign('pay_type',$pay_type);
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
        $limit = $data['limit'] ?: 200;
        $where  = Model::getWhere($data,'createtime');

            $data['data'] = Db::name('paytype_st')
                /*->field("date,terrace_name,englishname,update_time,GROUP_CONCAT(NULLIF(COALESCE(user_ids,''),'')) as user_ids,
            sum(user_count) as user_count,sum(game_count) as game_count,sum(service_score) as service_score,sum(income) as income,
        sum(bet_score) as bet_score,sum(ai_bet_score) as ai_bet_score,sum(coin_change) as coin_change,sum(ai_coin_change) as ai_coin_change,
        sum(final_score) as final_score,sum(ai_final_score) as ai_final_score,GROUP_CONCAT(NULLIF(COALESCE(pay_user_ids,''),'')) as pay_user_ids,
        GROUP_CONCAT(NULLIF(COALESCE(no_user_ids,''),'')) as no_user_ids,sum(pay_bet_score) as pay_bet_score,
        sum(pay_coin_change) as pay_coin_change,sum(no_bet_score) as no_bet_score,sum(no_coin_change) as no_coin_change")*/
                ->where($where)
                ->order('createtime', 'desc')
                ->order('id', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('paytype_st')
                ->where($where)
                ->count();
            if (!empty($data['data'])){
                $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数

                foreach ($data['data'] as $dk=>$dv){
                    $data['data'][$dk]['createtime'] = date('Y-m-d H:i:s', $dv['createtime']);
                    $data['data'][$dk]['recharge_money'] = bcdiv($dv['recharge_money'],$amount_reduction_multiple,2);
                    $data['data'][$dk]['recharge_money_yes'] = bcdiv($dv['recharge_money_yes'],$amount_reduction_multiple,2);
                    $data['data'][$dk]['recharge_rate'] = $dv['recharge_count'] > 0 ? (bcdiv($dv['recharge_suc_count'], $dv['recharge_count'],4)*100).'%' : 0;
                    $data['data'][$dk]['recharge_rate_yes'] = $dv['recharge_count_yes'] > 0 ? (bcdiv($dv['recharge_suc_count_yes'], $dv['recharge_count_yes'],4)*100).'%' : 0;
                    $data['data'][$dk]['ave_time'] = $dv['recharge_suc_count'] > 0 ? bcdiv($dv['all_time'], $dv['recharge_suc_count']).'秒' : 0;
                    $data['data'][$dk]['ave_time_yes'] = $dv['recharge_suc_count_yes'] > 0 ? bcdiv($dv['yes_time'], $dv['recharge_suc_count_yes']).'秒' : 0;
                }
            }


        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }



    public function edit($id = 0){
        $active = Db::name('paytype_st')->where('id',$id)->find();
        if(!$active){
            Json::fail('参数错误!');
        }
        $f[] = Form::input('unsettled_amount', '代收未结算金额',$active['unsettled_amount']);
        $f[] = Form::input('available_balance', '可用余额',$active['available_balance']);
        $f[] = Form::input('frozen_balance', '冻结余额',$active['frozen_balance']);

        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    /**
     * @return void 存储数据
     */
    public function save($id=0){
        $adminId = $this->adminId;

        $data = request()->post();
        if($id > 0){
            $res = Db::name('paytype_st')->where('id',$id)->update($data);
        }else{
            $res = Db::name('paytype_st')->insert($data);
        }
        if(!$res){
            Json::fail('添加失败');
        }
        return Json::successful($id > 0 ? '修改成功!' : '添加成功!');
    }

}
