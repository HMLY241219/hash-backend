<?php

namespace app\admin\controller\active;
use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  红包雨发放时间配置
 */
class RedEnvelopestime extends AuthController
{


    private $table = 'red_envelopes_time';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $filed = "id,time,type,day,status";
        $data = Model::Getdata($this->table,$filed,$data,'id','desc',$page,$limit);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    /**
     * @return void 添加
     */
    public function add()
    {

        $f[] = Form::input('time', '参与时间(H:i:s - H:i:s)格式');
        $f[] = Form::radio('type', '状态','1')->options([['label' => '每天', 'value' => 1], ['label' => '每周', 'value' => 2], ['label' => '每月', 'value' => 3]]);

        $f[] = Form::input('day', '几号或周几能参与(几号、几号)这种格式，每周和每日必填');


        $f[] = Form::radio('status', '状态','1')->options([['label' => '关闭', 'value' => 0], ['label' => '开启', 'value' => 1]]);

        $form = Form::make_post_form('添加数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function edit($id = 0){
        $terrace = Db::name($this->table)->where('id',$id)->find();
        if(!$terrace){
            Json::fail('参数错误!');
        }

        $f = array();
        $f[] = Form::input('time', '参与时间(H:i:s - H:i:s)格式',$terrace['time']);
        $f[] = Form::radio('type', '状态',(string)$terrace['type'])->options([['label' => '每天', 'value' => 1], ['label' => '每周', 'value' => 2], ['label' => '每月', 'value' => 3]]);

        $f[] = Form::input('day', '几号或周几能参与(几号、几号)这种格式，每周和每日必填',$terrace['day']);


        $f[] = Form::radio('status', '状态',$terrace['status'])->options([['label' => '关闭', 'value' => 0], ['label' => '开启', 'value' => 1]]);

        $form = Form::make_post_form('修改数据', $f, url('save',['id' => $id]));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    /**
     * @return void 存储数据
     */
    public function save($id=0){

        $data = request()->post();
        [$data['startdate'],$data['enddate']] = explode(' - ',$data['time']);
        $data['startdate'] = str_replace(':','',$data['startdate']);
        $data['enddate'] = str_replace(':','',$data['enddate']);
        if($id > 0){
            $res = Db::name($this->table)->where('id',$id)->update($data);
        }else{
            $data['createtime'] = time();
            $res = Db::name($this->table)->insert($data);
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

        $id = request()->post('id');
        $data['status'] = request()->post('status');

        $res = Db::name($this->table)->where('id',$id)->update($data);
        if(!$res){
            return Json::fail('修改失败2');
        }
        Db::name('slots_game')->where('terrace_id',$id)->update(['maintain_status' => $data['status']]);
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


