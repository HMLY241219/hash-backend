<?php

namespace app\api\controller\share;

use app\api\controller\active\Exception;
use app\api\controller\ReturnJson;
use app\common\xsex\User;
use app\Request;
use crmeb\basic\BaseController;
use customlibrary\Common;
use Google\Service\DataprocMetastore\DatabaseDump;
use service\NewjsonService;
use think\facade\Db;
use think\facade\Env;
use think\facade\Log;
use think\facade\Validate;
use function React\Promise\all;


/**
 * 分享
 */
class Share extends BaseController
{

    /**
     * 分享页面控制台数据
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function painel(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'uid' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("分享控制台数据验证失败===>".$validate->getError());
            return ReturnJson::failFul(219);
        }

        //今日数据
        $day_user = Db::name('teamlevel')
            ->where('puid', $param['uid'])
            ->where('level','<>',0)
            ->whereDay('createtime')
            ->column('uid');

        $all_user = Db::name('teamlevel')
            ->where('puid', $param['uid'])
            ->where('level','<>',0)
            ->column('uid');
        $cz_num = Db::name('user_day_' . date('Ymd'))
            ->whereIn('uid',$all_user)
            ->where('total_pay_score','>',0)
            ->count();
        $bet = Db::name('user_day_' . date('Ymd'))
            ->whereIn('uid',$all_user)
            ->where('total_cash_water_score|total_bonus_water_score','>',0)
            ->field('IFNULL(SUM(total_cash_water_score),0) AS total_cash_water_score,IFNULL(SUM(total_bonus_water_score),0) AS total_bonus_water_score,
            COUNT(uid) AS bet_num')
            ->find();
        $commission_day = Db::name('commission_day')->where('uid',$param['uid'])->whereDay('date')->find();

        //总数据
        $order = Db::name('order')->whereIn('uid',$all_user)->where('pay_status',1)->group('uid')->column('uid');
        $userinfo = Db::name('userinfo')
            ->whereIn('uid',$all_user)
            ->field('IFNULL(SUM(total_cash_water_score),0) AS total_cash_water_score,IFNULL(SUM(total_bonus_water_score),0) AS total_bonus_water_score')
            ->find();
        $commission = Db::name('commission_day')->where('uid',$param['uid'])->field('IFNULL(SUM(commission),0) AS commission')->find();

        //领取的佣金
        $get_commission = Db::name('userinfo')
            ->alias('a')
            ->leftJoin('user_water b','a.uid=b.uid')
            ->where('a.uid',$param['uid'])->field('a.commission_total,a.commission,b.total_cash_water_score,b.total_bonus_water_score')->find();
        $bill_list = Db::name('commission_bill')->select()->toArray();
        $team_water = !empty($get_commission['total_cash_water_score']) && !empty($get_commission['total_bonus_water_score']) ? bcadd($get_commission['total_cash_water_score'], $get_commission['total_bonus_water_score']) : 0;
        //返利比例
        //$bill = 0;
        $bill_level = 1;
        foreach ($bill_list as $kk=>$item) {
            if ($item['total_amount'] > $team_water) {
                //$bill = bcdiv($bill_list[$kk-1]['bili'],10000,4);
                $bill_level = $bill_list[$kk-1]['id'];
                break;
            }
        }


        $data = [];
        $data['Hoje']['register'] = count($day_user);
        $data['Hoje']['topup'] = $cz_num;
        $data['Hoje']['bet_money'] = (int)bcadd($bet['total_cash_water_score'], $bet['total_bonus_water_score']);
        $data['Hoje']['bet_num'] = $bet['bet_num'];
        $data['Hoje']['commission'] = !empty($commission_day) ? $commission_day['commission'] : 0;

        $data['Total']['register'] = count($all_user);
        $data['Total']['topup'] = count($order);
        $data['Total']['bet_money'] = (int)bcadd($userinfo['total_cash_water_score'], $userinfo['total_bonus_water_score']);
        $data['Total']['commission'] = !empty($commission) ? (int)$commission['commission'] : 0;

        $data['Comissao']['commission_total'] = $get_commission['commission_total'];
        $data['Comissao']['commission'] = $get_commission['commission'];
        $data['Comissao']['bill_level'] = $bill_level;

        return ReturnJson::successFul(200, $data);
    }

    /**
     * 领取佣金
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCommission(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'uid' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("提取佣金数据验证失败===>".$validate->getError());
            return ReturnJson::failFul(219);
        }

        $userinfo = Db::name('userinfo')->where('uid',$param['uid'])->field('commission_total,commission')->find();
        if (empty($userinfo) || $userinfo['commission'] <= 0) return ReturnJson::failFul(226);

        try {
            Db::startTrans();

            Db::name('commission_get')->insert([
                'uid' => $param['uid'],
                'createtime' => time(),
            ]);

            Db::name('userinfo')->where('uid',$param['uid'])->update([
                'commission_total' => Db::raw('commission_total + '.$userinfo['commission']),
                'commission' => 0
            ]);
            User::userEditCoin($param['uid'], $userinfo['commission'], 9, '下级返佣');
            User::editUserTotalGiveScore($param['uid'], $userinfo['commission']);
            Db::commit();
            return ReturnJson::successFul(200,[]);

        }catch (Exception $exception){
            Db::rollback();
            Log::record("错误文件===" . $exception->getFile() . '===错误行数===' . $exception->getLine() . '===错误信息===' . $exception->getMessage());
            return ReturnJson::failFul();
        }

    }

    public function commissionGetList(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'uid' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("提取佣金記錄数据验证失败===>".$validate->getError());
            return ReturnJson::failFul(219);
        }

        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['page_size']) ? $param['page_size'] : 30;
        $page = ($page - 1) * $limit;

        $list = Db::name('commission_get')
            ->where('uid',$param['uid'])
            ->limit($page,$limit)
            ->order('createtime','desc')
            ->select()->toArray();
        return ReturnJson::successFul(200,$list,2);
    }

    /**
     * 下级用户列表
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function junior(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'uid' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("分享下级数据验证失败===>".$validate->getError());
            return ReturnJson::failFul(219);
        }

        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['page_size']) ? $param['page_size'] : 30;
        $page = ($page - 1) * $limit;

        $where = [];
        if (isset($param['date']) && !empty($param['date'])){
            $time = strtotime($param['date']) + 86400;
            $where[] = ['a.createtime','<',$time];
        }else {
            $where[] = ['a.createtime','<',time()];
            $where[] = ['a.createtime','>=',strtotime(date('Y-m-d'))];
        }
        $teamlevel = Db::name('teamlevel')
            ->alias('a')
            ->leftJoin('userinfo b','a.uid=b.uid')
            ->leftJoin('commissionlog c','a.uid=c.uid')
            ->where(['a.puid' => $param['uid'], 'a.level' => 1])
            ->where($where)
            ->field('a.uid,IFNULL(b.total_cash_water_score,0) as total_cash_water_score,IFNULL(b.total_bonus_water_score,0) as total_bonus_water_score,
            IFNULL(SUM(c.commission_money),0) AS team_bet,COUNT(DISTINCT c.char_uid) as num,GROUP_CONCAT(DISTINCT c.char_uid) as xj_users')
            ->group('a.uid')
            ->order('a.createtime','desc')
            ->limit($page, $limit)
            ->select()->toArray();

        if (!empty($teamlevel)){
            foreach ($teamlevel as $key=>&$value){
                //返佣
                $users_arr = explode(',',$value['xj_users']);
                $users_arr[] = (string)$value['uid'];
                $commission = Db::name('commissionlog')->where('uid',$param['uid'])->whereIn('char_uid',$users_arr)
                    ->field('IFNULL(SUM(really_money),0) AS really_money')->find();
                $value['commission'] = $commission['really_money'];
                $value['bet'] = bcadd($value['total_cash_water_score'], $value['total_bonus_water_score']);

                $value['uid'] = $this->hideMiddle($value['uid']);

                unset($value['total_cash_water_score'],$value['total_bonus_water_score'],$value['xj_users']);
            }
        }

        $all_teamlevel = Db::name('teamlevel')
            ->alias('a')
            ->where(['a.puid' => $param['uid']])
            ->where('level','>',0)
            ->where($where)
            ->field('a.uid,a.level')
            ->select()->toArray();
        $level1 = [];
        $level2 = [];
        if (!empty($all_teamlevel)){
            foreach ($all_teamlevel as $ak=>$av){
                if ($av['level'] == 1){
                    $level1[] = $av['uid'];
                }else{
                    $level2[] = $av['uid'];
                }
            }
        }

        $level1_commission = Db::name('commissionlog')->where('uid',$param['uid'])->whereIn('char_uid',$level1)
            ->field('IFNULL(SUM(really_money),0) AS really_money')->find();
        $level2_commission = Db::name('commissionlog')->where('uid',$param['uid'])->whereIn('char_uid',$level2)
            ->field('IFNULL(SUM(really_money),0) AS really_money')->find();

        $data = [];
        $data['list'] = $teamlevel;
        $data['total_direct_commission'] = $level1_commission['really_money'];
        $data['total_indirect_commission'] = $level2_commission['really_money'];
        return ReturnJson::successFul(200, $data, 2);
    }


    /**
     * 每日数据
     * @param Request $request
     * @return null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function dayData(Request $request){
        $param = $request->param();
        $validate = Validate::rule([
            'uid' => 'require',
        ]);
        if (!$validate->check($param)) {
            Log::record("每日数据验证失败===>".$validate->getError());
            return ReturnJson::failFul(219);
        }

        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['page_size']) ? $param['page_size'] : 30;
        $page = ($page - 1) * $limit;

        $list = Db::name('commission_day')
            ->where('uid',$param['uid'])
            ->limit($page,$limit)
            ->order('date','desc')
            ->select()->toArray();
        return ReturnJson::successFul(200,$list,2);

    }


    /**
     * 隐藏字符中间几位
     * @param $str
     * @return array|string|string[]
     */
    function hideMiddle($str) {
        $hidden = substr_replace($str,'****',2,3);

        return $hidden;
    }


}