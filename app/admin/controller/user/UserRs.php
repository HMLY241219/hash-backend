<?php

namespace app\admin\controller\user;

use app\admin\controller\AuthController;
use app\admin\controller\Model;
use app\admin\model\games\GameRecords;
use app\admin\model\games\UserDay;
use app\admin\model\system\SystemConfig;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\api\controller\My;
use app\common\xsex\Common;
use app\admin\Redis\pbuser\PBUserModel;
use think\facade\Session;

/**
 *  大R预流失用户管理
 */
class UserRs extends AuthController
{
    /**
     * 用户列表
     *
     */
    public function index()
    {
        $admininfo = $this->adminInfo;
        $this->assign('admininfo',$admininfo);
        return $this->fetch();
    }


    /**
     * 用户列表
     */
    public function getlist(){

        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;

        $data['date'] = isset($data['date']) ? $data['date'] : date('Y-m-d',strtotime('00:00:00 -7day')).' - '.date('Y-m-d');
        if(isset($data['a_uid@like']) && $data['a_uid@like'])unset($data['date']);
        //$order = $this->getOrder($data);
        $amount_reduction_multiple = config('my.amount_reduction_multiple');  //后台金额缩小倍数

        if (isset($data['min_pay']) && $data['min_pay']!==''){
            $this->sqlwhere[] = ['a.total_pay_score','>=',$data['min_pay']*$amount_reduction_multiple];
            unset($data['min_pay']);
        }
        if (isset($data['max_pay']) && $data['max_pay']!==''){
            $this->sqlwhere[] = ['a.total_pay_score','<=',$data['max_pay']*$amount_reduction_multiple];
            unset($data['max_pay']);
        }

        /*$min_rate_where = [];
        if (isset($data['min_rate']) && $data['min_rate']!==''){
            $min_rate = $data['min_rate']/100;
            $min_rate_where = function ($query) use ($min_rate) {
                $query->whereRaw('a.total_exchange / a.total_pay_score >= ?', [$min_rate]);
            };
            unset($data['min_rate']);
        }

        $max_rate_where = [];
        if (isset($data['max_rate']) && $data['max_rate']!==''){
            $max_rate = $data['max_rate']/100;
            $max_rate_where = function ($query) use ($max_rate) {
                $query->whereRaw('a.total_exchange / a.total_pay_score <= ?', [$max_rate]);
            };
            unset($data['max_rate']);
        }*/

        $where  = Model::getWhere($data,'regist_time');

        //平台与渠道
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$this->sqlwhere[] = ['a.channel', '<', 100000000];
            } else {
                $this->sqlwhere[] = ['a.channel', '>=', 100000000];
            }
        }

        $data['data'] = Db::name('userinfo')
            ->alias('a')
            ->field("a.uid,FROM_UNIXTIME(a.regist_time,'%m-%d %H:%i:%s') as regist_time,a.total_pay_score,a.total_exchange,a.get_bonus,
            IFNULL(b.zh_cash,0) as zh_cash")
            ->leftJoin('user_other b', 'a.uid = b.uid')
            //->join('share_strlog c','c.uid = a.uid')
            //->join('chanel d','d.cid = a.channel')
            ->where($where)
            ->where($this->sqlwhere)
            ->order('a.total_pay_score','desc')
            ->order('a.regist_time','desc')
            ->page($page,$limit)
            ->select()
            ->toArray();
//        $ss = Db::name('')->getLastSql();
//        dd($ss);

        $data['count'] = Db::name('userinfo')
            ->alias('a')
            ->leftJoin('user_other b', 'a.uid = b.uid')
            ->where($where)
            ->where($this->sqlwhere)
            ->count();

        if($data['data']){
            foreach ($data['data'] as &$v){
                $v['total_pay_score'] = bcdiv((string)$v['total_pay_score'], $amount_reduction_multiple,2) ?: 0;
                $v['total_exchange'] = bcdiv((string)$v['total_exchange'], $amount_reduction_multiple,2) ?: 0;
                $v['get_bonus'] = bcdiv((string)$v['get_bonus'], $amount_reduction_multiple,2) ?: 0;
                $v['zh_cash'] = bcdiv((string)$v['zh_cash'], $amount_reduction_multiple,2) ?: 0;

                //总提现比例
                $v['total_bili'] = $v['total_pay_score'] > 0 ? round(bcdiv($v['total_exchange'],$v['total_pay_score'],4)*100,2) : 0;


                //未玩游戏天数
                //$v['not_play_game_day'] = bcdiv((time() - strtotime($v['login_time'])),86400,0);
            }
        }
        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    private function getOrder(&$data){
        $login_time = '';
        $order = ['a.uid'=>'desc'];
        if (isset($data['login_time'])){
            $login_time = $data['login_time'];
            unset($data['login_time']);
        }
        if ($login_time == 1){
            $order = ['a.login_time'=>'asc'];
        }elseif ($login_time == 2){
            $order = ['a.login_time'=>'desc'];
        }
        return $order;
    }

    /**
     * 游戏统计
     * @param $uid
     * @param $dates
     * @return string|void
     * @throws \Exception
     */
    public function game($uid = 0, $dates=''){
        $param = [];
        $param['uid'] = $uid;
        $param['dates'] = $dates.' - '.date('Y-m-d H:i:s');
        $field = 'game_type,coin_change,service_score';
        $game_list = (new UserDay)->getDataMulti($param);
        //sort($game_list['data']);
        $list = $game_list['data'];
        //$daa = getDiffDate(date('Y-m-d',strtotime($dates)),date('Y-m-d'));

        $new_list = [];
        if (!empty($list)){
            foreach ($list as $key=>$value){
                if ($value['updatetime'] > 0){
                    $new_list[] = [
                        'day' => getDiffDate(date('Y-m-d', $value['updatetime']), date('Y-m-d')) + 1,
                        'total_score' => $value['total_score']/100,
                        'total_service_score' => $value['total_service_score']/100,
                        'total_pay_score' => $value['total_pay_score']/100,
                        'total_exchange' => $value['total_exchange']/100,
                        'total_bili' => $value['total_pay_score'] > 0 ? bcdiv($value['total_exchange'],$value['total_pay_score'],2)*100 : 0,
                    ];
                }
            }
        }

        $this->assign('userInfo',$new_list);
        return $this->fetch();
    }
}
