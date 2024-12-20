<?php

namespace app\admin\controller\statistics;
use app\admin\controller\AuthController;

use customlibrary\Common;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use app\admin\common\Retention;

/**
 *   老用户召回统计
 */
class Recallolduserlog extends AuthController
{

    private $table = 'recallold_statistics';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){

        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;


        $tablename =  $this->table;
        $filed = "FROM_UNIXTIME(a.time,'%Y-%m-%d %H:%i:%s') as time,a.sms_num,a.click_num,a.recallold_num,a.package_id,b.bagname";
        $orderfield = "a.id";
        $sort = "desc";
        $join = ['apppackage b','b.id = a.package_id'];
        $alias = 'a';
        $date = 'a.time';
        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left');

//
//        $tablename = $this->table;
//        $filed = "FROM_UNIXTIME(time,'%Y-%m-%d %H:%i:%s') as time,sms_num,click_num,recallold_num";
//        $orderfield = "id";
//        $sort = "desc";
//        $date = 'time';
//        $data = Model::Getdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$date);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    public function view($time,$package_id){
        $this->assign('time',$time);
        $this->assign('package_id',$package_id);
        return $this->fetch();
    }

    public function getUserArray(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $time = strtotime($data['time']);
        $package_id = $data['package_id'];
        unset($data['time'],$data['package_id']);
        $where = [['a.createtime','>',$time],['a.package_id','=',$package_id]];
        //获取最临近的发送时间
        $getNearTime = Db::name($this->table)->where([['time','>',$time],['package_id','=',$package_id]])->order('id','asc')->value('time');
        if($getNearTime)$where[] = ['a.createtime','<=',$getNearTime];

        $tablename = 'active_recallolduser_log';
        $filed = "a.uid,FROM_UNIXTIME(a.createtime,'%Y-%m-%d %H:%i:%s') as createtime,a.old_price,a.old_exchange,a.zs_bonus,b.total_pay_score,b.total_exchange,0 as total_bili";
        $orderfield = "a.createtime";
        $sort = "desc";
        $join = ['userinfo b','b.uid = a.uid'];
        $alias = 'a';
        $date = 'a.createtime';
        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'inner',$where);
        foreach ($data['data'] as &$v){
            $v['total_bili'] = $v['total_pay_score'] > 0 ? bcmul(bcdiv($v['total_exchange'],$v['total_pay_score'],4),100).'%' : bcdiv($v['total_exchange'],100).'%';
            $v['old_price'] = bcsub($v['total_pay_score'],$v['old_price'],0);
            $v['old_exchange'] = bcsub($v['total_exchange'],$v['old_exchange'],0);
            $v['recall_total_bili'] = $v['old_price'] > 0 ? bcmul(bcdiv($v['old_exchange'],$v['old_price'],4),100).'%' : bcdiv($v['old_exchange'],100).'%';

        }

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }
}


