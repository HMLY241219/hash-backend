<?php

namespace app\api\controller;

use phpseclib3\Crypt\EC;
use think\facade\Db;

/**
 * 分日期数据表处理
 * Class PublicController
 * @package app\api\controller
 */
class Sql
{

    /**
     *m 每日登录数据表
     * @return void
     */
    public static function getLoginTable($date = ''){
        $table = 'br_login_' . ($date ?: date('Ymd'));
        $res = Db::query("SHOW TABLES LIKE '$table'");
        if(!$res){
            $sql = "CREATE TABLE `$table` (
                      `uid` bigint(20) NOT NULL,
                      `channel` int(11) DEFAULT '0',
                      `package_id` int(11) DEFAULT '0' COMMENT '包id',
                      `createtime` int(11) DEFAULT NULL COMMENT '最近登录时间',
                      PRIMARY KEY (`uid`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户每日登录数据表'";
            Db::connect('sqlCreate')->query($sql);
        }

    }



    /**
     *m 每日登录数据表
     * @return void
     */
    public static function getRegistTable($date = ''){
        $table = 'br_regist_' . ($date ?: date('Ymd'));
        $res = Db::query("SHOW TABLES LIKE '$table'");
        if(!$res){
            $sql = "CREATE TABLE `$table` (
                      `uid` bigint(20) NOT NULL,
                      `channel` int(11) DEFAULT '0',
                      `package_id` int(11) DEFAULT '0' COMMENT '包id',
                      `createtime` int(11) DEFAULT NULL COMMENT '注册时间',
                      PRIMARY KEY (`uid`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户注册表'";
            Db::connect('sqlCreate')->query($sql);
        }

    }


    /**
     *m 用户余额变化表
     * @return void
     */
    public static function getCoinTable($date = ''){
        $table = 'br_coin_' . ($date ?: date('Ymd'));
        $res = Db::query("SHOW TABLES LIKE '$table'");
        if(!$res){
            $sql = "CREATE TABLE `$table` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `uid` bigint(15) NOT NULL,
                      `num` bigint(15) DEFAULT '0' COMMENT '操作数',
                      `total` bigint(20) DEFAULT '0' COMMENT '操作结果',
                      `reason` int(11) DEFAULT '0' COMMENT '操作原因',
                      `type` int(2) DEFAULT '1' COMMENT '类型:1发放/0回收',
                      `content` varchar(255) DEFAULT NULL COMMENT '备注',
                      `channel` int(11) DEFAULT '0',
                      `package_id` int(11) DEFAULT '0' COMMENT '包id',
                      `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
                      PRIMARY KEY (`id`),
                      KEY `uid` (`uid`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='用户余额变化表'";
            Db::connect('sqlCreate')->query($sql);
        }

    }

    /**
     * 用户bonus变化表
     * @return void
     */
    public static function getBonusTable($date = ''){
        $table = 'br_bonus_' . ($date ?: date('Ymd'));
        $res = Db::query("SHOW TABLES LIKE '$table'");
        if(!$res){
            $sql = "CREATE TABLE `$table` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `uid` bigint(15) NOT NULL,
                      `num` bigint(15) DEFAULT '0' COMMENT '操作数',
                      `total` bigint(20) DEFAULT '0' COMMENT '操作结果',
                      `reason` int(11) DEFAULT '0' COMMENT '操作原因',
                      `type` int(2) DEFAULT '1' COMMENT '类型:1发放/0回收',
                      `content` varchar(255) DEFAULT NULL COMMENT '备注',
                      `channel` int(11) DEFAULT '0',
                      `package_id` int(11) DEFAULT '0' COMMENT '包id',
                      `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
                      PRIMARY KEY (`id`),
                      KEY `uid` (`uid`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='用户余额变化表'";
            Db::connect('sqlCreate')->query($sql);
        }

    }


    /**
     *m 用户每日数据表
     * @return void
     */
    public static function getUserDayTable($date = ''){
        $table = 'br_user_day_' . ($date ?: date('Ymd'));
        $res = Db::query("SHOW TABLES LIKE '$table'");
        if(!$res){
            $sql = "CREATE TABLE `$table` (
                      `uid` bigint(20) NOT NULL COMMENT '用户id',
                      `puid` bigint(20) DEFAULT '0' COMMENT '上级用户ID',
                      `vip` int(11) DEFAULT '0' COMMENT 'vip',
                      `channel` int(11) DEFAULT '0' COMMENT '渠道号',
                      `package_id` int(11) DEFAULT '0' COMMENT '包id',
                      `cash_total_score` bigint(20) DEFAULT '0' COMMENT 'Cash总输赢',
                      `bonus_total_score` bigint(20) DEFAULT '0' COMMENT 'Bonus总输赢',
                      `total_cash_water_score` bigint(20) DEFAULT '0' COMMENT 'Cash游戏流水',
                      `total_bonus_water_score` bigint(20) DEFAULT '0' COMMENT 'Bonus游戏流水',      
                      `total_game_num` bigint(20) DEFAULT '0' COMMENT '总游戏次数',                   
                      `total_pay_score` bigint(20) DEFAULT '0' COMMENT '总充值金额',
                      `total_give_score` bigint(20) DEFAULT '0' COMMENT '总赠送',
                      `total_pay_num` bigint(20) DEFAULT '0' COMMENT '总充值次数',
                      `total_exchange` bigint(20) DEFAULT '0' COMMENT '总提现金额',
                      `total_exchange_num` bigint(20) DEFAULT '0' COMMENT '总提现次数',
                      `updatetime` bigint(20) DEFAULT '0' COMMENT '更新时间',
                      PRIMARY KEY (`uid`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户余额变化表'";
            Db::connect('sqlCreate')->query($sql);
        }

    }


    /**
     * 获取三方游戏记录数据表
     * @return void
     */
    public static function getSlotsLogTable($date = ''){

        $date = $date ?: date('Ymd');
        $table = 'br_slots_log_'. $date;
        $res = Db::query("SHOW TABLES LIKE '$table'");
        // if($res) Db::connect('sqlCreate')->query("DROP TABLE $table");
        if(!$res){
            $sql = "CREATE TABLE `$table` (
                 `betId` varchar(64) NOT NULL  COMMENT '第三方唯一标识',
                 `parentBetId` varchar(64) DEFAULT NULL COMMENT '上级的betId',
                 `uid` int(15) NOT NULL COMMENT '用户UID',
                 `puid` int(15) DEFAULT '0' COMMENT '上级用户UID',
                 `terrace_name` varchar(25) DEFAULT NULL COMMENT '游戏厂商',
                 `slotsgameid` varchar(64) NOT NULL COMMENT '第三方游戏id',
                 `game_id` int(15) NOT NULL DEFAULT 0 COMMENT '平台三方游戏id',
                 `englishname` varchar(255) DEFAULT NULL COMMENT '第三方游戏英文名称',
                 `cashBetAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Cash玩家投注额',
                 `bonusBetAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Bonus玩家投注额',
                 `cashWinAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Cash结算金额',
                 `bonusWinAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Bonus结算金额',
                 `cashTransferAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Cash输赢金额',
                 `bonusTransferAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Bonus输赢金额',
                 `cashRefundAmount` int(15) NOT NULL DEFAULT 0 COMMENT '退还Cash金额当is_settlement为2时退还',
                 `bonusRefundAmount` int(15) NOT NULL DEFAULT 0 COMMENT '退还Bonus金额当is_settlement为2时退还',
                 `transaction_id` varchar(255) NOT NULL COMMENT '三方唯一标识',
                 `betTime` int(11) DEFAULT NULL COMMENT '投注开始时间',
                 `package_id` int(15) NOT NULL DEFAULT 0 COMMENT '包名id',
                 `channel` int(15) NOT NULL DEFAULT 0 COMMENT '渠道',
                 `betEndTime` int(11) DEFAULT NULL COMMENT '投注结束时间',
                 `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
                 `is_consume` int(2) NOT NULL DEFAULT 0 COMMENT '是否消费了:1=是,0=否',
                 `is_sports` int(2) NOT NULL DEFAULT 0 COMMENT '是否体育订单:1=是,0=否',
                 `is_settlement` int(2) NOT NULL DEFAULT 1  COMMENT'是否结算:1=已完成,0=未结算,2=已退还,3=赢的钱已结算(PP需要这个字段，下注,结果和结算是2个不同接口),4=以回滚(订单变为进行中)',
                 `really_betAmount` int(15) NOT NULL DEFAULT 0 COMMENT '(sbs)体育实际下注金额',
                 `other` varchar(520) DEFAULT NULL COMMENT '其它字段(有些三方需要的额外字段，这里可以使用)',
                 `other2` varchar(520) DEFAULT NULL COMMENT '其它字段(有些三方需要的额外字段，这里可以使用)',
                 `other3` varchar(520) DEFAULT NULL COMMENT '其它字段(有些三方需要的额外字段，这里可以使用)',
                 `id` int(11) NOT NULL AUTO_INCREMENT  COMMENT 'ID',
                 PRIMARY KEY (`id`),
                 CONSTRAINT `unique_betId` UNIQUE (`betId`),
                 KEY `game_id` (`game_id`),
                 KEY `transaction_id` (`transaction_id`),
                 KEY `uid` (`uid`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='三方slots游戏历史记录'";
            Db::connect('sqlCreate')->query($sql);

        }



    }




//    /**
//     * 获取三方游戏记录数据表
//     * @return void
//     */
//    public static function getSlotsLogTable($date = ''){
//        for ($i = 0; $i <= 9; $i ++){
//            $date = $date ?: date('Ymd');
//            $table = 'br_slots_log_'. $date.'_'.$i;
//            $res = Db::query("SHOW TABLES LIKE '$table'");
//            // if($res) Db::connect('sqlCreate')->query("DROP TABLE $table");
//            if(!$res){
//                $sql = "CREATE TABLE `$table` (
//                     `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
//                     `betId` varchar(64) NOT NULL  COMMENT '第三方唯一标识',
//                     `parentBetId` varchar(64) DEFAULT NULL COMMENT '上级的betId',
//                     `uid` int(15) NOT NULL COMMENT '用户UID',
//                     `puid` int(15) DEFAULT '0' COMMENT '上级用户UID',
//                     `terrace_name` varchar(25) DEFAULT NULL COMMENT '游戏厂商',
//                     `slotsgameid` varchar(64) NOT NULL COMMENT '第三方游戏id',
//                     `game_id` int(15) NOT NULL DEFAULT 0 COMMENT '平台三方游戏id',
//                     `englishname` varchar(255) DEFAULT NULL COMMENT '第三方游戏英文名称',
//                     `cashBetAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Cash玩家投注额',
//                     `bonusBetAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Bonus玩家投注额',
//                     `cashWinAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Cash结算金额',
//                     `bonusWinAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Bonus结算金额',
//                     `cashTransferAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Cash输赢金额',
//                     `bonusTransferAmount` int(15) NOT NULL DEFAULT 0 COMMENT 'Bonus输赢金额',
//                     `cashRefundAmount` int(15) NOT NULL DEFAULT 0 COMMENT '退还Cash金额当is_settlement为2时退还',
//                     `bonusRefundAmount` int(15) NOT NULL DEFAULT 0 COMMENT '退还Bonus金额当is_settlement为2时退还',
//                     `transaction_id` varchar(255) NOT NULL COMMENT '三方唯一标识',
//                     `betTime` int(11) DEFAULT NULL COMMENT '投注开始时间',
//                     `package_id` int(15) NOT NULL DEFAULT 0 COMMENT '包名id',
//                     `channel` int(15) NOT NULL DEFAULT 0 COMMENT '渠道',
//                     `betEndTime` int(11) DEFAULT NULL COMMENT '投注结束时间',
//                     `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
//                     `is_consume` int(2) NOT NULL DEFAULT 0 COMMENT '是否消费了:1=是,0=否',
//                     `is_sports` int(2) NOT NULL DEFAULT 0 COMMENT '是否体育订单:1=是,0=否',
//                     `is_settlement` int(2) NOT NULL DEFAULT 1  COMMENT'是否结算:1=已完成,0=未结算,2=已退还,3=赢的钱已结算(PP需要这个字段，下注,结果和结算是2个不同接口),4=以回滚(订单变为进行中)',
//                     `really_betAmount` int(15) NOT NULL DEFAULT 0 COMMENT '(sbs)体育实际下注金额',
//                     `other` varchar(520) DEFAULT NULL COMMENT '其它字段(有些三方需要的额外字段，这里可以使用)',
//                     `other2` varchar(520) DEFAULT NULL COMMENT '其它字段(有些三方需要的额外字段，这里可以使用)',
//                     `other3` varchar(520) DEFAULT NULL COMMENT '其它字段(有些三方需要的额外字段，这里可以使用)',
//                     PRIMARY KEY (`id`),
//                     KEY `betId` (`betId`),
//                     KEY `parentBetId` (`parentBetId`),
//                     KEY `game_id` (`game_id`),
//                     KEY `transaction_id` (`transaction_id`),
//                     KEY `uid` (`uid`)
//                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='三方slots游戏历史记录'";
//                Db::connect('sqlCreate')->query($sql);
//
//            }
//        }
//
//
//    }
}
