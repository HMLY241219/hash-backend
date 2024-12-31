<?php
namespace app\admin\middleware;

class CheckDomain
{
    // 允许的域名列表
    protected $allowedDomains = [];

    public function handle($request, \Closure $next)
    {
        $allowedDomains = env('HOST.HOST_DOMAIN_ALLOWED', '127.0.0.1');
        $this->allowedDomains = explode(',', $allowedDomains);

        // 获取请求的域名
        $domain = $request->host();

        // 检查请求的域名是否在允许的列表中
        if (!in_array($domain, $this->allowedDomains)) {
            return response('Forbidden', 403);
        }

        // 如果请求的域名在允许的列表中，则继续处理请求
        return $next($request);
    }
}