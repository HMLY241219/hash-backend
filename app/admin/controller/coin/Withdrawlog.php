<?php

namespace app\admin\controller\coin;

use app\admin\controller\AuthController;
use app\api\controller\My;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use think\facade\Log;
use think\facade\Session;
use curl\Curl;

/**
 *  提现订单列表
 */
class Withdrawlog extends AuthController
{

    private $table = 'withdraw_log';


    private $header = array(
        "Content-Type: application/x-www-form-urlencoded",
    );
    /**
     * 提现订单列表
     *
     */
    public function index($uid = '',$status = 0,$date = '')
    {
        $data =  request()->param();

        $withdraw_type = Db::name('withdraw_type')->order('weight','desc')->column('name,id');
        $createtime = $uid > 0 ? '' : ($date != '' ? $date.' - '.$date : date('Y-m-d') .' - '. date('Y-m-d'));
        $this->assign('withdraw_type',$withdraw_type);
        $this->assign('uid',$uid);

        $adminInfo = $this->adminInfo;
        $is_export = Db::name('system_role')->where('id','=',$adminInfo->roles)->value('is_export');
        $defaultToolbar = $is_export == 1 ? ['print', 'exports'] : [];
        $this->assign('defaultToolbar', json_encode($defaultToolbar));


        $status = $uid > 0 ? 1 : ($status > 0 ? $status : 3);
        $this->assign('status',$status);
        $this->assign('createtime',isset($data['is_mess']) ? '' : $createtime);
        return $this->fetch();
    }


    /**
     * 提现订单列表
     */
    public function getlist(){
        $data =  request()->param();
        $data['date'] = $data['date'] ?? date('Y-m-d').' - '.date('Y-m-d');
        $siyutype = $data['siyutype'] =  $data['siyutype'] ?? 1; //不看思域
        unset($data['siyutype']);
        $where = Model::getWhere($data,'a.createtime');
        $siyuwhere = $siyutype == 1 ? [['a.auditdesc','<>',7]] : [['a.auditdesc','=',7]];
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 20;
        //平台与渠道
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$this->sqlwhere[] = ['a.channel', '<', 100000000];
            } else {
                $this->sqlwhere[] = ['a.channel', '>=', 100000000];
            }
        }
        $data = Db::name('withdraw_log')
            ->alias('a')
            ->field("a.uid,a.withdraw_type,a.type,a.before_money,a.ordersn,a.platform_id,a.fee_money,a.money,
            a.really_money,a.status,FROM_UNIXTIME(a.createtime,'%Y-%m-%d %H:%i:%s') as createtime,
            FROM_UNIXTIME(a.finishtime,'%Y-%m-%d %H:%i:%s') as finishtime,a.auditdesc,a.remark,
            a.control,b.order_coin,b.withdraw_coin,b.withdraw_bili,b.gl_user,b.gl_order,b.gl_withdraw,
            b.gl_refund_bili,b.gl_device,b.gl_phone,b.gl_email,b.gl_bankaccount,
            c.real_name,b.now_withdraw_money,b.send_fail_num,b.chinese_error,
            b.gl_ip,b.water_multiple,a.id,a.backname,a.bankaccount,a.ifsccode")
            ->join('withdraw_logcenter b ','b.withdraw_id = a.id')
            ->leftJoin('system_admin c','c.id = a.admin_id')
            ->where($where)
            ->where($siyuwhere)
            ->where($this->sqlwhere)
            ->where('a.black_status',0)
            ->order('a.createtime','desc')
            ->page($page,$limit)
            ->select()
            ->toArray();

        if(!$data){
            return json(['code' => 0, 'count' => 0, 'data' => []]);
        }


        $count = Db::name('withdraw_log')
            ->alias('a')
            ->join('withdraw_logcenter b ','b.withdraw_id = a.id')
            ->where($where)
            ->where($siyuwhere)
            ->where($this->sqlwhere)
            ->where('a.black_status',0)
            ->order('a.createtime','desc')
            ->count();

        $pt_money = 0;
        $fl_money = 0;

        foreach ($data as &$v){
            $v['real_name'] = $v['real_name'] ?: '系统';
            $v['type'] = $v['type'] == 1 ? '银行卡' : 'UPI';
            $control = explode(',',$v['control']);
            $v['control'] = bcdiv($control[0],100,2).'/'.bcdiv($control[1],100,2);
            $v['chinese_error'] = $v['chinese_error'] ?: '无';
            $pt_money = bcadd($pt_money,$v['money'],0);
//            $v['commission_type'] == 1 ? $fl_money = bcadd($fl_money,$v['money'],0) : $pt_money = bcadd($pt_money,$v['money'],0);
        }
        return json(['code' => 0, 'count' => $count, 'data' => $data, 'pt_money'=>$pt_money/100, 'fl_money'=>$fl_money/100]);
    }

    /**
     * @return void 关联用户
     */
    public function association($uid){
        $this->assign('uid',$uid);

        return $this->fetch();
    }


    public function associationList($uid){
//        [$phoneUid,$emailUid,$deviceUid,$backnameUid,$bankaccountUid,$ipUid] = My::glTypeUid($uid);
        [$phoneUid,$emailUid,$ipUid,$bankaccountUid,$upiUid] = My::glTypeUid($uid);

        $share_strlog = Db::name('share_strlog')->field('device_id,email,phone,ip')->where('uid',$uid)->find();
        $user_withinfo = Db::name('user_withinfo')->field('type,account')->where(['uid' => $uid,'type' => 1])->order('id','desc')->find();
        $list = [];
        if($share_strlog['ip'] && $ipUid) foreach ($ipUid as $v){
            isset($list[$v]) ? $list[$v]['value'] = $list[$v]['value'].','.$share_strlog['ip'] : $list[$v] = [
                'uid' => $v,
                'value' => $share_strlog['ip'],
            ];
        }
        if($share_strlog['phone'] && $phoneUid) foreach ($phoneUid as $v){
            isset($list[$v]) ? $list[$v]['value'] = $list[$v]['value'].','.$share_strlog['phone'] : $list[$v] = [
                'uid' => $v,
                'value' => $share_strlog['phone'],
            ];
        }
        if($share_strlog['email'] && $emailUid) foreach ($emailUid as $v){
            isset($list[$v]) ? $list[$v]['value'] = $list[$v]['value'].','.$share_strlog['email'] : $list[$v] = [
                'uid' => $v,
                'value' => $share_strlog['email'],
            ];
        }
//        if($share_strlog['device_id'] && $deviceUid) foreach ($deviceUid as $v){
//            isset($list[$v]) ? $list[$v]['value'] = $list[$v]['value'].','.$share_strlog['device_id'] : $list[$v] = [
//                'uid' => $v,
//                'value' => $share_strlog['device_id'],
//            ];
//        }
//        if($user_withinfo['backname'] && $backnameUid) foreach ($backnameUid as $v){
//            isset($list[$v]) ? $list[$v]['value'] = $list[$v]['value'].','.$user_withinfo['backname'] : $list[$v] = [
//                'uid' => $v,
//                'value' => $user_withinfo['backname'],
//            ];
//        }
        if($user_withinfo['account'] && $bankaccountUid) foreach ($bankaccountUid as $v){
            isset($list[$v]) ? $list[$v]['value'] = $list[$v]['value'].','.$user_withinfo['account'] : $list[$v] = [
                'uid' => $v,
                'value' => $user_withinfo['account'],
            ];
        }

        return json(['code' => 0, 'count' => count($list), 'data' => $list]);
    }



    /**
     * 完成订单
     * @param $ordersn 订单号
     * @param $remark 备注
     * @return void
     */
    public function successOrder($ordersn,$remark){
        $res = $this->successAffairs($ordersn,$remark);
        if($res['code'] != 200){
            return Json::fail($res['msg'],[]);
        }
        return Json::successful('成功',[]);
    }

    /**
     * @return void 批量完成订单
     */
    public function reviewAll(){
        $withdraw_All = input('list');
        foreach ($withdraw_All as $v){
            if($v['status'] == 3){
                $res = $this->successAffairs($v['ordersn'],'正常');
                if($res['code'] != 200){
                    return Json::fail($res['msg'],[]);
                }
            }
        }
        return Json::successful('成功',$withdraw_All);
    }


    /**
     * 完成订单
     * @param $ordersn 订单号
     * @param $remark 备注
     * @return void
     */
    private function successAffairs($ordersn,$remark){
        $withdraw = Db::name($this->table)->where('ordersn',$ordersn)->find();
        if(!$withdraw || !in_array($withdraw['status'],[0,3])){
            return ['code' => 201,'msg' => '不满足退款条件','data' => []];
        }

        if($withdraw['type'] == 4){
            $withdraw_protocol = Db::name('withdraw_protocol')->where('id',$withdraw['id'])->find();
            if($withdraw_protocol){
                $withdraw['protocol_name'] = $withdraw_protocol['protocol_name'];
                $withdraw['protocol_money'] = $withdraw_protocol['protocol_money'];
            }else{
                $withdraw['protocol_name'] = 'TRC20';
                $withdraw['protocol_money'] = 0;
            }
        }

        $withdraw['admin_id'] = $this->adminId;
        $withdraw['remark'] = $remark;
        $withdraw['jianame'] = Db::name('share_strlog')->where('uid',$withdraw['uid'])->value('jianame');
        if($withdraw['status'] == 3){
            Db::name($this->table)->where('ordersn',$ordersn)->update(['status' => 0]);
            $apInfo = Curl::post($this->getWithdrawUrl(),$withdraw,$this->header,[],2);
        }else{
            $apInfo = Curl::post($this->getWithdrawUrl(),$withdraw,$this->header,[],2);
        }



        $apInfo = json_decode($apInfo,true);

        if($apInfo['code'] != 200 ){
            if($apInfo['code'] != 202){ //服务器与三方网络冲突,请过1分钟左右再尝试该通道
                $userinfo = Db::name('userinfo')->field('uid,coin,total_exchange,total_exchange_num')->where('uid',$withdraw['uid'])->find();
                $this->setUserWithdrawLogInfo($userinfo,$withdraw['money'],date('Ymd',$withdraw['createtime']));
            }
            return ['code' => 201,'msg' => $apInfo['msg'],'data' => []];
        }

        //发送提现成功消息to Tg
        //\service\TelegramService::withdrawSuc($withdraw);
        return ['code' => 200,'msg' => '成功','data' => []];
    }


    /**
     * 驳回订单
     * @param $ordersn 订单号
     * @param $remark 备注
     * @return void
     */
    public function reject($ordersn,$remark){
        $res = $this->rejectAffairs($ordersn,$remark);
        if($res['code'] != 200){
            return Json::fail($res['msg'],[]);
        }
        return Json::successful('成功',[]);
    }

    /**
     * @return void 批量驳回
     */
    public function rejectAll(){
        $withdraw_All = input('list');
        $remark = input('remark');
        foreach ($withdraw_All as $v){
            if(in_array($v['status'],[0,3])){
                $this->rejectAffairs($v['ordersn'],$remark);
            }
        }
        return Json::successful('成功',$withdraw_All);
    }



    public function idleAll(){
        $idleAll = input('list');
        $ordersn = [];
        foreach ($idleAll as $v){
            $ordersn[] = $v['ordersn'];
        }
        $withdraw_log = Db::name('withdraw_log')->field('idle_order,id')->where('ordersn','in',$ordersn)->select()->toArray();
        foreach ($withdraw_log as $value){
            Db::name('withdraw_log')->where('id','=',$value['id'])->update(['idle_order' => $value['idle_order'] ? 0 : 1]);
        }
        Json::successful('成功',[]);
    }
    /**
     * 驳回订单
     * @param $ordersn 订单号
     * @param $remark 备注
     * @return void
     */
    private function rejectAffairs($ordersn,$remark){
        $withdraw = Db::name($this->table)->where('ordersn',$ordersn)->where('status','in',[0,3])->find();
        if(!$withdraw){
            return ['code' => 201,'msg' => '不满足驳回条件','data' => []];
        }

        $userinfo = Db::name('userinfo')->field('uid,coin,package_id,channel,total_exchange,total_exchange_num')->where('uid',$withdraw['uid'])->find();
        Db::startTrans();

        $this->setUserWithdrawLogInfo($userinfo,$withdraw['money'],date('Ymd',$withdraw['createtime']));

        if($withdraw['status'] == 0){
            $res = Db::name('userinfo')->where('uid',$withdraw['uid'])->update([
                'coin' => Db::raw('coin + '.$withdraw['money']),
                'withdraw_money' => Db::raw('withdraw_money + '.$withdraw['money']),
                'withdraw_money_other' => Db::raw('withdraw_money_other + '.$withdraw['withdraw_money_other']),
                'reject_num' => Db::raw('reject_num + 1'),
            ]);
        }else{
            $res = Db::name('userinfo')
                ->where('uid',$withdraw['uid'])
                ->update([
                    'coin' => Db::raw('coin + '.$withdraw['money']),
                    'withdraw_money' => Db::raw('withdraw_money + '.$withdraw['money']),
                    'withdraw_money_other' => Db::raw('withdraw_money_other + '.$withdraw['withdraw_money_other'])
                ]);
        }



        if(!$res){
            Db::rollback();
            return ['code' => 201,'msg' => '用户回退余额增加失败','data' => []];
        }
        $res = Db::name('coin_'.date('Ymd'))
            ->insert([
                'uid' => $withdraw['uid'],
                'num' => $withdraw['money'],
                'total' => bcadd((string)$userinfo['coin'],(string)$withdraw['money'],0),
                'reason' => 5,
                'type' => 1,
                'content' => '管理员:'.$this->adminName.'退款驳回',
                'channel' => $userinfo['channel'],
                'package_id' => $userinfo['package_id'],
                'createtime' => time(),
            ]);
        if(!$res){
            Db::rollback();
            return ['code' => 201,'msg' => '用户每日流水记录存储失败','data' => []];
        }
        $res = Db::name($this->table)->where('ordersn',$ordersn)->update(['remark' => $remark,'admin_id' => $this->adminId,'status' => -1,'finishtime' => time()]);
        if(!$res){
            Db::rollback();
            return ['code' => 201,'msg' => '用户退款记录修改失败','data' => []];
        }

        //存储发送内容
        /*Db::name('user_information')->insert([
            'uid' => $withdraw['uid'],
            'title' => 'System messages',
            'content' => $remark,
            'createtime' => time(),
        ]);*/

        Db::commit();
        return ['code' => 200,'msg' => '成功','data' => []];
    }

    /**
     * 发送邮件
     * @param $ordersn 订单号
     * @param $content 内容
     * @return void
     */
    public function send_fail_email($ordersn,$content){
        $withdraw_log = Db::name('withdraw_log')
            ->alias('a')
            ->field('a.uid,a.id')
            ->where('a.ordersn',$ordersn)
            ->join('withdraw_logcenter b','b.withdraw_id = a.id')
            ->find();
        if(!$withdraw_log) Json::fail('订单获取失败',[]);

        if(\customlibrary\Common::PregMatch($content,'chinese'))Json::fail('内容不能包含中文',[]);
        //修改次数
        Db::name('withdraw_logcenter')
            ->where('withdraw_id',$withdraw_log['id'])
            ->update([
                'send_fail_num' => Db::raw('send_fail_num + 1')
            ]);

        Db::name('user_information')->insert([
            'uid' => $withdraw_log['uid'],
            'title' => 'Withdrawal Failed',
            'content' => $content,
            'createtime' => time(),
        ]);
        Json::successful('发送成功',[]);
    }

    public function sendEmailLog($withdrawId){
        $this->assign('withdrawId',$withdrawId);
        return $this->fetch();
    }


    public function sendEmailLogIndex($withdrawId){

        $log_error = Db::name('withdraw_logcenter')->field('log_error')->where('withdraw_id',$withdrawId)->find();
        $data[] = $log_error;
        return json(['code' => 0, 'count' => 1, 'data' => $data]);
    }

    public function black_withdraw_log($ordersn){
        $withdraw_log = Db::name('withdraw_log')->field('id,uid')->where('ordersn',$ordersn)->find();
        $res = Db::name('withdraw_log')->where('id',$withdraw_log['id'])->update(['black_status' => 1]);
        if(!$res) Json::fail('拉黑失败',[]);


        //封禁用户以及关联用户
        \app\common\xsex\Common::prohibitedUsers($withdraw_log['uid'],$this->adminId,[],'提现订单封禁'.$ordersn);

        Json::successful('拉黑成功',[]);
    }


    private function getWithdrawUrl(){
        return config('redis.api').'/Withdrawlog/htWithdrawApi';
    }


    /**
     * 处理失败订单减去用户退款金额和次数
     * @param $userinfo
     * @param int $money
     * @param $daySuffix 后缀 代付订单创建那天
     * @return void
     */
    private function setUserWithdrawLogInfo($userinfo,int $money,$daySuffix = ''){
        $daySuffix = $daySuffix ?: date('Ymd');

        $user_day = Db::name('user_day_'.$daySuffix)->field('uid')->where('uid',$userinfo['uid'])->find();
        if($user_day){
            Db::name('user_day_'.$daySuffix)->where('uid',$userinfo['uid'])->update([
                'total_exchange' => Db::raw('total_exchange - '.$money),
                'total_exchange_num' => Db::raw('total_exchange_num - 1'),
            ]);
        }

        if ($userinfo['total_exchange_num'] == 1){ //如果已经有一次退款了,看第二次金额是否是退款失败
            Db::name('userinfo')->where('uid',$userinfo['uid'])
                ->update([
                    'total_exchange' => Db::raw('total_exchange - '.$money),
                    'total_exchange_num' => Db::raw('total_exchange_num - 1'),
                    'first_withdraw_time' => 0,
                    'updatetime' =>time(),
                ]);
        }else{
            Db::name('userinfo')->where('uid',$userinfo['uid'])
                ->update([
                    'total_exchange' => Db::raw('total_exchange - '.$money),
                    'total_exchange_num' => Db::raw('total_exchange_num - 1'),
                    'updatetime' => time(),
                ]);
        }


    }
}
