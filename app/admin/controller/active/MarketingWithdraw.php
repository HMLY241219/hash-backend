<?php

namespace app\admin\controller\active;

use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  退款配置
 */
class MarketingWithdraw extends AuthController
{


    private $table = 'marketing_withdraw';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;

        $filed = "*";

        $orderfield = "id";
        $sort = "desc";


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit,'createtime',[['user_type','<>',0],['terminal_type','=',1]]);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    public function add(){

        $f = array();

        $f[] = Form::input('cash_config', '代付金额配置(金额以|分隔为一组分)');



        $currency_and_ratio = Db::name('currency_and_ratio')->field('id,name')->select()->toArray();
        $f[] = Form::select('currency','货币类型','VND')->setOptions(function () use ($currency_and_ratio){
            $menus = [];
            foreach ($currency_and_ratio as $menu) {
                $menus[] = ['value' => $menu['name'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);


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
        $f[] = Form::input('cash_config', '退款金额配置(金额以|分隔为一组分)',$banner['cash_config']);


        $currency_and_ratio = Db::name('currency_and_ratio')->field('id,name')->select()->toArray();
        $f[] = Form::select('currency','货币类型',$banner['currency'])->setOptions(function () use ($currency_and_ratio){
            $menus = [];
            foreach ($currency_and_ratio as $menu) {
                $menus[] = ['value' => $menu['name'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);
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



