<?php

namespace app\admin\controller\setting;

use app\admin\controller\AuthController;
use crmeb\services\{FormBuilder as Form, JsonService as Json, UtilService as Util};
use app\admin\model\system\{SystemRole, SystemAdmin as AdminModel};
use think\facade\Db;
use think\facade\Log;
use think\facade\Route as Url;

/**
 * 管理员列表控制器
 * Class SystemAdmin
 * @package app\admin\controller\system
 */
class SystemAdmin extends AuthController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $admin = $this->adminInfo;
        $where = Util::getMore([
            ['name', ''],
            ['roles', ''],
            ['level', bcadd($admin->level, 1, 0)],
            ['id', $admin->id],
            ['type', $admin->type],
        ]);
        $this->assign('where', $where);
        $this->assign('admin', $admin);
        !$admin->type ? $this->assign('role', SystemRole::getRoleLevel(bcadd($admin->level, 1, 0))) : $this->assign('role', SystemRole::getRolePid($admin->roles));
        $this->assign(AdminModel::systemPage($where));
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $admin = $this->adminInfo;

        if ($admin->package_id == 0) {
            $apppackage = Db::name('apppackage')->field('id,bagname')->where('status',1)->select()->toArray();
        }else{
            $apppackage = Db::name('apppackage')->field('id,bagname')->where('id',$admin->package_id)->select()->toArray();
        }


        $menus = [];
//        $list = SystemRole::getRole(bcadd($admin->level, 1, 0));
        $list = SystemRole::getRole($admin->roles);

        foreach ($list as $id => $roleName) {
            $menus[] = ['label' => $roleName, 'value' => $id];
        }


        $this->assign('apppackage',$apppackage);
        $this->assign('admin',$admin);
        $this->assign('roleslist', $menus);
        $this->assign('chanel', []);

//        $admin = $this->adminInfo;
//        $f = array();
//        $f[] = Form::input('account', '管理员账号');
//        $f[] = Form::input('pwd', '管理员密码')->type('password');
//        $f[] = Form::input('conf_pwd', '确认密码')->type('password');
//        $f[] = Form::input('real_name', '管理员姓名');
//        $f[] = Form::select('roles', '管理员身份')->setOptions(function () use ($admin) {
//            $list = SystemRole::getRole(bcadd($admin->level, 1, 0));
//            $options = [];
//            foreach ($list as $id => $roleName) {
//                $options[] = ['label' => $roleName, 'value' => $id];
//            }
//            return $options;
//        });
//        $f[] = Form::radio('status', '状态', 1)->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);
//        $form = Form::make_post_form('添加管理员', $f, Url::buildUrl('save'));
//        $this->assign(compact('form'));
//        return $this->fetch('public/form-builder');
        return $this->fetch('newcreate');
    }

    /**
     * 保存新建的资源
     *
     * @param \think\Request $request
     * @return \think\Response
     */
    public function save()
    {
        $data = $this->setCheckboxdata($this->request->post('data'));
        //平台开通渠道人员
        if (isset($data['type']) && $data['type'] == 1 && $this->adminInfo['type'] == 0){
            $data['package_id'] = 2;
            $newcid = 100000000;
            $pcid = 0;
            //$channel_level = 1;

            for($i=0;$i<10;$i++){
                $channel = Db::name('chanel')->where('use_type',1)->where('channel',$newcid)->find();
                if (empty($channel)){
                    break;
                }else{
                    $newcid += 100000000;
                }
            }
            $data['channels'] = $newcid;
            $data['channel'] = $newcid;
        }

        Db::startTrans();
        try {

            //渠道人员开通下级
            if (!isset($data['type'])) {
                if ($this->adminInfo['level'] >= 5){
                    return Json::fail('无权限添加管理员');
                }
                $cid_type = $this->adminInfo['channels'][0] * 100000000;
                $no_cid_type = $cid_type + 100000000;
                $oldcid = Db::name('chanel')->where('use_type', 1)->where('channel', '<', $no_cid_type)->where('channel', '>=', $cid_type)->order('channel', 'desc')->value('channel');
                $newcid = $oldcid + 10;
                //$pcid = $oldcid;
                $pcid = $this->adminInfo['channel'];
                //$channel_level = $this->adminInfo['level'] + 1;

                $data['roles'] = $this->adminInfo['roles'];
                $data['package_id'] = $this->adminInfo['package_id'];
                $data['channels'] = $newcid;
                $data['channel'] = $newcid;
                $data['type'] = 1;

                //增加主人渠道
                $admin_channel = $this->adminInfo['channels'] . ',' . $newcid;
                Db::name('system_admin')->where('id', $this->adminInfo['id'])->update(['channels' => $admin_channel]);//父
                if ($this->adminInfo['pid'] != 0) {
                    $upadmin = AdminModel::get($this->adminInfo['pid']);
                    if ($upadmin['type'] == 1) {
                        $upadmin_channel = $upadmin['channels'] . ',' . $newcid;
                        Db::name('system_admin')->where('id', $upadmin['id'])->update(['channels' => $upadmin_channel]);//爷

                        if ($upadmin['pid'] != 0){
                            $upadmin2 = AdminModel::get($upadmin['pid']);
                            if ($upadmin2['type'] == 1){
                                $upadmin2_channel = $upadmin2['channels'] . ',' . $newcid;
                                Db::name('system_admin')->where('id', $upadmin2['id'])->update(['channels' => $upadmin2_channel]);//祖

                                if ($upadmin2['pid'] != 0){
                                    $upadmin3 = AdminModel::get($upadmin2['pid']);
                                    if ($upadmin3['type'] == 1){
                                        $upadmin3_channel = $upadmin3['channels'] . ',' . $newcid;
                                        Db::name('system_admin')->where('id', $upadmin3['id'])->update(['channels' => $upadmin3_channel]);//祖祖
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $channel_name = isset($data['channel_name']) ? $data['channel_name'] : '';
            unset($data['channel_name']);

            if (!$data['account']) return Json::fail('请输入管理员账号');
            if (!$data['roles']) return Json::fail('请选择至少一个管理员身份');
            if (!$data['pwd']) return Json::fail('请输入管理员登陆密码');
            if ($data['pwd'] != $data['conf_pwd']) return Json::fail('两次输入密码不想同');
            if (AdminModel::be($data['account'], 'account')) return Json::fail('管理员账号已存在');
            $data['pwd'] = md5($data['pwd']);
            $data['add_time'] = time();
            unset($data['conf_pwd']);
            $data['level'] = $this->adminInfo['level'] + 1;
            $data['pid'] = $this->adminInfo['id'];
            $data['add_time'] = time();
            $data['googlesecret'] = \googleAuth\GoogleAuth::createSecret();
            if (!AdminModel::create($data)) return Json::fail('添加管理员失败');

            //添加渠道
            if ((isset($data['type']) && $data['type'] == 1 && $this->adminInfo['type'] == 0) || $this->adminInfo['type'] == 1) {
                $packge_info = Db::name('apppackage')->where('id',$data['package_id'])->value('appname');
                $channel_data = [
                    'channel' => $newcid,
                    'pchannel' => $pcid,
                    'cname' => $channel_name,
                    'ctag' => $data['account'],
                    'admin_id' => $this->adminInfo['id'],
                    'appname' => $packge_info,
                    'level' => 1,
                    'package_id' => $data['package_id'],
                    'ppackage_id' => $data['package_id'],
                    'updatetime' => time(),
                    'remark' => $data['real_name'],
                    'use_type' => 1,
                ];
                Db::name('chanel')->insert($channel_data);
            }

            Db::commit();
            return Json::successful('添加管理员成功!');
        }catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error('TopSend fail==>'.$exception->getMessage());
            Db::rollback();
            return Json::fail('添加失败');
        }
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $adminself = $this->adminInfo;
        if ($adminself->package_id == 0) {
            $apppackage = Db::name('apppackage')->field('id,bagname')->where('status', 1)->select()->toArray();
        }else{
            $apppackage = Db::name('apppackage')->field('id,bagname')->where('status', 1)->where('id',$adminself->package_id)->select()->toArray();
        }
        if (!$id) return $this->failed('参数错误');

        $admin = AdminModel::get($id);
        if (!$admin) return Json::fail('数据不存在!');

//        $list = SystemRole::getRole($admin->level);
        $list = SystemRole::getRole($adminself->roles);
        $menus = [];
        foreach ($list as $id => $roleName) {
            $menus[] = ['label' => $roleName, 'value' => $id];
        }

        $chanel = [];
        if($admin['package_id']){
            if ($adminself->channels != 0) {
                $chanel = Db::name('chanel')->where([['package_id','in',$admin['package_id']],['level','in',1]])->whereIn('channel', $adminself->channels)->order('channel', 'asc')->column('channel,cname');
            }else{
                $chanel = Db::name('chanel')->where([['package_id','in',$admin['package_id']],['level','in',1]])->order('channel', 'asc')->column('channel,cname');
            }
        }

        $this->assign('apppackage',$apppackage);
        $this->assign('admin',$admin);
        $this->assign('adminself',$adminself);
        $this->assign('roleslist', $menus);
        $this->assign('chanel', $chanel);
//        $f = array();
//        $f[] = Form::input('account', '管理员账号', $admin->account);
//        $f[] = Form::input('pwd', '管理员密码')->type('password');
//        $f[] = Form::input('conf_pwd', '确认密码')->type('password');
//        $f[] = Form::input('real_name', '管理员姓名', $admin->real_name);
//        $f[] = Form::select('package_id','包名', (string)$admin['package_id'])->setOptions(function () use ($apppackage){
//            $menus = [];
//            foreach ($apppackage as $menu) {
//                $menus[] = ['value' => $menu['id'], 'label' => $menu['bagname']];
//            }
//            return $menus;
//        })->filterable(1);
//        $f[] = Form::select('roles', '管理员身份', explode(',', $admin->roles))->setOptions(function () use ($admin) {
//            $list = SystemRole::getRole($admin->level);
//            $options = [];
//            foreach ($list as $id => $roleName) {
//                $options[] = ['label' => $roleName, 'value' => $id];
//            }
//            return $options;
//        })->multiple(1);
//        $f[] = Form::radio('status', '状态', 1)->options([['label' => '开启', 'value' => 1], ['label' => '关闭', 'value' => 0]]);
//        $form = Form::make_post_form('编辑管理员', $f, Url::buildUrl('update', compact('id')));
//        $this->assign(compact('form'));
        return $this->fetch('newedit');
    }

    /**
     * 保存更新的资源
     *
     * @param \think\Request $request
     * @param int $id
     * @return \think\Response
     */
    public function update($id)
    {
        $lodadmin = Db::name('system_admin')->where('id',$id)->find();

        $data = $this->setCheckboxdata($this->request->post('data'));
        if (!$data['account']) return Json::fail('请输入管理员账号');
        if ($this->adminInfo['type'] == 0) {
            if (!$data['roles']) return Json::fail('请选择至少一个管理员身份');
        }
        if (!$data['pwd'])
            unset($data['pwd']);
        else {
            if (isset($data['pwd']) && $data['pwd'] != $data['conf_pwd']) return Json::fail('两次输入密码不想同');
            $data['pwd'] = md5($data['pwd']);
        }
        if (AdminModel::where('account', $data['account'])->where('id', '<>', $id)->count()) return Json::fail('管理员账号已存在');
        unset($data['conf_pwd']);
        $googleSecret  = Db::name('system_admin')->where('account',$data['account'])->value('googlesecret');
        if(!$googleSecret){
            $data['googlesecret'] = \googleAuth\GoogleAuth::createSecret();
        }
        if (!AdminModel::edit($data, $id)) return Json::fail('修改失败');

        //修改渠道
        if ($lodadmin['account'] != $data['account']){
            Db::name('chanel')->where('channel',$lodadmin['channel'])->update(['ctag'=>$data['account']]);
        }

        return Json::successful('修改成功!');
    }

    /**
     * 删除指定资源
     *
     * @param int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        if (!$id)
            return Json::fail('删除失败!');
        if (AdminModel::edit(['is_del' => 1, 'status' => 0], $id, 'id'))
            return Json::successful('删除成功!');
        else
            return Json::fail('删除失败!');
    }

    /**
     * 个人资料 展示
     * @return string
     */
    public function admin_info()
    {
        $adminInfo = $this->adminInfo;//获取当前登录的管理员
        $this->assign('adminInfo', $adminInfo);
        return $this->fetch();
    }

    /**
     * 保存信息
     */
    public function setAdminInfo()
    {
        $adminInfo = $this->adminInfo;//获取当前登录的管理员
        if ($this->request->isPost()) {
            $data = Util::postMore([
                ['new_pwd', ''],
                ['new_pwd_ok', ''],
                ['pwd', ''],
                'real_name',
            ]);
            if ($data['pwd'] != '') {
                $pwd = md5($data['pwd']);
                if ($adminInfo['pwd'] != $pwd) return Json::fail('原始密码错误');
            }
            if ($data['new_pwd'] != '') {
                if (!$data['new_pwd_ok']) return Json::fail('请输入确认新密码');
                if ($data['new_pwd'] != $data['new_pwd_ok']) return Json::fail('俩次密码不一样');
            }
            if ($data['pwd'] != '' && $data['new_pwd'] != '') {
                $data['pwd'] = md5($data['new_pwd']);
            } else {
                unset($data['pwd']);
            }
            unset($data['new_pwd']);
            unset($data['new_pwd_ok']);
            if (!AdminModel::edit($data, $adminInfo['id'])) return Json::fail('修改失败');
            return Json::successful('修改成功!,请重新登录');
        }
    }


    public function getpackage($package_ids = []){
        if(!$package_ids || in_array(0,$package_ids)){
            return Json::successful('成功',[]);
        }
        $admin = $this->adminInfo;
        if ($admin->channels != 0) {
            $chanel = Db::name('chanel')->where([['package_id','in',$package_ids],['level','in',1]])->whereIn('channel', $admin->channels)->column('channel,cname');
        }else{
            $chanel = Db::name('chanel')->where([['package_id','in',$package_ids],['level','in',1]])->column('channel,cname');
        }
        return Json::successful('成功',$chanel);
    }

    private function setCheckboxdata($data){
        $data['channels'] = [];
        $data['package_id'] = [];
        foreach ($data as $k => $v){
            if(substr($k,0,8) == 'channels' && $k != 'channels'){
                $data['channels'][] = $v;
                unset($data[$k]);
            }
            if(substr($k,0,11) == 'package_ids' && $k != 'package_ids'){
                $data['package_id'][] = $v;
                unset($data[$k]);
            }
        }

        if(count($data['channels']) > 0){
            $data['channels'] = implode(',',$data['channels']);
        }else{
            $data['channels'] = 0;
        }
        //如果选了全部包就直接为0
        if(count($data['package_id']) > 0 && in_array(0,$data['package_id'] )){
            $data['package_id'] = 0;
            $data['channels'] = 0;
        }elseif(count($data['package_id']) > 0){
            $data['package_id'] = implode(',',$data['package_id']);
        }else{
            $data['package_id'] = 0;
        }
        return $data;
    }
}
