<?php

namespace app\admin\controller\statistics;

use app\admin\controller\AuthController;
use app\admin\controller\Model;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;

/**
 *  玩家今日输赢排行榜和总输赢排行榜，一个玩家金币余额排行榜
 */
class Userranking extends AuthController
{

    private $table = 'userinfo';

    private $filed = "a.uid,a.coin,a.bonus,(b.cash_total_score + b.bonus_total_score) as daytotal_score,(a.cash_total_score + a.bonus_total_score) as alltotal_score,
        (a.coin + a.bonus) as cointpc,a.total_pay_score,a.total_pay_num,b.total_pay_score as day_total_pay_score,b.total_pay_num as day_total_pay_num,
        a.total_exchange,a.total_exchange_num,b.total_exchange as day_total_exchange,b.total_exchange_num as day_total_exchange_num,FROM_UNIXTIME(a.regist_time,'%Y-%m-%d %H:%i:%s') as regist_time,
        FROM_UNIXTIME(a.login_time,'%Y-%m-%d %H:%i:%s') as login_time,FROM_UNIXTIME(c.last_pay_time,'%Y-%m-%d %H:%i:%s') as last_pay_time";



    public function index()
    {
        return $this->fetch();
    }

    public function getlist(){


        $data =  request()->param();

        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 100;
        $data['ranking'] = $data['ranking'] ?? 1;

        $data['date'] = isset($data['date']) ? $data['date'] : date('Y-m-d',strtotime('00:00:00 -7day')).' - '.date('Y-m-d');
        if($data['date']){
            [$list,$count] = $this->dateData($data,$page,$limit);
        }else{
            [$list,$count] = $this->notDateData($data,$page,$limit);
        }

        foreach ($list as &$v){
            $v['day_total_exchange_bili'] = $v['day_total_pay_score'] > 0 ? bcdiv($v['day_total_exchange'],$v['day_total_pay_score'],2) : 0;  //今日退款率
            $v['total_exchange_bili'] = $v['total_pay_score'] > 0 ? bcdiv($v['total_exchange'],$v['total_pay_score'],2) : 0;  //今日退款率;   //总退款率
        }
        return json(['code' => 0, 'count' => $count, 'data' => $list]);
    }

    private function notDateData($data,$page,$limit){


        $joinTable = 'user_day_'.date('Ymd');

        [$join1,$join2] = [$joinTable.' b','b.uid = a.uid'];

        $sert = 'desc';
        if( $data['ranking'] == 1){ //用户总赢排行
            $orderfield = 'alltotal_score';
            $whereRaw = '(a.cash_total_score + a.bonus_total_score) > 0';
        }elseif ($data['ranking'] == 2){//用户总输排行
            $orderfield = 'alltotal_score';
            $whereRaw = '(a.cash_total_score + a.bonus_total_score) < 0';
            $sert = 'asc';
        }elseif ($data['ranking'] == 3){//用户每日赢排行
            $orderfield = 'daytotal_score';
            $whereRaw = '(b.cash_total_score + b.bonus_total_score) > 0';
        }elseif ($data['ranking'] == 4){//用户每日输排行
            $orderfield = 'daytotal_score';
            $whereRaw = '(b.cash_total_score + b.bonus_total_score) < 0';
            $sert = 'asc';
        }elseif ($data['ranking'] == 6){//用户总充值排行
            $orderfield = 'total_pay_score';
            $whereRaw = 'a.total_pay_score > 0';
        }elseif ($data['ranking'] == 7){//用户每日充值排行
            $orderfield = 'day_total_pay_score';
            $whereRaw = 'b.total_pay_score > 0';
        }elseif ($data['ranking'] == 8){//用户每日充值排行
            $orderfield = 'total_exchange';
            $whereRaw = 'a.total_exchange > 0';
        }elseif ($data['ranking'] == 9){//用户每日充值排行
            $orderfield = 'day_total_exchange';
            $whereRaw = 'b.total_exchange > 0';
        }elseif ($data['ranking'] == 10){//用户Cash排行
            $orderfield = 'a.coin';
            $whereRaw = 'a.coin > 0';
        }else{//用户金币余额排行
            $orderfield = 'cointpc';
            $whereRaw = '(a.coin + a.bonus) > 0';

        }

        return $this->userInfoTable($join1,$join2,$whereRaw,$page,$limit,$orderfield,$sert);

    }


    private function dateData($data,$page,$limit){

        $joinTable = 'user_day_'.date('Ymd');
        [$start,$end] = explode(' - ',$data['date']);
        $start = strtotime($start);
        $end = strtotime($end.' 23:59:59');




        [$join1,$join2] = [$joinTable.' b','b.uid = a.uid'];
        [$join3,$join4] = ['share_strlog c','c.uid = a.uid'];
        $sert = 'desc';
        if( $data['ranking'] == 1){ //用户总赢排行
            [$list,$count] = $this->getOtherTable($data['date'],1,$page,$limit);
        }elseif ($data['ranking'] == 2){//用户总输排行
            [$list,$count] = $this->getOtherTable($data['date'],2,$page,$limit);
        }elseif ($data['ranking'] == 3){//用户每日赢排行
            $orderfield = 'daytotal_score';
            $whereRaw = '(b.cash_total_score + b.bonus_total_score) > 0';
            [$list,$count] = $this->userInfoTable($join1,$join2,$whereRaw,$page,$limit,$orderfield,$sert);
        }elseif ($data['ranking'] == 4){//用户每日输排行
            $orderfield = 'daytotal_score';
            $whereRaw = '(b.cash_total_score + b.bonus_total_score) < 0';
            $sert = 'asc';
            [$list,$count] = $this->userInfoTable($join1,$join2,$whereRaw,$page,$limit,$orderfield,$sert);
        }elseif ($data['ranking'] == 6){//用户总充值排行
            [$list,$count] = $this->getOtherTable($data['date'],6,$page,$limit);

        }elseif ($data['ranking'] == 7){//用户每日充值排行
            $orderfield = 'day_total_pay_score';
            $whereRaw = 'b.total_pay_score > 0';
            [$list,$count] = $this->userInfoTable($join1,$join2,$whereRaw,$page,$limit,$orderfield,$sert);
        }elseif ($data['ranking'] == 8){//用户总提现排行

            [$list,$count] = $this->getOtherTable($data['date'],8,$page,$limit);

        }elseif ($data['ranking'] == 9){//用户每日提现排行
            $orderfield = 'day_total_exchange';
            $whereRaw = 'b.total_exchange > 0';
            [$list,$count] = $this->userInfoTable($join1,$join2,$whereRaw,$page,$limit,$orderfield,$sert);
        }elseif ($data['ranking'] == 10){//用户Cash排行
            $orderfield = 'a.coin';
            $whereRaw = 'a.coin > 0';
            $where[] = ['a.regist_time','between',"{$start},{$end}"];
            [$list,$count] = $this->userInfoTable($join1,$join2,$whereRaw,$page,$limit,$orderfield,$sert,$where);
        }else{//用户金币余额排行
            $orderfield = 'cointpc';
            $whereRaw = '(a.coin + a.bonus) > 0';
            $where[] = ['a.regist_time','between',"{$start},{$end}"];
            [$list,$count] = $this->userInfoTable($join1,$join2,$whereRaw,$page,$limit,$orderfield,$sert,$where);
        }

        return [$list,$count];
    }


    private function userInfoTable($join1,$join2,$whereRaw,$page,$limit,$orderfield,$sert,$where = []){
        $list = Db::name($this->table)
            ->alias('a')
            ->join('share_strlog c','c.uid = a.uid')
            ->leftJoin($join1,$join2)
            ->field($this->filed)
            ->where($this->sqlwhere)
            ->whereRaw($whereRaw)
            ->where($where)
            ->where('a.status',0)
            ->page($page,$limit)
            ->order($orderfield,$sert)
            ->select()
            ->toArray();

        $count = Db::name($this->table)
            ->alias('a')
            ->join('share_strlog c','c.uid = a.uid')
            ->leftJoin($join1,$join2)
            ->where($where)
            ->where('a.status',0)
            ->where($this->sqlwhere)
            ->whereRaw($whereRaw)
            ->count();
        return [$list,$count];
    }

    /**
     * @param $date
     * @param $type  1 = 总赢 ，2=总输,6=总充值 ，8 =总提现
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function getOtherTable($date,$type = 1,$page,$limit){
        [$start,$end] = explode(' - ',$date);

        $datearray = \customlibrary\Common::createDateRange($start,$end,'Ymd');
        $datearray = array_reverse($datearray);
        $list = [];
        foreach ($datearray as $k => $v) {
            $tables = 'lzmj_user_day_' . $v;
            $res = Db::query("SHOW TABLES LIKE '$tables'");
            if (!$res) {
                continue;
            }
            $user_day = Db::name('user_day_'.$v)
                ->alias('a')
                ->join('userinfo b','b.uid = a.uid')
                ->field('a.uid,a.total_pay_score,a.total_pay_num,a.total_exchange,a.total_exchange_num,(a.cash_total_score + a.bonus_total_score) as total_score')
                ->where($this->sqlwhere)
                ->where('b.status',0)
                ->select()
                ->toArray();
            if($user_day)foreach ($user_day as $value){
                if(isset($list[$value['uid']])){
                    $list[$value['uid']]['total_pay_score'] = $list[$value['uid']]['total_pay_score'] + $value['total_pay_score'];
                    $list[$value['uid']]['total_pay_num'] = $list[$value['uid']]['total_pay_num'] + $value['total_pay_num'];
                    $list[$value['uid']]['total_exchange'] = $list[$value['uid']]['total_exchange'] + $value['total_exchange'];
                    $list[$value['uid']]['total_exchange_num'] = $list[$value['uid']]['total_exchange_num'] + $value['total_exchange_num'];
                    $list[$value['uid']]['alltotal_score'] = $list[$value['uid']]['alltotal_score'] + $value['total_score'];
                }else{
                    $list[$value['uid']] = [
                        'uid' => $value['uid'],
                        'total_pay_score' => $value['total_pay_score'],
                        'total_pay_num' => $value['total_pay_num'],
                        'total_exchange' => $value['total_exchange'],
                        'total_exchange_num' => $value['total_exchange_num'],
                        'alltotal_score' => $value['total_score'],
                        'day_total_exchange' => 0,
                        'day_total_pay_score' => 0,
                        'day_total_pay_num' => 0,
                        'day_total_exchange_num' => 0,
                        'daytotal_score' => 0,
                    ];
                }
            }
        }
        if(!$list){
            return [[],0];
        }

        if($type == 1){ //1 = 总赢 ，2=总输,6=总充值 ，8 =总提现
            $distance = array_column($list,'alltotal_score');
            array_multisort($distance,SORT_DESC,$list);
        }elseif ($type == 2){
            $distance = array_column($list,'alltotal_score');
            array_multisort($distance,SORT_ASC,$list);
        }elseif ($type == 6){
            $distance = array_column($list,'total_pay_score');
            array_multisort($distance,SORT_DESC,$list);
        }else{
            $distance = array_column($list,'total_exchange');
            array_multisort($distance,SORT_DESC,$list);
        }
        $count = count($list);

        $newList = $this->getData($page,$limit,$list);

        $uidArray = [];
        foreach ($newList as $uidValue){
            $uidArray[] = $uidValue['uid'];
        }



        //计算今日的数据
        $list2 = Db::name($this->table)
            ->alias('a')
            ->join('share_strlog c','c.uid = a.uid')
            ->leftJoin('user_day_'.date('Ymd').' b','b.uid = a.uid')
            ->where('a.uid','in',$uidArray)
            ->column("a.coin,a.bonus,FROM_UNIXTIME(a.regist_time,'%Y-%m-%d %H:%i:%s') as regist_time,(b.cash_total_score + b.bonus_total_score) as daytotal_score,
        FROM_UNIXTIME(a.login_time,'%Y-%m-%d %H:%i:%s') as login_time,FROM_UNIXTIME(c.last_pay_time,'%Y-%m-%d %H:%i:%s') as last_pay_time,
        b.total_pay_score as day_total_pay_score,b.total_pay_num as day_total_pay_num,b.total_exchange as day_total_exchange,b.total_exchange_num as day_total_exchange_num",'a.uid');

        foreach ($newList as $ke => &$v){
            if(isset($list2[$v['uid']])){
                $v['tpc'] = $list2[$v['uid']]['bonus'];
                $v['coin'] = $list2[$v['uid']]['coin'];
                $v['regist_time'] = $list2[$v['uid']]['regist_time'];
                $v['daytotal_score'] = $list2[$v['uid']]['daytotal_score'];
                $v['login_time'] = $list2[$v['uid']]['login_time'];
                $v['last_pay_time'] = $list2[$v['uid']]['last_pay_time'];
                $v['day_total_pay_score'] = $list2[$v['uid']]['day_total_pay_score'];
                $v['day_total_pay_num'] = $list2[$v['uid']]['day_total_pay_num'];
                $v['day_total_exchange'] = $list2[$v['uid']]['day_total_exchange'];
                $v['day_total_exchange_num'] = $list2[$v['uid']]['day_total_exchange_num'];
            }
        }

        return [$newList,$count];

    }

    /**
     * @param $page 页数
     * @param $limit  每页多少条数据
     * @param $totalData  原数据
     * @return array
     */
    private function getData($page,$limit,$totalData){

        // 计算总页数
        $totalPages = ceil(count($totalData) / $limit);
        // 根据页数和限制数量计算起始索引
        $startIndex = ($page - 1) * $limit;


        // 判断页数是否超出范围
        if ($page > $totalPages) {
            $result = []; // 返回空数组
        } else {
            // 根据起始索引和限制数量获取分页数据
            $result = array_slice($totalData, $startIndex, $limit);
        }

        return $result;

    }


}

