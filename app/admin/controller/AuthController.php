<?php

namespace app\admin\controller;

use app\admin\model\system\{SystemAdmin, SystemMenus, SystemRole};
use think\facade\Session;

/**
 * 基类 所有控制器继承的类
 * Class AuthController
 * @package app\admin\controller
 */
class AuthController extends SystemBasic
{
    /**
     * 当前登陆管理员信息
     * @var
     */
    protected $adminInfo;

    /**
     * 当前登陆管理员ID
     * @var
     */
    protected $adminId;

    /**
     * 当前登陆管理员昵称
     * @var
     */
    protected $adminName;

    /**
     * 当前管理员权限
     * @var array
     */
    protected $auth = [];

    protected $skipped = ['index', 'common'];

    protected $sqlwhere = [];  //获取筛选包和渠道的sql语句这里是关联的时候需要得别名2维数组

    protected $sqlNewWhere = [];  //获取筛选包和渠道的sql语句这里是关联的时候需要得别名1维数组

    protected function initialize()
    {
        parent::initialize();

        $login_url = (string)url('auth/login');
        if (!SystemAdmin::hasActiveAdmin()) {
            return $this->redirect($login_url);
        }
        try {
            $adminInfo = SystemAdmin::activeAdminInfoOrFail();
        }
        catch (\Exception $e) {
            return $this->failed(SystemAdmin::getErrorInfo($e->getMessage()), $login_url);
        }
        $this->adminInfo = $adminInfo;
        $this->adminId   = $adminInfo['id'];
        $this->adminName = $adminInfo['real_name'] ?: $adminInfo['account'];
        $this->getActiveAdminInfo();
        $this->auth = SystemAdmin::activeAdminAuthOrFail();
        $this->adminInfo->level === 0 || $this->checkAuth();
        $this->assign('_admin', $this->adminInfo);
        $type = 'system';

        $package_id = Session::get('package_id');
        $chanel = Session::get('chanel');

        if($chanel){
            $this->sqlwhere = [['a.channel' ,'in', $chanel]];
            $this->sqlNewWhere = ['channel','in',$chanel];
        }elseif ($package_id){
            $this->sqlwhere = [['a.package_id' ,'in', $package_id]];
            $this->sqlNewWhere = ['package_id','in',$package_id];
        }



        //包渠道
//        if($adminInfo['level']!=0 && !empty($adminInfo['pkg_name'])){
//            $this->sqlwhere = [['a.pkg_name' ,'in', $adminInfo['pkg_name']]];
//            $this->sqlNewWhere = ['pkg_name','in',$adminInfo['pkg_name']];
//        }
//        if ($adminInfo['level']!=0 && !empty($adminInfo['channel'])){
//            $this->sqlwhere = [['a.channel' ,'in', $adminInfo['channel']]];
//            $this->sqlNewWhere = ['channel','in',$adminInfo['channel']];
//        }

        event('AdminVisit', [$this->adminInfo, $type]);
    }


    protected function checkAuth($action = null, $controller = null, $module = null, array $route = [])
    {
        static $allAuth = null;
        if ($allAuth === null) $allAuth = SystemRole::getAllAuth();
        if ($module === null) $module = app('http')->getName();
        if ($controller === null) $controller = $this->request->controller();
        if ($action === null) $action = $this->request->action();
        if (!count($route)) $route = $this->request->route();
        array_shift($route);
        if (in_array(strtolower($controller), $this->skipped, true)) return true;
        $nowAuthName     = SystemMenus::getAuthName($action, $controller, $module, $route);
        $baseNowAuthName = SystemMenus::getAuthName($action, $controller, $module, []);
        //积分设置的父类 不是系统设置  但是 $baseNowAuthName   确实验证得 系统设置权限
        if (
            (in_array($nowAuthName, $allAuth) && !in_array($nowAuthName, $this->auth)) ||
            (in_array($baseNowAuthName, $allAuth) &&
             ($nowAuthName != 'admin/setting.systemconfig/index/type/3/tab_id/11' && !in_array($baseNowAuthName, $this->auth))
            )
        ) exit($this->failed('Access denied!'));

        return true;
    }


    /**
     * 获得当前用户最新信息
     * @return SystemAdmin
     */
    protected function getActiveAdminInfo()
    {
        $adminId   = $this->adminId;
        $adminInfo = SystemAdmin::getValidAdminInfoOrFail($adminId);
        if (!$adminInfo) $this->failed(SystemAdmin::getErrorInfo('请登录后操作!'));
        $this->adminInfo = $adminInfo;
        SystemAdmin::setLoginInfo($adminInfo);
        return $adminInfo;
    }


    /**
     * @return array|mixed 获取筛选包和渠道的sql语句
     */
    protected function sqlWhere(){
        $sqlwhere = $this->sqlwhere;
        if(!$sqlwhere || count($sqlwhere) <= 0){
            return [];
        }
        foreach ($sqlwhere as &$v){
            $v[0] = str_replace('a.','',$v[0]);
        }
        return $sqlwhere;
    }
}