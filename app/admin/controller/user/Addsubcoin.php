<?php

namespace app\admin\controller\user;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
use think\facade\Log;

/**
 *  用户加减款管理
 */
class Addsubcoin extends AuthController
{


    private $tablename = 'addsubcoin_log';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $data['date'] = $data['date'] ?? date('Y-m-d').' - '.date('Y-m-d');
        $zdywhere = [];
        if ($this->adminInfo['type'] == 1){
            $zdywhere = $this->sqlwhere;
        }
        $tablename = $this->tablename;
        $filed = "a.id,FROM_UNIXTIME(a.updatetime,'%Y-%m-%d %H:%i:%s') as updatetime,a.remark,a.coin,b.real_name as admin_id,a.uid,a.coin_type,a.money_type";
        $orderfield = "a.updatetime";
        $sort = "desc";
        $join = ['system_admin b','b.id = a.admin_id'];
        $alias = 'a';
        $date = 'a.updatetime';

        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left',$zdywhere);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    /**
     * @return void 添加
     */
    public function add()
    {
//        userinfo = Db::name('userinfo')->where('status',0)->select()->toArray();
        $f = array();
        $f[] = Form::input('uid', '用户ID');
        $f[] = Form::input('coin', '调整金额(分)');

        if ($this->adminInfo['type'] == 1) {
            $f[] = Form::radio('money_type', '钱类型', 1)->options([['label' => 'Cash', 'value' => 1]]);
            $f[] = Form::radio('coin_type', '类型', 1)->options([['label' => '赠送', 'value' => 1]]);
        }else{
            $f[] = Form::radio('money_type', '钱类型', 1)->options([['label' => 'Cash', 'value' => 1], ['label' => 'Bonus', 'value' => 2]]);
            $f[] = Form::radio('coin_type', '类型', 1)->options([['label' => '赠送', 'value' => 1], ['label' => '充值', 'value' => 2]]);
        }
        $f[] = Form::radio('type', '加减类型',1)->options([['label' => '加款', 'value' => 1], ['label' => '减款', 'value' => 2]]);
        $f[] = Form::textarea('remark', '备注');

        $form = Form::make_post_form('添加数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    /**
     * @return void 存储数据
     */
    public function save(){
        $data = request()->post();
        if ($this->adminInfo['type'] == 1 || $this->adminInfo['roles'] == 8){ //渠道 和 客服身份
            /*if (!in_array($this->adminInfo['id'],[15,18])){
                return Json::fail('请联系主账号操作');
            }*/
            if ($data['type'] == 1 && $this->adminInfo['put_money'] < $data['coin']){
                return Json::fail('可上分余额不足');
            }
        }

        $adminId = $this->adminId;
        $data['admin_id'] = $adminId;
        $data['updatetime'] = time();
        $userinfo = Db::name('userinfo')->where('uid',$data['uid'])->find();
        if(!$userinfo){
            Json::fail('请输入正确的用户ID');
        }
        $data['package_id'] = $userinfo['package_id'];
        $data['channel'] = $userinfo['channel'];
        if($data['coin'] <= 0 ){
            Json::fail('抱歉操作金额必须大于0');
        }
        if($data['remark'] == ''){
            Json::fail('备注不能为空');
        }

        Db::startTrans();
        $type = $data['type'] ?: 1;
        unset($data['type']);
        if($data['coin_type'] == 1){
            $data['coin'] = $type == 1 ? (int)$data['coin'] : (int)bcsub(0,$data['coin'],0);
        }
        $res = Db::name($this->tablename)->insert($data);

        if (!$res) {
            Db::rollback();
            return Json::fail('改款添加失败');
        }
        if($data['money_type'] == 1){
            $res = $this->addCash($data,$userinfo);
        }elseif ($this->adminInfo['type'] != 1 && $data['money_type'] == 2){
            $res = $this->addBonus($data,$userinfo);
        }
        if($res != 200){
            Db::rollback();
            return Json::fail($res);
        }

        Db::commit();
        return Json::success('成功');
    }

    private function addBonus($data,$userinfo){

        $res = Db::name('userinfo')->where('uid',$data['uid'])
            ->update([
                'updatetime' => time(),
                'bonus' => Db::raw('bonus + '.$data['coin']),
                'get_bonus' => Db::raw('get_bonus + '.$data['coin']),
            ]);
        if(!$res){
            return '用户加钱修改失败';
        }


        Db::name('bonus_'.date('Ymd'))
            ->insert([
                'uid' => $data['uid'],
                'num' => $data['coin'],
                'total' => bcadd((string)$userinfo['coin'],(string)$data['coin'],0),
                'reason' => 18,
                'type' => $data['coin'] > 0 ? 1 : 0,
                'content' => "后台手动加款".bcdiv($data['coin'],100,2),
                'channel' => $userinfo['channel'],
                'package_id' => $userinfo['package_id'],
                'createtime' => time(),
            ]);
        return 200;

    }

    private function addCash($data,$userinfo){


        Db::startTrans();
        try {

            //gm
            if ($data['coin_type'] == 1) {
                if ($this->adminInfo['type'] == 1) {
                    $res = $this->setQdSend($data, $userinfo);
                }else{
                    $res = $this->setSend($data, $userinfo);
                }
            } else {
                $res = $this->setOrder($data, $userinfo);
            }
            if($res != 200)return $res;
            //打标签
            if ($this->adminInfo['type'] == 1){
                $struser = Db::name('share_strlog')->where('uid',$userinfo['uid'])->find();
                if (empty($struser)) return '用户异常';
                $old_tagarr = explode(",",$struser['tag']);
                if (empty($struser['tag'])){
                    $tag = 1;
                } elseif (!in_array(1,$old_tagarr)){
                    $tag = $struser['tag'].',1';
                }else{
                    $tag = $struser['tag'];
                }
                Db::name('share_strlog')->where('uid',$userinfo['uid'])->update(['tag'=>$tag]);

                //管理员分钱额度减掉
                $put_money = $this->adminInfo['put_money'] - $data['coin'];
                Db::name('system_admin')->where('id',$this->adminInfo['id'])->update(['put_money'=>$put_money]);

                //标记为网红
                Db::name('share_strlog')->where('uid',$data['uid'])->update(['is_red'=>1]);

            }elseif ($this->adminInfo['roles'] == 8){
                //管理员分钱额度减掉
                $put_money = $this->adminInfo['put_money'] - $data['coin'];
                Db::name('system_admin')->where('id',$this->adminInfo['id'])->update(['put_money'=>$put_money]);
            }


            Db::commit();
            return 200;
        }catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error('TopSend fail==>'.$exception->getMessage());
            Db::rollback();
            return $exception->getMessage();
        }
    }

    private function setSend($data,$userinfo){

        $res = Db::name('userinfo')->where('uid',$data['uid'])
            ->update([
                'updatetime' => time(),
                'coin' => Db::raw('coin + '.$data['coin']),
            ]);
        if(!$res){
            return '用户加钱修改失败';
        }


        Db::name('coin_'.date('Ymd'))
            ->insert([
                'uid' => $data['uid'],
                'num' => $data['coin'],
                'total' => bcadd((string)$userinfo['coin'],(string)$data['coin'],0),
                'reason' => 18,
                'type' => $data['coin'] > 0 ? 1 : 0,
                'content' => "后台手动加款".bcdiv($data['coin'],100,2),
                'channel' => $userinfo['channel'],
                'package_id' => $userinfo['package_id'],
                'createtime' => time(),
            ]);
        return 200;
    }

    /**
     * 渠道加钱
     * @param $uid
     * @param $money
     * @return void
     */
    private function setQdSend($data,$userinfo){

        $res = Db::name('userinfo')->where('uid',$data['uid'])
            ->update([
                'updatetime' => time(),
                'coin' => Db::raw('coin + '.$data['coin']),
                'withdraw_money_other' => Db::raw('withdraw_money_other + '.$data['coin']),
                'total_pay_num' => Db::raw('total_pay_num + 1'),
                'first_pay_score' => Db::raw('first_pay_score + '.'1'),
                'total_pay_score' => Db::raw('total_pay_score + '.'1'),
            ]);
        if(!$res){
            return '用户加钱修改失败';
        }


        Db::name('coin_'.date('Ymd'))
            ->insert([
                'uid' => $data['uid'],
                'num' => $data['coin'],
                'total' => bcadd((string)$userinfo['coin'],(string)$data['coin'],0),
                'reason' => 18,
                'type' => $data['coin'] > 0 ? 1 : 0,
                'content' => "后台渠道加钱".bcdiv($data['coin'],100,2),
                'channel' => $userinfo['channel'],
                'package_id' => $userinfo['package_id'],
                'createtime' => time(),
            ]);
        return 200;
    }


    private function setOrder($data,$userinfo){

        $first_pay_score = $userinfo['first_pay_score'] <= 0 ? $data['coin'] : 0;
        $res = Db::name('userinfo')->where('uid',$data['uid'])
            ->update([
                'total_pay_num' => Db::raw('total_pay_num + 1'),
                'first_pay_score' => Db::raw('first_pay_score + '.$first_pay_score),
                'total_pay_score' => Db::raw('total_pay_score + '.$first_pay_score),
                'updatetime' => time(),
                'coin' => Db::raw('coin + '.$data['coin']),
            ]);
        if(!$res){
            return '用户充值次数修改失败';
        }


        Db::name('coin_'.date('Ymd'))
            ->insert([
                'uid' => $data['uid'],
                'num' => $data['coin'],
                'total' => bcadd((string)$userinfo['coin'],(string)$data['coin'],0),
                'reason' => 18,
                'type' => $data['coin'] > 0 ? 1 : 0,
                'content' => "手动充值".$data['uid']."充值".$data['coin'].",到账".bcdiv($data['coin'],100,2),
                'channel' => $userinfo['channel'],
                'package_id' => $userinfo['package_id'],
                'createtime' => time(),
            ]);

        return 200;
    }
}


