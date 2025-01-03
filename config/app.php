<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

use think\facade\Env;

return [
    // 应用地址
    'app_host'         => Env::get('app.host', ''),
    // 应用的命名空间
    'app_namespace'    => '',
    // 是否启用路由
    'with_route'       => true,
    // 是否启用事件
    'with_event'       => true,
    // 自动多应用模式
    'auto_multi_app'   => true,
    // 应用映射（自动多应用模式有效）
    'app_map'          => ['web' => 'web','api'=>'api', 'admin'=>'admin'],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'      => [
        //Env::get('app.domain', 'brgame.site') => 'admin',
        //Env::get('app.apidomain', 'api.brgame.site') => 'api',
    ],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    //'deny_app_list'    => ['admin', 'common'],
//    'deny_app_list'    => [],
    // 默认应用
    //'default_app'      => 'web',
    'default_app'      => 'admin',
    // 默认时区
    'default_timezone' => Env::get('app.default_timezone', 'Asia/Shanghai'),
    // 异常页面的模板文件
    'exception_tmpl'   => Env::get('app_debug', false) ? app()->getThinkPath() . 'tpl/think_exception.tpl' : true,
    // 错误显示信息,非调试模式有效
    'error_message'    => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'   => false,
];
