<?php
/**
 *
 * @author: xaboy<365615158@qq.com>
 * @day: 2017/11/23
 */

namespace crmeb\services;

/**
 * curl 请求
 * Class HttpService
 * @package crmeb\services
 */
class HttpService
{
    /**
     * 错误信息
     * @var string
     */
    private static $curlError;

    /**
     * header头信息
     * @var string
     */
    private static $headerStr;

    /**
     * 请求状态
     * @var int
     */
    private static $status;

    /**
     * 获取请求错误信息
     * @return string
     */
    public static function getCurlError()
    {
        return self::$curlError;
    }

    /**
     * 获取请求响应状态
     * @return mixed
     */
    public static function getStatus()
    {
        return self::$status;
    }

    /**
     * 模拟GET发起请求
     * @param $url 请求地址
     * @param array $data 请求数据
     * @param bool $header header头
     * @param int $timeout 响应超时时间
     * @return bool|string
     */
    public static function getRequest($url, $data = array(), $header = false, $timeout = 10)
    {
        if (!empty($data)) {
            $url .= (stripos($url, '?') === false ? '?' : '&');
            $url .= (is_array($data) ? http_build_query($data) : $data);
        }

        return self::request($url, 'get', array(), $header, $timeout);
    }
    /**
     * CURL请求
     *
     * @param            $url        请求url地址
     * @param            $method     请求方法 get post
     * @param null       $postfields post数据数组
     * @param array      $headers 请求header信息
     * @param bool|false $debug 调试开启 默认false
     *
     * @return mixed
     */
    public static function httpRequest($url, $method, $postfields = null, $headers = [], $debug = false) {
        $method = strtoupper($method);
        $ci     = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
        curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        switch ($method) {
            case "POST":
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
                }
                break;
            default:
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
                break;
        }
        $ssl = preg_match('/^https:\/\//i', $url) ? true : false;
        curl_setopt($ci, CURLOPT_URL, $url);
        if ($ssl) {
            curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts
            curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false); // 不从证书中检查SSL加密算法是否存在
        }
        //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
        curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);
        /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
        $response    = curl_exec($ci);
        $requestinfo = curl_getinfo($ci);
        $http_code   = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        if ($debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);
            echo "=====info===== \r\n";
            print_r($requestinfo);
            echo "=====response=====\r\n";
            print_r($response);
        }
        curl_close($ci);

        return $response;
        //return array($http_code, $response,$requestinfo);
    }
    /**
     * curl 请求
     * @param $url 请求地址
     * @param string $method 请求方式
     * @param array $data 请求数据
     * @param bool $header 请求header头
     * @param int $timeout 超时秒数
     * @return bool|string
     */
    public static function request($url, $method = 'get', $data = array(), $header = false, $timeout = 15)
    {
        self::$status = null;
        self::$curlError = null;
        self::$headerStr = null;

        $curl = curl_init($url);
        $method = strtoupper($method);
        //请求方式
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        //post请求
        if ($method == 'POST') curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //超时时间
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        //设置header头
        if ($header !== false) curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        //返回抓取数据
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //输出header头信息
        curl_setopt($curl, CURLOPT_HEADER, true);
        //TRUE 时追踪句柄的请求字符串，从 PHP 5.1.3 开始可用。这个很关键，就是允许你查看请求header
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        //https请求
        if (1 == strpos("$" . $url, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        self::$curlError = curl_error($curl);

        list($content, $status) = [curl_exec($curl), curl_getinfo($curl), curl_close($curl)];
        self::$status = $status;
        self::$headerStr = trim(substr($content, 0, $status['header_size']));
        $content = trim(substr($content, $status['header_size']));
        return (intval($status["http_code"]) === 200) ? $content : false;
    }

    /**
     * 模拟POST发起请求
     * @param $url 请求链接
     * @param array $data 请求参数
     * @param bool $header header头
     * @param int $timeout 超时秒数
     * @return bool|string
     */
    public static function postRequest($url, array $data = array(), $header = false, $timeout = 10)
    {
        return self::request($url, 'post', $data, $header, $timeout);
    }

    /**
     * 获取header头字符串类型
     * @return mixed
     */
    public static function getHeaderStr(): string
    {
        return self::$headerStr;
    }

    /**
     * 获取header头数组类型
     * @return array
     */
    public static function getHeader(): array
    {
        $headArr = explode("\r\n", self::$headerStr);
        return $headArr;
    }

}