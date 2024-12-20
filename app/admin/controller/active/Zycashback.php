<?php

namespace app\admin\controller\active;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  自研游戏反水初始值配置
 */
class Zycashback extends AuthController
{

    private $table = 'zy_cashback_config';

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


        $f[] = Form::number('minmoney', '最小充值金额(分)',0);
        $f[] = Form::number('maxmoney', '最大充值金额(分)',0);
        $f[] = Form::number('zs_cash', '赠送Cash(分)',0);
        $f[] = Form::number('zs_bonus', '赠送Bonus(分)',0);


        $form = Form::make_post_form('修改数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    public function edit($id = 0){
        $active = Db::name($this->table)->where('id',$id)->find();

        if(!$active){
            Json::fail('参数错误!');
        }

        $f[] = Form::number('minmoney', '最小充值金额(分)',$active['minmoney']);
        $f[] = Form::number('maxmoney', '最大充值金额(分)',$active['maxmoney']);
        $f[] = Form::number('zs_cash', '赠送Cash(分)',$active['zs_cash']);
        $f[] = Form::number('zs_bonus', '赠送Bonus(分)',$active['zs_bonus']);



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



