<?php

namespace app\admin\controller\slots;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  游戏平台管理
 */
class Terrace extends AuthController
{


    private $table = 'slots_terrace';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $filed = "id,name,image,status,weight,type,show_type,images,convert_bonus_bili";
        $data = Model::Getdata($this->table,$filed,$data,'weight','desc',$page,$limit,'updatetime');

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    /**
     * @return void 添加
     */
    public function add()
    {

        $f[] = Form::input('name', '厂商名称');
        $f[] = Form::uploadImageOne('image', '厂商图片',url('widget.Image/file',['file'=>'image']));
        $f[] = Form::uploadImageOne('images', '厂商图片2',url('widget.Image/file',['file'=>'images']));
        $f[] = Form::uploadImageOne('skin2_icon', '皮肤2图标',url('widget.Image/file',['file'=>'skin2_icon']));
        $f[] = Form::uploadImageOne('skin2_image', '皮肤2图片',url('widget.Image/file',['file'=>'skin2_image']));




        $home_game = Db::name('home_game')->field('id,name')->where('skin_type','=',2)->where('type',0)->select()->toArray();
        $f[] = Form::select('home_game_ids','首页游戏模块ID')->setOptions(function () use ($home_game){
            $menus = [];
            foreach ($home_game as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1)->multiple(true);

        $f[] = Form::input('type', '简称');
        $f[] = Form::number('weight', '权重',0);
        $f[] = Form::number('convert_bonus_bili', 'Bonus转化比例(小数)',0);
        $f[] = Form::radio('show_type', '显示地区',1)->options([['label' => 'slots厂商显示', 'value' => 1], ['label' => '体育厂商显示', 'value' => 2], ['label' => '全部地方显示', 'value' => 3]]);
        $f[] = Form::radio('status', '状态',0)->options([['label' => '维护', 'value' => 0], ['label' => '上线', 'value' => 1]]);

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
        $f[] = Form::input('name', '厂商名称',$terrace['name']);
        $f[] = Form::uploadImageOne('image', '厂商图片',url('widget.Image/file',['file'=>'image']),$terrace['image']);
        $f[] = Form::uploadImageOne('images', '厂商图片2',url('widget.Image/file',['file'=>'images']),$terrace['images']);
        $f[] = Form::uploadImageOne('skin2_icon', '皮肤2图标',url('widget.Image/file',['file'=>'skin2_icon']),$terrace['skin2_icon']);
        $f[] = Form::uploadImageOne('skin2_image', '皮肤2图片',url('widget.Image/file',['file'=>'skin2_image']),$terrace['skin2_image']);



        if($terrace['home_game_ids'])$terrace['home_game_ids'] = explode(',',$terrace['home_game_ids']);
        $home_game = Db::name('home_game')->field('id,name')->where('skin_type','=',2)->where('type',0)->select()->toArray();
        $f[] = Form::select('home_game_ids','首页游戏模块ID',$terrace['home_game_ids'])->setOptions(function () use ($home_game){
            $menus = [];
            foreach ($home_game as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1)->multiple(true);


        $f[] = Form::input('type', '简称',$terrace['type']);
        $f[] = Form::number('weight', '权重',$terrace['weight']);
        $f[] = Form::number('convert_bonus_bili', 'Bonus转化比例(小数)',$terrace['convert_bonus_bili']);
        $f[] = Form::radio('show_type', '显示地区',$terrace['show_type'])->options([['label' => 'slots厂商显示', 'value' => 1], ['label' => '体育厂商显示', 'value' => 2], ['label' => '全部地方显示', 'value' => 3]]);

        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($id=0){

        $data = request()->post();
        $data['updatetime'] = time();
        if(isset($data['home_game_ids'])){
            $data['home_game_ids'] = implode(',',$data['home_game_ids']);
        }else{
            $data['home_game_ids'] = '';
        }
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
        $data['updatetime'] = time();

        $res = Db::name($this->table)->where('id',$id)->update($data);
        if(!$res){
            return Json::fail('修改失败2');
        }
        if($data['status'] == 1){
            Db::name('slots_game')->where('terrace_id',$id)->where('image', '<>', '')->whereNotNull('image')->update(['status' => 1]);
        }else{
            Db::name('slots_game')->where('terrace_id',$id)->update(['status' => 0]);
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

