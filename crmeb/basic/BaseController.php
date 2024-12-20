<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace crmeb\basic;

use think\facade\{App, View, Validate};
use think\exception\{HttpResponseException, ValidateException};
use crmeb\traits\HttpTrait;
use service\EncryptionService;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    use HttpTrait;

    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    private static $securityKey16 = 'Sjese(eE%68sLOap';

    private static $iv = '1234567890123456';

    protected $param = [];

    /**
     * 构造方法
     * @access public
     * @param App $app 应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = app('request');

        /*$redata = $this->request->param('data');
        $en = new EncryptionService(self::$securityKey16,'AES-128-ECB',self::$iv);

        $this->param = $en->decrypt($redata);*/

        $redata = $this->request->param('param');

        if (!empty($redata)) {
            $this->param = json_decode(base64_decode(str_replace(' ', '+', input('param'))), true);
        }

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize() {}

    /**
     * 验证数据
     * @access protected
     * @param array $data 数据
     * @param string|array $validate 验证器名或者验证规则数组
     * @param array $message 提示信息
     * @param bool $batch 是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

    /**
     * 模板赋值
     * @param mixed ...$vars
     */
    protected function assign(...$vars)
    {
        View::assign(...$vars);
    }

    /**
     * 解析和获取模板内容
     * @param string $template
     */
    protected function fetch(string $template = '')
    {
        return View::fetch($template);
    }

    /**
     * 重定向
     * @param mixed ...$args
     */
    protected function redirect(...$args)
    {
        throw new HttpResponseException(redirect(...$args));
    }

    /**
     * 空方法
     * @param $method
     * @param $args
     */
    public function __call($method, $args)
    {
        return \think\Response::create()->code(404);
    }

}