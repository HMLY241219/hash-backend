<?php

namespace app\admin\common;

use app\api\controller\My;
use customlibrary\Common;
use think\facade\Db;
use think\facade\Log;

class RedisDeleteWith{

    /**
     * @param int $ipType 链接redis的地址:1=本地,2=游戏那边redis
     * @param int $port  端口
     * @param int $db 链接指定的redis库
     * @return \Redis
     * @throws \RedisException
     */
    public function __construct(int $ipType = 1,int $port = 6379,int $db = 2,string $password = '')
    {
        try {
            $redis = new \Redis();
            $redis->connect($ipType == 1 ? config('redis.my_ip') : config('redis.ip'),$port);
            if($db > 0)$redis->select($db);
            if($password)$redis->auth($password);
            return $redis;
        }catch (\RedisException $e){
            Log::error('Redis连接失败信息:'.$e->getMessage());
            return 0;
        }

    }



//    /**
//     * @param int $ipType 链接redis的地址:1=本地,2=游戏那边redis
//     * @param int $port  端口
//     * @param int $db 链接指定的redis库
//     * @return \Redis
//     * @throws \RedisException
//     */
//    public function initialize(int $ipType = 1,int $port = 6379,int $db = 2,string $password = '')
//    {
//        try {
//            $redis = new \Redis();
//            $redis->connect($ipType == 1 ? config('redis.my_ip') : config('redis.ip'),$port);
//            if($db > 0)$redis->select($db);
//            if($password)$redis->auth($password);
//            return $redis;
//        }catch (\RedisException $e){
//            Log::error('Redis连接失败信息:'.$e->getMessage());
//            return 0;
//        }
//
//    }


}

