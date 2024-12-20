<?php
/**
 * Created by PhpStorm
 * User: song
 * Date: 2020/9/28/0028
 * Time: 16:14
 */

namespace crmeb\services\product;

use crmeb\basic\BaseManager;
use crmeb\services\AccessTokenServeService;
use think\facade\Config;
use think\Container;


/**
 * Class Product
 * @package crmeb\services\product
 * @mixin \crmeb\services\product\storage\Copy
 */
class Product extends BaseManager
{
    /**
     * 空间名
     * @var string
     */
    protected $namespace = '\\crmeb\\services\\product\\storage\\';

    /**
     * 默认驱动
     * @return mixed
     */
    protected function getDefaultDriver()
    {
        return Config::get('product.default', 'copy');
    }

    /**
     * 获取类的实例
     * @param $class
     * @return mixed|void
     */
    protected function invokeClass($class)
    {
        if (!class_exists($class)) {
            throw new \RuntimeException('class not exists: ' . $class);
        }
        $this->getConfigFile();

        if (!$this->config) {
            $this->config = Config::get($this->configFile . '.stores.' . $this->name, []);
        }
        $handleAccessToken = new AccessTokenServeService($this->config['account'] ?? '', $this->config['secret'] ?? '');
        $handle = Container::getInstance()->invokeClass($class, [$this->name, $handleAccessToken, $this->configFile]);
        $this->config = [];
        return $handle;
    }

}
