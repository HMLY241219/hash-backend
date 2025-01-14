<?php

namespace app\admin\common;

use think\facade\Log;

class RedisDeleteWith{

    private $redis;

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
            $this->redis = new \Redis();
            $this->redis->connect($ipType == 1 ? config('redis.my_ip') : config('redis.ip'),$port);
            if($db > 0)$this->redis->select($db);
            if($password)$this->redis->auth($password);
        }catch (\RedisException $e){
            Log::error('Redis连接失败信息:'.$e->getMessage());
            $this->redis = null;
            throw new \RuntimeException('Redis 连接失败，请检查配置和网络状态：' . $e->getMessage());
        }

    }

    /**
     * 获取redis实例
     * @return mixed
     */
    public function getRedis()
    {
        return $this->redis;
    }
}

