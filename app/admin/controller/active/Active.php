<?php

namespace app\admin\controller\active;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  活动管理列表
 */
class Active extends AuthController
{


    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $where = [];

        $tablename = "active";
        $filed = "a.id,FROM_UNIXTIME(a.updatetime,'%Y-%m-%d %H:%i:%s') as updatetime,a.banner,a.name,b.real_name as admin_id,
        a.weight,a.status,a.terminal_type,a.type,a.skin_type,a.class_id";
        $orderfield = "a.terminal_type";
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
        $active_class = Db::name('active_class')->where('status',1)->order('weight','desc')->select()->toArray();
        $f = array();
        $f[] = Form::select('class_id','活动分类')->setOptions(function () use ($active_class){
            $menus = [];
            foreach ($active_class as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);
        $f[] = Form::input('englishname', '活动名称');
        $f[] = Form::input('name', '活动中文名称');
        $f[] = Form::uploadImageOne('banner', '活动图片',url('widget.Image/file',['file'=>'banner']));
        $f[] = Form::input('weight', '权重');

        $f[] = Form::radio('type', '活动类型',1)->options([['label' => '动物卡', 'value' => 0], ['label' => '红包雨', 'value' => 1], ['label' => '转盘', 'value' => 2], ['label' => 'cashback', 'value' => 3], ['label' => '邀请信息', 'value' => 4], ['label' => '飞机社区', 'value' => 5], ['label' => '充值活动', 'value' => 6], ['label' => 'vip升级奖励', 'value' => 7], ['label' => '跳转内部链接', 'value' => 8], ['label' => '跳转外部链接', 'value' => 9]]);

        //$f[] = Form::radio('is_exclusion', '活动是否互斥',1)->options([['label' => '互斥', 'value' => 1], ['label' => '不互斥', 'value' => 2]]);
        $f[] = Form::radio('terminal_type', '包类型',1)->options([['label' => '老包', 'value' => 1], ['label' => '新包', 'value' => 2]]);
        $f[] = Form::input('url', '跳转路径');

        $f[] = Form::radio('status', '状态',1)->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);
        $f[] = Form::radio('skin_type', '皮肤',1)->options([['label' => '皮肤1', 'value' => 1], ['label' => '皮肤2', 'value' => 2]]);

        $form = Form::make_post_form('添加数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }



    public function edit($id = 0){
        $active = Db::name('active')->where('id',$id)->find();

        if(!$active){
            Json::fail('参数错误!');
        }

        $active_class = Db::name('active_class')->where('status',1)->order('weight','desc')->select()->toArray();
        $f[] = Form::select('class_id','活动分类', (string)$active['class_id'])->setOptions(function () use ($active_class){
            $menus = [];
            foreach ($active_class as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);
        $f[] = Form::input('englishname', '活动名称',$active['englishname']);
        $f[] = Form::input('name', '活动中文名称',$active['name']);
        $f[] = Form::uploadImageOne('banner', '活动图片',url('widget.Image/file',['file'=>'banner']),$active['banner']);
        $f[] = Form::input('weight', '活动权重',$active['weight']);

        //$f[] = Form::input('active_num', '活动参与次数',$active['active_num']);


        $f[] = Form::radio('type', '活动类型', $active['type'])->options([['label' => '动物卡', 'value' => 0], ['label' => '红包雨', 'value' => 1], ['label' => '转盘', 'value' => 2], ['label' => 'cashback', 'value' => 3], ['label' => '邀请信息', 'value' => 4], ['label' => '飞机社区', 'value' => 5], ['label' => '充值活动', 'value' => 6], ['label' => 'vip升级奖励', 'value' => 7], ['label' => '跳转内部链接', 'value' => 8], ['label' => '跳转外部链接', 'value' => 9]]);
        //$f[] = Form::radio('is_exclusion', '活动是否互斥', $active['is_exclusion'])->options([['label' => '互斥', 'value' => 1], ['label' => '不互斥', 'value' => 2]]);
        $f[] = Form::radio('terminal_type', '包类型', $active['terminal_type'])->options([['label' => '老包', 'value' => 1], ['label' => '新包', 'value' => 2]]);
        $f[] = Form::input('url', '跳转路径',$active['url']);
        //$f[] = Form::input('lose_money', '活动需要的客损金额(卢比分)',$active['lose_money']);
//        $f[] = Form::input('minmoney', '活动最低存款金额(卢比分/充值金额>=)',$active['minmoney'])->placeholder('要求的最低存款金额');
//        //根据活动的不同json配置，自动生成相应的配置页面
//        $f = $this->config($f,$active['config']);
//
//        $f[] = Form::textarea('remark', '说明',$active['remark']);
        /*$f[] = Form::input('money', '活动支付金额(卢比分)',$active['money']);
        $f[] = Form::input('get_money', '活动立刻获的金额(卢比分)',$active['get_money']);
        $f[] = Form::input('bonus', '活动赠送的Bonus(分)',$active['bonus']);
        $f[] = Form::radio('day_status', '是否开启活动连续赠送天数', $active['day_status'])->options([['label' => '是', 'value' => 1], ['label' => '否', 'value' => 0]]);
        $f[] = Form::input('day', '活动赠送天数',$active['day']);
        $f[] = Form::input('day_money', '活动赠送金额(卢比分)',$active['day_money']);
        if($active['type'] == 11)$f[] = Form::input('day_bonus', '活动每日领取的Bonus(分)',$active['day_bonus']);
        if(($active['type'] == 5 || $active['type'] == 11) &&  !in_array($active['id'],[5,6,7,35,36]) ){
            $f[] = Form::input('last_day', '周卡第二波赠送天数',$active['last_day']);
            $f[] = Form::input('last_money', '周卡第二波活动赠送金额(卢比分)',$active['last_money']);
            if($active['type'] == 11)$f[] = Form::input('last_bonus', '周卡第二波活动赠送Bonus(分)',$active['last_bonus']);
        }*/

//        $f[] = Form::input('mult', '赠送乘数',$active['mult']);
        $f[] = Form::radio('status', '状态', $active['status'])->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);
        $f[] = Form::radio('skin_type', '皮肤', $active['skin_type'])->options([['label' => '皮肤1', 'value' => 1], ['label' => '皮肤2', 'value' => 2]]);

        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($id=0){

        $data = request()->post();
        $data['updatetime'] = time();
        $data['admin_id'] = $this->adminId;

        if($id > 0) {
            $active = Db::name('active')->field('id,day_status,config,day,type')->where('id', $id)->find();

            if ($active['config'] && isset($data['config'])) {
                $data['config'] = $this->configjson($active['config'], $data['config']);
            }
            /*if ($active['type'] == 5){

                $idConfig = [5 => 0,6 => 1,7 => 2,31 => 3, 32 => 4, 33 => 5,35 => 0,36 => 2];

                $day_config = [
                    [
                        'start' => 'pay_7',
                        'end' => '',
                    ],
                    [
                        'start' => 'pay_15',
                        'end' => ''
                    ],
                    [
                        'start' => 'pay_30',
                        'end' => ''
                    ],
                    [
                        'start' => 'pay_7_1',
                        'end' => 'pay_7_1_end'
                    ],
                    [
                        'start' => 'pay_7_2',
                        'end' => 'pay_7_2_end'
                    ],
                    [
                        'start' => 'pay_7_3',
                        'end' => 'pay_7_3_end'
                    ],
                ];

                $redis = new \Redis();
                $redis->connect(Config::get('redis.ip'),6502);
                $redis->hSet('config',$day_config[$idConfig[$id]]['start'],$data['day_money']);
                if($day_config[$idConfig[$id]]['end'])$redis->hSet('config',$day_config[$idConfig[$id]]['end'],$data['last_money']);
            }elseif ($active['type'] == 11){
                $redis = new \Redis();
                $redis->connect(Config::get('redis.ip'),6502);
                $redis->hSet('config','pay_3_score',$data['day_money']);
                $redis->hSet('config','pay_3_score_end',$data['last_money']);
                $redis->hSet('config','pay_3_tpc',$data['day_bonus']);
                $redis->hSet('config','pay_3_tpc_end',$data['last_bonus']);
            }*/


            $res = Db::name('active')->where('id', '=', $id)->update($data);
        }else{
            $res = Db::name('active')->insert($data);
        }
        if(!$res){
            Json::fail('失败');
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
}
