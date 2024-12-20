<?php

namespace app\admin\controller\operate;

use app\admin\controller\AuthController;
use crmeb\services\FormBuilder as Form;
use crmeb\services\JsonService as Json;
use app\admin\model\operate\Notices;

class Notice extends AuthController
{

    public function index()
    {
        return $this->fetch();
    }

    public function get_list()
    {
        $param = $this->request->param();
        $data = Notices::getDataSet($param);

        return Json::successlayui($data);
    }

    public function set_state($id, $name, $value)
    {
        if (Notices::setField($id, $name, $value))
        {
            return Json::success('操作成功');
        }
        else
        {
            return Json::fail('操作失败，稍后再试');
        }
    }

    /**
     * 弃用
     * @return string
     */
    public function create()
    {
        $f   = [];
        $f[] = Form::input('title', '公告标题')->required();
        $f[] = Form::textarea('content', '公告内容')->rows(4)->required();
        $f[] = Form::number('bonus', '金币奖励', 0)->min(0)->step(1)->precision(0)->col(8);
        $f[] = Form::dateTimeRange('dates', '显示时间');

        $form = Form::make_post_form('创建', $f, url('save'));
        $this->assign(compact('form'));

        return $this->fetch('public/form-builder');
    }

    public function add(){
        return $this->fetch();
    }

    public function edit($id){
        $announcement = Notices::find($id);
        $announcement['content'] = json_encode($announcement['content']);
        $this->assign('announcement',$announcement);

        return $this->fetch();
    }

    //弃用
    public function update($id)
    {
        if (!$r = Notices::find($id)) return $this->failed('数据不存在');

        $f   = [];
        $f[] = Form::input('title', '公告标题', $r->getData('title'))->required();
        $f[] = Form::textarea('content', '公告内容', $r->getData('content'))->required();
        $f[] = Form::number('bonus', '金币奖励', $r->getData('bonus'))->min(0)->step(1)->precision(0)->col(8);
        $f[] = Form::dateTimeRange('dates', '显示时间', $r->start, $r->end);

        $form = Form::make_post_form('修改', $f, url('save', ['id' => $id]));
        $this->assign(compact('form'));

        return $this->fetch('public/form-builder');
    }

    public function copy($id)
    {
        if (!$r = Notices::find($id)) return $this->failed('数据不存在');

        $f   = [];
        $f[] = Form::input('title', '公告标题', $r->getData('title'))->required();
        $f[] = Form::textarea('content', '公告内容', $r->getData('content'))->required();
        $f[] = Form::number('bonus', '金币奖励', $r->getData('bonus'))->min(0)->step(1)->precision(0)->col(8);
        $f[] = Form::dateTimeRange('dates', '显示时间', $r->start, $r->end);

        $form = Form::make_post_form('复制', $f, url('save'));
        $this->assign(compact('form'));

        return $this->fetch('public/form-builder');
    }

    public function save($id = 0)
    {
        $data = $this->request->param();

        /*[$data['start'], $data['end']] = $data['dates'];
        unset($data['dates']);

        if (!$data['start'] || !$data['end'])
        {
            return $this->failed('请选择显示时间!');
        }*/

        $data['operator'] = $this->adminName;
        $data['update_time'] = time();

        if ($id > 0)
        {
            Notices::update($data);
        }
        else
        {
            $data['create_time'] = time();
            Notices::create($data);
        }

        return Json::success('保存成功');
    }

    public function delete($id)
    {
        if (Notices::destroy($id, true))
        {
            return Json::success('删除成功');
        }
        else
        {
            return Json::success('删除失败，稍后再试');
        }
    }


    /**
     * @return void 上传图片
     */
    public function uploadImage2(){
        $res = \customlibrary\Common::uplode('news');
        if($res['code'] != 200){
            return Json::fail('上传失败!');
        }
        //return Json::successful('',['url'=>$res['data']],0);
        $data = [
            [
                'url' => config('redis.domain').$res['data']
            ]
        ];
        return json(['errno' => 0, 'data' => $data]);

    }


}