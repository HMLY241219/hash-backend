<?php
namespace app\api\controller;

use app\admin\controller\Common;
use app\api\controller\ReturnJson;
use app\Request;
use think\facade\Config;
use think\facade\Db;
use think\facade\Log;
use crmeb\basic\BaseController;
use curl\Curl;
use think\facade\Validate;

class Userts extends BaseController {

    /**
     * 每日投注排行榜统计 1小时
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function dayTopBet()
    {
        $day = date('Ymd');
        $time = strtotime('00:00:00');
        $user_day = Db::name('user_day_'.$day)->field('uid,total_cash_water_score')->order('total_cash_water_score','desc')->limit(100)->select()->toArray();

        $data = [];
        if (!empty($user_day)) {
            foreach ($user_day as $k => $v) {
                $data[] = [
                    'time' => $time,
                    'uid' => $v['uid'],
                    'bet' => $v['total_cash_water_score'],
                    'user_type' => 0
                ];
            }
        }

        $ai_top = Db::name('bet_top')->where(['time'=>$time,'user_type'=>1,'type'=>0])->column('uid');
        $ai_bet = Config::get('active.top');
        if (empty($ai_top)){
            $bet = 0;
            for ($i = 0; $i < 100; $i++) {
                if ($i == 0) {
                    $bet = mt_rand($ai_bet['day_ai_bet'][0][0], $ai_bet['day_ai_bet'][0][1]);
                }elseif ($i == 1 || $i == 2){
                    $bet = mt_rand($ai_bet['day_ai_bet'][1][0], $ai_bet['day_ai_bet'][1][1]);
                }elseif ($i == 3){
                    $bet = mt_rand($ai_bet['day_ai_bet'][2][0], $ai_bet['day_ai_bet'][2][1]);
                }elseif ($i >= 4 && $i <= 49){
                    $bet = mt_rand($ai_bet['day_ai_bet'][3][0], $ai_bet['day_ai_bet'][3][1]);
                }else{
                    $bet = mt_rand($ai_bet['day_ai_bet'][4][0], $ai_bet['day_ai_bet'][4][1]);
                }

                $data[] = [
                    'time' => $time,
                    'uid' => mt_rand(20050050,99999999),
                    'bet' => $bet,
                    'user_type' => 1
                ];
            }
        }

        try {
            Db::startTrans();
            if (!empty($data)){
                Db::name('bet_top')->where('time',$time)->where('user_type',0)->where('type',0)->delete();

                $res = Db::name('bet_top')->insertAll($data);
                if (!$res){
                    Db::rollback();
                    Log::error('dayTopBet fail==>插入失败');
                    return json(['code' => 200,'msg'=>'统计失败','data' => []]);
                }
            }

            if (!empty($ai_top)){
                $inc_bet = mt_rand($ai_bet['day_ai_inc'][0],$ai_bet['day_ai_inc'][1]);

                $ai_tree = Db::name('bet_top')->where(['time'=>$time,'user_type'=>1,'type'=>0])->order('bet','desc')->limit(3)->select()->toArray();
                $user_tree = array_slice($user_day, 0, 3);
                foreach ($ai_tree as $ak => $av) {
                    foreach ($user_tree as $ut => $uv) {
                        if ($av['bet'] + $inc_bet <= $uv['total_cash_water_score']){
                            //$tmp_bet = $inc_bet + 200000000;
                            Db::name('bet_top')->where('id',$av['id'])->inc('bet',210000000)->update();
                            break;
                        }
                    }
                }

                Db::name('bet_top')->where(['time'=>$time,'user_type'=>1,'type'=>0])->whereIn('uid',$ai_top)->inc('bet',$inc_bet)->update();
            }

            Db::commit();
            return json(['code' => 200,'msg'=>'每日排行统计完成','data' => []]);

        }catch (\Exception $exception){
            Db::rollback();
            echo $exception->getMessage();
            Log::error('dayTopBet fail==>'.$exception->getMessage());
            return json(['code' => 201,'msg'=>'每日排行统计失败','data' => []]);
        }
    }

    /**
     * 每天十二点执行，发放前一天排行奖励
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     *
     */
    public function dayTopGive()
    {
        $day = date('Ymd');
        $time = strtotime('00:00:00') - 86400;
        $user_top = Db::name('bet_top')->where(['time'=>$time,'type'=>0])->order('bet','desc')->limit(100)->select()->toArray();
        $top_config = Db::name('top_config')->where('type',0)->select()->toArray();
        if (empty($top_config)){
            Log::error('每日排行发放配置不存在');
            return json(['code' => 201,'msg'=>'每日排行发放配置不存在','data' => []]);
        }

        if (!empty($user_top)) {
            foreach ($user_top as $k => $v) {
                if ($v['user_type'] == 0){
                    $cash = 0;
                    $bonus = 0;
                    foreach ($top_config as $k1 => $v1) {
                        $tmp = explode(',',$v1['rank']);
                        $tmp[1] = isset($tmp[1]) ? $tmp[1] : $tmp[0];
                        if ($k + 1 >= $tmp[0] && $k + 1 <= $tmp[1]) {
                            $cash = $v1['cash'];
                            $bonus = $v1['bonus'];
                            break;
                        }
                    }
                    if ($cash==0 && $bonus==0){
                        $cash = $v1['cash'];
                        $bonus = $v1['bonus'];
                    }

                    //修改奖励
                    Db::name('bet_top')->where('id',$v['id'])->update(['get_cash'=>$cash,'get_bonus'=>$bonus]);
                }
            }

            return json(['code' => 200,'msg'=>'每日排行发放成功','data' => []]);
        }else{
            return json(['code' => 200,'msg'=>'无发放','data' => []]);
        }

    }

    /**
     * 每周奖励发放
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function weekTopGive()
    {
        $day = date('Ymd');
        $time = strtotime('last monday', strtotime('tomorrow')) - 604800;
        $user_top = Db::name('bet_top')->where(['time'=>$time,'type'=>1])->order('bet','desc')->limit(100)->select()->toArray();
        $top_config = Db::name('top_config')->where('type',1)->select()->toArray();
        if (empty($top_config)){
            Log::error('每日排行发放配置不存在');
            return json(['code' => 201,'msg'=>'每日排行发放配置不存在','data' => []]);
        }

        if (!empty($user_top)) {
            foreach ($user_top as $k => $v) {
                if ($v['user_type'] == 0){
                    $cash = 0;
                    $bonus = 0;
                    foreach ($top_config as $k1 => $v1) {
                        $tmp = explode(',',$v1['rank']);
                        $tmp[1] = isset($tmp[1]) ? $tmp[1] : $tmp[0];
                        if ($k + 1 >= $tmp[0] && $k + 1 <= $tmp[1]) {
                            $cash = $v1['cash'];
                            $bonus = $v1['bonus'];
                            break;
                        }
                    }
                    if ($cash==0 && $bonus==0){
                        $cash = $v1['cash'];
                        $bonus = $v1['bonus'];
                    }

                    //修改奖励
                    Db::name('bet_top')->where('id',$v['id'])->update(['get_cash'=>$cash,'get_bonus'=>$bonus]);
                }
            }

            return json(['code' => 200,'msg'=>'每周排行发放成功','data' => []]);
        }else{
            return json(['code' => 200,'msg'=>'每周无发放','data' => []]);
        }

    }


    /**
     * 每日凌晨统计前一天周下级投注排行
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function weekTopBet()
    {
        $day = date('Ymd', strtotime("-1 day"));
//        $day = date('Ymd');
        $time = strtotime('00:00:00') - 84600;
        $time_week = strtotime('last monday', strtotime('tomorrow'));

        $user_day = Db::name('user_day_'.$day)
            ->field('uid,puid,total_cash_water_score')
            ->where('puid','>',0)
            ->order('total_cash_water_score','desc')->select()->toArray();

        $top_list = Db::name('bet_top')
            ->where(['time'=>$time_week,'user_type'=>0,'type'=>1])
            ->select()->toArray();

//dd();
        $data = [];
        if (!empty($user_day)){
            if (empty($top_list)) {
                foreach ($user_day as $udk => $udv) {
                    if ($udv['total_cash_water_score'] >= 200000) {
                        if (isset($data[$udv['puid']])) {
                            $data[$udv['puid']]['bet'] += $udv['total_cash_water_score'];
                            $data[$udv['puid']]['users'] .= ','.$udv['uid'];
                        } else {
                            $data[$udv['puid']]['time'] = $time_week;
                            $data[$udv['puid']]['uid'] = $udv['puid'];
                            $data[$udv['puid']]['bet'] = $udv['total_cash_water_score'];
                            $data[$udv['puid']]['user_type'] = 0;
                            $data[$udv['puid']]['type'] = 1;
                            $data[$udv['puid']]['users'] = $udv['uid'];
                        }
                    }
                }

            }else{
                $old_puids = array_column($top_list,'uid');
                foreach ($user_day as $udk => $udv) {
                    foreach ($top_list as $tlk => $tlv) {
                        if ($udv['puid'] == $tlv['uid']) {//已在榜上
                            $user_arr = explode(',',$tlv['users']);
                            if (in_array($udv['uid'], $user_arr)) {//下级已到达过2000下注 或 这次到达
                                if (isset($data[$udv['puid']])) {
                                    $data[$udv['puid']]['bet'] += $udv['total_cash_water_score'];
                                    //$data[$udv['puid']]['users'] .= ',' . $udv['uid'];
                                } else {
                                    $data[$udv['puid']]['time'] = $time_week;
                                    $data[$udv['puid']]['uid'] = $udv['puid'];
                                    $data[$udv['puid']]['bet'] = $tlv['bet'] + $udv['total_cash_water_score'];
                                    $data[$udv['puid']]['user_type'] = 0;
                                    $data[$udv['puid']]['type'] = 1;
                                    $data[$udv['puid']]['users'] = $tlv['users'];// . ',' . $udv['uid'];
                                }
                                break;
                            }elseif ($udv['total_cash_water_score'] >= 200000){
                                if (isset($data[$udv['puid']])) {
                                    $data[$udv['puid']]['bet'] += $udv['total_cash_water_score'];
                                    $data[$udv['puid']]['users'] .= ',' . $udv['uid'];
                                } else {
                                    $data[$udv['puid']]['time'] = $time_week;
                                    $data[$udv['puid']]['uid'] = $udv['puid'];
                                    $data[$udv['puid']]['bet'] = $tlv['bet'] + $udv['total_cash_water_score'];
                                    $data[$udv['puid']]['user_type'] = 0;
                                    $data[$udv['puid']]['type'] = 1;
                                    $data[$udv['puid']]['users'] = $tlv['users'] . ',' . $udv['uid'];
                                }
                                break;
                            }

                        }elseif ($udv['total_cash_water_score'] >= 200000 && !in_array($udv['puid'], $old_puids)){//不在榜上
                            //if ($udv['total_cash_water_score'] >= 200000) {
                                if (isset($data[$udv['puid']])) {
                                    $data[$udv['puid']]['bet'] += $udv['total_cash_water_score'];
                                    $data[$udv['puid']]['users'] .= ','.$udv['uid'];
                                }else{
                                    $data[$udv['puid']]['time'] = $time_week;
                                    $data[$udv['puid']]['uid'] = $udv['puid'];
                                    $data[$udv['puid']]['bet'] = $udv['total_cash_water_score'];
                                    $data[$udv['puid']]['user_type'] = 0;
                                    $data[$udv['puid']]['type'] = 1;
                                    $data[$udv['puid']]['users'] = $udv['uid'];
                                }
                                break;
                            //}
                        }

                    }
                    //dd($data);
                }
            }
        }

        $bet_sort = array_column($data,'bet');
        array_multisort($bet_sort,SORT_DESC,$data);
        $data = array_slice($data, 0, 100);

        $ai_top = Db::name('bet_top')->where(['time'=>$time_week,'user_type'=>1,'type'=>1])->column('uid');
        $ai_bet = Config::get('active.top');
        if (empty($ai_top)) {
            $bet = 0;
            for ($i = 0; $i < 100; $i++) {
                if ($i == 0) {
                    $bet = mt_rand($ai_bet['week_ai_bet'][0][0], $ai_bet['week_ai_bet'][0][1]);
                }elseif ($i == 1 || $i == 2){
                    $bet = mt_rand($ai_bet['week_ai_bet'][1][0], $ai_bet['week_ai_bet'][1][1]);
                }elseif ($i >= 3 && $i <= 9){
                    $bet = mt_rand($ai_bet['week_ai_bet'][2][0], $ai_bet['week_ai_bet'][2][1]);
                }elseif ($i >= 10 && $i <= 49){
                    $bet = mt_rand($ai_bet['week_ai_bet'][3][0], $ai_bet['week_ai_bet'][3][1]);
                }else{
                    $bet = mt_rand($ai_bet['week_ai_bet'][4][0], $ai_bet['week_ai_bet'][4][1]);
                }

                $data[] = [
                    'time' => $time_week,
                    'uid' => mt_rand(20050050,99999999),
                    'bet' => $bet,
                    'user_type' => 1,
                    'type' => 1,
                    'users' => '',
                ];
            }
        }

        try {
            Db::startTrans();
            if (!empty($data)){
                Db::name('bet_top')->where('time',$time_week)->where('user_type',0)->where('type',1)->delete();

                $res = Db::name('bet_top')->insertAll($data);
                if (!$res){
                    Db::rollback();
                    Log::error('weekTopBet fail==>插入失败');
                    return json(['code' => 200,'msg'=>'统计失败','data' => []]);
                }
            }

            if (!empty($ai_top)){
                $inc_bet = mt_rand($ai_bet['week_ai_inc'][0],$ai_bet['week_ai_inc'][1]);

                $ai_tree = Db::name('bet_top')->where(['time'=>$time_week,'user_type'=>1,'type'=>1])->order('bet','desc')->limit(3)->select()->toArray();
                $user_tree = array_slice($data, 0, 3);
                foreach ($ai_tree as $ak => $av) {
                    foreach ($user_tree as $ut => $uv) {
                        if ($av['bet'] + $inc_bet <= $uv['bet']){
                            //$tmp_bet = $inc_bet + 200000000;
                            Db::name('bet_top')->where('id',$av['id'])->inc('bet',280000000)->update();
                            break;
                        }
                    }
                }

                Db::name('bet_top')->where(['time'=>$time_week,'user_type'=>1,'type'=>1])->whereIn('uid',$ai_top)->inc('bet',$inc_bet)->update();
            }

            Db::commit();
            return json(['code' => 200,'msg'=>'每周排行统计完成','data' => []]);

        }catch (\Exception $exception){
            Db::rollback();
            echo $exception->getMessage();
            Log::error('weekTopBet fail==>'.$exception->getMessage());
            return json(['code' => 201,'msg'=>'每周排行统计失败','data' => []]);
        }
    }

    public function setSlotsLog($day)
    {
        set_time_limit(0);
        ini_set('memory_limit','512M');

        $day = $day ? $day : date('Ymd');
        $list = Db::name('slots_log_'.$day)->order('createtime','asc')->cursor();

        $data = [];
        if (!empty($list)){
            foreach ($list as $key=>$value){
                $k = $value['uid'] % 10;
                $data[$k][] = $value;
            }
        }

        if (!empty($data)){
            foreach ($data as $dk=>$dv){
                Db::name('slots_log_'.$day.'_'.$dk)->insertAll($dv);
            }

            return json(['code' => 200,'msg'=>'完成','data' => []]);
        }else{
            return json(['code' => 201,'msg'=>'无','data' => []]);
        }
    }

    public function delZyUser()
    {
        $redis = new \Redis();
        $redis->connect(Config::get('redis.ip'), 5502);

        $threeDaysAgo = strtotime('-2 days');
        $user_list = Db::name('userinfo')->where('login_time','<',$threeDaysAgo)->column('uid');
        $keys = [];
        if (!empty($user_list)){
            foreach ($user_list as $value){
                $keys[] = 'user_'.$value;
            }
        }

        $res = $redis->del($keys);
        dd($res);
    }

    public function setRedisUser(Request $request)
    {
        $param = $request->param();
        $validate = Validate::rule([
            'userinfo' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("设置用户redis数据验证失败===>".$validate->getError());
            return json(['code' => 201,'msg'=>'参数错误','data' => []]);
        }

        Log::record("设置用户redis数据===>".$param['userinfo']);

    }

}



