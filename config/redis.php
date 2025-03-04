<?php


return [
    'ip' => env('REDIS.REDIS_HOST','127.0.0.1'),  //redis地址游戏那边/
    'my_ip' => env('REDIS.REDIS_MY_HOST','127.0.0.1'),  //redis地址我们本地/
    'domain' => env('HOST.HOST_DOMAIN'),  //后台域名
    'api' => env('HOST.HOST_API'),  //接口域名
    'port0' => 6379,
    'port1' => 6501,
    'port2' => 6502,
    'port5501' => 5501,
    'port5502' => 5502,
];

