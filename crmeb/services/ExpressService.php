<?php
/**
 *
 * @author: xaboy<365615158@qq.com>
 * @day: 2018/01/10
 */

namespace crmeb\services;


use crmeb\services\express\Express;

class ExpressService
{
    protected static $api = [
        'query' => 'https://wuliu.market.alicloudapi.com/kdi'
    ];

    protected static $express = [];

    /**
     * @param string $type
     * @return Express|mixed
     */
    public static function init($type = 'express')
    {
        if (isset(self::$express['express_' . $type])) {
            return self::$express['express_' . $type];
        }
        $config = [];
        $config['account'] = sys_config('sms_account', '');
        $config['secret'] = sys_config('sms_token', '');
        return self::$express['express_' . $type] = new Express($type, $config);
    }

    public static function expressList()
    {
        $key = md5('crmeb_plat_express_list');
        $express = CacheService::get($key);
        if (!$express) {
            $expressInit = self::init();
            try {
                $express = $expressInit->express(1, 1, 100);
                $express = $express['data'] ?? [];
                CacheService::set($key, $express, 86400);
            } catch (\Throwable $e) {
                $express = [];
            }
        }
        return $express;
    }

    public static function query($no, $com = '')
    {
        $expressInit = self::init();
        $express = self::expressList();
        $code = '';
        if ($express) {
            $express = array_combine(array_column($express, 'name'), $express);
            $code = $express[$com]['code'] ?? '';
        }
        try {
            if ($code) {
                $data = $expressInit->query($code, $no);
                $result['status'] = 0;
                $result['msg'] = 'ok';
                $result['result'] = [
                    'number' => $data['num'],
                    'type' => $data['com'],
                    'list' => $data['content']
                ];
            } else {
                $result = self::oldquery($no);
            }
        } catch (\Throwable $e) {
            $result = [];
        }
        return $result;
    }

    public static function oldquery($no, $type = '')
    {
        $appCode = sys_config('system_express_app_code');
        if (!$appCode) return false;
        $res = HttpService::getRequest(self::$api['query'], compact('no', 'type'), ['Authorization:APPCODE ' . $appCode]);
        $result = json_decode($res, true) ?: false;
        return $result;
    }

}