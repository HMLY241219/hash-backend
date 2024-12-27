<?php


return [
    'ip' => env('REDIS.REDIS_HOST','127.0.0.1'),  //redis地址 124.221.1.74/
    'domain' => env('HOST.HOST_DOMAIN'),  //后台域名
    'api' => env('HOST.HOST_API'),  //接口域名
    'port0' => 6379,
    'port1' => 6501,
    'port2' => 6502,
    'port5501' => 5501,
    'port5502' => 5502,
];

