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
//use app\common\xsex\Common;
use app\admin\Redis\pbuser\PBUserModel;
use think\facade\Session;
use app\admin\controller\Common;

/**
 *  用户分配管理
 */
class Useragent extends AuthController
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
            ->field("a.uid,FROM_UNIXTIME(a.regist_time,'%m-%d %H:%i:%s') as regist_time,a.total_pay_score,a.total_exchange,a.get_bonus,a.coin,a.puid")
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
            ->where($where)
            ->where($this->sqlwhere)
            ->count();

        if($data['data']){
            foreach ($data['data'] as &$v){
                $v['total_pay_score'] = bcdiv((string)$v['total_pay_score'], $amount_reduction_multiple,2) ?: 0;
                $v['total_exchange'] = bcdiv((string)$v['total_exchange'], $amount_reduction_multiple,2) ?: 0;
                $v['get_bonus'] = bcdiv((string)$v['get_bonus'], $amount_reduction_multiple,2) ?: 0;

                //总提现比例
                //$v['total_bili'] = $v['total_pay_score'] > 0 ? round(bcdiv($v['total_exchange'],$v['total_pay_score'],4)*100,2) : 0;


                //未玩游戏天数
                //$v['not_play_game_day'] = bcdiv((time() - strtotime($v['login_time'])),86400,0);
            }
        }
        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    /**
     * @return void
     * 分配代理
     */
    public function agent(){
        $uid = input('uid');
        $bili = input('bili');
        $agent = Db::name('agent')->field('uid')->where(['uid' => $bili])->find();

        if(!$agent) return  Json::fail('代理不存在',[]);


        $share_strlog = Db::name('share_strlog')
            ->alias('a')
            ->leftJoin('userinfo b','a.uid=b.uid')
            ->field('a.phone,a.package_id,a.channel,a.appname,a.nickname,a.puid,a.avatar')->where('a.uid',$uid)->find();
        if ($share_strlog['puid'] > 0){
            return  Json::fail('该用户已有上级',[]);
        }

        Db::startTrans();
        // 修改代理状态
        $res = Db::name('share_strlog')->where('uid',$uid)->update(['is_agent_user' => 1,'puid'=>$bili]);
        if(!$res){
            Db::rollback();
            return  Json::fail('代理状态修改失败',[]);
        }
        $res = Db::name('userinfo')->where('uid',$uid)->update(['puid'=>$bili]);
        if(!$res){
            Db::rollback();
            return  Json::fail('用户代理状态修改失败',[]);
        }

        //添加团队数据
        $res = Common::setTeamLevel($uid, $bili, 0, 0, $share_strlog);

        /*$res = Db::name('agent_teamlevel')->insert([
            'uid' => $uid,
            'puid' => $bili,
            'bili' => $bili,
            'createtime' => time()
        ]);*/
        if(!$res){
            Db::rollback();
            return  Json::fail('团队数据失败',[]);
        }
        Db::commit();
        return Json::successful('成功',[]);
    }


}
