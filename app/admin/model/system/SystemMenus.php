<?php

namespace app\admin\model\system;

use crmeb\basic\BaseModel;
use crmeb\traits\ModelTrait;
use think\facade\Route as Url;

/**
 * 菜单 model
 * Class SystemMenus
 * @package app\admin\model\system
 */
class SystemMenus extends BaseModel
{
    use ModelTrait;

    protected $pk = 'id';

    protected $name = 'system_menus';

    public static $isShowStatus = [1 => '显示', 0 => '不显示'];

    public static $accessStatus = [1 => '管理员可用', 0 => '管理员不可用'];

    public static function legalWhere($where = [])
    {
        $where['is_show'] = 1;
    }

    public function setParamsAttr($value)
    {
        $value  = $value ? explode('/', $value) : [];
        $params = array_chunk($value, 2);

        $data = [];
        foreach ($params as $param) {
            if (isset($param[0]) && isset($param[1])) $data[$param[0]] = $param[1];
        }

        return json_encode($data);
    }

    public function getParamsAttr($value)
    {
        return json_decode($value, true);
    }

    protected function setControllerAttr($value)
    {
        return lcfirst($value);
    }

    public function getPidAttr($value)
    {
        return $value ? (self::getValues($value, 'menu_name')) : '顶级';
    }

    public static function getMenuList($field = '*')
    {
        $query = self::field($field)->where('is_show', 1);
        return $query->order('sort DESC,id ASC')->select()->toArray();
    }

    public static function getController($cid)
    {
        return self::where('id', $cid)->value('controller', '');
    }

    public static function getParentMenu($field = '*', $filter = false)
    {
        $where = ['pid' => 0];
        $query = self::field($field);
        $query = $filter ? $query->where(self::legalWhere($where)) : $query->where($where);
        return $query->order('sort DESC')->select();
    }

    public static function menuList()
    {
        $menusList = self::where('is_show', '1')->where('access', '1')->order('sort DESC')->select();//->whereNotIn('id',[584,585])
        return self::tidyMenuTier(true, $menusList);
    }

    public static function ruleList()
    {
        $ruleList = self::order('sort DESC')->select();
        return self::tidyMenuTier(false, $ruleList);
    }

    public static function rolesByRuleList($rules)
    {
        $res      = SystemRole::where('id', 'IN', $rules)->field('GROUP_CONCAT(rules) as ids')->find();
        $ruleList = self::where('id', 'IN', $res['ids'])->whereOr('pid', 0)->order('sort DESC')->select();
        return self::tidyMenuTier(false, $ruleList);
    }

    /**
     * @param $action
     * @param $controller
     * @param $module
     * @param $route
     * @return string
     */
    public static function getAuthName($action, $controller, $module, $route)
    {
        return strtolower($module . '/' . $controller . '/' . $action . '/' . SystemMenus::paramStr($route));
    }

    /**
     * @param bool  $adminFilter
     * @param array $menusList
     * @param int   $pid
     * @param array $navList
     * @throws \Exception
     * @return array
     */
    public static function tidyMenuTier($adminFilter = false, $menusList = [], $pid = 0, $navList = [])
    {
        static $allAuth = null;
        static $adminAuth = null;
        if ($allAuth === null) $allAuth = $adminFilter == true ? SystemRole::getAllAuth() : [];//所有的菜单
        if ($adminAuth === null) $adminAuth = $adminFilter == true ? SystemAdmin::activeAdminAuthOrFail() : [];//当前登录用户的菜单
        foreach ($menusList as $k => $menu) {
            $menu = $menu->getData();
            if ($menu['pid'] == $pid) {
                unset($menusList[$k]);
                $params   = json_decode($menu['params'], true);//获取参数
                $authName = self::getAuthName($menu['action'], $menu['controller'], $menu['module'], $params);//按钮链接
                if ($pid != 0 && $adminFilter && in_array($authName, $allAuth) && (!in_array($authName, $adminAuth) || !array_key_exists($menu['id'], $adminAuth))) continue;
                $menu['child'] = self::tidyMenuTier($adminFilter, $menusList, $menu['id']);
                if ($pid != 0 && !count($menu['child']) && !$menu['controller'] && !$menu['action']) continue;
                $menu['url'] = !count($menu['child']) ? Url::buildUrl($menu['module'] . '/' . $menu['controller'] . '/' . $menu['action'], $params) : 'javascript:;';
                if ($pid == 0 && !count($menu['child'])) continue;
                $navList[] = $menu;
            }
        }
        return $navList;
    }

    /**
     * @param $id
     * @return bool
     */
    public static function delMenu($id)
    {
        if (self::where('pid', $id)->count()) {
            return self::setErrorInfo('请先删除子菜单!');
        }

        return self::del($id);
    }

    /**
     * @param $params
     * @return array
     */
    public static function getAdminPage($params, $return = false)
    {
        $model = new self;
        if ($params['is_show'] !== '') $model = $model->where('is_show', $params['is_show']);
        //if($params['access'] !== '') $model = $model->where('access',$params['access']);//子管理员是否可用
        if ($params['pid'] !== '' && !$params['keyword']) $model = $model->where('pid', $params['pid']);
        if ($params['keyword'] !== '') $model = $model->where('menu_name|id|pid', 'LIKE', "%$params[keyword]%");
        $model = $model->order('sort DESC,id ASC');
        return $return ? $model->select() : self::page($model, $params);
    }

    /**
     * @param $params
     * @return string
     */
    public static function paramStr($params)
    {
        if (!is_array($params)) $params = json_decode($params, true) ?: [];
        $p = [];
        foreach ($params as $key => $param) {
            $p[] = $key;
            $p[] = $param;
        }
        return implode('/', $p);
    }

    /**
     * @param       $action
     * @param       $controller
     * @param       $module
     * @param array $route
     * @return mixed
     */
    public static function getVisitName($action, $controller, $module, array $route = [])
    {
        $params = json_encode($route);
        return self::where('action', $action)
                   ->where('controller', lcfirst($controller))
                   ->where('module', lcfirst($module))
                   ->where('params', $params)
                   ->where("params = '$params' OR params = '[]'")
                   ->order('id DESC')
                   ->value('menu_name');
    }

}