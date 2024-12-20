<?php

namespace app\admin\controller\operate;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  Banner管理列表
 */
class Banner extends AuthController
{


    private $tablename = 'banner';

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
        $filed = "a.id,FROM_UNIXTIME(a.updatetime,'%Y-%m-%d %H:%i:%s') as updatetime,a.title,a.image,a.status,b.real_name as admin_id,a.weight,a.url_type,a.end_type,a.skin_type";

        $orderfield = "a.skin_type";
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
        $active = Db::name('active')->where('status',1)->order('weight','desc')->select()->toArray();
        $f = array();
        $f[] = Form::input('title', 'Banner名称');
        $f[] = Form::uploadImageOne('image', 'Banner名称',url('widget.Image/file',['file'=>'image']));
        $f[] = Form::radio('url_type', '类型',1)->options([['label' => '活动Banner', 'value' => 1], ['label' => '网页Banner', 'value' => 2],['label' => '签到弹窗', 'value' => 3],['label' => 'cashback弹窗', 'value' => 4],['label' => '宝箱弹窗', 'value' => 5]]);
        $f[] = Form::select('active_id','活动')->setOptions(function () use ($active){
            $menus = [];
            foreach ($active as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);
        $f[] = Form::input('url', '网页链接(网页Banner必填)');
        //$f[] = Form::radio('type', '类型',1)->options([['label' => '首页banner', 'value' => 1], ['label' => '充值banner', 'value' => 2]]);
        $f[] = Form::radio('end_type', '包类型',1)->options([['label' => '老包', 'value' => 1], ['label' => '新包', 'value' => 2]]);
        $f[] = Form::radio('skin_type', '皮肤类型',1)->options([['label' => '皮肤1', 'value' => 1], ['label' => '皮肤2', 'value' => 2]]);
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
        $active = Db::name('active')->where('status',1)->order('weight','desc')->select()->toArray();
        $f = array();
        $f[] = Form::input('title', 'Banner名称',$banner['title']);
        $f[] = Form::uploadImageOne('image', '图片',url('widget.Image/file',['file'=>'image']),$banner['image']);
        $f[] = Form::radio('url_type', '类型',$banner['url_type'])->options([['label' => '活动Banner', 'value' => 1], ['label' => '网页Banner', 'value' => 2],['label' => '签到弹窗', 'value' => 3],['label' => 'cashback弹窗', 'value' => 4],['label' => '宝箱弹窗', 'value' => 5]]);
        $f[] = Form::select('active_id','活动', (string)$banner['active_id'])->setOptions(function () use ($active){
            $menus = [];
            foreach ($active as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);
        $f[] = Form::input('url', '网页链接(网页Banner必填)',$banner['url']);
        //$f[] = Form::radio('type', '类型', $banner['type'])->options([['label' => '首页banner', 'value' => 1], ['label' => '充值banner', 'value' => 2]]);
        $f[] = Form::radio('end_type', '包类型',$banner['end_type'])->options([['label' => '老包', 'value' => 1], ['label' => '新包', 'value' => 2]]);
        $f[] = Form::radio('skin_type', '皮肤类型',$banner['skin_type'])->options([['label' => '皮肤1', 'value' => 1], ['label' => '皮肤2', 'value' => 2]]);
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
