<?php

namespace app\admin\controller\active;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  破产转盘配置
 */
class BankruptcyWheel extends AuthController
{

    private $table = 'bankruptcy_wheel';

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

    public function add(){

        $f[] = Form::input('minmoney', '充值最低金额(分)');
        $f[] = Form::input('maxmoney', '充值最大金额(分)');
        $f[] = Form::input('amount_config', '奖励配置(分)');
        $f[] = Form::input('probability_config', '概率配置(小数)');
        $f[] = Form::input('currency_config', '货币配置(1=C,2=B)');
        $f[] = Form::input('image_config', '图片配置(0=奖励直接显示,1=C,2=B,3=哭)');
        $f[] = Form::input('zs_pay_bili', '每轮总赠送多少比例');




        $form = Form::make_post_form('修改数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function edit($id = 0){
        $active = Db::name($this->table)->where('id',$id)->find();

        if(!$active){
            Json::fail('参数错误!');
        }


        $f[] = Form::input('minmoney', '充值最低金额(分)',$active['minmoney']);
        $f[] = Form::input('maxmoney', '充值最大金额(分)',$active['maxmoney']);
        $f[] = Form::input('amount_config', '奖励配置(分)',$active['amount_config']);
        $f[] = Form::input('probability_config', '概率配置(小数)',$active['probability_config']);
        $f[] = Form::input('currency_config', '货币配置(1=C,2=B)',$active['currency_config']);
        $f[] = Form::input('image_config', '图片配置(0=奖励直接显示,1=C,2=B,3=哭)',$active['image_config']);
        $f[] = Form::input('zs_pay_bili', '每轮总赠送多少比例',$active['zs_pay_bili']);


        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($id = 0){

        $data = request()->post();

        if($id > 0){
            $res = Db::name($this->table)->where('id',$id)->update($data);
        }else{
            $res = Db::name($this->table)->insert($data);
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

