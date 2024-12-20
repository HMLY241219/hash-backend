<?php

namespace app\admin\controller\operate;
use app\admin\controller\AuthController;
use app\admin\model\ump\ExecPhp;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use think\facade\Db;
use app\admin\controller\Model;
/**
 *  首页游戏模版管理
 */
class HomeGame extends AuthController
{


    private $tablename = 'home_game';

    private $type_options = [['label' => '厂商', 'value' => 0], ['label' => '热门', 'value' => 1],['label' => '推荐', 'value' => 6],['label' => '真人', 'value' => 7],['label' => '捕鱼', 'value' => 12],['label' => '区块链', 'value' => 3],['label' => '体育', 'value' => 13],['label' => 'Slots', 'value' => 8]];

    public function index()
    {
        return $this->fetch();
    }


    public function getlist(){
        $data =  request()->param();
        $page = $data['page'] ?: 1;
        $limit = $data['limit'] ?: 30;
        $tablename = $this->tablename;
        $filed = "a.id,FROM_UNIXTIME(a.update_time,'%Y-%m-%d %H:%i:%s') as updatetime,a.name,a.tag,a.icon,a.weight,a.status,a.type,a.terrace_id,a.admin,
        b.name as terrace_name,a.click_icon,a.skin_type";

        $orderfield = "a.id";
        $sort = "desc";
        $join = ['slots_terrace b','b.id = a.terrace_id'];
        $alias = 'a';
        $date = 'a.update_time';

        $data = Model::joinGetdata($tablename,$filed,$data,$orderfield,$sort,$page,$limit,$join,$alias,$date,'left',[]);

        return json(['code' => 0, 'count' => $data['count'], 'data' => $data['data']]);
    }


    /**
     * @return void 添加
     */
    public function add()
    {
        $active = Db::name('slots_terrace')->where('status',1)->order('weight','desc')->select()->toArray();
        $f = array();
        $f[] = Form::input('name', '名称');
        $f[] = Form::input('tag', '标签');
        $f[] = Form::uploadImageOne('icon', '图标',url('widget.Image/file',['file'=>'icon']));
        $f[] = Form::uploadImageOne('click_icon', '点击图标',url('widget.Image/file',['file'=>'click_icon']));
        $f[] = Form::radio('type', '类型',1)->options($this->type_options);
        $f[] = Form::select('terrace_id','厂商')->setOptions(function () use ($active){
            $menus = [];
            $menus[] = ['value' => 0, 'label' => '无'];
            foreach ($active as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);

        $f[] = Form::input('weight', '权重');
        $f[] = Form::radio('status', '状态',0)->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);
        $f[] = Form::radio('skin_type', '皮肤类型',1)->options([['label' => '皮肤1', 'value' => 1], ['label' => '皮肤2', 'value' => 2]]);

        $form = Form::make_post_form('添加数据', $f, url('save'));
        $this->assign(compact('form'));
        return $this->fetch('public/form-builder');
    }

    public function edit($id = 0){
        $banner = Db::name($this->tablename)->where('id',$id)->find();
        if(!$banner){
            Json::fail('参数错误!');
        }
        $active = Db::name('slots_terrace')->where('status',1)->order('weight','desc')->select()->toArray();
        $f = array();
        $f[] = Form::input('name', '名称',$banner['name']);
        $f[] = Form::input('tag', '标签',$banner['tag']);
        $f[] = Form::uploadImageOne('icon', '图标',url('widget.Image/file',['file'=>'icon']),$banner['icon']);
        $f[] = Form::uploadImageOne('click_icon', '点击图标',url('widget.Image/file',['file'=>'click_icon']),$banner['click_icon']);
        $f[] = Form::radio('type', '类型',$banner['type'])->options($this->type_options);
        $f[] = Form::select('terrace_id','厂商', (string)$banner['terrace_id'])->setOptions(function () use ($active){
            $menus = [];
            $menus[] = ['value' => 0, 'label' => '无'];
            foreach ($active as $menu) {
                $menus[] = ['value' => $menu['id'], 'label' => $menu['name']];
            }
            return $menus;
        })->filterable(1);
        $f[] = Form::input('weight', '权重',$banner['weight']);
        $f[] = Form::radio('status', '状态', $banner['status'])->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);
        $f[] = Form::radio('skin_type', '皮肤类型',$banner['skin_type'])->options([['label' => '皮肤1', 'value' => 1], ['label' => '皮肤2', 'value' => 2]]);
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
        $data['admin'] = $this->adminName;
        $data['update_time'] = time();
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
        $data['admin'] = $this->adminName;
        $data['update_time'] = time();

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
