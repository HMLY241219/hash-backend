<?php
/**
 * author:  songtao<375177628@qq.com>
 * Date: 2020/09/21
 */

namespace crmeb\basic;

use crmeb\services\AccessTokenServeService;

/**
 * Class BaseProduct
 * @package crmeb\basic
 */
abstract class BaseProduct extends BaseStorage
{

    /**
     * access_token
     * @var null
     */
    protected $accessToken = NULL;


    public function __construct(string $name, AccessTokenServeService $accessTokenServeService, string $configFile)
    {
        $this->accessToken = $accessTokenServeService;
    }

    /**
     * 初始化
     * @param array $config
     * @return mixed|void
     */
    protected function initialize(array $config = [])
    {
//        parent::initialize($config);
    }

    /**
     * 开通服务
     * @return mixed
     */
    abstract public function open();

    /**复制商品
     * @return mixed
     */
    abstract public function goods($url);
}
