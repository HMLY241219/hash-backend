<?php

namespace app\admin\controller\operate;

use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  登录ip白名单配置
 */
class IpLoginIpWhite extends AuthController
{


    private $table = 'ip_login_white';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;

        $filed = "ip";

        $orderfield = "ip";
        $sort = "desc";


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    public function add(){

        $f = array();
        $f[] = Form::input('ip', 'IP');
        $form = Form::make_post_form('修改数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function edit($ip = 0){
        $banner = Db::name($this->table)->where('ip',$ip)->find();
        if(!$banner){
            Json::fail('参数错误!');
        }

        $f = array();
        $f[] = Form::input('ip', 'IP',$banner['ip']);

        $form = Form::make_post_form('修改数据', $f, url('save',['ip' => $ip]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }





    /**
     * @return void 存储数据
     */
    public function save($ip=0){

        $data = request()->post();
        $res = Db::name($this->table)->insert($data);
        if(!$res){
            Json::fail('添加失败');
        }
        return Json::successful($ip > 0 ? '修改成功!' : '添加成功!');
    }



    /**
     * @return void 删除数据
     */
    public function delete($ip = ''){
        $res = Db::name($this->table)->where('ip',$ip)->delete();

        if(!$res){
            return Json::fail('删除失败');
        }
        return Json::successful('删除成功!');
    }
}



