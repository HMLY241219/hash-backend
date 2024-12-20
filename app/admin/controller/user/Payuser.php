<?php

namespace app\admin\controller\user;

use app\admin\controller\AuthController;
use app\admin\controller\Model;
use app\admin\model\system\SystemConfig;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\api\controller\My;
use app\common\xsex\Common;
use think\facade\Session;

/**
 *  付费用户管理
 */
class Payuser extends AuthController
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

        /*$data['date'] = isset($data['date']) ? $data['date'] : date('Y-m-d',strtotime('00:00:00 -7day')).' - '.date('Y-m-d');
        if(isset($data['a_uid@like']) && $data['a_uid@like'])unset($data['date']);*/
        /*$emaileWhere = $this->getEmail($data); //邮箱状态
        $gamestatusWhere = $this->getGameStatus($data); //玩游戏状态
        $shouchongWhere = $this->getShouChong($data); //首充状态
        $isWithdrawWhere = $this->getWithdrawWhere($data);//是否提现*/
        $order = $this->getOrder($data);

        $table = 'user_day_'.date('Ymd');
        $shtable = "SHOW TABLES LIKE 'br_".$table."'";
        $res = Db::query($shtable);
        if(!$res){
            return json(['code' => 0, 'count' => 0, 'data' => []]);
        }

        $where  = Model::getWhere($data,'regist_time');
        //平台与渠道
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] != 0)$this->sqlwhere[] = ['a.channel', '>=', 100000000];
        }


        $data['data'] = Db::name('userinfo')
            ->alias('a')
            ->field("b.total_pay_score as daytotal_pay_score,b.total_give_score as daytotal_give_score,
            b.total_exchange as daytotal_exchange,b.total_exchange_num as daytotal_exchange_num,c.phone,c.device_id,
            (b.cash_total_score + b.bonus_total_score) as daytotal_score,b.total_game_num as daytotal_game_num,
            a.uid,a.vip,a.coin,a.first_pay_score,a.bonus,a.first_pay_time,a.first_withdraw_time,
            (a.now_cash_score_water + a.now_bonus_score_water) as now_score_water,(a.need_cash_score_water + a.need_bonus_score_water) as need_score_water,
            a.total_pay_score,a.total_give_score,c.status,d.reason,
            (a.cash_total_score + a.bonus_total_score) as total_score,
            a.total_exchange,a.total_exchange_num,(a.total_cash_water_score + a.total_bonus_water_score) as alltotal_water_score,
            a.total_game_num,a.total_game_day,a.ip,FROM_UNIXTIME(a.regist_time,'%Y-%m-%d %H:%i:%s') as regist_time,
            FROM_UNIXTIME(a.login_time,'%Y-%m-%d %H:%i:%s') as login_time,e.cname")
            ->leftJoin($table.' b','b.uid = a.uid')
            ->join('share_strlog c','c.uid = a.uid')
            ->leftJoin('black_user d','d.uid = a.uid')
            ->leftJoin('chanel e','e.channel = a.channel')
            ->where($where)
            ->where('a.total_pay_score', '>', 0)
            /*->where($emaileWhere)
            ->whereRaw($gamestatusWhere)
            ->where($shouchongWhere)
            ->where($isWithdrawWhere)*/
            ->where($this->sqlwhere)
            ->order($order)
            ->page($page,$limit)
            ->select()
            ->toArray();
//            $rr = Db::name('')->getLastSql();
//            dd($rr);

        $data['count'] = Db::name('userinfo')
            ->alias('a')
            ->leftJoin($table.' b','b.uid = a.uid')
            ->join('share_strlog c','c.uid = a.uid')
            ->where($where)
            ->where('a.total_pay_score', '>', 0)
            /*->where($emaileWhere)
            ->whereRaw($gamestatusWhere)
            ->where($shouchongWhere)
            ->where($isWithdrawWhere)*/
            ->where($this->sqlwhere)
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
                //总流水倍数
                $v['all_game_water_bs'] = $v['total_pay_score'] > 0 ? bcdiv($v['alltotal_water_score'],$v['total_pay_score'],2) : 0;

                //充提时间间隔
                $v['interval'] = '-';
                if ($v['first_withdraw_time'] > 0) {
                    $v['interval'] = $this->getInterval($v['first_pay_time'], $v['first_withdraw_time']);
                }
            }
        }
        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    public function getInterval($timestamp1=0, $timestamp2=0)
    {
        $diffInSeconds = abs($timestamp2 - $timestamp1);
        $hours = floor($diffInSeconds / 3600);
        $minutes = floor(($diffInSeconds % 3600) / 60);

        return $hours.'小时'.$minutes.'分钟';
    }


    public function view($uid = 0){

        $table = 'user_day_'.date('Ymd');
        $userinfo = Db::name('userinfo')
            ->alias('a')
            ->field("b.total_pay_score as daytotal_pay_score,b.total_give_score as daytotal_give_score,
            b.total_exchange as daytotal_exchange,(b.cash_total_score + b.bonus_total_score)  as daytotal_score,
            a.uid,a.vip,d.nickname,d.status,a.coin,a.first_pay_score,d.af_status,a.withdraw_money,a.ip,
            a.total_pay_score,a.total_give_score,(a.cash_total_score + a.bonus_total_score) as total_score,
            a.total_exchange,(a.total_cash_water_score + a.total_bonus_water_score) as alltotal_water_score,
            FROM_UNIXTIME(a.regist_time,'%Y-%m-%d %H:%i:%s') as regist_time,FROM_UNIXTIME(a.login_time,'%Y-%m-%d %H:%i:%s') as login_time,
            des,d.phone,d.appname,d.channel,c.puid,d.login_ip,a.bonus,a.get_bonus,d.last_pay_price,d.city")
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
        $sharApp = ['com.win3377.sharewin'];
//        if($userinfo['af_status'] == 1){
//            $userinfo['cname'] = Db::name('chanel')->where('cid',$userinfo['channel'])->value('cname');
//        }elseif (in_array($userinfo['appname'],$sharApp) && $userinfo['puid'] > 0){
//            $userinfo['cname'] = '分享量';
//        }elseif(in_array($userinfo['appname'],$sharApp) && $userinfo['puid'] <= 0){
//            $userinfo['cname'] = '未知量';
//        }else{
//            $userinfo['cname'] = '自然量';
//        }
        $sharChanel = [350020];
        if($userinfo['af_status'] == 1){
            $userinfo['cname'] = Db::name('chanel')->where('cid',$userinfo['channel'])->value('cname');
        }elseif (in_array($userinfo['appname'],$sharApp)){
            $userinfo['cname'] = '分享量';
        }elseif (in_array($userinfo['channel'],$sharChanel)){
            $userinfo['cname'] = Db::name('chanel')->where('cid',$userinfo['channel'])->value('cname');
        }else{
            $userinfo['cname'] = '自然量';
        }


        //总流水倍数
        $userinfo['poor_coding_volume']  = ($userinfo['total_pay_score'] + $userinfo['total_give_score']) > 0
            ? bcdiv($userinfo['alltotal_water_score'],bcadd($userinfo['total_give_score'],$userinfo['total_pay_score'],0),2)
            : '0';



        //用户今日获取的tpc
        $userinfo['day_bonus'] = Db::name('bonus_'.date('Ymd'))->where([['uid','=',$uid],['type','=',1]])->sum('num');




        $userinfo['appname'] .= in_array($userinfo['appname'],$sharApp) ? '-分享包' : '-Google包';
        //总提现比例
        $userinfo['total_bili'] = $userinfo['total_pay_score'] > 0 ? bcdiv($userinfo['total_exchange'],$userinfo['total_pay_score'],2) : bcdiv($userinfo['total_exchange'],10000,2);
        //今日提现比例
        $userinfo['day_total_bili'] = $userinfo['daytotal_pay_score'] > 0 ? bcdiv($userinfo['daytotal_exchange'],$userinfo['daytotal_pay_score'],2) : bcdiv($userinfo['daytotal_exchange'],10000,2);
        //未玩游戏天数
        $userinfo['not_play_game_day'] = bcdiv((time() - strtotime($userinfo['login_time'])),86400,0);


        $user_team = Db::name('user_team')->field('createtime')->where('puid',$uid)->select()->toArray();


        $userinfo['address'] = $userinfo['city'];

        //正式服
//        $userinfo['loginAddress'] = $userinfo['login_ip'] ? \customlibrary\Common::get_ip_addr($userinfo['login_ip']) : '';
        //测试服
        $userinfo['loginAddress'] = '';



        //推广人数
        $userinfo['charcount'] = count($user_team);


        $userinfo['bonus_to'] = $userinfo['get_bonus'] - $userinfo['bonus'];



        //银行卡信息
        $user_withinfo_bank = Db::name('user_withinfo')->field('backname,account,ifsccode')->where(['uid' => $uid,'type' => 1])->find();
        $userinfo['backname'] = $user_withinfo_bank['backname'] ?? '';
        $userinfo['ifsccode'] = $user_withinfo_bank['ifsccode'] ?? '';
        $userinfo['account'] = $user_withinfo_bank['account'] ?? '';




        $glUidArray = \app\api\controller\My::glUid($uid);
        $userinfo['glUserCount'] = count($glUidArray);


        $this->assign('userInfo',$userinfo);
        return $this->fetch();
    }


    /**
     * echarts数据
     * @return void
     */
    public function echartsdata($uid = 0,$date = ''){


        $endtime = date('Y-m-d');  //开始时间
        $starttime =  date('Y-m-d',strtotime(date('Y-m-d') . ' -30 day')); //30天时间
        if($date) [$starttime,] = explode(' - ',$date);


        $data['date'] = \customlibrary\Common::createDateRange($starttime,$endtime,'Y-m-d');
        $data['total_score'] = [];  //每日总输赢
        $data['total_pay_score'] = []; //每日总充值
        $data['total_exchange'] = [];   //每日总提现
        $data['total_give_score'] = [];   //每日总赠送
        $data['total_water_score'] = [];   //每日总流水
        foreach ($data['date'] as $v){
            $time = str_replace('-','',$v);
            $table = 'user_day_'.$time;
            $sql = "SHOW TABLES LIKE 'br_".$table."'";
            $res = Db::query($sql);
            if(!$res){
                $data['total_score'][] = 0;
                $data['total_pay_score'][] = 0;
                $data['total_exchange'][] = 0;
                $data['total_give_score'][] = 0;
                $data['total_water_score'][] = 0;
                continue;
            }
            $userday = Db::name($table)->field('(cash_total_score + bonus_total_score) as total_score,total_pay_score,total_exchange,total_give_score,(total_cash_water_score + total_bonus_water_score) as total_water_score')->where('uid',$uid)->find();
            if(!$userday){
                $data['total_score'][] = 0;
                $data['total_pay_score'][] = 0;
                $data['total_exchange'][] = 0;
                $data['total_give_score'][] = 0;
                $data['total_water_score'][] = 0;
                continue;
            }
            $data['total_score'][] = bcdiv($userday['total_score'],100,2);
            $data['total_pay_score'][] = bcdiv($userday['total_pay_score'],100,2);
            $data['total_exchange'][] = bcdiv($userday['total_exchange'],100,2);
            $data['total_give_score'][] = bcdiv($userday['total_give_score'],100,2);
            $data['total_water_score'][] = bcdiv($userday['total_water_score'],100,2);



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

        $filed = "game_type,game_id,bet_score,total_score,service_score,time_stamp,final_score,table_level";
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

        $filed = "id,uid,game_type,CAST(game_id AS CHAR(30)) AS game_id,bet_score,total_score,service_score,time_stamp,final_score,table_level,control_win_or_loser";
        $date = isset($data['datetable']) && $data['datetable']? $data['datetable'] : date('Y-m-d',strtotime('-7 day')).' - '.date('Y-m-d');


        [$start,$end] = explode(' - ',$date);

        $datearray = \customlibrary\Common::createDateRange($start,$end,'Ymd');
        $dateList = array_reverse($datearray);

        [$count,$dataList] = Model::SubTablequery($dateList,'lzmj_game_records_',$filed,$where,'time_stamp','desc',$page,$limit);

        $xZhou = [];
        foreach ($dataList as $xz){
            $xZhou[] = config('game.gamename')[$xz['game_type']] ?? '';
        }

        return json(['code' => 0, 'count' => $count, 'data' => $dataList,'xZhou' => $xZhou]);
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
        $status = request()->post('status');  //用户状态：注意这里1代表正常，0=不正常
        Db::name('share_strlog')->where('uid',$uid)->update(['status' => $status]);

        $getUidinformation = My::getUidinformation($uid);
        if($getUidinformation['code'] != 200){
            return json(['code' => 201,'msg' => '获取用户手机等信息','data' => []]);
        }




        if(!$status){  //拉黑
            //加入封禁名单
            $list = [
                'uid' => $uid,
                'admin_id' => $this->adminId,
                'reason' => '后台管理员封禁'.$this->adminId,
                'createtime' => time(),
            ];
            Db::name('black_user')->replace()->insert($list);

            if($getUidinformation['data']){
                foreach ($getUidinformation['data'] as $k => $v){
                    Db::name('black_'.$k)->replace()->insert([$k => $v]);
                }
            }

            Common::blockGlUser($uid);
        }else{
            Db::name('black_user')->where('uid',$uid)->delete();
            if($getUidinformation['data']){
                foreach ($getUidinformation['data'] as $k => $v){
                    Db::name('black_'.$k)->where([$k => $v])->delete();
                }
            }
        }






        return json(['code' => 200,'msg' => '成功','data' => []]);
    }

    /**
     * @return void 是否免费参加转盘
     */
    public function is_free_rotary(){
        $uid = request()->post('uid');  //用户uid
        $is_free_rotary = request()->post('is_free_rotary');  //用户状态：注意这里1代表允许直接参加，0=不允许直接参加
        if($is_free_rotary == 1){
            Db::name('share_strlog')->where('uid',$uid)->update([
                'rotary_sd_num'  => Db::raw('rotary_sd_num + 1')
            ]);

            //
            $limitarray = [
                'type' => 100,
                'uid' => $uid,
                'jsonstr' => json_encode(["msg_id" => 16,"uid"=>(int)$uid,"num"=>3,"type" => 8]),
                "description"=>"手动转盘赠送"
            ];
            Db::name('exec_php')->insert($limitarray);
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
                $water = $v['water'];
                $v['multiple'] = (($v['operate'] == 1) && $v['reason'] != 103) ? bcdiv($water,bcadd($v['coins'],$v['give_score'],0),0) : 0;
                $v['coins'] = (($v['operate'] == 1) && $v['reason'] != 103) ? $v['coins']/100 : '';
                $v['water'] = '';
                if($v['reason'] == 103){
                    $v['water'] = bcdiv($water,100,2);
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


    public function bonus($uid){
        $this->assign('uid', $uid);

        return $this->fetch();
    }


    public function bonus_list(){
        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $filed = "uid,reason,num,FROM_UNIXTIME(createtime,'%Y-%m-%d %H:%i:%s') as createtime";
        $date = isset($data['datetable']) && $data['datetable']? $data['datetable'] : date('Y-m-d',strtotime('-7 day')).' - '.date('Y-m-d');
        $where = [['uid' ,'=', $data['uid']],['type','=',1]];
        [$start,$end] = explode(' - ',$date);

        $datearray = \customlibrary\Common::createDateRange($start,$end,'Ymd');
        $datearray = array_reverse($datearray);

        [$count,$dataList] = Model::SubTablequery($datearray,'br_bonus_',$filed,$where,'createtime','desc',$page,$limit);



        return json(['code' => 0, 'count' => $count, 'data' => $dataList]);
    }


    public function glUid($uid){
        $this->assign('uid', $uid);

        return $this->fetch();
    }


    public function glUidList($uid){

        $glUidArray = \app\api\controller\My::glUid($uid);

        $page = input('page') ?: 1;
        $limit =  input('limit') ?: 200;
        $filed = "uid,total_pay_score,total_exchange,(cash_total_score + bonus_total_score) as total_score ,FROM_UNIXTIME(regist_time,'%Y-%m-%d %H:%i:%s') as regist_time";

        $orderfield = "uid";
        $sort = "desc";

        $array = Model::Getdata('userinfo',$filed,[],$orderfield,$sort,$page,$limit,'createtime',[['uid','in',$glUidArray]]);
        $list = $array['data'];
        foreach ($list as &$v){
            $v['total_bili'] =  $v['total_pay_score'] > 0 ? bcdiv($v['total_exchange'],$v['total_pay_score'],2) : bcdiv($v['total_exchange'],10000,2);
        }

        return json(['code' => 0, 'count' => $array['count'], 'data' => $list]);
    }


    public function tgUid($uid){
        $this->assign('uid', $uid);

        return $this->fetch();
    }


    public function tgUidList(){

        $data =  request()->param();

        $page = input('page') ?: 1;
        $limit =  input('limit') ?: 200;
        $filed = "b.uid,b.total_pay_score,b.total_exchange,(b.cash_total_score + b.bonus_total_score) as total_score,FROM_UNIXTIME(a.createtime,'%Y-%m-%d %H:%i:%s') as createtime";
        $join = ['userinfo b','a.uid = b.uid'];
        $orderfield = "b.uid";
        $sort = "desc";
        $date = 'a.createtime';
        $array = Model::joinGetdata('user_team',$filed,$data,$orderfield,$sort,$page,$limit,$join,'a',$date,'inner',$this->sqlwhere);

        $list = $array['data'];
        foreach ($list as &$v){
            $v['total_bili'] =  $v['total_pay_score'] > 0 ? bcdiv($v['total_exchange'],$v['total_pay_score'],2) : bcdiv($v['total_exchange'],10000,2);
        }

        return json(['code' => 0, 'count' => $array['count'], 'data' => $list,'puid' => $data['a_puid']]);
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


    private function getEmail(&$data){
        $email = '';
        if(isset($data['email'])){
            $email = $data['email'];
            unset($data['email']);
        }
        $emaileWhere = [];
        if($email == 1){  //绑定邮箱的用户
            $emaileWhere = [['c.email' ,'>', '0']];
        }elseif ($email == 2){//未绑定邮箱的用户
            $emaileWhere = ['c.email' => null];
        }
        return $emaileWhere;
    }


    private function getGameStatus(&$data){
        $gamestatus = '';
        if(isset($data['gamestatus2']) && $data['gamestatus2']){
            $gamestatus = $data['gamestatus2'];
            unset($data['gamestatus2']);
            if(isset($data['gamestatus1'])) unset($data['gamestatus1']);

        }elseif (isset($data['gamestatus1']) && $data['gamestatus1']){
            $gamestatus = $data['gamestatus1'];
            unset($data['gamestatus1']);
            if(isset($data['gamestatus2'])) unset($data['gamestatus2']);

        }else{
            if(isset($data['gamestatus2'])){
                unset($data['gamestatus2']);
            }
            if(isset($data['gamestatus1'])){
                unset($data['gamestatus1']);
            }
        }

        $gamestatusWhere  = 'c.isgold = 0';
        if($gamestatus == 1){  //玩游戏玩家
            $gamestatusWhere = 'c.isgold = 0 AND  a.total_game_num > 0';
        }elseif ($gamestatus == 2){//未玩游戏玩家
            $gamestatusWhere = 'c.isgold = 0 AND  a.total_game_num <= 0';
        }elseif ($gamestatus == 3){//今日玩游戏玩家
            $gamestatusWhere = 'c.isgold = 0 AND  b.total_game_num > 0';
        }elseif ($gamestatus == 4){//今日未玩游戏玩家
            $gamestatusWhere = 'c.isgold = 0 AND  b.total_game_num <= 0';
        }
        return $gamestatusWhere;
    }


    private function getShouChong(&$data){
        $shouchong = '';
        if(isset($data['shouchong'])){
            $shouchong = $data['shouchong'];
            unset($data['shouchong']);
        }
        $shouchongWhere = [];
        if($shouchong == 1){  //首冲玩家
            $shouchongWhere = [['a.first_pay_score' ,'>', 0]];
        }elseif ($shouchong == 2){//未首冲玩家
            $shouchongWhere = ['a.first_pay_score' => 0];
        }
        return $shouchongWhere;
    }

    private function getWithdrawWhere(&$data){
        $is_withdraw = '';
        $isWithdrawWhere = [];
        if (isset($data['is_withdraw'])){
            $is_withdraw = $data['is_withdraw'];
            unset($data['is_withdraw']);
        }
        if ($is_withdraw == 1){
            $isWithdrawWhere = [['a.total_exchange', '>', 0]];
        }elseif ($is_withdraw == 2){
            $isWithdrawWhere = ['a.total_exchange' => 0];
        }
        return $isWithdrawWhere;
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

    private function getUserRotaryLog($uid){
        $rotaryLog1 = Db::name('rotarylog')
            ->field("num,type")
            ->where('uid','=',$uid)
            ->order('createtime','desc')
            ->select()
            ->toArray();//之前的参与次数

        //今日的参与次数
        $rotaryLog2 = \app\api\controller\My::getRotarylog(strtotime('00:00:00'),date('Ymd'),2,[['uid','=',$uid]]);
        $rotaryLog = array_merge($rotaryLog1,$rotaryLog2);
        $count = count($rotaryLog);
        $tpc = 0;
        $coin = 0;
        if($count){
            foreach ($rotaryLog as $rotary){
                if($rotary['type'] == 2){
                    $coin = bcadd($coin,bcdiv($rotary['num'],100,0),0);
                }else{
                    $tpc = bcadd($tpc,bcdiv($rotary['num'],100,0),0);
                }
            }
        }

        return $coin.'/'.$tpc.'/'.$count;

    }

    /**
     * 获取不同活动玩家参与的次数
     * @param $uid 用户uid
     * @return int[]
     */
    private static function getUserActiveNum($uid){
        $type = [10 => 'first_active_num',6 => 'bankruptcy_active_num',7 => 'loss_active_num'];
        $active_log = Db::name('active_log')
            ->where([['uid','=', $uid],['type','in',[6,7,10]]])
            ->group('type')
            ->column('count(*) as num','type');

        if(!$active_log){
            return [0,0,0];
        }
        $first_active_num = 0;  // 首充活动
        $bankruptcy_active_num = 0;  // 破产活动
        $loss_active_num = 0;  // 客损活动
        foreach ($active_log as $k => $v){
            $key = $type[$k];
            $$key = $v;
        }
        return [$first_active_num,$bankruptcy_active_num,$loss_active_num];
    }

    private $tag_type = [
        1 => '停止自动提现',
        //2 => '测试',
    ];

    public function setUser($id){
        $tag[0]['label'] = '停止自动提现';
        $tag[0]['value'] = 1;
        /*$tag[1]['label'] = '测试';
        $tag[1]['value'] = 2;*/

        $r = Db::name("share_strlog")->where('uid',$id)->find();
        if(!$r){
            Json::fail('参数错误!');
        }
        $tag_arr = [];
        //$old_tag = [];
        if (!empty($r['tag'])){
            $tag_arr = explode(",",$r['tag']);
            /*foreach ($tag_arr as $key=>$value){
                $old_tag[$key]['label'] = $this->tag_type[$value];
                $old_tag[$key]['value'] = $value;
            }*/
        }
        //dd($old_tag);
        $f = array();
        $f[] = Form::selectMultiple('tag', '标签',$tag_arr)->options($tag);

        $form = Form::make_post_form('修改数据', $f, url('saveUser',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function saveUser($id=0){
        $data = request()->post();
        if (!empty($data['tag'])) {
            $data['tag'] = implode(",",$data['tag']);
        }else{
            $data['tag'] = '';
        }

        $data['updatetime'] = time();
        if($id > 0){
            $res = Db::name('share_strlog')->where('uid',$id)->update($data);
        }else{
            //$res = Db::name($this->tablename)->insert($data);
        }
        if(!$res){
            Json::fail('添加失败');
        }
        return Json::successful($id > 0 ? '修改成功!' : '添加成功!');
    }


    public function orderWithdraw($uid){
        $this->assign('uid',$uid);
        return $this->fetch();
    }

    public function orderWithdrawIndex($uid){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 200;
        $order = Db::name('order')->field("FROM_UNIXTIME(finishtime,'%Y-%m-%d %H:%i:%s') as finishtime,price as money,1 as type,zs_bonus,zs_money,active_id")->where([['uid','=',$uid],['pay_status','=',1]])->select()->toArray();
        $withdraw_log = Db::name('withdraw_log')->field("FROM_UNIXTIME(finishtime,'%Y-%m-%d %H:%i:%s') as finishtime,really_money as money,2 as type,0 as zs_bonus,0 as zs_money,0 as active_id")->where([['uid','=',$uid],['status','=',1]])->select()->toArray();
        $list = array_merge($order,$withdraw_log);
        if(!$list){
            return json(['code' => 0, 'count' => 0, 'data' => []]);
        }
        $distance = array_column($list,'finishtime');
        array_multisort($list,SORT_DESC,$distance);

        $newList = $this->getData($page,$limit,$list);


        return json(['code' => 0, 'count' => count($list), 'data' => $newList]);
    }


    public function markingShop(){
        $uid = input('uid');
        $type = input('type');
        if(!$uid || !$type)   Json::fail('参数获取失败');
        if($type == 6){
            $filed = 'bankruptcynum';
        }elseif ($type == 7){
            $filed = 'lossnum';
        }else{
            Json::fail('暂无赠送类型');
        }
        $res = Db::name('user_point_control')->where('uid',$uid)->update([
            $filed => Db::raw("$filed + 1")
        ]);
        if(!$res){
            Db::name('user_point_control')->replace()->insert([
                'uid' => $uid,
                $filed => 1
            ]);
        }
        Db::name('share_strlog')->where('uid',$uid)->update([
            'shop_type' => $type
        ]);
        Json::successful('成功');
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


    private function activeNumMoney($uid){

        $active_log = Db::name('active_log')->field('type,money')->where([['uid','=',$uid],['type','in','6,7,10']])->select()->toArray();
        if(!$active_log)return['0/0','0/0','0/0'];
        $firstActive = [
            'num' => 0,
            'money' => 0,
        ];
        $lossActive = [
            'num' => 0,
            'money' => 0,
        ];
        $backActive = [
            'num' => 0,
            'money' => 0,
        ];
        foreach ($active_log as $v){
            if($v['type'] == 6){
                $backActive['num'] = $backActive['num'] + 1;
                $backActive['money'] = $backActive['money'] + $v['money'];
            }elseif ($v['type'] == 7){
                $lossActive['num'] = $lossActive['num'] + 1;
                $lossActive['money'] = $lossActive['money'] + $v['money'];
            }else{
                $firstActive['num'] = $firstActive['num'] + 1;
                $firstActive['money'] = $firstActive['money'] + $v['money'];
            }
        }
        return[bcdiv($firstActive['money'],100,2).'/'.$firstActive['num'],bcdiv($lossActive['money'],100,2).'/'.$lossActive['num'],bcdiv($backActive['money'],100,2).'/'.$backActive['num']];
    }

    /**
     * @return void
     * 设置代理
     */
    public function agent(){
        $uid = input('uid');
        $bili = input('bili') ?: 0.7;
        $agent = Db::name('agent')->field('uid')->where(['uid' => $uid])->find();

        if($agent) return  Json::fail('该用户已经是代理了，无需重复设置',[]);


        $share_strlog = Db::name('share_strlog')
            ->alias('a')
            ->leftJoin('userinfo b','a.uid=b.uid')
            ->field('a.phone,a.package_id,a.channel,a.appname,b.nick_name')->where('a.uid',$uid)->find();

        Db::startTrans();
        // 修改代理状态
        $res = Db::name('share_strlog')->where('uid',$uid)->update(['agent' => 1,'is_agent_user' => 1]);
        if(!$res){
            Db::rollback();
            return  Json::fail('代理状态修改失败',[]);
        }

        //添加代理
        $res = Db::name('agent')->insert([
            'uid' => $uid,
            'password' => md5(888888),
            'phone' => $share_strlog['phone'],
            'bili' => $bili,
            'createtime' => time(),
            'package_id' => $share_strlog['package_id'],
            'channel' => $share_strlog['channel'],
            'packname' => $share_strlog['appname'],
            'nickname' => $share_strlog['nick_name'],
        ]);
        if(!$res){
            Db::rollback();
            return  Json::fail('代理添加失败',[]);
        }

        //添加团队数据
        $res = Db::name('agent_teamlevel')->insert([
            'uid' => $uid,
            'puid' => $uid,
            'bili' => $bili,
            'createtime' => time()
        ]);
        if(!$res){
            Db::rollback();
            return  Json::fail('团队数据失败',[]);
        }
        Db::commit();
        return Json::successful('成功',[]);
    }
}

