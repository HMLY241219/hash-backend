<?php

namespace app\admin\controller\user;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  封禁用户列表
 */
class Blackuser extends AuthController
{

    private $table = "black_user";

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;



        $tablename = $this->table;
        $filed = "a.uid,FROM_UNIXTIME(a.createtime,'%Y-%m-%d %H:%i:%s') as createtime,b.real_name,a.reason";
        $orderfield = "a.createtime";
        $sort = "desc";
        $join = ['system_admin b','b.id = a.admin_id'];
        $alias = 'a';
        $date = 'a.createtime';
        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left');

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    public function unblockingUsers(){
        $list = input('list');

        if(!$list){
            return Json::successful('操作成功!');
        }

        foreach ($list as $v){
            \app\common\xsex\Common::unblockingUser($v['uid']);
        }


        return Json::successful('操作成功!');
    }

}
