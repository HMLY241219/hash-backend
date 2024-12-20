<?php

namespace app\admin\controller\operate;

use app\admin\controller\AuthController;
use app\admin\model\operate\Apps;
use crmeb\services\FormBuilder as Form;
use crmeb\services\JsonService as Json;
use think\facade\Filesystem;

class Apk extends AuthController
{
    private $options = [
        ['label' => '广告包', 'value' => '0'],
        ['label' => '分享包', 'value' => '1']
    ];

    private $options_update = [
        ['label' => '否', 'value' => '0'],
        ['label' => '是', 'value' => '1']
    ];

    public function index()
    {
        return $this->fetch();
    }

    public function get_list()
    {
        $param = $this->request->param();

        $data = Apps::getDataSet($param);

        return Json::successlayui($data);
    }

    public function delete($id)
    {
        if (Apps::destroy($id))
        {
            return Json::success('删除成功');
        }
        else
        {
            return Json::success('删除失败，稍后再试');
        }
    }

    public function uploads()
    {
        $file = $this->request->file('file');

        @chmod(public_path('uploads/apk'), 0755);
        $origin = $file->getOriginalName();

        $file = Filesystem::putFileAs('apk', $file, $origin);
        //@chmod(public_path('uploads/apk'), 0555);

        $ret = $this->apk_parser($file);

        return true === $ret ? Json::success('上传成功') : Json::fail($ret);
    }

    private function apk_parser($file)
    {
        $url = Filesystem::url($file);

        try
        {
            $apk = new \ApkParser\Parser(public_path() . $url);
        } catch (\Exception $e)
        {
            return 'apk文件解析失败';
        }

        $manifest = $apk->getManifest();

        $data = [
            'file_name'           => ltrim($file, 'apk/'),
            'file_url'            => $this->request->domain() . $url,
            'pkg_name'            => $manifest->getPackageName(),
            'app_version'         => $manifest->getVersionName(),
            'min_sdk_level'       => $manifest->getMinSdkLevel(),
            'min_sdk_platform'    => $manifest->getMinSdk()->platform,
            'target_sdk_level'    => $manifest->getTargetSdkLevel(),
//            'target_sdk_platform' => $manifest->getTargetSdk()->platform,
            'operator'            => $this->adminName,
        ];

        Apps::create($data);

        return true;
    }


    public function update($id)
    {
        if (!$r = Apps::find($id)) return $this->failed('数据不存在');

        $f   = [];
        //$f[] = Form::select('pkg_type', '包类型', (string)$r->getData('pkg_type'))->options($this->options)->required();

        $f[] = Form::input('app_version', '版本号', (string)$r->getData('app_version'))->required();
        $f[] = Form::select('is_forced_update', '是否强制更新', (string)$r->getData('is_forced_update'))->options($this->options_update)->required();


        $form   = Form::make_post_form('修改', $f, url('save', ['id' => $id]));
        $custom = true;
        $this->assign(compact('form', 'custom'));

        return $this->fetch('public/form-builder');
    }

    public function save($id = 0)
    {
        $data = $this->request->param();

        $data['operator'] = $this->adminName;

        if ($id > 0)
        {
            Apps::update($data);
        }
        else
        {
            Apps::create($data);
        }

        return Json::success('保存成功');
    }


}