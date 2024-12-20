<?php

namespace crmeb\traits;

use think\facade\App;
use think\exception\HttpResponseException;
use think\Response;

trait HttpTrait
{
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
     * 构造方法
     * @access public
     * @param App $app 应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = app('request');
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param mixed  $msg    提示信息
     * @param array  $data   返回的数据
     * @param string $url    跳转的URL地址
     * @param array  $header 发送的Header信息
     */
    protected function success($msg = '', array $data = [], string $url = '', array $header = [])
    {
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        }
        elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : (string)$this->app->route->buildUrl($url);
        }

        if (is_array($msg)) {
            $data = $msg;
            $msg  = 'succeed';
        }
        elseif (empty($msg)) {
            $msg = 'succeed';
        }

        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url
        ];

        $type = $this->getResponseType();
        // 把跳转模板的渲染下沉，这样在 response_send 行为里通过getData()获得的数据是一致性的格式
        if ('html' == strtolower($type)) {
            $type     = 'view';
            $response = Response::create($this->app->config->get('app.exception_tmpl'), $type)->assign($result)->header($header);
        }
        else {
            return Response::create($result, $type)->header($header);
        }

        throw new HttpResponseException($response);
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed  $msg    提示信息
     * @param array  $data   返回的数据
     * @param string $url    跳转的URL地址
     * @param array  $header 发送的Header信息
     */
    protected function error($msg = '', array $data = [], string $url = '', array $header = [])
    {
        if (is_null($url)) {
            $url = $this->request->isAjax() ? '' : 'javascript:history.back(-1);';
        }
        elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : (string)$this->app->route->buildUrl($url);
        }

        if (is_array($msg)) {
            $data = $msg;
            $msg  = 'failed';
        }
        elseif (empty($msg)) {
            $msg = 'failed';
        }

        $result = [
            'code' => 1,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url
        ];

        $type = $this->getResponseType();
        if ('html' == strtolower($type)) {
            $type     = 'view';
            $response = Response::create($this->app->config->get('app.exception_tmpl'), $type)->assign($result)->header($header);
        }
        else {
            return Response::create($result, $type)->header($header);
        }

        throw new HttpResponseException($response);
    }

    /**
     * 返回封装后的API数据到客户端
     * @access protected
     * @param mixed  $msg    提示信息
     * @param array  $data   要返回的数据
     * @param int    $code   返回的code
     * @param string $type   返回数据格式
     * @param array  $header 发送的Header信息
     */
    protected function result($msg = '', array $data = [], int $code = 0, string $type = 'json', array $header = [])
    {
        if (is_array($msg)) {
            $data = $msg;
            $msg  = 'ok';
        }

        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'time' => time(),
        ];

        $type     = $type ?: $this->getResponseType();
        $response = Response::create($result, $type)->header($header);

        throw new HttpResponseException($response);
    }

    /**
     * URL重定向
     * @access protected
     * @param string $url  跳转的URL表达式
     * @param int    $code http code
     * @param mixed  $with 隐式传参
     */
    protected function redirect(string $url, int $code = 302, $with = [])
    {
        $response = Response::create($url, 'redirect', $code);

        $response->with($with);

        throw new HttpResponseException($response);
    }

    /**
     * 获取当前的response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType(): string
    {
        return $this->request->isJson() || $this->request->isAjax() ? 'json' : 'html';
    }


    /**
     * 获取POST请求的数据
     * @param mixed $params
     * @param bool  $index
     * @return array
     */
    protected function basePost($params = [], bool $index = false): array
    {
        $request = $this->request;

        if (empty($params)) {
            return $request->post();
        }

        $p = [];
        $i = 0;
        foreach ($params as $param) {
            if (!is_array($param)) {
                $p[$index ? $i++ : $param] = $request->post($param);
            }
            else {
                if (!isset($param[1])) $param[1] = null;
                if (!isset($param[2])) $param[2] = '';
                if (is_array($param[0])) {
                    $name    = is_array($param[1]) ? $param[0][0] . '/a' : $param[0][0] . '/' . $param[0][1];
                    $keyName = $param[0][0];
                }
                else {
                    $name    = is_array($param[1]) ? $param[0] . '/a' : $param[0];
                    $keyName = $param[0];
                }

                $p[$index ? $i++ : ($param[3] ?? $keyName)] = $request->post($name, $param[1], $param[2]);
            }
        }

        return $p;
    }

    /**
     * 获取GET请求的数据
     * @param mixed $params
     * @param bool  $index
     * @return array
     */
    protected function baseGet($params = [], bool $index = false): array
    {
        $request = $this->request;

        if (empty($params)) {
            return $request->get();
        }

        $p = [];
        $i = 0;
        foreach ($params as $param) {
            if (!is_array($param)) {
                $p[$index ? $i++ : $param] = $request->get($param);
            }
            else {
                if (!isset($param[1])) $param[1] = null;
                if (!isset($param[2])) $param[2] = '';
                if (is_array($param[0])) {
                    $name    = is_array($param[1]) ? $param[0][0] . '/a' : $param[0][0] . '/' . $param[0][1];
                    $keyName = $param[0][0];
                }
                else {
                    $name    = is_array($param[1]) ? $param[0] . '/a' : $param[0];
                    $keyName = $param[0];
                }

                $p[$index ? $i++ : ($param[3] ?? $keyName)] = $request->get($name, $param[1], $param[2]);
            }
        }

        return $p;
    }


}