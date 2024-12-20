<?php

namespace app\admin\controller\operate;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  渠道管理列表
 */
class Chanel extends AuthController
{


    private $tablename = 'chanel';

    public function index($id = 0)
    {

        $this->assign('package_id',$id);
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $tablename = $this->tablename;
        $filed = "FROM_UNIXTIME(a.updatetime,'%Y-%m-%d %H:%i:%s') as updatetime,a.channel,a.ctag,a.cname,b.real_name,a.package_id,a.remark,a.type,a.appname";

        $orderfield = "a.updatetime";
        $sort = "desc";
        $join = ['system_admin b','b.id = a.admin_id'];
        $alias = 'a';
        $date = 'a.createtime';

        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left');

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    /**
     * @return void 添加
     */
    public function add($package_id)
    {

        $apppackage = Db::name('apppackage')->field('bagname,id')->select()->toArray();
        $f = array();
//        $f[] = Form::input('cid', '渠道ID');
        $f[] = Form::select('package_id','包名',(string)$package_id)->setOptions(function () use ($apppackage){
            $menus = [];
            foreach ($apppackage as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['bagname']];
            }
            return $menus;
        })->filterable(1)->disabled(true);
        $f[] = Form::input('ctag', '广告码');
        $f[] = Form::input('cname', '渠道名称');
        $f[] = Form::textarea('remark', '备注');



        $form = Form::make_post_form('添加数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function edit($channel = 0){
        $apppackage = Db::name('apppackage')->field('bagname,id')->select()->toArray();
        $chanel = Db::name('chanel')->where('channel',$channel)->find();
        if(!$chanel){
            Json::fail('渠道获取失败!');
        }
        $f = array();
        $f[] = Form::input('channel', '渠道ID',$chanel['channel'])->disabled(true);
        $f[] = Form::select('package_id','包名',(string)$chanel['package_id'])->setOptions(function () use ($apppackage){
            $menus = [];
            foreach ($apppackage as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['bagname']];
            }
            return $menus;
        })->filterable(1)->disabled(true);
        $f[] = Form::input('ctag', '广告码',$chanel['ctag']);
        $f[] = Form::input('cname', '渠道名称',$chanel['cname']);
        $f[] = Form::textarea('remark', '备注',$chanel['remark']);
        $form = Form::make_post_form('修改数据', $f, url('save',['channel' => $channel]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($channel=0){
        $adminId = $this->adminId;

        $data = request()->post();
        $data['admin_id'] = $adminId;
        $data['updatetime'] = time();
        $data['appname'] = Db::name('apppackage')->where('id',$data['package_id'])->value('appname');
        $data['ppackage_id'] = $data['package_id'];
        if($channel > 0){
            $res = Db::name($this->tablename)->where('channel',$channel)->update($data);
        }else{
            //获取上个包的主渠道
            $olecid =Db::name('chanel')->where(['use_type' => 0,'level' => 1,'package_id' => $data['package_id']])->order('channel','desc')->value('channel');
            $data['channel'] = $olecid + 10;
            $res = Db::name($this->tablename)->insert($data);
        }
        if(!$res){
            Json::fail('添加失败');
        }
        return Json::successful($channel > 0 ? '修改成功!' : '添加成功!');
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
     * @return void 删除数据
     */
    public function delete($id = ''){
        $channel = Db::name($this->tablename)->field('type')->where('id',$id)->find();
        if($channel['type'] == 1 || $channel['type'] == 2){
            return Json::fail('默认渠道不能删除');
        }
        $res = Db::name($this->tablename)->where('id',$id)->delete();

        if(!$res){
            return Json::fail('删除失败');
        }
        return Json::successful('删除成功!');
    }


    public function ChannelPoint($channel,$type,$appname){
        if(!$channel  || !$appname)return Json::fail('缺少参数');
        $reallyChannel = $type == 0 ? $channel : $appname;
        $channel_point = Db::name('channel_point')->where('channel',$reallyChannel)->find();

        $f[] = Form::input('channel', '包或者渠道',$reallyChannel)->disabled(true);
        $f[] = Form::input('ad_first_purchase', 'Adjust-firstPurchase',$channel_point['ad_first_purchase'] ?? '');
        $f[] = Form::input('ad_purchase', 'Adjust-purchase',$channel_point['ad_purchase'] ?? '');
        $f[] = Form::input('ad_todayfirst_purchase', 'Adjust-todayfirstPurchase',$channel_point['ad_todayfirst_purchase'] ?? '');
        $f[] = Form::input('ad_complete_registration', 'Adjust-completeRegistration',$channel_point['ad_complete_registration'] ?? '');
        $f[] = Form::input('ad_key', 'Adjust应用码',$channel_point['ad_key'] ?? '');
        $f[] = Form::input('fb_pixel_id', 'Fb-pixel_Id',$channel_point['fb_pixel_id'] ?? '');
        $f[] = Form::input('fb_token', 'Fb-Token',$channel_point['fb_token'] ?? '');
        $form = Form::make_post_form('修改数据', $f, url('setChannelPoint'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    public function setChannelPoint(){
        $data =  request()->param();
        $channel_point = Db::name('channel_point')->where('channel',$data['channel'])->find();
        if($channel_point){
            $res = Db::name('channel_point')->where('channel',$data['channel'])->update($data);
//            Json::fail('修改失败');
        }else{
            $res = Db::name('channel_point')->insert($data);
        }
        if(!$res){
            return Json::fail('删除失败');
        }
        return Json::successful('修改成功!');
    }


    public function AdChannel($channel,$package_id){
        $adjust_network_config = Db::name('adjust_network_config')->where('channel',$channel)->find();
        $f[] = Form::input('package_id', '包ID',$package_id)->disabled(true);
        $f[] = Form::input('channel', '渠道号',$channel)->disabled(true);
        $f[] = Form::input('network', 'Ad渠道名',$adjust_network_config['network'] ?? '');
        $f[] = Form::input('name', '备注',$adjust_network_config['name'] ?? '');
        $form = Form::make_post_form('修改数据', $f, url('AdChannelSave'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    public function AdChannelSave($package_id,$network,$name,$channel){

        $res = Db::name('adjust_network_config')->replace()->insert(['channel' => $channel,'package_id' => $package_id,'name' => $name,'network' => $network]);
        if(!$res){
            return Json::fail('添加失败');
        }
        return Json::successful('添加成功!');
    }

}


