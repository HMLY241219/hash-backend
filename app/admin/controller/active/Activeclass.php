<?php

namespace app\admin\controller\active;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  Activeclass管理列表
 */
class Activeclass extends AuthController
{


    private $tablename = 'active_class';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        //$data['a_type'] = $data['a_type'] ?? 1;
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $tablename = $this->tablename;
        $filed = "a.id,FROM_UNIXTIME(a.updatetime,'%Y-%m-%d %H:%i:%s') as updatetime,a.name,a.image,a.status,b.real_name as admin_id,a.weight,a.not_image";

        $orderfield = "weight";
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
        $f[] = Form::input('name', '名称');
        $f[] = Form::uploadImageOne('not_image', '未选中图标',url('widget.Image/file',['file'=>'not_image']));
        $f[] = Form::uploadImageOne('image', '图标',url('widget.Image/file',['file'=>'image']));

        $f[] = Form::input('weight', '权重');
        $f[] = Form::radio('status', '状态',0)->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);

        $form = Form::make_post_form('添加数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function edit($id = 0){
        $banner = Db::name($this->tablename)->where('id',$id)->find();
        if(!$banner){
            Json::fail('参数错误!');
        }
        $f = array();
        $f[] = Form::input('name', '名称',$banner['name']);
        $f[] = Form::uploadImageOne('not_image', '未选中图标',url('widget.Image/file',['file'=>'not_image']),$banner['not_image']);
        $f[] = Form::uploadImageOne('image', '图标',url('widget.Image/file',['file'=>'image']),$banner['image']);

        $f[] = Form::input('weight', '权重',$banner['weight']);
        $f[] = Form::radio('status', '状态', $banner['status'])->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);
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
    /**
     * @return void 修改状态
     */
    public function is_show(){
        $adminId = $this->adminId;
        $id = request()->post('id');
        $data['status'] = request()->post('status');
        $data['admin_id'] = $adminId;
        $data['updatetime'] = time();

        $res = Db::name($this->tablename)->where('id',$id)->update($data);
        if(!$res){
            return Json::fail('修改失败2');
        }
        return Json::successful('修改成功!');

    }


    /**
     * @return void 删除数据
     */
    public function delete($id = ''){
        $res = Db::name($this->tablename)->where('id',$id)->delete();

        if(!$res){
            return Json::fail('删除失败');
        }
        return Json::successful('删除成功!');
    }

}
