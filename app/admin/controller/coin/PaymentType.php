<?php

namespace app\admin\controller\coin;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  支付方式配置
 */
class PaymentType extends AuthController
{

    private $table = 'payment_type';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){

        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;

        $filed = "*";

        $orderfield = "ht_weight";
        $sort = "desc";


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    public function add(){


        $f[] = Form::input('name', '名称');

        $f[] = Form::uploadImageOne('image', '图片',url('widget.Image/file',['file'=>'image']));
        $currency_and_ratio = Db::name('currency_and_ratio')->field('id,name')->select()->toArray();
        $f[] = Form::select('currency','货币类型','VND')->setOptions(function () use ($currency_and_ratio){
            $menus = [];
            foreach ($currency_and_ratio as $menu) {
                $menus[] = ['value' => $menu['name'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);
        $f[] = Form::number('weight', '权重');
        $f[] = Form::number('ht_weight', '后台权重');
        $f[] = Form::input('zs_bili', '人工充值显示赠送比例填2个比例(首充|复充)');
        $f[] = Form::input('first_zs_bonus_bili', '首充赠送Bonus(区间用-分隔，赠送用|分隔，每一组用空格分隔)');
        $f[] = Form::input('zs_bonus_bili', '复充赠送Bonus(区间用-分隔，赠送用|分隔，每一组用空格分隔)');
        $f[] = Form::input('url', '人工链接');
        $f[] = Form::radio('type', '是否开启', 1)->options([['label' => '普通充值', 'value' => 1],['label' => '数字货币', 'value' => 2],['label' => '人工充值', 'value' => 3],['label' => '钱包充值', 'value' => 4]]);
        $f[] = Form::radio('status', '是否开启', 1)->options([['label' => '开启', 'value' => 1],['label' => '关闭', 'value' => 0]]);
        $f[] = Form::input('remark', '备注');
        $form = Form::make_post_form('修改数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }



    public function edit($id = 0){
        $active = Db::name($this->table)->where('id',$id)->find();

        if(!$active){
            Json::fail('参数错误!');
        }

        $f[] = Form::input('name', '名称',$active['name']);

        $f[] = Form::uploadImageOne('image', '图片',url('widget.Image/file',['file'=>'image']),$active['image']);

        $currency_and_ratio = Db::name('currency_and_ratio')->field('id,name')->select()->toArray();
        $f[] = Form::select('currency','货币类型',$active['currency'])->setOptions(function () use ($currency_and_ratio){
            $menus = [];
            foreach ($currency_and_ratio as $menu) {
                $menus[] = ['value' => $menu['name'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);

        $f[] = Form::number('weight', '权重',$active['weight']);
        $f[] = Form::number('ht_weight', '后台权重',$active['ht_weight']);
        $f[] = Form::input('zs_bili', '人工充值显示赠送比例填2个比例(首充|复充)',$active['zs_bili']);
        $f[] = Form::input('first_zs_bonus_bili', '首充赠送Bonus(区间用-分隔，赠送用|分隔，每一组用空格分隔)',$active['first_zs_bonus_bili']);
        $f[] = Form::input('zs_bonus_bili', '复充赠送Bonus(区间用-分隔，赠送用|分隔，每一组用空格分隔)',$active['zs_bonus_bili']);

        if($active['type'] == 2){
            $digital_currency_protocol = Db::name('digital_currency_protocol')->field('id,name')->select()->toArray();
            if($active['protocol_ids'])$active['protocol_ids'] = explode(',',$active['protocol_ids']);
            $f[] = Form::select('protocol_ids','协议类型',$active['protocol_ids'])->setOptions(function () use ($digital_currency_protocol){
                $menus = [];
                foreach ($digital_currency_protocol as $menu) {
                    $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
                }
                return $menus;
            })->filterable(1)->multiple(true);
        }


        $f[] = Form::input('url', '人工链接',$active['url']);
        $f[] = Form::radio('type', '是否开启', $active['type'])->options([['label' => '普通充值', 'value' => 1],['label' => '数字货币', 'value' => 2],['label' => '人工充值', 'value' => 3],['label' => '钱包充值', 'value' => 4]]);
        $f[] = Form::radio('status', '是否开启', $active['status'])->options([['label' => '开启', 'value' => 1],['label' => '关闭', 'value' => 0]]);
        $f[] = Form::input('remark', '备注',$active['remark']);
        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($id = 0){

        $data = request()->post();


        if(isset($data['protocol_ids'])){
            $data['protocol_ids'] = implode(',',$data['protocol_ids']);
        }else{
            $data['protocol_ids'] = '';
        }

        if($id > 0){

            $res = Db::name($this->table)->where('id','=',$id)->update($data);
            if(!$res){
                Json::fail('编辑失败');
            }

        }else{
            $res = Db::name($this->table)->insert($data);
            if(!$res){
                Json::fail('添加失败');
            }
        }
        return Json::successful($id > 0 ? '修改成功!' : '添加成功!');

    }


    /**
     * @return void 修改状态
     */
    public function is_show(){
        $data =  request()->param();
        Db::name($this->table)->where('id',$data['id'])->update(['status' => $data['status']]);

        return Json::successful('修改成功!');
    }


    /**
     * @return void 删除数据
     */
    public function delete($id = ''){
        $res = Db::name($this->table)->where('id',$id)->delete();

        if(!$res){
            return Json::fail('删除失败');
        }
        return Json::successful('删除成功!');
    }
}


