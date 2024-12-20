<?php

namespace app\admin\controller\coin;

use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
use think\facade\Session;
use curl\Curl;

/**
 *  充值订单列表
 */
class Order extends AuthController
{

    private $table = 'order';
    private $header = array(
        "Content-Type: application/x-www-form-urlencoded",
    );
    /**
     * 充值订单列表
     *
     */
    public function index($uid = '')
    {
//        $admin = $this->adminInfo;

        $pay_type = Db::name('pay_type')->order('weight','desc')->column('name,id');
        $active = Db::name('order_active')->order('id','desc')->column('name,id');
        $createtime = $uid > 0 ? '' : date('Y-m-d',strtotime('-7 day')) .' - '. date('Y-m-d');
        $this->assign('pay_type',$pay_type);
        $this->assign('active',$active);
        $this->assign('uid',$uid);
        $this->assign('status',$uid > 0 ? 1 : '');
        $this->assign('createtime',$createtime);
        $adminId = $this->adminId;
        $defaultToolbar = $adminId == 59 ? ['print', 'exports'] : [];
        $this->assign('defaultToolbar', json_encode($defaultToolbar));


        return $this->fetch();
    }


    /**
     * 充值订单列表
     */
    public function getlist(){
        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $data['date'] = $data['date'] ?? date('Y-m-d',strtotime('-7 day')).' - '.date('Y-m-d');
        $tablename = $this->table;
        $filed = "a.id,FROM_UNIXTIME(a.createtime,'%Y-%m-%d %H:%i:%s') as createtime,FROM_UNIXTIME(a.finishtime,'%Y-%m-%d %H:%i:%s') as finishtime,
        a.uid,a.ordersn,a.tradeodersn,a.zs_bonus,a.zs_money,a.money,a.price,a.pay_status,a.type,a.paytype,a.packname,b.name,a.nickname,a.phone,
        a.email,a.ip,a.all_price,a.fee_money,a.pay_chanel,a.remark,
        c.cname";//FROM_UNIXTIME(c.createtime,'%Y-%m-%d %H:%i:%s') as user_createtime

        //平台与渠道
        if (!Session::get('chanel')) {
            if ($this->adminInfo['type'] == 0) {
                //$this->sqlwhere[] = ['a.channel', '<', 100000000];
            } else {
                $this->sqlwhere[] = ['a.channel', '>=', 100000000];
            }
        }

        $orderfield = "a.createtime";
        $sort = "desc";
        $join1 = ['order_active b','b.id = a.active_id'];
//        $join2 = ['share_strlog c','a.uid = c.uid'];
        $join2 = ['chanel c','a.channel = c.channel'];
        $alias = 'a';
        $date = 'a.createtime';
        $date2 = 'c.createtime';
        $data = Model::joinGetdata2($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join1,$join2,$alias,$date,$date2,'left',$this->sqlwhere);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }

    /**
     * @return void 完成订单
     */
    public function completeOrder()
    {
        $id = request()->param('id');
        $order = Db::name('order')->where('id', $id)->find();
        $apInfo = Curl::post($this->getOrderUrl(),$order,$this->header,[],2);
        $res = json_decode($apInfo,true);
        if($res['code'] != 200){
            return json(['code' => '201','msg' => $res['msg'],'data' => []]);
        }
        return json(['code' => '200','msg' => '','data' => []]);
    }


    /**
     * 人工充值
     * @return void
     */
    public function peopleAdd(){
        $f[] = Form::number('uid', '充值用户ID');
        $f[] = Form::number('price', '充值金额(分)',0);
        $f[] = Form::number('zs_cash', '赠送的Cash(分)',0);
        $f[] = Form::number('zs_bonus', '赠送的Bonus(分)',0);


        $form = Form::make_post_form('修改数据', $f, url('peopleAddSave'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    public function peopleAddSave(){
        $data = request()->post();
        $share_strlog = Db::name('share_strlog')
            ->alias('a')
            ->join('userinfo b','a.uid = b.uid')
            ->field('a.phone,b.total_pay_score,b.package_id,b.channel,a.phone,a.jiaphone,a.jiaemail,a.appname,a.ip')
            ->where('a.uid', $data['uid'])
            ->find();
        if(!$share_strlog) return json(['code' => '201','msg' => '用户不存在！','data' => []]);
        if($data['price'] <= 0)return json(['code' => '201','msg' => '充值金额必须大于0！','data' => []]);
        $phone = $share_strlog['phone'] ?: ($share_strlog['jiaphone'] ?: rand(7777777777,9999999999));

        $email = $share_strlog['jiaemail'];
        // 创建订单
        $createData = [
            "uid"           => $data['uid'],
            "day"           => 1 ,
            "ordersn"  => date('YmdHis') . '000' . substr(microtime(), 2, 3) . sprintf('%02d', rand(0, 99)),
            "paytype"       => '',
            "zs_bonus"      => $data['zs_bonus'],
            "zs_money"      => $data['zs_cash'],
            "money"      => bcadd((string)$data['zs_cash'],(string)$data['price'],0),
            'get_money' => $data['price'],
            'price'    => $data['price'],
            'email'         => $email,
            'phone'        => $phone,
            'nickname'        => $phone,
            'createtime' => time(),
            'packname' => $share_strlog['appname'],
            'active_id' => 0,
            'ip' => $share_strlog['ip'],
            'all_price' => $share_strlog['total_pay_score'],
            'fee_money' => 0,
            'current_money' => 0,
            'package_id' => $share_strlog['package_id'],
            'channel' => $share_strlog['channel'],
            'shop_id' =>  0,
            'type' =>  3,
        ];

        $res =  Db::name('order')->insert($createData);
        if(!$res)return json(['code' => '201','msg' => '人工充值失败！','data' => []]);
        $apInfo = Curl::post($this->getOrderUrl(),$createData,$this->header,[],2);
        $res = json_decode($apInfo,true);
        if($res['code'] != 200){
            return json(['code' => '201','msg' => $res['msg'],'data' => []]);
        }
        return json(['code' => '200','msg' => '人工充值成功','data' => []]);
    }

    private function getOrderUrl(){
        return config('redis.api').'/Order/htOrderApi';
    }
}
