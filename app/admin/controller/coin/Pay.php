<?php

namespace app\admin\controller\coin;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  充值渠道管理
 */
class Pay extends AuthController
{



    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();

        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;



        $tablename = "pay_type";
        $filed = "a.id,a.send_bili,FROM_UNIXTIME(a.updatetime,'%Y-%m-%d %H:%i:%s') as updatetime,a.icon ,a.name,b.real_name as admin_id,a.weight,a.minmoney,a.maxmoney,a.fee_money,a.fee_bili,a.status,a.englishname,a.wake_status,a.is_specific_channel,a.ht_weight,a.video_url";
        $orderfield = "a.ht_weight";
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
    public function add()
    {
        $f = array();
        $f[] = Form::input('name', '渠道名称')->disabled(true);
        $f[] = Form::input('englishname', '客户端昵称');
//        $f[] = Form::uploadImageOne('icon', 'logo');

        $currency_and_ratio = Db::name('currency_and_ratio')->field('id,name')->where('type',1)->select()->toArray();
        $f[] = Form::select('currency','货币类型')->setOptions(function () use ($currency_and_ratio){
            $menus = [];
            foreach ($currency_and_ratio as $menu) {
                $menus[] = ['value' => $menu['name'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);

        $f[] = Form::uploadImageOne('icon', 'logo',url('widget.Image/file',['file'=>'icon']));
        $f[] = Form::input('minmoney', '充值最小金额(雷亚尔分)');
        $f[] = Form::input('maxmoney', '充值最大金额(雷亚尔分)');
        $f[] = Form::input('fee_bili', '手续费(比例0.01=1%)');
        $f[] = Form::input('fee_money', '手续费(固定值雷亚尔分)');
        $f[] = Form::input('send_bili', '额外赠送(比例0.01=1%)');
        $f[] = Form::input('weight', '权重');
        $f[] = Form::input('video_url', '视频链接');
        $f[] = Form::radio('is_specific_channel', '是否是特定通道', 0)->options([['label' => '是', 'value' => 1], ['label' => '否', 'value' => 0]]);
        $f[] = Form::radio('status', '状态', 1)->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);


        $form = Form::make_post_form('添加数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }


    /**
     * @return void 修改
     */
    public function edit($id = ''){
        $pay_type = Db::name('pay_type')->where('id',$id)->find();
        if(!$pay_type){
            Json::fail('参数错误!');
        }

        $payment_type = Db::name('payment_type')->field('id,name')->where('type','<>',3)->select()->toArray();

        $f[] = Form::input('name', '渠道名称',$pay_type['name'])->disabled(true);
        $f[] = Form::input('englishname', '客户端昵称',$pay_type['englishname']);
//        $f[] = Form::uploadImageOne('icon', 'logo');
        if($pay_type['payment_ids'])$pay_type['payment_ids'] = explode(',',$pay_type['payment_ids']);
        $f[] = Form::select('payment_ids','支付方式',$pay_type['payment_ids'])->setOptions(function () use ($payment_type){
            $menus = [];
            foreach ($payment_type as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1)->multiple(true);

        $currency_and_ratio = Db::name('currency_and_ratio')->field('id,name')->where('type',1)->select()->toArray();
        $f[] = Form::select('currency','货币类型',$pay_type['currency'])->setOptions(function () use ($currency_and_ratio){
            $menus = [];
            foreach ($currency_and_ratio as $menu) {
                $menus[] = ['value' => $menu['name'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);


        $f[] = Form::uploadImageOne('icon', 'logo',url('widget.Image/file',['file'=>'icon']),$pay_type['icon']);
        $f[] = Form::input('minmoney', '充值最小金额(雷亚尔分)',$pay_type['minmoney']);
        $f[] = Form::input('maxmoney', '充值最大金额(雷亚尔分)',$pay_type['maxmoney']);
        $f[] = Form::input('fee_bili', '手续费(比例0.01=1%)',$pay_type['fee_bili']);
        $f[] = Form::input('fee_money', '手续费(固定值雷亚尔分)',$pay_type['fee_money']);
        $f[] = Form::input('send_bili', '额外赠送(比例0.01=1%)',$pay_type['send_bili']);
        $f[] = Form::input('weight', '权重',$pay_type['weight']);
        $f[] = Form::input('ht_weight', '后台权重排序',$pay_type['ht_weight']);
        $f[] = Form::input('video_url', '视频链接',$pay_type['video_url']);
        $f[] = Form::radio('is_specific_channel', '是否是特定通道', $pay_type['is_specific_channel'])->options([['label' => '是', 'value' => 1], ['label' => '否', 'value' => 0]]);
        $f[] = Form::radio('status', '状态', $pay_type['status'])->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);

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
        if(isset($data['payment_ids'])){
            $data['payment_ids'] = implode(',',$data['payment_ids']);
        }else{
            $data['payment_ids'] = '';
        }

        if($id > 0){
            $data['updatetime'] = time();
            $res = Db::name('pay_type')->where('id',$id)->update($data);
        }else{
            $data['updatetime'] = time();
            $data['createtime'] = time();
            $res = Db::name('pay_type')->insert($data);
        }
        if(!$res){
            Json::fail('添加失败');
        }
        return Json::successful($id > 0 ? '修改成功!' : '添加成功!');
    }


    /**
     * @return void 修改状态
     */
    public function is_show(){
        $adminId = $this->adminId;
        $id = request()->post('id');
        $data['status'] = request()->post('status');
        $data['admin_id'] = $adminId;
        $data['updatetime'] = time();

        $res = Db::name('pay_type')->where('id',$id)->update($data);
        if(!$res){
            return Json::fail('修改失败2');
        }
        return Json::successful('修改成功!');

    }


    /**
     * @return void 删除数据
     */
    public function delete($id = ''){
        $res = Db::name('pay_type')->where('id',$id)->delete();

        if(!$res){
            return Json::fail('删除失败');
        }
        return Json::successful('删除成功!');
    }
}

