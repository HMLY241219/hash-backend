<?php
/**
 *
 * @author: xaboy<365615158@qq.com>
 * @day: 2017/11/02
 */
namespace basic;

use Redis;
use think\Config;
use think\Db;
use think\Model;

class ModelBasic extends Model
{
    private static $errorMsg;

    private static $transaction = 0;

    private static $DbInstance = [];

    const DEFAULT_ERROR_MSG = '操作失败,请稍候再试!';

    protected static function getDb($name,$update = false)
    {
        if(isset(self::$DbInstance[$name]) && $update == false)
            return self::$DbInstance[$name];
        else
            return self::$DbInstance[$name] = Db::name($name);
    }

    /**
     * 设置错误信息
     * @param string $errorMsg
     * @return bool
     */
    protected static function setErrorInfo($errorMsg = self::DEFAULT_ERROR_MSG,$rollback = false)
    {
        if($rollback) self::rollbackTrans();
        self::$errorMsg = $errorMsg;
        return false;
    }

    /**
     * 获取错误信息
     * @param string $defaultMsg
     * @return string
     */
    public static function getErrorInfo($defaultMsg = self::DEFAULT_ERROR_MSG)
    {
        return !empty(self::$errorMsg) ? self::$errorMsg : $defaultMsg;
    }

    /**
     * 开启事务
     */
    public static function beginTrans()
    {
        Db::startTrans();
    }

    /**
     * 提交事务
     */
    public static function commitTrans()
    {
        Db::commit();
    }

    /**
     * 关闭事务
     */
    public static function rollbackTrans()
    {
        Db::rollback();
    }

    /**
     * 根据结果提交滚回事务
     * @param $res
     */
    public static function checkTrans($res)
    {
        if($res){
            self::commitTrans();
        }else{
            self::rollbackTrans();
        }
    }

    //创建redis连接
    public static function createuserredis($port)
    {
        //连接本地的 Redis 服务
        $redis = new Redis();
        $redis->connect( Config::get('iphost'),$port);
        return $redis;
    }
    public static function secToTime($times){
        $result = '00:00:00';
        if ($times>0) {
            $hour = floor($times/3600);
            $minute = floor(($times-3600 * $hour)/60);
            $second = floor((($times-3600 * $hour) - 60 * $minute) % 60);
            $result = $hour.':'.$minute.':'.$second;
        }
        return $result;
    }

}