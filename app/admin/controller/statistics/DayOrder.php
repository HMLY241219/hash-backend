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
class DayOrder extends AuthController
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

        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数
        if ($tj_type === '1'){
            $data['data'] = Db::name('day_order')
                ->field("min(date) as min_date,max(date) as max_date,sum(all_money) as all_money,sum(all_count) as all_count,sum(m100) as m100,sum(m300) as m300,sum(m500) as m500,sum(m1000) as m1000,sum(m3000) as m3000,
                sum(m5000) as m5000,sum(m10000) as m10000,sum(m20000) as m20000,sum(m49999) as m49999,sum(c100) as c100,sum(c300) as c300,sum(c500) as c500,sum(c1000) as c1000,
                sum(c3000) as c3000,sum(c5000) as c5000,sum(c10000) as c10000,sum(c20000) as c20000,sum(c49999) as c49999")
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->order('date', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('day_order')
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->count();
            if (!empty($data['data'])){
                foreach ($data['data'] as $dk=>$dv){
                    $data['data'][$dk]['date'] = $dv['min_date'].' - '.$dv['max_date'];
                    $data['data'][$dk]['all_money2'] = bcdiv($dv['all_money'], $amount_reduction_multiple, 2);
                }
            }

        }else {//正常
            $data['data'] = Db::name('day_order')
                ->field("date,sum(all_money) as all_money,sum(all_count) as all_count,sum(m100) as m100,sum(m300) as m300,sum(m500) as m500,sum(m1000) as m1000,sum(m3000) as m3000,
                sum(m5000) as m5000,sum(m10000) as m10000,sum(m20000) as m20000,sum(m49999) as m49999,sum(c100) as c100,sum(c300) as c300,sum(c500) as c500,sum(c1000) as c1000,
                sum(c3000) as c3000,sum(c5000) as c5000,sum(c10000) as c10000,sum(c20000) as c20000,sum(c49999) as c49999")
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->group('date')
                ->order('date', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();
            $data['count'] = Db::name('day_order')
                ->group('date')
                ->where($where)
                ->where($NewWhere)
                ->where($channel_where)
                ->count();
            if (!empty($data['data'])){
                foreach ($data['data'] as $ddk=>$ddv){
                    $data['data'][$ddk]['all_money2'] = bcdiv($ddv['all_money'], $amount_reduction_multiple, 2);
                }
            }
        }

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }




}
