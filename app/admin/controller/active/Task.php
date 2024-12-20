<?php

namespace app\admin\controller\active;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  任务管理
 */
class Task extends AuthController
{

    private $table = 'task';

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

        $f[] = Form::input('title', '名称');
        $f[] = Form::input('introduction', '简介');
        $f[] = Form::select('task_time','任务时间')->setOptions(function (){
            $menus = [];

            foreach ($this->dayConfig() as $key => $menu) {
                $menus[] = ['value' => $key, 'label' => $menu];
            }
            return $menus;
        })->filterable(1);


        $f[] = Form::select('game_code','游戏类型')->setOptions(function (){
            $menus = [];

            foreach ($this->gameCode() as $key => $menu) {
                $menus[] = ['value' => $key, 'label' => $menu];
            }
            return $menus;
        })->filterable(1);

        //任务类型:1=游戏局数,2=游戏赢得局数,游戏赢金
        $f[] = Form::radio('type', '任务类型', 1)->options([['label' => '游戏局数', 'value' => 1],['label' => '游戏赢得局数', 'value' => 2],['label' => '游戏赢金', 'value' => 3]]);

        $f[] = Form::number('num', '完成次数/对应金额',0);
        $f[] = Form::number('zs_cash', '赠送Cash(分)',0);
        $f[] = Form::number('zs_bonus', '赠送Bonus(分)',0);
        $f[] = Form::number('zs_integral', '赠送积分(分)',0);
        $f[] = Form::number('weight', '权重');
        $form = Form::make_post_form('修改数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }



    public function edit($id = 0){
        $active = Db::name($this->table)->where('id',$id)->find();

        if(!$active){
            Json::fail('参数错误!');
        }


        $f[] = Form::input('title', '名称',$active['title']);
        $f[] = Form::input('introduction', '简介',$active['introduction']);
        $f[] = Form::select('task_time','任务时间',(string)$active['task_time'])->setOptions(function (){
            $menus = [];

            foreach ($this->dayConfig() as $key => $menu) {
                $menus[] = ['value' => $key, 'label' => $menu];
            }
            return $menus;
        })->filterable(1);


        $f[] = Form::select('game_code','游戏类型',(string)$active['game_code'])->setOptions(function (){
            $menus = [];

            foreach ($this->gameCode() as $key => $menu) {
                $menus[] = ['value' => $key, 'label' => $menu];
            }
            return $menus;
        })->filterable(1);

        //任务类型:1=游戏局数,2=游戏赢得局数,游戏赢金
        $f[] = Form::radio('type', '任务类型',$active['type'])->options([['label' => '游戏局数', 'value' => 1],['label' => '游戏赢得局数', 'value' => 2],['label' => '游戏赢金', 'value' => 3]]);

        $f[] = Form::number('num', '完成次数/对应金额',$active['num']);
        $f[] = Form::number('zs_cash', '赠送Cash(分)',$active['zs_cash']);
        $f[] = Form::number('zs_bonus', '赠送Bonus(分)',$active['zs_bonus']);
        $f[] = Form::number('zs_integral', '赠送积分(分)',$active['zs_integral']);
        $f[] = Form::number('weight', '权重',$active['weight']);

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
    /**
     * @return  任务类型配置
     */
    private function dayConfig(){
        $day = [
            0 => '每周任务',
            1 => '周一任务',
            2 => '周二任务',
            3 => '周三任务',
            4 => '周四任务',
            5 => '周五任务',
            6 => '周六任务',
            7 => '周日任务',
        ];
        return $day;
    }


    /**
     * @return  游戏ID
     */
    private function gameCode(){
        return [
            0 => '全部自研',
            1003 => 'TeenPatti',
            1502 => 'Wheel Of Fortune',
            1503 => 'Dranon Tiger',
            1051 => 'Lucky Dice',
            1052 => 'Jhandi Munda',
            1053 => 'Lucky Ball',
            1054 => '3 Patti Bet',
            1055 => 'Andar Bahar',
            1062 => 'Mine',
            1070 => 'Mines',
            1071 => 'Mines2',
            1072 => 'Blastx',
            1399 => 'Aviator',
            2151 => 'Lucky Jet',
            2152 => 'Rocket Queen',
        ];
    }
}



