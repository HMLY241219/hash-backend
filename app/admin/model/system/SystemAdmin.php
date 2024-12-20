<?php

namespace app\admin\model\system;

use crmeb\basic\BaseModel;
use crmeb\traits\ModelTrait;
use think\facade\Session;

class SystemAdmin extends BaseModel
{

    use ModelTrait;

    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    /**
     * 模型名称
     * @var string
     */
    protected $name = 'system_admin';

    protected $insert = ['add_time'];

    public function setAddTimeAttr($value)
    {
        return time();
    }

    public function setRolesAttr($value)
    {
        return is_array($value) ? implode(',', $value) : $value;
    }

    /**
     * 用户登陆
     * @param $account
     * @param $pwd
     * @return bool
     */
    public static function checkLogin($account, $pwd)
    {
        $adminInfo = self::get(compact('account'));
        if (!$adminInfo) return self::setErrorInfo('账号或密码错误!');
        if ($adminInfo['pwd'] != md5($pwd)) return self::setErrorInfo('账号或密码错误!');
        if (!$adminInfo['status']) return self::setErrorInfo('账号已被封禁!');
        self::setLoginInfo($adminInfo);
        event('SystemAdminLoginAfter', [$adminInfo]);
        return true;
    }

    /**
     *  保存当前登陆用户信息
     */
    public static function setLoginInfo($adminInfo)
    {
        Session::set('adminId', $adminInfo['id']);
        Session::set('adminInfo', $adminInfo->toArray());
        Session::save();
    }

    /**
     * 清空当前登陆用户信息
     */
    public static function clearLoginInfo()
    {
        Session::destroy();
        Session::save();
    }

    /**
     * 检查用户登陆状态
     * @return bool
     */
    public static function hasActiveAdmin()
    {
        return Session::has('adminId') && Session::has('adminInfo');
    }

    /**
     * 获得登陆用户信息
     * @throws \Exception
     * @return mixed
     */
    public static function activeAdminInfoOrFail()
    {
        $adminInfo = Session::get('adminInfo');
        if (!$adminInfo) exception('请登录后操作!');
        if (!$adminInfo['status']) exception('账号已被封禁!');
        return $adminInfo;
    }

    /**
     * @throws \Exception
     * @return array|null
     */
    public static function activeAdminAuthOrFail()
    {
        $adminInfo = self::activeAdminInfoOrFail();
        if (is_object($adminInfo)) $adminInfo = $adminInfo->toArray();
        return $adminInfo['level'] === 0 ? SystemRole::getAllAuth() : SystemRole::rolesByAuth($adminInfo['roles']);
    }

    /**
     * 获得有效管理员信息
     * @param $id
     * @throws \Exception
     * @return mixed
     */
    public static function getValidAdminInfoOrFail($id)
    {
        $adminInfo = self::get($id);
        if (!$adminInfo) exception('账号或密码错误!');
        if (!$adminInfo['status']) exception('账号已被封禁!');
        return $adminInfo;
    }

    /**
     * @param string $field
     * @param int    $level
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DbException
     * @return \think\Collection
     */
    public static function getOrdAdmin($field = 'real_name,id', $level = 0)
    {
        return self::where('level', '>=', $level)->field($field)->select();
    }

    public static function getTopAdmin($field = 'real_name,id')
    {
        return self::where('level', 0)->field($field)->select();
    }

    /**
     * @param $where
     * @return array
     */
    public static function systemPage($where)
    {
        $model = new self;
        if ($where['name'] != '') $model = $model->where('account|real_name', 'LIKE', "%$where[name]%");
        if ($where['roles'] != '') $model = $model->where("CONCAT(',',roles,',')  LIKE '%,$where[roles],%'");
        $model = $model->where('level', $where['level'])->where('is_del', 0);
        return self::page($model, function ($admin) {
            $admin->roles = SystemRole::where('id', 'IN', $admin->roles)->column('role_name', 'id');
        }, $where);
    }
}