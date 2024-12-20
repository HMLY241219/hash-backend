<?php

namespace app\api\controller\active;

use app\api\controller\ReturnJson;
use app\common\xsex\User;
use app\Request;
use crmeb\basic\BaseController;
use customlibrary\Common;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use service\NewjsonService;
use think\facade\Db;
use think\facade\Env;
use think\facade\Log;
use think\facade\Validate;
use crmeb\services\MqProducer;
use crmeb\services\MqConsumer;


/**
 * 活动
 */
class Active extends BaseController
{

    /**
     * 活动列表
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function activeList(Request $request){
        //$packname = $request->header('packname');
        //$param = $this->param;

        $list = Db::name('active')->where(['status'=>1])->field('englishname,banner,type,url')->select()->toArray();
        if (!empty($list)){
            foreach ($list as $key=>$value){
                $list[$key]['banner'] = Common::domain_name_path($value['banner']);
            }
        }
        return ReturnJson::successFul(200,$list,1);
    }

    /**
     * 转盘活动页面数据
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function turntableActive(Request $request){
        $uid = $request->uid;

        $is_get = false;
        $info = Db::name('turntable')->where(['endstatus'=>1,'uid'=>$uid])->order('id','desc')->find();
        if (!empty($info)){
            if ($info['money'] < 100 && (time()-$info['createtime']) > 86400*3){//超过3天
                Db::name('turntable')->where('id',$info['id'])->update(['endstatus'=>3]);
                $info['remaining_time'] = 0;
                $info['turntable_id'] = 0;
            }else{
                $is_get = true;
                $info['remaining_time'] = 86400*3 - (time() - $info['createtime']);
                $info['turntable_id'] = $info['id'];
            }
        }else{
            $info['money'] = 0;
            $info['z_count'] = 1;
            $info['remaining_time'] = 0;
            $info['turntable_id'] = 0;
            $info['createtime'] = 0;
        }

        $data = [];
        $data['uid'] = $uid;
        $data['is_get'] = $is_get;
        $data['zs_money'] = $info['money'];
        $data['z_count'] = $info['z_count'];
        $data['remaining_time'] = $info['remaining_time'];
        $data['turntable_id'] = $info['turntable_id'];
        $data['end_time'] = $info['createtime'] + 86400*3;
        $data['start_time'] = $info['createtime'];

        //奖品列表
        $options = Db::name('turntable_reward')->field('id as options_id,name,logo,type')->select()->toArray();
        if (!empty($options)){
            foreach ($options as $key=>$value){
                $options[$key]['logo'] = Common::domain_name_path($value['logo']);
            }
        }
        $data['options'] = $options;

        //获奖名单
        $get_list = [];
        for ($i=0; $i<30; $i++){
            $k = mt_rand(2358, 9988);
            $e = mt_rand(101, 998);
            //$get_list[] = $k . '******' . $e . '   Acabou de saca   +100 R$';
            $get_list[$i]['uid'] = $k . '******' . $e;
            $get_list[$i]['text'] = 'Acabou de saca';
            $get_list[$i]['money'] = 100;
            $get_list[$i]['currency'] = 'R$';
        }
        $data['get_list'] = $get_list;

        //邀请记录
        $user_team = [];
        if ($info['turntable_id'] > 0) {
            $user_team = Db::name('user_team')->where('turntable_id',$info['turntable_id'])
                ->field('nickname,money,"Acabou de ajuda-lo a ganhar" as text')->select()->toArray();
        }
        $data['minha'] = $user_team;

        return ReturnJson::successFul(200,$data,1);
    }

    /**
     * 转动转盘
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function turntable(Request $request){
        $uid = $request->uid;
        $info = Db::name('turntable')->where(['endstatus'=>1,'uid'=>$uid])->order('id','desc')->find();

        try {
            Db::startTrans();
            if (empty($info)){
                $in_data = [];
                $in_data['uid'] = $uid;
                $give = $in_data['money'] = mt_rand(95*100,96*100) / 100;
                $in_data['createtime'] = time();
                $turntable_id = Db::name('turntable')->insertGetId($in_data);
            }else{
                $give = 0;
                if ($info['z_count'] < 1){
                    return ReturnJson::failFul();
                }
                $turntable_id = $info['id'];
            }

            $winnerList = Db::name('turntable_reward')->select()->toArray();
            //概率计算
            $ranges = [];
            $start = 0;
            foreach ($winnerList as $item) {
                $end = $start + $item['probability'];
                $ranges[] = ['start' => $start, 'end' => $end, 'index' => $item['id'], 'reward' => $item['reward'], 'reward_max' => $item['reward_max'], 'type' => $item['type']];
                $start = $end;
            }
            // 生成随机数
            $random = mt_rand(0, 100);
            $turntable_reward_id = 0;
            $reward = 0;
            $reward_max = 0;
            $type = 0;
            // 判断随机数落在哪个范围内
            for ($i = 0; $i < count($ranges); $i++) {
                if ($random >= $ranges[$i]['start'] && $random < $ranges[$i]['end']) {
                    $turntable_reward_id = $ranges[$i]['index'];
                    $reward = $ranges[$i]['reward'];
                    $reward_max = $ranges[$i]['reward_max'];
                    $type = $ranges[$i]['type'];
                }
            }

            //给与奖励
            if (!empty($info)) {
                if ($info['money'] < 99.7) {
                    if ($type == 1) {
                        $give = mt_rand($reward * 100, $reward_max * 100) / 100;
                        Db::name('turntable')->where('id', $info['id'])->inc('money', $give)->dec('z_count')->update();
                    } elseif ($type == 2) {
                        Db::name('turntable')->where('id', $info['id'])->dec('z_count')->update();
                        $give = $reward;
                        $res = User::userEditCoin($uid, $reward * 100, 11, '玩家' . $uid . '转盘中奖：' . $reward, 2);
                        if (!$res) {
                            Db::rollback();
                            return ReturnJson::failFul();
                        }
                        $res = User::editUserTotalGiveScore($uid, $reward * 100);
                        if (!$res) {
                            Db::rollback();
                            return ReturnJson::failFul();
                        }
                    } elseif ($type == 3) {
                        Db::name('turntable')->where('id', $info['id'])->dec('z_count')->update();
                        $give = $reward;
                        $res = User::userEditBonus($uid, $reward * 100, 11, '玩家' . $uid . '转盘中奖：' . $reward, 2);
                        if (!$res) {
                            Db::rollback();
                            return ReturnJson::failFul();
                        }
                    }
                }else{
                    Db::name('turntable')->where('id', $info['id'])->dec('z_count')->update();
                    //控制到达99.7
                    $turntable_reward_id = 7;
                    $give = 0;
                    $type = 1;
                }
            }

            //添加转盘记录
            $log_data = [];
            $log_data['uid'] = $uid;
            $log_data['turntable_id'] = $turntable_id;
            $log_data['turntable_reward_id'] = $turntable_reward_id;
            $log_data['reward'] = $give;
            $log_data['type'] = $type;
            $log_data['create_time'] = time();
            Db::name('turntable_log')->insert($log_data);

            $data = [];
            $data['options_id'] = $turntable_reward_id;
            $data['give'] = $give;

            Db::commit();
            return ReturnJson::successFul(200,$data,1);
        }catch (Exception $exception){
            Db::rollback();
            Log::record("错误文件===" . $exception->getFile() . '===错误行数===' . $exception->getLine() . '===错误信息===' . $exception->getMessage());
            return ReturnJson::failFul();
        }
    }

    /**
     * 领取奖励
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCash(Request $request){
        $uid = $request->uid;
        $money = 10000;
        $info = Db::name('turntable')->where(['endstatus'=>1,'uid'=>$uid])->order('id','desc')->find();
        if (!empty($info) && $info['endstatus']==1 && $info['money']>=100){
            try {
                Db::startTrans();
                $res = User::userEditCoin($uid, $money, 11, '玩家'.$uid.'转盘获取：100', 2);
                if (!$res){
                    Db::rollback();
                    return ReturnJson::failFul();
                }

                $res = User::editUserTotalGiveScore($uid, $money);
                if (!$res){
                    Db::rollback();
                    return ReturnJson::failFul();
                }

                $res = Db::name('turntable')->where('id',$info['id'])->update([
                    'endstatus' => 2
                ]);
                if (!$res){
                    Db::rollback();
                    return ReturnJson::failFul();
                }

                Db::commit();
                return ReturnJson::successFul(200,[],1);

            }catch (Exception $exception){
                Db::rollback();
                Log::record("错误文件===" . $exception->getFile() . '===错误行数===' . $exception->getLine() . '===错误信息===' . $exception->getMessage());
                return ReturnJson::failFul();
            }

        }else{
            return ReturnJson::failFul();
        }
    }


    /**
     * 每日给与转盘次数
     * @return mixed
     * @throws \think\db\exception\DbException
     */
    public function setTurntableCount(){
        $threeDaysAgo = strtotime('-5 days'); // 获取三天前的时间戳

        $result = Db::name('turntable')
            ->where('createtime', '>=', $threeDaysAgo)
            ->where('endstatus', 1)
            ->update(['z_count' => 1]);

        if ($result){
            return app('json')->status('SUCCESS', '转盘次数设置成功');
        }else{
            return app('json')->fail('无需设置转盘数据');
        }
    }


}