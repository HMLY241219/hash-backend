<?php

namespace app\admin\controller\operate;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  系统邮件管理列表
 */
class Information extends AuthController
{


    private $tablename = 'user_information';

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $data['a_type'] = $data['a_type'] ?? 1;
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $tablename = $this->tablename;
        $filed = "a.id,FROM_UNIXTIME(a.createtime,'%Y-%m-%d %H:%i:%s') as createtime,a.title,a.content,b.real_name as admin_id";

        $orderfield = "a.id";
        $sort = "desc";
        $join = ['system_admin b','b.id = a.admin_id'];
        $alias = 'a';
        $date = 'a.createtime';

        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left',[['a.type','=',1]]);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    /**
     * @return void 添加
     */
    public function add()
    {
        $f = array();
        $f[] = Form::input('title', '标题');

        $f[] = Form::textarea('content', '内容');

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
        $f[] = Form::input('title', '标题',$banner['title']);
        $f[] = Form::textarea('content', '内容',$banner['content']);

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
        if($id > 0){
            $res = Db::name($this->tablename)->where('id',$id)->update($data);
        }else{
            $data['type'] = 1;
            $data['createtime'] = time();
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
