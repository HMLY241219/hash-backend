<?php

namespace app\admin\controller\coin;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  人工充值客服配置
 */
class ArtificialService extends AuthController
{

    private $table = 'artificial_service';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){

        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;


        $filed = "a.id,a.title,a.weight,a.image,a.url,a.status,b.name";
        $orderfield = "a.id";
        $sort = "desc";
        $join = ['payment_type b','b.id = a.payment_id'];
        $alias = 'a';
        $date = '';
        $data = Model::joinGetdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left');

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    public function add(){

        $f[] = Form::input('title', '客服名称');
        $payment_type = Db::name('payment_type')->where('type',3)->select()->toArray();
        $f[] = Form::radio('payment_id','客服类型')->setOptions(function () use ($payment_type){
            $menus = [];
            foreach ($payment_type as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        });
        $f[] = Form::uploadImageOne('image', '图片',url('widget.Image/file',['file'=>'image']));
        $f[] = Form::number('weight', '权重');
        $f[] = Form::input('url', '人工链接');
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
        $f[] = Form::input('title', '客服名称',$active['title']);
        $payment_type = Db::name('payment_type')->where('type',3)->select()->toArray();
        $f[] = Form::radio('payment_id','客服类型',$active['payment_id'])->setOptions(function () use ($payment_type){
            $menus = [];
            foreach ($payment_type as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        });
        $f[] = Form::uploadImageOne('image', '图片',url('widget.Image/file',['file'=>'image']),$active['image']);
        $f[] = Form::number('weight', '权重',$active['weight']);
        $f[] = Form::input('url', '人工链接',$active['url']);
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



