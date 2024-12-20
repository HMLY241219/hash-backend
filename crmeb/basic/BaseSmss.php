<?php
/**
 * author:  songtao<375177628@qq.com>
 * Date: 2020/09/21
 */

namespace crmeb\basic;

use crmeb\services\AccessTokenServeService;

/**
 * Class BaseSmss
 * @package crmeb\basic
 */
abstract class BaseSmss extends BaseStorage
{

    /**
     * access_token
     * @var null
     */
    protected $accessToken = NULL;


    public function __construct(string $name, AccessTokenServeService $accessTokenServeService, string $configFile)
    {
        $this->accessToken = $accessTokenServeService;
        $this->name = $name;
        $this->configFile = $configFile;
        $this->initialize();
    }

    /**
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

    /**
     * 修改
     * @return mixed
     */
    abstract public function modify($sign);

    /**
     * 信息
     * @return mixed
     */
    abstract public function info();

    /**
     * 发送短信
     * @return mixed
     */
    abstract public function send($phone, $templateId, $data);

    /**
     * 模版
     * @return mixed
     */
    abstract public function temps($page, $limit);

    /**
     * 申请模版
     * @return mixed
     */
    abstract public function apply($title, $content, $type);

    /**
     * 申请模版记录
     * @return mixed
     */
    abstract public function applys($temp_type, $page, $limit);

    /**
     * 发送记录
     * @return mixed
     */
    abstract public function record($record_id);
}
