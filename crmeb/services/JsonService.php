<?php
/**
 * @author: xaboy<365615158@qq.com>
 * @day   : 2017/10/24
 */

namespace crmeb\services;

class JsonService
{
    private static $SUCCESSFUL_DEFAULT_MSG = 'ok';

    private static $FAIL_DEFAULT_MSG = 'no';

    public static function result($code, $msg = '', $data = [], $count = 0)
    {
        exit(json_encode(compact('code', 'msg', 'data', 'count')));
    }

    public static function result2($code, $msg = '', $data = [], $count = 0, $param = [])
    {
        exit(json_encode(compact('code', 'msg', 'data', 'count', 'param')));
    }

    public static function successlayui($count = 0, $data = [], $msg = '')
    {
        if (is_array($count)) {
            if (isset($count['data'])) $data = $count['data'];
            if (isset($count['count'])) $count = $count['count'];
        }
        if (!is_string($msg)) {
            $data = $msg;
            $msg  = self::$SUCCESSFUL_DEFAULT_MSG;
        }
        return self::result(0, $msg, $data, $count);
    }

    public static function successlayui2($count = 0, $data = [], $msg = '',$param = [])
    {
        if (is_array($count)) {
            if (isset($count['data'])) $data = $count['data'];
            if (isset($count['count'])) $count = $count['count'];
        }
        if (!is_string($msg)) {
            $data = $msg;
            $msg  = self::$SUCCESSFUL_DEFAULT_MSG;
        }
        return self::result2(0, $msg, $data, $count,$param);
    }

    public static function successful($msg = 'ok', $data = [], $status = 200)
    {
        if (!is_string($msg)) {
            $data = $msg;
            $msg  = self::$SUCCESSFUL_DEFAULT_MSG;
        }
        return self::result($status, $msg, $data);
    }

    public static function status($status, $msg, $result = [])
    {
        $status = strtoupper($status);
        if (is_array($msg)) {
            $result = $msg;
            $msg    = self::$SUCCESSFUL_DEFAULT_MSG;
        }
        return self::result(200, $msg, compact('status', 'result'));
    }

    public static function fail($msg, $data = [], $code = 400)
    {
        if (is_array($msg)) {
            $data = $msg;
            $msg  = self::$FAIL_DEFAULT_MSG;
        }
        return self::result($code, $msg, $data);
    }

    public static function success($msg, $data = [])
    {
        if (is_array($msg)) {
            $data = $msg;
            $msg  = self::$SUCCESSFUL_DEFAULT_MSG;
        }
        return self::result(200, $msg, $data);
    }

}