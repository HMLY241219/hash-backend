<?php

namespace app\admin\controller\operate;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  包名管理列表
 */
class Apppackage extends AuthController
{


    private $tablename = 'apppackage';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $tablename = $this->tablename;
        $filed = "a.id,FROM_UNIXTIME(a.updatetime,'%Y-%m-%d %H:%i:%s') as updatetime,a.hide,a.bagname,a.appname,a.remark1,b.real_name,a.type,a.is_genuine_gold,a.cashgame_status,a.pullingame_status,a.gps_status";

        $orderfield = "a.id";
        $sort = "desc";
        $join = ['system_admin b','b.id = a.admin_id'];
        $alias = 'a';
        $date = 'a.createtime';

        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left',[['a.status','=',1]]);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    public function edit($id = 0){
        $banner = Db::name($this->tablename)->where('id',$id)->find();
        if(!$banner){
            Json::fail('参数错误!');
        }

        $f = array();
        $f[] = Form::input('id', '包ID',$banner['id'])->readonly(true);
        $f[] = Form::input('appname', '包名',$banner['appname'])->readonly(true);
        $f[] = Form::input('bagname', '包中文名',$banner['bagname']);
        $f[] = Form::radio('type', '类型', $banner['type'])->options([['label' => '主包', 'value' => 1], ['label' => '分享包', 'value' => 2]]);

        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($id=0){
        $adminId = $this->adminId;

        $data = request()->post();
        $data['admin_id'] = $adminId;
        $data['updatetime'] = time();
        if($id > 0){
            $res = Db::name($this->tablename)->where('id',$id)->update($data);
        }else{
            $res = Db::name($this->tablename)->insert($data);
        }
        if(!$res){
            Json::fail('添加失败');
        }
        return Json::successful($id > 0 ? '修改成功!' : '添加成功!');
    }


    public function config($id = 0){
        $config = Db::name($this->tablename)
            ->alias('a')
            ->field('a.appname,b.*')
            ->leftJoin('apppackage_config b','a.id = b.package_id')
            ->where('a.id',$id)
            ->find();
        if(!$config){
            Json::fail('参数错误!');
        }
        $pay_type = Db::name('pay_type')->field('id,name')->select()->toArray();
        $withdraw_type = Db::name('withdraw_type')->field('id,name')->select()->toArray();
        $f = array();
        $f[] = Form::input('appname', '包名',$config['appname'])->readonly(true);

        $f[] = Form::input('with_money_config', '退款默认金额配置(以英文|分隔)(卢比分)',$config['with_money_config']);
        $f[] = Form::input('order_money_config', '普通充值金额与赠送bouns比例配置(金额和bouns以-为一组, 然后以|分隔单位:卢比分)',$config['order_money_config']);
//        $f[] = Form::input('first_cash_money', '首次充值金额与赠送cash比例配置(金额和cash以-为一组, 然后以|分隔单位:卢比分)',$config['first_cash_money']);
        if($config['pay_type_ids'])$config['pay_type_ids'] = explode(',',$config['pay_type_ids']);
        $f[] = Form::select('pay_type_ids','支付渠道',$config['pay_type_ids'])->setOptions(function () use ($pay_type){
            $menus = [];
            foreach ($pay_type as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1)->multiple(true);
        if($config['withdraw_type_ids'])$config['withdraw_type_ids'] = explode(',',$config['withdraw_type_ids']);
        $f[] = Form::select('withdraw_type_ids','退款渠道',$config['withdraw_type_ids'])->setOptions(function () use ($withdraw_type){
            $menus = [];
            foreach ($withdraw_type as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1)->multiple(true);
        $f[] = Form::radio('sendmoney_status', '是否允许参与普通充值活动:0=否,1=是',$config['sendmoney_status'])->options([['label' => '是', 'value' => 1], ['label' => '否', 'value' => 0]]);
        $form = Form::make_post_form('修改数据', $f, url('config_save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    /**
     * @return void 存储数据
     */
    public function config_save($id=0){
        $adminId = $this->adminId;

        $data = request()->post();
        $data['updatetime'] = time();
        $res = Db::name($this->tablename)->where('id',$id)->update(['admin_id' => $adminId,'updatetime' => time()]);
        if(!$res){
            Json::fail('修改失败');
        }

        if(isset($data['pay_type_ids'])){
            $data['pay_type_ids'] = implode(',',$data['pay_type_ids']);
        }else{
            $data['pay_type_ids'] = '';
        }


        if(isset($data['withdraw_type_ids'])){
            $data['withdraw_type_ids'] = implode(',',$data['withdraw_type_ids']);
        }else{
            $data['withdraw_type_ids'] = '';
        }
        $apppackage_config = Db::name('apppackage_config')->where('package_id',$id)->find();
        if($apppackage_config){
            Db::name('apppackage_config')->where('package_id',$id)->update($data);
        }else{
            $data['package_id'] = $id;
            Db::name('apppackage_config')->insert($data);
        }

        return Json::successful('配置成功!');
    }

    /**
     * @return null
     */
    public function layuiedit(){
        $data =  request()->param();
        $res = Model::layuiedit($this->tablename,$data,'id');
        if($res['code'] != 200){
            return Json::fail('修改失败');

        }
        return Json::successful('修改成功!');
    }


    /**
     * @return void 修改状态
     */
    public function is_show(){
        $data =  request()->param();
        $res = Model::is_show($this->tablename,$data,'id',$this->adminId);
        if($res['code'] != 200){
            return Json::fail('修改失败');

        }
        return Json::successful('修改成功!');
    }



    public function create_app(){

        $f = array();
        $f[] = Form::input('package', '包名');
        $f[] = Form::input('package_end', '包名后缀');
        $f[] = Form::input('package_name', '游戏名');

        $form = Form::make_post_form('修改数据', $f, url('save_create_app'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }



    /**
     * @return 提包创建配置
     */
    public function save_create_app($package,$package_end,$package_name){
//        $package      = 'com.win3377.amzingAD';  //包名com.win3377.sharewin
//        $package_end  = 'amzingAD';  //包名后缀
//        $package_name = 'amzingAD线上包'; //括号后面就是游戏名

        Db::startTrans();
        $apppackage = Db::name('apppackage')->where('appname','like','%'.$package_end)->find();
        if($apppackage){
            Db::rollback();
            return Json::fail('包名后缀已使用');
        }

        //增加包名
        $package_id = Db::name('apppackage')->insertGetId(['bagname' => $package_name,'appname' => $package, 'hide' => 1,'cashgame_status' => 0]);
        if(!$package_id){
            Db::rollback();
            return Json::fail('包名已使用');
        }

        $apppackage_config = [
            'package_id' => $package_id,
            'appname' => $package,
            'updatetime' => time(),
        ];

        $res = Db::name('apppackage_config')->insert($apppackage_config);
        if(!$res){
            Db::rollback();
            return Json::fail('包配置失败');
        }

        //获取上个包的主渠道
        $olecid =Db::name('chanel')->where(['type' => 1,'level' => 1])->order('channel','desc')->value('channel');
        $cid = $olecid + 10000;

        $chanel = [
            'channel' => $cid,
            'cname' => $package_name.'自然量默认渠道',
            'appname' => $package,
            'package_id' => $package_id,
            'ppackage_id' => $package_id,
            'updatetime' => time(),
            'remark' => '提包系统生成',
            'type' => 1,
        ];
        $res = Db::name('chanel')->insert($chanel);
        if(!$res){
            Db::rollback();
            return Json::fail('默认主渠道生成失败');
        }

        $cid = $cid + 10;

        $chanel = [
            'channel' => $cid,
            'cname' => $package_name.'广告默认渠道',
            'appname' => $package,
            'package_id' => $package_id,
            'ppackage_id' => $package_id,
            'updatetime' => time(),
            'remark' => '提包系统生成',
            'type' => 2,
        ];
        $res = Db::name('chanel')->insert($chanel);
        if(!$res){
            Db::rollback();
            return Json::fail('默认主渠道生成失败');
        }
        Db::commit();
        return Json::successful('包配置成功!');
    }


    public function Adapp($id){
        $adjust_app_config = Db::name('adjust_app_config')->where('package_id',$id)->find();
        $f[] = Form::input('id', '包ID',$id)->disabled(true);
        $f[] = Form::input('app', 'Ad应用名',$adjust_app_config['app'] ?? '');
        $f[] = Form::input('name', '备注',$adjust_app_config['name'] ?? '');
        $form = Form::make_post_form('修改数据', $f, url('AdappSave',['package_id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function AdappSave($package_id,$app,$name){

        $res = Db::name('adjust_app_config')->replace()->insert(['package_id' => $package_id,'app' => $app,'name' => $name]);
        if(!$res){
            return Json::fail('添加失败');
        }
        return Json::successful('添加成功!');
    }
}

