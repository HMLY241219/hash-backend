<?php

namespace app\admin\controller\statistics;

use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  反水领取记录
 */
class Betrayallog extends AuthController
{


    private $table = 'betrayal_log';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;
        $where = [];
        if(isset($data['type']) && $data['type']){
            $where[] = $data['type'] == 1 ? ['status','=',1] : ['status','<>',1];
        }
        if(isset($data['type']))unset($data['type']);
        $filed = "id,uid,amount,status,FROM_UNIXTIME(createtime,'%Y-%m-%d %H:%i:%s') as createtime,betrayal_start_date";

        $orderfield = "id";
        $sort = "desc";


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit,'createtime',$where);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


}






