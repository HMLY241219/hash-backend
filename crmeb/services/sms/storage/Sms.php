<?php
/**
 * Created by PhpStorm
 * User: song
 * Date: 2020/9/28/0028
 * Time: 16:14
 */

namespace crmeb\services\sms\storage;

use crmeb\basic\BaseSmss;
use crmeb\services\AccessTokenServeService;
use think\exception\ValidateException;
use think\facade\Config;


/**
 * Class Copy
 * @package crmeb\services\product\storage
 */
class Sms extends BaseSmss
{

    /**
     * 开通
     */
    const SMS_OPEN = 'sms_v2/open';
    /**
     * 修改签名
     */
    const SMS_MODIFY = 'sms_v2/modify';
    /**
     * 用户信息
     */
    const SMS_INFO = 'sms_v2/info';
    /**
     * 发送短信
     */
    const SMS_SEND = 'sms_v2/send';
    /**
     * 短信模板
     */
    const SMS_TEMPS = 'sms_v2/temps';
    /**
     * 申请模板
     */
    const SMS_APPLY = 'sms_v2/apply';
    /**
     * 模板记录
     */
    const SMS_APPLYS = 'sms_v2/applys';
    /**
     * 发送记录
     */
    const SMS_RECORD = 'sms_v2/record';

    /**
     * 短信签名
     * @var string
     */
    protected $sign = '';
    /**
     * 模板id
     * @var array
     */
    protected $templateIds = [];

    public function __construct()
    {
        $this->accessToken = $this->getAccessToken();
        $this->templateIds = Config::get('sms.stores.sms.template_id', []);
    }

    protected function getAccessToken()
    {
        $this->account = sys_config('sms_account');
        $this->sercet = sys_config('sms_token');
        return new AccessTokenServeService($this->account, $this->sercet);
    }

    /** 初始化
     * @param array $config
     */
    protected function initialize(array $config = [])
    {
        parent::initialize($config);
    }

    /**
     * 提取模板code
     * @param string $templateId
     * @return null
     */
    protected function getTemplateCode(string $templateId)
    {
        return $this->templateIds[$templateId] ?? null;
    }

    /**
     * 设置签名
     * @param $sign
     * @return $this
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
        return $this;
    }

    /**
     * 开通服务
     * @return array|bool|mixed
     */
    public function open()
    {
        $param = [
            'sign' => $this->sign
        ];
        return $this->accessToken->httpRequest(self::SMS_OPEN, $param);
    }

    /**
     * 修改签名
     * @param $sign
     * @return array|bool|mixed
     */
    public function modify($sign)
    {
        $param = [
            'sign' => $sign
        ];
        return $this->accessToken->httpRequest(self::SMS_MODIFY, $param);
    }

    /**
     * 获取用户信息
     * @return array|bool|mixed
     */
    public function info()
    {
        return $this->accessToken->httpRequest(self::SMS_INFO, []);
    }

    /**
     * 短信模版
     * @param int $page
     * @param int $limit
     * @param $temp_type
     * @return array|bool|mixed
     */
    public function temps($page = 1, $limit = 10, $temp_type = '')
    {
        $param = [
            'page' => $page,
            'limit' => $limit,
            'temp_type' => $temp_type
        ];
        return $this->accessToken->httpRequest(self::SMS_TEMPS, $param);
    }

    /**
     * 申请模版
     * @param $title
     * @param $content
     * @param $type
     * @return array|bool|mixed
     */
    public function apply($title, $content, $type)
    {
        $param = [
            'title' => $title,
            'content' => $content,
            'type' => $type
        ];
        return $this->accessToken->httpRequest(self::SMS_APPLY, $param);
    }

    /**
     * 申请记录
     * @param $temp_type
     * @param int $page
     * @param int $limit
     * @return array|bool|mixed
     */
    public function applys($temp_type, $page, $limit)
    {
        $param = [
            'temp_type' => $temp_type,
            'page' => $page,
            'limit' => $limit
        ];
        return $this->accessToken->httpRequest(self::SMS_APPLYS, $param);
    }

    /**
     * 发送短信
     * @param $phone
     * @param $template
     * @param $param
     * @return bool|string
     */
    public function send($phone, $templateId, $data = [])
    {
        if (!$phone) {
            throw new ValidateException('手机号不能为空');
        }
        $param = [
            'phone' => $phone
        ];
        $param['temp_id'] = $this->getTemplateCode($templateId);
        if (is_null($param['temp_id'])) {
            throw new ValidateException('模版ID不存在');
        }
        $param['param'] = json_encode($data);
        return [
            'data' => $this->accessToken->httpRequest(self::SMS_SEND, $param)
        ];
    }

    /**
     * 发送记录
     * @param $record_id
     * @return array|bool|mixed
     */
    public function record($record_id)
    {
        $param = [
            'record_id' => $record_id
        ];
        return $this->accessToken->httpRequest(self::SMS_RECORD, $param);
    }
}
