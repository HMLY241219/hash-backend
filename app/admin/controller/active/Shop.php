<?php

namespace app\admin\controller\active;

use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  商场活动配置
 */
class Shop extends AuthController
{


    private $table = 'marketing_shop';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;

        $filed = "*";

        $orderfield = "weight";
        $sort = "desc";


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit,'createtime',[['user_type','<>',0],['terminal_type','=',1]]);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    public function add(){

        $f = array();
        $f[] = Form::radio('type', '类型',6)->options([['label' => '普通商场', 'value' => 0],['label' => '破产商城', 'value' => 6], ['label' => '客损商城', 'value' => 7],['label' => '首充商城', 'value' => 10]]);
        $f[] = Form::input('bonus_config', 'Bonus赠送配置(金额和bouns以|分隔为一组, 然后以空格分隔单位:卢比分)');
        $f[] = Form::input('cash_config', 'Cash赠送配置(金额和cash以|分隔为一组, 然后以空格分隔单位:卢比分)');
        $f[] = Form::input('hot_config', '是否热销配置(金额和配置以|分隔为一组, 然后以空格分隔单位:1=是,0=否)');


        $currency_and_ratio = Db::name('currency_and_ratio')->field('id,name')->select()->toArray();
        $f[] = Form::select('currency','货币类型')->setOptions(function () use ($currency_and_ratio){
            $menus = [];
            foreach ($currency_and_ratio as $menu) {
                $menus[] = ['value' => $menu['name'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);

        $f[] = Form::input('weight', '权重');
        $f[] = Form::radio('user_type', '用户类型',0)->options([['label' => '全部', 'value' => 0], ['label' => '广告', 'value' => 1],['label' => '自然量', 'value' => 2],['label' => '分享', 'value' => 3]]);
//        $f[] = Form::radio('terminal_type', '版本类型:',1)->options([['label' => 'APP', 'value' => 1], ['label' => 'H5', 'value' => 2]]);
        $f[] = Form::input('customer_money', '客损金额(分)');
        $f[] = Form::input('withdraw_bili', '提现率');
        $f[] = Form::input('coin_money', '用户余额');
        $f[] = Form::radio('status', '状态',1)->options([['label' => '关闭', 'value' => 0], ['label' => '开启', 'value' => 1]]);
        $f[] = Form::radio('is_new_package', '是否是新包配置',0)->options([['label' => '老包', 'value' => 0], ['label' => '新包', 'value' => 1]]);

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
        $f[] = Form::radio('type', '类型',$banner['type'])->options([['label' => '普通商场', 'value' => 0],['label' => '破产商城', 'value' => 6], ['label' => '客损商城', 'value' => 7],['label' => '首充商城', 'value' => 10],['label' => '二次商城', 'value' => 11],['label' => '三次商城', 'value' => 12],['label' => '四次商城', 'value' => 13],['label' => '五次商城', 'value' => 14],['label' => '客损商城2', 'value' => 20]]);
        $f[] = Form::input('bonus_config', 'Bonus赠送配置(金额和bouns以|分隔为一组, 然后以空格分隔单位:卢比分)',$banner['bonus_config']);
        $f[] = Form::input('cash_config', 'Cash赠送配置(金额和cash以|分隔为一组, 然后以空格分隔单位:卢比分)',$banner['cash_config']);
        $f[] = Form::input('hot_config', '是否热销配置(金额和配置以|分隔为一组, 然后以空格分隔单位:1=是,0=否)',$banner['hot_config']);


        $currency_and_ratio = Db::name('currency_and_ratio')->field('id,name')->select()->toArray();
        $f[] = Form::select('currency','货币类型',$banner['currency'])->setOptions(function () use ($currency_and_ratio){
            $menus = [];
            foreach ($currency_and_ratio as $menu) {
                $menus[] = ['value' => $menu['name'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);

        $f[] = Form::input('weight', '权重',$banner['weight']);
        $f[] = Form::radio('user_type', '用户类型',$banner['user_type'])->options([['label' => '全部', 'value' => 0], ['label' => '广告', 'value' => 1],['label' => '自然量', 'value' => 2],['label' => '分享', 'value' => 3]]);
//        $f[] = Form::radio('terminal_type', '版本类型:',$banner['terminal_type'])->options([['label' => 'APP', 'value' => 1], ['label' => 'H5', 'value' => 2]]);
        $f[] = Form::input('customer_money', '客损金额(分)',$banner['customer_money']);
        $f[] = Form::input('withdraw_bili', '提现率',$banner['withdraw_bili']);
        $f[] = Form::input('coin_money', '用户余额',$banner['coin_money']);
        $f[] = Form::input('num', '参与次数',$banner['num']);
        $f[] = Form::radio('status', '状态',$banner['status'])->options([['label' => '关闭', 'value' => 0], ['label' => '开启', 'value' => 1]]);
        $f[] = Form::radio('is_new_package', '是否是新包配置',$banner['is_new_package'])->options([['label' => '老包', 'value' => 0], ['label' => '新包', 'value' => 1]]);
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

    /**
     * @return void 修改状态
     */
    public function is_show(){
        $data =  request()->param();

        Db::name($this->table)->where('id',$data['id'])->update([$data['field'] => $data['value']]);

        return Json::successful('修改成功!');
    }
}


