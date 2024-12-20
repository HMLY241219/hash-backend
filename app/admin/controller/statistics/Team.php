<?php

namespace app\admin\controller\statistics;

use app\admin\controller\AuthController;
use app\admin\controller\Model;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Session;

/**
 *  推广管理
 */
class Team extends AuthController
{

    private $table = 'user_team';
    /**
     * 推广列表
     *
     */
    public function index()
    {
//        $admin = $this->adminInfo;

        return $this->fetch();
    }


    /**
     * 推广列表
     */
    public function getlist(){


        $data =  request()->param();

        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 30;
        $data['date'] = $data['date'] ?? date('Y-m-d',strtotime('-7 day')).' - '.date('Y-m-d');

        $tablename = 'user_team';
        $filed = "a.uid,b.vip,a.puid,FROM_UNIXTIME(a.createtime,'%Y-%m-%d %H:%i:%s') as createtime,FROM_UNIXTIME(a.updatetime,'%Y-%m-%d %H:%i:%s') as updatetime,b.total_pay_score";
        $join = ['userinfo b','b.uid = a.uid'];
        $orderfield = "a.createtime";
        $sort = "desc";
        $date = 'a.createtime';

//        $this->sqlwhere[] = ['a.puid','>',0];
        //平台与渠道
        $channel_where = [];
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$this->sqlwhere[] = ['a.channel', '<', 100000000];
            } else {
                $this->sqlwhere[] = ['a.channel', '>=', 100000000];
            }
        }

        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,'a',$date,'inner',$this->sqlwhere);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    /**
     * @return null
     */
    public function layuiedit(){
        $data =  request()->param();
        $res = Model::layuiedit($this->table,$data,'uid');
        if($res['code'] != 200){
            return Json::fail('修改失败');

        }
        return Json::successful('修改成功!');
    }

}

