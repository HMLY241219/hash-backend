<?php

namespace app\admin\controller\slots;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  首页模块厂商配置
 */
class TerraceType extends AuthController
{


    private $table = 'slots_terrace_type';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $filed = "*";
        $data = Model::Getdata($this->table,$filed,$data,'weight','desc',$page,$limit,'updatetime');

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    /**
     * @return void 添加
     */
    public function add()
    {
        $f[] = Form::input('name', '名称');
        $f[] = Form::uploadImageOne('image', '图片',url('widget.Image/file',['file'=>'image']));
        $f[] = Form::uploadImageOne('icon', '图标',url('widget.Image/file',['file'=>'icon']));


        $home_game = Db::name('home_game')->field('id,name')->where('skin_type','=',2)->where('type','<>',1)->select()->toArray();
        $f[] = Form::select('home_game_id','首页游戏模块')->setOptions(function () use ($home_game){
            $menus = [];
            foreach ($home_game as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);


        $slots_terrace = Db::name('slots_terrace')->field('id,name')->select()->toArray();
        $f[] = Form::select('terrace_id','游戏厂商')->setOptions(function () use ($slots_terrace){
            $menus = [];
            foreach ($slots_terrace as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);


        $f[] = Form::radio('jump_type', '跳转类型', 0)->options([['label' => '游戏', 'value' => 0],['label' => '游戏大厅', 'value' => 4]]);



        $f[] = Form::number('weight', '权重',0);

        $f[] = Form::radio('status', '状态',1)->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);

        $form = Form::make_post_form('添加数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function edit($id = 0){
        $terrace = Db::name($this->table)->where('id',$id)->find();
        if(!$terrace){
            Json::fail('参数错误!');
        }

        $f = array();
        $f[] = Form::input('name', '名称',$terrace['name']);
        $f[] = Form::uploadImageOne('image', '图片',url('widget.Image/file',['file'=>'image']),$terrace['image']);
        $f[] = Form::uploadImageOne('icon', '图标',url('widget.Image/file',['file'=>'icon']),$terrace['icon']);



        $home_game = Db::name('home_game')->field('id,name')->where('skin_type','=',2)->where('type','<>',1)->select()->toArray();
        $f[] = Form::select('home_game_id','首页游戏模块ID',(string)$terrace['home_game_id'])->setOptions(function () use ($home_game){
            $menus = [];
            foreach ($home_game as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);



        $slots_terrace = Db::name('slots_terrace')->field('id,name')->select()->toArray();
        $f[] = Form::select('terrace_id','游戏厂商',(string)$terrace['terrace_id'])->setOptions(function () use ($slots_terrace){
            $menus = [];
            foreach ($slots_terrace as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);

        $f[] = Form::radio('jump_type', '跳转类型',$terrace['jump_type'])->options([['label' => '游戏', 'value' => 0],['label' => '游戏大厅', 'value' => 4]]);

        $f[] = Form::number('weight', '权重',$terrace['weight']);
        $f[] = Form::radio('status', '状态',$terrace['status'])->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);

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
     * @return void 修改状态
     */
    public function is_show(){

        $id = request()->post('id');
        $data['status'] = request()->post('status');


        $res = Db::name($this->table)->where('id',$id)->update($data);
        if(!$res){
            return Json::fail('修改失败2');
        }

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


