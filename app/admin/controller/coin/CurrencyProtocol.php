<?php

namespace app\admin\controller\coin;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  数字货币协议管理
 */
class CurrencyProtocol extends AuthController
{

    private $table = 'digital_currency_protocol';

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


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    public function add(){

        $f[] = Form::input('name', '名称')->disabled(true);
        $f[] = Form::input('englishname', '客户端名称');
        $f[] = Form::uploadImageOne('icon', '图片',url('widget.Image/file',['file'=>'icon']));
        $f[] = Form::number('weight', '权重');
        $f[] = Form::number('min_money', '最低充币提币金额');
        $f[] = Form::number('max_money', '最大充币提币金额');
        $f[] = Form::input('digital_currency_address', '转账钱包地址');
        $f[] = Form::uploadImageOne('digital_currency_url', '转账钱包二维码',url('widget.Image/file',['file'=>'digital_currency_url']));
        $f[] = Form::radio('status', '是否开启', 1)->options([['label' => '开启', 'value' => 1],['label' => '关闭', 'value' => 0]]);
        $form = Form::make_post_form('修改数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }



    public function edit($id = 0){
        $active = Db::name($this->table)->where('id',$id)->find();

        if(!$active){
            Json::fail('参数错误!');
        }

        $f[] = Form::input('name', '名称',$active['name']);
        $f[] = Form::input('englishname', '客户端名称',$active['englishname']);
        $f[] = Form::uploadImageOne('icon', '图片',url('widget.Image/file',['file'=>'icon']),$active['icon']);
        $f[] = Form::number('weight', '权重',$active['weight']);
        $f[] = Form::number('min_money', '最低充币提币金额',$active['min_money']);
        $f[] = Form::number('max_money', '最大充币提币金额',$active['max_money']);
        $f[] = Form::input('digital_currency_address', '转账钱包地址',$active['digital_currency_address']);
        $f[] = Form::uploadImageOne('digital_currency_url', '转账钱包二维码',url('widget.Image/file',['file'=>'digital_currency_url']),$active['digital_currency_url']);
        $f[] = Form::radio('status', '是否开启',$active['status'])->options([['label' => '开启', 'value' => 1],['label' => '关闭', 'value' => 0]]);
        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($id = 0){

        $data = request()->post();

        if($id > 0){

            $res = Db::name($this->table)->where('id','=',$id)->update($data);
            if(!$res){
                Json::fail('编辑失败');
            }

        }else{
            $res = Db::name($this->table)->insert($data);
            if(!$res){
                Json::fail('添加失败');
            }
        }
        return Json::successful($id > 0 ? '修改成功!' : '添加成功!');

    }


    /**
     * @return void 修改状态
     */
    public function is_show(){
        $data =  request()->param();
        Db::name($this->table)->where('id',$data['id'])->update(['status' => $data['status']]);

        return Json::successful('修改成功!');
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



