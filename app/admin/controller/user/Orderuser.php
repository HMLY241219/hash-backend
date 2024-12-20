<?php

namespace app\admin\controller\user;

use app\admin\controller\AuthController;
use app\admin\controller\Model;
use app\admin\model\system\SystemConfig;
use app\admin\Redis\pbuser\PBUserModel;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\model\games\GameRecords;
use app\admin\model\games\GameTable;
/**
 *  用户管理
 */
class Orderuser extends AuthController
{
    /**
     * 用户列表
     *
     */
    public function index()
    {
//        $admin = $this->adminInfo;
        $data =  request()->param();
        //dd($data);
        return $this->fetch();
    }


    /**
     * 用户列表
     */
    public function getlist(){

        $data =  request()->param();
        if (!isset($data['id']) || !isset($data['type'])){
            return json(['code' => 0, 'count' => 0, 'data' => []]);
        }
        $day_id = $data['id'];
        $type = $data['type'];
        $daydate = $data['daydate'];
        unset($data['id'],$data['type'],$data['daydate']);

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        //$data['date'] = isset($data['date']) ? $data['date'] : date('Y-m-d').' - '.date('Y-m-d');

        $table = 'user_day_'.date('Ymd',strtotime($daydate));
        $shtable = "SHOW TABLES LIKE 'lzmj_".$table."'";
        $res = Db::query($shtable);
        if(!$res){
            return json(['code' => 0, 'count' => 0, 'data' => []]);
        }

        $where  = Model::getWhere($data,'regist_time');

        
        $this->sqlwhere[] = ['c.isgold','=',0];

        /*if ($type == 1) {
            $users = Db::name('day_data')->where('id',$day_id)->value('new_recharge_suc_users');
        }elseif ($type == 2){
            $users = Db::name('day_data')->where('id',$day_id)->value('old_recharge_suc_users');
        }elseif ($type == 3){
            $users = Db::name('day_data')->where('id',$day_id)->value('new_withdraw_users');
        }elseif ($type == 4){
            $users = Db::name('day_data')->where('id',$day_id)->value('old_withdraw_users');
        }*/
        //var_dump($day_id);exit;

        $data['data'] = Db::name('userinfo')
            ->alias('a')
            ->field("b.total_pay_score as daytotal_pay_score,b.total_give_score as daytotal_give_score,b.total_exchange as daytotal_exchange,
            b.total_exchange_num as daytotal_exchange_num,b.total_game_num as daytotal_game_num,
            a.uid,a.vip,a.status,a.coin,a.first_pay_score,a.total_pay_score,a.total_give_score,a.total_exchange,a.total_exchange_num,a.now_cash_score_water,a.now_bonus_score_water,
            a.total_game_num,a.cash_total_score,a.bonus_total_score,a.total_pay_num,a.cash_total_score,a.bonus_total_score,
            a.total_game_day,a.ip,FROM_UNIXTIME(a.regist_time,'%Y-%m-%d %H:%i:%s') as regist_time,a.get_bonus,a.total_cash_water_score,a.total_bonus_water_score,a.bonus_cash,
            FROM_UNIXTIME(a.login_time,'%Y-%m-%d %H:%i:%s') as login_time")
            ->leftJoin($table.' b','b.uid = a.uid')
            ->join('share_strlog c','c.uid = a.uid')
            ->where($where)
            ->where($this->sqlwhere)
            ->whereIn('a.uid',$day_id)
            ->order('a.uid','desc')
            ->page($page,$limit)
            ->select()
            ->toArray();
        $data['count'] = Db::name('userinfo')
            ->alias('a')
            ->leftJoin($table.' b','b.uid = a.uid')
            ->join('share_strlog c','c.uid = a.uid')
            ->where($where)
            ->where($this->sqlwhere)
            ->whereIn('a.uid',$day_id)
            ->count();

        if($data['data']){
            foreach ($data['data'] as &$v){
                foreach ($v as &$ll){
                    if(is_null($ll)){
                        $ll = 0;
                    }
                }
                //总提现比例
                $v['total_bili'] = $v['total_pay_score'] > 0 ? bcdiv($v['total_exchange'],$v['total_pay_score'],2) : 0;
                //今日提现比例
                $v['day_total_bili'] = $v['daytotal_pay_score'] > 0 ? bcdiv($v['daytotal_exchange'],$v['daytotal_pay_score'],2) : 0;
                //未玩游戏天数
                $v['not_play_game_day'] = bcdiv((time() - strtotime($v['login_time'])),86400,0);

                //游戏
                /*$kkk=PBUserModel::searchuser($v['uid']);
                $v['game_name_info'] = '';
                if ($kkk){
                    $usergame_info = PBUserModel::changuserfield('uid,PBBPlayerPositionInfo',0,$kkk,[]);
                    $v['game_name_info'] = $usergame_info['PBBPlayerPositionInfo'];
                }*/

                $v['cash_water_multiple'] = ($v['total_pay_score'] + $v['total_give_score']) > 0 ? bcdiv($v['total_cash_water_score'],$v['total_pay_score'] + $v['total_give_score'], 2) : 0;
                $v['bonus_water_multiple'] = $v['get_bonus'] > 0 ? bcdiv($v['total_bonus_water_score'], $v['get_bonus'], 2) : 0;
            }
        }
        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    public function view($uid = 0){

        $table = 'user_day_'.date('Ymd');
        $userinfo = Db::name('userinfo')
            ->alias('a')
            ->field("c.code,c.really_commission_allmoney,b.total_pay_score as daytotal_pay_score,b.total_give_score as daytotal_give_score,
            b.total_exchange as daytotal_exchange,b.total_exchange_num as daytotal_exchange_num,(b.total_score + b.total_outside_score)  as daytotal_score,
            b.total_outside_game_num as daytotal_outside_game_num,b.total_game_num as daytotal_game_num,a.uid,a.vip,a.nick_name,a.status,a.coin,a.first_pay_score,
            a.now_score_water,a.need_score_water,a.total_pay_score,a.total_give_score,(a.total_score + a.total_outside_score) as total_score,
            a.total_exchange,a.total_exchange_num,(a.total_water_score + a.total_outside_water_score) as alltotal_water_score,a.total_water_score,a.total_outside_water_score,
            a.tpc_unlock,(a.tpc - a.tpc_unlock) as sytpc,a.total_tpc_to,a.total_game_num,a.total_outside_game_num,a.total_game_day,a.ip,
            FROM_UNIXTIME(a.regist_time,'%Y-%m-%d %H:%i:%s') as regist_time,FROM_UNIXTIME(a.login_time,'%Y-%m-%d %H:%i:%s') as login_time,
            des,d.phone,d.email,a.total_outside_score as sftotal_outside_score,a.total_score as pttotal_score,d.appname,d.channel,
            d.is_brushgang,a.water_to_coins,a.total_water_to_coins,a.vip_back,a.total_vip_back,(a.jiacoin - a.total_vip_back) as sy_vip_back")
            ->leftJoin($table.' b','a.uid = b.uid')
            ->leftJoin('user_team c','c.uid = a.uid')
            ->leftJoin('share_strlog d','d.uid = a.uid')
            ->where('a.uid',$uid)
            ->find();
        if(!$userinfo){
            echo '用户不存在!';
            exit();
        }
        foreach ($userinfo as &$v){
            if(is_null($v)){
                $v = 0;
            }
        }

        $userinfo['user_package_source'] = $userinfo['appname'] == 'com.wbwiqq.uqtvcgbjuvjuv' ? '分享包' : '主包';
        //总提现比例
        $userinfo['total_bili'] = $userinfo['total_pay_score'] > 0 ? bcdiv($userinfo['total_exchange'],$userinfo['total_pay_score'],2) : 0;
        //今日提现比例
        $userinfo['day_total_bili'] = $userinfo['daytotal_pay_score'] > 0 ? bcdiv($userinfo['daytotal_exchange'],$userinfo['daytotal_pay_score'],2) : 0;
        //未玩游戏天数
        $userinfo['not_play_game_day'] = bcdiv((time() - strtotime($userinfo['login_time'])),86400,0);
        //返水比例
        $userinfo['chahback'] = 0.00;
        if($userinfo['vip'] != 0){
            $redis = new \Redis();
            $redis->connect(Config::get('redis.ip'),6502);
            $level = $redis->hGet('vip_'.$userinfo['vip'],'chahback');
            $userinfo['chahback'] = bcdiv($level,100,2);
        }

        $user_team = Db::name('user_team')->field('createtime')->where('puid',$uid)->select()->toArray();

        //注册地址
        $userinfo['address'] = $userinfo['ip'] ? \customlibrary\Common::get_ip_addr($userinfo['ip']) : '';

        //今日推广人数
        $userinfo['day_charcount'] = 0;
        if($user_team){

            foreach ($user_team as $value){
                if($value['createtime'] > strtotime('00:00:00')){
                    $userinfo['day_charcount'] += 1;
                }
            }
        }
        //推广人数
        $userinfo['charcount'] = count($user_team);
        //今日返利金额

        $userinfo['dayreally_commission_allmoney'] = $this->getDayreallyCommission($uid);

        //银行卡信息
        $user_withinfo_bank = Db::name('user_withinfo')->field('backname,bankaccount,ifsccode,phone,email')->where(['uid' => $uid,'type' => 1])->find();
        $userinfo['backname'] = $user_withinfo_bank['backname'] ?? '';
        $userinfo['ifsccode'] = $user_withinfo_bank['ifsccode'] ?? '';
        $userinfo['bankaccount'] = $user_withinfo_bank['bankaccount'] ?? '';
        $userinfo['bankemail'] = $user_withinfo_bank['email'] ?? '';
        $userinfo['bankphone'] = $user_withinfo_bank['phone'] ?? '';

        //UPI信息
        $user_withinfo_upi = Db::name('user_withinfo')->field('backname,bankaccount,phone,email')->where(['uid' => $uid,'type' => 2])->find();
        $userinfo['upikname'] = $user_withinfo_upi['backname'] ?? '';
        $userinfo['upiaccount'] = $user_withinfo_upi['bankaccount'] ?? '';
        $userinfo['upiemail'] = $user_withinfo_upi['email'] ?? '';
        $userinfo['upiphone'] = $user_withinfo_upi['phone'] ?? '';


        $this->assign('userInfo',$userinfo);
        return $this->fetch();
    }

    /**
     * echarts数据
     * @return void
     */
    public function echartsdata($uid = 0){



        $endtime = date('Y-m-d');  //开始时间
        $starttime = date('Y-m-d',strtotime(date('Y-m-d') . ' -30 day')); //30天时间

        $data['date'] = \customlibrary\Common::createDateRange($starttime,$endtime,'Y-m-d');
        $data['total_score'] = [];  //每日总输赢
        $data['total_pay_score'] = []; //每日总充值
        $data['total_exchange'] = [];   //每日总提现
        foreach ($data['date'] as $v){
            $time = str_replace('-','',$v);
            $table = 'user_day_'.$time;
            $sql = "SHOW TABLES LIKE 'lzmj_".$table."'";
            $res = Db::query($sql);
            if(!$res){
                $data['total_score'][] = 0;
                $data['total_pay_score'][] = 0;
                $data['total_exchange'][] = 0;
                continue;
            }
            $userday = Db::name($table)->field('(total_score + total_outside_score) as total_score,total_pay_score,total_exchange')->where('uid',$uid)->find();
            if(!$userday){
                $data['total_score'][] = 0;
                $data['total_pay_score'][] = 0;
                $data['total_exchange'][] = 0;
                continue;
            }
            $data['total_score'][] = bcdiv($userday['total_score'],100,2);
            $data['total_pay_score'][] = bcdiv($userday['total_pay_score'],100,2);
            $data['total_exchange'][] = bcdiv($userday['total_exchange'],100,2);



        }
        return json($data);
    }



    //游戏记录
    public function record($uid)
    {
        $this->assign('uid', $uid);

        return $this->fetch();
    }

    public function record_list()
    {
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;

        $where = Model::getWhere($data);

        $filed = "game_type,game_id,bet_score,total_score,service_score,time_stamp,final_score";
        $date = isset($data['datetable']) && $data['datetable']? $data['datetable'] : date('Y-m-d').' - '.date('Y-m-d');


        [$start,$end] = explode(' - ',$date);

        $datearray = \customlibrary\Common::createDateRange($start,$end,'Ymd');
        $datearray = array_reverse($datearray);

        $allcount = 0;
        $min_count = $limit * ($page - 1); //开始的最小查询数量
        $max_count = $limit * $page;

        $wheredata = [];
        foreach ($datearray as $k => $v){
            $table = 'game_records_'.$v;
            $tables = 'lzmj_game_records_'.$v;
            $res = Db::query("SHOW TABLES LIKE '$tables'");
            if(!$res){
                continue;
            }
            $count = Db::name($table)->where($where)->count(); //25
            $allcount += $count;
            $wheredata[$v] = $count;
            if($allcount >= $max_count){
                break;
            }
            if(end($datearray) == $v){ //最后一次
                if($allcount <= $min_count){
                    return json(['code' => 0,'count' => $allcount,'data'=>[]]);
                }
            }
        }
        $table_list = $this->pageSelectDBData($page,$limit,$wheredata);
        if(!$table_list){
            return json(['code' => 0,'count' => $allcount,'data'=>[]]);
        }
        $data = [];
        foreach ($table_list as $key => $value){
            $table = 'lzmj_game_'.$key;
            $list = Db::name($table)
                ->field($filed)
                ->where($where)
                ->order('time_stamp','desc')
                ->limit($value['page'],$value['limit'])
                ->select()
                ->toArray();
            $data = array_merge($data,$list);
        }
        return json(['code' => 0, 'count' => $allcount, 'data' => $data]);
    }

    //牌局日志
    public function log($uid)
    {
        $this->assign('uid', $uid);

        $this->assign('game_name_type', config('game.gamename'));

        return $this->fetch();
    }

    public function log_list()
    {
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;

        $where = Model::getWhere($data);

        $filed = "id,uid,game_type,CAST(game_id AS CHAR(30)) AS game_id,bet_score,total_score,service_score,time_stamp,final_score,table_level";
        $date = isset($data['datetable']) && $data['datetable']? $data['datetable'] : date('Y-m-d').' - '.date('Y-m-d');


        [$start,$end] = explode(' - ',$date);

        $datearray = \customlibrary\Common::createDateRange($start,$end,'Ymd');
        $datearray = array_reverse($datearray);

        $allcount = 0;
        $min_count = $limit * ($page - 1); //开始的最小查询数量
        $max_count = $limit * $page;

        $wheredata = [];
        foreach ($datearray as $k => $v){
            $table = 'game_records_'.$v;
            $tables = 'lzmj_game_records_'.$v;
            $res = Db::query("SHOW TABLES LIKE '$tables'");
            if(!$res){
                continue;
            }
            $count = Db::name($table)->where($where)->count(); //25
            $allcount += $count;
            $wheredata[$v] = $count;
            if($allcount >= $max_count){
                break;
            }
            if(end($datearray) == $v){ //最后一次
                if($allcount <= $min_count){
                    return json(['code' => 0,'count' => $allcount,'data'=>[]]);
                }
            }
        }
        $table_list = $this->pageSelectDBData($page,$limit,$wheredata);
        if(!$table_list){
            return json(['code' => 0,'count' => $allcount,'data'=>[]]);
        }
        $data = [];
        foreach ($table_list as $key => $value){
            $table = 'game_records_'.$key;
            $list = Db::name($table)
                ->field($filed)
                ->where($where)
                ->order('time_stamp','desc')
                ->limit($value['page'],$value['limit'])
                ->select()
                ->toArray();
            $data = array_merge($data,$list);
        }

        return json(['code' => 0, 'count' => $allcount, 'data' => $data]);
    }


    /**
     * 返回分页数据表的后缀，以及page和limit
     * @param $page 当前第几页
     * @param $limit 分页的数量
     * @param $DBData ['20230315' => 10 ,'20230316' => 20]  分表的后缀加上条数
     * @return array
     */
    public function pageSelectDBData($page,$limit,$DBData){

        $retData = [];
        $pushIdx = 0;
        $breaked = false;
        $endIdx = $page * $limit;
        $startIdx = ($page - 1) * $limit;

        foreach ($DBData as $k => $v){
            for ($j=0;$j<$v;$j++){
                $pushIdx += 1;
                if($pushIdx >= $startIdx && $pushIdx < $endIdx){
                    array_push($retData,[$k,$j]);
                }
                if($pushIdx > $endIdx){
                    $breaked = true;
                    break;
                }
            }
            if($breaked){
                break;
            }
        }
        $statusarray= [];
        $tablearray = [];

        foreach ($retData as $value){
            if(in_array($value[0],$statusarray)){
                $tablearray[$value[0]]['limit'] += 1;
            }else{
                $tablearray[$value[0]]['page'] = $value[1];
                $tablearray[$value[0]]['limit'] = 1;
                array_push($statusarray,$value[0]);
            }
        }

        return $tablearray;
    }

    /**
     * @return void 修改玩家备注
     */
    public function setRemark(){
        $uid = request()->post('uid');  //用户uid
        $des = request()->post('remark');  //用户备注
        Db::name('userinfo')->where('uid',$uid)->update(['des' => $des]);
        return json(['code' => 200,'msg' => '成功','data' => []]);
    }


    public function is_normal(){
        $uid = request()->post('uid');  //用户uid
        $status = request()->post('status');  //用户状态：注意这里0代表正常，1=不正常
        Db::name('userinfo')->where('uid',$uid)->update(['status' => $status]);
        $jsonstr = json_encode(['msg_id' => 2,'uid'=>(int)$uid,'update_int32' => (int)$status]);
        $userphpexec = [
            'type' => 100,
            'uid' => $uid,
            'jsonstr' => $jsonstr,
            'description' => $status == 0 ? $uid.'解封' : $uid.'封号',
        ];
        Db::name('exec_php')->insert($userphpexec);

        if($status){  //拉黑
            //加入封禁名单
            $list = [
                'uid' => $uid,
                'admin_id' => $this->adminId,
                'reason' => '',
                'createtime' => time(),
            ];
            Db::name('black_user')->insert($list);
        }else{
            Db::name('black_user')->where('uid',$uid)->delete();
        }
        return json(['code' => 200,'msg' => '成功','data' => []]);
    }

    /**
     * @return void 用户打码量记录
     */
    public function water($uid = 0){
        $this->assign('reason',Config::get('my.htdml'));
        $this->assign('uid', $uid);

        return $this->fetch();
    }


    /**
     * @return void 用户打码量记录
     */
    public function waterlist($uid)
    {
        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $data['date'] = isset($data['date']) ? $data['date'] : date('Y-m-d').' - '.date('Y-m-d');
        $tablename = 'water';
        $filed = "water,uid,coins,reason,give_score,operate,FROM_UNIXTIME(time_stamp,'%Y-%m-%d %H:%i:%s') as time_stamp";
        $orderfield = "time_stamp";
        $sort = "desc";
        if(isset($data['reason']) && $data['reason'] == -1){
            unset($data['reason']);
            $data['operate'] = 2;
        }
        $data = Model::Getdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,'time_stamp');


        if($data['data']){
            foreach ($data['data'] as &$v){

                $v['multiple'] = (($v['operate'] == 1) && $v['reason'] != 103) ? bcdiv($v['water'],bcadd($v['coins'],$v['give_score'],0),0) : 0;
                $v['coins'] = (($v['operate'] == 1) && $v['reason'] != 103) ? $v['coins']/100 : '';
                $v['water'] = '';
                if($v['reason'] == 103){
                    $v['water'] = bcdiv($v['water'],100,2);
                }elseif($v['coins'] > 0 && $v['give_score'] > 0){
                    $v['water'] = '('.$v['coins'] .'+'.$v['give_score']/100 .')*'.$v['multiple'];
                }elseif ($v['coins']){
                    $v['water'] = $v['coins'] .'*'.$v['multiple'];
                }elseif ($v['give_score'] > 0){
                    $v['water'] = $v['give_score']/100 .'*'.$v['multiple'];
                }
//                $v['multiple'] = bcdiv($v['water'],bcadd($v['coins'],$v['give_score'],0),0);
            }
        }
        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    private function getDayreallyCommission($uid){
        $wager_commission_bili = SystemConfig::getConfigValue('wager_commission_bili');  //返利比例
        $runwater_commission_bili = SystemConfig::getConfigValue('runwater_commission_bili');  //庄家优势
        $SQL = "SHOW TABLES LIKE 'lzmj_user_day_".date('Ymd')."'";
        if(!Db::query($SQL)){
            return 0;
        }else{
            $userday = Db::name('user_day_'.date('Ymd'))
                ->field('uid,bind_uid,total_water_score,total_outside_water_score')
                ->where([['bind_uid','=',$uid],['total_water_score','>',0]])
                ->whereOr(function ($query) use ($uid){
                    $query->where([['bind_uid','=',$uid],['total_outside_water_score','>',0]]);
                })
                ->select()
                ->toArray();

            if(!$userday){
                return 0;
            }else{
                $userinfo['dayreally_commission_allmoney'] = 0;
                foreach ($userday as $value){
                    //用户三方游戏流水返佣
                    $tripartite_all_rebate = bcmul(bcmul($wager_commission_bili,$value['total_outside_water_score'],0),$runwater_commission_bili,0);

                    //用户平台游戏流水返佣
                    $terrace_all_rebate = bcmul(bcmul($wager_commission_bili,$value['total_water_score'],0),$runwater_commission_bili,0);

                    $user_really_commission = bcadd($terrace_all_rebate,$tripartite_all_rebate,0);

                    $userinfo['dayreally_commission_allmoney'] = isset($userinfo['dayreally_commission_allmoney']) ? bcadd($userinfo['dayreally_commission_allmoney'],$user_really_commission,0) : $user_really_commission;

                }

                return $userinfo['dayreally_commission_allmoney'];
            }

        }
    }
}
