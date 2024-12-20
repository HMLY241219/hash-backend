<?php

namespace app\admin\controller\setting;

use app\admin\controller\AuthController;
use app\admin\model\system\SystemMenus as MenusModel;
use crmeb\services\{FormBuilder as Form, UtilService as Util, JsonService as Json};
use think\facade\Route as Url;

class SystemMenus extends AuthController
{

    private $options = [
        ['value' => 1, 'label' => '显示 (菜单最多三级)'],
        ['value' => 0, 'label' => '隐藏'],
    ];

    private $menuList;

    protected function initialize()
    {
        $menuList = MenusModel::getMenuList('id,pid,menu_name');
        $list     = sort_list_tier($menuList, '顶级', 'pid', 'menu_name');
        $menus    = [['value' => 0, 'label' => '顶级菜单']];
        foreach ($list as $menu) {
            $menus[] = ['value' => $menu['id'], 'label' => $menu['html'] . ' ' . $menu['menu_name']];
        }

        $this->menuList = $menus;
    }

    public function index($pid = 0)
    {
        $params = Util::getMore([
            ['is_show', ''],
            ['keyword', ''],
            ['pid', $pid]
        ], $this->request);

        //$this->assign(MenusModel::getAdminPage($params));
        $list = MenusModel::getAdminPage($params, true)->toJson();
        $this->assign('list', $list);

        $addurl = Url::buildUrl('create', ['cid' => $pid]);
        $this->assign(compact('params', 'addurl'));

        return $this->fetch();
    }

    public function set_state($id, $name, $value)
    {
        if (MenusModel::update([$name => $value], ['id' => $id])) {
            return Json::success('操作成功');
        }
        else {
            return Json::fail('操作失败，稍后再试');
        }
    }

    public function create($cid = 0)
    {
        $field   = [];
        $field[] = Form::select('pid', '父级菜单', $cid)
            ->options($this->menuList)->filterable(true)->required();
        $field[] = Form::input('menu_name', '菜单名称')->required();
        $field[] = Form::select('module', '模块名', 'admin')->options([['label' => '总后台', 'value' => 'admin']])->required();
        if ($cid) $controller = MenusModel::getController($cid);
        else $controller = '';
        $field[] = Form::input('controller', '控制器名', $controller)->required();
        if (!empty($controller)) {
            $controller = preg_replace_callback('/([.]+([a-z]{1}))/i', function ($matches) {
                return '\\' . strtoupper($matches[2]);
            }, $controller);
            if (class_exists('\app\admin\controller\\' . $controller)) {
                $list = get_this_class_methods('\app\admin\controller\\' . $controller);

                $field[] = Form::select('action', '方法名')
                    ->setOptions(function () use ($list) {
                        $menus = [['value' => 0, 'label' => '默认函数']];
                        foreach ($list as $menu) {
                            $menus[] = ['value' => $menu, 'label' => $menu];
                        }
                        return $menus;
                    })->filterable(1);
            }
            else {
                $field[] = Form::input('action', '方法名');
            }
        }
        else {
            $field[] = Form::input('action', '方法名');
        }
        $field[] = Form::input('params', '参数')->placeholder('用‘/’分割，例如：a/123/b/234');
        //$field[] = Form::frameInputOne('icon', '图标', Url::buildUrl('admin/widget.widgets/icon', ['fodder' => 'icon']))->icon('ionic')->height('500px');
        $field[] = Form::input('icon', '图标', 'app');
        $field[] = Form::number('sort', '排序', 0);
        $field[] = Form::radio('is_show', '状态', 1)->options($this->options);

        $form = Form::make_post_form('添加菜单', $field, Url::buildUrl('save'), 3);
        $this->assign(compact('form'));

        return $this->fetch('public/form-builder');
    }

    public function save()
    {
        $data = Util::postMore([
            ['pid', 0],
            'menu_name',
            ['module', 'admin'],
            'controller',
            'action',
            'params',
            ['icon', 'app'],
            ['sort', 0],
            ['is_show', 0],
            ['access', 1]
        ]);

        MenusModel::create($data);
        return Json::successful('创建成功');
    }

    public function edit($id)
    {
        $menu = MenusModel::get($id);
        if (!$menu) return Json::fail('菜单不存在!');

        $field   = [];
        $field[] = Form::select('pid', '父级菜单', (string)$menu->getData('pid'))
            ->options($this->menuList)->filterable(true)->required();
        $field[] = Form::input('menu_name', '菜单名称', $menu['menu_name'])->required();
        $field[] = Form::select('module', '模块名', $menu['module'])->options([['label' => '总后台', 'value' => 'admin']])->required();
        $field[] = Form::input('controller', '控制器名', $menu['controller'])->required();
        if (!empty($menu['controller'])) {
            $controller = preg_replace_callback('/([.]+([a-z]{1}))/i', function ($matches) {
                return '\\' . strtoupper($matches[2]);
            }, $menu['controller']);
            if (class_exists('\app\admin\controller\\' . $controller)) {
                $list = get_this_class_methods('\app\admin\controller\\' . $controller);

                $field[] = Form::select('action', '方法名', (string)$menu['action'])
                    ->setOptions(function () use ($list) {
                        $menus = [['value' => 0, 'label' => '默认函数']];
                        foreach ($list as $menu) {
                            $menus[] = ['value' => $menu, 'label' => $menu];
                        }
                        return $menus;
                    })->filterable(1);
            }
            else {
                $field[] = Form::input('action', '方法名', $menu['action']);
            }
        }
        else {
            $field[] = Form::input('action', '方法名');
        }
        $field[] = Form::input('params', '参数', MenusModel::paramStr($menu['params']))->placeholder('用‘/’分割，例如：a/123/b/234');
        //$field[] = Form::frameInputOne('icon', '图标', Url::buildUrl('admin/widget.widgets/icon', ['fodder' => 'icon']), $menu['icon'])->icon('ionic')->height('500px');
        $field[] = Form::input('icon', '图标', $menu['icon']);
        $field[] = Form::number('sort', '排序', $menu['sort']);
        $field[] = Form::radio('is_show', '状态', $menu['is_show'])->options($this->options);

        $form = Form::make_post_form('修改菜单', $field, Url::buildUrl('update', ['id' => $id]), 3);
        $this->assign(compact('form'));

        return $this->fetch('public/form-builder');
    }

    public function update($id)
    {
        $data = Util::postMore([
            ['pid', 0],
            'menu_name',
            ['module', 'admin'],
            ['controller', '', 'htmlspecialchars'],
            'action',
            'params',
            ['icon', 'app'],
            ['sort', 0],
            ['is_show', 0],
            ['access', 1]
        ]);

        if (!MenusModel::get($id)) return Json::fail('修改的菜单不存在!');

        MenusModel::edit($data, $id);
        return Json::successful('修改成功');
    }

    public function delete($id)
    {
        if (MenusModel::delMenu($id)) {
            return Json::successful('删除成功');
        }
        else {
            return Json::fail(MenusModel::getErrorInfo('删除失败, 稍候再试!'));
        }

    }

}
