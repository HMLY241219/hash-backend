<?php

namespace app\admin\controller\user;

use app\admin\controller\AuthController;
use app\admin\model\games\Coin;
use app\admin\model\games\GameRecords;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
use app\admin\controller\Common;


/**
 *  用户流水日志
 */
class Flowlog extends AuthController
{

    public function index($uid = 0,$type = 1)
    {
        $this->assign('uid',$uid);
        $this->assign('type',$type);
        $reason = $type == 1 ? Config::get('my.reason') : Config::get('reason.zs_reason');
        $this->assign('reason',$reason);
        return $this->fetch();
    }



    public function getlist(){
        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 500;
        if(isset($data['uid']) && $data['uid'] <= 0) unset($data['uid']);
        $type = $data['type'];
        $watertype = $data['watertype'] ?? 1;
        unset($data['type']);
        unset($data['watertype']);
        $where = Model::getWhere($data);
        if($type == 2 && (!isset($data['reason']) || !$data['reason'])){
            $config = Config::get('reason.zs_reason');
            $zcReasonArray = array_keys($config);
            $where[] = ['reason','in',$zcReasonArray];
        }
        $where[] = ['num','<>',0];
        $filed = "id,uid,num,total,reason,FROM_UNIXTIME(createtime,'%Y-%m-%d %H:%i:%s') as createtime";
        $date = isset($data['datetable']) && $data['datetable']? $data['datetable'] : date('Y-m-d',strtotime('-7 day')).' - '.date('Y-m-d');

        [$start,$end] = explode(' - ',$date);

        $datearray = \customlibrary\Common::createDateRange($start,$end,'Ymd');
        $datearray = array_reverse($datearray);
        $table = $watertype == 1 ? 'br_coin_' : 'br_bonus_';
        [$count,$dataList] = Model::SubTablequery($datearray,$table,$filed,$where,'createtime','desc',$page,$limit);


        $zsSum = 0;
        if($dataList){
            foreach ($dataList as $v){
                $zsSum +=  $v['num'];
            }
        }

        return json(['code' => 0, 'sum' => $zsSum,'type' => $type,'count' => $count, 'data' => $dataList]);
    }


    public function getReason(){
        $param = request()->param();
        $type = isset($param['type']) ? $param['type'] : 1;
        $reason = $type == 1 ? Config::get('reason.reason') : Config::get('reason.zs_reason');

        $data = [];
        if (!empty($reason)){
            foreach ($reason as $key=>$value){
                $data[$key]['name'] = $value;
                $data[$key]['value'] = $key;
            }
        }
        sort($data);

        return Json::success('成功',$data);
    }


    public function tkFallback(){
        $data = input('data');
        $withdraw_log = Db::name('withdraw_log')->field('id,status,admin_id,remark')->where([['uid','=',$data['uid']],['finishtime','<=',strtotime($data['time_stamp'])],['money','=',$data['num']],['status','in','2,-1']])->order('finishtime','desc')->find();
        if(!$withdraw_log){
            return Json::success('成功','三方退款失败!');
        }
        if((int)$withdraw_log['status'] === -1){
            $real_name = Db::name('system_admin')->where('id',$withdraw_log['admin_id'])->value('real_name');
            return Json::success('成功','管理员:'.$real_name.'驳回订单');
        }else{
            $log_error = Db::name('withdraw_logcenter')->where('withdraw_id',$withdraw_log['id'])->value('log_error');
            $error = \customlibrary\Common::getTripartiteErrorInfo($log_error);
            return Json::success('成功',$error ?: '三方退款失败,无具体原因');
        }
    }
}

