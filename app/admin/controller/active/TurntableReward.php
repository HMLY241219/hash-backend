<?php

namespace app\admin\controller\active;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Config;
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  转盘配置
 */
class TurntableReward extends AuthController
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

        $tablename = "turntable_reward";
        $filed = "a.id,FROM_UNIXTIME(a.updatetime,'%Y-%m-%d %H:%i:%s') as updatetime,a.logo,a.name,a.probability,a.reward,a.reward_max,a.type,
        b.real_name as admin_id";
        $orderfield = "a.id";
        $sort = "desc";
        $join = ['system_admin b','b.id = a.admin_id'];
        $alias = 'a';
        $date = 'a.create_time';
        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left');

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }



    public function edit($id = 0){
        $active = Db::name('turntable_reward')->where('id',$id)->find();

        if(!$active){
            Json::fail('参数错误!');
        }
        $f[] = Form::input('name', '名称',$active['name']);
        $f[] = Form::uploadImageOne('logo', '图标',url('widget.Image/file',['file'=>'logo']),$active['logo']);
        $f[] = Form::number('reward', '奖励金额',$active['reward']);
        $f[] = Form::number('reward_max', '奖励金额最大值',$active['reward_max']);
        $f[] = Form::number('probability', '概率百分比',$active['probability']);

//        $f[] = Form::input('mult', '赠送乘数',$active['mult']);
        $f[] = Form::radio('type', '状态', $active['type'])->options([['label' => '累积取现额', 'value' => 1], ['label' => 'cash', 'value' => 2], ['label' => 'bouns', 'value' => 3]]);

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
            $data['updatetime'] = time();
            $data['admin_id'] = $this->adminId;


            $res = Db::name('turntable_reward')->where('id','=',$id)->update($data);
            if(!$res){
                Json::fail('编辑失败');
            }

        }
        return Json::successful($id > 0 ? '修改成功!' : '添加成功!');

    }
}
