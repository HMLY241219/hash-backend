<?php

namespace app\admin\controller\operate;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  反水配置
 */
class NewCashbackConfig extends AuthController
{

    private $table = 'new_week_cashback_config';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){

        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;

        $filed = "id,bili,minwater,maxwater,maxamount";

        $orderfield = "id";
        $sort = "desc";


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    public function add(){


        $f[] = Form::input('bili', '反水比例');
        $f[] = Form::input('minwater', '上周最小需求流水(分)');
        $f[] = Form::input('maxwater', '上周最大需求流水(分)');
        $f[] = Form::input('maxamount', '返奖的最大金额(分)');


        $form = Form::make_post_form('修改数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    public function edit($id = 0){
        $active = Db::name($this->table)->where('id',$id)->find();

        if(!$active){
            Json::fail('参数错误!');
        }

        $f[] = Form::input('bili', '反水比例',$active['bili']);


        $f[] = Form::input('minwater', '上周最小需求流水(分)',$active['minwater']);
        $f[] = Form::input('maxwater', '上周最大需求流水(分)',$active['maxwater']);
        $f[] = Form::input('maxamount', '返奖的最大金额(分)',$active['maxamount']);


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
        Db::name($this->table)->where('id',$data['id'])->update([$data['field'] => $data['value']]);

        return Json::successful('修改成功!');
    }
}



