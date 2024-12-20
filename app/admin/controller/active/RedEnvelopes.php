<?php

namespace app\admin\controller\active;

use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  红包雨配置
 */
class RedEnvelopes extends AuthController
{


    private $table = 'red_envelopes';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;

        $filed = "id,money,bonus,withdraw_bili,sycash,water_multiple,min_money,max_money,type,probability,num";

        $orderfield = "id";
        $sort = "desc";


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    public function add(){

        $f = array();
        $f[] = Form::input('money', '奖励Cash金额(分)');
        $f[] = Form::input('bonus', '奖励Bonus金额(分)');
        $f[] = Form::input('withdraw_bili', '退款比例低于多少');
        $f[] = Form::number('sycash', '剩余Cash(小数位比例,整数为金额)');
        $f[] = Form::number('water_multiple', '流水倍数小于多少');
        $f[] = Form::number('min_money', '最小充值金额');
        $f[] = Form::number('max_money', '最大充值金额');
        $f[] = Form::number('num', '红包个数(-99表示无数个)/');
        $f[] = Form::radio('type', '用户类型',1)->options([['label' => '常规奖励', 'value' => 1], ['label' => '新手奖励', 'value' => 2], ['label' => '大R奖励', 'value' => 3]]);
        $f[] = Form::number('probability', '概率小数');


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
        $f[] = Form::input('money', '奖励Cash金额(分)',$banner['money']);
        $f[] = Form::input('bonus', '奖励Bonus金额(分)',$banner['bonus']);
        $f[] = Form::input('withdraw_bili', '退款比例低于多少',$banner['withdraw_bili']);
        $f[] = Form::number('sycash', '剩余Cash(小数位比例,整数为金额)',$banner['sycash']);
        $f[] = Form::number('water_multiple', '流水倍数小于多少',$banner['water_multiple']);
        $f[] = Form::number('min_money', '最小充值金额',$banner['min_money']);
        $f[] = Form::number('max_money', '最大充值金额',$banner['max_money']);
        $f[] = Form::number('num', '常规奖励:红包个数(-99表示无数个)/特殊奖励:参与次数',$banner['num']);
        $f[] = Form::radio('type', '用户类型',$banner['type'])->options([['label' => '常规奖励', 'value' => 1], ['label' => '新手奖励', 'value' => 2], ['label' => '大R奖励', 'value' => 3]]);
        $f[] = Form::number('probability', '概率小数',$banner['probability']);


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




