<?php

namespace app\admin\controller\slots;

use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;

/**
 *  三方Slots游戏记录管理
 */
class Slotslog extends AuthController
{

    public function index($uid = 0)
    {
//        $admin = $this->adminInfo;
        $this->assign('uid',$uid);
        $slots_terrace = Db::name('slots_terrace')->column('name,type');
//
        $this->assign('slots_terrace',$slots_terrace);

        return $this->fetch();
    }



    public function getlist(){
        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        if(isset($data['uid']) && $data['uid'] <= 0) unset($data['uid']);
        $where = Model::getWhere($data,'betEndTime',false);
        if($this->sqlNewWhere)$where[] = $this->sqlNewWhere;
        $filed = "englishname,CAST(parentBetId AS CHAR(30)) AS parentBetId,CAST(betId AS CHAR(30)) AS betId,uid,cashBetAmount,bonusBetAmount,cashTransferAmount,bonusTransferAmount,is_settlement,FROM_UNIXTIME(betTime,'%Y-%m-%d %H:%i:%s') as betTime,terrace_name";
        $date = isset($data['datetable']) && $data['datetable']? $data['datetable'] : date('Y-m-d').' - '.date('Y-m-d');


        [$start,$end] = explode(' - ',$date);

        $datearray = \customlibrary\Common::createDateRange($start,$end,'Ymd');

        $datearray = array_reverse($datearray);


        [$count,$dataList] = Model::SubTablequery($datearray,'br_slots_log_',$filed,$where,'betTime','desc',$page,$limit);


        return json(['code' => 0, 'count' => $count, 'data' => $dataList]);
    }


}

