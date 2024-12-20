<?php

namespace app\admin\controller\operate;

use app\admin\controller\AuthController;
use app\admin\model\operate\Contact as Contacts;
use crmeb\services\FormBuilder as Form;
use crmeb\services\JsonService as Json;
use think\facade\Db;

/**
 * 联系
 */
class Contact extends AuthController
{
    private $options = [
        ['label' => '官方账号', 'value' => '1'],
        ['label' => '官方社交账号', 'value' => '2'],
        ['label' => '官方联系方式', 'value' => '3'],
    ];

    public function index()
    {
        return $this->fetch();
    }

    public function get_list()
    {
        $param = $this->request->param();

        $data = Contacts::getDataSet($param);

        return Json::successlayui($data);
    }

    public function create()
    {
        $f   = [];
        $f[] = Form::input('name', '名称')->required();
        $f[] = Form::uploadImageOne('icon', '图片',url('widget.Image/file',['file'=>'icon']));
        $f[] = Form::textarea('contact', '联系方式')->rows(2);
        $f[] = Form::select('type', '类型')->options($this->options)->required();
        $f[] = Form::input('url', '社区链接')->required();
        $f[] = Form::number('sort', '排序');

        $form = Form::make_post_form('创建', $f, url('save'));
        $this->assign(compact('form'));

        return $this->fetch('public/form-builder');
    }

    public function update($id): string
    {
        if (!$r = Contacts::find($id)) return $this->failed('数据不存在');

        $f   = [];
        $f[] = Form::input('name', '名称', $r->getData('name'))->required();
        $f[] = Form::uploadImageOne('icon', '图标',url('widget.Image/file',['file'=>'icon']),$r->getData('icon'));
        $f[] = Form::textarea('contact', '联系方式', $r->getData('contact'))->rows(2);
        $f[] = Form::select('type', 'url类型', (string)$r->getData('type'))->options($this->options)->required();
        $f[] = Form::input('url', '社区链接', $r->getData('url'))->required();
        $f[] = Form::number('sort', '排序', $r->getData('sort'));

        $form = Form::make_post_form('修改', $f, url('save', ['id' => $id]));
        $this->assign(compact('form'));

        return $this->fetch('public/form-builder');
    }

    public function save($id = 0, $cate = 0)
    {
        $data = $this->request->param();
        $data['operator'] = $this->adminName;

        if ($id > 0)
        {
            Contacts::update($data);
        }
        else
        {
            Contacts::create($data);
        }

        return Json::success('保存成功');
    }

    public function delete($id)
    {
        if (Contacts::destroy($id))
        {
            return Json::success('删除成功');
        }
        else
        {
            return Json::success('删除失败，稍后再试');
        }
    }


    /**
     * @return void 修改状态
     */
    public function is_show(){
        //$adminId = $this->adminId;
        $id = request()->post('id');
        $data['status'] = request()->post('status');
        //$data['admin_id'] = $adminId;
        //$data['updatetime'] = time();
        $data['id'] = $id;

        $res = Contacts::update($data);;
        if(!$res){
            return Json::fail('修改失败2');
        }
        return Json::successful('修改成功!');

    }

}