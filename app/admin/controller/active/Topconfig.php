<?php

namespace app\admin\controller\active;

use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  排行榜奖励配置
 */
class Topconfig extends AuthController
{


    private $table = 'top_config';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;

        $filed = "*,FROM_UNIXTIME(update_time,'%Y-%m-%d %H:%i:%s') as update_time";

        $orderfield = "type,rank";
        $sort = "asc";


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit);
        /*foreach ($data['data'] as &$v){
            $v['week'] = $this->get_week_array($v['week']);
        }*/
        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    public function add(){

        $f = array();
        $f[] = Form::input('rank', '排名（范围使用逗号隔开）');
        $f[] = Form::number('cash','赠送cash金额（分）');
        $f[] = Form::number('bonus','赠送bonus金额(分)');
        $f[] = Form::radio('type', '类型',0)->options([['label' => '每日排行配置', 'value' => 0], ['label' => '每周团队排行配置', 'value' => 1]]);

        $form = Form::make_post_form('添加数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function edit($id = 0){
        $banner = Db::name($this->table)->where('id',$id)->find();
        if(!$banner){
            Json::fail('参数错误!');
        }

        $f = array();
        $f[] = Form::input('rank', '排名（范围使用逗号隔开）',$banner['rank']);
        $f[] = Form::number('cash', '赠送cash金额（分）',$banner['cash']);
        $f[] = Form::number('bonus', '赠送bonus金额(分)',$banner['bonus']);
        $f[] = Form::radio('type', '类型',$banner['type'])->options([['label' => '每日排行配置', 'value' => 0], ['label' => '每周团队排行配置', 'value' => 1]]);


        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }





    /**
     * @return void 存储数据
     */
    public function save($id=0){

        $data = request()->post();
        $data['admin'] = $this->adminName;
        $data['update_time'] = time();

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

    private function get_week_array($week = 0){
        $week_array = array(
            '0' => '星期日',
            '1' => '星期一',
            '2' => '星期二',
            '3' => '星期三',
            '4' => '星期四',
            '5' => '星期五',
            '6' => '星期六',
        );
        return $week_array[$week];
    }
}





