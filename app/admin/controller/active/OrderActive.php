<?php

namespace app\admin\controller\active;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  充值活动列表
 */
class OrderActive extends AuthController
{

    private $table = 'order_active';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){

        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 100;

        $filed = "*";

        $orderfield = "id";
        $sort = "desc";


        $data = Model::Getdata($this->table,$filed,$data,$orderfield,$sort,$page,$limit);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }



    public function edit($id = 0){
        $active = Db::name($this->table)->where('id',$id)->find();

        if(!$active){
            Json::fail('参数错误!');
        }

        $f[] = Form::input('name', '中文名称',$active['name']);

        $f[] = Form::uploadImageOne('image', 'Banner名称',url('widget.Image/file',['file'=>'image']),$active['image']);

        $f[] = Form::input('price', '支付金额(分)',$active['price']);
        $f[] = Form::input('get_cash', '立刻得到的Cash(分)',$active['get_cash']);
        $f[] = Form::input('get_bonus', '立刻得到的Bonus(分)',$active['get_bonus']);
        $f[] = Form::input('next_get_cash', '第二次/赠送得到的Cash(分)',$active['next_get_cash']);
        if($active['type'] == 7){
            $f[] = Form::input('piggy_money', '存钱罐累计存钱金额(分)',$active['piggy_money']);
        }else{
            $f[] = Form::input('next_get_bonus', '第二次得到的Bonus(分)',$active['next_get_bonus']);
            $f[] = Form::input('last_get_cash', '最后一次得到的Cash(分)',$active['last_get_cash']);
            $f[] = Form::input('last_get_bonus', '最后一次得到的Bonus(分)',$active['last_get_bonus']);
            $f[] = Form::input('min_order_price', '历史充值最小金额(分)',$active['min_order_price']);
            $f[] = Form::input('max_order_price', '历史充值最大金额(分)',$active['max_order_price']);
            $f[] = Form::input('lose_water_multiple', '流水倍数低于多少倍',$active['lose_water_multiple']);
            $f[] = Form::input('high_water_multiple', '流水倍数高于多少倍',$active['high_water_multiple']);
            $f[] = Form::input('withdraw_bili', '退款比例低于多少',$active['withdraw_bili']);
            $f[] = Form::input('lose_money', '余额低于多少',$active['lose_money']);
            $f[] = Form::input('customer_money', '客损金额大于多少',$active['customer_money']);
            $f[] = Form::input('num', '参与次数',$active['num']);
        }


        $currency_and_ratio = Db::name('currency_and_ratio')->field('id,name')->select()->toArray();
        $f[] = Form::select('currency','货币类型',$active['currency'])->setOptions(function () use ($currency_and_ratio){
            $menus = [];
            foreach ($currency_and_ratio as $menu) {
                $menus[] = ['value' => $menu['name'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);


        if($active['type'] == 2){
            $f[] = Form::input('day', '连续领取多少天',$active['num']);
        }elseif ($active['type'] == 1){
            $f[] = Form::input('active_tage_hour', '标记多少小时后不能参加该活动ID	',$active['active_tage_hour']);
        }
//        $f[] = Form::radio('user_type', '用户类型', $active['user_type'])->options([['label' => '广告', 'value' => 1],['label' => '自然', 'value' => 2],['label' => '分享', 'value' => 3]]);
//        $f[] = Form::radio('type', '活动类型', $active['type'])->options([['label' => '3天卡', 'value' => 1],['label' => '月卡', 'value' => 2]]);
        $f[] = Form::radio('status', '是否开启', $active['status'])->options([['label' => '开启', 'value' => 1],['label' => '关闭', 'value' => 0]]);

        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($id){

        $data = request()->post();

        if($id > 0){

            $res = Db::name($this->table)->where('id','=',$id)->update($data);
            if(!$res){
                Json::fail('编辑失败');
            }

        }
        return Json::successful($id > 0 ? '修改成功!' : '添加成功!');

    }

    /**
     * 配置的json数据针对不同活动的不同配置
     * @param $f  表格f
     * @param $config
     * @return void
     */
    public function config(&$f,$config){
        $config_array = json_decode($config,true);
        foreach ($config_array as $v){
            if($v['tage'] == 'input'){
                $f[] = Form::input('config['.$v['name'].']', $v['childname'] ? $v['title'].'('.$v['childname'].')' : $v['title'],$v['value'])->type($v['type'])->placeholder($v['remark']);
            }
        }
        return $f;
    }


    /**
     * 修改数据是将config数组转为
     * @return void 将配置文件
     * @param $json 修改数据的json字符串
     * @param  $config 后台修改的config默认值
     */
    public function configjson($json,$config){
        $config_array = json_decode($json,true);
        foreach ($config_array as &$v){
            $v['value'] = $config[$v['name']] ?? $v['value'];
        }
        return json_encode($config_array);
    }

    /**
     * @return void 修改状态
     */
    public function is_show(){
        $data =  request()->param();
        Db::name($this->table)->where('id',$data['id'])->update([$data['field'] => $data['value']]);

        return Json::successful('修改成功!');
    }
}

