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
class Handshop extends AuthController
{


    private $table = 'marketing_handshop';

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


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit,'createtime');

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    public function add(){

        $f = array();
        $f[] = Form::radio('type', '类型',0)->options([['label' => '普通商场', 'value' => 0],['label' => '首充商城', 'value' => 10]]);
        $f[] = Form::input('min_money', '最小输入金额(分)');
        $f[] = Form::input('max_money', '最大输入金额(分)');
        $f[] = Form::radio('user_type', '用户类型',1)->options([ ['label' => '广告', 'value' => 1],['label' => '自然量', 'value' => 2],['label' => '分享', 'value' => 3]]);
        $f[] = Form::input('zs_cash', '赠送Cash比例');
        $f[] = Form::input('zs_bonus', '赠送Bonus比例');
        $f[] = Form::radio('status', '状态',1)->options([['label' => '关闭', 'value' => 0], ['label' => '开启', 'value' => 1]]);

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
        $f[] = Form::radio('type', '类型',$banner['type'])->options([['label' => '普通商场', 'value' => 0],['label' => '首充商城', 'value' => 10]]);
        $f[] = Form::input('min_money', '最小输入金额(分)',$banner['min_money']);
        $f[] = Form::input('max_money', '最大输入金额(分)',$banner['max_money']);
        $f[] = Form::radio('user_type', '用户类型',$banner['user_type'])->options([ ['label' => '广告', 'value' => 1],['label' => '自然量', 'value' => 2],['label' => '分享', 'value' => 3]]);
        $f[] = Form::input('zs_cash', '赠送Cash比例',$banner['zs_cash']);
        $f[] = Form::input('zs_bonus', '赠送Bonus比例',$banner['zs_bonus']);
        $f[] = Form::radio('status', '状态',$banner['status'])->options([['label' => '关闭', 'value' => 0], ['label' => '开启', 'value' => 1]]);
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



