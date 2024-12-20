<?php

namespace app\api\controller;


/**
 *  返回给客户端的类
 */
class ReturnJson
{




    /**
     *
     * 成功
     * @param $msg  错误信息
     * @param $data  返回数据
     * @param $type  1 = 加密返回, 2 = 不加密返回
     * @return void
     */
    public static function successFul($code = 200,$data ='',$type = 1){
        return $type == 1
            ? self::encryptionData(['code' => $code,'msg' => self::getMsg($code),'data' => $data])
            : json(['code' => $code,'msg' => self::getMsg($code),'data' => $data]);
    }


    /**
     * 失败
     * @param $code  错误码
     * @param $data  返回数据
     * @param $type  1 = 加密返回, 2 = 不加密返回
     * @return void
     */
    public static function failFul($code = 201,$data =[],$type = 1){
        $statusCode = substr($code,0,1) == '4' ? 204 : 200; //如果是明文返回,同时又是400状态，响应状态需要返回对应的状态码
        return $type == 1
            ? self::encryptionData(['code' => $code,'msg' => self::getMsg($code),'data' => $data])
            : json(['code' => $code,'msg' => self::getMsg($code),'data' => $data],$statusCode);
    }

    /**
     * @param $code int 错误码
     * @return void 获取错误信息
     */
    private static function getMsg(int $code){

        return config('lang.'.$code)[request()->lang] ?? config('lang.'.$code)['en'];
    }

    /**
     * 加密数据
     * @param $data 数据
     * @return void
     */
    private static function encryptionData($data){
        return base64_encode(self::rc4(json_encode($data)));
    }

    /**
     * rc4加密
     * @param $data  数据
     * @param $pwd  包名
     * @return string
     */
    private static function rc4($data,$pwd = '') {
        //不传包名直接获取请求头的包名
        $pwd = $pwd ?: request()->packname;

        $key[]       = "";
        $box[]       = "";
        $pwd_length  = strlen($pwd);
        $data_length = strlen($data);
        $cipher      = '';
        for ($i = 0; $i < 256; $i++) {
            $key[$i] = ord($pwd[$i % $pwd_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j       = ($j + $box[$i] + $key[$i]) % 256;
            $tmp     = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $data_length; $i++) {
            $a       = ($a + 1) % 256;
            $j       = ($j + $box[$a]) % 256;
            $tmp     = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $k = $box[(($box[$a] + $box[$j]) % 256)];
            $cipher .= chr(ord($data[$i]) ^ $k);
        }
        return $cipher;
    }
}
