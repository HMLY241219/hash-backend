<?php

namespace app\admin\controller\statistics;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use think\facade\Session;

/**
 *  基础数据列表
 */
class DayFirst extends AuthController
{

    public function index()
    {
        /*$level = getAdminLevel($this->adminInfo);

        $this->assign('adminInfo', $this->adminInfo);
        $this->assign('adminlevel', $level);*/
        $this->assign('adminInfo', $this->adminInfo);
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $tj_type = 0;
        if (isset($data['tj_type'])) {
            $tj_type = $data['tj_type'];
            unset($data['tj_type']);
        }
        //下级筛选
        $level_where = [];
        if (isset($data['channels']) && !empty($data['channels'])){
            $level_where = [['channel', 'in', $data['channels']]];
            unset($data['channels']);
        }

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 200;
        $where  = Model::getWhere2($data,'date');
        /*$chan_where = [];
        if (empty($this->sqlNewWhere)){
            $chan_where = ['channel'=>0,'package_id'=>0];
        }*/
        $NewWhere = [];
        if (!empty($this->sqlNewWhere)){
            $NewWhere = [$this->sqlNewWhere];
        }

        //平台与渠道
        $channel_where = [];
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$channel_where = [['channel', '<', 100000000]];
            } else {
                $channel_where = [['channel', '>=', 100000000]];
            }
        }

        if ($tj_type === '1'){
            $data['data'] = Db::name('day_first')
                ->field("min(date) as min_date,max(date) as max_date,sum(all_money) as all_money,sum(all_num) as all_num,sum(n10) as n10,sum(n20) as n20,
                sum(n30) as n30,sum(n60) as n60,sum(n120) as n120,sum(n720) as n720,sum(n1440) as n1440")
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->order('date', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('day_first')
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->count();
            if (!empty($data['data'])){
                foreach ($data['data'] as $dk=>$dv){
                    $data['data'][$dk]['date'] = $dv['min_date'].' - '.$dv['max_date'];
                }
            }

        }else {//正常
            $data['data'] = Db::name('day_first')
                ->field("date,sum(all_money) as all_money,sum(all_num) as all_num,sum(n10) as n10,sum(n20) as n20,
                sum(n30) as n30,sum(n60) as n60,sum(n120) as n120,sum(n720) as n720,sum(n1440) as n1440")
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->group('date')
                ->order('date', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('day_first')
                ->group('date')
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->count();
        }

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }




}
