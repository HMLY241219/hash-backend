<?php

namespace app\admin\controller\coin;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  退款方式配置
 */
class Refundmethod extends AuthController
{

    private $table = 'refundmethod_type';

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

        $f[] = Form::input('name', '名称');

        $f[] = Form::number('weight', '权重');
        $f[] = Form::radio('type', '类型', 1)->options([['label' => '银行卡', 'value' => 1],['label' => 'UPI', 'value' => 2],['label' => '钱包', 'value' => 3],['label' => '数字货币', 'value' => 4]]);
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

        if($active['type'] == 4){
            $digital_currency_protocol = Db::name('digital_currency_protocol')->field('id,name')->select()->toArray();
            if($active['protocol_ids'])$active['protocol_ids'] = explode(',',$active['protocol_ids']);
            $f[] = Form::select('protocol_ids','协议类型',$active['protocol_ids'])->setOptions(function () use ($digital_currency_protocol){
                $menus = [];
                foreach ($digital_currency_protocol as $menu) {
                    $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
                }
                return $menus;
            })->filterable(1)->multiple(true);
        }

        $f[] = Form::number('weight', '权重',$active['weight']);
        $f[] = Form::radio('type', '类型' ,$active['type'])->options([['label' => '银行卡', 'value' => 1],['label' => 'UPI', 'value' => 2],['label' => '钱包', 'value' => 3],['label' => '数字货币', 'value' => 4]]);
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
        if(isset($data['protocol_ids'])){
            $data['protocol_ids'] = implode(',',$data['protocol_ids']);
        }else{
            $data['protocol_ids'] = '';
        }
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



