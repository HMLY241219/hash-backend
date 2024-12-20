<?php

namespace app\admin\controller\operate;

use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  VIP配置管理
 */
class Vip extends AuthController
{


    private $table = 'vip';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;

        $filed = "*";

        $orderfield = "vip";
        $sort = "desc";


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    public function add(){

        $f = array();
        $f[] = Form::input('vip', '用户等级');
        $f[] = Form::number('need_water', '需求流水(分)');
        $f[] = Form::number('need_pay_price', '需要的充值金额(分)');
//        $f[] = Form::number('betrayal_bili', '反水比例(小数)');
        $f[] = Form::number('daily_reward_bili', '每日奖励比例(小数)');
        $f[] = Form::number('sj_amount', '升级Cash奖励(分)');
        $f[] = Form::number('sj_bonus', '升级Bonus奖励(分)');
//        $f[] = Form::number('week_order_money', '每周奖励前一月充值金额(分)');
        $f[] = Form::number('week_amount', '每周Cash奖励金额(分)');
        $f[] = Form::number('week_bonus', '每月Bonus奖励金额(分)');
//        $f[] = Form::number('month_order_money', '每月奖励前3月充值金额(分)');
        $f[] = Form::number('month_amount', '每月Cash奖励金额(分)');
        $f[] = Form::number('month_bonus', '每月Bonus奖励金额(分)');
        $f[] = Form::number('day_withdraw_num', '每天退款次数');
        $f[] = Form::number('day_withdraw_money', '每天退款金额');
        $f[] = Form::number('order_pay_money', '前30天需要充值的金额');

//        $f[] = Form::number('activation_money', '激活金额');
        $f[] = Form::number('withdraw_max_money', 'Vip退款额度');
        $f[] = Form::number('new_week_min_amount', '新版周返奖最低领取金额');
        $form = Form::make_post_form('修改数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function edit($id = 0){
        $banner = Db::name($this->table)->where('id',$id)->find();
        if(!$banner){
            Json::fail('参数错误!');
        }

        $f = array();
        $f[] = Form::input('vip', '用户等级',$banner['vip']);
        $f[] = Form::number('need_water', '需求流水(分)',$banner['need_water']);
        $f[] = Form::number('need_pay_price', '需要的充值金额(分)',$banner['need_pay_price']);
//        $f[] = Form::number('betrayal_bili', '反水比例(小数)',$banner['betrayal_bili']);
        $f[] = Form::number('daily_reward_bili', '每日奖励比例(小数)',$banner['daily_reward_bili']);
        $f[] = Form::number('sj_amount', '升级Cash奖励(分)',$banner['sj_amount']);
        $f[] = Form::number('sj_bonus', '升级Bonus奖励(分)',$banner['sj_bonus']);
//        $f[] = Form::number('week_order_money', '每周奖励前一月充值金额(分)',$banner['week_order_money']);
        $f[] = Form::number('week_amount', '每周Cash奖励金额(分)',$banner['week_amount']);
        $f[] = Form::number('week_bonus', '每周Bonus奖励金额(分)',$banner['week_bonus']);
//        $f[] = Form::number('month_order_money', '每月奖励前3月充值金额(分)',$banner['month_order_money']);
        $f[] = Form::number('month_amount', '每月Cash奖励金额(分)',$banner['month_amount']);
        $f[] = Form::number('month_bonus', '每月Bonus奖励金额(分)',$banner['month_bonus']);
        $f[] = Form::number('day_withdraw_num', '每天退款次数',$banner['day_withdraw_num']);
        $f[] = Form::number('day_withdraw_money', '每天退款金额(分)',$banner['day_withdraw_money']);
        $f[] = Form::number('order_pay_money', '前30天需要充值的金额',$banner['order_pay_money']);
//        $f[] = Form::number('activation_money', '激活金额',$banner['activation_money']);
        $f[] = Form::number('withdraw_max_money', 'Vip退款额度',$banner['withdraw_max_money']);
        $f[] = Form::number('new_week_min_amount', '新版周返奖最低领取金额',$banner['new_week_min_amount']);

        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }





    /**
     * @return void 存储数据
     */
    public function save($id=0){

        $data = request()->post();
        if($id > 0){
            $res = Db::name($this->table)->where('id',$id)->update($data);
        }else{
            $res = Db::name($this->table)->insert($data);
        }

        if(!$res){
            Json::fail('添加失败');
        }
        return Json::successful($id > 0 ? '修改成功!' : '添加成功!');
    }



    /**
     * @return void 删除数据
     */
    public function delete($id = ''){
        $res = Db::name($this->table)->where('id',$id)->delete();

        if(!$res){
            return Json::fail('删除失败');
        }
        return Json::successful('删除成功!');
    }
}



